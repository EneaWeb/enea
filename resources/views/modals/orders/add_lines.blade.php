<div class="modal-dialog modal-lg">

    <style>
        ::-webkit-input-placeholder { /* WebKit, Blink, Edge */
            color:    #ededed!important;
        }
        :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
        color:    #ededed!important;
        opacity:  1;
        }
        ::-moz-placeholder { /* Mozilla Firefox 19+ */
        color:    #ededed!important;
        opacity:  1;
        }
        :-ms-input-placeholder { /* Internet Explorer 10-11 */
        color:    #ededed!important;
        }
    </style>

    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="smallModalHead">{{trans('x.Insert product')}} {!!$product->name!!}</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-5">
                    <img src="{{X::s3_products_thumb( $product->featuredPicture())}}" style="width:100%; max-width:200px; height:auto; float:right">
                </div> 
                
                <div class="col-md-7">
                
                    <h2> {{-- product name --}}
                        {!!$product->prodmodel->name!!} - {!!$product->name!!}
                    </h2>
                    <h3> {{-- product prices --}}
                        € {!!$product->renderPrices()!!}
                    </h3>
                    <h5> {{-- codes --}}
                        SKU: {!!$product->sku!!}<br>
                        SID: {!!$product->id!!}
                    </h5>
                </div>
            </div>

            <hr>

            <div class="row">

                {!!Form::open(array('url' => '/orders/new/save-line', 'method'=>'POST', 'id'=>'lines-form'))!!}
                    
                    <div class="panel-body tab-content">

                        <table class="table-condensed table-bordered" style="margin-left:auto; margin-right:auto; border-collapse: collapse;">
                            <tr class="no-count">
                                @foreach ($product->getSizesNameArray() as $sizeName)
                                    <th style="text-align:center">{{$sizeName}}</th>
                                @endforeach
                            </tr>

                            @foreach($product->variations as $variation)
                                <tr class="no-count"><td colspan="42"></td></tr>
                                <tr>
                                    <td colspan="42">
                                        <img src="{{X::s3_products_thumb( $variation->featuredPicture())}}" style="width:60px; height:auto; float:left; margin-right:10px">
                                        <p style="margin:0px;">
                                            {{$variation->sku != '' ? $variation->sku : '' }} <br>
                                            <b>{{$variation->renderTerms()}}</b>
                                            ( € {{$variation->renderPrices()}} )
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    @foreach ($product->getSizesIdArray() as $sizeId)
                                        {{-- get Item with this VARIATION and SIZE (can be only one) --}}
                                        <?php $item = \App\Item::where('variation_id', $variation->id)->where('size_id', $sizeId)->first(); ?>
                                        {{-- check if there is an item for this size (can be null) --}}
                                        @if ($item !== NULL)
                                            <td class="td-add-line">
                                                <input name="{!!$item->id!!}" 
                                                       data-price="{!!$item->priceForOrderList()!!}" 
                                                       class="form-control tip" 
                                                       type="number" 
                                                       min="0"
                                                       placeholder="{!!\App\Size::find($sizeId)->name!!}"
                                                       @if (X::cartHasItem($item->id))
                                                       value="{{X::cartGetItem($item->id)->qty}}"
                                                       @endif
                                                       />
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach

                            <tr class="no-count"><td colspan="42"></td></tr>
                            <tr class="no-count"><td colspan="42" style="background-color:#eee; text-align:center">{{trans('x.Total')}}</td></tr>
                            <tr class="no-count"><td colspan="42"></td></tr>

                            {{-- totals --}}
                            <tr class="no-count">
                                @foreach ($product->getSizesIdArray() as $sizeId)
                                    <td class="td-add-line td-total-count" style="background-color:#eee">
                                        <input class="form-control tip" type="number" disabled="disabled" />
                                    </td>
                                @endforeach
                            </tr>

                            <tr class="no-count"><td colspan="42" style="background-color:#eee; text-align:center">
                                {{trans('x.N. Pieces')}}: <b><span id="tot-qty"></span></b>
                            </td></tr>

                            <tr class="no-count"><td colspan="42" style="background-color:#eee; text-align:center">
                                {{trans('x.Total Price')}}: <b><span id="tot-price"></span> €</b>
                            </td></tr>

                        </table>

                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" id="button-save-line" class="btn btn-danger" data-dismiss="modal">{!!trans('x.Save')!!}</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{!!trans('x.Close')!!}</button>
                    </div>

                {!!Form::close()!!}

            </div>

        </div>

        <script>

            function updateTotals() {
                var tot = 0;
                var price = 0;
                $("form#lines-form tr:not('.no-count') :input").each(function() {
                if(!isNaN($(this).val())) { 
                //Your code 
                    tot += +this.value;
                }
                if(!isNaN($(this).data('price'))) { 
                    price += Number($(this).attr('data-price')*this.value);
                }
                });
                $('#tot-qty').text(tot);
                $('#tot-price').text(price);

                var colTotals=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
                                0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
                var $dataRows=$("tr:not('.no-count')");
                    
                $dataRows.each(function(i) {
                    $(this).find("td > input").each(function(j){  
                        colTotals[j]+= Number($(this).val());
                    });
                });

                $("td.td-total-count > input").each(function(i){  
                    if (colTotals[i] !== 0)
                        $(this).val(colTotals[i]);
                    else
                        $(this).val('');
                });

            }

            $('form#lines-form :input').change(function() {
                updateTotals();
            }).change();

            $('#button-save-line').on('click', function(e){
                e.preventDefault();
                $("#lines-form").ajaxSubmit({
                    url : '/orders/new/save-line', 
                    type : 'POST',
                    target : '#order-infos',
                    success: toastr.success("{{trans('x.Order updated')}}"),
                });
            });

        </script>

    </div>
</div>