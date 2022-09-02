<header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="@if(auth()->user()->is_superadministrator) {{route('superadministrator.home')}}@elseif(auth()->user()->is_administrator) {{route('administrator.home')}}@elseif(auth()->user()->is_secretary) {{route('secretary.home')}} @else javascript:void(0) @endif">
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="{{asset('assets/images/logo-icon.png')}}" alt="homepage" class="dark-logo" />
                            <!-- Light Logo icon -->
                            <img src="{{asset('assets/images/logo-light-icon.png')}}" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text --><span>
                         <!-- dark Logo text -->
                         <img src="{{asset('assets/images/logo-text.png')}}" alt="homepage" class="dark-logo" />
                         <!-- Light Logo text -->    
                         <img src="{{asset('assets/images/logo-light-text.png')}}" class="light-logo" alt="homepage" /></span> </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler d-block d-sm-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                        
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- User Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">  <span class="hidden-md-down">{{Session::get('lang_code') ?? 'en'}} </span> </a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">

                                <!-- text-->
                                <a href="{{route('change.language','en')}}" class="dropdown-item">En</a>
                                <!-- text-->
                                <a href="{{route('change.language','fr')}}" class="dropdown-item">Fr</a>
                                <!-- text-->
                                <div class="dropdown-divider"></div>
                                <!-- text-->
                            </div>
                        </li>
                        <li class="nav-item dropdown u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset(auth()->user()->image)}}" onerror="this.src=`{{asset('assets/images/users/default-user.png')}}`" alt="user" class=""> <span class="hidden-md-down">{{auth()->user()->fullname}} &nbsp;<i class="fa fa-angle-down"></i></span> </a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                <!-- text-->
                                <a href="@if(auth()->user()->is_superadministrator){{route('superadministrator.profile.edit')}}@elseif(auth()->user()->is_administrator){{route('administrator.profile.edit')}}@elseif(auth()->user()->is_secretary){{route('secretary.profile.edit')}}@else javascript:void(0) @endif" class="dropdown-item"><i class="ti-user"></i> {{__('messages.profile')}}</a>
                                <!-- text-->
                                <a href="@if(auth()->user()->is_superadministrator){{route('superadministrator.password.edit')}}@elseif(auth()->user()->is_administrator){{route('administrator.password.edit')}}@elseif(auth()->user()->is_secretary){{route('secretary.profile.edit')}}@else javascript:void(0) @endif" class="dropdown-item"><i class="ti-key"></i> {{__('messages.change_password')}}</a>
                                <!-- text-->
                                <div class="dropdown-divider"></div>
                                <!-- text-->
                                <!-- text-->
                                <a href="javascript:void(0)" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('form-logout').submit()"><i class="fa fa-power-off"></i> {{__('messages.logout')}}</a>
                                <form id="form-logout" class="d-none" method='post' action="{{ route('logout') }}">
                                    @method('post')
                                    @csrf
                                </form>
                                <!-- text-->
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End User Profile -->
                        <!-- ============================================================== -->
                        
                    </ul>
                </div>
            </nav>
        </header>