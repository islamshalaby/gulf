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
        $data['sub_one_car_types'] = SubOneCarType::where('deleted', 0)->get();

        return view('admin.sub_two_car_type_form', ['data' => $data]);
    }

    // type : post -> add new cart type
    public function AddPost(Request $request){
        $post = $request->all();
        $image_name = $request->file('image')->getRealPath();
        Cloudder::upload($image_name, null);
        $imagereturned = Cloudder::getResult();
        $image_id = $imagereturned['public_id'];
        $image_format = $imagereturned['format'];    
        $image_new_name = $image_id.'.'.$image_format;
        $post['image'] = $image_new_name;
        SubTwoCarType::create($post);
        return redirect()->route('sub_two_car_types.index'); 
    }

    // get edit
    public function getEdit(SubTwoCarType $subCarType) {
        $data['sub_two_car_type'] = $subCarType;
        $data['sub_one_car_type'] = SubOneCarType::where('deleted', 0)->get();

        return view('admin.sub_two_car_type_edit', ['data' => $data]);
    }

    // edit category
    public function EditPost(Request $request, SubTwoCarType $subCarType){
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
        
        return redirect()->route('sub_two_car_types.index');
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