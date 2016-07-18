<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">{!!trans('messages.Delivery Dates')!!}</h3>      
            <ul class="panel-controls">
                <li><a href="#" data-toggle="modal" data-target="#modal_add_delivery"><span class="fa fa-plus"></span></a></li>
            </ul>                     
    </div>
    <div class="panel-body">  
        @if ($season->season_deliveries->all())
        @foreach($season->season_deliveries->all() as $delivery_date)
                <table class="table" style="margin-bottom:6px">
                <tr class="active">
                    <td style="padding:4px;"" >
                        <strong>{!!$delivery_date->name!!}</strong>
                        @if ($delivery_date->date != '')
                            [ {!!$delivery_date->date!!} ]
                        @endif
                    </td>
                    <td style="padding:4px; width:90px">
                        <span class="badge badge-warning">
                            <a href="#" data-toggle="modal" data-target="#modal_edit_delivery{!!$delivery_date->id!!}" style="color:inherit; padding:6px">
                                <span class="fa fa-pencil"></span>
                            </a>
                        </span>
                        <span class="badge badge-danger">
                            <a href="#" onclick="confirm_delete_delivery({!!$delivery_date->id!!})" style="color:inherit; padding:6px">
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

<div class="modal animated fadeIn" id="modal_add_delivery" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">
    <div class="modal-dialog animated zoomIn">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="smallModalHead">{!! trans('menu.New delivery date for this Season') !!}</h4>
            </div>
            <div class="modal-body">
                
            </div>
            {!!Form::open(array('url' => '/catalogue/seasons/delivery/new', 'method'=>'POST'))!!}
            
            {!!Form::hidden('season_id', $season->id)!!}
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
                    {!!Form::label('date', trans('menu.Date'), ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        {!! Form::text('date', '', ['class' => 'form-control datepicker', 'placeholder'=>'yyyy-mm-dd']) !!}
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


@foreach($season->season_deliveries->all() as $delivery_date)

    <div class="modal animated fadeIn" id="modal_edit_delivery{!!$delivery_date->id!!}" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">
        <div class="modal-dialog animated zoomIn">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="smallModalHead">{!! trans('menu.Edit delivery date for this Season') !!}</h4>
                </div>
                <div class="modal-body">
                    
                </div>
                {!!Form::open(array('url' => '/catalogue/seasons/delivery/edit', 'method'=>'GET'))!!}
                
                {!!Form::hidden('id', $delivery_date->id)!!}
                {!!Form::hidden('season_id', $delivery_date->season_id)!!}
                <div class="modal-body form-horizontal form-group-separated">                        
                    <div class="form-group">
                        {!!Form::label('name', trans('auth.Name').'*', ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">
                            {!!Form::input('text', 'name', $delivery_date->name, ['class' => 'form-control', 'placeholder' => trans('auth.Name')])!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('slug', trans('menu.Slug'), ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">
                            {!!Form::input('text', 'slug',  $delivery_date->slug, ['class' => 'form-control', 'placeholder' => trans('menu.Slug')])!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('date', trans('menu.Date'), ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">
                            {!! Form::text('date',  $delivery_date->date, ['class' => 'form-control datepicker', 'placeholder'=>'yyyy-mm-dd']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {!!Form::submit(trans('menu.Edit'), ['class' => 'btn btn-danger'])!!}
                    <button type="button" class="btn btn-default" data-dismiss="modal">{!!trans('menu.Close')!!}</button>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
     </div>
@endforeach

{{--- END MODALS --}}
