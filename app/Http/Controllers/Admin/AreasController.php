<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Area;
use App\Company;
use App\Governorate;
use App\GovernorateAreas;
use App\DeliveryArea;

class AreasController extends AdminController{
    // get all areas
    public function show(){
        $data['areas'] = Area::where('deleted', 0)->orderBy('id' , 'desc')->get();
        return view('admin.areas' , ['data' => $data]);
    }

    // add get
    public function addGet() {
        return view('admin.area_form');
    }

    // add post
    public function AddPost(Request $request){
        Area::create($request->all());
        return redirect()->route('areas.index');
    }

    // get edit page
    public function EditGet(Area $area){
        $data['area'] = $area;
        return view('admin.area_edit' , ['data' => $data ]);
    }

    // edit area
    public function EditPost(Request $request, Area $area){
        $area->update($request->all());

        return redirect()->route('areas.index');
    }

    // delete
    public function delete(Area $area) {
        $area->update(['deleted' => 1]);

        return redirect()->back();
    }

    // details
    public function details(Area $area) {
        $data['area'] = $area;

        return view('admin.area_details', ['data' => $data]);
    }

    // get delivery costs by area
    public function deliver_cost_areas() { // country_id = 4 => kuwait
        $governorates = Governorate::where('country_id', 4)->pluck('id')->toArray();
        $data['areas'] = GovernorateAreas::where('deleted', 0)->whereIn('governorate_id', $governorates)->orderBy('name_ar' , 'asc')->get();

        return view('admin.deliver_cost_areas', compact('data'));
    }

    // get add delivery by area
    public function getAddDeliveryByArea($area) {
        $data['stores'] = Company::where('deleted', 0)->orderBy('id', 'desc')->get();
        $data['area_id'] = $area;
        $data['area'] = GovernorateAreas::where('id', $area)->first();

        return view('admin.deliver_cost_areas_form', compact('data'));
    }

    // post add delivery costs
    public function add_deliver_cost_post(Request $request) {
        $post = $request->validate([
            "delivery_cost" => 'required',
            "area_id" => "required",
            "store_id" => "required"
        ]);
        $deliveryArea = DeliveryArea::where('area_id', $request->area_id)->where('store_id', $request->store_id)->first();
        if ($deliveryArea) {
            $deliveryArea->update($post);
        }else {
            DeliveryArea::create($post);
        }

        return redirect()->back()->with('success', __('messages.added_successfully'));
    }

    // get add delivery costs by governorate
    public function addDeliveryCostByGovernorate() { // country_id = 4 => kuwait
        $data['governorates'] = Governorate::where('deleted', 0)->where('country_id', 4)->orderBy('id', 'desc')->get();

        return view('admin.deliver_cost_governorates', compact('data'));
    }

    // get add delivery by governorate
    public function getAddDeliveryByGovernorate($governorate) {
        $data['stores'] = Company::where('deleted', 0)->orderBy('id', 'desc')->get();
        $areas = GovernorateAreas::where('deleted', 0)->where('governorate_id', $governorate)->pluck('id')->toArray();
        $data['governorate_id'] = $governorate;
        $data['governorate'] = Governorate::where('id', $governorate)->first();

        return view('admin.deliver_cost_governorates_form', compact('data'));
    }

    // post add delivery costs by governorate
    public function add_deliver_cost_post_by_governorate(Request $request) {
        $post = $request->validate([
            "delivery_cost" => 'required',
            "store_id" => "required",
            "governorate_id" => "required"
        ]);
        $areas = GovernorateAreas::where('deleted', 0)->where('governorate_id', $post['governorate_id'])->pluck('id')->toArray();
        $store = Company::where('id', $post['store_id'])->first();
        $store->areas()->delete();
        
        for ($i = 0; $i < count($areas); $i ++) {
            $post['area_id'] = $areas[$i];

            DeliveryArea::create($post);
        }

        return redirect()->back()->with('success', __('messages.added_successfully'));
    }
}