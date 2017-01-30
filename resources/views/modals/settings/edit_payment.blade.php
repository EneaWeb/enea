<div class="modal-dialog animated zoomIn">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="smallModalHead">{!! trans('x.New delivery date for this Season') !!}</h4>
        </div>
        <div class="modal-body">
            
        </div>
        {!!Form::open(array('url' => '/admin/payment/edit', 'method'=>'GET'))!!}
        
        {!!Form::hidden('id', $payment->id)!!}
        <div class="modal-body form-horizontal form-group-separated">                        
            <div class="form-group">
                {!!Form::label('name', trans('x.Name').'*', ['class' => 'col-md-3 control-label'])!!}
                <div class="col-md-8">
                    {!!Form::input('text', 'name', $payment->name, ['class' => 'form-control', 'placeholder' => trans('x.Name')])!!}
                </div>
            </div>
            <div class="form-group">
                {!!Form::label('slug', 'Slug', ['class' => 'col-md-3 control-label'])!!}
                <div class="col-md-8">
                    {!!Form::input('text', 'slug', $payment->slug, ['class' => 'form-control', 'placeholder' => trans('x.Slug')])!!}
                </div>
            </div>
            <div class="form-group">
                {!!Form::label('slug', trans('x.Action'), ['class' => 'col-md-3 control-label'])!!}
                <div class="col-md-8">
                    {!!Form::select('action', [''=>trans('x.None'), '+'=>trans('x.Increase'), '-'=>trans('x.Discount')], $payment->action, ['class' => 'form-control', 'placeholder' => trans('x.Select')])!!}
                </div>
            </div>
            <div class="form-group">
                {!!Form::label('amount', trans('x.Amount').' (%)', ['class' => 'col-md-3 control-label'])!!}
                <div class="col-md-8">
                    {!!Form::input('number', 'amount', $payment->amount, ['class' => 'form-control', 'placeholder' => '0 %'])!!}
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