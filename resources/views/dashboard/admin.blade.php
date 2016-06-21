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
	                   <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
	                   <li class="dropdown">
	                       <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>                                        
	                       <ul class="dropdown-menu">
	                           <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
	                           <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
	                       </ul>                                        
	                   </li>                                        
	               </ul>
	           </div>
	           <div class="panel-body panel-body-table">
	               
	               <div class="table-responsive">
	                   <table class="table table-condensed table-bordered table-striped">
	                       <thead>
	                           <tr>
	                               <th width="50%">Project</th>
	                               <th width="20%">Status</th>
	                               <th width="30%">Activity</th>
	                           </tr>
	                       </thead>
	                       <tbody>
	                           <tr>
	                               <td><strong>Atlant</strong></td>
	                               <td><span class="label label-danger">Developing</span></td>
	                               <td>
	                                   <div class="progress progress-small progress-striped active">
	                                       <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">85%</div>
	                                   </div>
	                               </td>
	                           </tr>
	                           <tr>
	                               <td><strong>Gemini</strong></td>
	                               <td><span class="label label-warning">Updating</span></td>
	                               <td>
	                                   <div class="progress progress-small progress-striped active">
	                                       <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">40%</div>
	                                   </div>
	                               </td>
	                           </tr>                                                
	                           <tr>
	                               <td><strong>Taurus</strong></td>
	                               <td><span class="label label-warning">Updating</span></td>
	                               <td>
	                                   <div class="progress progress-small progress-striped active">
	                                       <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 72%;">72%</div>
	                                   </div>
	                               </td>
	                           </tr>
	                           <tr>
	                               <td><strong>Gemini</strong></td>
	                               <td><span class="label label-warning">Updating</span></td>
	                               <td>
	                                   <div class="progress progress-small progress-striped active">
	                                       <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">40%</div>
	                                   </div>
	                               </td>
	                           </tr>                                                
	                           <tr>
	                               <td><strong>Taurus</strong></td>
	                               <td><span class="label label-warning">Updating</span></td>
	                               <td>
	                                   <div class="progress progress-small progress-striped active">
	                                       <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 72%;">72%</div>
	                                   </div>
	                               </td>
	                           </tr>
	                           <tr>
	                               <td><strong>Leo</strong></td>
	                               <td><span class="label label-success">Support</span></td>
	                               <td>
	                                   <div class="progress progress-small progress-striped active">
	                                       <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">100%</div>
	                                   </div>
	                               </td>
	                           </tr>
	                           <tr>
	                               <td><strong>Virgo</strong></td>
	                               <td><span class="label label-success">Support</span></td>
	                               <td>
	                                   <div class="progress progress-small progress-striped active">
	                                       <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">100%</div>
	                                   </div>
	                               </td>
	                           </tr>                                                
	                           <tr>
	                               <td><strong>Aquarius</strong></td>
	                               <td><span class="label label-success">Support</span></td>
	                               <td>
	                                   <div class="progress progress-small progress-striped active">
	                                       <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">100%</div>
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
	
	   <div class="col-md-8">
	       
	       {{-- START SALES BLOCK --}}
	       <div class="panel panel-default">
	           <div class="panel-heading">
	               <div class="panel-title-box">
	                   <h3>Sales</h3>
	                   <span>Sales activity by period you selected</span>
	               </div>                                     
	               <ul class="panel-controls panel-controls-title">                                        
	                   <li>
	                       <div id="reportrange" class="dtrange">                                            
	                           <span></span><b class="caret"></b>
	                       </div>                                     
	                   </li>                                
	                   <li><a href="#" class="panel-fullscreen rounded"><span class="fa fa-expand"></span></a></li>
	               </ul>
	           </div>
	           <div class="panel-body">                                    
	               <div class="row stacked">
	                   <div class="" style="height:400px">
	                       {!! $mapHelper->renderHtmlContainer($map) !!}
	                   </div>
	               </div>                                    
	           </div>
	       </div>
	       {{-- END SALES BLOCK --}}
	       
	   </div>
	</div>

@stop

@section('more_foot')

{!! $mapHelper->renderJavascripts($map) !!}
{!! $mapHelper->renderStylesheets($map) !!}

@stop