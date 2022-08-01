<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\SubThreeCarType;
use App\SubTwoCarType;

class CategoryController extends AdminController{

    // type : get -> to add new
    public function AddGet(){
        $subThreeCarTypes = SubThreeCarType::where('deleted', 0)->pluck('sub_car_type_id')->toArray();
        $data['sub_cars'] = SubTwoCarType::where(function ($q) use ($subThreeCarTypes) {
            $q->whereIn('id', $subThreeCarTypes)->where('deleted', 0);
        })->orWhere(function ($q) {
            $q->has('products', '=', 0)->where('deleted', 0);
        })->orderBy('id', 'desc')->get();

        return view('admin.category_form', compact('data'));
    }

    // type : get -> to add new
    public function adsAddGet(){
        return view('admin.ad_category_form');
    }

    // type : post -> add new category
    public function AddPost(Request $request){
        $request->validate([
            'image' => 'required',
            'title_en' => 'required',
            'title_ar' => 'required',
            'sub_car_type_id' => 'required'
        ]);
        $image_name = $request->file('image')->getRealPath();
        Cloudder::upload($image_name, null);
        $imagereturned = Cloudder::getResult();
        $image_id = $imagereturned['public_id'];
        $image_format = $imagereturned['format'];    
        $image_new_name = $image_id.'.'.$image_format;
        $category = new SubThreeCarType();
        $category->image = $image_new_name;
        $category->title_en = $request->title_en;
        $category->title_ar = $request->title_ar;
        $category->sub_car_type_id = $request->sub_car_type_id;
        $category->save();

        return redirect('admin-panel/categories/show')
        ->with('success', __('messages.created_successfully'));
    }

    // type : post -> add new category
    public function adsAddPost(Request $request){
        $request->validate([
            'image' => 'required',
            'title_en' => 'required',
            'title_ar' => 'required'
        ]);
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
        $data['categories'] = SubThreeCarType::where('deleted' , 0)->orderBy('id' , 'desc')->get();
        return view('admin.categories' , ['data' => $data]);
    }

    // get all ads categories
    public function adsShow(){
        $data['categories'] = Category::where('deleted' , 0)->where('type', 2)->orderBy('id' , 'desc')->get();
        return view('admin.ad_categories' , ['data' => $data]);
    }

    // get edit page
    public function EditGet(Request $request){
        $subThreeCarTypes = SubThreeCarType::where('deleted', 0)->pluck('sub_car_type_id')->toArray();
        $data['category'] = SubThreeCarType::find($request->id);
        $data['sub_cars'] = SubTwoCarType::where(function ($q) use ($subThreeCarTypes) {
            $q->whereIn('id', $subThreeCarTypes)->where('deleted', 0);
        })->orWhere(function ($q) {
            $q->has('products', '=', 0)->where('deleted', 0);
        })->orWhere(function ($q) use ($data) {
            $q->where('id', $data['category']->sub_car_type_id)->where('deleted', 0);
        })->orderBy('id', 'desc')->get();

        return view('admin.category_edit' , ['data' => $data ]);
    }

    // get edit page
    public function adsEditGet(Request $request){
        $data['category'] = Category::find($request->id);
        return view('admin.ad_category_edit' , ['data' => $data ]);
    }

    // edit category
    public function EditPost(Request $request){
        $request->validate([
            'image' => 'required',
            'title_en' => 'required',
            'title_ar' => 'required',
            'sub_car_type_id' => 'required'
        ]);
        $category = SubThreeCarType::find($request->id);
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
        $category->sub_car_type_id = $request->sub_car_type_id;
        $category->save();

        return redirect('admin-panel/categories/show')
        ->with('success', __('messages.created_successfully'));
    }

    // edit category
    public function adsEditPost(Request $request){
        $request->validate([
            'title_en' => 'required',
            'title_ar' => 'required'
        ]);
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
    public function details(SubThreeCarType $category) {
        $data['category'] = $category;

        return view('admin.category_details', ['data' => $data]);
    }

    // delete category
    public function deleteSubCar(Request $request){
        $category = SubThreeCarType::find($request->id);
        $category->deleted = 1;
        $category->save();
        return redirect()->back();
    }

    // details
    public function ad_details(Category $category) {
        $data['category'] = $category;

        return view('admin.ad_category_details', ['data' => $data]);
    }

}