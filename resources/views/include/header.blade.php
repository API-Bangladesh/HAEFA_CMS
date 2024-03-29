<header class="dt-header">

    <!-- Header container -->
    <div class="dt-header__container">

      <!-- Brand -->
      <div class="dt-brand">

        <!-- Brand tool -->
        <div class="dt-brand__tool" data-toggle="main-sidebar">
          <i class="icon icon-xl icon-menu-fold d-none d-lg-inline-block"></i>
          <i class="icon icon-xl icon-menu d-lg-none"></i>
        </div>
        <!-- /brand tool -->

        <!-- Brand logo -->
        <span class="dt-brand__logo">
        <a class="dt-brand__logo-link" href="{{ url('/') }}">
          <img class="d-none d-lg-inline-block" src="{{ url(config('app.url') . '/public/storage/logo/' . config('settings.logo')) }}" alt="Logo" style="max-width: 60px;"/>
          <!-- max-height:50px;-->
          <img class="dt-brand__logo-symbol d-lg-none" src="{{ url(config('app.url') . '/public/storage/logo/' . config('settings.logo')) }}" alt="Logo"/>
        </a>
      </span>
        <!-- /brand logo -->

      </div>
      <!-- /brand -->

      <!-- Header toolbar-->
      <div class="dt-header__toolbar">

        <!-- /search box -->

        <!-- Header Menu Wrapper -->
        <div class="dt-nav-wrapper">


          


          <!-- Header Menu -->
          <ul class="dt-nav">
            <li class="dt-nav__item dropdown">

              <!-- Dropdown Link -->
              <a href="#" class="dt-nav__link dropdown-toggle no-arrow dt-avatar-wrapper"
                 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @if (Auth::user()->avatar)
                  <img class="dt-avatar size-40" src="storage/{{ USER_AVATAR_PATH.Auth::user()->avatar }}" alt="{{ Auth::user()->name }}">
                  @else
                  <img class="dt-avatar size-40" src="images/{{ Auth::user()->gender == 1 ? 'male' : 'female' }}.svg" alt="{{ Auth::user()->name }}">
                  @endif
              </a>
              <!-- /dropdown link -->

              <!-- Dropdown Option -->
              <div class="dropdown-menu custom-menu dropdown-menu-right" style="left: 50px;min-width:200px;">
                <div class="dt-avatar-wrapper flex-nowrap p-6 mt--5 bg-gradient-purple text-white rounded-top">
                  @if (Auth::user()->avatar)
                  <img class="dt-avatar" src="storage/{{ USER_AVATAR_PATH.Auth::user()->avatar }}" alt="{{ Auth::user()->name }}">
                  @else
                  <img class="dt-avatar" src="images/{{ Auth::user()->gender == 1 ? 'male' : 'female' }}.svg" alt="{{ Auth::user()->name }}">
                  @endif


                  <span class="dt-avatar-info">
                  <span class="dt-avatar-name">{{ Auth::user()->name }}</span>
                  <span class="f-12">{{ Auth::user()->role->role_name }}</span>
                </span>
                </div>
                <a class="dropdown-item" href="{{ route('my.profile') }}"> <i class="icon icon-user-o icon-fw mr-2 mr-sm-1"></i>Account
                </a>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit()">
                  <i class="fa fa-share mr-2 mr-sm-1" aria-hidden="true"></i>
                  Logout
                </a>
                <form action="{{ route('logout') }}" id="logout-form" method="POST" class="d-none">
                @csrf
                </form>
              </div>
              <!-- /dropdown option -->

            </li>
          </ul>
          <!-- /header menu -->

        </div>
        <!-- Header Menu Wrapper -->

      </div>
      <!-- /header toolbar -->

    </div>
    <!-- /header container -->

  </header>