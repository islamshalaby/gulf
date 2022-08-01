<?php

namespace App\Http\Controllers\Admin;

use App\HomeAd;
use App\Product;
use App\AdProduct;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;

class HomeAdController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['ads'] = HomeAd::orderBy('id' , 'desc')->get();
        return view('admin.home_sliders' , ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.home_slider_form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image_name = $request->file('image')->getRealPath();
        Cloudder::upload($image_name, null);
        $imagereturned = Cloudder::getResult();
        $image_id = $imagereturned['public_id'];
        $image_format = $imagereturned['format'];    
        $image_new_name = $image_id.'.'.$image_format;
        $ad = new HomeAd();
        $ad->image = $image_new_name;
        $ad->content = $request->content;
        $ad->type = $request->type;
        if($request->product_type){
            $ad->product_type = $request->product_type;
        }
        
        $ad->save();
        return redirect()->route('home-slider.index'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['ad'] = HomeAd::find($id);
        if($data['ad']['product_type'] == 1){
            $data['product'] = Product::select('id' , 'title_ar as title')->where('deleted' , 0)->where('hidden' , 0)->get();
        }else if($data['ad']['product_type'] == 2){
            $data['product'] = AdProduct::where('status' , 1)->get();
        }
        return view('admin.home_slider_edit' , ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ad = HomeAd::find($id);
        if($request->file('image')){
            $image = $ad->image;
            $publicId = substr($image, 0 ,strrpos($image, "."));    
            Cloudder::delete($publicId);
            $image_name = $request->file('image')->getRealPath();
            Cloudder::upload($image_name, null);
            $imagereturned = Cloudder::getResult();
            $image_id = $imagereturned['public_id'];
            $image_format = $imagereturned['format'];    
            $image_new_name = $image_id.'.'.$image_format;
            $ad->image = $image_new_name;
        }
        $ad->type = $request->type;
        
        if($request->type == 1){
            if($request->product_type){
                $ad->product_type = $request->product_type;
            }
        }else{
            $ad->product_type =0;
        }


        $ad->content = $request->content;
        
        $ad->save();
        return redirect()->route('home-slider.index'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        HomeAd::where('id', $id)->first()->delete();

        return redirect()->back();
    }
}
