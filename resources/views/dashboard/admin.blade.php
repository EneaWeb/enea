@extends('layout.dashboard.main')

@section('content')

	<div class="row">
	
	   <div class="col-md-4">
	      {{-- START PROJECTS BLOCK --}}
	       <div class="panel panel-default">
	           <div class="panel-heading">
	               <div class="panel-title-box">
	                   <h3>Projects</h3>
	                   <span>Projects activity</span>
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
	                              <th width="30%">Agent</th>
	                              <th width="25%">Amount</th>
	                              <th width="45%">Activity</th>
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
	                               <td><strong>
	                               	{!!number_format(\App\Order::where('user_id', $agent->id)->sum('total'), 2, ',','.') !!}
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
	                                       <div class="progress-bar progress-bar-{!!$barColor!!}" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: {!!$percent!!}%;">{!!$percent!!}%</div>
	                                   </div>
	                               </td>
	                           </tr>
	                           @endforeach
	                       </tbody>
	                   </table>
	               </div>
	               
	           </div>
	           
	       </div>
	       {{-- END PROJECTS BLOCK --}}
	   </div>
	
	   <div class="col-md-8">
	       
	       {{-- START SALES BLOCK --}}
	       	<div class="panel panel-default">
	           	<div class="panel-heading">
	               <div class="panel-title-box">
							<h3>Sales</h3>
	                  <span></span>
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
	         </div>
	      </div>
	   </div>
	   
	   <div>
	   	<div>

               {{-- INCLUDE ORDERS TABLE --}}
               <div class="panel-body">
                  @include('dashboard._orders_table')
               </div>
               {{-- END INCLUDE ORDERS TABLE --}}

	       </div>
	       {{-- END SALES BLOCK --}}
	       
	   </div>
	</div>

@stop

@section('more_foot')

@stop