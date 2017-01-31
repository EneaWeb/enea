{{--
<div class="modal animated fadeIn" id="modal_add_lines_{!!$product->id!!}" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">
--}}
    <div class="modal-dialog animated zoomIn">
    
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="smallModalHead">Inserimento dell'articolo {!!$product->name!!}</h4>
            </div>
            <div class="modal-body">

                <div class="col-md-4">
                    <img src="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/300/{!!$product->picture!!}" style="width:60%">
                </div>  
                
                <div class="col-md-8">
                
                    <h2>{!!$product->prodmodel->name!!} - 
                    {!!$product->name!!}</h2>
                    <h3>
                       € {!!number_format(\App\ItemPrice::where('season_list_id', Session::get('order.season_list_id'))->where('item_id', \App\Item::where('product_id', $product->id)->first()['id'])->first()['price'], 2, ',','.')!!}</h3>
                    <h5>Code: {!!$product->slug!!} / #{!!$product->id!!}</h5>
                    <a href="/catalogue/product/{!!$product->id!!}" target="_blank">
                        Guarda la scheda prodotto in un'altra pagina
                    </a>
                </div>

            </div>
            {!!Form::open(array('url' => '/order/new/save-line', 'method'=>'POST', 'id'=>'lines-form-'.$product->id))!!}
            
            <div class="panel-body tab-content">
                {{-- */ $i2 = 1 /* --}}
                <table class="table-condensed table-bordered" style="margin-left:auto; margin-right:auto; border-collapse: collapse;">
                    <tr>
                        <th></th>
                        <th></th>
                       @foreach (\App\Item::where('product_variation_id', $product->variations()->first()->id)->orderBy('size_id')->pluck('size_id') as $size_id)
                            <th>{!!\App\Size::find($size_id)->name!!}</th>
                        @endforeach
                    </tr>
                    @foreach(\App\Variation::where('product_id', $product->id)
                                                    ->where('active', 1)->get() as $product_variation)
                        <tr>
                            <th style="padding:1px">
                                <img style="max-width:40px" src="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug;!!}/300/{!!$product_variation->picture!!}"/>
                            </th>
                            <th style="border-left:5px solid {!!\App\Color::find($product_variation->color_id)->hex!!}">
                                {!!substr(\App\Color::find($product_variation->color_id)->name, 0, 20)!!}
                            </th>
                            
                            @foreach (\App\Item::where('product_variation_id', $product_variation->id)->orderBy('size_id')->get() as $item)
                                <td style="padding:2px">
                                    <input name="{!!$item->id!!}" data-price="{!!\App\ItemPrice::where('item_id', $item->id)->where('season_list_id', Session::get('order.season_list_id'))->first()['price']!!}" class="form-control tip" type="number" min="0" style="height: 30px !important;padding:0px !important;width: 40px;padding-left:8px !important;" @if(Session::has('order.items')) @if(array_key_exists($item->id, Session::get('order.items'))) value="{!!Session::get('order.items.'.$item->id)!!}" @endif @endif />
                                </td>
                            @endforeach
                            
                        </tr>
                    {{-- */ $i2++ /* --}}
                    @endforeach
                </table>
                <br><br>
                <div style="margin-right:50px; margin-left:50px">
                    <h5 style="text-align:right; padding:10px; background-color: #DDDDDD;">
                        N. pezzi: <span id="tot-qty-{!!$product->id!!}">0</span>{{--N pezzi. --}}
                    </h6> 
                    <h5 style="text-align:right; padding:10px; background-color: #DDDDDD;">
                        Tot: € <span id="tot-price-{!!$product->id!!}">0</span>{{--N pezzi. --}}
                    </h6> 
                </div>
                <br><br><br>
            </div>
            
            <div class="modal-footer">
                {!!Form::submit(trans('x.Save'), ['class' => 'btn btn-danger'])!!}
                <button type="button" class="btn btn-default" data-dismiss="modal">{!!trans('x.Close')!!}</button>
            </div>
            {!!Form::close()!!}
                <script>

                        $('form#lines-form-{!!$product->id!!} :input').change(function() {
                          var tot = 0;
                          var price = 0;
                          $("form#lines-form-{!!$product->id!!} :input").each(function() {
                            if(!isNaN($(this).val())) { 
                            //Your code 
                                tot += +this.value;
                            }
                            if(!isNaN($(this).data('price'))) { 
                                price += Number($(this).attr('data-price')*this.value);
                            }
                          });
                          $('#tot-qty-{!!$product->id!!}').text(tot);
                          $('#tot-price-{!!$product->id!!}').text(price);
                        }).change();

                </script>
        </div>
    </div>
{{--
</div>
--}}