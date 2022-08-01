<?php
namespace App\Http\Controllers\Admin;

use App\AdProduct;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use App\AdSlider;
use App\Country;
use App\User;
use App\Setting;
use PHPUnit\Framework\Constraint\Count;

class AdSliderController extends AdminController{

    // show
    public function show() {
        $data['sliders'] = AdSlider::orderBy('id','desc')->get();
        
        return view('admin.ad_sliders', ['data' => $data]);
    }

    // type get 
    public function AddGet(){
        $data['countries'] = Country::orderBy('id', 'desc')->get();

        return view('admin.ad_slider_form', ['data' => $data]);
    }

    // type post
    public function AddPost(Request $request){
        $request->validate([
            'image' => 'required',
            'country_id' => 'required',
            'type' => 'required',
            'content' => 'required',
        ]);
        $image_name = $request->file('image')->getRealPath();
        Cloudder::upload($image_name, null);
        $imagereturned = Cloudder::getResult();
        $image_id = $imagereturned['public_id'];
        $image_format = $imagereturned['format'];    
        $image_new_name = $image_id.'.'.$image_format;
        $ad = new AdSlider();
        $ad->image = $image_new_name;
        $ad->country_id = $request->country_id;
        $ad->content = $request->content;
        $ad->type = $request->type;
        
        $ad->save();
        return redirect('admin-panel/ad-slider/show'); 
    }

    // get edit page
    public function EditGet(Request $request){
        $data['ad'] = AdSlider::find($request->id);
        $data['countries'] = Country::orderBy('id', 'desc')->get();
        if($data['ad']['type'] == 1){
            $data['product'] = AdProduct::where('deleted', 0)->select('id' , 'title')->get();
        }else if($data['ad']['product_type'] == 2){
            $data['product'] = [];
        }
        return view('admin.ad_slider_edit' , ['data' => $data]);
    }

    // post edit ad
    public function EditPost(Request $request){
        $ad = AdSlider::find($request->id);
        if($request->file('image')){
            $image = $ad->image;
            $publicId = substr($image, 0 ,strrpos($image, "."));    
            Cloudder::delete($publicId);
            $image_name = $request->file('image')->getRealPath();
            Cloudder::upload($image_name, null);
            $imagereturned = Cloudder::getResult();
            $image_id = $imagereturned['public_id'];
            $image_format = $imagereturned['format'];    
            $image_new_name = $image_id.'.'.$image_format;
            $ad->image = $image_new_name;
        }
        $ad->type = $request->type;
        $ad->country_id = $request->country_id;


        $ad->content = $request->content;
        
        $ad->save();
        return redirect('admin-panel/ad-slider/show');
    }

    // delete
    public function delete(Request $request) {
        $slider = AdSlider::where('id', $request->id)->first();
        $image = $slider->image;
        $publicId = substr($image, 0 ,strrpos($image, "."));    
        Cloudder::delete($publicId);
        $slider->delete();

        return redirect()->back();
    }

}