@extends('layout.main')

@section('content')

<!-- BEGIN STEPS -->
    @include('components.orders_steps')
<!-- END STEPS -->

<style>
hr, p {
    margin: 10px 0!important;
}
</style>

<div class="page-content-container">
	<div class="page-content-row">

        @include('sidebars.customers')

        <div class="page-content-col">
            <!-- BEGIN PAGE BASE CONTENT -->
            
            {!!Form::open(['url'=>'/orders/new/confirm', 'method'=>'GET'])!!}

            <div class="invoice-content-2 bordered">
                <div class="row invoice-head">
                    <div class="col-md-7 col-xs-6">
                        <div class="invoice-logo">
                            <img src="{{$brand->logo()}}" class="img-responsive" alt="" style="max-width:40%; heigh:auto;:" />
                            {{-- <h1 class="uppercase">Invoice</h1> --}}
                        </div>
                    </div>
                    <div class="col-md-5 col-xs-6">
                        <div class="company-address">
                            <span class="bold uppercase">{{$brand->companyname}}</span>
                            <br/> {{$brand->address}}, {{$brand->postcode}} {{$brand->city}} {{$brand->province}}
                            <br/> {{$brand->country}}
                            <br/>
                            <span class="bold">T</span> {{$brand->telephone}}
                            <br/>
                            <span class="bold">E</span> {{$brand->email}}
                            <br/>
                            <span class="bold">W</span> {{$brand->website}} </div>
                    </div>
                </div>
                <div class="row invoice-cust-add">
                    <div class="col-xs-6">
                        <h2 class="invoice-title uppercase">Agente</h2>
                        <p class="invoice-desc">{{Auth::user()->profile->companyname}}</p>
                    </div>
                    <div class="col-xs-6">
                        <h2 class="invoice-title uppercase">Data</h2>
                        <p class="invoice-desc">{{\Carbon\Carbon::now()->format('d/m/Y H:i')}}</p>
                    </div>
                </div>
                <div class="row invoice-body">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="invoice-title uppercase"></th>
                                    <th class="invoice-title uppercase text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><p>Cliente</p></td>
                                    <td class="sbold">
                                        <p>{{$customer->companyname}}</p>
                                        @if ($customer->name !== '')
                                            <p> rif {{$customer->name}} </p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><p>Dati di fatturazione</p></td>
                                    <td class="sbold">
                                        <p>{{$customer->address}}, {{$customer->postcode}} {{$customer->city}} {{$customer->province}}</p>
                                        <p>P.Iva/CF {{$customer->vat}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td><p>Dati di spedizione</p></td>
                                    <td class="sbold">
                                        <p>{{$delivery->address}}, {{$delivery->postcode}} {{$delivery->city}} {{$delivery->province}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td><p>Listino</p></td>
                                    <td class="sbold">
                                        <p>{{ \App\PriceList::find(\App\Order::getOption('price_list_id'))->name }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td><p>Periodo di Consegna</p></td>
                                    <td class="sbold">
                                        <p>{{ \App\SeasonDelivery::find(\App\Order::getOption('season_delivery_id'))->name }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td><p>Condizioni di Pagamento</p></td>
                                    <td class="sbold">
                                        <p>{{ $payment->name }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td><p>Note</p></td>
                                    <td class="sbold">
                                        <p>
                                            @if (Session::has('cart.options.order_id'))
                                                <textarea name="note" class="form-control" rows="4" style="max-width:500px">{!!\App\Order::find(Session::get('cart.options.order_id'))->note!!}</textarea>
                                            @else
                                                <textarea name="note" class="form-control" rows="4" style="max-width:500px"></textarea>
                                            @endif
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td><p>Dettaglio:<br></p></td>
                                    <td></td>
                                </td>
                                <tr>
                                    <td colspan="2">
                                        
                                    @if (X::isOrderInProgress())
                                        <table class="table table-striped table-bordered table-hover dataTable" id="">
                                        <thead>
                                            <tr>
                                                <th style="padding:4px"><p>Articolo</p></th>
                                                <th style="padding:4px"><p>Variante</p></th>
                                                @foreach (\App\Size::activeSizes() as $size)
                                                    <th style="padding:4px; text-align:center"><p>{{$size->name}}</p></th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach (\App\Order::reorderCart() as $variation_id => $item_qty)

                                        <?php $variation = \App\Variation::find($variation_id); ?>

                                        <tr>
                                            <td style="padding:4px">{{$variation->product->prodmodel->name}} {{$variation->product->name}}</td>
                                            <td style="padding:4px">{!!$variation->sku !== NULL ? $variation->sku : $variation->renderTerms()!!}</td>
                                            @foreach (\App\Size::activeSizes() as $size)
                                                <?php $item = \App\Item::where('size_id', $size->id)->where('variation_id', $variation->id)->first(); ?>
                                                @if ($item !== NULL)
                                                <td style="padding:4px; text-align:center"><p>{{isset($item_qty[$item->id]) ? $item_qty[$item->id] : ''}}</p></td>
                                                @else
                                                <td style="padding:4px; text-align:center"></td>
                                                @endif
                                            @endforeach
                                        </tr>

                                        @endforeach
                                        </tbody>
                                        </table>                                        
                                        @endif

                                </tr>
                                <tr>
                                    <td><p>N. Pezzi</p></td>
                                    <td class="sbold">
                                        {{Cart::instance('agent')->count()}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Subtotale</p>
                                        <p>Variazione {{$payment->action}}{{$payment->amount}}%</p>
                                    </td>
                                    <td class="sbold">
                                        <p style="color:black">
                                        {{X::priceFormat(Cart::instance('agent')->total())}} € 
                                        </p>
                                        <p>
                                            {{X::priceFormat(Cart::instance('agent')->total()/100*$payment->amount)}} €
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td><p>Total</p></td>
                                    <td class="sbold">
                                        <p class="invoice-desc grand-total" style="color:black">
                                        {{X::priceFormat(X::calculateTotal($payment->action, $payment->amount, Cart::instance('agent')->total()))}} €
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-success btn-lg" style="float:right">Conferma e Salva</button>
                        <a href="/orders/new/step3?show=fast" class="btn btn-info btn-lg" style="float:right">Modifica</a>
                    </div>
                </div>
            </div>

            {!!Form::close()!!}
            <!-- END PAGE BASE CONTENT -->
        </div>

    </div>
</div>

@stop
