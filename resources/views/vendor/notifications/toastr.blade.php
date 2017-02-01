@if (Session::has('_notification'))
    <script>
        // display notification
        toastr.{{Session::get('_notification.name')}}('{!!Session::get('_notification.value')!!}')
        <?php 
            // forget notification
            Session::forget('_notification'); 
        ?>
    </script>
@endif
