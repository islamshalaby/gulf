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
use Illuminate\Support\Facades\Session;
use App\Product;
use App\SubFourCarType;
use App\SubThreeCarType;

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
              'getCategoriesForCreate',
              'getSubCatsLevel2ForCreate',
              'getSubCatsLevel3ForCreate',
              'get_ecommerce_sub_car_type_level3',
              'get_ecommerce_sub_car_type_level4',
              'getSubCatsLevel4ForCreate' ]]);
    }

    public function getecommercecategories(Request $request){
  
        if($request->lang == 'en'){
            $data['categories'] = Category::where('deleted' , 0)->where('type' , 1)->has('products', '>', 0)->select('id' , 'title_en as title' , 'image')->get();   
        }else{
            $data['categories'] = Category::where('deleted' , 0)->where('type' , 1)->has('products', '>', 0)->select('id' , 'title_ar as title' , 'image')->get();   
        }
         

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }
	
	public function get_ecommerce_sub_categories(Request $request){

        if($request->lang == 'en'){
            $data['sub_categories'] = SubCategory::where('deleted' , 0)->where('category_id' , $request->category_id)->has('products', '>', 0)->select('id' , 'image' , 'title_en as title')->get()->toArray();
            $data['category'] = Category::select('id' , 'title_en as title')->find($request->category_id);
            // $all = new \StdClass;
            // $all->id = 0;
            // $all->title = 'All';
            // $all->image = 'all_liwbsi.png';
        }else{
            $data['sub_categories'] = SubCategory::where('deleted' , 0)->where('category_id' , $request->category_id)->has('products', '>', 0)->select('id' , 'image' , 'title_ar as title')->get()->toArray();
            $data['category'] = Category::select('id' , 'title_ar as title')->find($request->category_id);
            // $all = new \StdClass;
            // $all->id = 0;
            // $all->title = 'الكل';
            // $all->image = 'all_liwbsi.png';
        }

        // array_unshift($data['sub_categories'], $all);
        
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }

    public function get_car_types(Request $request){
        if($request->lang == 'en'){
            $data = CarType::select('id' ,'image' , 'title_en as title')->where('deleted' , 0)->has('products', '>', 0)->get()->toArray();
            
		}else{
            $data = CarType::select('id' ,'image' , 'title_ar as title')->where('deleted' , 0)->has('products', '>', 0)->get()->toArray();
            
        }
        $root_url = $request->root();
        if (count($data) > 0) {
            for ($m = 0; $m < count($data); $m ++) {
                if ($data[$m]['id'] != 0) {
                    $data[$m]['next_level'] = false;
                    $data[$m]['url'] = $root_url . '/api/ecommerce/products/' . $request->curr . '/' . $request->lang . '/v1?category_id=' . $data[$m]['id'] . '&type=0';
                    $subCarTypes = SubOneCarType::where('car_type_id', $data[$m]['id'])->get();
                    if (count($subCarTypes) > 0) {
                        $hasProducts = false;
                        for ($ms = 0; $ms < count($subCarTypes); $ms ++) {
                            if (count($subCarTypes[$ms]->products) > 0) {
                                $hasProducts = true;
                            }
                        }

                        if ($hasProducts) {
                            $data[$m]['next_level'] = true;
                            $data[$m]['url'] = $root_url . "/api/ecommerce/sub_car_types/level1/" . $data[$m]['id'] . "/" . $request->curr . "/" . $request->lang . "/v1";
                        }
                    }
                }else {
                    $data[$m]['next_level'] = true;
                    $data[$m]['url'] = "";
                }
                
            }
        }

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }


    public function get_ecommerce_sub_car_type_level1(Request $request){
        if ($request->car_type_id == 0) {
            $data = SubOneCarType::where('deleted' , 0)->select('id' , 'image' , 'title_' . $request->lang . ' as title', 'car_type_id')->has('products', '>', 0)->get()
            ->makeHidden(['subCategories', 'carType'])
            ->map(function ($cat) use ($request) {
                $cat->next_level = false;
                $root_url = $request->root();
                
                $cat->url = $root_url . '/api/ecommerce/products/' . $request->curr . '/' . $request->lang . '/v1?category_id=' . $cat->car_type_id . '&sub_car_type_id=' . $cat->id . '&type=0';
                if ($cat->subCategories && count($cat->subCategories) > 0) {
                    $hasProducts = false;
                    for ($i = 0; $i < count($cat->subCategories); $i ++) {
                        if (count($cat->subCategories[$i]->products) > 0) {
                            $hasProducts = true;
                        }
                    }
    
                    if ($hasProducts) {
                        $cat->next_level = true;
                        $cat->url = $root_url . "/api/ecommerce/sub_car_types/level2/" . $cat->id . "/" . $request->curr . "/" . $request->lang . "/v1?car_type_id=" . $cat->car_type_id . "&sub_car_type_id=" . $cat->id;
                    }
                    
                }
    
                return $cat;
            });
        }else {
            $data = SubOneCarType::where('deleted' , 0)->where('car_type_id' , $request->car_type_id)->has('products', '>', 0)->select('id' , 'image' , 'title_' . $request->lang . ' as title', 'car_type_id')->get()
            ->makeHidden(['subCategories', 'carType'])
            ->map(function ($cat) use ($request) {
                $cat->next_level = false;
                $root_url = $request->root();
                // dd($cat->car_type_id);
                $cat->url = $root_url . '/api/ecommerce/products/' . $request->curr . '/' . $request->lang . '/v1?category_id=' . $cat->car_type_id . '&sub_car_type_id=' . $cat->id . '&type=0';
                if ($cat->subCategories && count($cat->subCategories) > 0) {
                    $hasProducts = false;
                    for ($i = 0; $i < count($cat->subCategories); $i ++) {
                        if (count($cat->subCategories[$i]->products) > 0) {
                            $hasProducts = true;
                        }
                    }
    
                    if ($hasProducts) {
                        $cat->next_level = true;
                        $cat->url = $root_url . "/api/ecommerce/sub_car_types/level2/" . $cat->id . "/" . $request->curr . "/" . $request->lang . "/v1?car_type_id=" . $cat->car_type_id . "&sub_car_type_id=" . $cat->id;
                    }
                    
                }
    
                return $cat;
            });
        }

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }

    public function get_ecommerce_sub_car_type_level2(Request $request){
        
        $data['sub_car_types'] = SubTwoCarType::where('deleted' , 0)->where('sub_one_car_type_id' , $request->sub_car_type_id)->has('products', '>', 0)->select('id' , 'image' , 'title_en as title', 'sub_one_car_type_id')->get()->makeHidden(['subCategories', 'carType'])
        ->map(function ($cat) use ($request) {
            $cat->next_level = false;
            $root_url = $request->root();
            $cat->url = $root_url . '/api/ecommerce/products/' . $request->curr . '/' . $request->lang . '/v1?category_id=' . $cat->carType->car_type_id . '&sub_car_type_id=' . $cat->sub_one_car_type_id . '&sub_car_type2_id=' . $cat->id . '&type=0';
            if ($cat->subCategories && count($cat->subCategories) > 0) {
                $hasProducts = false;
                for ($i = 0; $i < count($cat->subCategories); $i ++) {
                    if (count($cat->subCategories[$i]->products) > 0) {
                        $hasProducts = true;
                    }
                }

                if ($hasProducts) {
                    $cat->next_level = true;
                    $cat->url = $root_url . "/api/ecommerce/sub_car_types/level3/" . $cat->id . "/" . $request->curr . "/" . $request->lang . "/v1?car_type_id=" . $cat->carType->car_type_id . "&sub_car_type_id=" . $cat->sub_one_car_type_id;
                }
                
            }

            return $cat;
        });
        

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }

    public function get_ecommerce_sub_car_type_level3(Request $request){
        
        $data['sub_car_types'] = SubThreeCarType::where('deleted' , 0)->where('sub_car_type_id' , $request->sub_car_type_id)->has('products', '>', 0)->select('id' , 'image' , 'title_en as title', 'sub_car_type_id')->get()->makeHidden(['subCategories', 'carType'])
        ->map(function ($cat) use ($request) {
            $cat->next_level = false;
            $root_url = $request->root();
            $cat->url = $root_url . '/api/ecommerce/products/' . $request->curr . '/' . $request->lang . '/v1?category_id=' . $cat->carType->carType->car_type_id . '&sub_car_type_id=' . $cat->carType->sub_one_car_type_id . '&sub_car_type2_id=' . $cat->sub_car_type_id . '&sub_car_type3_id=' . $cat->id . '&type=0';
            if ($cat->subCategories && count($cat->subCategories) > 0) {
                $hasProducts = false;
                for ($i = 0; $i < count($cat->subCategories); $i ++) {
                    if (count($cat->subCategories[$i]->products) > 0) {
                        $hasProducts = true;
                    }
                }

                if ($hasProducts) {
                    $cat->next_level = true;
                    $cat->url = $root_url . "/api/ecommerce/sub_car_types/level4/" . $cat->id . "/" . $request->curr . "/" . $request->lang . "/v1?car_type_id=" . $cat->sub_car_type_id;
                }
                
            }

            return $cat;
        });
        

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }

    public function get_ecommerce_sub_car_type_level4(Request $request){
        
        $data['sub_car_types'] = SubFourCarType::where('deleted' , 0)->where('sub_car_type_id' , $request->sub_car_type_id)->has('products', '>', 0)->select('id' , 'image' , 'title_en as title', 'sub_car_type_id')->get()->makeHidden(['subCategories', 'carType'])
        ->map(function ($cat) use ($request) {
            $cat->next_level = false;
            $root_url = $request->root();
            $cat->url = $root_url . '/api/ecommerce/products/' . $request->curr . '/' . $request->lang . '/v1?category_id=' . $cat->carType->carType->carType->car_type_id . '&sub_car_type_id=' . $cat->carType->carType->sub_one_car_type_id . '&sub_car_type2_id=' . $cat->carType->sub_car_type_id . '&sub_car_type3_id=' . $cat->sub_car_type_id . '&sub_car_type4_id=' . $cat->id . '&type=0';

            return $cat;
        });
        

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }

    // get ad categories
    public function getAdCategories(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'country' => 'required'
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة'  , null , $request->lang);
            return response()->json($response , 406);
        }
        Session::put('api_country',$request->country);

        $data['categories'] = Category::where('deleted' , 0)->has('adProducts', '>', 0)->where('type' , 2)->select('id' , 'title_' . $request->lang . ' as title' , 'image')->get()->makeHidden(['adProducts', 'subCategories'])
        ->map(function ($cat) use ($request) {
            $cat->next_level = false;
            $root_url = $request->root();
            $cat->url = $root_url . '/api/ad/products/' . $request->curr . '/' . $request->lang . '/v1?category_id=' . $cat->id;
            if ($cat->subCategories && count($cat->subCategories) > 0) {
                $hasProducts = false;
                for ($i = 0; $i < count($cat->subCategories); $i ++) {
                    if (count($cat->subCategories[$i]->adProducts) > 0) {
                        $hasProducts = true;
                    }
                }

                if ($hasProducts) {
                    $cat->next_level = true;
                    $cat->url = $root_url . "/api/ad/sub_categories/" . $request->curr . "/level1/" . $cat->id . "/" . $request->lang . "/v1?country=" . $request->country;
                }
                
            }

            return $cat;
        });   
        
         

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }

    // get ad subcategories
    public function getAdSubCategories(Request $request) {
        $validator = Validator::make($request->all(), [
            'country' => 'required'
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة'  , null , $request->lang);
            return response()->json($response , 406);
        }
        Session::put('api_country',$request->country);
        $data['sub_categories'] = SubCategory::where('deleted' , 0);
        if ($request->category_id != 0) {
            $data['sub_categories'] = $data['sub_categories']->where('category_id' , $request->category_id);
        }
        $data['sub_categories'] = $data['sub_categories']->has('adProducts', '>', 0)->select('id' , 'image' , 'title_' . $request->lang . ' as title', 'category_id')->get()->makeHidden(['adProducts', 'subCategories'])
        ->map(function ($cat) use ($request) {
            $cat->next_level = false;
            $root_url = $request->root();
            $cat->url = $root_url . '/api/ad/products/' . $request->curr . '/' . $request->lang . '/v1?category_id=' . $cat->category_id . '&sub_category_level1_id=' . $cat->id . "&country=" . $request->country;
            if ($cat->subCategories && count($cat->subCategories) > 0) {
                $hasProducts = false;
                for ($i = 0; $i < count($cat->subCategories); $i ++) {
                    if (count($cat->subCategories[$i]->adProducts) > 0) {
                        $hasProducts = true;
                    }
                }

                if ($hasProducts) {
                    $cat->next_level = true;
                    $cat->url = $root_url . "/api/ad/sub_categories/" . $request->curr . "/level2/" . $cat->id . "/" . $request->lang . "/v1?category_id=" . $cat->category_id . "&country=" . $request->country;
                }
            }

            return $cat;
        })->toArray();
        $all_sub_categories = SubTwoCategory::where('deleted', 0)->has('adProducts', '>', 0)->count();
        $all = new \StdClass;
        $all->id = 0;
        $all->title = 'All';

        
        $all->next_level = false;
        $all->url = $request->root() . '/api/ad/products/' . $request->curr . '/' . $request->lang . '/v1?category_id=' . $request->category_id . '&sub_category_level1_id=0&country=' . $request->country;
        

        if ($request->lang == 'ar') {
            $all->title = 'الكل';
        }

        $all->image = 'all_liwbsi.png';
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
        Session::put('api_country',$request->country);
        $data['sub_categories'] = SubTwoCategory::where('deleted' , 0);
        if ($request->sub_category_id != 0) {
            $data['sub_categories'] = $data['sub_categories']->where('sub_category_id' , $request->sub_category_id);
        }
        
        $data['sub_categories'] = $data['sub_categories']->has('adProducts', '>', 0)->select('id' , 'image' , 'title_en as title', 'sub_category_id')->get()->makeHidden(['adProducts', 'subCategories', 'category'])

        ->map(function ($cat) use ($request) {
            // dd($cat->category);
            $cat->next_level = false;
            $root_url = $request->root();
            $cat->url = $root_url . '/api/ad/products/' . $request->curr . '/' . $request->lang . '/v1?category_id=' . $cat->category->category_id . '&sub_category_level1_id=' . $cat->sub_category_id . '&sub_category_level2_id=' . $cat->id . "&country=" . $request->country;
            if ($cat->subCategories && count($cat->subCategories) > 0) {
                $hasProducts = false;
                for ($i = 0; $i < count($cat->subCategories); $i ++) {
                    if (count($cat->subCategories[$i]->adProducts) > 0) {
                        $hasProducts = true;
                    }
                }

                if ($hasProducts) {
                    $cat->next_level = true;
                    $cat->url = $root_url . "/api/ad/sub_categories/" . $request->curr . "/level3/" . $cat->id . "/" . $request->lang . "/v1?category_id=" . $cat->category->category_id . "&sub_category_level1_id=" . $cat->sub_category_id . "&country=" . $request->country;
                }
            }

            return $cat;
        })->toArray();

        $all_sub_categories = SubThreeCategory::where('deleted', 0)->has('adProducts', '>', 0)->count();
        $all = new \StdClass;
        $all->id = 0;
        $all->title = 'All';
        
        $all->next_level = false;
        $all->url = $request->root() . '/api/ad/products/' . $request->curr . '/' . $request->lang . '/v1?category_id=' . $request->category_id . '&sub_category_level1_id=' . $request->sub_category_id . '&sub_category_level2_id=0&country=' . $request->country;
        

        if ($request->lang == 'ar') {
            $all->title = 'الكل';
        }

        $all->image = 'all_liwbsi.png';
        array_unshift($data['sub_categories'], $all);

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
        Session::put('api_country',$request->country);
        $data['sub_categories'] = SubThreeCategory::where('deleted' , 0);
        if ($request->sub_category_id != 0) {
            $data['sub_categories'] = $data['sub_categories']->where('sub_category_id' , $request->sub_category_id);
        }
        
        $data['sub_categories'] = $data['sub_categories']->has('adProducts', '>', 0)->select('id' , 'image' , 'title_' . $request->lang . ' as title', 'sub_category_id')->get()->makeHidden(['adProducts', 'category', 'subCategories'])
        ->map(function ($cat) use ($request) {
            $cat->next_level = false;
            $root_url = $request->root();
            $cat->url = $root_url . '/api/ad/products/' . $request->curr . '/' . $request->lang . '/v1?category_id=' . $cat->category->category->category_id . '&sub_category_level1_id=' . $cat->category->sub_category_id . '&sub_category_level2_id=' . $cat->sub_category_id . '&sub_category_level3_id=' . $cat->id. "&country=" . $request->country;
            if ($cat->subCategories && count($cat->subCategories) > 0) {
                $hasProducts = false;
                for ($i = 0; $i < count($cat->subCategories); $i ++) {
                    if (count($cat->subCategories[$i]->adProducts) > 0) {
                        $hasProducts = true;
                    }
                }

                if ($hasProducts) {
                    $cat->next_level = true;
                    $cat->url = $root_url . "/api/ad/sub_categories/" . $request->curr . "/level4/" . $cat->id . "/" . $request->lang . "/v1?category_id=" . $cat->category->category->category_id . "&sub_category_level1_id=" . $cat->category->sub_category_id . "&sub_category_level2_id=" . $cat->sub_category_id . "&country=" . $request->country;
                }
            }

            return $cat;
        })->toArray();

        $all_sub_categories = SubFourCategory::where('deleted', 0)->has('adProducts', '>', 0)->count();
        $all = new \StdClass;
        $all->id = 0;
        $all->title = 'All';

        
        $all->next_level = false;
        $all->url = $request->root() . '/api/ad/products/' . $request->curr . '/' . $request->lang . '/v1?category_id=' . $request->category_id . '&sub_category_level1_id=' . $request->sub_category_level1_id . '&sub_category_level2_id=' . $request->sub_category_id . '&sub_category_level3_id=0&country=' . $request->country;
        

        if ($request->lang == 'ar') {
            $all->title = 'الكل';
        }

        $all->image = 'all_liwbsi.png';
        array_unshift($data['sub_categories'], $all);
    

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
        Session::put('api_country',$request->country);

        $data['sub_categories'] = SubFourCategory::where('deleted' , 0);

        if ($request->sub_category_id != 0) {
            $data['sub_categories'] = $data['sub_categories'] ->where('sub_category_id' , $request->sub_category_id);
        }
        
        $data['sub_categories'] = $data['sub_categories']->has('adProducts', '>', 0)->select('id' , 'image' , 'title_' . $request->lang . ' as title', 'sub_category_id')->get()->makeHidden(['adProducts', 'category'])
        ->map(function ($cat) use ($request) {
            $cat->next_level = false;
            $root_url = $request->root();
            $cat->url = $root_url . '/api/ad/products/' . $request->curr . '/' . $request->lang . '/v1?category_id=' . $cat->category->category->category->category_id . '&sub_category_level1_id=' . $cat->category->category->sub_category_id . '&sub_category_level2_id=' . $cat->category->sub_category_id . '&sub_category_level3_id=' . $cat->sub_category_id . '&sub_category_level4_id=' . $cat->id . '&country=' . $request->country;

            return $cat;
        })->toArray();

        $all = new \StdClass;
        $all->id = 0;
        $all->title = 'All';
        $all->next_level = false;
        $all->url = $request->root() . '/api/ad/products/' . $request->curr . '/' . $request->lang . '/v1?category_id=' . $request->category_id . '&sub_category_level1_id=' . $request->sub_category_level1_id . '&sub_category_level2_id=' . $request->sub_category_level2_id . '&sub_category_level3_id=' . $request->sub_category_level3_id . '&sub_category_level4_id=' . $request->sub_category_id . '&country=' . $request->country;
        

        if ($request->lang == 'ar') {
            $all->title = 'الكل';
        }

        $all->image = 'all_liwbsi.png';
        array_unshift($data['sub_categories'], $all);
    

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }

    // get category options
    public function getCategoryOptions(Request $request, $category, $type) {
        if ($request->lang == 'en') {
            $data['options'] = CategoryOption::where('category_id', $category)->where('deleted', 0)->where('category_type', $type)->select('id as option_id', 'title_en as title', 'is_required')->get();
            if (count($data['options']) > 0) {
                for ($i =0; $i < count($data['options']); $i ++) {
                    $data['options'][$i]['type'] = 'input';
                    $optionValues = CategoryOptionValue::where('option_id', $data['options'][$i]['option_id'])->where('deleted', 0)->select('id as value_id', 'value_en as value')->get();
                    if (count($optionValues) > 0) {
                        $data['options'][$i]['type'] = 'select';
                        $data['options'][$i]['values'] = $optionValues;
                    }
                }
            }
        }else {
            $data['options'] = CategoryOption::where('category_id', $category)->where('category_type', $type)->where('deleted', 0)->select('id as option_id', 'title_ar as title', 'is_required')->get();
            if (count($data['options']) > 0) {
                for ($i =0; $i < count($data['options']); $i ++) {
                    $data['options'][$i]['type'] = 'input';
                    $optionValues = CategoryOptionValue::where('option_id', $data['options'][$i]['option_id'])->where('deleted', 0)->select('id as value_id', 'value_ar as value')->get();
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

    public function getCategoriesForCreate(Request $request) {
        $data['category'] = Category::where('type', 2)->where('deleted', 0)->select('id' , 'title_' . $request->lang . ' as title', 'image')->orderBy('id', 'desc')->get()->makeHidden('subCategories')
        ->map(function ($row) {
            $row->next_level = false;
            if (count($row->subCategories) > 0) {
                $row->next_level = true;
            }

            return $row;
        });

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
            $subTwoCats = SubTwoCategory::where('sub_category_id', $data['sub_categories'][$i]['id'])->where('deleted', 0)->select('id')->first();
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
                $subThreeCats = SubThreeCategory::where('sub_category_id', $data['sub_categories'][$i]['id'])->where('deleted', 0)->select('id')->first();
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
                $subThreeCats = SubFourCategory::where('sub_category_id', $data['sub_categories'][$i]['id'])->where('deleted', 0)->select('id')->first();
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

    // get category Options
    
	
	

}    