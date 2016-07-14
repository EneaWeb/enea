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
                    {!!Form::label('vat', trans('auth.Vat').'', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">   
                        {!!Form::input('text', 'vat', '', ['class'=>'form-control'])!!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">{!!trans('auth.Address')!!}*</label>
                    <div class="col-md-8">  
                        {!!Form::input('text', 'address', '', ['class'=>'form-control'])!!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">{!!trans('auth.City')!!}*</label>
                    <div class="col-md-8">  
                        {!!Form::input('text', 'city', '', ['class'=>'form-control'])!!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">{!!trans('auth.Province')!!}</label>
                    <div class="col-md-8">  
                        {!!Form::input('text', 'province', '', ['class'=>'form-control'])!!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">{!!trans('auth.Postcode')!!}</label>
                    <div class="col-md-8">  
                        {!!Form::input('text', 'postcode', '', ['class'=>'form-control'])!!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">{!!trans('auth.Country')!!}</label>
                    <div class="col-md-8">  
                        {!!Form::input('text', 'country', '', ['class'=>'form-control'])!!}
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
                <div class="form-group">
                    {!!Form::label('language', trans('auth.Language').'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">   
                        {!!Form::select('language', $supportedLocales, '', ['class'=>'form-control'])!!}
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

@section('more_scripts5')
    <script>
        // disable ENTER on form
        $('#customer-form').on('keyup keypress', function(e) {
          var keyCode = e.keyCode || e.which;
          if (keyCode === 13) { 
            e.preventDefault();
            return false;
          }
        });
        
        $( window ).load(function() {
        
            $.getJSON('/customers/api-companyname', function(data) {
                $( "#customer-autocomplete" ).autocomplete({
                    source: data
                });
            });
            
            $.getJSON('/customers/api-sign', function(data) {
                $( "#sign-autocomplete" ).autocomplete({
                    source: data
                });
            });
        });
    </script>
@stop