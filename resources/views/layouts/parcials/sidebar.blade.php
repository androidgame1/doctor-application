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
                                <span class="hide-menu">{{__('messages.administrators')}}</span></a>
                            </li>
                        @endif
                        @if(auth()->user()->is_administrator)
                            <li> <a class="waves-effect waves-dark" href="@if(auth()->user()->is_administrator) {{route('administrator.suppliers')}} @else javascript:void(0) @endif" aria-expanded="false">
                                <i class="fa fa-users"></i>
                                <span class="hide-menu">{{__('messages.suppliers')}}</span></a>
                            </li>
                            <li> <a class="waves-effect waves-dark" href="@if(auth()->user()->is_administrator) {{route('administrator.products')}} @else javascript:void(0) @endif" aria-expanded="false">
                                <i class="fa fa-th-large"></i>
                                <span class="hide-menu">{{__('messages.products')}}</span></a>
                            </li>
                            <li> <a class="waves-effect waves-dark" href="@if(auth()->user()->is_administrator) {{route('administrator.purchase_invoices')}} @else javascript:void(0) @endif" aria-expanded="false">
                                <i class="fa fa-file"></i>
                                <span class="hide-menu">{{__('messages.purchase_invoices')}}</span></a>
                            </li>
                            <li> <a class="waves-effect waves-dark" href="@if(auth()->user()->is_administrator) {{route('administrator.users','secretary')}} @else javascript:void(0) @endif" aria-expanded="false">
                                <i class="fa fa-users"></i>
                                <span class="hide-menu">{{__('messages.secretaries')}}</span></a>
                            </li>
                            <li> <a class="waves-effect waves-dark" href="@if(auth()->user()->is_administrator) {{route('administrator.patients')}} @else javascript:void(0) @endif" aria-expanded="false">
                                <i class="fa fa-users"></i>
                                <span class="hide-menu">{{__('messages.patients')}}</span></a>
                            </li>
                            <li> <a class="waves-effect waves-dark" href="@if(auth()->user()->is_administrator) {{route('administrator.calendar')}} @else javascript:void(0) @endif" aria-expanded="false">
                                <i class="fa fa-calendar"></i>
                                <span class="hide-menu">{{__('messages.calendar')}}</span></a>
                            </li>
                            <li> <a class="waves-effect waves-dark" href="@if(auth()->user()->is_administrator) {{route('administrator.appointments','appointments')}} @else javascript:void(0) @endif" aria-expanded="false">
                                <i class="fa fa-calendar-o"></i>
                                <span class="hide-menu">{{__('messages.appointments')}}</span></a>
                            </li>
                            <li> <a class="waves-effect waves-dark" href="@if(auth()->user()->is_administrator) {{route('administrator.acts')}} @else javascript:void(0) @endif" aria-expanded="false">
                                <i class="fa fa-cubes"></i>
                                <span class="hide-menu">{{__('messages.acts')}}</span></a>
                            </li>
                            <li> <a class="waves-effect waves-dark" href="@if(auth()->user()->is_administrator) {{route('administrator.activities')}} @else javascript:void(0) @endif" aria-expanded="false">
                                <i class="fa fa-file-text"></i>
                                <span class="hide-menu">{{__('messages.activities')}}</span></a>
                            </li>
                            <li> <a class="waves-effect waves-dark" href="@if(auth()->user()->is_administrator) {{route('administrator.sale_invoices')}} @else javascript:void(0) @endif" aria-expanded="false">
                                <i class="fa fa-file"></i>
                                <span class="hide-menu">{{__('messages.sale_invoices')}}</span></a>
                            </li>
                            <li> <a class="waves-effect waves-dark" href="@if(auth()->user()->is_administrator) {{route('administrator.prescriptions')}} @else javascript:void(0) @endif" aria-expanded="false">
                                <i class="fa fa-file-o"></i>
                                <span class="hide-menu">{{__('messages.prescription')}}</span></a>
                            </li>
                            <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-cogs"></i><span class="hide-menu">{{__('messages.setting')}}</span></a>
                                <ul aria-expanded="false" class="collapse">
                                <li><a href="@if(auth()->user()->is_administrator) {{route('administrator.type_drugs')}} @else javascript:void(0) @endif">{{__('messages.types_of_drug')}}</a></li>
                                    <li><a href="@if(auth()->user()->is_administrator) {{route('administrator.drugs')}} @else javascript:void(0) @endif">{{__('messages.drugs')}}</a></li>
                                    <li><a href="@if(auth()->user()->is_administrator) {{route('administrator.tests')}} @else javascript:void(0) @endif">{{__('messages.tests')}}</a></li>
                                    <li><a href="@if(auth()->user()->is_administrator) {{route('administrator.status')}} @else javascript:void(0) @endif">{{__('messages.status')}}</a></li>
                                </ul>
                            </li>
                        @endif
                        @if(auth()->user()->is_secretary)
                            <li> <a class="waves-effect waves-dark" href="@if(auth()->user()->is_secretary) {{route('secretary.patients')}} @else javascript:void(0) @endif" aria-expanded="false">
                                <i class="fa fa-users"></i>
                                <span class="hide-menu">{{__('messages.Patients')}}</span></a>
                            </li>
                            <li> <a class="waves-effect waves-dark" href="@if(auth()->user()->is_secretary) {{route('secretary.calendar')}} @else javascript:void(0) @endif" aria-expanded="false">
                                <i class="fa fa-calendar"></i>
                                <span class="hide-menu">{{__('messages.Calendar')}}</span></a>
                            </li>
                            <li> <a class="waves-effect waves-dark" href="@if(auth()->user()->is_secretary) {{route('secretary.appointments','appointments')}} @else javascript:void(0) @endif" aria-expanded="false">
                                <i class="fa fa-calendar-o"></i>
                                <span class="hide-menu">{{__('messages.Appointments')}}</span></a>
                            </li>
                        @endif
                        
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>