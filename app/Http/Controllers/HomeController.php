<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Helpers\APIHelpers;
use App\HomeElement;
use App\HomeSection;
use App\Company;
use App\CarType;
use App\SubOneCarType;
use App\Product;
use App\ProductImage;
use App\Favorite;
use App\Ad;
use App\HomeAd;
use Carbon\Carbon;
use App\AdProduct;
use App\Country;
use App\Currency;
use App\AdSlider;
use App\Category;
use App\BestOffer;
use App\Cart;
use App\Setting;
use App\Visitor;
use App\SubCategory;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api' , ['except' => ['getdata' , 'getecommercehome' , 'getcurrencies', 'getAdData', 'getcurrencyByCountry', 'getHomeLogos']]);
    }

    public function getAdData(Request $request) {
        $expired = \DB::table('ad_products')->whereDate('expiry_date', '<', Carbon::now())->get();
        $notFeature = \DB::table('ad_products')->whereDate('expiry_feature', '<', Carbon::now())->where('selected', 1)->get();
        $notPin = \DB::table('ad_products')->whereDate('expire_pin_date', '<', Carbon::now())->where('pin', 1)->get();
		
        if (count($expired) > 0) {
            for($i = 0; $i < count($expired); $i++){
                $product = AdProduct::find($expired[$i]->id);
                $product->status = 2;
                $product->save();
            }
        }
        
        if (count($notFeature) > 0) {
            for($i = 0; $i < count($notFeature); $i++){
                $product = AdProduct::find($notFeature[$i]->id);
                $product->selected = 0;
                $product->save();
            }
        }

        if (count($notPin) > 0) {
            for($i = 0; $i < count($notPin); $i++){
                $product = AdProduct::find($notPin[$i]->id);
                $product->pin = 0;
                $product->save();
            }
        }
		
        $country = Country::where('id', $request->country)->select('id', 'currency')->first();
        $fromCurr = trim(strtolower($country['currency']));
        $toCurr = trim(strtolower($request->curr));
        if ($fromCurr == $toCurr) {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', $fromCurr)->where('to', $toCurr)->first();
        }
        
        if (isset($currency['id'])) {
            if (!$currency->updated_at->isToday()) {
                $result = APIHelpers::converCurruncy2("4ab95df1bf98d41d1c3bfb0e", $fromCurr, $toCurr);
                if(isset($result['value'])){
					$currency->update(['value' => $result['value'], 'updated_at' => Carbon::now()]);
					$currency = Currency::where('from', $fromCurr)->where('to', $toCurr)->first();
				}
            }
        }else {
            if ($fromCurr != $toCurr) {
                $result = APIHelpers::converCurruncy2("4ab95df1bf98d41d1c3bfb0e", $fromCurr, $toCurr);
                $currency = Currency::create(['value' => $result['value'], "from" => $fromCurr, "to" => $toCurr]);
            }
            
        }
        
// dd($currency);
        $data['slider'] = AdSlider::select('id', 'image', 'content', 'type', 'link_type')->where('country_id', $country['id'])->get();

        Session::put('api_country',$request->country);

        $data['categories'] = Category::where('deleted' , 0)->has('adProducts', '>', 0)->where('type' , 2)->select('id' , 'title_' . $request->lang . ' as title' , 'image')->get()->makeHidden(['adProducts', 'subCategories'])
        ->map(function ($cat) use ($request) {
            $cat->next_level = false;
            $root_url = $request->root();
            $cat->url = $root_url . '/api/ad/products/' . $request->curr . '/en/v1?category_id=' . $cat->id;
            if ($cat->subCategories && count($cat->subCategories) > 0) {
                $hasProducts = false;
                for ($i = 0; $i < count($cat->subCategories); $i ++) {
                    if (count($cat->subCategories[$i]->adProducts) > 0) {
                        $hasProducts = true;
                    }
                }

                if ($hasProducts) {
                    $cat->next_level = true;
                    $cat->url = $root_url . "/api/ad/sub_categories/" . $request->curr . "/level1/" . $cat->id . "/en/v1?country=" . $request->country;
                }
                
            }

            return $cat;
        })->toArray();
        $all_sub_categories = SubCategory::where('deleted', 0)->has('adProducts', '>', 0)->count();
        $all = new \StdClass;
        $all->id = 0;
        $all->title = 'All';

        if ($all_sub_categories > 0) {
            $all->next_level = true;
            $all->url = $request->root() . "/api/ad/sub_categories/" . $request->curr . "/level1/0/en/v1?country=" . $request->country;
        }else {
            $all->next_level = false;
            $all->url = $request->root() . '/api/ad/products/' . $request->curr . '/' . $request->lang . '/v1?category_id=0&sub_category_level1_id=0&sub_category_level2_id=0&sub_category_level3_id=0&sub_category_level4_id=0&country=' . $request->country;
        }

        if ($request->lang == 'ar') {
            $all->title = 'الكل';
        }
        $all->image = 'all_liwbsi.png';
        array_unshift($data['categories'], $all);
        $data['feature_ads'] = AdProduct::where('deleted', 0)->where('country_id', $country['id'])->where('selected', 1)->where('status', 1)->select('id', 'title', 'price', 'publication_date as date', 'selected as feature', 'year')->orderBy('id', 'desc')->get()->makeHidden('mainImage');

        for($i = 0; $i < count($data['feature_ads']); $i ++) {
            $data['feature_ads'][$i]['image'] = "";
            if (isset($data['feature_ads'][$i]->mainImage)) {
                $data['feature_ads'][$i]['image'] = $data['feature_ads'][$i]->mainImage['image'];
            }
            $featureAdsPrice = $data['feature_ads'][$i]['price'] * $currency['value'];
            $data['feature_ads'][$i]['price'] = number_format((float)$featureAdsPrice, 3, '.', '');
            $data['feature_ads'][$i]['date'] = date_format(date_create($data['feature_ads'][$i]['date']) , "d-m-Y");
            $data['feature_ads'][$i]['time'] = date_format(date_create($data['feature_ads'][$i]['date']) , "h:i:s");
            if(auth()->user()){
                $user_id = auth()->user()->id;
                $prevfavorite = Favorite::where('product_id' , $data['feature_ads'][$i]['id'])->where('user_id' , $user_id)->first();
                if($prevfavorite){
                    $data['feature_ads'][$i]['favorite'] = true;
                }else{
                    $data['feature_ads'][$i]['favorite'] = false;
                }

            }else{
                $data['feature_ads'][$i]['favorite'] = false;
            }
        }
        $data['store_image'] = Setting::where('id', 1)->select('store_image')->first()['store_image'];
        $data['ad'] = Ad::select('image', 'type', 'content', 'product_type as link_type')->inRandomOrder()->first();
        $bestOffers = BestOffer::get();
        $data['best_offers'] = [];
        for ($n = 0; $n < count($bestOffers); $n ++) {
            $product = AdProduct::where('deleted', 0)->where('country_id', $country['id'])->where('id', $bestOffers[$n]['product_id'])->where('status', 1)->select('id', 'title', 'price', 'publication_date as date', 'selected as feature', 'year')->first();
            if ($product) {
                $product->makeHidden('mainImage');
                $product['date'] = date_format(date_create($product['date']) , "d-m-Y");
                $bestOfferPrice = $product['price'] * $currency['value'];
                $product['price'] = number_format((float)$bestOfferPrice, 3, '.', '');
                $product['time'] = date_format(date_create($product['date']) , "h:i:s");
                if(isset($product->mainImage['image'])) {
                    $product['image'] = $product->mainImage['image'];
                }else {
                    $product['image'] = '';
                }
                
                if(auth()->user()){
                    $user_id = auth()->user()->id;
                    $prevfavorite = Favorite::where('product_id' , $product['id'])->where('user_id' , $user_id)->first();
                    if($prevfavorite){
                        $product['favorite'] = true;
                    }else{
                        $product['favorite'] = false;
                    }

                }else{
                    $product['favorite'] = false;
                }
                array_push($data['best_offers'], $product);
            }
            
            
        }

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }

    public function getdata(Request $request){

        $expired = \DB::table('ad_products')->whereDate('expiry_date', '<', Carbon::now())->get();
		
		for($i = 0; $i < count($expired); $i++){
			$product = AdProduct::find($expired[$i]->id);
			$product->status = 2;
			$product->save();
		}


        $data['ads'] = HomeAd::get();
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }

    public function getecommercehome(Request $request){
        $toCurr = trim(strtolower($request->curr));
        $currency = Currency::where('from', "kwd")->where('to', $toCurr)->first();
        
        // $result = APIHelpers::converCurruncy2("4ab95df1bf98d41d1c3bfb0e", "kwd", $toCurr);
        // dd($result->value);
        if (isset($currency['id'])) {
            if (!$currency->updated_at->isToday()) {
                $result = APIHelpers::converCurruncy2("4ab95df1bf98d41d1c3bfb0e", "kwd", $toCurr);
                if(isset($result['value'])){
					$currency->update(['value' => $result['value'], 'updated_at' => Carbon::now()]);
					$currency = Currency::where('from', "kwd")->where('to', $toCurr)->first();
				}
                
            }
            
        }else {
            $result = APIHelpers::converCurruncy2("4ab95df1bf98d41d1c3bfb0e", "kwd", $toCurr);
            $currency = Currency::create(['value' => $result['value'], "from" => "kwd", "to" => $toCurr]);
            
        }
        if ($request->unique_id && $request->country) {
            $visitor = Visitor::where('unique_id', $request->unique_id)->first();
            // dd($visitor);
            if ($visitor) {
                if ($request->country != $visitor->country_id) {
                    $cart = Cart::where('visitor_id', $visitor->id)->get();
                    if (count($cart) > 0) {
                        for ($i = 0; $i < count($cart); $i ++) {
                            $cart[$i]->delete();
                        }
                    }
                }
                $visitor->update(['country_id' => $request->country]);
            }

        }
        $home_data = HomeSection::where('section_type', 1)->orderBy('sort' , 'Asc')->get();
        
        $data = [];
        for($i = 0; $i < count($home_data); $i++){
            $element = [];
			$element['id'] = $home_data[$i]['id'];
            $element['type'] = $home_data[$i]['type'];
            if($request->lang == 'en'){
                $element['title'] = $home_data[$i]['title_en'];
            }else{
                $element['title'] = $home_data[$i]['title_ar'];
            }
            $ids = HomeElement::where('home_id' , $home_data[$i]['id'])->pluck('element_id');
            
            if($home_data[$i]['type'] == 1){
                
                $element['data'] = Ad::select('id' ,'image' , 'type' , 'content', 'product_type as link_type')->whereIn('id' , $ids)->get();

                array_push($data , $element);

            }elseif($home_data[$i]['type'] == 2){
				
                if($request->lang == 'en'){
                    $element['data'] = CarType::select('id' ,'image' , 'title_en as title')->where('deleted' , 0)->whereIn('id' , $ids)->has('products', '>', 0)->get()->toArray();
                    // $all = [];
                    // $all['id'] = 0;
                    // $all['title'] = "All";
                    // $all['image'] = "all_liwbsi.png";
					
                }else{
                    $element['data'] = CarType::select('id' ,'image' , 'title_ar as title')->where('deleted' , 0)->whereIn('id' , $ids)->has('products', '>', 0)->get()->toArray();
                    // $all = [];
                    // $all['id'] = 0;
                    // $all['title'] = "الكل";
                    // $all['image'] = "all_liwbsi.png";

                }

                // array_unshift($element['data'], $all);
                $root_url = $request->root();
                if (count($element['data']) > 0) {
                    for ($m = 0; $m < count($element['data']); $m ++) {
                        if ($element['data'][$m]['id'] != 0) {
                            $element['data'][$m]['next_level'] = false;
                            $element['data'][$m]['url'] = $root_url . '/api/ecommerce/products/' . $request->curr . '/en/v1?category_id=' . $element['data'][$m]['id'] . '&type=0';
                            $subCarTypes = SubOneCarType::where('car_type_id', $element['data'][$m]['id'])->get();
                            if (count($subCarTypes) > 0) {
                                $hasProducts = false;
                                for ($ms = 0; $ms < count($subCarTypes); $ms ++) {
                                    if (count($subCarTypes[$ms]->products) > 0) {
                                        $hasProducts = true;
                                    }
                                }
    
                                if ($hasProducts) {
                                    $element['data'][$m]['next_level'] = true;
                                    $element['data'][$m]['url'] = "";
                                }
                            }
                        }else {
                            $element['data'][$m]['next_level'] = true;
                            $element['data'][$m]['url'] = "";
                        }
                        
                    }
                }
				

                for($j = 0; $j < count($element['data']); $j++){
                    if($element['data'][$j]['id'] == 0){
                        $element['data'][$j]['sub_car_types'] = SubOneCarType::select('id' ,'image' , 'title_' . $request->lang . ' as title', 'car_type_id')->where('deleted' , 0)->has('products', '>', 0)->get()->makeHidden('subCategories')
                        ->map(function ($cat) use ($request) {
                            $cat->next_level = false;
                            $root_url = $request->root();
                            $cat->url = $root_url . '/api/ecommerce/products/' . $request->curr . '/en/v1?category_id=' . $cat->car_type_id . '&sub_car_type_id=' . $cat->id;
                            if ($cat->subCategories && count($cat->subCategories) > 0) {
                                $hasProducts = false;
                                for ($i = 0; $i < count($cat->subCategories); $i ++) {
                                    if (count($cat->subCategories[$i]->products) > 0) {
                                        $hasProducts = true;
                                    }
                                }
                
                                if ($hasProducts) {
                                    $cat->next_level = true;
                                    $cat->url = $root_url . "/api/ecommerce/sub_car_types/level2/" . $cat->id . "/" . $request->curr . "/en/v1?car_type_id=" . $cat->car_type_id;
                                }
                                
                            }
                
                            return $cat;
                        });
                        
                    }else{
                        $element['data'][$j]['sub_car_types'] = SubOneCarType::select('id' ,'image' , 'title_' . $request->lang . ' as title', 'car_type_id')->where('deleted' , 0)->where('car_type_id' , $element['data'][$j]['id'])->has('products', '>', 0)->get()->makeHidden('subCategories')
                        ->map(function ($cat) use ($request) {
                            $cat->next_level = false;
                            $root_url = $request->root();
                            $cat->url = $root_url . '/api/ecommerce/products/' . $request->curr . '/en/v1?category_id=' . $cat->car_type_id . '&sub_car_type_id=' . $cat->id;
                            if ($cat->subCategories && count($cat->subCategories) > 0) {
                                $hasProducts = false;
                                for ($i = 0; $i < count($cat->subCategories); $i ++) {
                                    if (count($cat->subCategories[$i]->products) > 0) {
                                        $hasProducts = true;
                                    }
                                }
                
                                if ($hasProducts) {
                                    $cat->next_level = true;
                                    $cat->url = $root_url . "/api/ecommerce/sub_car_types/level2/" . $cat->id . "/" . $request->curr . "/en/v1?car_type_id=" . $cat->car_type_id;
                                }
                                
                            }
                
                            return $cat;
                        });
                        
                    }
                }

                array_push($data , $element);

            }elseif($home_data[$i]['type'] == 3){

                if($request->lang == 'en'){
                    $element['data'] = Company::select('id' ,'image' , 'title_en as title')->where('deleted' , 0)->whereIn('id' , $ids)->limit(5)->get();
                }else{
                    $element['data'] = Company::select('id' ,'image' , 'title_ar as title')->where('deleted' , 0)->whereIn('id' , $ids)->limit(5)->get(); 
                }                

                array_push($data , $element);

            }elseif($home_data[$i]['type'] == 4){
                if($request->lang == 'en'){
                    $element['data'] = Product::select('id', 'title_en as title' , 'final_price' , 'price_before_offer' , 'offer' , 'offer_percentage'  , 'type', 'year' )->where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0)->whereIn('id' , $ids)->limit(5)->get();
                }else{
                    $element['data'] = Product::select('id', 'title_ar as title' , 'final_price' , 'price_before_offer' , 'offer' , 'offer_percentage'  , 'type', 'year' )->where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0)->whereIn('id' , $ids)->limit(5)->get();
                }
                
                for($j = 0; $j < count($element['data']) ; $j++){
                    $final = $element['data'][$j]['final_price'] * $currency['value'];
                    $priceBefore = $element['data'][$j]['price_before_offer'] * $currency['value'];
                    $element['data'][$j]['final_price'] = number_format((float)$final, 3, '.', '');
                    $element['data'][$j]['price_before_offer'] = number_format((float)$priceBefore, 3, '.', '');

                    if(auth()->user()){
                        $user_id = auth()->user()->id;

                        $prevfavorite = Favorite::where('product_id' , $element['data'][$j]['id'])->where('user_id' , $user_id)->first();
                        if($prevfavorite){
                            $element['data'][$j]['favorite'] = true;
                        }else{
                            $element['data'][$j]['favorite'] = false;
                        }

                    }else{
                        $element['data'][$j]['favorite'] = false;
                    }

                    $element['data'][$j]['image'] = ProductImage::where('product_id' , $element['data'][$j]['id'])->pluck('image')->first();
                }

                array_push($data , $element);

            }elseif($home_data[$i]['type'] == 5){

                $element['data'] = Ad::select('id' ,'image' , 'type' , 'content', 'product_type as link_type')->whereIn('id' , $ids)->get();

                array_push($data , $element);

            }elseif($home_data[$i]['type'] == 6){
                $element['data'] = [];
                array_push($data , $element);
            }elseif($home_data[$i]['type'] == 7){
                $banner = Setting::where('id', 1)->select('vehicle_banner')->first();
                $item = (object)['image' => $banner->vehicle_banner];
                $element['data'] = [
                    $item
                ];
                array_push($data , $element);
            }
        }
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);


    }
	
	public function getcurrencies(Request $request){
        if ($request->lang == 'en') {
            $data = Country::where('deleted', 0)->select('id', 'name_en as title', 'flag as image', 'currency as symbol', 'currency', 'currency_logo')->get();
        }else {
            $data = Country::where('deleted', 0)->select('id', 'name_ar as title', 'flag as image', 'currency as symbol', 'currency_ar as currency', 'currency_logo')->get();
        }
		
		$response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }
    
    public function getcurrencyByCountry(Request $request, Country $country){
        if ($request->lang == 'en') {
            $data = $country->currency;
        }else {
            $data = $country->currency_ar;
        }
		
		$response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
	}

    // get home logos
    public function getHomeLogos(Request $request) {
        $settings = Setting::where('id', 1)->select('companies_logo', 'individual_logo')->first();
        $data['vehicle_logo'] = $settings->individual_logo;
        $data['spare_parts_logo'] = $settings->companies_logo;

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }

}
