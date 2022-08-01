<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use App\Brand;
use App\Category;

class BrandController extends AdminController{
    // get all brands
    public function show(){
        $data['brands'] = Brand::where('deleted', 0)->orderBy('id' , 'desc')->get();
        return view('admin.brands' , ['data' => $data]);
    }

    // add get
    public function addGet() {
        $data['categories'] = Category::where('deleted', 0)->orderBy('id' , 'desc')->get();

        return view('admin.brand_form', ['data' => $data]);
    }

    // add post
    public function AddPost(Request $request){
        $image_name = $request->file('image')->getRealPath();
        Cloudder::upload($image_name, null);
        $imagereturned = Cloudder::getResult();
        $image_id = $imagereturned['public_id'];
        $image_format = $imagereturned['format'];    
        $image_new_name = $image_id.'.'.$image_format;
        $post = $request->all();
        $post['image'] = $image_new_name;
        Brand::create($post);

        return redirect()->route('brands.index');
    }

    // get edit page
    public function EditGet(Brand $brand){
        $data['brand'] = $brand;
        $data['categories'] = Category::where('deleted', 0)->orderBy('id' , 'desc')->get();

        return view('admin.brand_edit' , ['data' => $data ]);
    }

    // post edit
    public function EditPost(Request $request, Brand $brand) {
        $post = $request->all();
        if($request->file('image')){
            $image = $brand->image;
            $publicId = substr($image, 0 ,strrpos($image, "."));    
            Cloudder::delete($publicId);
            $image_name = $request->file('image')->getRealPath();
            Cloudder::upload($image_name, null);
            $imagereturned = Cloudder::getResult();
            $image_id = $imagereturned['public_id'];
            $image_format = $imagereturned['format'];    
            $image_new_name = $image_id.'.'.$image_format;
            $post['image'] = $image_new_name;
        }

        $brand->update($post);

        return redirect()->route('brands.index');
    }

    // delete
    public function delete(Brand $brand) {
        $brand->update(['deleted' => 1]);

        return redirect()->back();
    }

    // details
    public function details(Brand $brand) {
        $data['brand'] = $brand;

        return view('admin.brand_details', ['data' => $data]);
    }
}