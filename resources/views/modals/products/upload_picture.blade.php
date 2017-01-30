<div class="modal animated fadeIn" id="upload_picture" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">

    <div class="modal-dialog animated zoomIn">
    
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="smallModalHead">{!! trans('x.New Delivery Address') !!}</h4>
            </div>
            <div class="modal-body">

            </div>
            {!!Form::open(array('url' => '/catalogue/products/upload-picture', 'method'=>'POST', 'id'=>'upload-form', 'files'=>true))!!}

            {!!Form::hidden('product_id', $product->id)!!}
            
            <div class="modal-body form-horizontal form-group-separated">  
            
                <br>
                <div class="form-group">
                    <label class="col-md-3 control-label">{!!trans('x.Type')!!}*</label>

                    <div class="col-md-8">   
                        {!!Form::select('type', [
                                                    'product'=>trans('x.Main Picture'),
                                                    'variation'=>trans('x.Main Variation Picture'),
                                                    'variation_picture'=>trans('x.Variation Picture')
                                                ], '', 
                        ['class' => 'form-control', 'id'=>'select-type'])!!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">{!!trans('x.Variation')!!}*</label>
                    <div class="col-md-8">
                        <select id="variation-select" name="variation_id" class="form-control" disabled="disabled">
                            @foreach ($product->variations as $variation)
                                <option value="{!!$variation->id!!}">{!!$variation->color->name!!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">{!!trans('x.Picture')!!}*</label>
                    <div class="col-md-8">
                        {!!Form::file('picture', ['class'=>'form-control'])!!}
                    </div>
                </div>
                <br><br><br>
            </div>
            <div class="modal-footer">
                {!!Form::submit(trans('x.Create'), ['class' => 'btn btn-danger'])!!}
                <button type="button" class="btn btn-default" data-dismiss="modal">{!!trans('x.Close')!!}</button>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>