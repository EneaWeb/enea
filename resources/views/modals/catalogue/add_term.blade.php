<div class="modal animated fadeIn" id="modal_add_term" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">
    <div class="modal-dialog animated zoomIn">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="smallModalHead">{!! trans('x.Add Term') !!}</h4>
            </div>
            <div class="modal-body">

                {!!Form::open(array('url' => '/catalogue/terms/new', 'method'=>'POST', 'id'=>'term-form'))!!}

                <div class="modal-body form-horizontal form-group-separated">         
                    <div class="form-group">
                    </div>             
                    <div class="form-group">
                        {!!Form::label('attribute_id', 'Attribute*', ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">
                            {!!Form::select('attribute_id', \App\Attribute::pluck('name', 'id'),'', ['class' => 'form-control', 'id'=>'set_attr_id'])!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('id', 'ID*', ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">
                            {!!Form::input('text', 'id', '', ['class' => 'form-control', 'placeholder' => trans('x.Value')])!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('name', trans('x.Name').'*', ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">
                            {!!Form::input('text', 'name', '', ['class' => 'form-control', 'placeholder' => trans('x.Value')])!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('color', trans('x.Color'), ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">
                            {!!Form::input('text', 'color', '', ['class' => 'form-control jq-colorpicker'])!!}
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