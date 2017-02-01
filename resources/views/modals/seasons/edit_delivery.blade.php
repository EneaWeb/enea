<div class="modal animated fadeIn" id="modal_edit_delivery{!!$delivery->id!!}" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">
    <div class="modal-dialog animated zoomIn">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="smallModalHead">{!! trans('x.Edit delivery date for this Season') !!}</h4>
            </div>
            <div class="modal-body">
                
            </div>
            {!!Form::open(array('url' => '/catalogue/seasons/delivery/edit', 'method'=>'GET'))!!}
            
            {!!Form::hidden('id', $delivery->id)!!}
            {!!Form::hidden('season_id', $delivery->season_id)!!}
            <div class="modal-body form-horizontal form-group-separated">                        
                <div class="form-group">
                    {!!Form::label('name', trans('x.Name').'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        {!!Form::input('text', 'name', $delivery->name, ['class' => 'form-control', 'placeholder' => trans('x.Name')])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('slug', 'Slug', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        {!!Form::input('text', 'slug',  $delivery->slug, ['class' => 'form-control', 'placeholder' => trans('x.Slug')])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('date', trans('x.Date'), ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        {!! Form::text('date',  $delivery->date, ['class' => 'form-control datepicker', 'placeholder'=>'yyyy-mm-dd']) !!}
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