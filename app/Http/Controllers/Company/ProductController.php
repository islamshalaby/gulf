<?php

namespace App\Http\Controllers\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\CarType;
use App\Product;

class ProductController extends CompanyController{

    public function show(Request $request) {
        $data['categories'] = CarType::where('deleted', 0)->orderBy('id', 'desc')->get();
        // $data['brands'] = Brand::where('deleted', 0)->orderBy('id', 'desc')->get();
        if($request->expire){
            $data['products'] = Product::where('deleted', 0)->where('store_id', Auth::user()->id)->where('remaining_quantity' , '<' , 10)->orderBy('id' , 'desc')->get();
            $data['expire'] = 'soon';
        }else{
            $data['products'] = Product::where('deleted', 0)->where('store_id', Auth::user()->id)->orderBy('id' , 'desc')->get();
            $data['expire'] = 'no';
        }
        
        
        $data['encoded_products'] = json_encode($data['products']);
        return view('shop.products', ['data' => $data]);
    }
}