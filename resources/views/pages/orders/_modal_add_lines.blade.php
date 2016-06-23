<div class="modal animated fadeIn" id="modal_add_lines_{!!$product->id!!}" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">

    <div class="modal-dialog animated zoomIn">
    
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="smallModalHead">Inserimento dell'articolo {!!$product->name!!}</h4>
            </div>
            <div class="modal-body">

                <div class="col-md-4">
                    <img src="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/{!!$product->picture!!}" style="width:60%">
                </div>  
                
                <div class="col-md-8">
                
                    <h2>{!!$product->model->name!!} - 
                    {!!$product->name!!}</h2>
                    <h3>
                       € {!!number_format(\App\ItemPrice::where('season_list_id', \App\Option::where('name', 'active_season')->first()->value)->where('item_id', \App\Item::where('product_id', $product->id)->first()['id'])->first()['price'], 2, ',','.')!!}</h3>
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
                            @foreach (\App\Size::all() as $size)
                            <th>{!!$size->name!!}</th>
                            @endforeach
                    </tr>
                    @foreach(\App\Product::product_colors($product->id) as $color_id)
                        <tr>
                            <th style="border-left:5px solid {!!\App\Color::find($color_id)->hex!!}">
                                {!!\App\Color::find($color_id)->name!!}
                            </th>
                            @foreach (\App\Item::where('product_id', $product->id)->where('color_id', $color_id)->get() as $item)
                            <td style="padding:2px">
                                <input name="{!!$item->id!!}" class="form-control tip" type="number" min="0" style="height: 26px !important;padding:0px !important;width: 40px;padding-left:8px !important;" @if(Session::has('order.items')) @if(array_key_exists($item->id, Session::get('order.items'))) value="{!!Session::get('order.items.'.$item->id)!!}" @endif @endif />
                            </td>
                            @endforeach
                        </tr>
                    {{-- */ $i2++ /* --}}
                    @endforeach
                </table>
                
                <div style="margin-right:40px">
                    <h5 style="text-align:right">N. pezzi: <span id="tot-qty-{!!$product->id!!}">0</span>{{--N pezzi. --}}</h6> 
                    <h6 style="text-align:right">Tot: € <span id="tot-val-{!!$product->id!!}">0</span></h6>
                </div>
                <br><br><br>
            </div>
            
            <div class="modal-footer">
                {!!Form::submit(trans('auth.Save'), ['class' => 'btn btn-danger'])!!}
                <button type="button" class="btn btn-default" data-dismiss="modal">{!!trans('menu.Close')!!}</button>
            </div>
            {!!Form::close()!!}
                <script>
                    $(document).ready(function(){
                        $('form#lines-form-{!!$product->id!!} :input').change(function() {
                          var tot = 0;
                          $("form#lines-form-{!!$product->id!!} :input").each(function() {
                            if(!isNaN($(this).val())) { 
                            //Your code 
                                tot += +this.value;
                            }
                          });
                          console.log(Number(tot));
                          $('#tot-qty-{!!$product->id!!}').text(tot);
                        });
                    });
                </script>
        </div>
    </div>
</div>