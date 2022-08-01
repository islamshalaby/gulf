<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\SubCategory;
use App\SubTwoCategory;

class SubTwoCategoryController extends AdminController{
    // get all sub categories
    public function show(){
        $categories = Category::where('deleted', 0)->where('type', 2)->pluck('id')->toArray();
        $subCatsOne = SubCategory::where('deleted', 0)->whereIn('category_id', $categories)->pluck('id')->toArray();
        $data['sub_categories'] = SubTwoCategory::where('deleted', 0)->whereIn('sub_category_id', $subCatsOne)->orderBy('id' , 'desc')->get();
        return view('admin.sub_two_categories' , ['data' => $data]);
    }

    // add get
    public function addGet() {
        $categories = Category::where('deleted', 0)->where('type', 2)->pluck('id')->toArray();
        $subTwoCats = SubTwoCategory::where('deleted', 0)->pluck('sub_category_id')->toArray();
        $data['categories'] = SubCategory::where(function ($q) use ($subTwoCats, $categories) {
            $q->whereIn('category_id', $categories)->whereIn('id', $subTwoCats)->where('deleted', 0);
        })->orWhere(function ($q) use ($categories) {
            $q->whereIn('category_id', $categories)->has('adPrs', '=', 0)->where('deleted', 0);
        })->orderBy('id' , 'desc')->get();

        return view('admin.sub_two_categories_form', ['data' => $data]);
    }

    // add post
    public function AddPost(Request $request){
        $request->validate([
            'image' => 'required',
            'title_en' => 'required',
            'title_ar' => 'required',
            'sub_category_id' => 'required'
        ]);
        $image_name = $request->file('image')->getRealPath();
        Cloudder::upload($image_name, null);
        $imagereturned = Cloudder::getResult();
        $image_id = $imagereturned['public_id'];
        $image_format = $imagereturned['format'];    
        $image_new_name = $image_id.'.'.$image_format;
        $post = $request->all();
        $post['image'] = $image_new_name;
        SubTwoCategory::create($post);

        return redirect()->route('sub_two_categories.index');
    }

    // edit get
    public function EditGet(Request $request) {
        $data['sub_category'] = SubTwoCategory::find($request->subCategory);
        $subTwoCats = SubTwoCategory::where('deleted', 0)->pluck('sub_category_id')->toArray();
        $categories = Category::where('deleted', 0)->where('type', 2)->pluck('id')->toArray();
        $data['categories'] = SubCategory::where(function ($q) use ($subTwoCats, $categories) {
            $q->whereIn('category_id', $categories)->whereIn('id', $subTwoCats)->where('deleted', 0);
        })->orWhere(function ($q) use ($categories) {
            $q->whereIn('category_id', $categories)->has('adPrs', '=', 0)->where('deleted', 0);
        })->orWhere(function ($q) use ($data) {
            $q->where('id', $data['sub_category']->sub_category_id)->where('deleted', 0);
        })->orderBy('id' , 'desc')->get();
        
        return view('admin.sub_two_categories_edit', ['data' => $data]);
    }

      // post edit
      public function EditPost(Request $request) {
        $request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'sub_category_id' => 'required'
        ]);
        $post = $request->all();
        $subTwoCategory = SubTwoCategory::find($request->subCategory);
        if($request->file('image')){
            $image = $subTwoCategory->image;
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

        // dd($post);
        $subTwoCategory->update($post);

        return redirect()->route('sub_two_categories.index');
    }


    // details
    public function details(Request $request) {
        $data['sub_category'] = SubTwoCategory::find($request->subCategory);

        return view('admin.sub_two_category_details', ['data' => $data]);
    }

    // delete sub category
    public function delete(Request $request){
        $subTwoCategory = SubTwoCategory::find($request->subCategory);
        $subTwoCategory->update(['deleted' => 1]);
        // dd($subCategory);
        
        return redirect()->back();
    }
}