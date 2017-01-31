<div class="modal animated fadeIn" id="modal_edit_attribute{!!$attr->id!!}" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">
    <div class="modal-dialog animated zoomIn">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="smallModalHead">{!! trans('x.Add Attribute') !!}</h4>
            </div>
            <div class="modal-body">

                {!!Form::open(array('url' => '/catalogue/attributes/edit', 'method'=>'POST'))!!}

                {!!Form::hidden('attribute_id', $attr->id)!!}

                <div class="modal-body form-horizontal form-group-separated">         
                    <div class="form-group">
                    </div>             
                    <div class="form-group">
                        {!!Form::label('companyname', trans('x.ID').'*', ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">
                            {!!Form::input('text', 'id', $attr->id, ['class' => 'form-control', 'placeholder' => trans('x.ID')])!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('text', trans('x.Name').'*', ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">
                            {!!Form::input('text', 'name', $attr->name, ['class' => 'form-control', 'placeholder' => trans('x.Name')])!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('description', trans('x.Description'), ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">
                            {!!Form::textarea('description', $attr->description, ['class' => 'form-control', 'placeholder' => trans('x.Description')])!!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {!!Form::submit(trans('x.Save'), ['class' => 'btn btn-danger'])!!}
                    <button type="button" class="btn btn-default" data-dismiss="modal">{!!trans('x.Close')!!}</button>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
 </div>