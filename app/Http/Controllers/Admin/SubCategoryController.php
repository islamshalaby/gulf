<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\SubCategory;
use App\SubTwoCategory;
use App\SubThreeCategory;
use App\SubFourCarType;
use App\SubThreeCarType;

class SubCategoryController extends AdminController{

    public function fetchsubcategories(Request $request){
        $sub_categories = SubCategory::where('deleted', 0)->where('category_id' , $request->category_id)->orderBy('id' , 'desc')->get();
        $data = json_decode(($sub_categories));

        return response($data, 200);
    }

    public function fetchsubtwocategories(Request $request){
        $sub_categories = SubTwoCategory::where('deleted', 0)->where('sub_category_id' , $request->sub_category_id)->orderBy('id' , 'desc')->get();
        $data = json_decode(($sub_categories));

        return response($data, 200);
    }

    public function fetchsubthreecategories(Request $request){
        $sub_categories = SubThreeCategory::where('deleted', 0)->where('sub_category_id' , $request->sub_category_id)->orderBy('id' , 'desc')->get();
        $data = json_decode(($sub_categories));

        return response($data, 200);
    }

    // get all sub categories
    public function show(){
        $categories = SubThreeCarType::where('deleted', 0)->pluck('id')->toArray();
        $data['sub_categories'] = SubFourCarType::where('deleted', 0)->whereIn('sub_car_type_id', $categories)->orderBy('id' , 'desc')->get();
        return view('admin.sub_categories' , ['data' => $data]);
    }

    // get all sub categories
    public function adsShow(){
        $categories = Category::where('deleted', 0)->where('type', 2)->pluck('id')->toArray();
        $data['sub_categories'] = SubCategory::where('deleted', 0)->whereIn('category_id', $categories)->orderBy('id' , 'desc')->get();
        return view('admin.ad_sub_categories' , ['data' => $data]);
    }

    // add get
    public function addGet() {
        $subFourCarTypes = SubFourCarType::where('deleted', 0)->pluck('sub_car_type_id')->toArray();
        $data['sub_cars'] = SubThreeCarType::where(function ($q) use ($subFourCarTypes) {
            $q->whereIn('id', $subFourCarTypes)->where('deleted', 0);
        })->orWhere(function ($q) {
            $q->has('products', '=', 0)->where('deleted', 0);
        })->orderBy('id', 'desc')->get();

        return view('admin.sub_categories_form', ['data' => $data]);
    }

    // add get
    public function adsAddGet() {
        $subCategories = SubCategory::where('deleted', 0)->pluck('category_id');
        $data['categories'] = Category::where(function ($q) use ($subCategories) {
            $q->whereIn('id', $subCategories)->where('deleted', 0)->where('type', 2);
        })->orWhere(function ($q) {
            $q->has('adPrs', '=', 0)->where('deleted', 0)->where('type', 2);
        })->orderBy('id', 'desc')->get();

        return view('admin.ad_sub_categories_form', ['data' => $data]);
    }

    // add post
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
        $post = $request->all();
        $post['image'] = $image_new_name;
        SubFourCarType::create($post);

        return redirect()->route('sub_categories.index')
        ->with('success', __('messages.created_successfully'));
    }

    // add post
    public function adsAddPost(Request $request){
        $request->validate([
            'image' => 'required',
            'title_en' => 'required',
            'title_ar' => 'required',
            'category_id' => 'required'
        ]);
        $image_name = $request->file('image')->getRealPath();
        Cloudder::upload($image_name, null);
        $imagereturned = Cloudder::getResult();
        $image_id = $imagereturned['public_id'];
        $image_format = $imagereturned['format'];    
        $image_new_name = $image_id.'.'.$image_format;
        $post = $request->all();
        $post['image'] = $image_new_name;
        SubCategory::create($post);

        return redirect()->route('sub_categories.ads.index');
    }

    // edit get
    public function EditGet(SubFourCarType $subCategory) {
        $subFourCarTypes = SubFourCarType::where('deleted', 0)->pluck('sub_car_type_id')->toArray();
        $data['sub_category'] = $subCategory;
        $data['sub_cars'] = SubThreeCarType::where(function ($q) use ($subFourCarTypes) {
            $q->whereIn('id', $subFourCarTypes)->where('deleted', 0);
        })->orWhere(function ($q) {
            $q->has('products', '=', 0)->where('deleted', 0);
        })->orWhere(function ($q) use ($data) {
            $q->where('id', $data['sub_category']->sub_car_type_id)->where('deleted', 0);
        })->orderBy('id', 'desc')->get();
        
        return view('admin.sub_categories_edit', ['data' => $data]);
    }

    // edit get
    public function adsEditGet(SubCategory $subCategory) {
        $data['sub_category'] = $subCategory;
        $subCategories = SubCategory::where('deleted', 0)->pluck('category_id');
        $data['categories'] = Category::where(function ($q) use ($subCategories) {
            $q->whereIn('id', $subCategories)->where('deleted', 0)->where('type', 2);
        })->orWhere(function ($q) {
            $q->has('adPrs', '=', 0)->where('deleted', 0)->where('type', 2);
        })->orWhere(function ($q) use ($subCategory) {
            $q->where('id', $subCategory->category_id)->where('deleted', 0)->where('type', 2);
        })->orderBy('id', 'desc')->get();
        // dd($data['categories']);
        return view('admin.ad_sub_categories_edit', ['data' => $data]);
    }

      // post edit
    public function EditPost(Request $request, SubFourCarType $subCategory) {
        $request->validate([
            'image' => 'required',
            'title_en' => 'required',
            'title_ar' => 'required',
            'sub_car_type_id' => 'required'
        ]);
        $this->update($request->all(), $request, $subCategory);

        return redirect()->route('sub_categories.index')
        ->with('success', __('messages.created_successfully'));
    }

    // post edit
    public function adsEditPost(Request $request, SubCategory $subCategory) {
        $request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'category_id' => 'required'
        ]);
        $this->update($request->all(), $request, $subCategory);

        return redirect()->route('sub_categories.ads.index');
    }

    public function update($post, $request, $subCategory) {
        $post = $request->all();
        if($request->file('image')){
            $image = $subCategory->image;
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

        $subCategory->update($post);
    }

    // fetch brands
    public function fetchBrands(Category $category) {
        $row = $category->brands()->where('deleted', 0)->get();
        $data = json_decode($row);
        
        return response($data, 200);
    }

    // details
    public function details(SubFourCarType $subCategory) {
        $data['sub_category'] = $subCategory;

        return view('admin.sub_category_details', ['data' => $data]);
    }

    // details
    public function adsDetails(SubCategory $subCategory) {
        $data['sub_category'] = $subCategory;

        return view('admin.ad_sub_category_details', ['data' => $data]);
    }

    // delete sub category
    public function delete(SubCategory $subCategory){
        $subCategory->update(['deleted' => 1]);
        
        return redirect()->back();
    }

    // delete sub category
    public function deleteSubCar(SubFourCarType $subCategory){
        $subCategory->update(['deleted' => 1]);
        
        return redirect()->back();
    }
}