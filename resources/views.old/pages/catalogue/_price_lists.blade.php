<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">{!!trans('x.Price Lists')!!}</h3>      
            <ul class="panel-controls">
                <li><a href="#" data-toggle="modal" data-target="#modal_add_list"><span class="fa fa-plus"></span></a></li>
            </ul>                     
    </div>
    <div class="panel-body">  
        @if ($season->season_lists->all())
        @foreach($season->season_lists->all() as $season_list)
                <table class="table" style="margin-bottom:6px">
                <tr class="active">
                    <td style="padding:4px;"" >
                        <strong>{!!$season_list->name!!} </strong>[{!!$season_list->slug!!}]
                    </td>
                    <td style="padding:4px; width:90px">
                        <span class="badge badge-warning">
                            <a href="#" data-toggle="modal" data-target="#modal_edit_list{!!$season_list->id!!}" style="color:inherit; padding:6px">
                                <span class="fa fa-pencil"></span>
                            </a>
                        </span>
                        <span class="badge badge-danger">
                            <a href="#" onclick="confirm_delete_list({!!$season_list->id!!})" style="color:inherit; padding:6px">
                                <span class="fa fa-ban"></span>
                            </a>
                        </span>
                    </td>
                </tr>    
                </table>
        @endforeach
        @endif
    </div>
</div>


{{-- MODALS --}}

<div class="modal animated fadeIn" id="modal_add_list" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">
    <div class="modal-dialog animated zoomIn">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="smallModalHead">{!! trans('x.New price list for this Season') !!}</h4>
            </div>
            <div class="modal-body">
                
            </div>
            {!!Form::open(array('url' => '/catalogue/seasons/list/new', 'method'=>'POST'))!!}
            
            {!!Form::hidden('season_id', $season->id)!!}
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


@foreach($season->season_lists->all() as $season_list)

    <div class="modal animated fadeIn" id="modal_edit_list{!!$season_list->id!!}" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">
        <div class="modal-dialog animated zoomIn">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="smallModalHead">{!! trans('x.Edit price list for this Season') !!}</h4>
                </div>
                <div class="modal-body">
                    
                </div>
                {!!Form::open(array('url' => '/catalogue/seasons/list/edit', 'method'=>'GET'))!!}
                
                {!!Form::hidden('id', $season_list->id)!!}
                {!!Form::hidden('season_id', $season_list->season_id)!!}
                <div class="modal-body form-horizontal form-group-separated">                        
                    <div class="form-group">
                        {!!Form::label('name', trans('x.Name').'*', ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">
                            {!!Form::input('text', 'name', $season_list->name, ['class' => 'form-control', 'placeholder' => trans('x.Name')])!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('slug', trans('x.Slug'), ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">
                            {!!Form::input('text', 'slug',  $season_list->slug, ['class' => 'form-control', 'placeholder' => trans('x.Slug')])!!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {!!Form::submit(trans('x.Edit'), ['class' => 'btn btn-danger'])!!}
                    <button type="button" class="btn btn-default" data-dismiss="modal">{!!trans('x.Close')!!}</button>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
     </div>
@endforeach

{{--- END MODALS --}}
