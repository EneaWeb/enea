{{-- 
///////////////////////////////////////////////////
//////////////////  ALERTIFY alert_error
///////////////////////////////////////////////////
--}}
@if (Session::has('alert_error'))
	<script>
	$( document ).ready(function() {
		alertify.set('notifier','delay', 4);
		alertify.set('notifier','position', 'top-right');
		alertify.error('{!!Session::get("alert_error")!!}');
	});
	</script>
	{{ Session::forget('alert_error') }}
@endif
{{-- 
///////////////////////////////////////////////////
//////////////////  ALERTIFY alert_success
///////////////////////////////////////////////////
--}}
@if (Session::has('alert_success'))
	<script>
	$( document ).ready(function() {
		alertify.set('notifier','delay', 4);
		alertify.set('notifier','position', 'top-right');
		alertify.success('{!!Session::get("alert_success")!!}');
	});
	</script>
	{{ Session::forget('alert_success') }}
@endif
{{-- 
///////////////////////////////////////////////////
//////////////////  ALERTIFY alert_message
///////////////////////////////////////////////////
--}}
@if (Session::has('alert_message'))
	<script>
	$( document ).ready(function() {
		alertify.dialog('alert').set({transition:'zoom',message: '{!!Session::get("alert_message")!!}'}).show(); 
	});
	</script>
	{{ Session::forget('alert_message') }}
@endif
{{-- 
///////////////////////////////////////////////////
//////////////////  ALERTIFY STYLE
///////////////////////////////////////////////////
--}}
<style>
.alertify-notifier.ajs-top.ajs-right {
	margin-top:40px;
}
</style>