@extends('layout.dashboard.main')

@section('more_head')

@stop
@section('more_foot')

@stop

@section('content')  

    {{-- START BASIC ELEMENTS --}}
    <div class="content-frame">
        <div class="content-frame-right">
            <div class="panel-heading">
                <h3 style="display:inline-block">{!! trans('menu.Attributes')!!}</h3>
                <ul class="panel-controls" style="margin-top:-4px">
                <li><a href="#" data-toggle="modal" data-target="#modal_add_attribute"><span class="fa fa-plus"></span></a></li>
                </ul>
            </ul>
            </div>
            <div class="block">
                <div class="list-group border-bottom">
                    @foreach(\App\Attribute::all() as $attribute)
                        <a data-toggle="collapse" href="#{!!$attribute->slug!!}" class="list-group-item">
                            <span class="fa fa-inbox"></span><strong>{!!$attribute->name!!}</strong> [{!!$attribute->slug!!}]
                            <span class="badge badge-success">{!!$attribute->attribute_values->count()!!}</span>
                        </a>
                            <div id="{!!$attribute->slug!!}" class="panel-collapse collapse">
                                <div class="panel-body">
                                    @foreach ($attribute->attribute_values->all() as $attribute_value)
                                        <div class="panel" style="padding:6px; margin-bottom:4px">
                                            <strong>{!!$attribute_value->name!!}</strong> [{!!$attribute_value->slug!!}]
                                            <a href="/catalogue/attribute-value/delete/{!!$attribute_value->id!!}">
                                                <span class="fa fa-minus-circle little-delete-icon"></span>  
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                    @endforeach
                </div>
            </div>
            
            <div class="panel panel-default">
                <a data-toggle="collapse" href="#new-attribute-value" class="list-group-item">
                    <h3 class="no-margin-bottom">{!! trans('menu.New Value')!!}</h3>
                </a>
                <div class="panel-body2">
                    <div id="new-attribute-value" class="collapse">
                        {!! Form::open(['url'=> '/catalogue/attribute-values/new', 'method'=>'POST', 'class'=>'form-material'])!!}
                        
                            <div class="form-group">
                                {!!Form::select('attribute_id', \App\Attribute::lists('name', 'id'), '', ['class'=>'form-control'])!!}
                                {!!Form::label('attribute_id', trans('menu.Attribute'))!!}
                            </div>
                            
                            <div class="form-group">
                                {!!Form::input('text', 'name', '', ['class'=>'form-control'])!!}
                                {!!Form::label('name', trans('menu.Value Name'))!!}
                            </div>
                            
                            <div class="form-group">
                                {!!Form::input('text', 'slug', '', ['class'=>'form-control'])!!}
                                {!!Form::label('slug', trans('menu.Value Slug'))!!}
                            </div>
                            
                            <div class="form-group">
                                {!!Form::submit(trans('menu.Submit'), ['class'=>'btn btn-danger'])!!}
                            </div>                     
                            
                        {!!Form::close()!!}
                    </div>
                </div>
            </div>                    

        </div>
    </div>
    
{{-- MODALS --}}

<div class="modal animated fadeIn" id="modal_add_attribute" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">
    <div class="modal-dialog animated zoomIn">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="smallModalHead">{!! trans('menu.New Attribute') !!}</h4>
            </div>
            <div class="modal-body">
                
            </div>
            {!!Form::open(array('url' => '/catalogue/attributes/new', 'method'=>'POST'))!!}
            
            <div class="modal-body form-horizontal form-group-separated">                        
                <div class="form-group">
                    {!!Form::label('name', trans('auth.Name').'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        {!!Form::input('text', 'name', '', ['class' => 'form-control', 'placeholder' => trans('auth.Name')])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('slug', trans('menu.Slug'), ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        {!!Form::input('text', 'slug', '', ['class' => 'form-control', 'placeholder' => trans('menu.Slug')])!!}
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
    
@stop