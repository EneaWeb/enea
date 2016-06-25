<html style="width:100%">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
    body {
        padding:50px;
    }
    * { box-sizing:border-box; margin:0; font-weight:normal;}
    html, p {font-size:11px; line-height:16px;}
    
    div.page-break { page-break-inside:avoid; page-break-after:always; }
    
    h6 {
        font-size:13px;
    }
    h3 {
        font-size:17px;
    }
    h4 {
        font-size:15px;
    }
    table.bordered td {
        border:1px solid #FFDEFD;
        padding:10px 4px;
        max-width:30px;
    }
    table.bordered th {
       padding:16px 10px;
    }
    table.bordered th span {
        border-bottom:1px solid #770476;
    }
    .clearfix {
      overflow: auto;
      zoom: 1;
    }
    </style>
</head>
<body style="width:100%">
<div id="container" style="font-family:'Open Sans', sans-serif; width:100%;">

    @include('pdf.header')
    
    <table style="width:100%">
        <tr style="width:100%">
            <td style="width:50%">
    
                <h4 style="color: 770476; border-bottom:1px solid #770476; margin-right:30px">
                {!!strtoupper(trans('messages.Brand info'))!!}:<br><br></h4>
                <div style="height:10px"></div>
                <p>{!!trans('messages.Agent')!!}: {!!strtoupper($order->user->profile->companyname)!!}</p>
                <p>{!!trans('auth.Vat')!!} {!!$brand->vat!!}</p>
                <p>{!!$brand->address!!}</p>
                <p>
                    {!!$brand->postcode!!} 
                    {!!$brand->city!!} 
                    ({!!$brand->province!!})
                    - {!!$brand->country!!}
                </p>
                <p>{!!$brand->email!!}</p>
                <p>{!!$brand->telephone!!}</p>
            </td>
            <td>
                <h4 style="color:770476; border-bottom:1px solid #770476; margin-right:30px">{!!strtoupper(trans('messages.Customer info'))!!}:<br><br></h4>
                <div style="height:10px"></div>
                <p>{!!strtoupper($order->customer->companyname)!!}</p>
                <p>{!!trans('auth.Vat')!!} {!!$order->customer->vat!!}</p>
                <p>{!!$order->customer->address!!}</p>
                <p>
                    {!!$order->customer->postcode!!} 
                    {!!$order->customer->city!!} 
                    ({!!$order->customer->province!!})
                    - {!!$order->customer->country!!}
                </p>
                <p>{!!$order->customer->email!!}</p>
                <p>{!!$order->customer->telephone!!} / {!!$order->customer->mobile!!}</p>    
            </td>
        </tr>
    </table>

    <br><br><br>
    <p>
    {!!trans('messages.The delivery of goods will be done at the following address:')!!} 
            <u>{!!$customer_delivery->postcode!!} 
        {!!$customer_delivery->city!!} 
        ({!!$customer_delivery->province!!})
        - {!!$customer_delivery->country!!}</p>
    </p>
    <p>
    {!!trans('messages.Payment conditions')!!}: 
        <u>{!!\App\Payment::find($order->payment_id)->name!!}</u>
    </p><br><br>

    <table>
        <tr>
            <td>
                <div style="float:left; display:inline-block; width:100px; padding:16px; background-color:#E1E1E1;">
                    <h3>{!!trans('messages.Products')!!}</h3>
                </div>
            </td>
            <td>
                <div style="float:left; display:inline-block; padding:16px; background-color:#591055; color:white">
                    <h3>{!!$order->products_qty!!}</h3>
                </div>
            </td>
            <td>
                <div style="float:left; display:inline-block; width:100px; padding:16px; background-color:#E1E1E1;">
                    <h3>{!!trans('messages.Pieces N.')!!}</h3>
                </div>
            </td>
            <td>
                <div style="float:left; display:inline-block; padding:16px; background-color:#591055; color:white">
                    <h3>{!!$order->items_qty!!}</h3>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="float:left; display:inline-block; width:100px; padding:16px; background-color:#E1E1E1;">
                    <h3>{!!trans('messages.Subtotal')!!}</h3>
                </div>
            </td>
            <td>
                <div style="float:left; display:inline-block; width:100px; padding:16px; background-color:#591055; color:white">
                    <h3>€ {!!number_format($order->subtotal, 2, ',','.')!!}</h3>
                </div>
            </td>
            <td>
                <div style="float:left; display:inline-block; width:100px; padding:16px; background-color:#E1E1E1;">
                    <h3>{!!trans('messages.Variation')!!}</h3>
                </div>
            </td>
            <td>
                <div style="float:left; display:inline-block; width:100px; padding:16px; background-color:#591055; color:white">
                    <h3>{!!($order->payment->amount != NULL) ? '-'.$order->payment->amount.'%' : '/' !!}</h3>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="float:left; display:inline-block; width:100px; padding:16px; background-color:#E1E1E1;">
                    <h3>{!!trans('messages.Total')!!}</h3>
                </div>
            </td>
            <td>
                <div style="float:left; display:inline-block; padding:16px; background-color:#803F7C; color:white">
                    <h3>€ {!!number_format($order->total, 2, ',','.')!!}</h3>
                </div>
            </td>
        </tr>
    </table>

    <div class="page-break"></div>
    
    @include('pdf.header')
    
    <h3>{!!strtoupper(trans('messages.Detail'))!!}:</h3>
    <br><br>

    <table class="bordered" style="margin-right:auto; border-collapse: collapse; width:100%;">
        <tr>
            <th style="text-align:left"><span>{!!strtoupper(trans('messages.Product'))!!}</span></th>
            @foreach (\App\Size::all() as $size)
                <th style="text-align:center"><span>{!!$size->name!!}</span></th>
            @endforeach
            <th><span>{!!trans('messages.Price')!!}</span></th>
            <th><span>{!!trans('messages.Qty')!!}</span></th>
            <th><span>{!!trans('messages.Total')!!}</span></th>
        </tr>
        {{--*/ $i=0 /*--}}
        @foreach (unserialize($order->products_array) as $product_id => $product_variations)
        @foreach ($product_variations as $key => $product_variation_id)
            <tr>
                <td style="border-left:5px solid {!!\App\Color::find(\App\ProductVariation::find($product_variation_id)->color_id)->hex!!}; width:200px">
                    {!!\App\Product::find(\App\ProductVariation::find($product_variation_id)->product_id)->prodmodel->name!!}
                    {!!\App\Product::find(\App\ProductVariation::find($product_variation_id)->product_id)->name!!} - 
                    {!!\App\Color::find(\App\ProductVariation::find($product_variation_id)->color_id)->name!!}
                </td>
                {{--*/ $totprice = 0 /* --}}
                {{--*/ $qty = 0 /* --}}
                @foreach (\App\Item::where('product_variation_id', $product_variation_id)->get() as $item)
                <td style="text-align:center" id="{!!$item->id!!}">
                    @if (\App\OrderDetail::where('order_id', $order->id)->where('item_id', $item->id)->first() != NULL)
                        {!!\App\OrderDetail::where('order_id', $order->id)->where('item_id', $item->id)->first()->qty!!}
                        {{--*/ $price = \App\ItemPrice::where('item_id',$item->id)->first()->price /*--}}
                        {{--*/ $totprice += ( \App\ItemPrice::where('item_id',$item->id)->first()->price * \App\OrderDetail::where('order_id', $order->id)->where('item_id', $item->id)->first()->qty ) /*--}}
                        {{--*/ $qty += \App\OrderDetail::where('order_id', $order->id)->where('item_id', $item->id)->first()->qty /*--}}
                    @endif
                </td>
                @endforeach
                <td style="text-align:center">€ {!!number_format($price, 2, ',','.')!!}</td>
                <td style="text-align:center">{!!$qty!!}</td>
                <td style="text-align:center">€ {!! number_format(($price*$qty), 2, ',','.')!!}</td>                
            </tr>
        @endforeach
        @endforeach
    </table>
    
    <div class="page-break"></div>

    @include('pdf.header')

    <h3>{!!strtoupper(trans('messages.Conditions'))!!}:</h3>

    <br><br>
    <p>
        Quest'ordine è regolato dalle condizioni di vendita da voi sottoscritte che qui si intendono integralmente riportate.
        <br>Vale come conferma d'ordine salvo eventuali annullamenti che saranno comunicati tempestivamente.
        <br>Tutte le vendite online dovranno essere preventivamente approvate dall'azienda.
        <br><br>IL CLIENTE _____________________
    </p>
    <br><br>
    <p>
        Agli effetti degli art. 1341 e 1342 del C.C. si approva specificatamente l'art. 1 (condizioni generali di vendita)
        <br><br>IL CLIENTE _____________________
    </p>
</div>
</body>
</html>