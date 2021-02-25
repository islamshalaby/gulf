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
use App\Setting;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api' , ['except' => ['getdata' , 'getecommercehome' , 'getcurrencies', 'getAdData', 'getcurrencyByCountry']]);
    }

    public function getAdData(Request $request) {
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
                $result = APIHelpers::converCurruncy("oS-hVi-XUF5EKiaDtRhUbqkNmNfcLfu8q5Ad0I7IxcsVVpjUfOWe4", $fromCurr, $toCurr);
                if(isset($result->amount)){
					$currency->update(['value' => $result->amount, 'updated_at' => Carbon::now()]);
					$currency = Currency::where('from', $fromCurr)->where('to', $toCurr)->first();
				}
            }
        }else {
            $result = APIHelpers::converCurruncy("oS-hVi-XUF5EKiaDtRhUbqkNmNfcLfu8q5Ad0I7IxcsVVpjUfOWe4", $fromCurr, $toCurr);
            if(isset($result->amount) && $currency['value'] != 1){
				$currency = Currency::create(['value' => $result->amount, "from" => $fromCurr, "to" => $toCurr]);
			}
        }
        

        $data['slider'] = AdSlider::select('id', 'image', 'content', 'type', 'link_type')->where('country_id', $country['id'])->get();

        if ($request->lang == 'en') {
            $data['categories'] = Category::where('type', 2)->has('adProducts', '>' , 0)->select('id', 'title_en as title', 'image')->get();
        }else {
            $data['categories'] = Category::where('type', 2)->has('adProducts', '>' , 0)->select('id', 'title_ar as title', 'image')->get();
        }
        $data['feature_ads'] = AdProduct::where('country_id', $country['id'])->where('selected', 1)->select('id', 'title', 'price', 'publication_date as date', 'selected as feature')->orderBy('id', 'desc')->get()->makeHidden('mainImage');

        for($i = 0; $i < count($data['feature_ads']); $i ++) {
            $data['feature_ads'][$i]['image'] = $data['feature_ads'][$i]->mainImage['image'];
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
        $data['ad'] = Ad::select('image', 'type', 'content', 'place as link_type')->inRandomOrder()->first();
        $bestOffers = BestOffer::get();
        $data['best_offers'] = [];
        for ($n = 0; $n < count($bestOffers); $n ++) {
            $product = AdProduct::where('id', $bestOffers[$n]['product_id'])->select('id', 'title', 'price', 'publication_date as date', 'selected as feature')->first();
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
        if ($toCurr == "kwd") {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', "kwd")->where('to', $toCurr)->first();
        }
        
        
        if (isset($currency['id'])) {
            if (!$currency->updated_at->isToday()) {
                $result = APIHelpers::converCurruncy("oS-hVi-XUF5EKiaDtRhUbqkNmNfcLfu8q5Ad0I7IxcsVVpjUfOWe4", "kwd", $toCurr);
                if(isset($result->amount)){
					$currency->update(['value' => $result->amount, 'updated_at' => Carbon::now()]);
					$currency = Currency::where('from', "kwd")->where('to', $toCurr)->first();
				}
                
            }
            
        }else {
            $result = APIHelpers::converCurruncy("oS-hVi-XUF5EKiaDtRhUbqkNmNfcLfu8q5Ad0I7IxcsVVpjUfOWe4", "kwd", $toCurr);
            if(isset($result->amount) && $currency['value'] != 1){
				$currency = Currency::create(['value' => $result->amount, "from" => "kwd", "to" => $toCurr]);
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
                
                $element['data'] = Ad::select('id' ,'image' , 'type' , 'content')->whereIn('id' , $ids)->get();

                array_push($data , $element);

            }elseif($home_data[$i]['type'] == 2){
				
                if($request->lang == 'en'){
                $element['data'] = CarType::select('id' ,'image' , 'title_en as title')->where('deleted' , 0)->whereIn('id' , $ids)->has('products', '>', 0)->limit(5)->get()->toArray();
                    $all = [];
                    $all['id'] = 0;
                    $all['title'] = "All";
                    $all['image'] = "all_liwbsi.png";
					
                }else{
                    $element['data'] = CarType::select('id' ,'image' , 'title_ar as title')->where('deleted' , 0)->whereIn('id' , $ids)->has('products', '>', 0)->limit(5)->get()->toArray();
                    $all = [];
                    $all['id'] = 0;
                    $all['title'] = "الكل";
                    $all['image'] = "all_liwbsi.png";

                }

                array_unshift($element['data'], $all);
				

                for($j = 0; $j < count($element['data']); $j++){
                    if($element['data'][$j]['id'] == 0){
                        if($request->lang == 'en'){
                            $element['data'][$j]['sub_car_types'] = SubOneCarType::select('id' ,'image' , 'title_en as title')->where('deleted' , 0)->has('products', '>', 0)->get();
                        }else{
                            $element['data'][$j]['sub_car_types'] = SubOneCarType::select('id' ,'image' , 'title_ar as title')->where('deleted' , 0)->has('products', '>', 0)->get();
    
                        }
                    }else{
                        if($request->lang == 'en'){
                            $element['data'][$j]['sub_car_types'] = SubOneCarType::select('id' ,'image' , 'title_en as title')->where('deleted' , 0)->where('car_type_id' , $element['data'][$j]['id'])->has('products', '>', 0)->get();
                        }else{
                            $element['data'][$j]['sub_car_types'] = SubOneCarType::select('id' ,'image' , 'title_ar as title')->where('deleted' , 0)->where('car_type_id' , $element['data'][$j]['id'])->has('products', '>', 0)->get();
    
                        }
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
                    $element['data'] = Product::select('id', 'title_en as title' , 'final_price' , 'price_before_offer' , 'offer' , 'offer_percentage'  , 'type' )->where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0)->whereIn('id' , $ids)->limit(5)->get();
                }else{
                    $element['data'] = Product::select('id', 'title_ar as title' , 'final_price' , 'price_before_offer' , 'offer' , 'offer_percentage'  , 'type' )->where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0)->whereIn('id' , $ids)->limit(5)->get();
                }
                
                for($j = 0; $j < count($element['data']) ; $j++){
                    if($request->curr != 'kwd'){
                        $final = $element['data'][$j]['final_price'] * $currency['value'];
                        $priceBefore = $element['data'][$j]['price_before_offer'] * $currency['value'];
                        $element['data'][$j]['final_price'] = number_format((float)$final, 3, '.', '');
                        $element['data'][$j]['price_before_offer'] = number_format((float)$priceBefore, 2, '.', '');
                    }

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

                $element['data'] = Ad::select('id' ,'image' , 'type' , 'content')->whereIn('id' , $ids)->get();

                array_push($data , $element);

            }elseif($home_data[$i]['type'] == 6){
                $element['data'] = [];
                array_push($data , $element);
            }
        }
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);


    }
	
	public function getcurrencies(Request $request){
        if ($request->lang == 'en') {
            $data = Country::where('deleted', 0)->select('id', 'name_en as title', 'flag as image', 'currency as symbol', 'currency')->get();
        }else {
            $data = Country::where('deleted', 0)->select('id', 'name_ar as title', 'flag as image', 'currency as symbol', 'currency_ar as currency')->get();
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

    

}
