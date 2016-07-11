<div class="modal animated fadeIn" id="modal_add_delivery" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">

    <div class="modal-dialog animated zoomIn">
    
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="smallModalHead">{!! trans('menu.New Delivery Address') !!}</h4>
            </div>
            <div class="modal-body">

            </div>
            {!!Form::open(array('url' => '/customer-delivery/new', 'method'=>'POST', 'id'=>'customer-form'))!!}
            
            <div class="modal-body form-horizontal form-group-separated">  
            
                <br>
                {!!Form::hidden('customer_id', $customer->id)!!}
                <div class="form-group">
                    {!!Form::label('receiver', trans('auth.Receiver').'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">   
                        {!!Form::input('text', 'receiver', '', ['class'=>'form-control'])!!}
                    </div>
                </div>
                <div class="form-group">
                        {!!Form::label('address', trans('menu.Address').'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        {!! $autocompleteHelper->renderHtmlContainer($autocomplete2) !!}
                        {{-- Google Autocomplete Script --}}
                         {!! $autocompleteHelper->renderJavascripts($autocomplete2) !!}
                        {{-- END Google Autocomplete Script --}}
                    </div>
                </div>
                <br><br><br>
            </div>
            <div class="modal-footer">
                {!!Form::submit(trans('menu.Create'), ['class' => 'btn btn-danger'])!!}
                <button type="button" class="btn btn-default" data-dismiss="modal">{!!trans('menu.Close')!!}</button>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
<script>
// disable ENTER on form
$('#customer-form').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
</script>