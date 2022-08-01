<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login/{lang}/{v}', [ 'as' => 'login', 'uses' => 'AuthController@login'])->middleware('checkguest');
    Route::post('logout/{lang}/{v}', 'AuthController@logout');
    Route::post('refresh/{lang}/{v}', 'AuthController@refresh');
    Route::post('me/{lang}/{v}', 'AuthController@me');
    Route::post('register/{lang}/{v}' , [ 'as' => 'register', 'uses' => 'AuthController@register'])->middleware('checkguest');
    Route::post('verify/{lang}/{v}', 'AuthController@verifyAccount');
});

Route::get('/invalid/{lang}/{v}', [ 'as' => 'invalid', 'uses' => 'AuthController@invalid']);


// users apis group
Route::group([
    'middleware' => 'api',
    'prefix' => 'user'
], function($router) {
    Route::get('profile/{lang}/{v}' , 'UserController@getprofile');
    Route::put('profile/{lang}/{v}' , 'UserController@updateprofile');
    Route::put('upload-image/{lang}/{v}' , 'UserController@uploadProfileIamge');
    Route::put('resetpassword/{lang}/{v}' , 'UserController@resetpassword');
    Route::put('resetpassword-byemail/{lang}/{v}' , 'AuthController@resetforgettenpasswordByEmail')->middleware('checkguest');
    Route::post('check-verfication-code/{lang}/{v}' , 'AuthController@checkVerficationCode')->middleware('checkguest');
    Route::put('resetforgettenpassword/{lang}/{v}' , 'UserController@resetforgettenpassword')->middleware('checkguest');
    Route::post('checkphoneexistance/{lang}/{v}' , 'UserController@checkphoneexistance')->middleware('checkguest');
    Route::get('notifications/{lang}/{v}' , 'UserController@notifications');
    Route::get('unread-notifications/{lang}/{v}' , 'UserController@getUnreadNotificationsNumber');
    Route::post('add-comment/{lang}/{v}' , 'UserController@addComment');

});

Route::group([
    'middleware' => 'api',
    'prefix' => 'ad/user'
] , function($router){
    Route::get('adscount/{lang}/{v}' , 'UserController@getadscount');
    Route::get('current_ads/{curr}/{lang}/{v}' , 'UserController@getcurrentads');
    Route::get('user_ads/{id}/{curr}/{lang}/{v}' , 'UserController@getuserads');
    Route::get('expired_ads/{lang}/{v}' , 'UserController@getexpiredads');
    Route::put('renew_ad/{lang}/{v}' , 'UserController@renewad');
    Route::delete('delete_ad/{lang}/{v}' , 'UserController@deletead');
    Route::put('update_ad/{lang}/{v}' , 'UserController@updateAd');
    Route::put('feature_ad/{lang}/{v}' , 'UserController@featureAd');
    Route::delete('delete_ad_image/{lang}/{v}' , 'UserController@delteadimage');
    Route::get('ad_details/{id}/{lang}/{v}' , 'UserController@getaddetails');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'ad/products'
] , function($router){
    Route::post('create/{lang}/{v}' , 'AdProductController@create');
    Route::post('uploadimages/{lang}/{v}' , 'AdProductController@uploadimages');
    Route::get('comments/{product}/{lang}/{v}' , 'AdProductController@getComments')->middleware('checkguest');
    Route::get('{curr}/details/{id}/{lang}/{v}' , 'AdProductController@getdetails');
    Route::get('{curr}/filter/{lang}/{v}' , 'AdProductController@adFilter')->middleware('checkguest');
    Route::get('{curr}/getmaxminprice/{lang}/{v}' , 'AdProductController@getMaxMinPrice')->middleware('checkguest');

});

Route::get('ad/home/{curr}/{lang}/{v}' , 'HomeController@getAdData')->middleware('checkguest');

Route::get('ad/ad_owner_profile/{id}/{lang}/{v}' , 'UserController@getownerprofile')->middleware('checkguest');

Route::get('ad/products/{curr}/{lang}/{v}' , 'AdProductController@getproducts')->middleware('checkguest');
Route::get('ad/products/{curr}/search/{lang}/{v}' , 'AdProductController@adSearch')->middleware('checkguest');
Route::get('ad/countries/{lang}/{v}' , 'AdProductController@getCountries')->middleware('checkguest');
Route::get('ad/governorates/{country}/{lang}/{v}' , 'AdProductController@getGovernorates')->middleware('checkguest');
Route::get('ad/areas/{governorate}/{lang}/{v}' , 'AdProductController@getAreas')->middleware('checkguest');

Route::post('ad/favorites/{curr}/{lang}/{v}' , 'FavoriteController@addAdtofavorites');
Route::delete('ad/favorites/{curr}/{lang}/{v}' , 'FavoriteController@removeAdfromfavorites');
Route::get('ad/favorites/{curr}/{lang}/{v}' , 'FavoriteController@getAdfavorites');

//  plans apis
Route::group([
    'middleware' => 'api',
    'prefix' => 'ad/plans'
],function($router){
    Route::get('{curr}/pricing/{lang}/{v}' , 'PlanController@getpricing')->middleware('checkguest');
    Route::post('{curr}/buy/{lang}/{v}' , 'PlanController@buyplan');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'ad'
],function($router){
Route::get('/excute_pay' , 'PlanController@excute_pay');
Route::get('/pay/success' , 'PlanController@pay_sucess');
Route::get('/pay/error' , 'PlanController@pay_error');
});


// favorites
Route::group([
    'middleware' => 'api',
    'prefix' => 'favorites'
] , function($router){
    Route::get('/{lang}/{v}' , 'FavoriteController@getfavorites');
    Route::post('/{lang}/{v}' , 'FavoriteController@addtofavorites');
    Route::delete('/{lang}/{v}' , 'FavoriteController@removefromfavorites');
});

// favorites
Route::group([
    'middleware' => 'api',
    'prefix' => 'addresses'
] , function($router){
    Route::get('/{lang}/{v}' , 'AddressController@getaddress');
    Route::post('/{lang}/{v}' , 'AddressController@addaddress');
    Route::delete('/{lang}/{v}' , 'AddressController@removeaddress');
    Route::post('/setdefault/{lang}/{v}' , 'AddressController@setmain');
    Route::get('/areas/{lang}/{v}' , 'AddressController@getareas')->middleware('checkguest');
    Route::get('/details/{id}/{lang}/{v}' , 'AddressController@getdetails');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'ecommerce/orders'
] , function($router){
    Route::post('create/{lang}/{v}' , 'OrderController@create');
    Route::get('{curr}/{lang}/{v}' , 'OrderController@getorders');
    Route::get('{curr}/{id}/{lang}/{v}' , 'OrderController@orderdetails');
	Route::delete('cancelitem/{lang}/{v}' , 'OrderController@cancelItem');
});

Route::get('ecommerce/excute_pay' , 'OrderController@excute_pay');
Route::get('ecommerce/pay/success' , 'OrderController@pay_sucess');
Route::get('ecommerce/pay/error' , 'OrderController@pay_error');

Route::get('offers/{lang}/{v}' , 'OfferController@getoffers')->middleware('checkguest');
Route::get('offers_android/{lang}/{v}' , 'OfferController@getoffersandroid')->middleware('checkguest');
Route::get('selected/{lang}/{v}' , 'OfferController@getselected')->middleware('checkguest');

Route::get('ecommerce/delivery_price/{lang}/{v}' , 'AddressController@getdeliveryprice')->middleware('checkguest');



// get home data
Route::get('/ad/categories/{curr}/{lang}/{v}' , 'CategoryController@getAdCategories')->middleware('checkguest');
Route::get('/ad/categories-create/{curr}/{lang}/{v}' , 'CategoryController@getCategoriesForCreate')->middleware('checkguest');
Route::get('/ad/sub_categories/level1/{category_id}/{lang}/{v}' , 'CategoryController@getSubCatsForCreate')->middleware('checkguest');
Route::get('/ad/sub_categories/level2/{sub_category_id}/{lang}/{v}' , 'CategoryController@getSubCatsLevel2ForCreate')->middleware('checkguest');
Route::get('/ad/sub_categories/level3/{sub_category_id}/{lang}/{v}' , 'CategoryController@getSubCatsLevel3ForCreate')->middleware('checkguest');
Route::get('/ad/sub_categories/level4/{sub_category_id}/{lang}/{v}' , 'CategoryController@getSubCatsLevel4ForCreate')->middleware('checkguest');
Route::get('/ad/sub_categories/{curr}/level1/{category_id}/{lang}/{v}' , 'CategoryController@getAdSubCategories')->middleware('checkguest');
Route::get('/ad/sub_categories/{curr}/level2/{sub_category_id}/{lang}/{v}' , 'CategoryController@get_sub_categories_level2')->middleware('checkguest');
Route::get('/ad/sub_categories/{curr}/level3/{sub_category_id}/{lang}/{v}' , 'CategoryController@get_sub_categories_level3')->middleware('checkguest');
Route::get('/ad/sub_categories/{curr}/level4/{sub_category_id}/{lang}/{v}' , 'CategoryController@get_sub_categories_level4')->middleware('checkguest');
Route::get('/ad/category_options/{category}/{type}/{lang}/{v}' , 'CategoryController@getCategoryOptions')->middleware('checkguest');
Route::get('ad/offers/{curr}/{lang}/{v}' , 'OfferController@get_ad_offers')->middleware('checkguest');


Route::get('home-logos/{lang}/{v}' , 'HomeController@getHomeLogos');

// get home data - 1
Route::get('currencies/{lang}/{v}' , 'HomeController@getcurrencies')->middleware('checkguest');
Route::get('currenciesbycountry/{country}/{lang}/{v}' , 'HomeController@getcurrencyByCountry')->middleware('checkguest');
Route::get('home/{lang}/{v}' , 'HomeController@getdata')->middleware('checkguest');
Route::get('ecommerce/home/{curr}/{lang}/{v}' , 'HomeController@getecommercehome')->middleware('checkguest');
Route::get('ecommerce/categories/{curr}/{lang}/{v}' , 'CategoryController@getecommercecategories')->middleware('checkguest');
Route::get('ecommerce/sub_categories/level1/{category_id}/{curr}/{lang}/{v}' , 'CategoryController@get_ecommerce_sub_categories')->middleware('checkguest');
Route::get('ecommerce/car_types/{curr}/{lang}/{v}' , 'CategoryController@get_car_types')->middleware('checkguest');
Route::get('ecommerce/sub_car_types/level1/{car_type_id}/{curr}/{lang}/{v}' , 'CategoryController@get_ecommerce_sub_car_type_level1')->middleware('checkguest');
Route::get('ecommerce/sub_car_types/level2/{sub_car_type_id}/{curr}/{lang}/{v}' , 'CategoryController@get_ecommerce_sub_car_type_level2')->middleware('checkguest');
Route::get('ecommerce/sub_car_types/level3/{sub_car_type_id}/{curr}/{lang}/{v}' , 'CategoryController@get_ecommerce_sub_car_type_level3')->middleware('checkguest');
Route::get('ecommerce/sub_car_types/level4/{sub_car_type_id}/{curr}/{lang}/{v}' , 'CategoryController@get_ecommerce_sub_car_type_level4')->middleware('checkguest');
Route::get('ecommerce/products/{curr}/{lang}/{v}' , 'ProductController@getecommercefilterproducts')->middleware('checkguest');
Route::get('ecommerce/get-filters/{curr}/{lang}/{v}' , 'ProductController@getOptionsByCatId')->middleware('checkguest');

Route::post('ecommerce/products-filter/{curr}/{lang}/{v}' , 'ProductController@filter');

Route::get('ecommerce/products/{curr}/getmaxminprice/{lang}/{v}' , 'ProductController@getMaxMinPrice')->middleware('checkguest');
Route::get('ecommerce/products/filter/{curr}/{lang}/{v}' , 'ProductController@getecommercefilterproducts')->middleware('checkguest');
Route::get('ecommerce/products/search/{curr}/{lang}/{v}' , 'ProductController@ecommercesearch' )->middleware('checkguest');
Route::get('ecommerce/products/details/{id}/{curr}/{lang}/{v}' , 'ProductController@getecommerceproductdetails' )->middleware('checkguest');
Route::get('ecommerce/products/company/{id}/{curr}/{lang}/{v}' , 'ProductController@getecommercecompanyproducts')->middleware('checkguest');
Route::get('ecommerce/favorites/{curr}/{lang}/{v}' , 'FavoriteController@getecommercefavorites');
Route::post('ecommerce/favorites/{curr}/{lang}/{v}' , 'FavoriteController@addecommercetofavorites');
Route::delete('ecommerce/favorites/{curr}/{lang}/{v}' , 'FavoriteController@removeecommercefromfavorites');
Route::get('ecommerce/offers/{curr}/{lang}/{v}' , 'OfferController@get_ecommerce_offers')->middleware('checkguest');
Route::get('ecommerce/companies/{curr}/{lang}/{v}' , 'ProductController@getcompanies')->middleware('checkguest');
Route::get('ecommerce/delivery_methods/{curr}/{lang}/{v}' , 'ProductController@getdeliverymethods')->middleware('checkguest');




// visitors
Route::group([
    'middleware' => 'api',
    'prefix' => 'ecommerce/visitors'
], function($router){
    Route::post('create/{curr}/{lang}/{v}' , 'VisitorController@create')->middleware('checkguest');
    Route::post('cart/add/{curr}/{lang}/{v}' , 'VisitorController@add')->middleware('checkguest');
    Route::delete('cart/delete/{curr}/{lang}/{v}' , 'VisitorController@delete')->middleware('checkguest');
    Route::post('cart/get/{curr}/{lang}/{v}' , 'VisitorController@get')->middleware('checkguest');
    Route::put('cart/changecount/{curr}/{lang}/{v}' , 'VisitorController@changecount')->middleware('checkguest');
    Route::post('cart/count/{curr}/{lang}/{v}' , 'VisitorController@getcartcount')->middleware('checkguest');
});

// send contact us message
Route::post('/contactus/{lang}/{v}' , 'ContactUsController@SendMessage')->middleware('checkguest');

// get app number
Route::get('/getappnumber/{lang}/{v}' , 'SettingController@getappnumber')->middleware('checkguest');


// get countries for shipping
Route::get('/countries/{lang}/{v}' , 'SettingController@getCountries');

// get country name
Route::get('/country/{country_id}/{lang}/{v}' , 'SettingController@getCountryName');

// get services
Route::get('/getservices/{lang}/{v}' , 'SettingController@getServices')->middleware('checkguest');

// get whats app number
Route::get('/getwhatsappnumber/{lang}/{v}' , 'SettingController@getwhatsapp')->middleware('checkguest');

// get products
// Route::get('/products/{lang}/{v}' , 'ProductController@getproducts')->middleware('checkguest');

// get products brand
Route::get('/ecommerce/products/category/{category_id}/{lang}/{v}' , 'ProductController@getcategoryproducts')->middleware('checkguest');

// get product details
Route::get('/ecommerce/products/{id}/{lang}/{v}' , 'ProductController@getdetails')->middleware('checkguest');

// rates
// get rates
Route::get('/rate/{order_id}/{lang}/{v}' , 'RateController@getrates')->middleware('checkguest');
// add rate
Route::post('/rate/{lang}/{v}' , 'RateController@addrate');

Route::get('/search/{lang}/{v}' , 'SearchByNameController@search' )->middleware('checkguest');

//nasser code
//chat api
Route::get('/chat/test_exists_conversation/{id}/{lang}/{v}' , 'ChatController@test_exists_conversation');

Route::post('/chat/send_message/{lang}/{v}' , 'ChatController@store');
Route::get('/chat/my_messages/{lang}/{v}' , 'ChatController@my_messages');
Route::get('/chat/get_ad_message/{id}/{conversation_id}/{lang}/{v}' , 'ChatController@get_ad_message');
Route::get('/chat/search_conversation/{search}/{lang}/{v}' , 'ChatController@search_conversation');
Route::get('/chat/make_read/{message_id}/{lang}/{v}' , 'ChatController@make_read');
//end nasser code

// get payment status
Route::get('/paymentstatus/{lang}/{v}' , 'SettingController@paymentStatus');
