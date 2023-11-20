<!DOCTYPE html>
<html lang="fa" class="light-style layout-navbar-fixed layout-menu-fixed" dir="rtl" data-theme="theme-default" data-template="vertical-menu-template">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <title>داشبورد - تجزیه و تحلیل | پیشگامان - قالب مدیریت بوت‌استرپ</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{ config('app.url') }}">

    <meta name="description" content="">

    <link rel="icon" type="image/x-icon" href="{{url('Templates/first/assets/img/favicon/favicon.ico')}}">

    <link rel="stylesheet" href="{{url('Templates/first/assets/vendor/fonts/boxicons.css')}}">
    <link rel="stylesheet" href="{{url('Templates/first/assets/vendor/fonts/fontawesome.css')}}">
    <link rel="stylesheet" href="{{url('Templates/first/assets/vendor/fonts/flag-icons.css')}}">
    <link rel="stylesheet" href="{{url('Templates/first/assets/vendor/css/rtl/core.css')}}" class="template-customizer-core-css">
    <link rel="stylesheet" href="{{url('Templates/first/assets/vendor/css/rtl/theme-default.css')}}" class="template-customizer-theme-css">
    <link rel="stylesheet" href="{{url('Templates/first/assets/css/demo.css')}}">
    <link rel="stylesheet" href="{{url('Templates/first/assets/vendor/css/rtl/rtl.css')}}">
    <link rel="stylesheet" href="{{url('Templates/first/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}">
    
    {{-- <link rel="stylesheet" href="{{url('Templates/first/assets/vendor/libs/typeahead-js/typeahead.css')}}"> --}}
    {{-- <link rel="stylesheet" href="{{url('Templates/first/assets/vendor/libs/apex-charts/apex-charts.css')}}"> --}}
    {{-- <script src="{{url('Templates/first/assets/vendor/js/helpers.js')}}"></script> --}}
    {{-- <script src="{{url('Templates/first/assets/js/config.js')}}"></script> --}}
    
  </head>
  <body>
    <div class="layout-wrapper layout-content-navbar">

        <div class="layout-container">
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="index.html" class="app-brand-link">
                    <span class="app-brand-logo demo">
                        <svg width="26px" height="26px" viewbox="0 0 26 26" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <title>آیکن</title>
                        <defs>
                            <lineargradient x1="50%" y1="0%" x2="50%" y2="100%" id="linearGradient-1">
                            <stop stop-color="#5A8DEE" offset="0%"></stop>
                            <stop stop-color="#699AF9" offset="100%"></stop>
                            </lineargradient>
                            <lineargradient x1="0%" y1="0%" x2="100%" y2="100%" id="linearGradient-2">
                            <stop stop-color="#FDAC41" offset="0%"></stop>
                            <stop stop-color="#E38100" offset="100%"></stop>
                            </lineargradient>
                        </defs>
                        <g id="Pages" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="Login---V2" transform="translate(-667.000000, -290.000000)">
                            <g id="Login" transform="translate(519.000000, 244.000000)">
                                <g id="Logo" transform="translate(148.000000, 42.000000)">
                                <g id="icon" transform="translate(0.000000, 4.000000)">
                                    <path d="M13.8863636,4.72727273 C18.9447899,4.72727273 23.0454545,8.82793741 23.0454545,13.8863636 C23.0454545,18.9447899 18.9447899,23.0454545 13.8863636,23.0454545 C8.82793741,23.0454545 4.72727273,18.9447899 4.72727273,13.8863636 C4.72727273,13.5423509 4.74623858,13.2027679 4.78318172,12.8686032 L8.54810407,12.8689442 C8.48567157,13.19852 8.45300462,13.5386269 8.45300462,13.8863636 C8.45300462,16.887125 10.8856023,19.3197227 13.8863636,19.3197227 C16.887125,19.3197227 19.3197227,16.887125 19.3197227,13.8863636 C19.3197227,10.8856023 16.887125,8.45300462 13.8863636,8.45300462 C13.5386269,8.45300462 13.19852,8.48567157 12.8689442,8.54810407 L12.8686032,4.78318172 C13.2027679,4.74623858 13.5423509,4.72727273 13.8863636,4.72727273 Z" id="Combined-Shape" fill="#4880EA"></path>
                                    <path d="M13.5909091,1.77272727 C20.4442608,1.77272727 26,7.19618701 26,13.8863636 C26,20.5765403 20.4442608,26 13.5909091,26 C6.73755742,26 1.18181818,20.5765403 1.18181818,13.8863636 C1.18181818,13.540626 1.19665566,13.1982714 1.22574292,12.8598734 L6.30410592,12.859962 C6.25499466,13.1951893 6.22958398,13.5378796 6.22958398,13.8863636 C6.22958398,17.8551125 9.52536149,21.0724191 13.5909091,21.0724191 C17.6564567,21.0724191 20.9522342,17.8551125 20.9522342,13.8863636 C20.9522342,9.91761479 17.6564567,6.70030817 13.5909091,6.70030817 C13.2336969,6.70030817 12.8824272,6.72514561 12.5388136,6.77314791 L12.5392575,1.81561642 C12.8859498,1.78721495 13.2366963,1.77272727 13.5909091,1.77272727 Z" id="Combined-Shape2" fill="url(#linearGradient-1)"></path>
                                    <rect id="Rectangle" fill="url(#linearGradient-2)" x="0" y="0" width="7.68181818" height="7.68181818"></rect>
                                </g>
                                </g>
                            </g>
                            </g>
                        </g>
                        </svg>
                    </span>
                    <span class="app-brand-text demo menu-text fw-bold ms-2">پیشگامان</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                    <i class="bx menu-toggle-icon d-none d-xl-block fs-4 align-middle"></i>
                    <i class="bx bx-x d-block d-xl-none bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-divider mt-0"></div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    @foreach ($sidebar as $key => $menu)
                        @if($menu instanceof Illuminate\Database\Eloquent\Collection)
                            <li class="menu-item active open">
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                                    <div data-i18n="Dashboards">{{$key ?? '???'}}</div>
                                </a>
                                <ul class="menu-sub">
                                    @foreach($menu as $subItem)
                                    <li class="menu-item">
                                        <a href="{{$subItem->route ? route($subItem->route) : (url($subItem->url) ?? '#')}}{{$subItem->route ? '?action='.$subItem->url : ''}}" class="menu-link">
                                            <div data-i18n="Analytics">{{__($subItem->packeage.'::RoutName.'.($subItem->name ?? '???'))}}</div>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            @if($menu->type == 'header')
                                <li class="menu-header small text-uppercase"><span class="menu-header-text">{{__($menu->packeage.'::RoutName.'.($menu->name ?? '???'))}}</span></li>
                            @endif
                            @if($menu->type == '')
                                <li class="menu-item">
                                    <a href="{{$menu->route ? route($menu->route) : (url($menu->url) ?? '#')}}{{$menu->route ? ($menu->url ? '?action='.$menu->url : '') : ''}}" class="menu-link">
                                        <i class="menu-icon {{$menu->icon ?? ''}}"></i>
                                        <div>{{__($menu->packeage.'::RoutName.'.($menu->name ?? '???'))}}</div>
                                    </a>
                                </li>
                            @endif
                        @endif
                    @endforeach
                </ul>
            </aside>

            <div class="layout-page">
                <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
                <div class="container-fluid">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                        <i class="bx bx-menu bx-sm"></i>
                    </a>
                    </div>
    
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                    <!-- Search -->
                    <div class="navbar-nav align-items-center">
                        <div class="nav-item navbar-search-wrapper mb-0">
                        <a class="nav-item nav-link search-toggler px-0" href="javascript:void(0);">
                            <i class="bx bx-search-alt bx-sm"></i>
                            <span class="d-none d-md-inline-block text-muted">جستجو <span class="d-inline-block" dir="ltr">(Ctrl+/)</span></span>
                        </a>
                        </div>
                    </div>
                    <!-- /Search -->
    
                    <ul class="navbar-nav flex-row align-items-center ms-auto">
                        <!-- Language -->
                        <li class="nav-item dropdown-language dropdown me-2 me-xl-0">
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                            <i class="fi fi-ir fis rounded-circle fs-3 me-1"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-language="fa">
                                <i class="fi fi-ir fis rounded-circle fs-4 me-1"></i>
                                <span class="align-middle">فارسی</span>
                            </a>
                            </li>
                        </ul>
                        </li>
                        <!--/ Language -->
    
                        <!-- Style Switcher -->
                        <li class="nav-item me-2 me-xl-0">
                        <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
                            <i class="bx bx-sm"></i>
                        </a>
                        </li>
                        <!--/ Style Switcher -->
    
                        <!-- Quick links  -->
                        <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0">
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <i class="bx bx-grid-alt bx-sm"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end py-0">
                            <div class="dropdown-menu-header border-bottom">
                            <div class="dropdown-header d-flex align-items-center py-3">
                                <h5 class="text-body mb-0 me-auto secondary-font">میانبرها</h5>
                                <a href="javascript:void(0)" class="dropdown-shortcuts-add text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="افزودن میانبر"><i class="bx bx-sm bx-plus-circle"></i></a>
                            </div>
                            </div>
                            <div class="dropdown-shortcuts-list scrollable-container">
                            <div class="row row-bordered overflow-visible g-0">
                                <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                    <i class="bx bx-calendar fs-4"></i>
                                </span>
                                <a href="app-calendar.html" class="stretched-link">تقویم</a>
                                <small class="text-muted mb-0">قرارهای ملاقات</small>
                                </div>
                                <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                    <i class="bx bx-food-menu fs-4"></i>
                                </span>
                                <a href="app-invoice-list.html" class="stretched-link">برنامه صورتحساب</a>
                                <small class="text-muted mb-0">مدیریت حساب‌ها</small>
                                </div>
                            </div>
                            <div class="row row-bordered overflow-visible g-0">
                                <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                    <i class="bx bx-user fs-4"></i>
                                </span>
                                <a href="app-user-list.html" class="stretched-link">برنامه کاربر</a>
                                <small class="text-muted mb-0">مدیریت کاربران</small>
                                </div>
                                <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                    <i class="bx bx-check-shield fs-4"></i>
                                </span>
                                <a href="app-access-roles.html" class="stretched-link">مدیریت نقش‌‌ها</a>
                                <small class="text-muted mb-0">مجوزها</small>
                                </div>
                            </div>
                            <div class="row row-bordered overflow-visible g-0">
                                <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                    <i class="bx bx-pie-chart-alt-2 fs-4"></i>
                                </span>
                                <a href="index.html" class="stretched-link">داشبورد</a>
                                <small class="text-muted mb-0">پروفایل کاربر</small>
                                </div>
                                <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                    <i class="bx bx-cog fs-4"></i>
                                </span>
                                <a href="pages-account-settings-account.html" class="stretched-link">تنظیمات</a>
                                <small class="text-muted mb-0">تنظیمات حساب</small>
                                </div>
                            </div>
                            <div class="row row-bordered overflow-visible g-0">
                                <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                    <i class="bx bx-help-circle fs-4"></i>
                                </span>
                                <a href="pages-help-center-landing.html" class="stretched-link">مرکز راهنمایی</a>
                                <small class="text-muted mb-0">سوالات متداول و مقالات</small>
                                </div>
                                <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                    <i class="bx bx-window-open fs-4"></i>
                                </span>
                                <a href="modal-examples.html" class="stretched-link">مودال‌ها</a>
                                <small class="text-muted mb-0">پاپ‌آپ‌های کاربردی</small>
                                </div>
                            </div>
                            </div>
                        </div>
                        </li>
                        <!-- Quick links -->
    
                        <!-- Notification -->
                        <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <i class="bx bx-bell bx-sm"></i>
                            <span class="badge bg-danger rounded-pill badge-notifications">5</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end py-0">
                            <li class="dropdown-menu-header border-bottom">
                            <div class="dropdown-header d-flex align-items-center py-3">
                                <h5 class="text-body mb-0 me-auto secondary-font">اعلان‌ها</h5>
                                <a href="javascript:void(0)" class="dropdown-notifications-all text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark all as read"><i class="bx fs-4 bx-envelope-open"></i></a>
                            </div>
                            </li>
                            <li class="dropdown-notifications-list scrollable-container">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        <img src="assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle">
                                    </div>
                                    </div>
                                    <div class="flex-grow-1">
                                    <h6 class="mb-1">تبریک می‌گوییم کلارک</h6>
                                    <p class="mb-1">شما نشان فروشنده برتر ماه را برنده شدید</p>
                                    <small class="text-muted">1 ساعت قبل</small>
                                    </div>
                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                    <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                                    <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                                    </div>
                                </div>
                                </li>
                                <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        <span class="avatar-initial rounded-circle bg-label-danger">اک</span>
                                    </div>
                                    </div>
                                    <div class="flex-grow-1">
                                    <h6 class="mb-1">دیوید بکهام</h6>
                                    <p class="mb-1">درخواست شما را قبول کرد.</p>
                                    <small class="text-muted">12 ساعت قبل</small>
                                    </div>
                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                    <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                                    <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                                    </div>
                                </div>
                                </li>
                                <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        <img src="assets/img/avatars/2.png" alt class="w-px-40 h-auto rounded-circle">
                                    </div>
                                    </div>
                                    <div class="flex-grow-1">
                                    <h6 class="mb-1">پیام جدید</h6>
                                    <p class="mb-1">شما پیام جدید از ناتالی دارید</p>
                                    <small class="text-muted">1 ساعت قبل</small>
                                    </div>
                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                    <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                                    <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                                    </div>
                                </div>
                                </li>
                                <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        <span class="avatar-initial rounded-circle bg-label-success"><i class="bx bx-cart"></i></span>
                                    </div>
                                    </div>
                                    <div class="flex-grow-1">
                                    <h6 class="mb-1">هورا! شما سفارش جدید دارید</h6>
                                    <p class="mb-1">شرکت گوگل یک سفارش جدید ثبت کرد</p>
                                    <small class="text-muted">1 روز قبل</small>
                                    </div>
                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                    <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                                    <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                                    </div>
                                </div>
                                </li>
                                <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        <img src="assets/img/avatars/9.png" alt class="w-px-40 h-auto rounded-circle">
                                    </div>
                                    </div>
                                    <div class="flex-grow-1">
                                    <h6 class="mb-1">برنامه مورد تایید قرار گرفت</h6>
                                    <p class="mb-1">برنامه پروژه مدیریت شما پذیرفته شد.</p>
                                    <small class="text-muted">2 روز قبل</small>
                                    </div>
                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                    <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                                    <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                                    </div>
                                </div>
                                </li>
                                <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        <span class="avatar-initial rounded-circle bg-label-success"><i class="bx bx-pie-chart-alt"></i></span>
                                    </div>
                                    </div>
                                    <div class="flex-grow-1">
                                    <h6 class="mb-1">گزارش ماهانه ایجاد شد</h6>
                                    <p class="mb-1">گزارش ماهانه ماه خرداد ایجاد شد</p>
                                    <small class="text-muted">3 روز قبل</small>
                                    </div>
                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                    <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                                    <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                                    </div>
                                </div>
                                </li>
                                <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        <img src="assets/img/avatars/5.png" alt class="w-px-40 h-auto rounded-circle">
                                    </div>
                                    </div>
                                    <div class="flex-grow-1">
                                    <h6 class="mb-1">ارسال درخواست ارتباط</h6>
                                    <p class="mb-1">پیتر یک درخواست ارتباط برای شما ارسال کرد</p>
                                    <small class="text-muted">4 روز قبل</small>
                                    </div>
                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                    <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                                    <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                                    </div>
                                </div>
                                </li>
                                <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        <img src="assets/img/avatars/6.png" alt class="w-px-40 h-auto rounded-circle">
                                    </div>
                                    </div>
                                    <div class="flex-grow-1">
                                    <h6 class="mb-1">پیام جدید از جین</h6>
                                    <p class="mb-1">شما پیام جدید از سمت جین دارید</p>
                                    <small class="text-muted">5 روز قبل</small>
                                    </div>
                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                    <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                                    <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                                    </div>
                                </div>
                                </li>
                                <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        <span class="avatar-initial rounded-circle bg-label-warning"><i class="bx bx-error"></i></span>
                                    </div>
                                    </div>
                                    <div class="flex-grow-1">
                                    <h6 class="mb-1">میزان مصرف CPU بالاست</h6>
                                    <p class="mb-1">میران مصرف CPU در حال حاضر 88.63% است</p>
                                    <small class="text-muted">5 روز قبل</small>
                                    </div>
                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                    <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                                    <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                                    </div>
                                </div>
                                </li>
                            </ul>
                            </li>
                            <li class="dropdown-menu-footer border-top">
                            <a href="javascript:void(0);" class="dropdown-item d-flex justify-content-center p-3">
                                مشاهده همه اعلان‌ها
                            </a>
                            </li>
                        </ul>
                        </li>
                        <!--/ Notification -->
    
                        <!-- User -->
                        <li class="nav-item navbar-dropdown dropdown-user dropdown">
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                            <div class="avatar avatar-online">
                            <img src="assets/img/avatars/1.png" alt class="rounded-circle">
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                            <a class="dropdown-item" href="pages-account-settings-account.html">
                                <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                    <img src="assets/img/avatars/1.png" alt class="rounded-circle">
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">جان اسنو</span>
                                    <small>مدیر</small>
                                </div>
                                </div>
                            </a>
                            </li>
                            <li>
                            <div class="dropdown-divider"></div>
                            </li>
                            <li>
                            <a class="dropdown-item" href="pages-profile-user.html">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">پروفایل من</span>
                            </a>
                            </li>
                            <li>
                            <a class="dropdown-item" href="pages-account-settings-account.html">
                                <i class="bx bx-cog me-2"></i>
                                <span class="align-middle">تنظیمات</span>
                            </a>
                            </li>
                            <li>
                            <a class="dropdown-item" href="pages-account-settings-billing.html">
                                <span class="d-flex align-items-center align-middle">
                                <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                                <span class="flex-grow-1 align-middle">صورتحساب</span>
                                <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                                </span>
                            </a>
                            </li>
                            <li>
                            <div class="dropdown-divider"></div>
                            </li>
                            <li>
                            <a class="dropdown-item" href="pages-help-center-landing.html">
                                <i class="bx bx-support me-2"></i>
                                <span class="align-middle">راهنمایی</span>
                            </a>
                            </li>
                            <li>
                            <a class="dropdown-item" href="pages-faq.html">
                                <i class="bx bx-help-circle me-2"></i>
                                <span class="align-middle">سوالات متداول</span>
                            </a>
                            </li>
                            <li>
                            <a class="dropdown-item" href="pages-pricing.html">
                                <i class="bx bx-dollar me-2"></i>
                                <span class="align-middle">قیمت گذاری</span>
                            </a>
                            </li>
                            <li>
                            <div class="dropdown-divider"></div>
                            </li>
                            <li>
                            <a class="dropdown-item" href="auth-login-cover.html" target="_blank">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">خروج</span>
                            </a>
                            </li>
                        </ul>
                        </li>
                        <!--/ User -->
                    </ul>
                    </div>
    
                    <!-- Search Small Screens -->
                    <div class="navbar-search-wrapper search-input-wrapper d-none">
                    <input type="text" class="form-control search-input container-fluid border-0" placeholder="جستجو ..." aria-label="Search...">
                    <i class="bx bx-x bx-sm search-toggler cursor-pointer"></i>
                    </div>
                </div>
                </nav>            

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="py-3 breadcrumb-wrapper mb-4">
                            <span class="text-muted fw-light">مسیر 1/</span> مسیر
                        </h4>

                        @if(($card ?? '' )!= '')
                        <div class="row">
                            <div class="col-lg-12 col-md-12 mb-4">
                                <div class="card h-100">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">آمار وب‌سایت</h5>
                                            <div class="dropdown primary-font">
                                            <button class="btn p-0" type="button" id="analyticsOptions" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="analyticsOptions">
                                                <a class="dropdown-item" href="javascript:void(0);">انتخاب همه</a>
                                                <a class="dropdown-item" href="javascript:void(0);">تازه سازی</a>
                                                <a class="dropdown-item" href="javascript:void(0);">اشتراک گذاری</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pb-2" style="position: relative;">
                                        <div class="d-flex justify-content-around align-items-center flex-wrap mb-4">
                                            @yield('content')                    
                                        </div>
                                    </div>
                                </div>
                            </div>   
                        </div>
                        @else
                            @yield('content')                    
                        @endif
                    </div>
                </div>

            </div>            
        </div>
    </div>
  <script src="{{url('Templates/first/assets/vendor/libs/jquery/jquery.js')}}"></script>
  <script src="{{url('Templates/first/assets/vendor/libs/popper/popper.js')}}"></script>
  <script src="{{url('Templates/first/assets/vendor/js/bootstrap.js')}}"></script>
  <script src="{{url('Templates/first/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
  {{-- <script src="{{url('Templates/first/assets/vendor/libs/hammer/hammer.js')}}"></script> --}}
  <script src="{{url('Templates/first/assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>
  <script src="{{url('Templates/first/assets/vendor/js/menu.js')}}"></script>
  {{-- <script src="{{url('Templates/first/assets/vendor/libs/apex-charts/apexcharts.js')}}"></script> --}}
  {{-- <script src="{{url('Templates/first/assets/js/main.js')}}"></script> --}}
  {{-- <script src="{{url('Templates/first/assets/js/dashboards-analytics.js')}}"></script> --}}

    @if(($mix ?? '') != '')
        @foreach ($mix as $item)
            @vite($item)
        @endforeach
    @endif
</body>
</html>