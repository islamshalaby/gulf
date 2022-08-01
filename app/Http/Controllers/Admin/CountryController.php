<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use App\Country;

class CountryController extends AdminController{
    // index
    public function show() {
        $data['countries'] = Country::where('deleted', 0)->get();

        return view('admin.countries', ['data' => $data]);
    }

    // add type => get
    public function AddGet() {
        return view('admin.country_form');
    }

    // add type => post
    public function AddPost(Request $request) {
        $post = $request->validate([
            "flag" => "required",
            "name_en" => "required",
            "name_ar" => "required",
            "currency" => "required",
            "currency_ar" => "required",
            "currency_logo" => "required"
        ]);
        $image_name = $request->file('flag')->getRealPath();
        Cloudder::upload($image_name, null);
        $imagereturned = Cloudder::getResult();
        $image_id = $imagereturned['public_id'];
        $image_format = $imagereturned['format'];    
        $image_new_name = $image_id.'.'.$image_format;

        $post['flag'] = $image_new_name;

        $image_name2 = $request->file('currency_logo')->getRealPath();
        Cloudder::upload($image_name2, null);
        $imagereturned2 = Cloudder::getResult();
        $image_id2 = $imagereturned2['public_id'];
        $image_format2 = $imagereturned2['format'];    
        $image_new_name2 = $image_id2.'.'.$image_format2;

        $post['currency_logo'] = $image_new_name2;

        Country::create($post);

        return redirect()->route('countries.index')
        ->with('success', __('messages.created_successfully'));
    }

    // get edit
    public function EditGet(Country $country) {
        $data['country'] = $country;

        return view('admin.country_edit', ['data' => $data]);
    }

    // post edit
    public function postEdit(Request $request, Country $country) {
        $post = $request->validate([
            "name_en" => "required",
            "name_ar" => "required",
            "currency" => "required",
            "currency_ar" => "required"
        ]);
        
        if ($request->file('flag')) {
            $image_name = $request->file('flag')->getRealPath();
            Cloudder::upload($image_name, null);
            $imagereturned = Cloudder::getResult();
            $image_id = $imagereturned['public_id'];
            $image_format = $imagereturned['format'];    
            $image_new_name = $image_id.'.'.$image_format;
            $post['flag'] = $image_new_name;
        }

        if ($request->file('currency_logo')) {
            $image_name2 = $request->file('currency_logo')->getRealPath();
            Cloudder::upload($image_name2, null);
            $imagereturned2 = Cloudder::getResult();
            $image_id2 = $imagereturned2['public_id'];
            $image_format2 = $imagereturned2['format'];    
            $image_new_name2 = $image_id2.'.'.$image_format2;
            $post['currency_logo'] = $image_new_name2;
        }
        
        
        $country->update($post);

        return redirect()->route('countries.index')
        ->with('success', __('messages.updated_successfully'));
    }

    public function details(Country $country) {
        $data['country'] = $country;

        return view('admin.country_details', ['data' => $data]);
    }

    public function delete(Country $country) {
        $country->update(['deleted' => 1]);

        return redirect()->back()->with('success', __('messages.deleted_s'));
    }
}