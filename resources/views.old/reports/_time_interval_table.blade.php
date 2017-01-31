<div class="table-responsive">
    <div class="dataTables_wrapper no-footer">
       <table id="sold-by-date" class="table table-condensed">
            <thead>
                <tr>
                    <th>{!!trans('x.Picture')!!}</th>
                    <th class="export">{!!trans('x.Model')!!} / {!!trans('x.Variation')!!}</th>
                    @foreach (\App\Size::orderBy('name')->get() as $size)
                        <th class="sum export" style="text-align:center">{!!$size->name!!}</th>
                    @endforeach
                    <th class="sum export">{!!trans('x.Qty')!!}</th>
                </tr>
            </thead>
            <tfoot>
                <th></th>
                <th></th>
                    @foreach (\App\Size::orderBy('name')->get() as $size)
                        <th style="text-align:center"></th>
                    @endforeach
                <th></th>
            </tfoot>
            <tbody>
                @foreach($variation_ids as $variation_id)

                    <tr>
                        <td>
                            <a href="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/{!!\App\Variation::find($variation_id)->picture!!}" data-toggle="lightbox">
                                <img src="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/300/{!!\App\Variation::find($variation_id)->picture!!}" style="max-height:50px"/>
                            </a>
                        </td>
                        <td>
                            <strong>{!!\App\Variation::find($variation_id)->product->prodmodel->name!!}<br> {!!\App\Variation::find($variation_id)->product->name!!}<br> <span style="color:{!!(\App\Variation::find($variation_id)->color->hex == '#ffffff') ? '#ffffff; background-color:#D9D9D9; padding:2px' : \App\Variation::find($variation_id)->color->hex !!};">{!!\App\Variation::find($variation_id)->color->name!!}</span> </strong>
                        </td>
                        @foreach (\App\Size::orderBy('name')->get() as $size)
                            <td style="text-align:center">{!!
                                \App\OrderDetail::where('product_variation_id', $variation_id)
                                        ->whereHas('order', function( $q ) use ($date) {
                                                $q->where('created_at', '>=', $date);
                                            })->whereHas('item', function($q) use ($size) {
                                                $q->where('items.size_id', '=', $size->id);
                                            })->sum('qty');
                            !!}</td>
                        @endforeach
                        <td>{!!
                                \App\OrderDetail::where('product_variation_id', $variation_id)
                                        ->whereHas('order', function( $q ) use ($date) {
                                                $q->where('created_at', '>=', $date);
                                            })->sum('qty');
                            !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>                         
</div>
