@extends('layout.dashboard.main')

@section('more_head')

@stop
@section('more_foot')

@stop

@section('content')  

    {{-- START BASIC ELEMENTS --}}
    <div class="content-frame">
    
        <div class="content-frame-top">
            <h1>{!!trans('menu.Variations')!!}</h1>
        </div>
            
        <div class="content-frame-left">

            <div class="col-md-12" style="padding:0">

                <div class="widget widget-warning widget-no-subtitle">
                    <div class="widget-subtitle">{!! trans('messages.Variations') !!}</div>
                    <div class="widget-big-int"><span class="num-count">{!!$variations->count()!!}</span></div>            
                </div>
                <a href="#" data-toggle="modal" data-target="#modal_add_variation" class="tile tile-success tile-valign">
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
                            <table id="variations" class="table datatable table-condensed">
                                <thead>
                                    <tr>
                                        <th>{!!trans('auth.Name')!!}</th>
                                        <th>{!!trans('auth.Slug')!!}</th>
                                        <th>{!!trans('auth.Season')!!}</th>
                                        <th>{!!trans('menu.Options')!!}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($variations as $variation)
                                    <tr>
                                        <td>{!!$variation->name!!}</td>
                                        <td>{!!$variation->slug!!}</td>
                                        <td>{!!$variation->season->name!!}</td>
                                        <td>
                                            <button href="#" data-toggle="modal" data-target="#modal_edit_variation{!!$variation->id!!}" class="btn btn-default btn-rounded btn-condensed btn-sm"><span class="fa fa-pencil"></span></button>
                                            <button class="btn btn-danger btn-rounded btn-condensed btn-sm" onClick="confirm_delete_variation({!!$variation->id!!});"><span class="fa fa-times"></span></button>
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

    <div class="modal animated fadeIn" id="modal_add_variation" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">
        <div class="modal-dialog animated zoomIn">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="smallModalHead">{!! trans('menu.New Variation') !!}</h4>
                </div>
                <div class="modal-body">
                    
                </div>
                {!!Form::open(array('url' => '/catalogue/variations/new', 'method'=>'POST'))!!}
                
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
                    <div class="form-group">
                        {!!Form::label('season_id', trans('auth.Season'), ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">
                            {!!Form::select('season_id', \App\Season::lists('name', 'id'), \App\Option::where('name', 'active_season')->value('value'), ['class' => 'form-control'])!!}
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
    
    @foreach ($variations as $variation)
    
        <div class="modal animated fadeIn" id="modal_edit_variation{!!$variation->id!!}" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">
            <div class="modal-dialog animated zoomIn">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="smallModalHead">{!! trans('menu.New Variation') !!}</h4>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                    {!!Form::open(array('url' => '/catalogue/variation/edit', 'method'=>'GET'))!!}
                    
                    {!!Form::hidden('id', $variation->id)!!}
                    <div class="modal-body form-horizontal form-group-separated">                        
                        <div class="form-group">
                            {!!Form::label('name', trans('auth.Name').'*', ['class' => 'col-md-3 control-label'])!!}
                            <div class="col-md-8">
                                {!!Form::input('text', 'name', $variation->name, ['class' => 'form-control', 'placeholder' => trans('auth.Name')])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!!Form::label('slug', trans('menu.Slug'), ['class' => 'col-md-3 control-label'])!!}
                            <div class="col-md-8">
                                {!!Form::input('text', 'slug', $variation->slug, ['class' => 'form-control', 'placeholder' => trans('menu.Slug')])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!!Form::label('season_id', trans('menu.Season'), ['class' => 'col-md-3 control-label'])!!}
                            <div class="col-md-8">
                                {!!Form::select('season_id', \App\Season::lists('name', 'id'), $variation->season->id, ['class' => 'form-control'])!!}
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

    @endforeach
    {{-- end MODALS --}}

@stop
