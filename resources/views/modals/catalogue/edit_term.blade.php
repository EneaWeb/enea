<div class="modal animated fadeIn" id="modal_edit_term{!!$term->id!!}" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">
    <div class="modal-dialog animated zoomIn">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="smallModalHead">{!! trans('x.Edit Term') !!}</h4>
            </div>
            <div class="modal-body">

                {!!Form::open(array('url' => '/catalogue/terms/edit', 'method'=>'POST'))!!}

                {!!Form::hidden('term_id', $term->id)!!}
                {!!Form::hidden('attribute_id', $term->attribute_id)!!}

                <div class="modal-body form-horizontal form-group-separated">         
                    <div class="form-group">
                    </div>             
                    <div class="form-group">
                        {!!Form::label('attribute_show', trans('x.Attribute'), ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8" style="color:grey; padding-top:7px">
                            {!!$term->attribute_id!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('id', 'Slug*', ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">
                            {!!Form::input('text', 'id', $term->id, ['class' => 'form-control', 'placeholder' => trans('x.Value')])!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('name', trans('x.Name').'*', ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">
                            {!!Form::input('text', 'name', $term->name, ['class' => 'form-control', 'placeholder' => trans('x.Value')])!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('hex', trans('x.Color'), ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">
                            {!!Form::input('text', 'hex', $term->hex, ['class' => 'form-control color-selector', 'placeholder' => trans('x.Value')])!!}
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