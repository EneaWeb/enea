<ul class="x-navigation {!!(Session::has('minimized')) ? 'x-navigation-minimized' : ''!!}">
    <li class="xn-logo">
        <a href="/">--</a>
        <a href="#" class="x-navigation-control"></a>
    </li>
    <li class="xn-profile">
        <a href="#" class="profile-mini">
            <img src="/assets/images/users/{!!Auth::user()->profile->avatar!!}" alt="{!!Auth::user()->profile->name_surname()!!}"/>
        </a>
        <div class="profile">
            <a href="/profile/edit">
                <div class="profile-image">
                    <img src="/assets/images/users/{!!Auth::user()->profile->avatar!!}" alt="{!!Auth::user()->profile->name_surname()!!}"/>
                </div>
            </a>
            <div class="profile-data">
                <a href="/profile/edit">
                    <div class="profile-data-name">{!!Auth::user()->profile->companyname!!}</div>
                </a>
                <div class="profile-data-title">{!!ucfirst(Auth::user()->role())!!}</div>
            </div>
        </div>                                                                        
    </li>
    <!-- <li class="xn-title">Navigation</li> -->
    <li><a href="/"><span class="fa fa-home"></span> <span class="xn-text">{!!trans('menu.Orders')!!}</span></a></li>
    <li class="xn-openable">
        <a href="#"><span class="fa fa-book"></span> <span class="xn-text">{!!trans('menu.Line Sheet')!!}</span></a>
        <ul>
            <li><a href="/catalogue/linesheet/clean"><span class="fa fa-book"></span>{!!trans('messages.No prices')!!}</a></li>
            @if (Auth::user()->can('manage lists'))
                @foreach(\App\SeasonList::where('season_id', \App\Option::where('name', 'active_season')->first()->value)->get() as $seasonlist)
                    <li><a href="/catalogue/linesheet/{!!$seasonlist->id!!}"><span class="fa fa-book"></span>{!!$seasonlist->name!!}</a></li>
                @endforeach
            @else
                @foreach(Auth::user()->season_lists()->where('season_id', \App\Option::where('name', 'active_season')->first()->value)->get() as $seasonlist)
                    <li><a href="/catalogue/linesheet/{!!$seasonlist->id!!}"><span class="fa fa-book"></span>{!!$seasonlist->name!!}</a></li>
                @endforeach
            @endif
        </ul>
    </li>
    <li><a href="/catalogue/products"><span class="fa fa-tags"></span> <span class="xn-text">{!!trans('menu.Products')!!}</span></a></li>
    <li><a href="/customers"><span class="fa fa-user"></span><span class="xn-text">{!!trans('menu.Customers')!!}</span></a></li>
    
    {{-- @if(Auth::user()->can('manage orders')) --}}
    
    <li class="xn-openable">
        <a href="#"><span class="fa fa-table"></span> <span class="xn-text">{!!trans('menu.Report')!!}</span></a>
        <ul>
            <li><a href="/report"><span class="fa fa-table"></span>{!!trans('menu.Sold')!!}</a></li>
            <li><a href="/report/variations"><span class="fa fa-table"></span>{!!trans('menu.Sold per Variations')!!}</a></li>
            <li><a href="/report/delivery"><span class="fa fa-table"></span>{!!trans('menu.Sold per Delivery Date')!!}</a></li>
            <li><a href="/report/time-interval"><span class="fa fa-table"></span>{!!trans('menu.Sold per Creation Date')!!}</a></li>
            <li><a href="/report/zero-sold"><span class="fa fa-table"></span>{!!trans('menu.Zero Sold')!!}</a></li>
        </ul>
    </li>
    
    {{-- @endif --}}
    
    @if(Auth::user()->can('manage brands'))
        <li class="xn-openable">
            <a href="#"><span class="fa fa-barcode"></span> <span class="xn-text">{!!trans('menu.Manage Catalogue')!!}</span></a>
            <ul>
                <li><a href="/admin/products"><span class="fa fa-tags"></span>{!!trans('menu.Products')!!}</a></li>
                <li><a href="/catalogue/models"><span class="fa fa-sitemap"></span> {!!trans('menu.Models')!!}</a></li>
                <li><a href="/admin/types"><span class="fa fa-female"></span>{!!trans('menu.Types')!!}</a></li>
                <li><a href="/catalogue/colors"><span class="fa fa-chrome"></span>{!!trans('menu.Colors')!!}</a></li>
                <li><a href="/catalogue/sizes"><span class="fa fa-arrows"></span>{!!trans('menu.Sizes')!!}</a></li>
            </ul>
        </li>    
        <li class="xn-openable">
            <a href="#"><span class="fa fa-cogs"></span> <span class="xn-text">{!!trans('menu.Administration')!!}</span></a>
            <ul>
                <li><a href="/catalogue/seasons"><span class="fa fa-calendar"></span> <span class="xn-text">{!!trans('menu.Manage Seasons')!!}</span></a></li>
                <li><a href="/admin/payments"><span class="fa fa-credit-card"></span> {!!trans('menu.Payment Options')!!}</a></li>
                <li><a href="/admin/users"><span class="fa fa-user"></span> {!!trans('menu.Manage Users')!!}</a></li>
                <li><a href="/stats/customize"><span class="fa fa-line-chart"></span> {!!trans('menu.Customize Stats')!!}</a></li>
            </ul>
        </li>
    @endif
    @if (Auth::user()->hasRole('superuser'))
        <li class="xn-openable">
            <a href="#"><span class="fa fa-cogs"></span> <span class="xn-text">Superuser</span></a>
            <ul>
                <li><a href="/superuser/manage-permissions"><span class="fa fa-cogs"></span> <span class="xn-text">Permissions</span></a></li>
            </ul>
        </li>
    @endif
</ul>