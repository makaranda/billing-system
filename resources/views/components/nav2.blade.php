<div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" data-background-color="dark">
      @auth
      <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
          <a href="{{ URL::to('dashboard') }}" class="logo text-white text-uppercase">
             GIL Reminders
          </a>
          <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
              <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
              <i class="gg-menu-left"></i>
            </button>
          </div>
          <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
          </button>
        </div>
        <!-- End Logo Header -->
      </div>
      <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
          <ul class="nav nav-secondary">
            <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
              <a
                href="{{ URL::to('dashboard') }}"
              >
                <i class="fas fa-home"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li class="nav-section">
              <span class="sidebar-mini-icon">
                <i class="fa fa-ellipsis-h"></i>
              </span>
              <h4 class="text-section {{ request()->routeIs('index.reminders', 'index.prepaid', 'index.customers') ? '' : 'd-none' }}">Menus</h4>
            </li>
            @if(Auth::user()->privilege === 'admin')
            {{-- <li class="nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
              <a data-bs-toggle="collapse" href="#users">
                <i class="fas fa-layer-group"></i>
                <p>Users</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="users">
                <ul class="nav nav-collapse">
                  <li>
                    <a class="sub-item" href="{{ URL::to('users') }}"><span class="sub-item">Users</span></a>
                  </li>
                </ul>
              </div>
            </li> --}}

            {{-- <li class="nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <a data-bs-toggle="collapse" href="#users">
                  <i class="fas fa-layer-group"></i>
                  <p>Users</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="users">
                  <ul class="nav nav-collapse">
                    <li>
                      <a class="sub-item" href="{{ route('admin.users') }}"><span class="sub-item">Users</span></a>
                    </li>
                  </ul>
                </div>
              </li> --}}

            {{-- {{ var_dump($subMenus) }} --}}

            @if ($mainMenus)

                @foreach($mainMenus as $key => $mainMenu)
                    @if(request()->routeIs($mainMenu->route))
                    <li class="nav-item {{ request()->routeIs($mainMenu->route) ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#menuAre{{ $key+1 }}">
                            <i class="fas fa-layer-group"></i>
                            <p class="text-uppercase">{{ $mainMenu->name }}</p>
                            <span class="caret"></span>
                        </a>

                        @if($mainMenu->subMenus->isNotEmpty())
                        <div class="collapse show" id="#menuAre{{ $key+1 }}">
                            <ul class="nav nav-collapse">
                                @foreach($mainMenu->subMenus as $subMenu)
                                    <li class="{{ request()->routeIs($subMenu->route) ? 'active' : '' }}">
                                        <a class="sub-item" href="{{ route($subMenu->route) }}"><span class="sub-item">{{ $subMenu->name }}</span></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </li>
                    @endif
                @endforeach

            @endif
              @if (request()->routeIs('index.reminders'))
              {{-- <li class="nav-item {{ request()->routeIs('index.reminders') ? 'active' : '' }}">
                <a data-bs-toggle="collapse" href="#reminders">
                  <i class="fas fa-layer-group"></i>
                  <p class="text-uppercase">Reminders</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse show" id="reminders">
                  <ul class="nav nav-collapse">
                    {{-- @if ($subMenus)
                        @foreach($subMenus as $subMenu)
                            <li class="{{ request()->routeIs($subMenu->route) ? 'active' : '' }}">
                                <a class="sub-item" href="{{ route($subMenu->route) }}"><span class="sub-item">{{ $subMenu->name }}</span></a>
                            </li>
                        @endforeach
                    @endif --}}
                {{--  </ul>
                </div>
              </li> --}}
              @endif

              {{-- @if (request()->routeIs('index.prepaid'))
              <li class="nav-item {{ request()->routeIs('index.prepaid') ? 'active' : '' }}">
                <a data-bs-toggle="collapse" href="#prepaid">
                  <i class="fas fa-layer-group"></i>
                  <p class="text-uppercase">Prepaid</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="prepaid">
                  <ul class="nav nav-collapse">
                    <li>
                      <a class="sub-item" href="{{ route('index.prepaid') }}"><span class="sub-item">Prepaid</span></a>
                    </li>
                  </ul>
                </div>
              </li>
              @endif

              @if (request()->routeIs('index.customers'))
              <li class="nav-item {{ request()->routeIs('index.customers') ? 'active' : '' }}">
                <a data-bs-toggle="collapse" href="#customers">
                  <i class="fas fa-layer-group"></i>
                  <p class="text-uppercase">Customers</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="customers">
                  <ul class="nav nav-collapse">
                    <li>
                      <a class="sub-item" href="{{ route('index.customers') }}"><span class="sub-item">Customers</span></a>
                    </li>
                  </ul>
                </div>
              </li>
              @endif

              @if (request()->routeIs('index.documents'))
              <li class="nav-item {{ request()->routeIs('index.documents') ? 'active' : '' }}">
                <a data-bs-toggle="collapse" href="#documents">
                  <i class="fas fa-layer-group"></i>
                  <p class="text-uppercase">Documents</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="documents">
                  <ul class="nav nav-collapse">
                    <li>
                      <a class="sub-item" href="{{ route('index.documents') }}"><span class="sub-item">Documents</span></a>
                    </li>
                  </ul>
                </div>
              </li>
              @endif

              @if (request()->routeIs('index.payonline'))
              <li class="nav-item {{ request()->routeIs('index.payonline') ? 'active' : '' }}">
                <a data-bs-toggle="collapse" href="#payonline">
                  <i class="fas fa-layer-group"></i>
                  <p class="text-uppercase">Pay online</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="payonline">
                  <ul class="nav nav-collapse">
                    <li>
                      <a class="sub-item" href="{{ route('index.payonline') }}"><span class="sub-item">Pay online</span></a>
                    </li>
                  </ul>
                </div>
              </li>
              @endif

              @if (request()->routeIs('index.tasks'))
              <li class="nav-item {{ request()->routeIs('index.tasks') ? 'active' : '' }}">
                <a data-bs-toggle="collapse" href="#tasks">
                  <i class="fas fa-layer-group"></i>
                  <p class="text-uppercase">Tasks</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="tasks">
                  <ul class="nav nav-collapse">
                    <li>
                      <a class="sub-item" href="{{ route('index.tasks') }}"><span class="sub-item">Tasks</span></a>
                    </li>
                  </ul>
                </div>
              </li>
              @endif

              @if (request()->routeIs('index.reports'))
              <li class="nav-item {{ request()->routeIs('index.reports') ? 'active' : '' }}">
                <a data-bs-toggle="collapse" href="#reports">
                  <i class="fas fa-layer-group"></i>
                  <p class="text-uppercase">Reports</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="reports">
                  <ul class="nav nav-collapse">
                    <li>
                      <a class="sub-item" href="{{ route('index.reports') }}"><span class="sub-item">Reports</span></a>
                    </li>
                  </ul>
                </div>
              </li>
              @endif

              @if (request()->routeIs('index.accounting'))
              <li class="nav-item {{ request()->routeIs('index.accounting') ? 'active' : '' }}">
                <a data-bs-toggle="collapse" href="#accounting">
                  <i class="fas fa-layer-group"></i>
                  <p class="text-uppercase">Accounting</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="accounting">
                  <ul class="nav nav-collapse">
                    <li>
                      <a class="sub-item" href="{{ route('index.accounting') }}"><span class="sub-item">Accounting</span></a>
                    </li>
                  </ul>
                </div>
              </li>
              @endif

              @if (request()->routeIs('index.settings'))
              <li class="nav-item {{ request()->routeIs('index.settings') ? 'active' : '' }}">
                <a data-bs-toggle="collapse" href="#settings">
                  <i class="fas fa-layer-group"></i>
                  <p class="text-uppercase">Settings</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="settings">
                  <ul class="nav nav-collapse">
                    <li>
                      <a class="sub-item" href="{{ route('index.settings') }}"><span class="sub-item">Settings</span></a>
                    </li>
                  </ul>
                </div>
              </li>
              @endif --}}

            @endif
            {{-- <li class="nav-item">
              <a data-bs-toggle="collapse" href="#sidebarLayouts">
                <i class="fas fa-th-list"></i>
                <p>Sidebar Layouts</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="sidebarLayouts">
                <ul class="nav nav-collapse">
                  <li>
                    <a href="sidebar-style-2.html">
                      <span class="sub-item">Sidebar Style 2</span>
                    </a>
                  </li>
                  <li>
                    <a href="icon-menu.html">
                      <span class="sub-item">Icon Menu</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li> --}}
          </ul>
        </div>
      </div>
      @endauth
    </div>
    <!-- End Sidebar -->

    <div class="main-panel">
        <div class="main-header">
          @auth
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="{{ URL::to('dashboard') }}" class="logo text-uppercase">
                GIL Reminders
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
          >
            <div class="container-fluid">
              {{-- <nav
                class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"
              >

                </div>
              </nav> --}}
              <ul class="navbar-nav topbar-nav align-items-center mt-2 mb-2 top-menu">
                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle top-menu-link {{ request()->routeIs('index.reminders') ? 'active' : '' }}" href="{{ route('index.reminders') }}">
                        <span class="profile-username">
                            <span class="fw-bold text-uppercase">Reminders</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle top-menu-link {{ request()->routeIs('index.prepaid') ? 'active' : '' }}" href="{{ route('index.prepaid') }}">
                        <span class="profile-username">
                            <span class="fw-bold text-uppercase">Prepaid Services</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle top-menu-link {{ request()->routeIs('index.customers') ? 'active' : '' }}" href="{{ route('index.customers') }}">
                        <span class="profile-username">
                            <span class="fw-bold text-uppercase">Customers</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle top-menu-link {{ request()->routeIs('index.documents') ? 'active' : '' }}" href="{{ route('index.documents') }}">
                        <span class="profile-username">
                            <span class="fw-bold text-uppercase">Documents</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle top-menu-link {{ request()->routeIs('index.payonline') ? 'active' : '' }}" href="{{ route('index.payonline') }}">
                        <span class="profile-username">
                            <span class="fw-bold text-uppercase">Pay Online</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle top-menu-link {{ request()->routeIs('index.tasks') ? 'active' : '' }}" href="{{ route('index.tasks') }}">
                        <span class="profile-username">
                            <span class="fw-bold text-uppercase">Task</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle top-menu-link {{ request()->routeIs('index.reports') ? 'active' : '' }}" href="{{ route('index.reports') }}">
                        <span class="profile-username">
                            <span class="fw-bold text-uppercase">Reports</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle top-menu-link {{ request()->routeIs('index.accounting') ? 'active' : '' }}" href="{{ route('index.accounting') }}">
                        <span class="profile-username">
                            <span class="fw-bold text-uppercase">Accounting</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle top-menu-link {{ request()->routeIs('index.settings') ? 'active' : '' }}" href="{{ route('index.settings') }}">
                        <span class="profile-username">
                            <span class="fw-bold text-uppercase">Settings</span>
                        </span>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center mt-2 mb-2">
                <!-- <li
                  class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"
                >
                  <a
                    class="nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"
                    href="#"
                    role="button"
                    aria-expanded="false"
                    aria-haspopup="true"
                  >
                    <i class="fa fa-search"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-search animated fadeIn">
                    <form class="navbar-left navbar-form nav-search">
                      <div class="input-group">
                        <input
                          type="text"
                          placeholder="Search ..."
                          class="form-control"
                        />
                      </div>
                    </form>
                  </ul>
                </li> -->
{{--
                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a
                      class="dropdown-toggle profile-pic"
                      data-bs-toggle="dropdown"
                      href="#"
                      aria-expanded="false"
                    >
                      <span class="profile-username">
                        <span class="fw-bold">{{ Auth::guard('admin')->user()->username }}</span>
                      </span>
                    </a>
                </li> --}}

                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a
                    class="dropdown-toggle profile-pic"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                    <div class="avatar-sm">
                      <img
                        src="{{ url('public/assets/img/user_profile.jpg')}}"
                        alt="..."
                        class="avatar-img rounded-circle"
                      />
                    </div>
                    <span class="profile-username">
                      <span class="op-7">Hi,</span>
                      <span class="fw-bold">{{ Auth::guard('admin')->user()->username }}</span>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      <li>
                        <div class="user-box">
                          <div class="avatar-lg">
                            <img
                              src="{{ url('public/assets/img/user_profile.jpg')}}"
                              alt="image profile"
                              class="avatar-img rounded"
                            />
                          </div>
                          <div class="u-text">
                            <h4>{{ Auth::guard('admin')->user()->username }}</h4>
                            <p class="text-muted">{{ Auth::guard('admin')->user()->email }}</p>
                            <a
                              href="{{ route('profile.edit',Auth::guard('admin')->user()->id) }}"
                              class="btn btn-xs btn-secondary btn-sm"
                              >View Profile</a
                            >
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('profile.edit',Auth::guard('admin')->user()->id) }}">My Profile</a>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a>
                      </li>
                    </div>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
          @endauth
        </div>


    {{-- <aside class="left-sidebar" data-sidebarbg="skin6">

        <div class="scroll-sidebar">
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    @auth
                        <li>
                            <div class="user-profile d-flex no-block dropdown m-t-20">
                                <div class="user-pic"><img src="{{ url('public/assets/app/assets/images/users/1.jpg')}}" alt="users"
                                        class="rounded-circle" width="40" /></div>
                                <div class="user-content hide-menu m-l-10">
                                    <a href="#" class="" id="Userdd" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <h5 class="m-b-0 user-name font-medium">{{ Auth::guard('admin')->user()->username }} <i
                                                class="fa fa-angle-down"></i></h5>
                                        <span class="op-5 user-email">{{ Auth::guard('admin')->user()->email }}</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="Userdd">
                                        <a class="dropdown-item" href="{{ route('profile.edit',Auth::guard('admin')->user()->id) }}"><i
                                                class="ti-user m-r-5 m-l-5"></i> My Profile</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal"><i
                                                class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                href="{{ URL::to('dashboard') }}" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span
                                    class="hide-menu">Dashboard</span></a></li>
                        @if(Auth::user()->privilege === 'admin')
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link  {{ request()->routeIs('users*') ? 'active' : '' }}"
                                href="{{ URL::to('users') }}" aria-expanded="false"><i
                                    class="mdi mdi-account-network"></i><span class="hide-menu">Users</span></a></li>
                        @endif
                        @if(Auth::user()->privilege === 'admin')
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link  {{ request()->routeIs('extensions*') ? 'active' : '' }}"
                                href="#composer require phpoffice/phpspreadsheet" aria-expanded="false"><i class="mdi mdi-border-all"></i><span
                                    class="hide-menu">Extensions</span></a></li>
                        @endif
                    @endauth
                </ul>

            </nav>

        </div>

    </aside> --}}
