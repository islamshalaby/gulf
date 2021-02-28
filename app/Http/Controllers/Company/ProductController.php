<?php

namespace App\Http\Controllers\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use JD\Cloudder\Facades\Cloudder;
use App\Product;
use App\AdProduct;
use App\Category;
use App\Option;
use App\Brand;
use App\SubCategory;
use App\ProductImage;
use App\ProductOption;
use App\HomeSection;
use App\HomeElement;
use App\OptionValue;
use App\ProductProperty;
use App\ProductMultiOption;
use App\CarType;
use App\Company;
use App\Country;
use App\SubOneCarType;
use App\SubTwoCarType;

class ProductController extends CompanyController{

    public function show(Request $request) {
        $data['categories'] = CarType::where('deleted', 0)->orderBy('id', 'desc')->get();
        // $data['brands'] = Brand::where('deleted', 0)->orderBy('id', 'desc')->get();
        if($request->expire){
            $data['products'] = Product::where('deleted', 0)->where('company_id', Auth::user()->id)->where('remaining_quantity' , '<' , 10)->orderBy('id' , 'desc')->get();
            $data['expire'] = 'soon';
        }else{
            $data['products'] = Product::where('deleted', 0)->where('company_id', Auth::user()->id)->orderBy('id' , 'desc')->get();
            $data['expire'] = 'no';
        }
        
        
        $data['encoded_products'] = json_encode($data['products']);
        return view('company.products', ['data' => $data]);
    }

    // add get
    public function addGet(Request $request) {
        $data['categories'] = CarType::where('deleted', 0)->orderBy('id', 'desc')->get();
        $data['sections'] = Category::where('deleted', 0)->where('type', 1)->orderBy('id', 'desc')->get();
        $data['barcode'] = uniqid();
        $data['cat'] = $request->cat;
        

        return view('company.product_form', ['data' => $data]);
    }

    // product search
    public function product_search(Request $request) {
        $data['categories'] = CarType::where('deleted', 0)->orderBy('id', 'desc')->get();
        
        if (isset($request->name)) {
            $data['products'] = Product::with('images')->where('company_id', Auth::user()->id)->where('title_en', 'like', '%' . $request->name . '%')
                                ->orWhere('title_ar', 'like', '%' . $request->name . '%')->get();
            
            return view('company.searched_products', ['data' => $data]);
        }else {
            return view('company.product_search', ['data' => $data]);
        }
    }

    // get products by subcat
    public function get_product_by_sub_cat(Request $request) {
        $data['products'] = Product::with('images')->where('deleted' , 0)->where('company_id', Auth::user()->id)->where('remaining_quantity' , '<' , 10)->where('car_type_id', $request->sub_cat)->get();
        $data['cat'] = $request->cat;

        return view('company.searched_products', ['data' => $data]);
    }

    // update quantity
    public function update_quantity(Request $request, Product $product) {
        $total_quatity = (int)$request->remaining_quantity + (int)$product->total_quatity;
        $remaining_quantity = (int)$request->remaining_quantity + (int)$product->remaining_quantity;
        $product->update(['total_quatity' => $total_quatity, 'remaining_quantity' => $remaining_quantity]);

        return redirect()->back();
    }


    // add post
    public function addPost(Request $request) {
        $request->validate([
            'barcode' => 'unique:products,barcode|max:255|nullable',
            'stored_number' => 'max:255|nullable',
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_ar' => 'required',
            'description_en' => 'required',
            'category_id' => 'required'
        ]);
        $product_post = $request->except(['images', 'option', 'value_en', 'value_ar', 'home_section', 'option_id', 'property_value_id', 'multi_option_id', 'multi_option_value_id', 'total_quatity', 'remaining_quantity', 'final_price', 'total_amount', 'remaining_amount', 'price_after_discount', 'barcodes', 'stored_numbers']);
        $selected = $request->selected ? 1 : 0;
        $air_shipping = $request->air_shipping ? 1 : 0;
        $sea_shipping = $request->sea_shipping ? 1 : 0;
        $product_post['selected'] = $selected;
        $product_post['air_shipping'] = $air_shipping;
        $product_post['sea_shipping'] = $sea_shipping;
        // dd($product_post);
        $createdProduct = Product::create($product_post);

        if ( $images = $request->file('images') ) {
            foreach ($images as $image) {
                $image_name = $image->getRealPath();
                Cloudder::upload($image_name, null);
                $imagereturned = Cloudder::getResult();
                $image_id = $imagereturned['public_id'];
                $image_format = $imagereturned['format'];    
                $image_new_name = $image_id.'.'.$image_format;
                ProductImage::create(["image" => $image_new_name, "product_id" => $createdProduct['id']]);
            }
        }

        if (isset($request->option_id) 
        && count($request->option_id) > 0 
        && isset($request->property_value_id) 
        && count($request->property_value_id) > 0
        && count($request->option_id) == count($request->property_value_id)) {
            for ($i = 0; $i < count($request->option_id); $i ++) {
                $post_option['product_id'] = $createdProduct['id'];
                $post_option['option_id'] = $request->option_id[$i];
                
                // dd($post_option);
                if ($request->property_value_id[$i] != "empty") {
                    if ($request->property_value_id[$i] == 0) {
                        $option_val = OptionValue::create([
                            'option_id' => $request->option_id[$i],
                            'value_en' => $request->another_option_en[$i],
                            'value_ar' => $request->another_option_ar[$i]
                        ]);
                        $post_option['value_en'] = $request->another_option_en[$i];
                        $post_option['value_ar'] = $request->another_option_ar[$i];
                        $post_option['value_id'] = $option_val["id"];
                        ProductOption::create($post_option);
                    }else {
                        $oVal = OptionValue::where('id', $request->property_value_id[$i])->first();
                        $post_option['value_en'] = $oVal['value_en'];
                        $post_option['value_ar'] = $oVal['value_ar'];
                        $post_option['value_id'] = $request->property_value_id[$i];
                        ProductOption::create($post_option);
                    }
                }
            }
        }

        $selected_product = Product::where('id', $createdProduct['id'])->first();
        
        
        if (isset($request->offer)) {
            $price_before = number_format((float)$request->price_before_offer, 3, '.', '');
            $discount_value = (double)$request->offer_percentage / 100;
            $price_value = $price_before * $discount_value;
            $fPV = $price_before - $price_value;
            $selected_prod_data['final_price'] = number_format((float)$fPV, 3, '.', '');
        }

        if (!isset($request->offer)) {
            $selected_prod_data['final_price'] = number_format((float)$request->price_before_offer, 3, '.', '');
        }

        if (isset($request->offer)) {
            $selected_prod_data['offer'] = 1;
            $selected_prod_data['offer_percentage'] = (double)$request->offer_percentage;
        }else {
            $selected_prod_data['offer'] = 0;
            $selected_prod_data['offer_percentage'] = 0;
            $selected_prod_data['price_before_offer'] = number_format((float)$request->price_before_offer, 3, '.', '');
        }
        $selected_prod_data['total_quatity'] = $request->total_quatity;
        $selected_prod_data['remaining_quantity'] = $request->remaining_quantity;
        $selected_prod_data['company_id'] = Auth::user()->id;

        $selected_product->update($selected_prod_data);
        

        return redirect()->route('products.index')
                ->with('success', __('Created successfully'));
    }
}