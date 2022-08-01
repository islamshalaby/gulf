<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use App\Country;
use App\Governorate;

class GovernorateController extends AdminController{
    // index
    public function show() {
        $data['governorates'] = Governorate::where('deleted', 0)->orderBy('id', 'desc')->get();

        return view('admin.governorates', ['data' => $data]);
    }

    // add type => get
    public function AddGet() {
        $data['countries'] = Country::where('deleted', 0)->orderBy('id', 'desc')->get();

        return view('admin.governorate_form', ['data' => $data]);
    }

    // add type => post
    public function AddPost(Request $request) {
        $post = $request->validate([
            'name_en' => 'required',
            'name_ar' => 'required',
            'country_id' => 'required'
        ]);

        Governorate::create($post);

        return redirect()->route('governorates.index')
        ->with('success', __('messages.created_successfully'));
    }

    // get edit
    public function EditGet(Governorate $governorate) {
        $data['governorate'] = $governorate;
        $data['countries'] = Country::where('deleted', 0)->orderBy('id', 'desc')->get();

        return view('admin.governorate_edit', ['data' => $data]);
    }

    // post edit
    public function postEdit(Request $request, Governorate $governorate) {
        $post = $request->validate([
            'name_en' => 'required',
            'name_ar' => 'required',
            'country_id' => 'required'
        ]);

        $governorate->update($post);

        return redirect()->route('governorates.index')
        ->with('success', __('messages.updated_successfully'));
    }

    public function details(Governorate $governorate) {
        $data['governorate'] = $governorate;

        return view('admin.governorate_details', ['data' => $data]);
    }

    public function delete(Governorate $governorate) {
        $governorate->update(['deleted' => 1]);

        return redirect()->back()->with('success', __('messages.deleted_s'));
    }
}