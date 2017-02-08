<div class="modal animated fadeIn" id="modal_edit_list{!!$list->id!!}" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">
    <div class="modal-dialog animated zoomIn">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="smallModalHead">{!! trans('x.Edit Price List') !!}</h4>
            </div>
            <div class="modal-body">
                
            </div>
            {!!Form::open(array('url' => '/settings/lists/edit', 'method'=>'POST'))!!}
            
            {!!Form::hidden('list_id', $list->id)!!}

            <div class="modal-body form-horizontal form-group-separated"> 
                <div class="form-group">
                    {!!Form::label('id', trans('x.ID').'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        {!!trans('x.ID can\'t be changed. Try deleting the whole price list instead.')!!}
                    </div>
                </div>                       
                <div class="form-group">
                    {!!Form::label('name', trans('x.Name').'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        {!!Form::input('text', 'name', $list->name, ['class' => 'form-control', 'placeholder' => trans('x.Name')])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('active', 'Active', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        {!!Form::select('active', ['1'=>trans('x.Active'), '0'=>trans('x.Inactive')], $list->active, ['class' => 'form-control'])!!}
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