<!-- BEGIN HEADER -->
<header class="page-header">
    <nav class="navbar mega-menu" role="navigation">
        <div class="container-fluid">
            <div class="clearfix navbar-fixed-top">
                <!-- Brand and toggle get grouped for better mobile display -->
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="toggle-icon">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                    </span>
                </button>
                <!-- End Toggle Button -->
                <!-- BEGIN LOGO -->
                <a id="index" class="page-logo" href="/">
                    <img src="/assets/img/logo.png" alt="Logo"> </a>
                <!-- END LOGO -->
                <!-- BEGIN SEARCH -->
                <form class="search" action="?" method="GET">
                    <input type="name" class="form-control" name="query" placeholder="Search..." onclick="alert('La ricerca non è attualmente abilitata. g.')">
                    <a href="javascript:;" class="btn submit md-skip">
                            <i class="fa fa-search"></i>
                    </a>
                </form>
                <!-- END SEARCH -->
                <!-- BEGIN TOPBAR ACTIONS -->
                <div class="topbar-actions">

                    <div class="btn-group-red btn-group" style="margin: 0 15px 0 15px">
                        <button type="button" class="btn btn-sm md-skip dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" style="width:auto;">
                            <i class="fa fa-university" style="font-size:1.2em"></i>	{!!strtoupper(\App\X::brandInUseName())!!}					
                        </button>
                        <ul class="dropdown-menu-v2" role="menu">
                            @foreach (Auth::user()->brands as $brand)
                            @if( $brand->name != \App\X::brandInUseName())
                                <li><a href="/set-current-brand/{!!$brand->id!!}"><span class="glyphicon glyphicon-play"></span>{!!strtoupper($brand->name)!!}</a></li>
                            @endif
                            @endforeach
                        </ul>
                    </div>

                    <div class="btn-group-red btn-group">
                        <button type="button" class="btn btn-sm md-skip dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" style="width:auto; background:grey">
                            <i class="fa fa-venus-mars" style="font-size:1.2em"></i>	{!!ucfirst(trans('x.'.\App\X::typeInUseSlug()))!!}
                        </button>
                        <ul class="dropdown-menu-v2" role="menu">
                            <li><a href="/set-current-type/1">- {!!ucfirst(trans('x.all'))!!}</a></li>
                            <li><a href="/set-current-type/5">- {!!ucfirst(trans('x.woman'))!!}</a></li>
                            <li><a href="/set-current-type/4">- {!!ucfirst(trans('x.man'))!!}</a></li>
                        </ul>
                    </div>

                    <!-- BEGIN USER PROFILE -->
                    <div class="btn-group-img btn-group">
                        <button type="button" class="btn btn-sm md-skip dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <span>{!!Auth::user()->profile->companyname!!}</span>
                            <img src="/assets/images/users/{!!Auth::user()->profile->avatar!!}" alt="{!!Auth::user()->profile->name_surname()!!}"/> 
                        </button>
                        <ul class="dropdown-menu-v2" role="menu">
                            <li>
                            <a href="page_user_profile_1.html">
                                <i class="icon-user"></i> Profile
                            </a>
                            </li>
                            <li>
                            <a href="/logout">
                                <i class="icon-key"></i> Log Out </a>
                            </li>
                        </ul>
                    </div>
                    <!-- END USER PROFILE -->

                  <div class="btn-group-notification btn-group">
                        <button type="button" class="btn btn-sm md-skip dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <span class="flag-icon flag-icon-{!!Localization::getCurrentLocale()!!}"></span>
                        </button>
                        <ul class="dropdown-menu-v2" role="menu">
                            @foreach(Localization::getSupportedLocales() as $localeCode)
                            <li>
                            <a href="/set-locale/{!!$localeCode->key()!!}">
                                <span class="flag-icon flag-icon-{!!$localeCode->key()!!}"></span>
                                {!!$localeCode->native()!!}
                                @if ($localeCode->key() == Localization::getCurrentLocale())
                                <span class="fa fa-check"></span>
                                @endif
                            </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- END TOPBAR ACTIONS -->
            </div>
            
            @include('layout.main-menu')

        </div>
        <!--/container-->
    </nav>
</header>
<!-- END HEADER -->
