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
        $post = $request->all();
        $image_name = $request->file('flag')->getRealPath();
        Cloudder::upload($image_name, null);
        $imagereturned = Cloudder::getResult();
        $image_id = $imagereturned['public_id'];
        $image_format = $imagereturned['format'];    
        $image_new_name = $image_id.'.'.$image_format;

        $post['flag'] = $image_new_name;

        Country::create($post);

        return redirect()->route('countries.index');
    }

    // get edit
    public function EditGet(Country $country) {
        $data['country'] = $country;

        return view('admin.country_edit', ['data' => $data]);
    }

    // post edit
    public function postEdit(Request $request, Country $country) {
        $post = $request->all();
        if ($request->file('flag')) {
            $image_name = $request->file('flag')->getRealPath();
            Cloudder::upload($image_name, null);
            $imagereturned = Cloudder::getResult();
            $image_id = $imagereturned['public_id'];
            $image_format = $imagereturned['format'];    
            $image_new_name = $image_id.'.'.$image_format;
            $post['flag'] = $image_new_name;
        }
        
        
        $country->update($post);

        return redirect()->route('countries.index');
    }
}