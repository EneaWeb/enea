@extends('layout.dashboard.main')

@section('more_head')

@stop
@section('more_foot')

@stop

@section('content')                
    <div class="page-content-wrap">
        
        <div class="page-title">                    
            <h2>{!!trans('menu.New Order')!!}</h2>
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
                                        <span class="stepDesc">Step 1<br><small>SELEZIONA IL CLIENTE</small></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="disabled" isdone="0" style="cursor:default">
                                        <span class="stepNumber">2</span>
                                        <span class="stepDesc">Step 2<br><small>INFORMAZIONI PRELIMINARI</small></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="disabled" isdone="0" style="cursor:default">
                                        <span class="stepNumber">3</span>
                                        <span class="stepDesc">Step 3<br><small>INSERISCI GLI ARTICOLI</small></span>                   
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="disabled" isdone="0" style="cursor:default">
                                        <span class="stepNumber">4</span>
                                        <span class="stepDesc">Step 4<br><small>CONFERMA</small></span>                   
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
            <div class="col-md-10">
                {{-- START DATATABLE EXPORT --}}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            {!!trans('messages.Select Customer')!!}
                        </h3>                        
                    </div>
                    <div class="panel-body">
                    
                        <div class="panel-content">

                            <div class="panel-body">

                            </div>
                            
                            <div class="modal-body form-horizontal form-group-separated">
                                <br>                      
                                <div class="form-group">
                                    {!!Form::label('companyname', 'Cerca per ragione sociale', ['class' => 'col-md-3 control-label'])!!}
                                    <div class="col-md-6 col-xs-8">   
                                        Cerca un cliente già inserito scrivendo qui la ragione sociale (dropdown):
                                        <br><br>
                                        {!!Form::input(
                                            'text', 
                                            'companyname', 
                                            (Session::has('order')) ? 
                                            \App\Customer::find(Session::get('order.customer_id'))->companyname : 
                                            '', 
                                            ['class'=>'form-control ui-autocomplete-input', 'id'=>'customer-full-autocomplete']
                                        )!!}
                                    </div>
                                    <div class="col-md-2 col-xs-2">
                                        <br><br>
                                        <a class="goto-step2" 
                                        @if (Session::has('order.customer_id'))
                                            href="/order/new/step2?id={!!Session::get('order.customer_id')!!}"
                                        @else
                                            href=""
                                        @endif
                                        >
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">CONTINUA</button>
                                        </a>
                                    </div>
                                    <div class="clearfix"></div><br>
                                </div>
                            </div>
                            
                            <div class="modal-body form-horizontal form-group-separated">
                                <br>                      
                                <div class="form-group">
                                    {!!Form::label('companyname', 'O crea una uova anagrafica', ['class' => 'col-md-3 control-label'])!!}
                                    <div class="col-md-6 col-xs-12">
                                        <a href="#" data-toggle="modal" data-target="#modal_add_customer" class="btn btn-danger">
                                            {!!trans('menu.New Customer')!!}
                                        </a>
                                    </div>
                                    <div class="clearfix"></div><br>
                                </div>
                            </div>
                            
                            <div class="modal-body form-horizontal form-group-separated">  
                            
                                <div class="form-group">
                                    {!!Form::label('name', trans('auth.Name'), ['class' => 'col-md-3 control-label'])!!}
                                    <div class="col-md-8">   
                                        {!!Form::input(
                                            'text', 
                                            'name', 
                                            (Session::has('order')) ? 
                                            \App\Customer::find(Session::get('order.customer_id'))->name : 
                                            '', 
                                            ['class'=>'form-control maxw500', 'disabled'=>'']
                                        )!!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!!Form::label('sign', trans('auth.Sign'), ['class' => 'col-md-3 control-label'])!!}
                                    <div class="col-md-8">   
                                        {!!Form::input(
                                            'text', 
                                            'sign', 
                                            (Session::has('order')) ? 
                                            \App\Customer::find(Session::get('order.customer_id'))->sign : 
                                            '', 
                                            ['class'=>'form-control maxw500 ui-autocomplete-input', 'disabled'=>'']
                                        )!!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!!Form::label('vat', trans('auth.Vat'), ['class' => 'col-md-3 control-label'])!!}
                                    <div class="col-md-8">   
                                        {!!Form::input(
                                            'text', 
                                            'vat', 
                                            (Session::has('order')) ? 
                                            \App\Customer::find(Session::get('order.customer_id'))->vat : 
                                            '', 
                                            ['class'=>'form-control maxw500', 'disabled'=>'']
                                        )!!}
                                    </div>
                                </div>
                                <div class="form-group">
                                        {!!Form::label('address', trans('menu.Address'), ['class' => 'col-md-3 control-label'])!!}
                                    <div class="col-md-8">
                                        {!!Form::input(
                                            'text', 
                                            'address', 
                                            (Session::has('order')) ? 
                                            \App\Customer::find(Session::get('order.customer_id'))->address : 
                                            '', 
                                            ['class'=>'form-control maxw500', 'disabled'=>'']
                                        )!!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!!Form::label('telephone', trans('auth.Telephone'), ['class' => 'col-md-3 control-label'])!!}
                                    <div class="col-md-8">   
                                        {!!Form::input(
                                            'text', 
                                            'telephone', 
                                            (Session::has('order')) ? 
                                            \App\Customer::find(Session::get('order.customer_id'))->telephone : 
                                            '', 
                                            ['class'=>'form-control maxw500', 'disabled'=>'']
                                        )!!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!!Form::label('telephone', trans('auth.Mobile'), ['class' => 'col-md-3 control-label'])!!}
                                    <div class="col-md-8">   
                                        {!!Form::input(
                                            'text', 
                                            'mobile', 
                                            (Session::has('order')) ? 
                                            \App\Customer::find(Session::get('order.customer_id'))->mobile : 
                                            '', 
                                            ['class'=>'form-control maxw500', 'disabled'=>'']
                                        )!!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!!Form::label('email', trans('auth.Email'), ['class' => 'col-md-3 control-label'])!!}
                                    <div class="col-md-8">   
                                        {!!Form::email(
                                            'email', 
                                            (Session::has('order')) ? 
                                            \App\Customer::find(Session::get('order.customer_id'))->email : 
                                            '', 
                                            ['class'=>'form-control maxw500', 'disabled'=>'']
                                        )!!}
                                    </div>
                                </div>
                                <br><br><br>
                            </div>
                            <div style="text-align:right">
                                <a id="continue" class="goto-step2" 
                                @if (Session::has('order.customer_id'))
                                    href="/order/new/step2?id={!!Session::get('order.customer_id')!!}"
                                @else
                                    href=""
                                @endif
                                >
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">CONTINUA</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


            </div>   
        </div>
    </div>
@include('pages.customers._modal_add_customer');
@stop