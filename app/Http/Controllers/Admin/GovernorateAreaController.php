<?php
namespace App\Http\Controllers\Admin;

use App\Country;
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
        GovernorateAreas::create($request->all());

        return redirect()->route('governorates.areas.index');
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
        $area->update($request->all());

        return redirect()->route('governorates.areas.index');
    }

    // delete
    public function delete(GovernorateAreas $area) {
        $area->update(['deleted' => 1]);

        return redirect()->back();
    }

    // details
    public function details(GovernorateAreas $area) {
        $data['area'] = $area;

        return view('admin.governorate_area_details', ['data' => $data]);
    }
}