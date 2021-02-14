<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/setlocale/{locale}',function($lang){
    Session::put('locale',$lang);
    return redirect()->back();   
});



// Dashboard Routes
Route::group([
    'middleware'=>'language',
    'prefix' => "admin-panel",
    'namespace' => "Admin"  
] , function($router){

    Route::get('' ,'HomeController@show');
    Route::get('ad_home' ,'HomeController@ad_show')->name('home.ad.index');
    Route::get('ecommerce_home' ,'HomeController@ecommerce_show')->name('home.ecommerce.index');
    Route::get('login' ,  [ 'as' => 'adminlogin', 'uses' => 'AdminController@getlogin']);
    Route::post('login' , 'AdminController@postlogin');
    Route::get('logout' , 'AdminController@logout');
    Route::get('profile' , 'AdminController@profile');
    Route::post('profile' , 'AdminController@updateprofile');    
    Route::get('databasebackup' , 'AdminController@backup');

    // Users routes for dashboard
    Route::group([
        'prefix' => 'users',
    ] , function($router){
            Route::get('add' , 'UserController@AddGet');
            Route::post('add' , 'UserController@AddPost');
            Route::get('show' , 'UserController@show');
            Route::get('edit/{id}' , 'UserController@edit');
            Route::post('edit/{id}' , 'UserController@EditPost');
            Route::get('details/{id}' , 'UserController@details')->name("users.details");
            Route::post('send_notifications/{id}' , 'UserController@SendNotifications');
            Route::get('block/{id}' , 'UserController@block');
            Route::get('active/{id}' , 'UserController@active');
            Route::get('addresses/{user}' , 'UserController@get_user_addresses')->name('user.addresses');
            Route::get('address/details/{address}' , 'UserController@address_details')->name('address.details');
        }
    );

    // admins routes for dashboard
    Route::group([
        'prefix' => "managers",
    ], function($router){
        Route::get('add' , 'ManagerController@AddGet');
        Route::post('add' , 'ManagerController@AddPost');
        Route::get('show' , 'ManagerController@show');
        Route::get('edit/{id}' , 'ManagerController@edit');
        Route::post('edit/{id}' , 'ManagerController@EditPost');
        Route::get('delete/{id}' , 'ManagerController@delete');
    });

    // App Pages For Dashboard
    Route::group([
        'prefix' => 'app_pages'
    ] , function($router){
        Route::get('aboutapp' , 'AppPagesController@GetAboutApp');
        Route::post('aboutapp' , 'AppPagesController@PostAboutApp');
        Route::get('termsandconditions' , 'AppPagesController@GetTermsAndConditions');
        Route::post('termsandconditions' , 'AppPagesController@PostTermsAndConditions');
        Route::get('deliveryinformation' , 'AppPagesController@GetDeliveryInformation');
        Route::post('deliveryinformation' , 'AppPagesController@PostDeliveryInformation');
        Route::get('returnpolicy' , 'AppPagesController@GetReturnPolicy');
        Route::post('returnpolicy' , 'AppPagesController@PostReturnPolicy');
    });

    // Setting Route
    Route::get('settings' , 'SettingController@GetSetting');
    Route::post('settings' , 'SettingController@PostSetting');

    // Rates
    Route::get('rates' , 'RateController@Getrates');
   Route::get('rates/active/{id}' , 'RateController@activeRate');

    // meta tags Route
    Route::get('meta_tags' , 'MetaTagController@getMetaTags');
    Route::post('meta_tags' , 'MetaTagController@postMetaTags');

    // Ads Route
    Route::group([
        "prefix" => "ads"
    ],function($router){
        Route::get('add' , 'AdController@AddGet');
        Route::post('add' , 'AdController@AddPost');
        Route::get('show' , 'AdController@show')->name('ads.index');
        Route::get('edit/{id}' , 'AdController@EditGet')->name('ads.edit');
        Route::post('edit/{id}' , 'AdController@EditPost');
        Route::get('details/{id}' , 'AdController@details');
        Route::get('delete/{id}' , 'AdController@delete');
        Route::get('fetchproducts' , 'AdController@fetch_products')->name("products.fetch");
    });

    Route::group([
        "prefix" => "plans"
    ], function($router){

        Route::get('add' , 'PlanController@AddGet');
        Route::post('add' , 'PlanController@AddPost');
        Route::get('show' , 'PlanController@show');
        Route::get('edit/{id}' , 'PlanController@EditGet');
        Route::post('edit/{id}' , 'PlanController@EditPost');
        Route::get('delete/{id}' , 'PlanController@delete');

    });

    // countries
    Route::group([
        "prefix" => "countries"
    ], function($router){

        Route::get('add' , 'CountryController@AddGet')->name('countries.add');
        Route::post('add' , 'CountryController@AddPost');
        Route::get('show' , 'CountryController@show')->name('countries.index');
        Route::get('edit/{country}' , 'CountryController@EditGet')->name('countries.edit');
        Route::post('edit/{country}' , 'CountryController@postEdit');
        Route::get('details/{country}' , 'CountryController@details')->name('countries.details');
        Route::get('delete/{country}' , 'CountryController@delete')->name('countries.delete');

    });

    // governorates
    Route::group([
        "prefix" => "governorates"
    ], function($router){

        Route::get('add' , 'GovernorateController@AddGet')->name('governorates.add');
        Route::post('add' , 'GovernorateController@AddPost');
        Route::get('show' , 'GovernorateController@show')->name('governorates.index');
        Route::get('edit/{governorate}' , 'GovernorateController@EditGet')->name('governorates.edit');
        Route::post('edit/{governorate}' , 'GovernorateController@postEdit');
        Route::get('details/{governorate}' , 'GovernorateController@details')->name('governorates.details');
        Route::get('delete/{governorate}' , 'GovernorateController@delete')->name('governorates.delete');

    });

    // governorates areas
    Route::group([
        "prefix" => "governorate-areas"
    ], function($router){

        Route::get('add' , 'GovernorateAreaController@AddGet')->name('governorates.areas.add');
        Route::post('add' , 'GovernorateAreaController@AddPost');
        Route::get('show' , 'GovernorateAreaController@show')->name('governorates.areas.index');
        Route::get('edit/{area}' , 'GovernorateAreaController@EditGet')->name('governorates.areas.edit');
        Route::post('edit/{area}' , 'GovernorateAreaController@EditPost');
        Route::get('details/{area}' , 'GovernorateAreaController@details')->name('governorates.areas.details');
        Route::get('delete/{area}' , 'GovernorateAreaController@delete')->name('governorates.areas.delete');

    });

    // Home Multiple Options Route
    Route::group([
        "prefix" => "multi_options"
    ], function($router){
         Route::get('show' , 'MultiOptionController@show')->name('multi_options.index');
         Route::get('add' , 'MultiOptionController@AddGet')->name('multi_options.add');
         Route::post('add' , 'MultiOptionController@AddPost');
         Route::get('edit/{option}' , 'MultiOptionController@EditGet')->name('multi_options.edit');
         Route::post('edit/{option}' , 'MultiOptionController@EditPost');
         Route::get('delete/{option}' , 'MultiOptionController@delete')->name('multi_options.delete');
    });

    Route::get('getadpartproducts' , 'ProductController@getadpartproducts');
    Route::get('getadpartproducts/{country}' , 'ProductController@getadpartproductsByCountry');
    Route::get('getecommercepartproducts' , 'ProductController@getecommercepartproducts');
    Route::get('fetchgovernoratescountry/{country}' , 'GovernorateAreaController@fetchGovernoratesByCountry');

    Route::group([
        "prefix" => "ad_products"
    ], function($router){

        Route::get('add' , 'AdProductController@AddGet');
        Route::post('add' , 'AdProductController@AddPost');
        Route::get('show' , 'AdProductController@show');
        Route::get('edit/{id}' , 'AdProductController@EditGet');
        Route::post('edit/{id}' , 'AdProductController@EditPost');
        Route::get('delete/{id}' , 'AdProductController@delete');
        Route::get('details/{id}' , 'AdProductController@details');
        Route::get('images/delete/{id}' , 'AdProductController@delete_product_image');

    });

    // Categories Route
    Route::group([
        "prefix" => "categories"
    ], function($router){
         Route::get('add' , 'CategoryController@AddGet');
         Route::post('add' , 'CategoryController@AddPost')->name('categories.add');
         Route::get('show' , 'CategoryController@show')->name('categories.index');
        //  Route::get('ads/show' , 'CategoryController@adsShow')->name('categories.ads.index');
         Route::get('edit/{id}' , 'CategoryController@EditGet');
         Route::post('edit/{id}' , 'CategoryController@EditPost')->name('categories.update');
         Route::get('delete/{id}' , 'CategoryController@delete');   
         Route::get('details/{category}' , 'CategoryController@details')->name('categories.details'); 
    });

    // ads Categories Route
    Route::group([
        "prefix" => "ads_categories"
    ], function($router){
         Route::get('add' , 'CategoryController@adsAddGet');
         Route::post('add' , 'CategoryController@adsAddPost')->name('categories.ads.add');
         Route::get('show' , 'CategoryController@adsShow')->name('categories.ads.index');
         Route::get('edit/{id}' , 'CategoryController@adsEditGet');
         Route::post('edit/{id}' , 'CategoryController@adsEditPost')->name('categories.ads.update');
        //  Route::get('delete/{id}' , 'CategoryController@delete');   
         Route::get('details/{category}' , 'CategoryController@ad_details')->name('categories.ads.details');      
    });

    // Home Sections Route
    Route::group([
        "prefix" => "home_sections"
    ], function($router){
         Route::get('show' , 'HomeSectionsController@show')->name('home_sections.index');
         Route::post('sort' , 'HomeSectionsController@updateSectionsSorting')->name('home_sections.sort');
         Route::get('add' , 'HomeSectionsController@AddGet')->name('home_sections.add');
         Route::get('fetch/{element}' , 'HomeSectionsController@fetchData');
         Route::post('add' , 'HomeSectionsController@AddPost');
         Route::get('edit/{homeSection}' , 'HomeSectionsController@EditGet')->name('home_sections.edit');
         Route::post('edit/{homeSection}' , 'HomeSectionsController@EditPost');
         Route::get('delete/{homeSection}' , 'HomeSectionsController@delete')->name('home_sections.delete');
         Route::get('details/{homeSection}' , 'HomeSectionsController@details')->name('home_sections.details');
    });

    // Companies Route
    Route::group([
        "prefix" => "companies"
    ], function($router){
        Route::get('show' , 'CompanyController@show')->name('companies.index');
        Route::get('add' , 'CompanyController@AddGet')->name('companies.add');
        Route::post('add' , 'CompanyController@AddPost');
        Route::get('edit/{id}' , 'CompanyController@EditGet')->name('companies.edit');
        Route::post('edit/{id}' , 'CompanyController@EditPost');
        Route::get('delete/{id}' , 'CompanyController@delete');
        Route::get('details/{company}' , 'CompanyController@details')->name('companies.details');
    });

    // Ad Home Sections Route
    Route::group([
        "prefix" => "adpro_home_sections"
    ], function($router){
         Route::get('show' , 'HomeSectionsController@showAd')->name('ad_home_sections.index');
        //  Route::post('sort' , 'HomeSectionsController@updateSectionsSorting')->name('home_sections.sort');
         Route::get('add' , 'HomeSectionsController@adAddGet')->name('ad_home_sections.add');
         Route::get('fetch/{element}' , 'HomeSectionsController@adFetchData');
         Route::post('add' , 'HomeSectionsController@adAddPost');
        //  Route::get('edit/{homeSection}' , 'HomeSectionsController@EditGet')->name('home_sections.edit');
        //  Route::post('edit/{homeSection}' , 'HomeSectionsController@EditPost');
        //  Route::get('delete/{homeSection}' , 'HomeSectionsController@delete')->name('home_sections.delete');
        //  Route::get('details/{homeSection}' , 'HomeSectionsController@details')->name('home_sections.details');
    });

    // Offer Control Route
    Route::group([
        "prefix" => "offers_control"
    ], function($router){
            Route::get('add' , 'OffersControlController@AddGet')->name('offers_control.add');
            Route::post('add' , 'OffersControlController@AddPost');
            Route::post('sort' , 'OffersControlController@updateOffersSorting')->name('offers_control.sort');
            Route::get('edit/{section}' , 'OffersControlController@EditGet')->name('offers_control.edit');
            Route::post('edit/{section}' , 'OffersControlController@EditPost');
            Route::get('show' , 'OffersControlController@show')->name('offers_control.index');
            Route::get('details/{section}' , 'OffersControlController@details')->name('offers_control.details');
            Route::get('delete/{section}' , 'OffersControlController@delete')->name('offers_control.delete');
    });

    // Home Offers Route
    Route::group([
        "prefix" => "offers"
    ], function($router){
         Route::get('show' , 'OffersController@show')->name('offers.index');
         Route::get('fetch/{type}' , 'OffersController@fetchType')->name('fetch.type');
         Route::get('add' , 'OffersController@AddGet')->name('offers.add');
         Route::post('add' , 'OffersController@AddPost');
         Route::post('sort' , 'OffersController@updateOffersSorting')->name('offers.sort');
         Route::get('edit/{offer}' , 'OffersController@EditGet')->name('offers.edit');
         Route::post('edit/{offer}' , 'OffersController@EditPost');
         Route::get('delete/{offer}' , 'OffersController@delete')->name('offers.delete');
         Route::get('details/{offer}' , 'OffersController@details')->name('offers.details');
    });

    // Delivery methods
    Route::group([
        "prefix" => "delivery-methods"
    ], function($router){
         Route::get('show' , 'DeliveryMethodController@show')->name('deliveryMethod.index');
         Route::get('add' , 'DeliveryMethodController@AddGet')->name('deliveryMethod.add');
         Route::post('add' , 'DeliveryMethodController@AddPost');
         Route::get('edit/{method}' , 'DeliveryMethodController@EditGet')->name('deliveryMethod.edit');
         Route::post('edit/{method}' , 'DeliveryMethodController@EditPost');
         Route::get('delete/{method}' , 'DeliveryMethodController@delete')->name('deliveryMethod.delete');
    });

    // Delivery methods
    Route::group([
        "prefix" => "ad-slider"
    ], function($router){
         Route::get('show' , 'AdSliderController@show')->name('adSlider.index');
         Route::get('add' , 'AdSliderController@AddGet')->name('adSlider.add');
         Route::post('add' , 'AdSliderController@AddPost');
         Route::get('edit/{id}' , 'AdSliderController@EditGet')->name('adSlider.edit');
         Route::post('edit/{id}' , 'AdSliderController@EditPost');
         Route::get('delete/{id}' , 'AdSliderController@delete')->name('adSlider.delete');
    });

    // Home Options Route
    Route::group([
        "prefix" => "options"
    ], function($router){
         Route::get('show' , 'OptionsController@show')->name('options.index');
         Route::get('add' , 'OptionsController@AddGet')->name('options.add');
         Route::post('add' , 'OptionsController@AddPost');
         Route::get('edit/{option}' , 'OptionsController@EditGet')->name('options.edit');
         Route::post('edit/{option}' , 'OptionsController@EditPost');
         Route::get('delete/{option}' , 'OptionsController@delete')->name('options.delete');
    });

     // Orders Route
     Route::group([
        "prefix" => "orders"
    ], function($router){
         Route::get('show' , 'OrderController@show')->name('orders.index');
         Route::get('action/{order}/{status}' , 'OrderController@action_order')->name('orders.action');
         Route::get('details/{order}' , 'OrderController@details')->name('orders.details');
         Route::get('filter/{status}' , 'OrderController@filter_orders')->name('orders.filter');
         Route::get('fetchbyarea' , 'OrderController@fetch_orders_by_area')->name('orders.fetchbyarea');
         Route::get('fetchbydate' , 'OrderController@fetch_orders_date')->name('orders.fetchbydate');
         Route::get('fetchbypayment' , 'OrderController@fetch_order_payment_method')->name('orders.fetchbypayment');
         Route::get('invoice/{order}' , 'OrderController@getInvoice')->name('orders.invoice');
    });

    // Areas Route
    Route::group([
        "prefix" => "areas"
    ], function($router){
         Route::get('show' , 'AreasController@show')->name('areas.index');
         Route::get('add' , 'AreasController@AddGet')->name('areas.add');
         Route::post('add' , 'AreasController@AddPost');
         Route::get('edit/{area}' , 'AreasController@EditGet')->name('areas.edit');
         Route::post('edit/{area}' , 'AreasController@EditPost');
         Route::get('delete/{area}' , 'AreasController@delete')->name('areas.delete');
         Route::get('details/{area}' , 'AreasController@details')->name('areas.details');
    });

    // Brands Route
    Route::group([
        "prefix" => "brands"
    ], function($router){
         Route::get('show' , 'BrandController@show')->name('brands.index');
         Route::get('add' , 'BrandController@AddGet')->name('brands.add');
         Route::post('add' , 'BrandController@AddPost');
         Route::get('edit/{brand}' , 'BrandController@EditGet')->name('brands.edit');
         Route::post('edit/{brand}' , 'BrandController@EditPost');
         Route::get('delete/{brand}' , 'BrandController@delete')->name('brands.delete');
         Route::get('details/{brand}' , 'BrandController@details')->name('brands.details');
    });

    // Sub Categories Route
    Route::group([
        "prefix" => "sub_categories"
    ], function($router){
         Route::get('show' , 'SubCategoryController@show')->name('sub_categories.index');
         Route::get('add' , 'SubCategoryController@AddGet')->name('sub_categories.add');
         Route::post('add' , 'SubCategoryController@AddPost')->name('sub_categories.create');
         Route::get('fetchbrand/{category}' , 'SubCategoryController@fetchBrands')->name('fetch.brands');
         Route::get('edit/{subCategory}' , 'SubCategoryController@EditGet')->name('sub_categories.edit');
         Route::post('edit/{subCategory}' , 'SubCategoryController@EditPost')->name('sub_categories.update');
         Route::get('details/{subCategory}' , 'SubCategoryController@details')->name('sub_categories.details');
         Route::get('delete/{subCategory}' , 'SubCategoryController@delete')->name('sub_categories.delete');
    });

    // Sub Categories Route
    Route::group([
        "prefix" => "ads_sub_categories"
    ], function($router){
         Route::get('show' , 'SubCategoryController@adsShow')->name('sub_categories.ads.index');
         Route::get('add' , 'SubCategoryController@adsAddGet')->name('sub_categories.ads.add');
         Route::post('add' , 'SubCategoryController@adsAddPost')->name('sub_categories.ads.create');
         Route::get('edit/{subCategory}' , 'SubCategoryController@adsEditGet')->name('sub_categories.ads.edit');
         Route::post('edit/{subCategory}' , 'SubCategoryController@adsEditPost')->name('sub_categories.ads.update');
         Route::get('details/{subCategory}' , 'SubCategoryController@adsDetails')->name('sub_categories.ads.details');
    });

    // Car Types Route
    Route::group([
        "prefix" => "car_types"
    ], function($router){
         Route::get('show' , 'CarTypesController@show')->name('car_types.index');
         Route::get('add' , 'CarTypesController@getAdd')->name('car_types.add');
         Route::post('add' , 'CarTypesController@AddPost')->name('car_types.create');
         Route::get('edit/{carType}' , 'CarTypesController@getEdit')->name('car_types.edit');
         Route::post('edit/{carType}' , 'CarTypesController@EditPost')->name('car_types.update');
         Route::get('delete/{id}' , 'CarTypesController@delete')->name('car_types.delete');
         Route::get('details/{carType}' , 'CarTypesController@details')->name('car_types.details');
    });

    // sub Car Types one Route
    Route::group([
        "prefix" => "sub_one_car_types"
    ], function($router){
         Route::get('show' , 'SubOneCarTypeController@show')->name('sub_one_car_types.index');
         Route::get('add' , 'SubOneCarTypeController@getAdd')->name('sub_one_car_types.add');
         Route::post('add' , 'SubOneCarTypeController@AddPost')->name('sub_one_car_types.create');
         Route::get('edit/{subCarType}' , 'SubOneCarTypeController@getEdit')->name('sub_one_car_types.edit');
         Route::post('edit/{subCarType}' , 'SubOneCarTypeController@EditPost')->name('sub_one_car_types.update');
         Route::get('delete/{id}' , 'SubOneCarTypeController@delete')->name('sub_one_car_types.delete');
         Route::get('details/{subCarType}' , 'SubOneCarTypeController@details')->name('sub_one_car_types.details');
    });

    // sub Car Types two Route
    Route::group([
        "prefix" => "sub_two_car_types"
    ], function($router){
         Route::get('show' , 'SubTwoCarTypeController@show')->name('sub_two_car_types.index');
         Route::get('add' , 'SubTwoCarTypeController@getAdd')->name('sub_two_car_types.add');
         Route::post('add' , 'SubTwoCarTypeController@AddPost')->name('sub_two_car_types.create');
         Route::get('edit/{subCarType}' , 'SubTwoCarTypeController@getEdit')->name('sub_two_car_types.edit');
         Route::post('edit/{subCarType}' , 'SubTwoCarTypeController@EditPost')->name('sub_two_car_types.update');
         Route::get('delete/{id}' , 'SubTwoCarTypeController@delete')->name('sub_two_car_types.delete');
         Route::get('details/{subCarType}' , 'SubTwoCarTypeController@details')->name('sub_two_car_types.details');
    });

    // Route::get('sub_categories/{category_id}' , 'SubCategoryController@fetchsubcategories');
    // Route::get('sub_two_categories/{sub_category_id}' , 'SubCategoryController@fetchsubtwocategories');
    // Route::get('sub_three_categories/{sub_category_id}' , 'SubCategoryController@fetchsubthreecategories');

        // Sub two Categories Route
        Route::group([
            "prefix" => "sub_two_categories"
        ], function($router){
             Route::get('' , 'SubTwoCategoryController@show')->name('sub_two_categories.index');
             Route::get('add' , 'SubTwoCategoryController@AddGet')->name('sub_two_categories.add');
             Route::post('add' , 'SubTwoCategoryController@AddPost');
             Route::get('edit/{subCategory}' , 'SubTwoCategoryController@EditGet')->name('sub_two_categories.edit');
             Route::post('edit/{subCategory}' , 'SubTwoCategoryController@EditPost');
             Route::get('details/{subCategory}' , 'SubTwoCategoryController@details')->name('sub_two_categories.details');
             Route::get('delete/{subCategory}' , 'SubTwoCategoryController@delete')->name('sub_two_categories.delete');
        });


        // Sub three Categories Route
        Route::group([
            "prefix" => "sub_three_categories"
        ], function($router){
                Route::get('' , 'SubThreeCategoryController@show')->name('sub_three_categories.index');
                Route::get('add' , 'SubThreeCategoryController@AddGet')->name('sub_three_categories.add');
                Route::post('add' , 'SubThreeCategoryController@AddPost');
                Route::get('edit/{subCategory}' , 'SubThreeCategoryController@EditGet')->name('sub_three_categories.edit');
                Route::post('edit/{subCategory}' , 'SubThreeCategoryController@EditPost');
                Route::get('details/{subCategory}' , 'SubThreeCategoryController@details')->name('sub_three_categories.details');
                Route::get('delete/{subCategory}' , 'SubThreeCategoryController@delete')->name('sub_three_categories.delete');
        });

        // Sub four Categories Route
        Route::group([
            "prefix" => "sub_four_categories"
        ], function($router){
            Route::get('' , 'SubFourCategoryController@show')->name('sub_four_categories.index');
            Route::get('add' , 'SubFourCategoryController@AddGet')->name('sub_four_categories.add');
            Route::post('add' , 'SubFourCategoryController@AddPost');
            Route::get('edit/{subCategory}' , 'SubFourCategoryController@EditGet')->name('sub_four_categories.edit');
            Route::post('edit/{subCategory}' , 'SubFourCategoryController@EditPost');
            Route::get('details/{subCategory}' , 'SubFourCategoryController@details')->name('sub_four_categories.details');
            Route::get('delete/{subCategory}' , 'SubFourCategoryController@delete')->name('sub_four_categories.delete');
        });

    // Products Route
    Route::group([
        "prefix" => "products"
    ], function($router){
         Route::get('show' , 'ProductController@show')->name('products.index');
         Route::get('fetchbrands/{category}' , 'ProductController@fetch_category_brands');
         Route::get('fetchsubcategories/{brand}' , 'ProductController@fetch_brand_sub_categories');
         Route::get('fetchproducts/{subCategory}' , 'ProductController@sub_category_products');
         Route::get('fetchcategoryproducts/{category}' , 'ProductController@fetch_category_products');
         Route::get('fetchbrandproducts/{brand}' , 'ProductController@fetch_brand_products');
         Route::get('fetchcategoryoptions/{category}' , 'ProductController@fetch_category_options');
         Route::get('edit/{product}' , 'ProductController@EditGet')->name('products.edit');
         Route::post('edit/{product}' , 'ProductController@EditPost');
         Route::get('delete/productimage/{productImage}' , 'ProductController@delete_product_image')->name("productImage.delete");
         Route::get('details/{product}' , 'ProductController@details')->name('products.details');
         Route::get('delete/{product}' , 'ProductController@delete')->name('products.delete');
         Route::get('search' , 'ProductController@product_search')->name('products.search');
         Route::get('searched' , 'ProductController@product_search');
         Route::post('update/quantity/{product}' , 'ProductController@update_quantity')->name('update.quantity');
         Route::get('add' , 'ProductController@AddGet')->name('products.add');
         Route::post('add' , 'ProductController@AddPost');
         Route::get('hide/{product}/{status}' , 'ProductController@visibility_status_product')->name('products.visibility.status');
         Route::get('getbysubcat' , 'ProductController@get_product_by_sub_cat')->name('products.getbysubcat');
         Route::get('fetchsubcategorybycategory/{category}' , 'ProductController@fetch_sub_categories_by_category');
         Route::get('fetchsubcatsbycat/{category}' , 'ProductController@fetch_sub_cats_cats');
         Route::get('fetchsubcartwobycarone/{carOne}' , 'ProductController@fetch_sub_cartwotype_by_sub_caronetype');
         Route::get('fetchsubcategorymultioptions/{category}' , 'ProductController@fetch_sub_category_multi_options');

    });


    // Contact Us Messages Route
    Route::group([
        "prefix" => "contact_us"
    ] , function($router){
        Route::get('' , 'ContactUsController@show');
        Route::get('details/{id}' , 'ContactUsController@details');
        Route::get('delete/{id}' , 'ContactUsController@delete');
    });

    // stats Messages Route
    Route::group([
        "prefix" => "statistics"
    ] , function($router){
        Route::get('' , 'StatsController@show')->name("statistics.index");
    });

    // Notifications Route
    Route::group([
        "prefix" => "notifications"
    ], function($router){
        Route::get('show' , 'NotificationController@show');
        Route::get('details/{id}' , 'NotificationController@details');
        Route::get('delete/{id}' , 'NotificationController@delete');
        Route::get('send' , 'NotificationController@getsend');
        Route::post('send' , 'NotificationController@send');
        Route::get('resend/{id}' , 'NotificationController@resend');        
    });

});



// Web View Routes 
Route::group([
    'prefix' => "webview"
] , function($router){
    Route::get('aboutapp/{lang}' , 'WebViewController@getabout');
    Route::get('termsandconditions/{lang}' , 'WebViewController@gettermsandconditions' );
    Route::get('returnpolicy/{lang}' , 'WebViewController@returnpolicy');
    Route::get('deliveryinformation/{lang}' , 'WebViewController@deliveryinformation');
});