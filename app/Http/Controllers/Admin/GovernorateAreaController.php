<?php
namespace App\Http\Controllers\Admin;

use App\Country;
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

        return view('admin.governorate_area_form', $data);
    }

    // fetch governorates by country
    public function fetchGovernoratesByCountry(Country $country) {
        $governorates = $country->governorates;
        $data = json_decode(($governorates));

        return response($data, 200);
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
}