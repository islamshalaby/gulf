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
use App\SubFourCarType;
use App\SubCategory;
use App\ProductImage;
use App\ProductOption;
use App\HomeSection;
use App\HomeElement;
use App\OptionValue;
use App\Company;
use App\OriginCountry;
use App\CarType;
use App\ProductCompatible;
use App\SubThreeCarType;
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
        $data['origin_countries'] = OriginCountry::orderBy('country_name', 'asc')->get();
        $data['sections'] = Category::where('deleted', 0)->where('type', 1)->orderBy('id', 'desc')->get();
        $data['barcode'] = uniqid();
        $data['cat'] = $request->cat;
        

        return view('company.product_form', ['data' => $data]);
    }

    // fetch sub categories by category
    public function fetch_sub_cartwotype_by_sub_carthreetype(SubThreeCarType $carOne) {
        $rows = SubFourCarType::where('deleted', 0)->where('sub_car_type_id', $carOne->id)->get();
        // dd($rows);

        $data = json_decode($rows);
        return response($data, 200);
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
            // 'category_id' => 'required'
        ]);
        $product_post = $request->except(['images', 'option', 'value_en', 'value_ar', 'home_section', 'option_id', 'property_value_id', 'multi_option_id', 'multi_option_value_id', 'total_quatity', 'remaining_quantity', 'final_price', 'total_amount', 'remaining_amount', 'price_after_discount', 'barcodes', 'stored_numbers']);
        $product_post['weight'] = number_format((float)$request->weight, 3, '.', '');
        if ($request->width) {
            $product_post['width'] = number_format((float)$request->width, 3, '.', '');
        }
        if ($request->height) {
            $product_post['height'] = number_format((float)$request->height, 3, '.', '');
        }
        if ($request->length) {
            $product_post['length'] = number_format((float)$request->length, 3, '.', '');
        }
        $selected = $request->selected ? 1 : 0;
        $air_shipping = $request->air_shipping ? 1 : 0;
        $sea_shipping = $request->sea_shipping ? 1 : 0;
        $product_post['selected'] = $selected;
        $product_post['air_shipping'] = $air_shipping;
        $product_post['sea_shipping'] = $sea_shipping;
        $product_post['global_shipping'] = $request->global_shipping ? 1 : 0;
        $product_post['company_id'] = Auth::user()->id;
        $createdProduct = Product::create($product_post);

        if (isset($request->compatible)) {
            for ($p = 0; $p < count($request->compatible); $p ++) {
                ProductCompatible::create(['product_id' => $createdProduct['id'], 'year' => $request->compatible[$p]]);
            }
        }

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
        

        return redirect()->route('products.company.index')
        ->with('success', __('messages.created_successfully'));
    }

    // fetch category options
    public function fetch_category_options(CarType $category) {
        $rows = $category->optionsWithValues;
        // dd($rows[0]->values);
        $data = json_decode(($rows));

        return response($data, 200);
    }

    // fetch sub categories by category
    public function fetch_sub_categories_by_category(CarType $category) {
        $rows = SubOneCarType::where('deleted', 0)->where('car_type_id', $category->id)->get();

        $data = json_decode($rows);
        return response($data, 200);
    }

    // fetch sub categories by category
    public function fetch_sub_cartwotype_by_sub_caronetype(SubOneCarType $carOne) {
        $rows = SubTwoCarType::where('deleted', 0)->where('sub_one_car_type_id', $carOne->id)->get();
        // dd($carOne);

        $data = json_decode($rows);
        return response($data, 200);
    }

    // fetch sub categories by category
    public function fetch_sub_cartwotype_by_sub_cartwotype(SubTwoCarType $carOne) {
        $rows = SubThreeCarType::where('deleted', 0)->where('sub_car_type_id', $carOne->id)->get();
        // dd($rows);

        $data = json_decode($rows);
        return response($data, 200);
    }

    // fetch sub cats cats
    public function fetch_sub_cats_cats(Category $category) {
        $rows = $category->subCategories;

        $data = json_decode(($rows));

        return response($data, 200);
    }

    // fetch category products
    public function fetch_category_products(CarType $category) {
        $rows = Product::where('company_id', Auth::user()->id)->where('car_type_id', $category->id)->where('deleted', 0)->with('images', 'category')->get();
        // dd($rows);
        $data = json_decode(($rows));


        return response($data, 200);
    }

    // details
    public function details(Product $product) {
        $data['product'] = $product;
        // dd($data['product']->subTwoCar);
        $data['options'] = [];
        if (count($data['product']->options) > 0) {
            for ($i = 0; $i < count($data['product']->options); $i ++) {
                $arr['option_id'] = $data['product']->options[$i]->option_id;
                $arr['id']  = $data['product']->options[$i]->id;
                $arr['value_en']  = $data['product']->options[$i]->value_en;
                $arr['value_ar']  = $data['product']->options[$i]->value_ar;
                $option = Option::findOrFail($data['product']->options[$i]->option_id);
                $arr['option_title_en'] = $option->title_en;
                $arr['option_title_ar'] = $option->title_ar;

                array_push($data['options'], $arr);
            }
        }

        

        return view('company.product_details', ['data' => $data]);
    }

    // delete
    public function delete(Product $product) {
        
        $product->update(['deleted' => 1]);

        return redirect()->back();
    }

    // edit get
    public function EditGet(Product $product) {
        $data['product'] = $product;
        $data['barcode'] = uniqid();
        
        $data['origin_countries'] = OriginCountry::orderBy('country_name', 'asc')->get();
        $data['categories'] = CarType::where('deleted', 0)->orderBy('id', 'desc')->get();
        $data['sub_one_cars'] = SubOneCarType::where('deleted', 0)->where('car_type_id', $data['product']['car_type_id'])->orderBy('id', 'desc')->get();
        $data['companies'] = Company::where('deleted', 0)->orderBy('id', 'desc')->get();
        if (!empty($data['product']['sub_one_car_type_id'])) {
            $data['sub_two_cars'] = SubTwoCarType::where('deleted', 0)->where('sub_one_car_type_id', $data['product']['sub_one_car_type_id'])->orderBy('id', 'desc')->get();
        }else {
            $data['sub_two_cars'] = SubTwoCarType::where('deleted', 0)->orderBy('id', 'desc')->get();
        }
        if (!empty($data['product']['sub_two_car_type_id'])) {
            $data['sections'] = SubThreeCarType::where('deleted', 0)->where('sub_car_type_id', $data['product']['sub_two_car_type_id'])->orderBy('id', 'desc')->get();
        }else {
            $data['sections'] = SubThreeCarType::where('deleted', 0)->orderBy('id', 'desc')->get();
        }
        
        if (!empty($data['product']['category_id'])) {
            $data['sub_sections'] = SubFourCarType::where('deleted', 0)->where('sub_car_type_id', $data['product']['category_id'])->orderBy('id', 'desc')->get();
        }else {
            $data['sub_sections'] = SubFourCarType::where('deleted', 0)->orderBy('id', 'desc')->get();
        }
        
        $data['category'] = CarType::findOrFail($data['product']['car_type_id']);
        // dd($data['category']);
        $data['options'] = [];
        $data['product_options'] = [];
        $data['Home_sections'] = HomeSection::where('type', 4)->get();
        $data['Home_sections_ids'] = HomeSection::where('type', 4)->pluck('id');
        $data['elements'] = HomeElement::where('element_id', $product->id)->whereIn('home_id', $data['Home_sections_ids'])->pluck('home_id')->toArray();
     
        $data['property_values'] = $data['product']->values()->select('option_values.id', 'option_values.option_id')->get();
        // dd($data['property_values']);
        $data['multi_options'] = $data['product']->multiOptions()->pluck('multi_option_value_id')->toArray();
        $data['encoded_multi_options'] = json_encode($data['multi_options']);
        $data['multi_options_id'] = $data['product']->multiOptions()->pluck('multi_option_id')->toArray();
        $data['encoded_multi_options_id'] = json_encode($data['multi_options_id']);
        $data['compatible'] = ProductCompatible::where('product_id', $product->id)->pluck('year')->toArray();
        
        return view('company.product_edit', ['data' => $data]);
    }

    // edit post
    public function EditPost(Request $request, Product $product) {
        $total_quantity = (int)$request->total_quatity + 1;
        $request->validate([
            'barcode' => 'unique:products,barcode,' . $product->id . '|max:255|nullable',
            'stored_number' => 'max:255|nullable',
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_ar' => 'required',
            'description_en' => 'required',
            'category_id' => 'required'
        ]);
        
        $product_post = $request->except(['images', 'option', 'value_en', 'value_ar']);
        $product_post['global_shipping'] = $request->global_shipping ? 1 : 0;
        if (empty($product_post['brand_id'])) {
            $product_post['brand_id'] = 0;
        }
        if (empty($product_post['brand_id'])) {
            $product_post['brand_id'] = 0;
        }
        if (empty($product_post['sub_one_car_type_id'])) {
            $product_post['sub_one_car_type_id'] = 0;
        }
        if (empty($product_post['sub_two_car_type_id'])) {
            $product_post['sub_two_car_type_id'] = 0;
        }
        if (empty($product_post['category_id'])) {
            $product_post['category_id'] = 0;
        }
        if (empty($product_post['sub_category_id'])) {
            $product_post['sub_category_id'] = 0;
        }

        $product_post['weight'] = number_format((float)$request->weight, 3, '.', '');
        if ($request->width) {
            $product_post['width'] = number_format((float)$request->width, 3, '.', '');
        }
        if ($request->height) {
            $product_post['height'] = number_format((float)$request->height, 3, '.', '');
        }
        if ($request->length) {
            $product_post['length'] = number_format((float)$request->length, 3, '.', '');
        }
        
        if (isset($request->home_section) && !empty($request->home_section)) {
            $data['Home_sections_ids'] = HomeSection::where('type', 4)->pluck('id')->toArray();
            $data['elements'] = HomeElement::where('element_id', $product->id)->whereIn('home_id', $data['Home_sections_ids'])->select('id')->first();
            if (!empty($data['elements'])) {
                $data['product_element'] = HomeElement::findOrFail($data['elements']['id']);

                $data['product_element']->update(['home_id'=>$request->home_section]);
            }else {
                HomeElement::create(['home_id'=>$request->home_section, 'element_id' => $product->id]);
            }
            
        }
        
        if (isset($request->compatible) && count($request->compatible) > 0) {
            $product->compatible()->delete();
            for ($p = 0; $p < count($request->compatible); $p ++) {
                ProductCompatible::create(['product_id' => $product['id'], 'year' => $request->compatible[$p]]);
            }
        }

        if (isset($product_post['offer'])) {
            $price_before = number_format((float)$product_post['price_before_offer'], 3, '.', '');
            $discount_value = $product_post['offer_percentage'] / 100;
            $price_value = $price_before * $discount_value;
            $finalVP = $price_before - $price_value;
            $product_post['final_price'] = number_format((float)$finalVP, 3, '.', '');
        }
        
        if (!isset($product_post['final_price']) || empty($product_post['final_price'])) {
            $product_post['final_price'] = number_format((float)$product_post['price_before_offer'], 3, '.', '');
        }
        
        if (isset($product_post['offer'])) {
            $product_post['offer'] = 1;
            $product_post['price_before_offer'] = number_format((float)$product_post['price_before_offer'], 3, '.', '');
        }else {
            $product_post['offer'] = 0;
            $product_post['offer_percentage'] = 0;
            $product_post['price_before_offer'] = 0;
        }
        // dd($product_post);
        // dd($product_post['final_price']);
        $product->update($product_post);
        if ( $images = $request->file('images') ) {
            foreach ($images as $image) {
                $image_name = $image->getRealPath();
                Cloudder::upload($image_name, null);
                $imagereturned = Cloudder::getResult();
                $image_id = $imagereturned['public_id'];
                $image_format = $imagereturned['format'];    
                $image_new_name = $image_id.'.'.$image_format;
                ProductImage::create(["image" => $image_new_name, "product_id" => $product->id]);
            }
        }

        if (isset($request->option_id) 
        && count($request->option_id) > 0 
        && isset($request->property_value_id) 
        && count($request->property_value_id) > 0
        && count($request->option_id) == count($request->property_value_id)) {
            if (count($product->productProperties) > 0) {
                $product->productProperties()->delete();
            }
            for ($i = 0; $i < count($request->option_id); $i ++) {
                $post_option['product_id'] = $product->id;
                $post_option['option_id'] = $request->option_id[$i];
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

        
        
        if (isset($request->offer)) {
            $price_before = (double)$request->price_before_offer;
            $discount_value = (double)$request->offer_percentage / 100;
            $price_value = $price_before * $discount_value;
            $fPO = $price_before - $price_value;
            $selected_prod_data['final_price'] = number_format((float)$fPO, 3, '.', '');
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
            $selected_prod_data['price_before_offer'] = 0;
        }
        $selected_prod_data['total_quatity'] = $request->total_quatity;
        $selected_prod_data['remaining_quantity'] = $request->remaining_quantity;
        $selected_prod_data['multi_options'] = 0;
        $product->update($selected_prod_data);
        

        return redirect()->route('products.company.index');
        
    }

    // visibility status product
    public function visibility_status_product(Product $product, $status) {
        $product->update(['hidden' => $status]);

        return redirect()->back();
    }

}