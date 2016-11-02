<div class="table-responsive">
    <div class="dataTables_wrapper no-footer">
       <table id="sold-by-delivery" class="table table-condensed">
            <thead>
                <tr>
                    <th>{!!trans('auth.Picture')!!}</th>
                    <th class="export">{!!trans('auth.Model')!!} / {!!trans('auth.Variation')!!}</th>
                    @foreach (\App\Size::orderBy('name')->get() as $size)
                        <th class="sum export" style="text-align:center">{!!$size->name!!}</th>
                    @endforeach
                    <th class="sum export">{!!trans('auth.Qty')!!}</th>
                    <th class="sum export">{!!trans('auth.Undiscounted')!!}</th>
                </tr>
            </thead>
            <tfoot>
                <th></th>
                <th></th>
                    @foreach (\App\Size::orderBy('name')->get() as $size)
                        <th style="text-align:center"></th>
                    @endforeach
                <th></th>
                <th style="text-align:right"></th>
            </tfoot>
            <tbody>
                @foreach($variation_ids as $variation_id)

                    <tr>
                        <td>
                            <a href="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/{!!\App\ProductVariation::find($variation_id)->picture!!}" data-toggle="lightbox">
                                <img src="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/300/{!!\App\ProductVariation::find($variation_id)->picture!!}" style="max-height:50px"/>
                            </a>
                        </td>
                        <td>
                            <strong>{!!\App\ProductVariation::find($variation_id)->product->prodmodel->name!!}<br> {!!\App\ProductVariation::find($variation_id)->product->name!!}<br> <span style="color:{!!(\App\ProductVariation::find($variation_id)->color->hex == '#ffffff') ? '#ffffff; background-color:#D9D9D9; padding:2px' : \App\ProductVariation::find($variation_id)->color->hex !!};">{!!\App\ProductVariation::find($variation_id)->color->name!!}</span> </strong>
                        </td>
                        @foreach (\App\Size::orderBy('name')->get() as $size)
                            <td style="text-align:center">{!!
                                \App\OrderDetail::where('product_variation_id', $variation_id)
                                        ->whereHas('order', function( $q ) use ($season_delivery_id) {
                                                $q->where('season_delivery_id', $season_delivery_id);
                                            })->whereHas('item', function($q) use ($size) {
                                                $q->where('items.size_id', '=', $size->id);
                                            })->sum('qty');
                            !!}</td>
                        @endforeach
                        <td>{!!
                                \App\OrderDetail::where('product_variation_id', $variation_id)
                                        ->whereHas('order', function( $q ) use ($season_delivery_id) {
                                                $q->where('season_delivery_id', $season_delivery_id);
                                            })->sum('qty');
                            !!}</td>
                        <td style="text-align:right">
                            € {!!number_format( \App\OrderDetail::where('product_variation_id', $variation_id)
                                    ->whereHas('order', function($q) use ($season_delivery_id) {
                                        $q->where('season_delivery_id', $season_delivery_id);
                                    })->sum('total_price'), false, ',', '.')!!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>                         
</div>
