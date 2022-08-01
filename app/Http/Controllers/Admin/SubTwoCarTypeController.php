<?php
namespace App\Http\Controllers\Admin;

use App\CarType;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use App\SubTwoCarType;
use App\SubOneCarType;

class SubTwoCarTypeController extends AdminController{
    // index
    public function show() {
        $data['sub_two_car_types'] = SubTwoCarType::where('deleted' , 0)->get();

        return view('admin.sub_two_car_types', ['data' => $data]);
    }

    // get add
    public function getAdd() {
        $subTwoCarTypes = SubTwoCarType::where('deleted', 0)->pluck('sub_one_car_type_id')->toArray();
        $data['sub_one_car_types'] = SubOneCarType::where(function ($q) use ($subTwoCarTypes) {
            $q->whereIn('id', $subTwoCarTypes)->where('deleted', 0);
        })->orWhere(function ($q) {
            $q->has('products', '=', 0)->where('deleted', 0);
        })->orderBy('id', 'desc')->get();
        
        return view('admin.sub_two_car_type_form', ['data' => $data]);
    }

    // type : post -> add new cart type
    public function AddPost(Request $request){
        $request->validate([
            'image' => 'required',
            'title_en' => 'required',
            'title_ar' => 'required',
            'sub_one_car_type_id' => 'required'
        ]);
        $post = $request->all();
        $image_name = $request->file('image')->getRealPath();
        Cloudder::upload($image_name, null);
        $imagereturned = Cloudder::getResult();
        $image_id = $imagereturned['public_id'];
        $image_format = $imagereturned['format'];    
        $image_new_name = $image_id.'.'.$image_format;
        $post['image'] = $image_new_name;
        SubTwoCarType::create($post);

        return redirect()->route('sub_two_car_types.index')
        ->with('success', __('messages.created_successfully'));
    }

    // get edit
    public function getEdit(SubTwoCarType $subCarType) {
        $data['sub_two_car_type'] = $subCarType;
        $subTwoCarTypes = SubTwoCarType::where('deleted', 0)->pluck('sub_one_car_type_id')->toArray();
        $data['sub_one_car_type'] = SubOneCarType::where(function ($q) use ($subTwoCarTypes) {
            $q->whereIn('id', $subTwoCarTypes)->where('deleted', 0);
        })->orWhere(function ($q) {
            $q->has('products', '=', 0)->where('deleted', 0);
        })->orWhere(function ($q) use ($subCarType) {
            $q->where('id', $subCarType->sub_one_car_type_id)->where('deleted', 0);
        })->orderBy('id', 'desc')->get();
        

        return view('admin.sub_two_car_type_edit', ['data' => $data]);
    }

    // edit category
    public function EditPost(Request $request, SubTwoCarType $subCarType){
        $request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'sub_one_car_type_id' => 'required'
        ]);
        $post = $request->all();
        if($request->file('image')){
            $image = $subCarType->image;
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
        

        $subCarType->update($post);
        
        return redirect()->route('sub_two_car_types.index')
        ->with('success', __('messages.created_successfully'));
    }

    // delete car type
    public function delete(Request $request){
        $subTwoCarType = SubTwoCarType::find($request->id);
        $subTwoCarType->deleted = 1;
        $subTwoCarType->save();
        return redirect()->back();
    }

    // details
    public function details(SubTwoCarType $subCarType) {
        $data['sub_two_car_type'] = $subCarType;
        // dd($data['sub_one_car_type']);

        return view('admin.sub_two_car_type_details', ['data' => $data]);
    }

}