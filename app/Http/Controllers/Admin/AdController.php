<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use App\Ad;
use App\User;
use App\Product;
use App\AdProduct;
use App\Setting;

class AdController extends AdminController{
    
    // type get 
    public function AddGet(){
        return view('admin.ad_form');
    }

    // type post
    public function AddPost(Request $request){
        $image_name = $request->file('image')->getRealPath();
        Cloudder::upload($image_name, null);
        $imagereturned = Cloudder::getResult();
        $image_id = $imagereturned['public_id'];
        $image_format = $imagereturned['format'];    
        $image_new_name = $image_id.'.'.$image_format;
        $ad = new Ad();
        $ad->image = $image_new_name;
        $ad->content = $request->content;
        $ad->type = $request->type;
        if($request->place){
            $ad->place = $request->place;
        }
        if($request->product_type){
            $ad->product_type = $request->product_type;
        }
        
        $ad->save();
        return redirect('admin-panel/ads/show'); 
    }


        // get all ads
        public function show(Request $request){
            $data['ads'] = Ad::orderBy('id' , 'desc')->get();
            return view('admin.ads' , ['data' => $data]);
        }
    
        // get edit page
        public function EditGet(Request $request){
            $data['ad'] = Ad::find($request->id);
            if($data['ad']['product_type'] == 1){
                $data['product'] = Product::select('id' , 'title_ar as title')->where('deleted' , 0)->where('hidden' , 0)->get();
            }else if($data['ad']['product_type'] == 2){
                $data['product'] = AdProduct::where('status' , 1)->get();
            }
            return view('admin.ad_edit' , ['data' => $data]);
        }
    
        // post edit ad
        public function EditPost(Request $request){
            $ad = Ad::find($request->id);
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
            if($request->place){
                $ad->place = $request->place;
            }else{
                $ad->place  = 2; 
            }
            
            if($request->type == 1){
                if($request->product_type){
                    $ad->product_type = $request->product_type;
                }
            }else{
                $ad->product_type =0;
            }


            $ad->content = $request->content;
            
            $ad->save();
            return redirect('admin-panel/ads/show');
        }
    
        public function details(Request $request){
            $data['ad'] = Ad::find($request->id);
            if ($data['ad']['type'] == 1) {
                $data['product'] = Product::find($data['ad']['content']);
            }else {
                $data['product'] = [];
            }
            return view('admin.ad_details' , ['data' => $data]);
        }
    
        public function delete(Request $request){
            $ad = Ad::find($request->id);
            if($ad){
                $ad->delete();
            }
            return redirect('admin-panel/ads/show');
        }
    
        public function fetch_products() {
            $row = Product::orderBy('id' , 'desc')->get();
            $data = json_decode($row);
    
            return response($data, 200);
        }

        
}