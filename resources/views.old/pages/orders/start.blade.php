@extends('layout.dashboard.main')

@section('more_head')

@stop
@section('more_foot')

@stop

@section('content')                
    <div class="page-content-wrap">
        
        <div class="page-title">                    
            <h2>{!!trans('x.New Order')!!}</h2>
        </div>
        {{-- START WIDGETS --}}
        <div class="row">
            
            <div class="col-md-12">
                
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="wizard2">
                            <ul class="steps_4 anchor" style="margin-bottom:30px">
                                <li>
                                    <a href="#" class="selected" isdone="0" style="cursor:default">
                                        <span class="stepNumber">1</span>
                                        <span class="stepDesc">Step 1<br><small>{!!trans('x.Select Customer')!!}</small></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="disabled" isdone="0" style="cursor:default">
                                        <span class="stepNumber">2</span>
                                        <span class="stepDesc">Step 2<br><small>{!!trans('x.First Informations')!!}</small></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="disabled" isdone="0" style="cursor:default">
                                        <span class="stepNumber">3</span>
                                        <span class="stepDesc">Step 3<br><small>{!!trans('x.Select Products')!!}</small></span>                   
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="disabled" isdone="0" style="cursor:default">
                                        <span class="stepNumber">4</span>
                                        <span class="stepDesc">Step 4<br><small>{!!trans('x.Confirm')!!}</small></span>                   
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        {{-- END WIDGETS --}}

        <div class="row">  
            <div class="col-md-12 col-lg-10">
                {{-- START DATATABLE EXPORT --}}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            {!!trans('x.Select Customer')!!}
                        </h3>                        
                    </div>
                    <div class="panel-body">
                    
                        <div class="panel-content">

                            <div class="panel-body">

                            </div>
                            
                            <div class="modal-body form-horizontal form-group-separated">
                                <br>                      
                                <div class="form-group">
                                    {!!Form::label('companyname', trans('x.Search by Company Name'), ['class' => 'col-md-3 control-label'])!!}
                                    <div class="col-md-6 col-xs-8">   
                                        {!!trans('x.Search for a Customer by Company Name (dropdown)')!!}:
                                        <br><br>
                                        {!!Form::input(
                                            'text', 
                                            'companyname', 
                                            (Session::has('order')) ? 
                                            \App\Customer::find(Session::get('order.customer_id'))->companyname : 
                                            '', 
                                            ['class'=>'form-control ui-autocomplete-input', 'id'=>'customer-full-autocomplete']
                                        )!!}
                                        <br>
                                        <a class="goto-step2" 
                                        @if (Session::has('order.customer_id'))
                                            href="/order/new/step2?id={!!Session::get('order.customer_id')!!}"
                                        @else
                                            href=""
                                        @endif
                                        >
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                {!!strtoupper(trans('x.Continue'))!!}
                                            </button>
                                        </a>
                                    </div>
                                    <div class="clearfix"></div><br>
                                </div>
                            </div>
                                              
                            <div class="col-md-3"></div>
                            <div class="modal-body form-horizontal form-material col-md-12 col-lg-8" style="padding-left:0px">  
                            <br><br>
                                <div class="form-group col-md-6">
                                    {!!Form::label('name', trans('x.Name'), ['class' => 'control-label'])!!}
                                        {!!Form::input(
                                            'text', 
                                            'name', 
                                            (Session::has('order')) ? 
                                            \App\Customer::find(Session::get('order.customer_id'))->name : 
                                            '', 
                                            ['class'=>'form-control maxw500', 'disabled'=>'']
                                        )!!}
                                </div>
                                <div class="form-group col-md-6">
                                    {!!Form::label('sign', trans('x.Sign'), ['class' => 'control-label'])!!}
                                        {!!Form::input(
                                            'text', 
                                            'sign', 
                                            (Session::has('order')) ? 
                                            \App\Customer::find(Session::get('order.customer_id'))->sign : 
                                            '', 
                                            ['class'=>'form-control maxw500 ui-autocomplete-input', 'disabled'=>'']
                                        )!!}
                                </div>
                                <div class="form-group col-md-6">
                                    {!!Form::label('vat', trans('x.Vat'), ['class' => 'control-label'])!!}
                                        {!!Form::input(
                                            'text', 
                                            'vat', 
                                            (Session::has('order')) ? 
                                            \App\Customer::find(Session::get('order.customer_id'))->vat : 
                                            '', 
                                            ['class'=>'form-control maxw500', 'disabled'=>'']
                                        )!!}
                                </div>
                                <div class="form-group col-md-6">
                                        {!!Form::label('address', trans('x.Address'), ['class' => 'control-label'])!!}
                                        {!!Form::input(
                                            'text', 
                                            'address', 
                                            (Session::has('order')) ? 
                                            \App\Customer::find(Session::get('order.customer_id'))->address : 
                                            '', 
                                            ['class'=>'form-control maxw500', 'disabled'=>'']
                                        )!!}
                                </div>
                                <div class="form-group col-md-6">
                                    {!!Form::label('telephone', trans('x.Telephone'), ['class' => 'control-label'])!!}
                                        {!!Form::input(
                                            'text', 
                                            'telephone', 
                                            (Session::has('order')) ? 
                                            \App\Customer::find(Session::get('order.customer_id'))->telephone : 
                                            '', 
                                            ['class'=>'form-control maxw500', 'disabled'=>'']
                                        )!!}
                                </div>
                                <div class="form-group col-md-6">
                                    {!!Form::label('telephone', trans('x.Mobile'), ['class' => 'control-label'])!!}
                                        {!!Form::input(
                                            'text', 
                                            'mobile', 
                                            (Session::has('order')) ? 
                                            \App\Customer::find(Session::get('order.customer_id'))->mobile : 
                                            '', 
                                            ['class'=>'form-control maxw500', 'disabled'=>'']
                                        )!!}
                                </div>
                                <div class="form-group col-md-6">
                                    {!!Form::label('email', trans('x.Email'), ['class' => 'control-label'])!!}
                                        {!!Form::email(
                                            'email', 
                                            (Session::has('order')) ? 
                                            \App\Customer::find(Session::get('order.customer_id'))->email : 
                                            '', 
                                            ['class'=>'form-control maxw500', 'disabled'=>'']
                                        )!!}
                                </div>
                            </div>
                            <div class="modal-body form-horizontal form-group-separated">
                                <div class="clearfix">&nbsp;</div>
                            </div>
                            <div class="modal-body form-horizontal form-group-separated">
                                <br>                      
                                <div class="form-group">
                                    {!!Form::label('companyname', trans('x.Or create a new Customer'), ['class' => 'col-md-3 control-label'])!!}
                                    <div class="col-md-6 col-xs-12">
                                        <a href="#" data-toggle="modal" data-target="#modal_add_customer" class="btn btn-danger">
                                            {!!trans('x.New Customer')!!}
                                        </a>
                                    </div>
                                    <div class="clearfix"></div><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>   
        </div>
    </div>
@include('pages.customers._modal_add_customer')
@stop

@section('more_scripts')
    <script>
        $( window ).load(function() {
            $.getJSON('/customers/api-companyname', function(data) {
                $( "#customer-full-autocomplete" ).autocomplete({
                    source: data,
                    select: function(event, ui) {
                        if(ui.item){
                            
                            $.ajax({
                                type: 'GET',
                                data: {
                                    'companyname' : ui.item.value,
                                    format: 'json'
                                },
                                url: '/customers/api-customer-data',
                                success: function(data) {
                                    parsed = JSON.parse(data);
                                    $('#name').val(parsed.name);
                                    $('#surname').val(parsed.surname);
                                    $('#address').val(parsed.address+' '+parsed.postcode+' '+parsed.city+' - '+parsed.country);
                                    $('#sign').val(parsed.sign);
                                    $('#surname').val(parsed.surname);
                                    $('#vat').val(parsed.vat);
                                    $('#telephone').val(parsed.telephone);
                                    $('#mobile').val(parsed.mobile);
                                    $('#email').val(parsed.email);
                                    // current locale
                                    currentlocale = $('#getcurrentlocale').text()
                                    // CONTINUE button href
                                    $('.goto-step2').attr("href", "/order/new/step2?id="+parsed.id);
                                },
                                error: function() {
                                    console.log('ajax error');
                                }
                            });
                            
                        }
                    }
                });
            });
        });
    </script>
@stop