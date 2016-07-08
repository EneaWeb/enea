{{-- Current locale for js inclusion --}}
<div id="getcurrentlocale" style="display:none">{!!strtolower(Localization::getCurrentLocale())!!}</div>
{{-- START PRELOADS --}}
<audio id="audio-alert" src="/assets/audio/alert.mp3" preload="auto"></audio>
<audio id="audio-fail" src="/assets/audio/fail.mp3" preload="auto"></audio>
{{-- END PRELOADS --}}
{{-- START SCRIPTS --}}
{{-- START THIS PAGE PLUGINS--}}
{{ HTML::script('/assets/js/plugins/icheck/icheck.min.js') }}
{{ HTML::script('/assets/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') }}
{{ HTML::script('/assets/js/plugins/scrolltotop/scrolltopcontrol.js') }}

{{ HTML::script('/assets/js/plugins/morris/raphael-min.js') }}
{{ HTML::script('/assets/js/plugins/morris/morris.min.js') }}
{{ HTML::script('/assets/js/plugins/rickshaw/d3.v3.js') }}
{{ HTML::script('/assets/js/plugins/rickshaw/rickshaw.min.js') }}
{{ HTML::script('/assets/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}
{{ HTML::script('/assets/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}
{{ HTML::script('/assets/js/plugins/bootstrap/bootstrap-datepicker.js') }}
{{ HTML::script('/assets/js/plugins/bootstrap/bootstrap-colorpicker.js') }}
{{ HTML::script('/assets/js/plugins/bootstrap/bootstrap-file-input.js') }}
{{ HTML::script('/assets/js/plugins/bootstrap/bootstrap-select.js') }}
{{ HTML::script('/assets/js/plugins/owl/owl.carousel.min.js') }}
{{ HTML::script('/assets/js/plugins/moment.min.js') }} 
{{ HTML::script('/assets/js/plugins/daterangepicker/daterangepicker.js') }} 
{{ HTML::script('/assets/js/plugins/form/jquery.form.js') }} 
{{-- {{ HTML::script('/assets/js/plugins/dropzone/dropzone.min.js') }} --}}
{{-- {{ HTML::script('/assets/js/plugins/dropzone/dropzone-config.js')}} --}}
{{ HTML::script('/assets/js/galleria-1.4.2.min.js') }} 
{{ HTML::script('/assets/js/galleria.classic.js') }} 


{{-- END THIS PAGE PLUGINS--}}
{{-- START TEMPLATE --}}
{{ HTML::script('/assets/js/plugins.js') }} 
{{ HTML::script('/assets/js/actions.js') }} 
{{ HTML::script('/assets/js/demo_dashboard.js') }} 
{{-- END TEMPLATE --}}

<script type="text/javascript" src="/assets/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
<script type="text/javascript" src="/assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/assets/js/plugins/tableexport/tableExport.js"></script>
<script type="text/javascript" src="/assets/js/plugins/tableexport/jquery.base64.js"></script>
<script type="text/javascript" src="/assets/js/plugins/tableexport/html2canvas.js"></script>
<script type="text/javascript" src="/assets/js/plugins/tableexport/jspdf/libs/sprintf.js"></script>
<script type="text/javascript" src="/assets/js/plugins/tableexport/jspdf/jspdf.js"></script>
<script type="text/javascript" src="/assets/js/plugins/tableexport/jspdf/libs/base64.js"></script>

{{-- END SCRIPTS --}}
@include('layout.scripts')

@yield('more_foot')

<script>
// hide loader
$(window).load(function(){
	pageLoadingFrame("hide");
});
</script>