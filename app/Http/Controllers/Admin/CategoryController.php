<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use App\Category;

class CategoryController extends AdminController{

    // type : get -> to add new
    public function AddGet(){
        return view('admin.category_form');
    }

    // type : get -> to add new
    public function adsAddGet(){
        return view('admin.ad_category_form');
    }

    // type : post -> add new category
    public function AddPost(Request $request){
        $image_name = $request->file('image')->getRealPath();
        Cloudder::upload($image_name, null);
        $imagereturned = Cloudder::getResult();
        $image_id = $imagereturned['public_id'];
        $image_format = $imagereturned['format'];    
        $image_new_name = $image_id.'.'.$image_format;
        $category = new Category();
        $category->image = $image_new_name;
        $category->title_en = $request->title_en;
        $category->title_ar = $request->title_ar;
        $category->type = 1;
        $category->save();
        return redirect('admin-panel/categories/show'); 
    }

    // type : post -> add new category
    public function adsAddPost(Request $request){
        $image_name = $request->file('image')->getRealPath();
        Cloudder::upload($image_name, null);
        $imagereturned = Cloudder::getResult();
        $image_id = $imagereturned['public_id'];
        $image_format = $imagereturned['format'];    
        $image_new_name = $image_id.'.'.$image_format;
        $category = new Category();
        $category->image = $image_new_name;
        $category->title_en = $request->title_en;
        $category->title_ar = $request->title_ar;
        $category->type = 2;
        $category->save();
        return redirect('admin-panel/ads_categories/show'); 
    }

    // get all ecommerce categories
    public function show(){
        $data['categories'] = Category::where('deleted' , 0)->where('type', 1)->orderBy('id' , 'desc')->get();
        return view('admin.categories' , ['data' => $data]);
    }

    // get all ads categories
    public function adsShow(){
        $data['categories'] = Category::where('deleted' , 0)->where('type', 2)->orderBy('id' , 'desc')->get();
        return view('admin.ad_categories' , ['data' => $data]);
    }

    // get edit page
    public function EditGet(Request $request){
        $data['category'] = Category::find($request->id);
        return view('admin.category_edit' , ['data' => $data ]);
    }

    // get edit page
    public function adsEditGet(Request $request){
        $data['category'] = Category::find($request->id);
        return view('admin.ad_category_edit' , ['data' => $data ]);
    }

    // edit category
    public function EditPost(Request $request){
        $category = Category::find($request->id);
        if($request->file('image')){
            $image = $category->image;
            $publicId = substr($image, 0 ,strrpos($image, "."));    
            Cloudder::delete($publicId);
            $image_name = $request->file('image')->getRealPath();
            Cloudder::upload($image_name, null);
            $imagereturned = Cloudder::getResult();
            $image_id = $imagereturned['public_id'];
            $image_format = $imagereturned['format'];    
            $image_new_name = $image_id.'.'.$image_format;
            $category->image = $image_new_name;
        }

        $category->title_en = $request->title_en;
        $category->title_ar = $request->title_ar;
        
        $category->save();
        return redirect('admin-panel/categories/show');
    }

    // edit category
    public function adsEditPost(Request $request){
        $category = Category::find($request->id);
        if($request->file('image')){
            $image = $category->image;
            $publicId = substr($image, 0 ,strrpos($image, "."));    
            Cloudder::delete($publicId);
            $image_name = $request->file('image')->getRealPath();
            Cloudder::upload($image_name, null);
            $imagereturned = Cloudder::getResult();
            $image_id = $imagereturned['public_id'];
            $image_format = $imagereturned['format'];    
            $image_new_name = $image_id.'.'.$image_format;
            $category->image = $image_new_name;
        }

        $category->title_en = $request->title_en;
        $category->title_ar = $request->title_ar;
        
        $category->save();
        return redirect('admin-panel/ads_categories/show');
    }

    // delete category
    public function delete(Request $request){
        $category = Category::find($request->id);
        $category->deleted = 1;
        $category->save();
        return redirect()->back();
    }

    // details
    public function details(Category $category) {
        $data['category'] = $category;

        return view('admin.category_details', ['data' => $data]);
    }

    // details
    public function ad_details(Category $category) {
        $data['category'] = $category;

        return view('admin.ad_category_details', ['data' => $data]);
    }

}