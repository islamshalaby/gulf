<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\SubCategory;
use App\SubFourCategory;
use App\SubTwoCategory;
use App\SubThreeCategory;

class SubFourCategoryController extends AdminController{
    // get all sub categories
    public function show(){
        $categories = Category::where('deleted', 0)->where('type', 2)->pluck('id')->toArray();
        $subCats = SubCategory::where('deleted', 0)->whereIn('category_id', $categories)->pluck('id')->toArray();
        $subCats2 = SubTwoCategory::where('deleted', 0)->whereIn('sub_category_id', $subCats)->pluck('id')->toArray();
        $subCats3 = SubThreeCategory::where('deleted', 0)->whereIn('sub_category_id', $subCats2)->pluck('id')->toArray();
        $data['sub_categories'] = SubFourCategory::where('deleted', 0)->whereIn('sub_category_id', $subCats3)->orderBy('id' , 'desc')->get();
        
        return view('admin.sub_four_categories' , ['data' => $data]);
    }

    // add get
    public function addGet() {
        $categories = Category::where('deleted', 0)->where('type', 2)->pluck('id')->toArray();
        $subCats = SubCategory::where('deleted', 0)->whereIn('category_id', $categories)->pluck('id')->toArray();
        $subCats2 = SubTwoCategory::where('deleted', 0)->whereIn('sub_category_id', $subCats)->pluck('id')->toArray();
        $data['categories'] = SubThreeCategory::where('deleted', 0)->whereIn('sub_category_id', $subCats2)->orderBy('id' , 'desc')->get();

        return view('admin.sub_four_categories_form', ['data' => $data]);
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
        SubFourCategory::create($post);

        return redirect()->route('sub_four_categories.index');
    }

    // edit get
    public function EditGet(Request $request) {
        $data['sub_category'] = SubFourCategory::find($request->subCategory);
        $categories = Category::where('deleted', 0)->where('type', 2)->pluck('id')->toArray();
        $subCats = SubCategory::where('deleted', 0)->whereIn('category_id', $categories)->pluck('id')->toArray();
        $subCats2 = SubTwoCategory::where('deleted', 0)->whereIn('sub_category_id', $subCats)->pluck('id')->toArray();
        $data['categories'] = SubThreeCategory::where('deleted', 0)->whereIn('sub_category_id', $subCats2)->orderBy('id' , 'desc')->get();
        
        return view('admin.sub_four_categories_edit', ['data' => $data]);
    }

    // post edit
    public function EditPost(Request $request) {
        $post = $request->all();
        $subFourCategory = SubFourCategory::find($request->subCategory);
        if($request->file('image')){
            $image = $subFourCategory->image;
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
        $subFourCategory->update($post);

        return redirect()->route('sub_four_categories.index');
    }

    // details
    public function details(Request $request) {
        $data['sub_category'] = SubFourCategory::find($request->subCategory);

        return view('admin.sub_four_category_details', ['data' => $data]);
    }

    // delete sub category
    public function delete(Request $request){
        $subFourCategory = SubFourCategory::find($request->subCategory);
        $subFourCategory->update(['deleted' => 1]);
        
        
        return redirect()->back();
    }
}