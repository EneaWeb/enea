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
                                    <a href="#" class="done" isdone="1" style="cursor:default">
                                        <span class="stepNumber">2</span>
                                        <span class="stepDesc">Step 2<br><small>INFORMAZIONI PRELIMINARI</small></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="done" isdone="1" style="cursor:default">
                                        <span class="stepNumber">3</span>
                                        <span class="stepDesc">Step 3<br><small>INSERISCI GLI ARTICOLI</small></span>                   
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="selected" isdone="0" style="cursor:default">
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
            <div class="col-md-12">
                {{-- START DATATABLE EXPORT --}}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Riepilogo dell'ordine
                        </h3>                        
                    </div>
                    <div class="panel-body">
                    
                        <div class="panel-content">

                        {!!Form::open(['url'=>'/order/new/confirm', 'method'=>'GET'])!!}
                        
                            <div class="modal-body form-horizontal form-group-separated">
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        Cliente:
                                    </h6>
                                    <h6 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        {!!\App\Customer::find($fullOrder['customer_id'])->companyname!!} /
                                        {!!\App\Customer::find($fullOrder['customer_id'])->name!!} 
                                        {!!\App\Customer::find($fullOrder['customer_id'])->surname!!}
                                    </h6>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        Dati di fatturazione:
                                    </h6>
                                    <h6 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        {!!\App\Customer::find($fullOrder['customer_id'])->address!!} - 
                                        {!!\App\Customer::find($fullOrder['customer_id'])->postcode!!} 
                                        {!!\App\Customer::find($fullOrder['customer_id'])->city!!} 
                                        ({!!\App\Customer::find($fullOrder['customer_id'])->province!!}) -
                                        {!!\App\Customer::find($fullOrder['customer_id'])->country!!} <br> 
                                        {!!trans('auth.Vat')!!} {!!\App\Customer::find($fullOrder['customer_id'])->vat!!}
                                    </h6>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        Dati di spedizione:
                                    </h6>
                                    <h6 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                    @if($fullOrder['customer_delivery_id'] != 0)
                                        {!!\App\CustomerDelivery::find($fullOrder['customer_delivery_id'])->address!!} - 
                                        {!!\App\CustomerDelivery::find($fullOrder['customer_delivery_id'])->postcode!!} 
                                        {!!\App\CustomerDelivery::find($fullOrder['customer_delivery_id'])->city!!} 
                                        ({!!\App\CustomerDelivery::find($fullOrder['customer_delivery_id'])->province!!}) -
                                        {!!\App\CustomerDelivery::find($fullOrder['customer_delivery_id'])->country!!}
                                    @else
                                        {!!\App\Customer::find($fullOrder['customer_id'])->address!!} - 
                                        {!!\App\Customer::find($fullOrder['customer_id'])->postcode!!} 
                                        {!!\App\Customer::find($fullOrder['customer_id'])->city!!} 
                                        ({!!\App\Customer::find($fullOrder['customer_id'])->province!!}) -
                                        {!!\App\Customer::find($fullOrder['customer_id'])->country!!}
                                    @endif
                                    </h6>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        Listino:
                                    </h6>
                                    <h6 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        {!!\App\SeasonList::find($fullOrder['season_list_id'])->name!!}
                                    </h6>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        Periodo di consegna:
                                    </h6>
                                    <h6 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        {!!\App\SeasonDelivery::find($fullOrder['season_delivery_id'])->name!!}
                                    </h6>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        Modalità di pagamento:
                                    </h6>
                                    <h6 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        {!!\App\Payment::find($fullOrder['payment_id'])->name!!}
                                    </h6>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        Dettagli:
                                    </h6>
                                    <h6 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        <table class="table-condensed table-bordered" style="margin-left:auto; margin-right:auto; border-collapse: collapse; width:100%;">
                                            <tr>
                                                <th></th>
                                                    @foreach (\App\Size::all() as $size)
                                                    <th style="text-align:center">{!!$size->name!!}</th>
                                                    @endforeach
                                            </tr>
                                            @foreach ($products_array as $product_id => $colors)
                                            @foreach ($colors as $key => $color_id)
                                                <tr>
                                                    <th style="border-left:5px solid {!!\App\Color::find($color_id)->hex!!}">
                                                        {!!\App\Product::find($product_id)->model->name!!}
                                                        {!!\App\Product::find($product_id)->name!!} - 
                                                        {!!\App\Color::find($color_id)->name!!}
                                                    </th>
                                                    @foreach (\App\Item::where('product_id', $product_id)->where('color_id', $color_id)->get() as $item)
                                                    <td style="text-align:center">
                                                        @if (array_key_exists($item->id, Session::get('order.items')))
                                                            {!! Session::get('order.items.'.$item->id) !!}
                                                        @endif
                                                    </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                            @endforeach
                                        </table>
                                    </h6>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        N. Pezzi:
                                    </h6>
                                    <h3 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        {!!$qty!!}
                                    </h3>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        Subtotale:
                                        <br>
                                        Variazioni:
                                    </h6>
                                    <h6 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        € {!!number_format($subtotal, 2, ',', '.');!!}
                                        <br>
                                        {!!trans('messages.'.ucfirst(\App\Payment::find($fullOrder['payment_id'])->action))!!}
                                        {!!\App\Payment::find($fullOrder['payment_id'])->amount !!}%
                                    </h6>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        TOTALE:
                                    </h6>
                                    <h3 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        € {!!number_format($total, 2, ',', '.');!!}
                                    </h3>
                                </div>
                                <div class="form-group">
                                    <h3 class="col-md-3 col-xs-12 control-label">
                                        Inserisci note:
                                    </h3>
                                    <h3 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        {!!Form::textarea('note', '', ['class'=>'form-control'])!!}
                                    </h3>
                                </div>
                            </div>
                            
                            <div class="modal-body form-horizontal form-group-separated">
                                <br>                      
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        Clicca per confermare:
                                    </h6>
                                    <div class="col-md-6 col-xs-12">
                                        <button type="button" onclick="location.href='{{ URL::to('/order/new/step3') }}';" class="btn btn-warning">Aggiungi/modifica gli articoli</button>
                                        {!!Form::submit('Conferma', ['class'=>'btn btn-danger'])!!}
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

@stop