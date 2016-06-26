@extends('layout.dashboard.main')

@section('more_head')

@stop
@section('more_foot')

@stop

@section('content')                
    <div class="page-content-wrap">
        
        <div class="page-title">                    
            <h2>Ordine # {!!$order->id!!} - {!!$order->customer->companyname!!}</h2>
            <span style="float:right">
                <a href="/order/pdf/download/{!!$order->id!!}"><button class="btn btn-warning">DOWNLOAD</button></a>
            </span>
        </div> 

        <div class="row">
            <div class="col-md-12">
                
                <div id="pdfview" style="height:80vh; z-index:899">
                </div>
                <script>
                    PDFObject.embed("/order/pdf/{!!$order->id!!}", "#pdfview");
                </script>
            </div>
            {{--
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-body">
                    
                        <div class="panel-content">
                        
                            <div class="modal-body form-horizontal form-group-separated">
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        Cliente:
                                    </h6>
                                    <h6 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        {!!$order->customer->companyname!!} /
                                        {!!$order->customer->name!!} 
                                        {!!$order->customer->surname!!}
                                    </h6>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        Dati di fatturazione:
                                    </h6>
                                    <h6 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        {!!$order->customer->address!!} - 
                                        {!!$order->customer->postcode!!} 
                                        {!!$order->customer->city!!} 
                                        ({!!$order->customer->province!!}) -
                                        {!!$order->customer->country!!} <br> 
                                        {!!trans('auth.Vat')!!} {!!$order->customer->vat!!}
                                    </h6>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        Dati di spedizione:
                                    </h6>
                                    <h6 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                    {!!$customer_delivery->address!!} - 
                                    {!!$customer_delivery->postcode!!} 
                                    {!!$customer_delivery->city!!} 
                                    ({!!$customer_delivery->province!!}) -
                                    {!!$customer_delivery->country!!}
                                    </h6>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        Listino:
                                    </h6>
                                    <h6 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        {!!\App\SeasonList::find($order->season_list_id)->name!!}
                                    </h6>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        Periodo di consegna:
                                    </h6>
                                    <h6 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        {!!\App\SeasonDelivery::find($order->season_delivery_id)->name!!}
                                    </h6>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        Modalità di pagamento:
                                    </h6>
                                    <h6 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        {!!\App\Payment::find($order->payment_id)->name!!}
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
                                            @foreach (unserialize($order->products_array) as $product_id => $colors)
                                            @foreach ($colors as $key => $color_id)
                                                <tr>
                                                    <th style="border-left:5px solid {!!\App\Color::find($color_id)->hex!!}">
                                                        {!!\App\Product::find($product_id)->prodmodel->name!!}
                                                        {!!\App\Product::find($product_id)->name!!} - 
                                                        {!!\App\Color::find($color_id)->name!!}
                                                    </th>
                                                    @foreach (\App\Item::where('product_id', $product_id)->where('color_id', $color_id)->get() as $item)
                                                    <td style="text-align:center" id="{!!$item->id!!}">
                                                        @if (\App\OrderDetail::where('order_id', $order->id)->where('item_id', $item->id)->first() != NULL)
                                                            {!!\App\OrderDetail::where('order_id', $order->id)->where('item_id', $item->id)->first()->qty!!}
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
                                        {!!$order->qty!!}
                                    </h3>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        Subtotale:
                                        <br>
                                        Variazioni:
                                    </h6>
                                    <h6 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        € {!!number_format($order->subtotal, 2, ',', '.');!!}
                                        <br>
                                        {!!trans('messages.'.ucfirst(\App\Payment::find($order->payment_id)->action))!!}
                                        {!!\App\Payment::find($order->payment_id)->amount !!}%
                                    </h6>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        Note:
                                    </h6>
                                    <h3 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        {!!$order->notes!!}
                                    </h3>
                                </div>                                
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        TOTALE:
                                    </h6>
                                    <h3 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        € {!!number_format($order->total, 2, ',', '.');!!}
                                    </h3>
                                </div>

                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>  
            --}} 
        </div>
    </div>

@stop