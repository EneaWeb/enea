@extends('layout.dashboard.main')

@section('content')

	<div class="row">
	

		<div class="row"><div class="col-md-12">
		   <div class="panel panel-default">
		       <div class="panel-heading">
		           <div class="panel-title-box">
		              <h3>{!!trans('x.Sales')!!}</h3>
		              <span>{!!trans('x.Daily Income')!!}</span>
		           </div>                                    
		           <ul class="panel-controls" style="margin-top: 2px;">
		              <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>                                   
		           </ul>
		       </div>
		       <div class="panel-body panel-body-table">
		           @include('stats.orders_line')
		       </div>
		   </div>
		</div>
	   
		<div class="col-md-6">	
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title-box">
					    <h3>{!!trans('x.Sales')!!}</h3>
					    <span>{!!trans('x.Stats')!!}</span>
					</div>                                    
					<ul class="panel-controls" style="margin-top: 2px;">
					    <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>                                   
					</ul>
				</div>
				<div class="panel-body panel-body-table">
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
				   	@include('stats.orders_n_donut')
					</div>
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
				   	@include('stats.orders_tot_donut')
					</div>
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
				   	@include('stats.orders_types_donut')
					</div>
				</div>
			</div>
		</div>
	   
	   <div class="col-md-6">
	      {{-- START PROJECTS BLOCK --}}
	       <div class="panel panel-default">
	           <div class="panel-heading">
	               <div class="panel-title-box">
	                   <h3>{!!trans('x.Sales')!!}</h3>
	                   <span>{!!trans('x.Sales per Agent')!!}</span>
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
	                              <th style="width:30%">{!!trans('x.Agent')!!}</th>
	                              <th style="width:20%; text-align:right">{!!trans('x.Amount')!!}</th>
	                              <th style="width:10%; text-align:right">{!!trans('x.Orders')!!}</th>
	                              <th style="width:40%">{!!trans('x.Activity')!!}</th>
	                           </tr>
	                       </thead>
	                       <tbody>
	                       		@foreach (\App\User::whereHas('roles', function($q) {
											    $q->where('name', '!=', 'accountant');
											})->whereHas('brands', function($qq) {
	                       				$qq->where('brand_id', Auth::user()->options->brand_in_use->id);
	                       			})->get() as $agent)
	                           <tr>
	                               <td><strong>{!!$agent->profile->companyname!!}</strong></td>
	                               <td style="text-align:right"><strong>
	                               	{!!number_format(\App\Order::where('user_id', $agent->id)->sum('total'), 2, ',','.') !!} €
	                               </strong></td>
	                               <td style="text-align:right"><strong>
                              		{!! \App\Order::where('user_id', $agent->id)->count() !!}
                              	</strong></td>
	                               <td>
	                               {{--*/ 
	                               $percent = \App\EneaHelper::percentage(
	                                       		\App\Order::where('user_id', $agent->id)->sum('total'), 
	                                       		\App\Order::sum('total'));
	                                 if($percent == 0)
	                                 	$barColor = '';
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
	                           <tr><td colspan="4"></td></tr>
	                           <tr>
											<td><strong>{!!trans('x.Total')!!}</strong></td>
											<td style="text-align:right"><strong>
											{!!number_format(\App\Order::sum('total'), 2, ',','.') !!} €
											</strong></td>
											<td style="text-align:right"><strong>
											{!! \App\Order::count() !!}
											</strong></td>
											<td>
	                              </td>
	                           </tr>
	                       </tbody>
	                   </table>
	               </div>
	               
	           </div>
	           
	       </div>
	       {{-- END PROJECTS BLOCK --}}
	   </div>

	</div>

@include('pages.customers._modal_add_customer')
@stop