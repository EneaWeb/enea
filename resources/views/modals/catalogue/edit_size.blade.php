<div class="modal animated fadeIn" id="modal_edit_size{!!$size->id!!}" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">
    <div class="modal-dialog animated zoomIn">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="smallModalHead">{!! trans('x.Invite an user to work with you') !!}!</h4>
            </div>
            <div class="modal-body">

                {!!Form::open(array('url' => '/catalogue/size/edit', 'method'=>'POST'))!!}

                {!!Form::hidden('size_id', $size->id)!!}

                <div class="modal-body form-horizontal form-group-separated">         
                    <div class="form-group">
                    </div>             
                    <div class="form-group">
                        {!!Form::label('companyname', trans('x.ID').'*', ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">
                            {!!Form::input('text', 'id', $size->id, ['class' => 'form-control', 'placeholder' => trans('x.ID')])!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('text', trans('x.Name').'*', ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">
                            {!!Form::input('text', 'name', $size->name, ['class' => 'form-control', 'placeholder' => trans('x.Name')])!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('types', trans('x.Types').' (default)*', ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">
                            {!!Form::select('types', \App\Type::pluck('name', 'id'), unserialize($size->types), ['class'=>'selectpicker form-control', 'multiple'=>'multiple', 'name'=>'types[]'])!!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {!!Form::submit(trans('x.Invite now'), ['class' => 'btn btn-danger'])!!}
                    <button type="button" class="btn btn-default" data-dismiss="modal">{!!trans('x.Close')!!}</button>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>