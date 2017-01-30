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
    <title>
        {!!trans('x.Order')!!} {!!$brand->name!!} #{!!$order->id!!}
    </title>
</head>
<body style="width:100%">
<div id="container" style="font-family:'Open Sans', sans-serif; width:100%;">

    @include('pdf.order_confirmation_header')
    
    <table style="width:100%">
        <tr style="width:100%">
            <td style="width:50%">
    
                <h4 style="color: 770476; border-bottom:1px solid #770476; margin-right:30px">
                {!!strtoupper(trans('x.Brand info'))!!}:<br><br></h4>
                <div style="height:10px"></div>
                <p>{!!$brand->companyname!!}</p>
                <p>{!!trans('x.Vat')!!} {!!$brand->vat!!}</p>
                <p>{!!$brand->address!!}</p>
                <p>
                    {!!($brand->postcode != '') ? $brand->postcode : ''!!} 
                    {!!$brand->city!!} 
                    {!!($brand->province != '') ? '('.$brand->province.')' : ''!!}
                    - {!!$brand->country!!}
                </p>
                <p>{!!$brand->email!!}</p>
                <p>{!!$brand->telephone!!}</p>
                <p>{!!trans('x.Agent')!!}: {!!strtoupper($order->user->profile->companyname)!!}</p>
            </td>
            <td>
                <h4 style="color:770476; border-bottom:1px solid #770476; margin-right:30px">{!!strtoupper(trans('x.Customer info'))!!}:<br><br></h4>
                <div style="height:10px"></div>
                <p>{!!strtoupper($order->customer->companyname)!!}</p>
                <p>{!!trans('x.Vat')!!} {!!$order->customer->vat!!}</p>
                <p>{!!$order->customer->address!!}</p>
                <p>
                   {!!(($order->customer->postcode != '') && ($order->customer->postcode != '0') ) ? $order->customer->postcode : ''!!} 
                    {!!$order->customer->city!!} 
                    {!!($order->customer->province != '') ? '('.$order->customer->province.')' : ''!!}
                    - {!!$order->customer->country!!}
                </p>
                <p>{!!$order->customer->email!!}</p>
                <p>{!!$order->customer->telephone!!} / {!!$order->customer->mobile!!}</p>    
            </td>
        </tr>
    </table>

    <br>
    <p>
        {!!trans('x.The delivery of goods will be done at the following address:')!!} 

        {!!strtoupper($customer_delivery->address)!!} 
        {!!$customer_delivery->postcode!!} 
        {!!strtoupper($customer_delivery->city)!!} 
        {!! ($customer_delivery->province != '' ? '('.$customer_delivery->province .')' : '')!!}
        - {!!$customer_delivery->country!!}

    </p>
    <p>
        {!!trans('x.Referee')!!}: 
        
        {!!strtoupper($order->customer->name)!!} - {!!strtoupper($order->customer->telephone)!!} - {!!strtoupper($order->customer->email)!!}
    </p>
    <p>
        {!!trans('x.Delivery Date')!!}:
        {!!strtoupper(\App\SeasonDelivery::find($order->season_delivery_id)->name)!!}
    </p>
    <p>
        {!!trans('x.Payment conditions')!!}: 
        {!!strtoupper(\App\Payment::find($order->payment_id)->name)!!}
    </p>
    @if ($order->note != '')
        <p>
            {!!trans('x.Agent Notes')!!}: 
            {!!$order->note!!}
        </p>
    @endif
    
    <br><br>

    <table>
        <tr>
            <td>
                <div style="float:left; display:inline-block; width:100px; padding:16px; background-color:#E1E1E1;">
                    <h3>{!!trans('x.Products')!!}</h3>
                </div>
            </td>
            <td>
                <div style="float:left; display:inline-block; padding:16px; background-color:#591055; color:white">
                    <h3>{!!$order->products_qty!!}</h3>
                </div>
            </td>
            <td>
                <div style="float:left; display:inline-block; width:100px; padding:16px; background-color:#E1E1E1;">
                    <h3>{!!trans('x.Pieces N.')!!}</h3>
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
                    <h3>{!!trans('x.Subtotal')!!}</h3>
                </div>
            </td>
            <td>
                <div style="float:left; display:inline-block; width:100px; padding:16px; background-color:#591055; color:white">
                    <h3>€ {!!number_format($order->subtotal, 2, ',','.')!!}</h3>
                </div>
            </td>
            <td>
                <div style="float:left; display:inline-block; width:100px; padding:16px; background-color:#E1E1E1;">
                    <h3>{!!trans('x.Variation')!!}</h3>
                </div>
            </td>
            <td>
                <div style="float:left; display:inline-block; width:100px; padding:16px; background-color:#591055; color:white">
                    <h3>{!!($order->payment->amount != NULL) ? $order->payment->action.' '.round($order->payment->amount).'%' : '/' !!}</h3>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="float:left; display:inline-block; width:100px; padding:16px; background-color:#E1E1E1;">
                    <h3>{!!trans('x.Total')!!}</h3>
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
    
    @include('pdf.order_confirmation_header')
    
    <h3>{!!strtoupper(trans('x.Detail'))!!}:</h3>
    <br><br>

    <table class="bordered" style="margin-right:auto; border-collapse: collapse; width:100%;">
        <tr>
            <th style="text-align:left"><span>{!!strtoupper(trans('x.Product'))!!}</span></th>
            @foreach (\App\Size::orderBy('name')->get() as $size)
                <th style="text-align:center"><span>{!!$size->name!!}</span></th>
            @endforeach
            <th><span>{!!trans('x.Price')!!}</span></th>
            <th><span>{!!trans('x.Qty')!!}</span></th>
            <th><span>{!!trans('x.Total')!!}</span></th>
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
                @foreach (\App\Size::orderBy('name')->get() as $size)
                <td style="text-align:center">
                    @if (!empty(\App\Item::where('product_variation_id', $product_variation_id)
                                            ->where('size_id', $size->id)->get()))
                        {{--*/ $item_id = \App\Item::where('product_variation_id', $product_variation_id)
                                                    ->where('size_id', $size->id)->value('id'); /*--}}
                                                                
                        @if (\App\OrderDetail::where('order_id', $order->id)->where('item_id', $item_id)->first() != NULL)
                            {!!\App\OrderDetail::where('order_id', $order->id)->where('item_id', $item_id)->first()->qty!!}
                            {{--*/ $price = \App\ItemPrice::where('item_id',$item_id)->where('season_list_id', $order->season_list_id)->first()['price'] /*--}}
                            {{--*/ $totprice += ( \App\ItemPrice::where('item_id',$item_id)->where('season_list_id', $order->season_list_id)->first()['price'] * \App\OrderDetail::where('order_id', $order->id)->where('item_id', $item_id)->first()['qty']) /*--}}
                            {{--*/ $qty += \App\OrderDetail::where('order_id', $order->id)->where('item_id', $item_id)->first()['qty'] /*--}}
                        @endif
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

    @include('pdf.order_confirmation_header')

    <br><br>

    <h3>{!!strtoupper(trans('x.Conditions'))!!}:</h3>

    <br>
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