<!DOCTYPE html>
<html lang="en">
<head>
    <link href="/admin/assets/css/elements/search.css" rel="stylesheet" type="text/css" />
    <link href="/admin/plugins/animate/animate.css" rel="stylesheet" type="text/css" />
    @if(App::isLocale('ar'))
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.png"/>
    <link href="/admin/rtl/assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="/admin/rtl/assets/js/loader.js"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="/admin/rtl/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/admin/rtl/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="/admin/plugins/bootstrap-select/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="/admin/plugins/select2/select2.min.css">
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="/admin/rtl/assets/css/dashboard/dash_2.css" rel="stylesheet" type="text/css">
    <link href="/admin/rtl/assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="/admin/rtl/assets/css/components/tabs-accordian/custom-accordions.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="/admin/rtl/assets/css/forms/theme-checkbox-radio.css">
    <link href="/admin/rtl/assets/css/tables/table-basic.css" rel="stylesheet" type="text/css" />
    
    <link href="/admin/rtl/assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <link href="/admin/rtl/assets/css/elements/custom-pagination.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/admin/rtl/plugins/font-icons/fontawesome/css/regular.css">
    <link rel="stylesheet" href="/admin/rtl/plugins/font-icons/fontawesome/css/fontawesome.css">
    <link rel="stylesheet" type="text/css" href="/admin/rtl/assets/css/elements/alert.css">
    <link href="/admin/rtl/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="/admin/rtl/assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="/admin/rtl/plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="/admin/rtl/plugins/table/datatable/custom_dt_html5.css">
    <link rel="stylesheet" type="text/css" href="/admin/rtl/plugins/table/datatable/dt-global_style.css">
    <link rel="stylesheet" href="/admin/rtl/plugins/editors/markdown/simplemde.min.css">
    <link rel="stylesheet" href="/admin/assets/css/custom.css">
    <link rel="stylesheet" type="text/css" href="https://www.fontstatic.com/f=dubai-medium" />
    <link rel="stylesheet" href="/admin/assets/css/ar.css">    
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="/admin/rtl/assets/css/components/tabs-accordian/custom-tabs.css" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->
    <link rel="stylesheet" type="text/css" href="/admin/rtl/plugins/jquery-step/jquery.steps.css">
    <link href="/admin/rtl/plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    @endif

    @if (App::isLocale('en')) 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.png"/>
    <link href="/admin/assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="/admin/assets/js/loader.js"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="/admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/admin/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="/admin/plugins/bootstrap-select/bootstrap-select.min.css">
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="/admin/plugins/select2/select2.min.css">

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="/admin/plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="/admin/assets/css/dashboard/dash_2.css" rel="stylesheet" type="text/css">
    <link href="/admin/assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="/admin/css/components/tabs-accordian/custom-accordions.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="/admin/assets/css/forms/theme-checkbox-radio.css">
    <link href="/admin/assets/css/tables/table-basic.css" rel="stylesheet" type="text/css" />
    <link href="/admin/plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    
    <link href="/admin/assets/css/elements/custom-pagination.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/admin/plugins/font-icons/fontawesome/css/regular.css">
    <link rel="stylesheet" href="/admin/plugins/font-icons/fontawesome/css/fontawesome.css">
    <link rel="stylesheet" type="text/css" href="/admin/assets/css/elements/alert.css">
    <link href="/admin/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="/admin/assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="/admin/plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="/admin/plugins/table/datatable/custom_dt_html5.css">
    <link rel="stylesheet" type="text/css" href="/admin/plugins/table/datatable/dt-global_style.css">
    <link rel="stylesheet" href="/admin/plugins/editors/markdown/simplemde.min.css">
    <link rel="stylesheet" href="/admin/assets/css/custom.css">
    <link rel="stylesheet" href="/admin/assets/css/en.css">    
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="/admin/assets/css/components/tabs-accordian/custom-tabs.css" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->
    <link rel="stylesheet" type="text/css" href="/admin/plugins/jquery-step/jquery.steps.css">
    <link href="/admin/assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    @endif
    <link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
    <link rel="stylesheet" type="text/css" href="/admin/assets/css/forms/switches.css">
    <style>
        .navbar .theme-brand li.theme-logo img {
            width: 45px;
        }
    </style>
    
    @stack('styles')

</head>
<body>
         <!-- START LOADER  -->
         <div id="load_screen"> <div class="loader"> <div class="loader-content"> <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 792 723" style="enable-background:new 0 0 792 723;" xml:space="preserve"> <g> <g> <path class="st0" d="M213.9,584.4c-47.4-25.5-84.7-60.8-111.8-106.1C75,433.1,61.4,382,61.4,324.9c0-57,13.6-108.1,40.7-153.3 S166.5,91,213.9,65.5s100.7-38.2,159.9-38.2c49.9,0,95,8.8,135.3,26.3s74.1,42.8,101.5,75.7l-85.5,78.9 c-38.9-44.9-87.2-67.4-144.7-67.4c-35.6,0-67.4,7.8-95.4,23.4s-49.7,37.4-65.4,65.4c-15.6,28-23.4,59.8-23.4,95.4 s7.8,67.4,23.4,95.4s37.4,49.7,65.4,65.4c28,15.6,59.7,23.4,95.4,23.4c57.6,0,105.8-22.7,144.7-68.2l85.5,78.9 c-27.4,33.4-61.4,58.9-102,76.5c-40.6,17.5-85.8,26.3-135.7,26.3C314.3,622.7,261.3,809.9,213.9,584.4z"/> </g> <circle class="st1" cx="375.4" cy="322.9" r="100"/> </g> <g> <circle class="st2" cx="275.4" cy="910" r="65"></circle> <circle class="st4" cx="475.4" cy="910" r="65"></circle> </g> </svg> </div></div></div>
         <!--  END LOADER -->

        <!--  BEGIN NAVBAR  -->
        <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">

            <ul class="navbar-item theme-brand flex-row  text-center">
                <li class="nav-item theme-logo">
                    <a href="/admin-panel">
                        <img src="https://res.cloudinary.com/dyyeedzqi/image/upload/w_100,q_100/v1601416550/<?=Auth::user()->custom['setting']['logo']?>" class="navbar-logo" alt="logo">
                    </a>
                </li>
                <li class="nav-item theme-text">
                    @if(App::isLocale('en'))
                        <a href="/admin-panel" class="nav-link"> <?=Auth::user()->custom['setting']['app_name_en']?></a>
                    @else
                        <a href="/admin-panel" class="nav-link"> <?=Auth::user()->custom['setting']['app_name_ar']?></a>
                    @endif
                </li>
            </ul>


            <ul class="navbar-item flex-row ml-md-auto">

                <li class="nav-item dropdown language-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="language-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if(App::isLocale('en'))    
                            <img src="/admin/assets/img/ca.png" class="flag-width" alt="flag">
                        @else
                            <img src="/admin/assets/img/ar.png" class="flag-width" alt="flag">
                        @endif
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="language-dropdown">
                        <a class="dropdown-item d-flex" href="/setlocale/en"><img src="/admin/assets/img/ca.png" class="flag-width" alt="flag"> <span class="align-self-center">&nbsp;{{ __('messages.english') }}</span></a>
                        <a class="dropdown-item d-flex" href="/setlocale/ar"><img src="/admin/assets/img/ar.png" class="flag-width" alt="flag"> <span class="align-self-center">&nbsp;{{ __('messages.arabic') }}</span></a>
                    </div>
                </li>

                <li class="nav-item dropdown user-profile-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <img src="/admin/assets/img/man.png" alt="avatar">
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="">
                            <div class="dropdown-item">
                                <a class="" href="/admin-panel/profile"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> {{ __('messages.myprofile') }} </a>
                            </div>
                          
                            <div class="dropdown-item">
                                <a class="" href="/admin-panel/logout"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> {{ __('messages.signout') }} </a>
                            </div>
                        </div>
                    </div>
                </li>

            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->
    <!--  BEGIN NAVBAR  -->
    <div class="sub-header-container">
        <header class="header navbar navbar-expand-sm">
            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a>

            <ul class="navbar-nav flex-row">
                <li>
                    <div class="page-header">

                        <nav class="breadcrumb-one" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home.ad.index') }}" class="btn btn-dark">{{ __('messages.ad_dashboard') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('home.ecommerce.index') }}" class="btn btn-dark">{{ __('messages.ecommerce_dashboard') }}</a></li>
                            </ol>
                        </nav>

                    </div>
                </li>
            </ul>
            <h4 style="margin: auto; text-align: center">{{ __('messages.prefere_to') }}</h4>
        </header>
    </div>
    <!--  END NAVBAR  -->
    
    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">
        <div class="overlay"></div>
        <div class="search-overlay"></div>
                <!--  BEGIN SIDEBAR  -->
                <div class="sidebar-wrapper sidebar-theme">
            
            <nav id="sidebar">
                <div class="shadow-bottom"></div>
                <ul class="list-unstyled menu-categories" id="accordionExample">
                   
                   @if(in_array(1 , Auth::user()->custom['admin_permission'])) 
                    <li class="menu users">
                        <a href="#users" data-active="true" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle first-link">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                <span>{{ __('messages.users') }}
                                    @if( Auth::user()->custom['user_count'] > 0 )
                                    <span class="unreadcount" > 
                                        <span class="insidecount" > 
                                            <?=Auth::user()->custom['user_count']?> 
                                        </span> 
                                    </span>
                                    @endif
                                </span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled show" id="users" data-parent="#accordionExample">
                            @if(Auth::user()->add_data) 
                            <li class="active add">
                                <a href="/admin-panel/users/add"> {{ __('messages.add') }} </a>
                            </li>
                            @endif
                            <li class="show" >
                                <a href="/admin-panel/users/show"> {{ __('messages.show') }} </a>
                            </li>
                        </ul>
                    </li>
                    @endif

                    @if(in_array(2 , Auth::user()->custom['admin_permission']))
                    <li class="menu app_pages">
                        <a href="#app_pages" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle first-link">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cpu"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
                                <span>{{ __('messages.app_pages') }}</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="app_pages" data-parent="#accordionExample">
                            <li class="aboutapp" >
                                <a href="/admin-panel/app_pages/aboutapp">{{ __('messages.about_app') }}</a>
                            </li>
                            <li class="termsandconditions" >
                                <a href="/admin-panel/app_pages/termsandconditions">{{ __('messages.terms_conditions') }}</a>
                            </li>
                            <li class="deliveryinformation" >
                                <a href="/admin-panel/app_pages/deliveryinformation">{{ __('messages.delivery_information') }}</a>
                            </li>
                            <li class="returnpolicy" >
                                <a href="/admin-panel/app_pages/returnpolicy">{{ __('messages.return_policy') }}</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if(in_array(22 , Auth::user()->custom['admin_permission']))
                    <li class="menu countries">
                        <a href="#countries" data-active="true" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle first-link">
                            <div class="">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                                <span>{{ __('messages.countries') }}</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled show" id="countries" data-parent="#accordionExample">
                            @if(Auth::user()->add_data) 
                                <li class="active add">
                                    <a href="{{ route('countries.add') }}"> {{ __('messages.add') }} </a>
                                </li>
                            @endif
                            <li class="show" >
                                <a href="{{ route('countries.index') }}"> {{ __('messages.show') }} </a>
                            </li>
                        </ul>
                    </li>
                    @endif

                    @if(in_array(35 , Auth::user()->custom['admin_permission']))
                    <li class="menu governorates">
                        <a href="#governorates" data-active="true" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle first-link">
                            <div class="">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                                <span>{{ __('messages.governorates') }}</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled show" id="governorates" data-parent="#accordionExample">
                            @if(Auth::user()->add_data) 
                                <li class="active add">
                                    <a href="{{ route('governorates.add') }}"> {{ __('messages.add') }} </a>
                                </li>
                            @endif
                            <li class="show" >
                                <a href="{{ route('governorates.index') }}"> {{ __('messages.show') }} </a>
                            </li>
                        </ul>
                    </li>
                    @endif

                    @if(in_array(36 , Auth::user()->custom['admin_permission']))
                    <li class="menu governorate-areas">
                        <a href="#governorate-areas" data-active="true" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle first-link">
                            <div class="">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                                <span>{{ __('messages.areas') }}</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled show" id="governorate-areas" data-parent="#accordionExample">
                            @if(Auth::user()->add_data) 
                                <li class="active add">
                                    <a href="{{ route('governorates.areas.add') }}"> {{ __('messages.add') }} </a>
                                </li>
                            @endif
                            <li class="show" >
                                <a href="{{ route('governorates.areas.index') }}"> {{ __('messages.show') }} </a>
                            </li>
                            {{-- <li class="delivery-costs" >
                                <a href="{{ route('governorates.areas.deliveryCosts') }}"> {{ __('messages.delivery_costs') }} </a>
                            </li> --}}
                        </ul>
                    </li>
                    @endif

                    @if(in_array(3 , Auth::user()->custom['admin_permission']))
                    <li class="menu ads">
                        <a href="#ads" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle first-link">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
                                <span>{{ __('messages.ads') }}</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="ads" data-parent="#accordionExample">
                            @if(Auth::user()->add_data) 
                                <li class="add" >
                                    <a href="/admin-panel/ads/add">{{ __('messages.add') }}</a>
                                </li>
                            @endif
                            <li class="show" >
                                <a href="/admin-panel/ads/show">{{ __('messages.show') }}</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if(in_array(38 , Auth::user()->custom['admin_permission']))
                    <li class="menu home-slider">
                        <a href="#home-slider" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle first-link">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
                                <span>{{ __('messages.home_slider') }}</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="home-slider" data-parent="#accordionExample">
                            @if(Auth::user()->add_data)
                                <li class="create" >
                                    <a href="{{ route('home-slider.create') }}">{{ __('messages.add') }}</a>
                                </li>
                            @endif
                            <li class="show" >
                                <a href="{{ route('home-slider.index') }}">{{ __('messages.show') }}</a>
                            </li>
                        </ul>
                    </li>
                    @endif

                    @if(in_array(5 , Auth::user()->custom['admin_permission']))
                    <li class="menu contact_us">
                        <a href="/admin-panel/contact_us" class="dropdown-toggle first-link">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg>
                                <span>{{ __('messages.contact_us') }}
                                      @if( Auth::user()->custom['contact_us_count'] > 0 )   
                                      <span class="unreadcount" > 
                                            <span class="insidecount" > 
                                                <?=Auth::user()->custom['contact_us_count']?> 
                                            </span> 
                                      </span>
                                      @endif  
                                 </span>
                            </div>
                        </a>
                    </li>
                    @endif
                    
                    @if(in_array(20 , Auth::user()->custom['admin_permission']))
                    <li class="menu stats">
                        <a href="{{ route('statistics.index') }}" class="dropdown-toggle first-link">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                                <span>{{ __('messages.statistics') }}</span>
                            </div>
                        </a>
                    </li>
                    @endif

                    @if(in_array(6 , Auth::user()->custom['admin_permission']))    
                    <li class="menu notifications">
                        <a href="#notifications" data-active="true" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle first-link">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                <span>{{ __('messages.notifications') }}</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled show" id="notifications" data-parent="#accordionExample">
                            @if(Auth::user()->add_data) 
                                <li class="active send">
                                    <a href="/admin-panel/notifications/send"> {{ __('messages.send') }} </a>
                                </li>
                            @endif
                            <li class="show" >
                                <a href="/admin-panel/notifications/show"> {{ __('messages.show') }} </a>
                            </li>
                        </ul>
                    </li>
                    @endif        


                    @if(in_array(7 , Auth::user()->custom['admin_permission']))      
                    <li class="menu settings">
                        <a href="/admin-panel/settings" class="dropdown-toggle first-link">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                                <span>{{ __('messages.settings') }}</span>
                            </div>
                        </a>
                    </li>
                    @endif

                    @if(in_array(8 , Auth::user()->custom['admin_permission']))
                    <li class="menu meta_tags">
                        <a href="/admin-panel/meta_tags" class="dropdown-toggle first-link">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>                
                                <span>{{ __('messages.meta_tags') }}</span>
                            </div>
                        </a>
                    </li>
                    @endif

                    @if(in_array(9 , Auth::user()->custom['admin_permission']))
                    <li class="menu managers">
                        <a href="#managers" data-active="true" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle first-link">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>    
                                <span>{{ __('messages.managers') }}</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled show" id="managers" data-parent="#accordionExample">
                            @if(Auth::user()->add_data)
                                <li class="active add">
                                    <a href="/admin-panel/managers/add"> {{ __('messages.add') }} </a>
                                </li>
                            @endif
                            <li class="show" >
                                <a href="/admin-panel/managers/show"> {{ __('messages.show') }} </a>
                            </li>
                        </ul>
                    </li>                    
                    @endif

                    @if(in_array(10 , Auth::user()->custom['admin_permission']))
                    <li class="menu databasebackup">
                        <a href="/admin-panel/databasebackup" class="dropdown-toggle first-link">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>
                                <span>{{ __('messages.databasebackup') }}</span>
                            </div>
                        </a>
                    </li>                 
                    @endif
                </ul>
                <!-- <div class="shadow-bottom"></div> -->
                
            </nav>

        </div>
        <!--  END SIDEBAR  -->

                <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="row layout-top-spacing">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="list-unstyled mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @yield('content')
                    </div>
            </div>
        </div>            
        <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="">{{ __('messages.copyright') }} © 2020 <a target="_blank" class="website-link" href="https://u-smart.co/">{{ __('messages.usmart') }}</a>, {{ __('messages.all_rights_reserved') }}</p>
                </div>
        </div>
    </div>   


    
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="/admin/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="/admin/bootstrap/js/popper.min.js"></script>
    <script src="/admin/bootstrap/js/bootstrap.min.js"></script>
    <script src="/admin/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/admin/plugins/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="/admin/assets/js/app.js"></script>
    
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="/admin/plugins/highlight/highlight.pack.js"></script>
    <script src="/admin/assets/js/custom.js"></script>
    <script src="/admin/assets/js/scrollspyNav.js"></script>
    <script src="/admin/assets/js/components/ui-accordions.js"></script>
    <script src="/admin/plugins/jquery-step/jquery.steps.min.js"></script>
    <script src="/admin/plugins/jquery-step/custom-jquery.steps.js"></script>
    <script src="/admin/plugins/select2/select2.min.js"></script>
    <script src="/admin/plugins/select2/custom-select2.js"></script>
    <script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="/admin/plugins/editors/markdown/simplemde.min.js"></script>
    <script src="/admin/plugins/editors/markdown/custom-markdown.js"></script>
    <script src="/admin/plugins/apex/apexcharts.min.js"></script>
    <script src="/admin/assets/js/dashboard/dash_1.js"></script>
    <script src="/admin/assets/js/dashboard/dash_2.js"></script>
    <script src="/admin/plugins/file-upload/file-upload-with-preview.min.js"></script>
    <script src="/admin/plugins/table/datatable/datatables.js"></script>
    <script src="/admin/plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
    <script src="/admin/plugins/table/datatable/button-ext/jszip.min.js"></script>    
    <script src="/admin/plugins/table/datatable/button-ext/buttons.html5.min.js"></script>
    <script src="/admin/plugins/table/datatable/button-ext/buttons.print.min.js"></script>
    <script>
        var dTbls = $('#html5-extension').DataTable( {
            dom: 'Blfrtip',
            buttons: {
                buttons: [
                    { extend: 'copy', className: 'btn', footer: true, exportOptions: {
                        columns: ':visible',
                        rows: ':visible'
                    } },
                    { extend: 'csv', className: 'btn', footer: true, exportOptions: {
                        columns: ':visible',
                        rows: ':visible'
                    } },
                    { extend: 'excel', className: 'btn', footer: true, exportOptions: {
                        columns: ':visible',
                        rows: ':visible'
                    } },
                    { extend: 'print', className: 'btn', footer: true, 
                        exportOptions: {
                            columns: ':visible',
                            rows: ':visible'
                        }
                    }
                ]
            },
            "Footer": true,
            "scrollX":true,
            "sScrollX": "200%",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [50, 100, 1000, 10000, 100000, 1000000, 2000000, 3000000, 4000000, 5000000],
            "pageLength": 50 
        } );
    </script>
    <script>
        var tbl = $('#without-print').DataTable( {
            "scrollX": true,
            buttons: {
                buttons: [
                    { extend: 'csv', className: 'btn' },
                    { extend: 'excel', className: 'btn' },
                    { extend: 'print', className: 'btn' }
                ]
            },
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [50, 100, 1000, 10000, 100000, 1000000, 2000000, 3000000, 4000000, 5000000],
            "pageLength": 50
        } );
    </script>
    <script src="https://cdn.ckeditor.com/4.14.0/full/ckeditor.js"></script>

        <script>
            CKEDITOR.replace( 'editor-ck-en' );
            CKEDITOR.replace( 'editor-ck-ar' );
        </script>
        
    

    <script>
    $(function() {
        $("#map_url").on("change paste keyup", function() {
            var url = $(this).val();
            var regex = new RegExp('@(.*),(.*),');
            var lon_lat_match = url.match(regex);
            var lon = lon_lat_match[2];
            var lat = lon_lat_match[1];

            $('input[name=longitude]').val(lon);
            $('input[name=latitude]').val(lat);             
        });
    });
    </script>

    <script>
        var firstUpload = new FileUploadWithPreview('myFirstImage')
        var firstUpload = new FileUploadWithPreview('mySecondImage')
    </script>

    <script>
        /*
        ================================================
        |            Aside set active                |
        ================================================
        */

        $(".menu a").removeAttr("data-active");
        $(".menu a").attr("aria-expanded" , "false");
        $(".menu ul").removeClass("show");
        $(".menu ul li").removeClass("active");
        var pathname = window.location.pathname;
        var pathnameArray = pathname.split("/");
        var currentSection = pathnameArray[2];
        $("."+currentSection+" .first-link").attr("data-active" , "true");
        $("."+currentSection+" .first-link").attr("aria-expanded" , "true");
        $("."+currentSection+" ul").addClass("show");
        $("."+currentSection+" ."+pathnameArray[3]).addClass("active")
    </script>
    <script src="/admin/assets/js/apps/invoice.js"></script>
    <script>
        $(".show_actions").on("click", function() {
            
            var  hideTxt = "{{ __('messages.hide_actions') }}",
                 showTxt = "{{ __('messages.show_actions') }}"
                 console.log($(this).data('show'))
            if ($(this).data('show') == 0) {
                $(".hide_col").hide()
                $(this).data('show', 1)
                $(this).text(showTxt)
            }else {
                $(".hide_col").show()
                $(this).data('show', 0)
                $(this).text(hideTxt)
            }
        })
    </script>

    @stack('scripts')

</body>
</html>