@extends('layout.main')

@section('content')

<!-- BEGIN DASHBOARD STATS 1-->
<div class="row">
   <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
         <div class="visual">
            <i class="fa fa-comments"></i>
         </div>
         <div class="details">
            <div class="number">
               <span data-counter="counterup" data-value="{!!$confirmedOrders!!}">0</span> / 
               <span data-counter="counterup" data-value="{!!$confirmedPieces!!}">0</span>                   
            </div>
            <div class="desc"> {{trans('x.Confirmed orders')}} / {{trans('x.Pieces')}}</div>
         </div>
      </a>
   </div>
   <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <a class="dashboard-stat dashboard-stat-v2 yellow" href="#">
         <div class="visual">
            <i class="fa fa-comments"></i>
         </div>
         <div class="details">
            <div class="number">
               € <span data-counter="counterup" data-value="{!!$incomes!!}" style="font-size:0.7em">0</span>
            </div>
            <div class="desc"> {{trans('x.Incomes')}} </div>
         </div>
      </a>
   </div>
   <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <a class="dashboard-stat dashboard-stat-v2 red" href="#">
         <div class="visual">
            <i class="fa fa-bar-chart-o"></i>
         </div>
         <div class="details">
            <div class="number">
               <span data-counter="counterup" data-value="{!!$mostReqItem['qty']!!}">0</span> 
               <span style="font-size:0.5em">{!!$mostReqItem['name']!!}</span> 
            </div>
            <div class="desc"> {!!trans('x.Most requested Item')!!} </div>
         </div>
      </a>
   </div>
   <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
         <div class="visual">
            <i class="fa fa-shopping-cart"></i>
         </div>
         <div class="details">
            <div class="number">
               <span data-counter="counterup" data-value="{!!$mostReqSize['qty']!!}">0</span>
               <span style="font-size:0.7em">{!!trans('x.sz')!!}.{!!$mostReqSize['name']!!}</span> 
            </div>
            <div class="desc"> {!!trans('x.Most requested Size')!!} </div>
         </div>
      </a>
   </div>
</div>
<div class="clearfix"></div>
<!-- END DASHBOARD STATS 1-->

<!-- BEGIN ORDERS TABLE -->
<div class="row">
   <div class="col-md-12">
      <div class="portlet light bordered">
         <div class="portlet-title">
            <div class="caption font-dark">
               <i class="icon-settings font-dark"></i>
               <span class="caption-subject bold uppercase">{!!trans('x.Orders')!!}</span>
            </div>
            <div class="tools"> </div>
         </div>
         <div class="portlet-body">
            
            @include('components.orders_table')

         </div>
      </div>
   </div>
</div>
<!-- END ORDERS TABLE -->

<!-- BEGIN SEARCH TABLE -->
<div class="row">
   <div class="col-md-12">
      <div class="portlet light bordered">
         <div class="portlet-title">
            <div class="caption font-dark">
               <i class="icon-settings font-dark"></i>
               <span class="caption-subject bold uppercase">{!!trans('x.Search for a model in all the orders')!!} (autocomplete)</span>
               <br><br><br>
               {!!Form::input(
                  'text', 
                  'autocomplete',
                  '', 
                  ['class'=>'form-control ui-autocomplete-input', 'id'=>'products-full-autocomplete', 'placeholder'=>trans('x.Start searching..'), 'style'=>'max-width:500px']
               )!!}
               <br><br>
            </div>
            <div class="tools"> </div>
         </div>
         <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover" id="dashboard-orders">
               <thead>
                  <tr>
                     <th>{!!trans('x.Id')!!}</th>
                     <th>{!!trans('x.Pieces')!!}</th>
                     <th>{!!trans('x.Customer')!!}</th>
                     <th>{!!trans('x.Agent')!!}</th>
                     <th>{!!trans('x.Options')!!}</th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                     <th></th>
                     <th></th>
                     <th></th>
                     <th></th>
                     <th></th>
                  </tr>
               </tfoot>
               <tbody id="search-table-content">

               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
<!-- END SEARCH TABLE -->

@stop

@section('pages-scripts')

<script>
    $( window ).load(function() {
        $.getJSON('/customers/api-products', function(data) {
            $( "#products-full-autocomplete" ).autocomplete({
                source: data,
                select: function(event, ui) {
                    if(ui.item){
                        
                        $.ajax({
                            type: 'GET',
                            data: {
                                'name' : ui.item.value,
                                format: 'json'
                            },
                            url: '/customers/api-products-data',
                            success: function(data) {
                                $('#search-table-content').html(data);
                            },
                            error: function() {
                                console.log('ajax error');
                            }
                        });
                        
                    }
                }
            });
        });
    });
</script>

@stop