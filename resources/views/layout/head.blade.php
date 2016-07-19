<head>
    {{-- META SECTION --}}
    <title>{!! Config::get('general.sitename') !!}{!!(isset($page_title)) ? '- '.$page_title : '' !!}</title>  
    <meta charset="UTF-8">          
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="/assets/favicon.ico" type="image/x-icon" />
    {{-- END META SECTION --}}
    {{-- CSS INCLUDE --}}
    {{ HTML::style('/assets/css/alertify.min.css') }}
    {{ HTML::style('/assets/css/bootstrap/bootstrap.min.css') }}
    {{ HTML::style('/assets/css/themes/default.min.css') }}
    {{ HTML::style('/assets/css/flag-icon.min.css') }}
    {{-- {{ HTML::style('/assets/css/dropzone/dropzone.css') }} --}}
    {{ HTML::style('https://fonts.googleapis.com/icon?family=Material+Icons')}}  {{-- material icons font --}}
    {{ HTML::style('/assets/css/galleria.classic.css') }}
    {{ HTML::style('/assets/css/bootstrap-select.css') }}
    {{ HTML::style('/assets/css/lightbox/ekko-lightbox.min.css') }}
    {{ HTML::style('/assets/css/fontawesome/font-awesome.min.css') }}
    
    {{ HTML::style('/assets/css/morris-0.4.3.min.css') }}
    
    {{ HTML::style('/assets/css/theme-default.css') }}
    {{ HTML::style('/assets/css/style.css') }}
    
    {{-- EOF CSS INCLUDE --}}
    {{-- START PLUGINS --}}
    {{ HTML::script('/assets/js/plugins/jquery/jquery.min.js') }}
    {{ HTML::script('/assets/js/plugins/jquery/jquery-ui.min.js') }}
    {{ HTML::script('/assets/js/plugins/bootstrap/bootstrap.min.js') }}
    {{ HTML::script('/assets/js/plugins/lightbox/ekko-lightbox.min.js') }}
    {{ HTML::script('/assets/js/pdfobject.min.js') }} 
    {{ HTML::script('/assets/js/alertify.min.js') }} 
    
    {{ HTML::script('/assets/js/plugins/morris/raphael-min.js') }}
    {{ HTML::script('/assets/js/plugins/morris/morris.min.js') }}

    @include('components.alerts')
    
    {{-- END PLUGINS --}}
    @yield('more_head')
    
</head>