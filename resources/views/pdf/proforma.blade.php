<html style="width:100%">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
    body {
        padding:50px;
        font-family:'Courier', sans-serif;
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
        {!!trans('messages.Proforma')!!} {!!$brand->name!!}
    </title>
</head>
<body style="width:100%">
<div id="container" style="width:100%;">

    <h3 style="line-height:1.3em">
        <u>{!!strtoupper($brand->name)!!}</u><br><br>
        {!!$brand->companyname!!}<br>
        {!!$brand->address!!}<br>
        {!!$brand->postcode!!} {!!$brand->city!!}<br>
        {!!trans('auth.Vat')!!} {!!$brand->vat!!}
    </h3>
    <br><br>
    <table style="width:100%; border:2px solid black">
        <tr>
            <td style="width:50%; border-right:2px solid black; padding:10px">
                <h4><u>{!!strtoupper(trans('messages.Billing Address'))!!}:</u><br><br></h4>
                <p>
                    {!!$order->customer->companyname!!}<br>
                    {!!$order->customer->address!!}<br>
                    {!!$order->customer->postcode!!} {!!$order->customer->city!!} {!!$order->customer->country!!} <br>
                    <br>
                </p>
            </td>
            <td style="width:50%; padding:10px">
                <h4><u>{!!strtoupper(trans('messages.Delivery Address'))!!}:</u><br><br></h4>
                <p>
                    @if ($order->customer_delivery_id == '0')
                        {!!$order->customer->companyname!!}<br>
                        {!!$order->customer->address!!}<br>
                        {!!$order->customer->postcode!!} {!!$order->customer->city!!} {!!$order->customer->country!!} <br>
                        <br>
                    @else
                        {!!$order->customer->companyname!!}<br>
                        {!!$order->customer_delivery->receiver!!}<br>
                        {!!$order->customer_delivery->address!!}<br>
                        {!!$order->customer_delivery->postcode!!} {!!$order->customer_delivery->city!!} {!!$order->customer_delivery->country!!} <br>
                        <br>
                    @endif
                </p>
            </td>
        </tr>
    </table>
    <br>
    <table style="width:100%">
        <tr>
            <td style="width:50%">
                <h6>{!!strtoupper(trans('messages.Our bank details'))!!}</h6><br>
                <h3 style="line-height:1.2em">
                    {!!$brand->bank_name!!}<br>
                    IBAN: {!!$brand->bank_IBAN!!}<br>
                    SWIFT: {!!$brand->bank_SWIFT!!}<br>
                </h3>
            </td>
            <td style="width:50%">
                <h4>{!!strtoupper(trans('messages.Proforma Invoice'))!!} # {!!$number!!} </h4>
                <br><br>
            </td>
        </tr>
    </table>
    <br><br>
    <table style="width:100%; border-collapse:collapse;">
        <tr>
            <td style="width:50%; border:2px solid black; padding:10px">
                <h3>{!!strtoupper(trans('messages.Country of manifacture'))!!} {!!strtoupper(trans('messages.Italy'))!!}</h3>
            </td>
            <td style="width:50%; border:2px solid black; padding:10px">
                <h3>{!!strtoupper(trans('messages.Your order reference'))!!} #{!!$order->id!!} - {!!\App\Season::find(\App\Option::where('name', 'active_season')->first()->value)->name!!}</h3>
            </td>
        </tr>
        <tr>
            <td style="width:50%; padding:10px">
                <h6>{!!strtoupper(trans('messages.Delivery Date'))!!}: <br>
                    {!!\App\SeasonDelivery::find($order->season_delivery_id)->name!!}
                </h6>
                <br><br>
            </td>
            <td style="width:50%; border:2px solid black; padding:10px">
                <br>
                <h6>{!!strtoupper(trans('messages.Payment Terms'))!!}: <br>
                    {!!\App\Payment::find($order->payment_id)->name!!}
                </h6>
                <br><br>
                <h6>
                    {!!trans('messages.Date')!!}: {!!\Carbon\Carbon::now()->format('d.m.Y')!!}
                </h6>
            </td>
        </tr>
    </table>
    <table style="width:100%; border-collapse:collapse;">
        <tr>
            <th style="border:2px solid black; padding:10px;">
                <h4>{!!strtoupper(trans('messages.Article'))!!}</h4>
            </th>
            <th style="border:2px solid black; padding:10px;">
                <h4>{!!strtoupper(trans('messages.Description'))!!}</h4>
            </th>
            <th style="border:2px solid black; padding:10px;">
                <h4>{!!strtoupper(trans('messages.Quantity'))!!}</h4>
            </th>
            <th style="border:2px solid black; padding:10px;">
                <h4>{!!strtoupper(trans('messages.Price'))!!}</h4>
            </th>
            <th style="border:2px solid black; padding:10px;">
                <h4>{!!strtoupper(trans('messages.Tot'))!!}</h4>
            </th>
        </tr>
        @foreach (unserialize($order->products_array) as $product_id => $product_variations)
        @foreach ($product_variations as $key => $product_variation_id)
            <tr>
                <td style="padding:4px; border-left:2px solid black;">
                    {!!\App\Product::find(\App\ProductVariation::find($product_variation_id)->product_id)->prodmodel->name!!}
                    {!!\App\Product::find(\App\ProductVariation::find($product_variation_id)->product_id)->name!!}
                </td>
                <td style="padding:4px; border-left:2px solid black;">
                    {!!\App\Color::find(\App\ProductVariation::find($product_variation_id)->color_id)->name!!}
                </td>
                {{--*/ $totprice = 0 /* --}}
                {{--*/ $qty = 0 /* --}}
                @foreach (\App\Size::all() as $size)
                    @if (!empty(\App\Item::where('product_variation_id', $product_variation_id)
                                            ->where('size_id', $size->id)->get()))
                        {{--*/ $item_id = \App\Item::where('product_variation_id', $product_variation_id)
                                                    ->where('size_id', $size->id)->value('id'); /*--}}
                                                                
                        @if (\App\OrderDetail::where('order_id', $order->id)->where('item_id', $item_id)->first() != NULL)
                            {{--*/ $price = \App\ItemPrice::where('item_id',$item_id)->where('season_list_id', $order->season_list_id)->first()['price'] /*--}}
                            {{--*/ $totprice += ( \App\ItemPrice::where('item_id',$item_id)->where('season_list_id', $order->season_list_id)->first()['price'] * \App\OrderDetail::where('order_id', $order->id)->where('item_id', $item_id)->first()['qty']) /*--}}
                            {{--*/ $qty += \App\OrderDetail::where('order_id', $order->id)->where('item_id', $item_id)->first()['qty'] /*--}}
                        @endif
                    @endif
                @endforeach
                <td style="text-align:center; padding:4px; border-left:2px solid black;">{!!$qty!!}</td>
                <td style="text-align:center; padding:4px; border-left:2px solid black;">€ {!!number_format($price, 2, ',','.')!!}</td>
                <td style="text-align:right; padding:4px; border-left:2px solid black; border-right:2px solid black">€ {!! number_format(($price*$qty), 2, ',','.')!!}</td>                
            </tr>
        @endforeach
        @endforeach
        <tr>
            <td style="padding:10px; border:2px solid black"></td>
            <td style="padding:12px; border:2px solid black">
                <h4>{!!trans('messages.Total Pieces')!!}</h4>
            </td>
            <td style="text-align:center; padding:10px; border:2px solid black">
                {!!$order->items_qty!!}
            </td>
            <td style="padding:10px; border:2px solid black"></td>
            <td style="padding:10px; border:2px solid black"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="4" style="padding:10px; border:2px solid black">
                <h3 style="text-align:right">{!!trans('messages.Tot')!!} : 
                {!!number_format($order->total, 2, ',','.')!!} € 
                </h3>
            </td>
        </tr>
        <tr>
            <td></td>
            <td colspan="4" style="padding:10px; border:2px solid black">
                <h3 style="text-align:right">{!!$description!!} : 
                {!!number_format(\App\EneaHelper::inverse_percentage($order->total, $percentage), 2, ',','.')!!} € 
                </h3>
            </td>
        </tr>
    </table>

</body>
</html>