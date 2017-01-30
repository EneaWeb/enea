{{-- Current locale for js inclusion --}}
<div id="getcurrentlocale" style="display:none">{!!strtolower(Localization::getCurrentLocale())!!}</div>

<!--[if lt IE 9]>
<script src="/assets/global/plugins/respond.min.js"></script>
<script src="/assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>

<!-- MENU coloration for active links -->
<script>
   links  = $('.menulink')
   for(ind in links){
      link = links[ind];
      if (link.href !== undefined) {
         //if (window.location.href.split('/').pop() == link.href.split('/').pop()) {
            winLocation = window.location.href.replace('it/', '');
            winLocation = winLocation.replace('en/', '');
            winLocation = winLocation.replace('es/', '');
         if (winLocation.indexOf(link.href) !== -1) {
            $(link).parent('li').addClass('active');
            $('.dropdown-fw.dropdown-fw-disabled').removeClass('active open selected');
            $(link).parent('li').parent('ul').parent('li').addClass('active open selected');
         }
      }
   }
</script>
<!-- end MENU coloration for active links -->

<script src="/assets/js/plugins/jquery/jquery-ui.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/assets/global/plugins/moment.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
<script src="/assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
<script src="/assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
<script src="/assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
<script src="/assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
<script src="/assets/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
<script src="/assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
<script src="/assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
<script src="/assets/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
<script src="/assets/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>
<script src="/assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/horizontal-timeline/horozontal-timeline.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="/assets/global/scripts/app.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js" type="text/javascript"></script>
<script src="/assets/pages/scripts/portfolio-1.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->

<script src="/assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
<script src="/assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="/assets/pages/scripts/table-datatables-buttons.js" type="text/javascript"></script>
<script src="/assets/pages/scripts/table-datatables-rowreorder.js" type="text/javascript"></script>

<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="/assets/layouts/layout5/scripts/layout.min.js"z type="text/javascript"></script>
<script src="/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->

{{ HTML::script('/assets/global/plugins/bootstrap-toastr/toastr.min.js') }}
{{ HTML::script('/assets/js/alertify.min.js') }} 

{{-- start toastr notifications --}}
@include('vendor.notifications.toastr')
{{-- end toastr notifications --}}

@include('components.scripts')

@yield('pages-scripts')

<script>
    $('body').on('show.bs.modal', '#modal_edit', function (event) {

      var button = $(event.relatedTarget) // Button that triggered the modal
      var order_id = button.data('order_id') // Extract info from data-* attributes

      if (order_id !== undefined) {

         // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
         // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
         var modal = $(this)
               
         modal.empty();
         
         $.ajax({
            type: 'GET',
            url: '/api/order/modal-edit',
            data: { '_token' : '{!!csrf_token()!!}', order_id: order_id },
            success:function(data){
               // successful request; do something with the data
               modal.append(data);
            },
            error:function(){
               // failed request; give feedback to user
               alert('ajax error');
            }
         });   
      }

    })
</script>