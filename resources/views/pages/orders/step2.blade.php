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
                                    <a href="#" class="done" isdone="1" style="cursor:default">
                                        <span class="stepNumber">1</span>
                                        <span class="stepDesc">Step 1<br><small>SELEZIONA IL CLIENTE</small></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="selected" isdone="0" style="cursor:default">
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
                            Informazioni preliminari
                        </h3>                        
                    </div>
                    <div class="panel-body">
                    
                        <div class="panel-content">

                            {!!Form::open(['url'=>'/order/new/step3', 'method'=>'GET'])!!}
                            <div class="modal-body form-horizontal form-group-separated">
                                <br>
                                {!!Form::hidden('customer_id', $customer->id)!!}
                                <div class="form-group">
                                    {!!Form::label('payment_id', 'Seleziona il listino*', ['class' => 'col-md-3 control-label'])!!}
                                    <div class="col-md-6 col-xs-12">   
                                        {!!Form::select('season_list_id', \App\SeasonList::where('season_id', \App\Option::where('name', 'active_season')->first()->value)->lists('name', 'id'), '', ['class'=>'form-control'])!!}
                                    </div>
                                    <div class="clearfix"></div><br>
                                </div>
                                <div class="form-group">
                                    {!!Form::label('payment_id', 'Seleziona un metodo di pagamento*', ['class' => 'col-md-3 control-label'])!!}
                                    <div class="col-md-6 col-xs-12">   
                                        {!!Form::select('payment_id', \App\Payment::where('active', '1')->lists('name', 'id'), '', ['class'=>'form-control'])!!}
                                    </div>
                                    <div class="clearfix"></div><br>
                                </div>
                                <div class="form-group">
                                    {!!Form::label('season_delivery_id', 'Seleziona una data di consegna*', ['class' => 'col-md-3 control-label'])!!}
                                    <div class="col-md-6 col-xs-12">   
                                        {!!Form::select('season_delivery_id', \App\SeasonDelivery::where('active', '1')->lists('name', 'id'), '', ['class'=>'form-control'])!!}
                                    </div>
                                        <a href="#" data-toggle="modal" data-target="#modal_add_delivery">
                                            <button class="btn btn-main" style="margin-top:12px; color:white"><span class="fa fa-plus"></span></button>
                                        </a>
                                    <div class="clearfix"></div><br>
                                </div>
                                <div class="form-group">
                                    {!!Form::label('customer_delivery_id', 'Seleziona una indirizzo di consegna*', ['class' => 'col-md-3 control-label'])!!}
                                    <div class="col-md-6 col-xs-12">
                                        <select name="customer_delivery_id" class="form-control">
                                            <option value="0">{!!$customer->address.' - '.$customer->postcode.' '.$customer->city!!}</option>
                                            @foreach (\App\CustomerDelivery::where('customer_id', $customer->id)->get() as $addr)
                                                <option value="{!!$addr->id!!}">{!!$addr->address.' - '.$addr->postcode.' '.$addr->city!!}</option>
                                            @endforeach
                                        </select>   
                                    </div>
                                    <div class="clearfix"></div><br>
                                </div>
                            </div>
                            
                            <div class="modal-body form-horizontal form-group-separated">
                                <br>                      
                                <div class="form-group">
                                    {!!Form::label('companyname', 'Clicca per continuare', ['class' => 'col-md-3 control-label'])!!}
                                    <div class="col-md-6 col-xs-12">
                                        {!!Form::submit(trans('menu.Continue'), ['class'=>'btn btn-danger'])!!}
                                    </div>
                                    <div class="clearfix"></div><br>
                                </div>
                            </div>
                            {!!Form::close()!!}
                        </div>
                    </div>
                </div>
            </div>   
        </div>
    </div>

@include('pages.customers._modal_add_delivery')

@stop