<div class="modal animated fadeIn" id="modal_add_customer" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">

    <div class="modal-dialog animated zoomIn">
    
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="smallModalHead">{!! trans('menu.New Customer') !!}</h4>
            </div>
            <div class="modal-body">

            </div>
            {!!Form::open(array('url' => '/customers/new', 'method'=>'POST', 'id'=>'customer-form'))!!}
            
            <div class="modal-body form-horizontal form-group-separated">  
            
                <br>                      
                <div class="form-group">
                    {!!Form::label('companyname', trans('auth.Company Name').'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">   
                        {!!Form::input('text', 'companyname', '', ['class'=>'form-control ui-autocomplete-input', 'id'=>'customer-autocomplete'])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('sign', trans('auth.Sign').'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">   
                        {!!Form::input('text', 'sign', '', ['class'=>'form-control ui-autocomplete-input', 'id'=>'sign-autocomplete'])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('name', trans('auth.Name').'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">   
                        {!!Form::input('text', 'name', '', ['class'=>'form-control'])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('vat', trans('auth.Vat').'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">   
                        {!!Form::input('text', 'vat', '', ['class'=>'form-control'])!!}
                    </div>
                </div>
                <div class="form-group">
                        {!!Form::label('address', trans('menu.Address').'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        
                        {!! $autocompleteHelper->renderHtmlContainer($autocomplete) !!}
                        {{-- Google Autocomplete Script --}}
                        {!! $autocompleteHelper->renderJavascripts($autocomplete) !!}
                        {{-- END Google Autocomplete Script --}}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('telephone', trans('auth.Telephone').'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">   
                        {!!Form::input('text', 'telephone', '', ['class'=>'form-control'])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('telephone', trans('auth.Mobile'), ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">   
                        {!!Form::input('text', 'mobile', '', ['class'=>'form-control'])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('email', trans('auth.Email').'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">   
                        {!!Form::email('email', '', ['class'=>'form-control'])!!}
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