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

            @if(Auth::user()->privilege === 1)
                    {{-- {{ var_dump($subMenus) }} --}}

                @if ($mainMenus)
                    @foreach($mainMenus as $key => $mainMenu)
                        @php
                            // Check if the user has permission for this main menu
                            $hasPermission = $getAllRoutePermisssions->contains(function ($permission) use ($mainMenu) {
                                return $permission->user_id == Auth::user()->id && $permission->main_route == $mainMenu->route;
                            });
                            //var_dump($hasPermission);
                        @endphp
                        <li class="nav-item {{ request()->routeIs($mainMenu->route) ? 'active' : '' }}">
                        @if($hasPermission)
                            @if(request()->routeIs($mainMenu->route) && $mainMenu->subMenus->isNotEmpty())
                            <div class="">
                                <ul class="nav nav-lists mt-0">
                                @foreach($mainMenu->subMenus as $subMenu)
                                    @php
                                        $subMenuRoute = $subMenu->route;
                                        // Check if the user's routesPermissions contains the main route
                                        $hasPermission2 = $getAllRoutePermisssions->contains('route', $subMenuRoute);
                                    @endphp

                                    @if ($hasPermission2)
                                        <li class="nav-list">
                                            <a class="sub-item text-uppercase" href="{{ route($subMenu->route) }}"><span class="sub-item">{{ $subMenu->name }}</span></a>
                                        </li>
                                    @endif
                                @endforeach
                                </ul>
                            </div>
                            @endif
                        @endif
                        </li>
                    @endforeach
                @endif
                {{-- @if ($mainMenus)

                    @foreach($mainMenus as $key => $mainMenu)

                        @if(request()->routeIs($mainMenu->route))
                        <li class="nav-item {{ request()->routeIs($mainMenu->route) ? 'active' : '' }}">

                            @if($mainMenu->subMenus->isNotEmpty())
                            <div class="">
                                <ul class="nav nav-lists mt-0">
                                    @foreach($mainMenu->subMenus as $subMenu)
                                        <li class="nav-list">
                                            <a class="sub-item text-uppercase" href="{{ route($subMenu->route) }}"><span class="sub-item">{{ $subMenu->name }}</span></a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </li>
                        @endif
                    @endforeach

                @endif --}}
               {{-- {{ var_dump($subsMenus) }} --}}

               @if(isset($subsMenus))
               <li class="nav-item">
                   <div class="">
                       <ul class="nav nav-lists mt-0">
                           @foreach($mainMenus as $subsMenu)
                               @foreach($subsMenu->subMenus as $key => $subM)
                                   @if($subM->parent_id === $parentid)
                                       @php
                                           $subsRoutes = $subM->mainroute;
                                           // Check if the user's routesPermissions contains the sub route
                                           $hasPermission = $getAllRoutePermisssions->contains(function ($permission) use ($subsRoutes) {
                                               return $permission->user_id === Auth::user()->id && $permission->route === $subsRoutes;
                                           });
                                       @endphp

                                       @if ($hasPermission)
                                           <li class="nav-list {{ $subsMenu->name }} {{ request()->routeIs($subsRoutes) ? 'active' : '' }}">
                                               <a class="sub-item text-uppercase" href="{{ route($subM->route) }}">
                                                   <span class="sub-item">aa {{ $subM->name }}</span>
                                               </a>
                                           </li>
                                       @endif
                                   @endif
                               @endforeach
                           @endforeach
                       </ul>
                   </div>
               </li>
               {{-- {{ var_dump($subsMenus) }} --}}
               @foreach($mainMenus as $key => $mainMenu)
                    @php
                        // Check if the user has permission for this main menu
                        $hasPermission = $getAllRoutePermisssions->contains(function ($permission) use ($mainMenu) {
                                return $permission->user_id == Auth::user()->id && $permission->main_route == $mainMenu->route;
                            });

                    @endphp
                    @if($hasPermission)
                        <li class="nav-item {{ request()->routeIs($mainMenu->route) ? 'active' : '' }}">
                            @if($mainMenu->subMenus->isNotEmpty())
                                @php
                                    // Check if the current route matches any of the submenus
                                    $currentMainRouteActive = $mainMenu->subMenus->contains(function ($subMenu) {
                                        return request()->routeIs($subMenu->route);
                                    });
                                @endphp

                                @if($currentMainRouteActive)
                                    <div class="">
                                        <ul class="nav nav-lists mt-0">
                                            @foreach($mainMenu->subMenus as $subMenu)
                                                @php
                                                    $subMenuRoute = $subMenu->route;
                                                    // Check if the user's routesPermissions contains the submenu route
                                                    $hasPermission2 = $getAllRoutePermisssions->contains(function ($permission) use ($subMenuRoute) {
                                                        return $permission->user_id == Auth::user()->id && $permission->route == $subMenuRoute;
                                                    });
                                                @endphp

                                                @if ($hasPermission2)
                                                    <li class="nav-list">
                                                        <a class="sub-item text-uppercase" href="{{ route($subMenu->route) }}">
                                                            <span class="sub-item">{{ $subMenu->name }}</span>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            @endif
                        </li>
                    @endif
                @endforeach
            @endif
            @endif
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

                <ul class="navbar-nav topbar-nav align-items-center mt-2 mb-2 top-menu">
                    {{-- {{ print_r($routesPermissions) }} --}}
                    @if(Auth::user()->privilege === 1)
                        {{-- {{ request()->route()->getName() }} --}}

                        @if ($mainMenus)
                            @php
                                $menuCounts = 0;
                                // Fetch routesPermissions for the authenticated user
                                $userRoutesPermissions = $getAllRoutePermisssions->filter(function ($permission) {
                                    return $permission->user_id === Auth::user()->id;
                                });
                            @endphp
                            @foreach($mainMenus as $key => $mainMenu)
                                @php
                                    $mainRoutes = $mainMenu->route;
                                    // Check if the user's routesPermissions contains the main route
                                    $hasPermission = $userRoutesPermissions->contains('main_route', $mainRoutes);
                                @endphp

                                @if ($hasPermission)
                                    <li class="nav-item topbar-user dropdown hidden-caret">
                                        <a class="dropdown-toggle top-menu-link {{ $mainMenu->route }} {{ $mainRouteName == $mainRoutes ? 'active' : '' }}" href="{{ route($mainMenu->route) }}">
                                            <span class="profile-username">
                                                <span class="fw-bold text-uppercase">{{ $mainMenu->name }}</span>
                                            </span>
                                        </a>
                                    </li>
                                    @php
                                        $menuCounts++;
                                    @endphp
                                @endif
                            @endforeach

                        @endif
                    @endif
                </ul>
            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center mt-2 mb-2">

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
          @if ($menuCounts > 9)
            <style>
                ul.navbar-nav.topbar-nav.align-items-center.top-menu{
                    overflow-x: scroll;
                }
            </style>
          @endif
          <!-- End Navbar -->
          @endauth
        </div>


