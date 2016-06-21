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
    <li><a href="/"><span class="fa fa-home"></span> <span class="xn-text">Dashboard</span></a></li>
    <li><a href="/catalogue/products"><span class="fa fa-tags"></span> <span class="xn-text">{!!trans('menu.Products')!!}</span></a></li>
    <li><a href="/customers"><span class="fa fa-user"></span><span class="xn-text">{!!trans('menu.Customers')!!}</span></a></li>
    <li class="xn-openable">
        <a href="#"><span class="fa fa-barcode"></span> <span class="xn-text">{!!trans('menu.Manage Catalogue')!!}</span></a>
        <ul>
            {{-- <li><a href="/catalogue/variations"><span class="fa fa-code-fork"></span> {!!trans('menu.Product Variations')!!}</a></li> --}}
            <li><a href="/admin/products"><span class="fa fa-tags"></span>{!!trans('menu.Products')!!}</a></li>
            <li><a href="/catalogue/models"><span class="fa fa-sitemap"></span> {!!trans('menu.Models')!!}</a></li>
            <li><a href="/admin/types"><span class="fa fa-female"></span>{!!trans('menu.Types')!!}</a></li>
            <li><a href="/catalogue/colors"><span class="fa fa-chrome"></span>{!!trans('menu.Colors')!!}</a></li>
            <li><a href="/catalogue/sizes"><span class="fa fa-arrows"></span>{!!trans('menu.Sizes')!!}</a></li>
            <li><a href="/catalogue/seasons"><span class="fa fa-calendar"></span> <span class="xn-text">{!!trans('menu.Seasons')!!}</span></a></li>
        </ul>
    </li>
    <li class="xn-openable">
        <a href="#"><span class="fa fa-usd"></span> <span class="xn-text">{!!trans('menu.Selling Tools')!!}</span></a>
        <ul>
            <li><a href="/admin/payments"><span class="fa fa-credit-card"></span> {!!trans('menu.Payment Options')!!}</a></li>
        </ul>
    </li>
    <li class="xn-openable">
        <a href="#"><span class="fa fa-cogs"></span> <span class="xn-text">{!!trans('menu.Administration')!!}</span></a>
        <ul>
            <li><a href="/admin/users"><span class="fa fa-user"></span> {!!trans('menu.Manage Users')!!}</a></li>
        </ul>
    </li>
    
</ul>