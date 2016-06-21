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
                    <h5>Code: {!!$product->slug!!} / #{!!$product->id!!}</h5>
                    <h5></h5>
                
                </div>

            </div>
            {!!Form::open(array('url' => '/order/new/save-line', 'method'=>'POST', 'id'=>'customer-form'))!!}
            
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
                </table><br><br><br>
                
                <div>
                    <h5>{{--N pezzi. --}}</h6> 
                    <h6>{{-- Costo: --}}</h6>
                </div>
            </div>
            
            <div class="modal-footer">
                {!!Form::submit(trans('auth.Save'), ['class' => 'btn btn-danger'])!!}
                <button type="button" class="btn btn-default" data-dismiss="modal">{!!trans('menu.Close')!!}</button>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>