@extends('layout.dashboard.main')

@section('more_head')

@stop
@section('more_foot')

@stop

@section('content')  

    {{-- START BASIC ELEMENTS --}}
    <div class="content-frame">
    
        <div class="content-frame-top">
            <h1>{!!trans('x.Sizes')!!}</h1>
        </div>
            
        <div class="content-frame-left">

            <div class="col-md-12" style="padding:0">

                <div class="widget widget-warning widget-no-subtitle">
                    <div class="widget-subtitle">{!! trans('x.Sizes') !!}</div>
                    <div class="widget-big-int"><span class="num-count">{!!$sizes->count()!!}</span></div>            
                </div>
                <a href="#" data-toggle="modal" data-target="#modal_add_size" class="tile tile-success tile-valign">
                    <span class="fa fa-plus"></span>
                </a>

            </div>
        </div>
        
        <div class="content-frame-body content-frame-body-right" style="padding-top:0">
        
            <div class="col-md-12">
                {{-- START DATATABLE EXPORT --}}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                                //
                        </h3>       
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="models" class="table datatable table-condensed">
                                <thead>
                                    <tr>
                                        <th>{!!trans('x.Name')!!}</th>
                                        <th>{!!trans('x.Slug')!!}</th>
                                        <th>{!!trans('x.Options')!!}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sizes as $size)
                                    <tr>
                                        <td>{!!$size->name!!}</td>
                                        <td>{!!$size->slug!!}</td>
                                        <td>
                                            <button href="#" data-toggle="modal" data-target="#modal_edit_size{!!$size->id!!}" class="btn btn-default btn-rounded btn-condensed btn-sm"><span class="fa fa-pencil"></span></button>
                                            <button class="btn btn-danger btn-rounded btn-condensed btn-sm" onClick="confirm_delete_size({!!$size->id!!});"><span class="fa fa-times"></span></button>
                                        </td>
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

    {{-- MODALS --}}

    <div class="modal animated fadeIn" id="modal_add_size" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">
        <div class="modal-dialog animated zoomIn">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="smallModalHead">{!! trans('x.New Size') !!}</h4>
                </div>
                <div class="modal-body">
                    
                </div>
                {!!Form::open(array('url' => '/catalogue/size/new', 'method'=>'POST'))!!}
                
                <div class="modal-body form-horizontal form-group-separated">                        
                    <div class="form-group">
                        {!!Form::label('name', trans('x.Name').'*', ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">
                            {!!Form::input('text', 'name', '', ['class' => 'form-control', 'placeholder' => trans('x.Name')])!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('slug', trans('x.Slug'), ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">
                            {!!Form::input('text', 'slug', '', ['class' => 'form-control', 'placeholder' => trans('x.Slug')])!!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {!!Form::submit(trans('x.Create'), ['class' => 'btn btn-danger'])!!}
                    <button type="button" class="btn btn-default" data-dismiss="modal">{!!trans('x.Close')!!}</button>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
    
    @foreach ($sizes as $size)
    
        <div class="modal animated fadeIn" id="modal_edit_size{!!$size->id!!}" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">
            <div class="modal-dialog animated zoomIn">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="smallModalHead">{!! trans('x.New product Model') !!}</h4>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                    {!!Form::open(array('url' => '/catalogue/model/edit', 'method'=>'GET'))!!}
                    
                    {!!Form::hidden('id', $size->id)!!}
                    <div class="modal-body form-horizontal form-group-separated">                        
                        <div class="form-group">
                            {!!Form::label('name', trans('x.Name').'*', ['class' => 'col-md-3 control-label'])!!}
                            <div class="col-md-8">
                                {!!Form::input('text', 'name', $size->name, ['class' => 'form-control', 'placeholder' => trans('x.Name')])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!!Form::label('slug', trans('x.Slug'), ['class' => 'col-md-3 control-label'])!!}
                            <div class="col-md-8">
                                {!!Form::input('text', 'slug', $size->slug, ['class' => 'form-control', 'placeholder' => trans('x.Slug')])!!}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {!!Form::submit(trans('x.Create'), ['class' => 'btn btn-danger'])!!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">{!!trans('x.Close')!!}</button>
                    </div>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>

    @endforeach
    {{-- end MODALS --}}

@stop
