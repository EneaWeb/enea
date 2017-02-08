<!DOCTYPE html>
<!--[if IE 8]> <html lang="{!!Localization::getCurrentLocale()!!}" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="{!!Localization::getCurrentLocale()!!}" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{!!Localization::getCurrentLocale()!!}">
<!--<![endif]-->

    @include('layout.head')

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-md">
        <!-- BEGIN CONTAINER -->
        <div class="wrapper">

            @include('layout.header')

                <div class="container-fluid">
                <div class="page-content">
                    <!-- BEGIN BREADCRUMBS -->
                    <div class="breadcrumbs">
                    
                        <h1>{!!(isset($pageTitle)) ? $pageTitle : '' !!}</h1>

                        @include('components.breadcrumb')

                        @if (X::isOrderInProgress())
                            @include('components.orders_topbar')
                        @endif

                    </div>
                    <!-- END BREADCRUMBS -->
                    <!-- BEGIN PAGE BASE CONTENT -->

                    @yield('content')

                    <!-- END PAGE BASE CONTENT -->
                </div>
                <!-- BEGIN FOOTER -->
                <p class="copyright"> 2017 &copy; Enea Gestionale v2.0 by
                    <a href="http://cellie.it" target="_blank" >EneaWeb</a> &nbsp;|&nbsp;
                    <a href="/changelog">Changelog</a>
                </p>
                <a href="#index" class="go2top">
                    <i class="icon-arrow-up"></i>
                </a>
                <!-- END FOOTER -->
                </div>
        </div>
        <!-- END CONTAINER -->

        @include('layout.foot')

    </body>

</html>