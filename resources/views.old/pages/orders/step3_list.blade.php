<div class="table-responsive">
    <div class="dataTables_wrapper no-footer">
        <table id="step3" class="table table-responsive table-condensed">
            <thead>
                <tr>
                    <th>{!!trans('x.Picture')!!}</th>
                    <th>{!!trans('x.Product')!!}</th>
                    <th>{!!trans('x.N. Items')!!}
                </tr>
            </thead>
            <tbody>
                @if ($products != NULL)
                    @foreach ($products as $product)
                    {{-- CUSTOMIZER --}}
                        <tr>
                            <td style="text-align:right">
                                @if (($brand_slug == 'cinziaaraia') && $product->slug == '_custom')
                                {{-- CUSTOMIZER --}}
                                 <a class="gallery-item" href="/customizer/{!!$brand_slug!!}" class="tile tile-primary">
                                @else
                                <a class="gallery-item" href="#" data-toggle="modal" data-target="#modal_add_lines" data-product_id="{!!$product->id!!}" class="tile tile-primary">
                                @endif
                                
                                <div>
                                    <img style="height:80px;" src="/assets/images/products/{!!$brand_slug!!}/300/{!!$product->picture!!}" alt="{!!$product->name!!}">
                                </div>
                                </a>
                            </td>
                            <td>
                                @if (($brand_slug == 'cinziaaraia') && $product->slug == '_custom')
                                {{-- CUSTOMIZER --}}
                                 <a class="gallery-item" href="/customizer/{!!$brand_slug!!}" class="tile tile-primary">
                                @else
                                <a class="gallery-item" href="#" data-toggle="modal" data-target="#modal_add_lines" data-product_id="{!!$product->id!!}" class="tile tile-primary">
                                @endif
                                
                                <div style="height:80px; padding-top:30px; color: #2D2D2D">
                                    <h3>{!!$product->prodmodel->name!!} - {!!$product->name!!}</h3>
                                </div>
                                </a>
                            </td>
                            <td>
                                {{--*/ $count = 0; /*--}}
                                
                                @if (Session::has('order.items'))
                                    @foreach (Session::get('order.items') as $order_item => $quantity)
                                        @if(\App\Item::find($order_item)->product->id == $product->id)
                                            {{--*/ $count += $quantity; /*--}}
                                        @endif
                                    @endforeach
                                @endif
                                
                                {!!(($count != 0) ? $count : '')!!}
                            </td>
                        </tr>
                        </a>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        var currentLocale = $('#getcurrentlocale').text();
        var lastColumn = $('#orders').find('th:last').index();
        $('#step3').DataTable( {
            "language": { "url": "/assets/js/plugins/datatables/"+currentLocale+".json" }
        });
    });
</script>