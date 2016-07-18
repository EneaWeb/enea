@extends('layout.dashboard.main')

@section('more_head')

@stop
@section('more_foot')

@stop

@section('content')                
    <div class="page-content-wrap">
        
        <div class="page-title">                    
            <h2>{!!trans('menu.Manage Products')!!}</h2>
        </div>
        {{-- START WIDGETS --}}
        <div class="row">
            <div class="col-xs-6 col-md-6 col-lg-3">
                <div class="widget widget-primary widget-carousel">
                    <div class="owl-carousel" id="owl-example">
                        <div class=""> {{-- multiply this --}}
                            <div class="widget-item-left">
                                <br><span class="fa fa-tags"></span>
                            </div>
                            <div class="widget-data">
                                <div class="widget-int num-count">
                                <div class="widget-subtitle">
                                <br>    {!!trans('menu.Products')!!}
                                </div>
                                    {!! ($products!=NULL) ? $products->count() : ''!!}
                                </div>
                                <div class="widget-title">
                                
                                </div>
                            </div>                         
                        </div>
                    </div>                   
                </div>
            </div>
        
            <div class="col-xs-6 col-md-2 col-lg-1">
                <a href="#" data-toggle="modal" data-target="#modal_add_product" class="tile tile-danger" style="padding-top:26px; padding-bottom:17px">
                    <span class="fa fa-plus"></span>
                </a>                                     
            </div>
            
        </div>
        {{-- END WIDGETS --}}

        <div class="row">         
            <div class="col-md-12">
                {{-- START DATATABLE EXPORT --}}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            {!!trans('messages.Products for brand')!!}: <span class="label label-info label-form">{!!strtoupper(Auth::user()->options->brand_in_use->name)!!}</span>
                        </h3>
                        <div class="btn-group pull-right">
                            <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> 
                                {!! trans('menu.Export')!!}    
                            </button>
                            <ul class="dropdown-menu animated zoomIn">
                                <li><a href="#" onClick ="$('#products').tableExport({type:'csv',escape:'false'});">
                                    <i class="fa fa-align-left fa-2x" aria-hidden="true"></i> CSV
                                </a></li>
                                <li><a href="#" onClick ="$('#products').tableExport({type:'txt',escape:'false'});">
                                    <i class="fa fa-file-text-o fa-2x" aria-hidden="true"></i> TXT
                                </a></li>
                                <li><a href="#" onClick ="$('#products').tableExport({type:'xml',escape:'false'});">
                                    <i class="fa fa-rss fa-2x" aria-hidden="true"></i> XML
                                </a></li>
                                <li class="divider"></li>
                                <li><a href="#" onClick ="$('#products').tableExport({type:'excel',escape:'false'});">
                                    <i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i> Excel
                                </a></li>
                                <li><a href="#" onClick ="$('#products').tableExport({type:'doc',escape:'false'});">
                                    <i class="fa fa-file-word-o fa-2x" aria-hidden="true"></i> Word
                                </a></li>
                                <li class="divider"></li>
                                <li><a href="#" onClick ="$('#products').tableExport({type:'png',escape:'false'});">
                                    <i class="fa fa-file-image-o fa-2x" aria-hidden="true"></i> PNG
                                </a></li>
                                <li><a href="#" onClick ="$('#products').tableExport({type:'pdf',escape:'false'});">
                                    <i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i> PDF
                                </a></li>
                            </ul>
                        </div>
                        
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="products" class="table datatable table-condensed">
                                <thead>
                                    <tr>
                                        <th>{!!trans('auth.Id')!!}</th>
                                        <th>{!!trans('auth.Model')!!}</th>
                                        <th>{!!trans('auth.Name')!!}</th>
                                        <th>{!!trans('auth.Slug')!!}</th>
                                        <th>{!!trans('auth.Options')!!}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($products != NULL)
                                    @foreach ($products as $product)
                                        <tr>
                                            <td><a href="/catalogue/product/edit/{!!$product->id!!}">{!!$product->id!!}</a></td>
                                            <td>{!!$product->prodmodel->name!!}</td>
                                            <td><a href="/catalogue/product/edit/{!!$product->id!!}">{!!$product->name!!}</a></td>
                                            <td>{!!$product->slug!!}</td>
                                            <td>
                                                <a href="/catalogue/product/edit/{!!$product->id!!}" class="btn btn-default btn-rounded btn-condensed btn-sm"><span class="fa fa-pencil"></span></a>
                                                <button class="btn btn-danger btn-rounded btn-condensed btn-sm" onclick="confirm_delete_product({!!$product->id!!});"><span class="fa fa-times"></span></button>
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
{{--
<script>
$(document).ready(function() {
    var table = $('#products').DataTable();
 
    $('#submit-products').click( function() {
        var data = table.$('input, select').serialize();
        console.log( data );
        return false;
    } );
} );
</script>
--}}
{{-- MODALS --}}

<div class="modal animated fadeIn" id="modal_add_product" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">
    <div class="modal-dialog animated zoomIn">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="smallModalHead">{!! trans('menu.Add new Product') !!}</h4>
            </div>
            {!!Form::open(array('url' => '/catalogue/products/new', 'method'=>'POST'))!!}
            <div class="modal-body form-horizontal form-group-separated"> 
                <div class="form-group">
                    {!!Form::label('season_id', trans('auth.Season'), ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        {!!Form::select('season_id', \App\Season::lists('name', 'id'), \App\Option::where('name', 'active_season')->first()->value, ['class' => 'form-control'])!!}
                    </div>
                </div> 
                <div class="form-group">
                    {!!Form::label('type_id', trans('auth.Type'), ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        {!!Form::select('type_id', \App\Type::lists('slug', 'id'), '', ['class' => 'form-control', 'placeholder'=>trans('messages.Select')])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('prodmodel_id', trans('auth.Model'), ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        {!!Form::select('prodmodel_id', \App\ProdModel::lists('name', 'id'), '', ['class' => 'form-control', 'placeholder' => trans('messages.Select Model')])!!}
                    </div>
                </div>             
                <div class="form-group">
                    {!!Form::label('name', trans('auth.Name'), ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        {!!Form::input('text', 'name', '', ['class' => 'form-control', 'placeholder' => trans('auth.Name')])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('slug', trans('auth.Slug'), ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        {!!Form::input('text', 'slug', '', ['class' => 'form-control', 'placeholder' => trans('auth.Slug')])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('has_variations', trans('auth.With Variations'), ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        {!!Form::select('has_variations', ['1'=>trans('messages.Yes'), '0'=>trans('messages.No')], '', ['class' => 'form-control', 'placeholder' => trans('auth.Select')])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('description', trans('auth.Description'), ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        {!!Form::textarea('description', '', ['class' => 'form-control', 'placeholder' => trans('auth.Description')])!!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {!!Form::submit(trans('menu.Create'), ['class' => 'btn btn-danger'])!!}
                <button type="button" class="btn btn-default" data-dismiss="modal">{!!trans('menu.Close')!!}</button>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
 </div>
    
{{-- END MODALS --}}
    
@stop