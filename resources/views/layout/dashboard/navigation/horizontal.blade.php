{{-- START X-NAVIGATION HORIZONTAL --}}
<ul class="x-navigation x-navigation-horizontal x-navigation-panel">

    {{-- TOGGLE NAVIGATION --}}
    <li class="xn-icon-button">
        <a href="#" class="x-navigation-minimize" id="minimize_maximize"><span class="fa fa-dedent"></span></a>
    </li>
    <script>$('#minimize_maximize').click(function() { $.ajax({ url: "/minimize-maximize", method:"POST", data: { '_token': '{!!csrf_token()!!}', } }); }); </script>
    {{-- END TOGGLE NAVIGATION --}}    
    
    {{-- PAGE TITLE --}}
    <li style="padding-top:6px; font-size:2em; color:#CDCDCD">
        {!! (isset($page_title))? $page_title : ''!!}
    </li>
    {{-- END PAGE TITLE --}}
             
    {{-- POWER OFF --}}
    <li class="xn-icon-button pull-right last">
        <a href="#"><span class="fa fa-power-off"></span></a>
        <ul class="xn-drop-left animated zoomIn">
            {{-- <li><a href="pages-lock-screen.html"><span class="fa fa-lock"></span> Lock Screen</a></li> --}}
            <li><a href="/logout"><span class="fa fa-sign-out"></span> {!!trans('auth.Sign Out')!!}</a></li>
        </ul>                        
    </li> 
    {{-- END POWER OFF --}}         
               
    {{-- LANG BAR --}}
    <li class="xn-icon-button pull-right">
        <a href="#"><span class="flag-icon flag-icon-{!!Localization::getCurrentLocale()!!}"></span></a>
        <ul class="xn-drop-left xn-drop-white animated zoomIn" style="max-width:160px">
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
    </li> 
    {{-- END LANG BAR --}}
    
    {{-- BRAND BAR --}}
    <li class=" pull-right">
        <a href="#"><span class="fa fa-university"></span>{!!strtoupper(Auth::user()->options->brand_in_use->name)!!}</a>
        <ul class="xn-drop-left xn-drop-white animated zoomIn" style="max-width:160px">
            @foreach (Auth::user()->brands as $brand)
                @if( $brand->name != Auth::user()->options->brand_in_use->name)
                    <li><a href="/set-current-brand/{!!$brand->id!!}"><span class="glyphicon glyphicon-play"></span>{!!strtoupper($brand->name)!!}</a></li>
                @endif
            @endforeach
        </ul>                        
    </li> 
    {{-- END BRAND BAR --}}
</ul>
{{-- END X-NAVIGATION HORIZONTAL --}}