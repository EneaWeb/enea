@extends('layout.dashboard.main')

@section('more_head')

@stop
@section('more_foot')

@stop

@section('content')  

    {{-- START BASIC ELEMENTS --}}
    <div class="content-frame">
    
        <div class="content-frame-top">
            <h1>{!!trans('x.Customers')!!}</h1>
        </div>
    
        <div class="content-frame-left">
        
            <div class="widget widget-warning widget-no-subtitle">
                <div class="widget-subtitle">{!! trans('x.Actual brand customers') !!}</div>
                <div class="widget-big-int">
                    <span class="num-count">
                        {!!\App\Brand::find(Auth::user()->options->active_brand)->customers()->count()!!}
                    </span>
                </div>            
            </div>
            <a href="#" data-toggle="modal" data-target="#modal_add_customer" class="tile tile-success tile-valign">
                <span class="fa fa-plus"></span>
            </a>

            
            <div class="panel panel-default">

            </div>
            
        </div>
        
        <div class="content-frame-body content-frame-body-right" style="padding-top:0">
            
            <div class="row">         
                <div class="col-md-12">
                    {{-- START DATATABLE EXPORT --}}
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                {!!trans('x.Customers')!!}
                            </h3>
                            <div class="btn-group pull-right">
                                <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> 
                                    {!! trans('x.Export')!!}    
                                </button>
                                <ul class="dropdown-menu animated zoomIn">
                                    <li><a href="#" onClick ="$('#customers').tableExport({type:'csv',escape:'false'});">
                                        <i class="fa fa-align-left fa-2x" aria-hidden="true"></i> CSV
                                    </a></li>
                                    <li><a href="#" onClick ="$('#customers').tableExport({type:'txt',escape:'false'});">
                                        <i class="fa fa-file-text-o fa-2x" aria-hidden="true"></i> TXT
                                    </a></li>
                                    <li><a href="#" onClick ="$('#customers').tableExport({type:'xml',escape:'false'});">
                                        <i class="fa fa-rss fa-2x" aria-hidden="true"></i> XML
                                    </a></li>
                                    <li class="divider"></li>
                                    <li><a href="#" onClick ="$('#customers').tableExport({type:'excel',escape:'false'});">
                                        <i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i> Excel
                                    </a></li>
                                    <li><a href="#" onClick ="$('#customers').tableExport({type:'doc',escape:'false'});">
                                        <i class="fa fa-file-word-o fa-2x" aria-hidden="true"></i> Word
                                    </a></li>
                                    <li class="divider"></li>
                                    <li><a href="#" onClick ="$('#customers').tableExport({type:'png',escape:'false'});">
                                        <i class="fa fa-file-image-o fa-2x" aria-hidden="true"></i> PNG
                                    </a></li>
                                    <li><a href="#" onClick ="$('#customers').tableExport({type:'pdf',escape:'false'});">
                                        <i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i> PDF
                                    </a></li>
                                </ul>
                            </div>
                            
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="customers" class="table datatable table-condensed">
                                    <thead>
                                        <tr>
                                            <th>{!!trans('x.Company Name')!!}</th>
                                            <th>{!!trans('x.Sign')!!}</th>
                                            <th>{!!trans('x.City')!!}</th>
                                            <th>{!!trans('x.Country')!!}</th>
                                            <th>{!!trans('x.Orders')!!}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $customer)
                                        <tr>
                                            <td>
                                                <a href="/customer/show/{!!$customer->id!!}">
                                                    {!!$customer->companyname!!}
                                                </a>
                                            </td>
                                            <td>{!!$customer->sign!!}</td>
                                            <td>{!!$customer->city!!} @if ($customer->province!='') ({!!$customer->province!!}) @endif</td>
                                            <td>{!!$customer->country!!}</td>
                                            <td><span class="badge">{!!$customer->orders->count()!!}</span></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- END DATATABLE EXPORT --}}
                </div>   
            </div>
        </div>
    </div>
    
    {{-- MODALS --}}
    @include('pages.customers._modal_add_customer')
    
@stop