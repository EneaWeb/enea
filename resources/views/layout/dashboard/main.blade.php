<!DOCTYPE html>
<html lang="{!!Localization::getCurrentLocale()!!}">

    {{-- START HEAD --}}
    @include('layout.head')
    {{-- END HEAD --}}
    
    <body>
    
        {{-- START PAGE CONTAINER --}}
        <div class="page-container{!!(Session::has('minimized')) ? ' page-navigation-toggled page-container-wide' : ''!!}">
            
            {{-- START PAGE SIDEBAR --}}
            <div class="page-sidebar">
            
                {{-- START X-NAVIGATION --}}
                @include('layout.dashboard.navigation.vertical')
                {{-- END X-NAVIGATION --}}
            
            </div> {{-- END PAGE SIDEBAR --}}
            
            {{-- PAGE CONTENT --}}
            <div class="page-content">
            
                {{-- START Y NAVIGATION --}}
                @include('layout.dashboard.navigation.horizontal')                 
                {{-- END Y NAVIGATION --}}

                {{-- START BREADCRUMB --}}
                <ul class="breadcrumb">
                    <li><a href="#">// future</a></li>                    
                    <li class="active">// breadcrumb space</li>
                </ul>
                {{-- END BREADCRUMB --}}                     
                
                {{-- PAGE CONTENT WRAPPER --}}
                <div class="page-content-wrap">
                
                {{-- page LOADER --}}
                <div class="page-loading-frame v2">
                    <div class="page-loading-loader">
                        <div class="dot1"></div><div class="dot2"></div>
                    </div>
                </div>
                {{-- END page LOADER --}}
                    
                    @yield('content')
                    
                </div>
                {{-- END PAGE CONTENT WRAPPER --}}                              
            </div>            
            {{-- END PAGE CONTENT --}}
        </div>
        {{-- END PAGE CONTAINER --}}

        {{-- MESSAGE BOX--}}
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>                    
                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="pages-login.html" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- END MESSAGE BOX--}}

        @include('layout.foot')  
        
    </body>
</html>