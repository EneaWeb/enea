<!-- BEGIN HEADER MENU -->
<div class="nav-collapse collapse navbar-collapse navbar-responsive-collapse">
    <ul class="nav navbar-nav">

        <li class="dropdown dropdown-fw dropdown-fw-disabled">
            <a href="@if (explode('/', Request::url())[count(explode('/', Request::url()))-1] !== 'dashboard') / @else # @endif" class="text-uppercase">
            <i class="icon-home"></i> Dashboard </a>
            <ul class="dropdown-menu dropdown-menu-fw">
                <li>
                <a class="menulink" href="/dashboard">
                <i class="icon-home"></i> Dashboard </a>
                </li>
            </ul>
        </li>

        <li class="dropdown dropdown-fw dropdown-fw-disabled">
            <a href="javascript:;" class="text-uppercase">
                <i class="fa fa-tags"></i> {!!trans('x.Catalogue')!!} 
            </a>
            <ul class="dropdown-menu dropdown-menu-fw">
                <li>
                    <a class="menulink" href="/catalogue/products?show=gallery">
                        <i class="fa fa-table"></i> {!!trans('x.Products')!!} 
                    </a>
                </li>
                <li>
                    <a class="menulink" href="/catalogue/products/new">
                        <i class="fa fa-plus"></i> {!!trans('x.New')!!} 
                    </a>
                </li>
                <li>
                    <a class="menulink" href="/catalogue/models">
                        <i class="fa fa-table"></i> {!!trans('x.Models')!!} 
                    </a>
                </li>
                <li>
                    <a class="menulink" href="/catalogue/attributes">
                        <i class="fa fa-table"></i> {!!trans('x.Attributes')!!} 
                    </a>
                </li>
                <li>
                    <a class="menulink" href="/catalogue/sizes">
                        <i class="fa fa-tags"></i> {!!trans('x.Sizes')!!} 
                    </a>
                </li>
                <li>
                    <a class="menulink" href="/catalogue/seasons">
                        <i class="fa fa-umbrella"></i> {!!trans('x.Seasons')!!} 
                    </a>
                </li>
                <li class="dropdown more-dropdown-sub">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i> Lookbook </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="/catalogue/linesheet/clean">
                                {!!trans('x.No prices')!!}
                            </a>
                        </li>
                        @if (Auth::user()->can('manage lists'))
                            @foreach(\App\PriceList::all() as $list)
                                <li>
                                    <a class="menulink" href="/catalogue/linesheet/{!!$list->id!!}">
                                        {!!$list->name!!}
                                    </a>
                                </li>
                            @endforeach
                        @else
                            @foreach(Auth::user()->priceLists() as $list)
                                <li>
                                    <a class="menulink" href="/catalogue/linesheet/{!!$list->id!!}">
                                        {!!$list->name!!}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </li>
            </ul>
        </li>

        <li class="dropdown dropdown-fw dropdown-fw-disabled">
            <a href="/customers" class="text-uppercase">
            <i class="fa fa-users"></i> {!!trans('x.Customers')!!} </a>
            <ul class="dropdown-menu dropdown-menu-fw">
                <li>
                    <a class="menulink" href="/customers">
                    <i class="fa fa-table"></i> {!!trans('x.List')!!} </a>
                </li>
            </ul>
        </li>

        <li class="dropdown dropdown-fw dropdown-fw-disabled">
            <a href="javascript:;" class="text-uppercase">
            <i class="fa fa-line-chart"></i> {!!trans('x.Report')!!} </a>
            <ul class="dropdown-menu dropdown-menu-fw">
                <li>
                    <a href="/report/stats" class="menulink">
                    <i class="fa fa-pie-chart"></i> {!!trans('x.Charts')!!} </a>
                </li>
                <li class="dropdown more-dropdown-sub">
                    <a href="javascript:;">
                        <i class="fa fa-table"></i> {!!trans('x.Sold By..')!!} 
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="/report/variations">
                                {!!trans('x.Sold by Variation')!!}
                            </a>
                        </li>
                        <li>
                            <a href="/report/products">
                                {!!trans('x.Sold by Model')!!}
                            </a>
                        </li> 
                        <li>
                            <a href="/report/time-interval">
                                {!!trans('x.Sold by Creation Date')!!}
                            </a>
                        </li>
                        <li>
                            <a href="/report/delivery">
                                {!!trans('x.Sold by Delivery Date')!!}
                            </a>
                        </li>
                        <li>
                            <a href="/report/zero-sold">
                                {!!trans('x.Zero Sold')!!}
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>

        <li class="dropdown dropdown-fw dropdown-fw-disabled">
            <a href="javascript:;" class="text-uppercase">
            <i class="fa fa-cogs"></i> {!!trans('x.Settings')!!} </a>
            <ul class="dropdown-menu dropdown-menu-fw">
                <li>
                    <a href="/settings/users" class="menulink">
                    <i class="fa fa-users"></i> {!!trans('x.Users')!!} </a>
                </li>
                <li>
                    <a href="/settings/permissions" class="menulink">
                    <i class="fa fa-users"></i> {!!trans('x.Permissions')!!} </a>
                </li>
                <li>
                    <a href="/settings/lists" class="menulink">
                    <i class="fa fa-dollar"></i> {!!trans('x.Price Lists')!!} </a>
                </li>
                <li>
                    <a href="/settings/payments" class="menulink">
                    <i class="fa fa-credit-card"></i> {!!trans('x.Payment Options')!!} </a>
                </li>
            </ul>
        </li>
    
    </ul>
</div>
<!-- END HEADER MENU -->