<table>
    <tr>
        <th><span>{!!strtoupper(trans('x.Product'))!!}</span></th>
        @foreach (\App\Size::orderBy('name')->get() as $size)
            <th><span>{!!$size->name!!}</span></th>
        @endforeach
        <th><span>{!!trans('x.Price')!!}</span></th>
        <th><span>{!!trans('x.Qty')!!}</span></th>
        <th><span>{!!trans('x.Total')!!}</span></th>
    </tr>
    {{--*/ $i=0 /*--}}
    @foreach (unserialize($order->products_array) as $product_id => $product_variations)
    @foreach ($product_variations as $key => $product_variation_id)
        <tr>
            <td>
                {!!\App\Product::find(\App\Variation::find($product_variation_id)->product_id)->prodmodel->name!!}
                {!!\App\Product::find(\App\Variation::find($product_variation_id)->product_id)->name!!} - 
                {!!\App\Color::find(\App\Variation::find($product_variation_id)->color_id)->name!!}
            </td>
            {{--*/ $totprice = 0 /* --}}
            {{--*/ $qty = 0 /* --}}
            @foreach (\App\Size::orderBy('name')->get() as $size)
            <td>
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
            <td>€ {!!number_format($price, 2, ',','.')!!}</td>
            <td">{!!$qty!!}</td>
            <td>€ {!! number_format(($price*$qty), 2, ',','.')!!}</td>                
        </tr>
    @endforeach
    @endforeach
    <tr>
        <th></th>
        @foreach (\App\Size::orderBy('name')->get() as $size)
            <th></th>
        @endforeach
        <th></span></th>
        <th>{!!$order->items_qty!!}</th>
        <th>€ {!!number_format($order->total, 2, ',','.')!!}</th>
</table>