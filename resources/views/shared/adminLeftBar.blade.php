<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('dashboard.index') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>{{ __('ٍSMT') }}</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>{{ __('ٍSMT') }}</b> {{ __('Stationery') }}</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu ">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">4</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 4 messages</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li><!-- start message -->
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}"
                                                 class="img-circle" alt="User Image">
                                        </div>
                                        <h4>
                                            Support Team
                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <!-- end message -->
                            </ul>
                        </li>
                        <li class="footer"><a href="#">See All Messages</a></li>
                    </ul>
                </li>
                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">10</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 10 notifications</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li>
                <!-- Tasks: style can be found in dropdown.less -->
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag-o"></i>
                        <span class="label label-danger">9</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 9 tasks</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Design some buttons
                                            <small class="pull-right">20%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                                 role="progressbar"
                                                 aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">20% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#">View all tasks</a>
                        </li>
                    </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}" class="user-image"
                             alt="User Image">
                        <span class="hidden-xs">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}" class="img-circle"
                                 alt="User Image">

                            <p>
                                {{ auth()->user()->name }}
                                <small>{{ auth()->user()->role->name }}</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <a href="#">Followers</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Friends</a>
                                </div>
                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<!-- =============================================== -->

<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ auth()->user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> {{ auth()->user()->role->name }}</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ request()->is('*/dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard.index') }}">
                    <i class="fa fa-dashboard"></i> <span>{{ __('Dashboard') }}</span>
                </a>
            </li>
            <li class="{{ request()->is(['*/dashboard/items', '*/dashboard/items/*']) ? 'active' : '' }}">
                <a href="{{ route('dashboard.items.index') }}">
                    <i class="fa fa-list"></i> <span>{{ __('Items') }}</span>
                </a>
            </li>
            <li class="treeview {{ request()->is([
                                                    '*/dashboard/customers',
                                                    '*/dashboard/customers/*',
                                                    '*/dashboard/orders',
                                                    '*/dashboard/orders/*',
                                                    '*/dashboard/customerPayments',
                                                    '*/dashboard/customerPayments/*',
                                                    ]) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-circle-o"></i>
                    <span>{{ __('Customers') }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ request()->is(['*/dashboard/customers','*/dashboard/customers/*']) ? 'active' : '' }}">
                        <a href="{{ route('dashboard.customers.index') }}">
                            <i class="fa fa-users"></i> <span>{{ __('Customers') }}</span>
                        </a>
                    </li>
                    <li class="{{ request()->is(['*/dashboard/orders','*/dashboard/orders/*']) ? 'active' : '' }}">
                        <a href="{{ route('dashboard.orders.index') }}">
                            <i class="fa fa-shopping-cart"></i> <span>{{ __('Orders') }}</span>
                        </a>
                    </li>
                    <li class="{{ request()->is(['*/dashboard/customerPayments','*/dashboard/customerPayments/*']) ? 'active' : '' }}">
                        <a href="{{ route('dashboard.customerPayments.index') }}">
                            <i class="fa fa-money"></i> <span>{{ __('Customer Payments') }}</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="treeview {{ request()->is([
                                                    '*/dashboard/suppliers',
                                                    '*/dashboard/suppliers/*',
                                                    '*/dashboard/bills',
                                                    '*/dashboard/bills/*',
                                                    '*/dashboard/supplierPayments',
                                                    '*/dashboard/supplierPayments/*',
                                                    ]) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-circle-o"></i>
                    <span>{{ __('Suppliers') }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ request()->is(['*/dashboard/suppliers','*/dashboard/suppliers/*']) ? 'active' : '' }}">
                        <a href="{{ route('dashboard.suppliers.index') }}">
                            <i class="fa fa-cube"></i> <span>{{ __('Suppliers') }}</span>
                        </a>
                    </li>
                    <li class="{{ request()->is(['*/dashboard/bills','*/dashboard/bills/*']) ? 'active' : '' }}">
                        <a href="{{ route('dashboard.bills.index') }}">
                            <i class="fa fa-truck"></i> <span>{{ __('Bills') }}</span>
                        </a>
                    </li>
                    <li class="{{ request()->is(['*/dashboard/supplierPayments','*/dashboard/supplierPayments/*']) ? 'active' : '' }}">
                        <a href="{{ route('dashboard.supplierPayments.index') }}">
                            <i class="fa fa-credit-card-alt"></i> <span>{{ __('Supplier Payments') }}</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="header">LABELS</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<!-- =============================================== -->
