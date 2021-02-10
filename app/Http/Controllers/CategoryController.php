<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Helpers\APIHelpers;
use App\Category;
use App\Brand;
use App\SubCategory;
use App\CarType;
use App\SubOneCarType;
use App\SubTwoCarType;
use App\CategoryOptionValue;
use App\SubTwoCategory;
use App\SubThreeCategory;
use App\CategoryOption;
use App\AdProduct;
use App\AdProductImage;
use App\Favorite;
use App\SubFourCategory;
use App\Country;
use App\Currency;
use App\Http\Controllers\Admin\SubTwoCategoryController;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api' , ['except' => ['getecommercecategories' ,
         'get_ecommerce_sub_categories' ,
          'get_car_types' ,
           'get_ecommerce_sub_car_type_level1' ,
            'get_ecommerce_sub_car_type_level2',
             'getAdCategories',
              'getAdSubCategories',
              'get_sub_categories_level2',
              'get_sub_categories_level3',
              'get_sub_categories_level4',
              'getCategoryOptions',
              'getSubCatsForCreate',
              'getSubCatsLevel2ForCreate',
              'getSubCatsLevel3ForCreate',
              'getSubCatsLevel4ForCreate' ]]);
    }

    public function getecommercecategories(Request $request){
  
        if($request->lang == 'en'){
            $data['categories'] = Category::where('deleted' , 0)->where('type' , 1)->select('id' , 'title_en as title' , 'image')->get();   
        }else{
            $data['categories'] = Category::where('deleted' , 0)->where('type' , 1)->select('id' , 'title_ar as title' , 'image')->get();   
        }
         

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }
	
	public function get_ecommerce_sub_categories(Request $request){

                if($request->lang == 'en'){
                    $data['sub_categories'] = SubCategory::where('deleted' , 0)->where('category_id' , $request->category_id)->select('id' , 'image' , 'title_en as title')->get()->toArray();
                	$data['category'] = Category::select('id' , 'title_en as title')->find($request->category_id);
                    $all = new \StdClass;
                    $all->id = 0;
                    $all->title = 'All';
                    $all->image = 'all_liwbsi.png';
				}else{
                    $data['sub_categories'] = SubCategory::where('deleted' , 0)->where('category_id' , $request->category_id)->select('id' , 'image' , 'title_ar as title')->get()->toArray();
                	$data['category'] = Category::select('id' , 'title_ar as title')->find($request->category_id);
                    $all = new \StdClass;
                    $all->id = 0;
                    $all->title = 'الكل';
                    $all->image = 'all_liwbsi.png';
                }

                array_unshift($data['sub_categories'], $all);
                
            $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
            return response()->json($response , 200);
    }

    public function get_car_types(Request $request){
        if($request->lang == 'en'){
            $data = CarType::where('deleted' , 0)->select('id' , 'image' , 'title_en as title')->get();

		}else{
            $data = CarType::where('deleted' , 0)->select('id' , 'image' , 'title_ar as title')->get();
        }

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }


    public function get_ecommerce_sub_car_type_level1(Request $request){
        if($request->lang == 'en'){
            if ($request->car_type_id == 0) {
                $data = SubOneCarType::where('deleted' , 0)->select('id' , 'image' , 'title_en as title')->get();
            }else {
                $data = SubOneCarType::where('deleted' , 0)->where('car_type_id' , $request->car_type_id)->select('id' , 'image' , 'title_en as title')->get();
            }
            

		}else{
            if ($request->car_type_id == 0) {
                $data = SubOneCarType::where('deleted' , 0)->select('id' , 'image' , 'title_ar as title')->get();
            }else {
                $data = SubOneCarType::where('deleted' , 0)->where('car_type_id' , $request->car_type_id)->select('id' , 'image' , 'title_ar as title')->get();
            }
            
		}

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }

    public function get_ecommerce_sub_car_type_level2(Request $request){
        if($request->lang == 'en'){
            
            if ($request->sub_car_type_id == 0) {
                $data['sub_car_types'] = SubTwoCarType::where('deleted' , 0)->select('id' , 'image' , 'title_en as title')->get()->toArray();
                $car_type = new \StdClass;
                $car_type->id = 0;
                $car_type->title = 'الكل';
                $car_type->image = 'all_liwbsi.png';
            }else {
                $data['sub_car_types'] = SubTwoCarType::where('deleted' , 0)->where('sub_one_car_type_id' , $request->sub_car_type_id)->select('id' , 'image' , 'title_en as title')->get()->toArray();

                $sub_one_car_type = SubOneCarType::select('id'  , 'title_en as title' , 'car_type_id')->find($request->sub_car_type_id);
                $car_type = CarType::select('id' , 'title_en as title')->find($sub_one_car_type->car_type_id);
            }
            $all = new \StdClass;
            $all->id = 0;
            $all->title = 'All';
            $all->image = 'all_liwbsi.png';
            
		}else{
            if ($request->sub_car_type_id == 0) {
                $data['sub_car_types'] = SubTwoCarType::where('deleted' , 0)->select('id' , 'image' , 'title_ar as title')->get()->toArray();
                $car_type = new \StdClass;
                $car_type->id = 0;
                $car_type->title = 'الكل';
                $car_type->image = 'all_liwbsi.png';
            }else {
                $data['sub_car_types'] = SubTwoCarType::where('deleted' , 0)->where('sub_one_car_type_id' , $request->sub_car_type_id)->select('id' , 'image' , 'title_ar as title')->get()->toArray();

                $sub_one_car_type = SubOneCarType::select('id'  , 'title_ar as title' , 'car_type_id')->find($request->sub_car_type_id);
                $car_type = CarType::select('id' , 'title_en as title')->find($sub_one_car_type->car_type_id);
            }
            $all = new \StdClass;
            $all->id = 0;
            $all->title = 'All';
            $all->image = 'all_liwbsi.png';
        }        

        array_unshift($data['sub_car_types'], $all);
        
        $data['car_type'] = new \StdClass;
        $data['car_type']->id = $car_type->id;
        $data['car_type']->title = $car_type->title;   
             
        

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }

    // get ad categories
    public function getAdCategories(Request $request) {
        if($request->lang == 'en'){
            $data['categories'] = Category::where('deleted' , 0)->where('type' , 2)->select('id' , 'title_en as title' , 'image')->get();   
        }else{
            $data['categories'] = Category::where('deleted' , 0)->where('type' , 2)->select('id' , 'title_ar as title' , 'image')->get();   
        }
         

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }

    // get ad subcategories
    public function getAdSubCategories(Request $request) {
        if($request->lang == 'en'){
            $data['sub_categories'] = SubCategory::where('deleted' , 0)->where('category_id' , $request->category_id)->select('id' , 'image' , 'title_en as title')->get()->toArray();
            $data['category'] = Category::select('id' , 'title_en as title')->find($request->category_id);
            $all = new \StdClass;
            $all->id = 0;
            $all->title = 'All';
            $all->image = 'all_liwbsi.png';
            $all->next_level = false;
        }else{
            $data['sub_categories'] = SubCategory::where('deleted' , 0)->where('category_id' , $request->category_id)->select('id' , 'image' , 'title_ar as title')->get()->toArray();
            $data['category'] = Category::select('id' , 'title_ar as title')->find($request->category_id);
            $all = new \StdClass;
            $all->id = 0;
            $all->title = 'الكل';
            $all->image = 'all_liwbsi.png';
            $all->next_level = false;
        }

        for ($i =0; $i < count($data['sub_categories']); $i ++) {
            $subTwoCats = SubTwoCategory::where('sub_category_id', $data['sub_categories'][$i]['id'])->select('id')->first();
            $data['sub_categories'][$i]['next_level'] = false;
            if (isset($subTwoCats['id'])) {
                $data['sub_categories'][$i]['next_level'] = true;
            }
        }
        array_unshift($data['sub_categories'], $all);
            
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }
    
    public function get_sub_categories_level2(Request $request){
        $validator = Validator::make($request->all() , [
            'country' => 'required',
            'category_id' => 'required'
        ]);

        if($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 ,  'بعض الحقول مفقودة' ,  'بعض الحقول مفقودة' , null , $request->lang );
            return response()->json($response , 406);
        }
        // dd($request->all());
        $country = Country::where('id', $request->country)->select('id', 'currency')->first();
        $fromCurr = trim(strtolower($country['currency']));
        $toCurr = trim(strtolower($request->curr));
        if ($fromCurr == $toCurr) {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', $fromCurr)->where('to', $toCurr)->first();
        }
        
        if($request->lang == 'en'){
            if ($request->sub_category_id != 0) {
                $data['sub_categories'] = SubTwoCategory::where('deleted' , 0)->where('sub_category_id' , $request->sub_category_id)->select('id' , 'image' , 'title_en as title')->get()->toArray();
                $data['sub_category_level1'] = SubCategory::where('id', $request->sub_category_id)->select('id', 'title_en as title', 'category_id')->first();
                $data['sub_category_array'] = SubCategory::where('category_id', $data['sub_category_level1']['category_id'])->select('id', 'title_en as title', 'category_id')->get()->makeHidden('category_id');
                $data['category'] = Category::where('id', $data['sub_category_level1']['category_id'])->select('id', 'title_en as title')->first();
            }else {
                $subCategories = SubCategory::where('category_id', $request->category_id)->pluck('id')->toArray();
                $data['sub_categories'] = SubTwoCategory::where('deleted' , 0)->whereIn('sub_category_id', $subCategories)->select('id' , 'image' , 'title_en as title')->get()->toArray();
                $data['sub_category_level1'] = (object)[
                    "id" => 0,
                    "title" => "All",
                    "category_id" => $request->category_id
                ];
                $data['sub_category_array'] = SubCategory::where('category_id', $request->category_id)->select('id', 'title_en as title', 'category_id')->get()->makeHidden('category_id');
                $data['category'] = Category::where('id', $request->category_id)->select('id', 'title_en as title')->first();
            }
        }else{
            if ($request->sub_category_id != 0) {
                $data['sub_categories'] = SubTwoCategory::where('deleted' , 0)->where('sub_category_id' , $request->sub_category_id)->select('id' , 'image' , 'title_ar as title')->get()->toArray();
                $data['sub_category_level1'] = SubCategory::where('id', $request->sub_category_id)->select('id', 'title_ar as title', 'category_id')->first();
                $data['sub_category_array'] = SubCategory::where('category_id', $data['sub_category_level1']['category_id'])->select('id', 'title_ar as title', 'category_id')->get()->makeHidden('category_id');
                $data['category'] = Category::where('id', $data['sub_category_level1']['category_id'])->select('id', 'title_ar as title')->first();
            }else {
                $subCategories = SubCategory::where('category_id', $request->category_id)->pluck('id')->toArray();
                $data['sub_categories'] = SubTwoCategory::where('deleted' , 0)->whereIn('sub_category_id', $subCategories)->select('id' , 'image' , 'title_ar as title')->get()->toArray();
                $data['sub_category_level1'] = (object)[
                    "id" => 0,
                    "title" => "All",
                    "category_id" => $request->category_id
                ];
                $data['sub_category_array'] = SubCategory::where('category_id', $request->category_id)->select('id', 'title_ar as title', 'category_id')->get()->makeHidden('category_id');
                $data['category'] = Category::where('id', $request->category_id)->select('id', 'title_ar as title')->first();
            }
        }



        for ($n =0; $n < count($data['sub_category_array']); $n ++) {
            if ($data['sub_category_array'][$n]['id'] == $request->sub_category_id) {
                $data['sub_category_array'][$n]['selected'] = true;
            }else {
                $data['sub_category_array'][$n]['selected'] = false;
            }
        }
        $all = new \StdClass;
        $all->id = 0;
        $all->title = 'All';
        $all->image = 'all_liwbsi.png';
        $all->next_level = false;
// dd($data['sub_categories']);
        if (count($data['sub_categories']) > 0) {
            for ($i =0; $i < count($data['sub_categories']); $i ++) {
                $subThreeCats = SubThreeCategory::where('sub_category_id', $data['sub_categories'][$i]['id'])->select('id')->first();
                $data['sub_categories'][$i]['next_level'] = false;

                if (isset($subThreeCats['id'])) {
                    $data['sub_categories'][$i]['next_level'] = true;
                }
            }
        }
        
        array_unshift($data['sub_categories'], $all);

        if($request->sub_category_id == 0){
            $products = AdProduct::where('status' , 1)->where('country_id', $request->country)->where('category_id', $request->category_id)->select('id' , 'title' , 'price'  , 'publication_date as date', 'selected as feature')->orderBy('publication_date' , 'DESC')->simplePaginate(12);

         }else{
            $products = AdProduct::where('status' , 1)->where('country_id', $request->country)->where('sub_category_id' , $request->sub_category_id)->select('id' , 'title' , 'price'  , 'publication_date as date', 'selected as feature')->orderBy('publication_date' , 'DESC')->simplePaginate(12);

         }  

         for($i = 0; $i < count($products); $i++){
            $date = date_create($products[$i]['date']);
            $products[$i]['date'] = date_format($date , 'd M Y');
            $proPrice = $products[$i]['price'] * $currency['value'];
            $products[$i]['price'] = number_format((float)$proPrice, 3, '.', '');
            $adImage = AdProductImage::where('product_id' , $products[$i]['id'])->first();
            if ($adImage) {
                $products[$i]['image'] = $adImage['image'];
            }else {
                $products[$i]['image'] = "";
            }
            
            $user = auth()->user();
            if($user){
                $favorite = Favorite::where('user_id' , $user->id)->where('product_id' , $products[$i]['id'])->where('product_type', 2)->first();
                if($favorite){
                    $products[$i]['favorite'] = true;
                }else{
                    $products[$i]['favorite'] = false;
                }
            }else{
                $products[$i]['favorite'] = false;
            }
        }

        $data['products'] = $products;
    

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }

    public function get_sub_categories_level3(Request $request){
        $validator = Validator::make($request->all() , [
            'country' => 'required',
            'category_id' => 'required'
        ]);

        if($validator->fails() && !isset($request->sub_category_level1_id)) {
            $response = APIHelpers::createApiResponse(true , 406 ,  'بعض الحقول مفقودة' ,  'بعض الحقول مفقودة' , null , $request->lang );
            return response()->json($response , 406);
        }
        $country = Country::where('id', $request->country)->select('id', 'currency')->first();
        $fromCurr = trim(strtolower($country['currency']));
        $toCurr = trim(strtolower($request->curr));
        if ($fromCurr == $toCurr) {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', $fromCurr)->where('to', $toCurr)->first();
        }
        $subCategories = SubCategory::where('category_id', $request->category_id)->pluck('id')->toArray();
        $subCategoriesTwo = SubTwoCategory::where('deleted' , 0)->whereIn('sub_category_id', $subCategories)->pluck('id')->toArray();
        if($request->lang == 'en'){
            if ($request->sub_category_id != 0) {
                $data['sub_categories'] = SubThreeCategory::where('deleted' , 0)->where('sub_category_id' , $request->sub_category_id)->select('id' , 'image' , 'title_en as title')->get()->toArray();
                $data['sub_category_level2'] = SubTwoCategory::where('id', $request->sub_category_id)->select('id', 'title_en as title', 'sub_category_id')->first();
                if ($request->sub_category_level1_id != 0) {
                    $data['sub_category_array'] = SubTwoCategory::where('sub_category_id', $request->sub_category_level1_id)->select('id', 'title_en as title', 'sub_category_id')->get();
                }else {
                    $data['sub_category_array'] = SubTwoCategory::whereIn('sub_category_id', $subCategories)->select('id', 'title_en as title', 'sub_category_id')->get();
                }
                
                $data['category'] = Category::where('id', $request->category_id)->select('id', 'title_en as title')->first();
            }else {
                
                $data['sub_category_level2'] = (object)[
                    "id" => 0,
                    "title" => "All",
                    "sub_category_id" => $request->sub_category_level1_id
                ];
                if ($request->sub_category_level1_id != 0) {
                    $data['sub_category_array'] = SubTwoCategory::where('sub_category_id', $request->sub_category_level1_id)->select('id', 'title_en as title', 'sub_category_id')->get();
                }else {
                    $data['sub_category_array'] = SubTwoCategory::whereIn('sub_category_id', $subCategories)->select('id', 'title_en as title', 'sub_category_id')->get();
                }
                $data['sub_categories'] = SubThreeCategory::where('deleted' , 0)->whereIn('sub_category_id', $subCategoriesTwo)->select('id' , 'image' , 'title_en as title')->get()->toArray();
                
                $data['category'] = Category::where('id', $request->category_id)->select('id', 'title_en as title')->first();
            }
        }else{
            if ($request->sub_category_id != 0) {
                $data['sub_categories'] = SubThreeCategory::where('deleted' , 0)->where('sub_category_id' , $request->sub_category_id)->select('id' , 'image' , 'title_ar as title')->get()->toArray();
                $data['sub_category_level2'] = SubTwoCategory::where('id', $request->sub_category_id)->select('id', 'title_ar as title', 'sub_category_id')->first();
                if ($request->sub_category_level1_id != 0) {
                    $data['sub_category_array'] = SubTwoCategory::where('sub_category_id', $request->sub_category_level1_id)->select('id', 'title_ar as title', 'sub_category_id')->get();
                }else {
                    $data['sub_category_array'] = SubTwoCategory::whereIn('sub_category_id', $subCategories)->select('id', 'title_ar as title', 'sub_category_id')->get();
                }
                
                $data['category'] = Category::where('id', $request->category_id)->select('id', 'title_ar as title')->first();
            }else {
                
                $data['sub_category_level2'] = (object)[
                    "id" => 0,
                    "title" => "All",
                    "sub_category_id" => $request->sub_category_level1_id
                ];
                if ($request->sub_category_level1_id != 0) {
                    $data['sub_category_array'] = SubTwoCategory::where('sub_category_id', $request->sub_category_level1_id)->select('id', 'title_ar as title', 'sub_category_id')->get();
                }else {
                    $data['sub_category_array'] = SubTwoCategory::whereIn('sub_category_id', $subCategories)->select('id', 'title_ar as title', 'sub_category_id')->get();
                }
                $data['sub_categories'] = SubThreeCategory::where('deleted' , 0)->whereIn('sub_category_id', $subCategoriesTwo)->select('id' , 'image' , 'title_ar as title')->get()->toArray();
                
                $data['category'] = Category::where('id', $request->category_id)->select('id', 'title_ar as title')->first();
            }
        }

        for ($n =0; $n < count($data['sub_category_array']); $n ++) {
            if ($data['sub_category_array'][$n]['id'] == $request->sub_category_id) {
                $data['sub_category_array'][$n]['selected'] = true;
            }else {
                $data['sub_category_array'][$n]['selected'] = false;
            }
        }
        $all = new \StdClass;
        $all->id = 0;
        $all->title = 'All';
        $all->image = 'all_liwbsi.png';
        $all->next_level = false;

        if (count($data['sub_categories']) > 0) {
            for ($i =0; $i < count($data['sub_categories']); $i ++) {
                $subThreeCats = SubFourCategory::where('sub_category_id', $data['sub_categories'][$i]['id'])->select('id')->first();
                $data['sub_categories'][$i]['next_level'] = false;
                if (isset($subThreeCats['id'])) {
                    $data['sub_categories'][$i]['next_level'] = true;
                }
            }
        }
        
        array_unshift($data['sub_categories'], $all);
        $products = AdProduct::where('status' , 1)->where('country_id', $request->country)->where('category_id', $request->category_id)->select('id' , 'title' , 'price'  , 'publication_date as date', 'selected as feature');
        if($request->sub_category_id != 0){
            $products = $products->where('sub_category_two_id' , $request->sub_category_id);
         }

        if ($request->sub_category_level1_id != 0) {
            $products = $products->where('sub_category_id' , $request->sub_category_level1_id);
        }
        
        $products = $products->orderBy('publication_date' , 'DESC')->simplePaginate(12);
         

         for($i = 0; $i < count($products); $i++){
            $date = date_create($products[$i]['date']);
            $products[$i]['date'] = date_format($date , 'd M Y');
            $proPrice = $products[$i]['price'] * $currency['value'];
            $products[$i]['price'] = number_format((float)$proPrice, 3, '.', '');
            $products[$i]['image'] = AdProductImage::where('product_id' , $products[$i]['id'])->first()['image'];
            $user = auth()->user();
            if($user){
                $favorite = Favorite::where('user_id' , $user->id)->where('product_id' , $products[$i]['id'])->where('product_type', 2)->first();
                if($favorite){
                    $products[$i]['favorite'] = true;
                }else{
                    $products[$i]['favorite'] = false;
                }
            }else{
                $products[$i]['favorite'] = false;
            }
        }

        $data['products'] = $products;
    

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }

    public function get_sub_categories_level4(Request $request){
        $validator = Validator::make($request->all() , [
            'country' => 'required',
            'category_id' => 'required'
        ]);

        if($validator->fails() && !isset($request->sub_category_level2_id) && !isset($request->sub_category_level1_id)) {
            $response = APIHelpers::createApiResponse(true , 406 ,  'بعض الحقول مفقودة' ,  'بعض الحقول مفقودة' , null , $request->lang );
            return response()->json($response , 406);
        }

        $country = Country::where('id', $request->country)->select('id', 'currency')->first();
        $fromCurr = trim(strtolower($country['currency']));
        $toCurr = trim(strtolower($request->curr));
        if ($fromCurr == $toCurr) {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', $fromCurr)->where('to', $toCurr)->first();
        }
        if ($request->sub_category_level1_id == 0) {
            $subCategories = SubCategory::where('deleted' , 0)->where('category_id', $request->category_id)->pluck('id')->toArray();
            $subCategoriesTwo = SubTwoCategory::where('deleted' , 0)->whereIn('sub_category_id', $subCategories)->pluck('id')->toArray();
        }else {
            $subCategoriesTwo = SubTwoCategory::where('deleted' , 0)->where('sub_category_id', $request->sub_category_level1_id)->pluck('id')->toArray();
        }
        
        if ($request->sub_category_level2_id == 0) {
            $subCategoriesThree = SubThreeCategory::where('deleted' , 0)->whereIn('sub_category_id', $subCategoriesTwo)->pluck('id')->toArray();
        }else {
            $subCategoriesThree = SubThreeCategory::where('deleted' , 0)->where('sub_category_id', $request->sub_category_level2_id)->pluck('id')->toArray();
        }
        
        if($request->lang == 'en'){
            if ($request->sub_category_id != 0) {
                $data['sub_categories'] = SubFourCategory::where('deleted' , 0)->where('sub_category_id' , $request->sub_category_id)->select('id' , 'image' , 'title_en as title')->get()->toArray();
                $data['sub_category_level3'] = SubThreeCategory::where('id', $request->sub_category_id)->select('id', 'title_en as title', 'sub_category_id')->first();
                if ($request->sub_category_level2_id == 0) {
                    $data['sub_category_array'] = SubThreeCategory::where('deleted' , 0)->whereIn('sub_category_id', $subCategoriesTwo)->select('id', 'title_en as title', 'sub_category_id')->get();
                }else {
                    $data['sub_category_array'] = SubThreeCategory::where('deleted' , 0)->where('sub_category_id', $request->sub_category_level2_id)->select('id', 'title_en as title', 'sub_category_id')->get();
                }
                
                $data['category'] = Category::where('id', $request->category_id)->select('id', 'title_en as title')->first();
            }else {
                $data['sub_categories'] = SubFourCategory::where('deleted' , 0)->whereIn('sub_category_id' , $subCategoriesThree)->select('id' , 'image' , 'title_en as title')->get()->toArray();
                $data['sub_category_level3'] = (object)[
                    "id" => 0,
                    "title" => "All",
                    "sub_category_id" => $request->sub_category_level2_id
                ];
                if ($request->sub_category_level2_id == 0) {
                    $data['sub_category_array'] = SubThreeCategory::where('deleted' , 0)->whereIn('sub_category_id', $subCategoriesTwo)->select('id', 'title_en as title', 'sub_category_id')->get();
                }else {
                    $data['sub_category_array'] = SubThreeCategory::where('deleted' , 0)->where('sub_category_id', $request->sub_category_level2_id)->select('id', 'title_en as title', 'sub_category_id')->get();
                }
                
                $data['category'] = Category::where('id', $request->category_id)->select('id', 'title_en as title')->first();
            }
        }else{
            if ($request->sub_category_id != 0) {
                $data['sub_categories'] = SubFourCategory::where('deleted' , 0)->where('sub_category_id' , $request->sub_category_id)->select('id' , 'image' , 'title_ar as title')->get()->toArray();
                $data['sub_category_level3'] = SubThreeCategory::where('id', $request->sub_category_id)->select('id', 'title_ar as title', 'sub_category_id')->first();
                if ($request->sub_category_level2_id == 0) {
                    $data['sub_category_array'] = SubThreeCategory::where('deleted' , 0)->whereIn('sub_category_id', $subCategoriesTwo)->select('id', 'title_ar as title', 'sub_category_id')->get();
                }else {
                    $data['sub_category_array'] = SubThreeCategory::where('deleted' , 0)->where('sub_category_id', $request->sub_category_level2_id)->select('id', 'title_ar as title', 'sub_category_id')->get();
                }
                
                $data['category'] = Category::where('id', $request->category_id)->select('id', 'title_ar as title')->first();
            }else {
                $data['sub_categories'] = SubFourCategory::where('deleted' , 0)->whereIn('sub_category_id' , $subCategoriesThree)->select('id' , 'image' , 'title_ar as title')->get()->toArray();
                $data['sub_category_level3'] = (object)[
                    "id" => 0,
                    "title" => "All",
                    "sub_category_id" => $request->sub_category_level2_id
                ];
                if ($request->sub_category_level2_id == 0) {
                    $data['sub_category_array'] = SubThreeCategory::where('deleted' , 0)->whereIn('sub_category_id', $subCategoriesTwo)->select('id', 'title_ar as title', 'sub_category_id')->get();
                }else {
                    $data['sub_category_array'] = SubThreeCategory::where('deleted' , 0)->where('sub_category_id', $request->sub_category_level2_id)->select('id', 'title_ar as title', 'sub_category_id')->get();
                }
                
                $data['category'] = Category::where('id', $request->category_id)->select('id', 'title_ar as title')->first();
            }
        }

        for ($n =0; $n < count($data['sub_category_array']); $n ++) {
            if ($data['sub_category_array'][$n]['id'] == $request->sub_category_id) {
                $data['sub_category_array'][$n]['selected'] = true;
            }else {
                $data['sub_category_array'][$n]['selected'] = false;
            }
        }
        // $all = new \StdClass;
        // $all->id = 0;
        // $all->title = 'All';
        // $all->image = 'all_liwbsi.png';
        // $all->next_level = false;
// dd($data['sub_categories']);
        
        
        // array_unshift($data['sub_categories'], $all);
        $products = AdProduct::where('status' , 1)->where('country_id', $request->country);
        if($request->sub_category_id != 0){
            $products = $products->where('sub_category_three_id', $request->sub_category_id);

         }

         if ($request->sub_category_level2_id != 0) {
             $products = $products->where('sub_category_two_id' , $request->sub_category_level2_id);
         }

         if ($request->sub_category_level1_id != 0) {
            $products = $products->where('sub_category_id' , $request->sub_category_level1_id);
        }

        $products = $products->select('id' , 'title' , 'price'  , 'publication_date as date', 'selected as feature')->orderBy('publication_date' , 'DESC')->simplePaginate(12);

         for($i = 0; $i < count($products); $i++){
            $date = date_create($products[$i]['date']);
            $products[$i]['date'] = date_format($date , 'd M Y');
            $proPrice = $products[$i]['price'] * $currency['value'];
            $products[$i]['price'] = number_format((float)$proPrice, 3, '.', '');
            $products[$i]['image'] = AdProductImage::where('product_id' , $products[$i]['id'])->first()['image'];
            $user = auth()->user();
            if($user){
                $favorite = Favorite::where('user_id' , $user->id)->where('product_id' , $products[$i]['id'])->where('product_type', 2)->first();
                if($favorite){
                    $products[$i]['favorite'] = true;
                }else{
                    $products[$i]['favorite'] = false;
                }
            }else{
                $products[$i]['favorite'] = false;
            }
        }

        $data['products'] = $products;
    

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }

    // get category options
    public function getCategoryOptions(Request $request, Category $category) {
        if ($request->lang == 'en') {
            $data['options'] = CategoryOption::where('category_id', $category['id'])->where('deleted', 0)->select('id as option_id', 'title_en as title')->get();
            if (count($data['options']) > 0) {
                for ($i =0; $i < count($data['options']); $i ++) {
                    $data['options'][$i]['type'] = 'input';
                    $optionValues = CategoryOptionValue::where('option_id', $data['options'][$i]['option_id'])->select('id as value_id', 'value_en as value')->get();
                    if (count($optionValues) > 0) {
                        $data['options'][$i]['type'] = 'select';
                        $data['options'][$i]['values'] = $optionValues;
                    }
                }
            }
        }else {
            $data['options'] = CategoryOption::where('category_id', $category['id'])->where('deleted', 0)->select('id as option_id', 'title_ar as title')->get();
            if (count($data['options']) > 0) {
                for ($i =0; $i < count($data['options']); $i ++) {
                    $data['options'][$i]['type'] = 'input';
                    $optionValues = CategoryOptionValue::where('option_id', $data['options'][$i]['option_id'])->select('id as value_id', 'value_ar as value')->get();
                    if (count($optionValues) > 0) {
                        $data['options'][$i]['type'] = 'select';
                        $data['options'][$i]['values'] = $optionValues;
                    }
                }
            }
        }
        

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }
    
    public function getSubCatsForCreate(Request $request) {
        if($request->lang == 'en'){
            $data['sub_categories'] = SubCategory::where('deleted' , 0)->where('category_id' , $request->category_id)->select('id' , 'image' , 'title_en as title')->get()->toArray();
            $data['category'] = Category::select('id' , 'title_en as title')->find($request->category_id);
           
        }else{
            $data['sub_categories'] = SubCategory::where('deleted' , 0)->where('category_id' , $request->category_id)->select('id' , 'image' , 'title_ar as title')->get()->toArray();
            $data['category'] = Category::select('id' , 'title_ar as title')->find($request->category_id);
            
        }

        for ($i =0; $i < count($data['sub_categories']); $i ++) {
            $subTwoCats = SubTwoCategory::where('sub_category_id', $data['sub_categories'][$i]['id'])->select('id')->first();
            $data['sub_categories'][$i]['next_level'] = false;
            if (isset($subTwoCats['id'])) {
                $data['sub_categories'][$i]['next_level'] = true;
            }
        }


        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }

    public function getSubCatsLevel2ForCreate(Request $request) {
        if($request->lang == 'en'){
            $data['sub_categories'] = SubTwoCategory::where('deleted' , 0)->where('sub_category_id' , $request->sub_category_id)->select('id' , 'image' , 'title_en as title')->get()->toArray();
        }else{
            $data['sub_categories'] = SubTwoCategory::where('deleted' , 0)->where('sub_category_id' , $request->sub_category_id)->select('id' , 'image' , 'title_ar as title')->get()->toArray();
           
        }

        if (count($data['sub_categories']) > 0) {
            for ($i =0; $i < count($data['sub_categories']); $i ++) {
                $subThreeCats = SubThreeCategory::where('sub_category_id', $data['sub_categories'][$i]['id'])->select('id')->first();
                $data['sub_categories'][$i]['next_level'] = false;

                if (isset($subThreeCats['id'])) {
                    $data['sub_categories'][$i]['next_level'] = true;
                }
            }
        }

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }

    public function getSubCatsLevel3ForCreate(Request $request) {
        if($request->lang == 'en'){
            $data['sub_categories'] = SubThreeCategory::where('deleted' , 0)->where('sub_category_id' , $request->sub_category_id)->select('id' , 'image' , 'title_en as title')->get()->toArray();
        }else{
            $data['sub_categories'] = SubThreeCategory::where('deleted' , 0)->where('sub_category_id' , $request->sub_category_id)->select('id' , 'image' , 'title_ar as title')->get()->toArray();
           
        }

        if (count($data['sub_categories']) > 0) {
            for ($i =0; $i < count($data['sub_categories']); $i ++) {
                $subThreeCats = SubFourCategory::where('sub_category_id', $data['sub_categories'][$i]['id'])->select('id')->first();
                $data['sub_categories'][$i]['next_level'] = false;

                if (isset($subThreeCats['id'])) {
                    $data['sub_categories'][$i]['next_level'] = true;
                }
            }
        }

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }

    public function getSubCatsLevel4ForCreate(Request $request) {
        if($request->lang == 'en'){
            $data['sub_categories'] = SubFourCategory::where('deleted' , 0)->where('sub_category_id' , $request->sub_category_id)->select('id' , 'image' , 'title_en as title')->get()->toArray();
        }else{
            $data['sub_categories'] = SubFourCategory::where('deleted' , 0)->where('sub_category_id' , $request->sub_category_id)->select('id' , 'image' , 'title_ar as title')->get()->toArray();
           
        }

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }
	
	

}    