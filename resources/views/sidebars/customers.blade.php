<div class="page-sidebar">
    <nav class="navbar" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <!-- Collect the nav links, forms, and other content for toggling -->
        <ul class="nav navbar-nav margin-bottom-35">
            <li>
                <a class="sidebarlink" href="/customers">
                    <i class="fa fa-users"></i> {!!trans('x.Customers')!!} 
                </a>
            </li>
            <li>
                <a href="#" data-toggle="modal" data-target="#modal_add_customer">
                    <i class="fa fa-plus"></i> {!!trans('x.Add Customer')!!} 
                </a>
            </li>
        </ul>
    </nav>
</div>

@include('modals.customer.add_customer')