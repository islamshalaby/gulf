<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use App\DeliveryMethod;

class DeliveryMethodController extends AdminController{
    // index
    public function show() {
        $data['methods'] = DeliveryMethod::where('deleted', 0)->orderBy('id', 'desc')->get();

        return view('admin.delivery_methods', ['data' => $data]);
    }

    // add type => get
    public function AddGet() {
        return view('admin.delivery_method_form');
    }

    // add type => post
    public function AddPost(Request $request) {
        $post = $request->all();
        $image_name = $request->file('icon')->getRealPath();
        Cloudder::upload($image_name, null);
        $imagereturned = Cloudder::getResult();
        $image_id = $imagereturned['public_id'];
        $image_format = $imagereturned['format'];    
        $image_new_name = $image_id.'.'.$image_format;

        $post['icon'] = $image_new_name;

        DeliveryMethod::create($post);

        return redirect()->route('deliveryMethod.index');
    }

    // get edit
    public function EditGet(DeliveryMethod $method) {
        $data['method'] = $method;

        return view('admin.delivery_method_edit', ['data' => $data]);
    }

    // post edit
    public function EditPost(Request $request, DeliveryMethod $method) {
        $post = $request->all();
        // dd($method);
        if ($request->file('icon')) {
            $image_name = $request->file('icon')->getRealPath();
            Cloudder::upload($image_name, null);
            $imagereturned = Cloudder::getResult();
            $image_id = $imagereturned['public_id'];
            $image_format = $imagereturned['format'];    
            $image_new_name = $image_id.'.'.$image_format;
            $post['icon'] = $image_new_name;
        }
        
        // dd($post);
        $method->update($post);

        return redirect()->route('deliveryMethod.index');
    }

    public function delete(DeliveryMethod $method) {
        $method->update(['deleted' => 1]);

        return redirect()->back();
    }
}