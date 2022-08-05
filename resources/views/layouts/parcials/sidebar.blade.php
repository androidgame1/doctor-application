<aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li> <a class="waves-effect waves-dark" href="@if(auth()->user()->is_superadministrator) {{route('superadministrator.home')}}@elseif(auth()->user()->is_administrator) {{route('administrator.home')}}@elseif(auth()->user()->is_secretary) {{route('secretary.home')}} @else javascript:void(0) @endif" aria-expanded="false">
                            <i class="icon-speedometer"></i>
                            <span class="hide-menu">Dashboard</span></a>
                        </li>
                        @if(auth()->user()->is_superadministrator)
                            <li> <a class="waves-effect waves-dark" href="@if(auth()->user()->is_superadministrator) {{route('superadministrator.users','administrator')}} @else javascript:void(0) @endif" aria-expanded="false">
                                <i class="fa fa-users"></i>
                                <span class="hide-menu">Administrators</span></a>
                            </li>
                        @endif
                        @if(auth()->user()->is_administrator)
                            <li> <a class="waves-effect waves-dark" href="@if(auth()->user()->is_administrator) {{route('administrator.suppliers')}} @else javascript:void(0) @endif" aria-expanded="false">
                                <i class="fa fa-users"></i>
                                <span class="hide-menu">Suppliers</span></a>
                            </li>
                            <li> <a class="waves-effect waves-dark" href="@if(auth()->user()->is_administrator) {{route('administrator.products')}} @else javascript:void(0) @endif" aria-expanded="false">
                                <i class="fa fa-th-large"></i>
                                <span class="hide-menu">Products</span></a>
                            </li>
                            <li> <a class="waves-effect waves-dark" href="@if(auth()->user()->is_administrator) {{route('administrator.purchase_invoices')}} @else javascript:void(0) @endif" aria-expanded="false">
                                <i class="fa fa-file"></i>
                                <span class="hide-menu">Purchase invoices</span></a>
                            </li>
                            <li> <a class="waves-effect waves-dark" href="@if(auth()->user()->is_administrator) {{route('administrator.users','secretary')}} @else javascript:void(0) @endif" aria-expanded="false">
                                <i class="fa fa-users"></i>
                                <span class="hide-menu">Secretaries</span></a>
                            </li>
                            <li> <a class="waves-effect waves-dark" href="@if(auth()->user()->is_administrator) {{route('administrator.patients')}} @else javascript:void(0) @endif" aria-expanded="false">
                                <i class="fa fa-users"></i>
                                <span class="hide-menu">Patients</span></a>
                            </li>
                        @endif
                        @if(auth()->user()->is_secretary)
                            <li> <a class="waves-effect waves-dark" href="@if(auth()->user()->is_secretary) {{route('secretary.patients')}} @else javascript:void(0) @endif" aria-expanded="false">
                                <i class="fa fa-users"></i>
                                <span class="hide-menu">Patients</span></a>
                            </li>
                        @endif
                        
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>