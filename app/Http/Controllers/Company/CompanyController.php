<?php

namespace App\Http\Controllers\Company;

use App\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Shop;

class CompanyController extends Controller{

    public function __construct()
    {
        $this->middleware('auth:company', ['except' => ['getlogin' , 'postlogin']]);
    }
    
    // get login page
    public function getlogin(){
        return view('company.login');
    }

    // post login 
    public function postlogin(Request $request){
        $credentials = request(['email', 'password']);

        if (Auth::guard('company')->attempt($credentials)) {
            $user = Auth::guard('company')->user();
            return redirect('/company-panel');
        } else {
            return view('company.login');
        }
    }

    // logout
    public function logout(){
        $user = Auth::guard('company')->user();
        Auth::logout();
        return redirect('/company-panel/login');
    }

    // get profile 
    public function profile(){
        $admin = Auth::user();
        $data['name'] = $admin->name;
        $data['email'] = $admin->email;
        $data['logo'] = $admin->logo;
        $data['cover'] = $admin->cover;
        return view('shop.profile' , ['data' => $data]);
    }

    // update profile
    // public function updateprofile(Request $request){
    //     $current_admin_id =  Auth::user()->id;
    //     $check_manager_email = Shop::where('email' , $request->email)->where('id' , '!=' , $current_admin_id)->first();
    //     if($check_manager_email){
    //         return redirect()->back()->with('status' , 'Email Exists Before');
    //     }
        
    //     $current_manager = Shop::find($current_admin_id);
    //     if($request->file('logo')){
    //         $image = $current_manager->logo;
    //         $publicId = substr($image, 0 ,strrpos($image, "."));
    //         if (!empty($publicId)) {
    //             Cloudder::delete($publicId);
    //         }
    //         $image_name = $request->file('logo')->getRealPath();
    //         Cloudder::upload($image_name, null);
    //         $imagereturned = Cloudder::getResult();
    //         $image_id = $imagereturned['public_id'];
    //         $image_format = $imagereturned['format'];    
    //         $image_new_name = $image_id.'.'.$image_format;
    //         $current_manager->logo = $image_new_name;
    //     }
    //     if($request->file('cover')){
    //         $image_cover = $current_manager->cover;
    //         $publicId = substr($image_cover, 0 ,strrpos($image_cover, "."));
    //         if (!empty($publicId)) {
    //             Cloudder::delete($publicId);
    //         }
    //         $cover_name = $request->file('cover')->getRealPath();
    //         Cloudder::upload($cover_name, null);
    //         $coverreturned = Cloudder::getResult();
    //         $cover_id = $coverreturned['public_id'];
    //         $cover_format = $coverreturned['format'];    
    //         $cover_new_name = $cover_id.'.'.$cover_format;
    //         $current_manager->cover = $cover_new_name;
    //     }
    //     $current_manager->name = $request->name;
    //     $current_manager->email = $request->email;
    //     if($request->password){
    //         $current_manager->password = Hash::make($request->password);
    //     }
    //     $current_manager->save();
    //     return redirect()->back();
    // }

    public function personal_data_get() {
        $data['company'] = Company::find(Auth::user()->id);

        return view('company.personal_data', ['data' => $data]);
    }

    public function personal_data_post(Request $request) {
        $company = Company::find(Auth::user()->id);
        $post = $request->all();

        if($request->file('image')){
            $image = $company->image;
            $publicId = substr($image, 0 ,strrpos($image, "."));
            if (!empty($publicId)) {
                Cloudder::delete($publicId);
            }
            $image_name = $request->file('image')->getRealPath();
            Cloudder::upload($image_name, null);
            $imagereturned = Cloudder::getResult();
            $image_id = $imagereturned['public_id'];
            $image_format = $imagereturned['format'];    
            $image_new_name = $image_id.'.'.$image_format;
            $post['image'] = $image_new_name;
        }
        

        $company->update($post);

        return redirect()->back();
    }

}