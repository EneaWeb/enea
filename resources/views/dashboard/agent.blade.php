@extends('layout.dashboard.main')

@section('more_head')

@stop
@section('more_foot')

@stop

@section('content')                
    <div class="page-content-wrap">
        
        <div class="page-title">                    
            <h2>{!!trans('menu.Manage Orders')!!}</h2>
        </div>
        {{-- START WIDGETS --}}
        <div class="row">
        	
        		<div class="col-xs-12 col-md-12 col-lg-12">
        		
	            <div style="max-width:350px; display:inline-block;">
	                <a href="/order/new" class="tile tile-danger">
                        {!!strtoupper(trans('menu.Order'))!!}
	                    <span class="fa fa-plus"></span>
	                </a>                                     
	            </div>
	            
	            <div style="width:1px; display:inline-block;"></div>
	            
					<div style="max-width:350px; display:inline-block; ">
	                <a href="#" data-toggle="modal" data-target="#modal_add_customer" class="tile tile-primary">
	                    {!!strtoupper(trans('menu.Customer'))!!}
                        <span class="fa fa-plus"></span>
	                </a>
					</div>
            </div>
            
        </div>
        {{-- END WIDGETS --}}

        <div class="row">         
            <div class="col-md-12">
                {{-- START DATATABLE EXPORT --}}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            {!!trans('messages.Personal Orders')!!}: <span class="label label-info label-form">{!!strtoupper(Auth::user()->options->brand_in_use->name)!!}</span>
                        </h3>
                        <div class="btn-group pull-right">
                            <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> 
                                {!! trans('menu.Export')!!}    
                            </button>
                            <ul class="dropdown-menu animated zoomIn">
                                <li><a href="#" onClick ="$('#orders').tableExport({type:'csv',escape:'false'});">
                                    <i class="fa fa-align-left fa-2x" aria-hidden="true"></i> CSV
                                </a></li>
                                <li><a href="#" onClick ="$('#orders').tableExport({type:'txt',escape:'false'});">
                                    <i class="fa fa-file-text-o fa-2x" aria-hidden="true"></i> TXT
                                </a></li>
                                <li><a href="#" onClick ="$('#orders').tableExport({type:'xml',escape:'false'});">
                                    <i class="fa fa-rss fa-2x" aria-hidden="true"></i> XML
                                </a></li>
                                <li class="divider"></li>
                                <li><a href="#" onClick ="$('#orders').tableExport({type:'excel',escape:'false'});">
                                    <i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i> Excel
                                </a></li>
                                <li><a href="#" onClick ="$('#orders').tableExport({type:'doc',escape:'false'});">
                                    <i class="fa fa-file-word-o fa-2x" aria-hidden="true"></i> Word
                                </a></li>
                                <li class="divider"></li>
                                <li><a href="#" onClick ="$('#orders').tableExport({type:'png',escape:'false'});">
                                    <i class="fa fa-file-image-o fa-2x" aria-hidden="true"></i> PNG
                                </a></li>
                                <li><a href="#" onClick ="$('#orders').tableExport({type:'pdf',escape:'false'});">
                                    <i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i> PDF
                                </a></li>
                            </ul>
                        </div>
                        
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="orders" class="table datatable table-condensed">
                                <thead>
                                    <tr>
                                        <th>{!!trans('auth.Id')!!}</th>
                                        <th>{!!trans('auth.Customer')!!}</th>
                                        <th>Articoli</th>
                                        <th>Pezzi</th>
                                        <th>{!!trans('auth.Total')!!}</th>
                                        <th>{!!trans('auth.Options')!!}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($orders != NULL)
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>
                                                <a href="/order/details/{!!$order->id!!}">
                                                    {!!$order->id!!}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="/order/details/{!!$order->id!!}">
                                                    {!!\App\Customer::find($order->customer_id)->companyname!!}
                                                </a>
                                            </td>
                                            <td>{!!$order->items_color_grouped!!}</td>
                                            <td>{!!$order->qty!!}</td>
                                            <td>€ {!!number_format($order->total, 2)!!}</td>
                                            <td>
                                        		<!-- <a href="/catalogue/order/edit/{!!$order->id!!}" class="btn btn-default btn-rounded btn-condensed btn-sm"><span class="fa fa-pencil"></span></a> -->
                                                <a href="/order/details/{!!$order->id!!}"><button class="btn btn-warning btn-rounded btn-condensed btn-sm"><span class="fa fa-search-plus"></span></button></a>
                                            	<button class="btn btn-danger btn-rounded btn-condensed btn-sm" onclick="confirm_delete_order({!!$order->id!!});"><span class="fa fa-times"></span></button>
                                    		</td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>                        
                        </div>
                    </div>
                </div>
            </div>   
        </div>
    </div>
 
@include('pages.customers._modal_add_customer');

@stop