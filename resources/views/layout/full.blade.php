<!DOCTYPE html>
<html lang="{!!Localization::getCurrentLocale()!!}">

    {{-- START HEAD --}}
    @include('layout.head')
    {{-- END HEAD --}}
    
    <body>
        
        @yield('body')    
    
    </body>
</html>