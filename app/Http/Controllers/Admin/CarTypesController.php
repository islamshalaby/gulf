<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\CarType;

class CarTypesController extends AdminController{
    // index
    public function show() {
        $data['car_types'] = CarType::where('deleted' , 0)->get();

        return view('admin.car_types', ['data' => $data]);
    }

    // get add
    public function getAdd() {
        return view('admin.car_type_form');
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
        CarType::create($post);
        return redirect()->route('car_types.index'); 
    }

    // get edit
    public function getEdit(CarType $carType) {
        $data['car_type'] = $carType;

        return view('admin.car_type_edit', ['data' => $data]);
    }

    // edit category
    public function EditPost(Request $request, CarType $carType){
        $post = $request->all();
        if($request->file('image')){
            $image = $carType->image;
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
        

        $carType->update($post);
        
        return redirect()->route('car_types.index');
    }

    // delete car type
    public function delete(Request $request){
        $carType = CarType::find($request->id);
        $carType->deleted = 1;
        $carType->save();
        return redirect()->back();
    }

    // details
    public function details(CarType $carType) {
        $data['car_type'] = $carType;

        return view('admin.car_type_details', ['data' => $data]);
    }
}