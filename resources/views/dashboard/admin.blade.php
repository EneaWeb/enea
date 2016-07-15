@extends('layout.dashboard.main')

@section('content')

	<div class="row">
	
	   <div class="col-md-6">
	      {{-- START PROJECTS BLOCK --}}
	       <div class="panel panel-default">
	           <div class="panel-heading">
	               <div class="panel-title-box">
	                   <h3>{!!trans('messages.Sales')!!}</h3>
	                   <span>{!!trans('messages.Sales per Agent')!!}</span>
	               </div>                                    
	               <ul class="panel-controls" style="margin-top: 2px;">
	                   <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>                                   
	               </ul>
	           </div>
	           <div class="panel-body panel-body-table">
	               
	               <div class="table-responsive">
	                   <table class="table table-condensed table-bordered table-striped">
	                       <thead>
	                           <tr>
	                              <th style="width:30%">{!!trans('messages.Agent')!!}</th>
	                              <th style="width:25%; text-align:right">{!!trans('messages.Amount')!!}</th>
	                              <th style="width:45%">{!!trans('messages.Activity')!!}</th>
	                           </tr>
	                       </thead>
	                       <tbody>
	                       		@foreach (\App\User::whereHas('roles', function($q) {
											    $q->where('name', 'agent');
											})->whereHas('brands', function($qq) {
	                       				$qq->where('brand_id', Auth::user()->options->brand_in_use->id);
	                       			})->get() as $agent)
	                           <tr>
	                               <td><strong>{!!$agent->profile->companyname!!}</strong></td>
	                               <td style="text-align:right"><strong>
	                               	{!!number_format(\App\Order::where('user_id', $agent->id)->sum('total'), 2, ',','.') !!} €
	                               </strong></td>
	                               <td>
	                               {{--*/ 
	                               $percent = \App\EneaHelper::percentage(
	                                       		\App\Order::where('user_id', $agent->id)->sum('total'), 
	                                       		\App\Order::sum('total'));
	                                       		
	                              	if($percent >= 1 && $percent < 20)
	                              		$barColor = 'danger';
	                              	else if ($percent >= 20 && $percent < 50)
	                              		$barColor = 'warning';
	                              	else if ($percent >= 50 && $percent < 75)
	                              		$barColor = 'info';
	                              	else if ($percent >= 75)
	                              		$barColor = 'success';
	                               /*--}}
	                                   <div class="progress progress-small progress-striped active">
	                                       <div class="progress-bar progress-bar-{!!$barColor!!}" role="progressbar" aria-valuenow="{!!$percent!!}" aria-valuemin="0" aria-valuemax="100" style="width: {!!$percent!!}%;">{!!$percent!!}%</div>
	                                   </div>
	                               </td>
	                           </tr>
	                           @endforeach
	                           <tr><td colspan="3"></td></tr>
	                           <tr>
											<td><strong>{!!trans('messages.Total')!!}</strong></td>
											<td style="text-align:right"><strong>
											{!!number_format(\App\Order::sum('total'), 2, ',','.') !!} €
											</strong></td>
											<td>
												<div class="progress progress-small progress-striped active">
	                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">100%</div>
	                                 </div>
	                              </td>
	                           </tr>
	                       </tbody>
	                   </table>
	               </div>
	               
	           </div>
	           
	       </div>
	       {{-- END PROJECTS BLOCK --}}
	   </div>
	
	   <div class="col-md-12">
	      
         <div class="col-xs-12 col-md-12 col-lg-12">
     		
            <div style="max-width:350px; display:inline-block;">
                <a href="/order/new" class="btn btn-danger">
                     {!!strtoupper(trans('menu.Order'))!!}
                    <span class="fa fa-plus"></span>
                </a>                                     
            </div>
            
            <div style="width:1px; display:inline-block;"></div>
            
			<div style="max-width:350px; display:inline-block; ">
             <a href="#" data-toggle="modal" data-target="#modal_add_customer" class="btn btn-primary">
                 {!!strtoupper(trans('menu.Customer'))!!}
                 <span class="fa fa-plus"></span>
             </a>
			</div>
             
         </div>
	       {{-- START SALES BLOCK --}}
			<div class="panel panel-default">
			  	<div class="panel-heading">
			      <div class="panel-title-box">
						<h3>{!!trans('messages.Sales')!!}</h3>
						<span>{!!trans('messages.Orders table')!!}</span>
			      </div>   
			      <ul class="panel-controls" style="margin-top: 2px;">
			          <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>                                   
			      </ul>                           
			      {{-- <ul class="panel-controls panel-controls-title">                                        
			          <li>
			              <div id="reportrange" class="dtrange">                                            
			                  <span></span><b class="caret"></b>
			              </div>                                     
			          </li>                                
			          <li><a href="#" class="panel-fullscreen rounded"><span class="fa fa-expand"></span></a></li>
			      </ul> --}}
			  	</div>
			  	
			   {{-- INCLUDE ORDERS TABLE --}}
			   <div class="panel-body">
			      @include('dashboard._orders_table')
			   </div>
			   {{-- END INCLUDE ORDERS TABLE --}}

	      </div>
	      {{-- END SALES BLOCK --}}
	       
	   </div>
	</div>

@include('pages.customers._modal_add_customer');
@stop
