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

class SubThreeCategoryController extends AdminController{

    

    // get all sub categories
    public function show(){
        $categories = Category::where('deleted', 0)->where('type', 2)->pluck('id')->toArray();
        $subCats = SubCategory::where('deleted', 0)->whereIn('category_id', $categories)->pluck('id')->toArray();
        $subCats2 = SubTwoCategory::where('deleted', 0)->whereIn('sub_category_id', $subCats)->pluck('id')->toArray();
        $data['sub_categories'] = SubThreeCategory::where('deleted', 0)->whereIn('sub_category_id', $subCats2)->orderBy('id' , 'desc')->get();
        
        return view('admin.sub_three_categories' , ['data' => $data]);
    }

    // add get
    public function addGet() {
        $categories = Category::where('deleted', 0)->where('type', 2)->pluck('id')->toArray();
        $subCats = SubCategory::where('deleted', 0)->whereIn('category_id', $categories)->pluck('id')->toArray();
        $data['categories'] = SubTwoCategory::where('deleted', 0)->whereIn('sub_category_id', $subCats)->orderBy('id' , 'desc')->get();

        return view('admin.sub_three_categories_form', ['data' => $data]);
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
        SubThreeCategory::create($post);

        return redirect()->route('sub_three_categories.index');
    }

    // edit get
    public function EditGet(Request $request) {
        $data['sub_category'] = SubThreeCategory::find($request->subCategory);
        $categories = Category::where('deleted', 0)->where('type', 2)->pluck('id')->toArray();
        $subCats = SubCategory::where('deleted', 0)->whereIn('category_id', $categories)->pluck('id')->toArray();
        $data['categories'] = SubTwoCategory::where('deleted', 0)->whereIn('sub_category_id', $subCats)->orderBy('id' , 'desc')->get();
        // dd($data['categories']);
        return view('admin.sub_three_categories_edit', ['data' => $data]);
    }

    // post edit
    public function EditPost(Request $request) {
        $post = $request->all();
        $subThreeCategory = SubThreeCategory::find($request->subCategory);
        if($request->file('image')){
            $image = $subThreeCategory->image;
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
        $subThreeCategory->update($post);

        return redirect()->route('sub_three_categories.index');
    }


    // details
    public function details(Request $request) {
        $data['sub_category'] = SubThreeCategory::find($request->subCategory);

        return view('admin.sub_three_category_details', ['data' => $data]);
    }

    // delete sub category
    public function delete(Request $request){
        $subThreeCategory = SubThreeCategory::find($request->subCategory);
        $subThreeCategory->update(['deleted' => 1]);
        // dd($subCategory);
        
        return redirect()->back();
    }
}