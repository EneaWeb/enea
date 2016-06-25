@extends('layout.dashboard.main')

@section('more_head')

@stop
@section('more_foot')

@stop

@section('content')  

    {{-- START BASIC ELEMENTS --}}
    <div class="content-frame">
    
        <div class="content-frame-left">

            <div class="col-md-12" style="padding:0">
                
            @if (\App\Option::active_season() != NULL)
                <div class="widget widget-warning widget-no-subtitle">
                    <div class="widget-subtitle">{!! trans('messages.Current Season') !!}</div>
                    <div class="widget-big-int"><span class="num-count">{!!\App\Option::active_season()->name!!}</span></div>            
                </div>
            @endif
                <a href="#" data-toggle="modal" data-target="#modal_add_season" class="tile tile-success tile-valign">
                    <span class="fa fa-plus"></span>
                </a>
                <div class="widget widget-success widget-no-subtitle">
                    <span class="widget-subtitle">{!!trans('messages.Change active Season')!!}</span>
                    <div class="widget-title">
                        {!!Form::open(['url'=>'/catalogue/season/select', 'method'=>'POST', 'class'=>'form-material'])!!}
                            {!!Form::select('season_id', \App\Season::lists('name', 'id'), '', ['class'=>'form-control', 'style'=>'text-indent:10px; background-color:white', 'onchange'=>'this.form.submit()', 'placeholder'=>trans('messages.Please select')])!!}
                        {!!Form::close()!!}
                    </div>                                                     
                </div>
            </div>
            
            <div class="panel panel-default">
                <h3 class="list-group-item">{!! trans('menu.Show Season')!!}</h3>
                <div class="panel-body">
                    {!! Form::open(['url'=> '/catalogue/seasons/change', 'method'=>'POST', 'class'=>'form-material'])!!}
                    
                        <div class="form-group">
                            <select name="season_id" class="form-control" onchange="this.form.submit()">
                                    <option value="">{!!trans('menu.Select')!!}</option>
                                @foreach (\App\Season::all() as $s)
                                    <option value="{!!$s->id!!}">{!!$s->name!!}</option>
                                @endforeach
                            </select>
                            <label for="season_id">{!!trans('menu.Select Season')!!}</label>
                        </div>          
                        
                    {!!Form::close()!!}
                </div>
            </div>
            
        </div>
        
        <div class="content-frame-body content-frame-body-right" style="padding-top:0">
        
            <div class="content-frame-top">
            
                <h1>{!!trans('menu.Season')!!} <span class="btn btn-success btn-lg">{!!$season->name!!}</span></h1>
                
            </div>

            <div class="col-md-12 col-lg-6" style="margin-top:10px">
            
                @include('pages.catalogue._price_lists')
            
                @include('pages.catalogue._delivery_dates')
                                
            </div>
            
            <div class="col-md-12 col-lg-6" style="margin-top:10px">
            
               
            
            </div>

        </div>
        
    </div>
    
    {{-- MODAL --}}
    
    <div class="modal animated fadeIn" id="modal_add_season" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">

        <div class="modal-dialog animated zoomIn">
        
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="smallModalHead">{!! trans('menu.New Season') !!}</h4>
                </div>
                <div class="modal-body">

                </div>
                {!!Form::open(array('url' => '/catalogue/season/new', 'method'=>'POST', 'id'=>'season-form'))!!}
                
                <div class="modal-body form-horizontal form-group-separated">                        
                    <div class="form-group">
                        {!!Form::label('name', trans('auth.Name').'*', ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">   
                            {!!Form::input('text', 'name', '', ['class'=>'form-control'])!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('slug', trans('auth.Slug').'*', ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">   
                            {!!Form::input('text', 'slug', '', ['class'=>'form-control'])!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('description', trans('auth.Description'), ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">   
                            {!!Form::textarea('description', '', ['class'=>'form-control'])!!}
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