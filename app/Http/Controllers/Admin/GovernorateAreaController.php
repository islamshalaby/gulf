<?php
namespace App\Http\Controllers\Admin;

use App\Country;
use App\DeliveryArea;
use App\Governorate;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\GovernorateAreas;

class GovernorateAreaController extends AdminController{
    // get all areas
    public function show(){
        $data['areas'] = GovernorateAreas::where('deleted', 0)->orderBy('id' , 'desc')->get();

        return view('admin.governorate_areas' , ['data' => $data]);
    }

    // add get
    public function addGet() {
        $data['countries'] = Country::where('deleted', 0)->orderBy('id' , 'desc')->get();

        return view('admin.governorate_area_form', compact('data'));
    }

    // fetch governorates by country
    public function fetchGovernoratesByCountry(Country $country) {
        $governorates = $country->governorates;
        $data = json_decode(($governorates));

        return response($data, 200);
    }

    // add post
    public function AddPost(Request $request){
        $post = $request->validate([
            'name_en' => "required",
            'name_ar' => "required",
            "governorate_id" => "required",
            'city_code' => ''
        ]);

        GovernorateAreas::create($post);

        return redirect()->route('governorates.areas.index')
        ->with('success', __('messages.created_successfully'));
    }

    // get edit page
    public function EditGet(GovernorateAreas $area){
        $data['area'] = $area;
        $data['countries'] = Country::where('deleted', 0)->orderBy('id' , 'desc')->get();
        $data['governorates'] = Governorate::where('deleted', 0)->orderBy('id' , 'desc')->get();

        return view('admin.governorate_area_edit' , ['data' => $data ]);
    }

    // edit area
    public function EditPost(Request $request, GovernorateAreas $area){
        $post = $request->validate([
            'name_en' => "required",
            'name_ar' => "required",
            "governorate_id" => "required",
            'city_code' => ''
        ]);

        $area->update($post);

        return redirect()->route('governorates.areas.index')
        ->with('success', __('messages.updated_successfully'));
    }

    // delete
    public function delete(GovernorateAreas $area) {
        $area->update(['deleted' => 1]);

        return redirect()->back()->with('success', __('messages.deleted_s'));
    }

    // details
    public function details(GovernorateAreas $area) {
        $data['area'] = $area;

        return view('admin.governorate_area_details', ['data' => $data]);
    }

    // update area delivery cost
    public function updateAreaDeliveryCost(Request $request) {
        $post = $request->validate([
            'governorate_area_id' => 'required',
            'delivery_cost' => 'required'
        ]);

        $area = DeliveryArea::where('governorate_area_id', $post['governorate_area_id'])->first();
        $deliveryCost = $post['delivery_cost'];
        $post['delivery_cost'] = number_format((float)$deliveryCost, 3, '.', '');

        if ($area) {
            $area->update($post);
        }else {
            DeliveryArea::create($post);
        }

        return redirect()->route('governorates.areas.deliveryCosts')->with('success', __('messages.delivery_cost_added'));
    }

    // get delivery cost
    public function getDeliveryCost() {
        $data['costs'] = DeliveryArea::orderBy('id', 'desc')->get();

        return view('admin.delivery_costs', compact('data'));
    }
}