<div class="mt-element-list">
    <div class="mt-list-container list-default ext-1 group">
        <a class="list-toggle-container" data-toggle="collapse" href="#var-{!!$variation->id!!}" aria-expanded="false">
            <div class="list-toggle"> {!!trans('x.Variation')!!} : 
                @foreach ($variation->terms as $term)
                    +{!!$term->name!!}
                @endforeach
            </div>
        </a>
        <div class="panel-collapse collapse" id="var-{!!$variation->id!!}">
            <ul>
                <li class="mt-list-item">
                    <div class="list-item-content form-horizontal">

                        <input type="hidden" name="variations[{!!$variation->id!!}][edit]" value="true" />

                        @foreach ($variation->terms as $term)
                            <input type="hidden" name="variations[{!!$variation->id!!}][terms_id][]" value="{!!$term->id!!}" />
                        @endforeach
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">SKU</label>
                            <div class="col-md-9">
                                <input type="text" name="variations[{!!$variation->id!!}][sku]" class="form-control" value="{!!$variation->sku!!}" placeholder="SKU Code"/>
                            </div>
                        </div>
                        @foreach (\App\PriceList::where('active', '1')->get() as $list)
                            <div class="form-group">
                                <label class="col-md-3 control-label">{!!$list->name!!} (EUR)</label>
                                <div class="col-md-9">
                                    <input type="number" step="0.01" name="variations[{!!$variation->id!!}][prices][{!!$list->id!!}]" class="form-control" value="{!!number_format( $variation->items->first()->prices->where('price_list_id', $list->id)->first()->price, 2) !!}" placeholder="0.00"/>
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group">
                            <label class="col-md-3 control-label">
                                {!!trans('x.Sizes')!!}<br>
                                ({!!trans('x.Multiple selection')!!})
                            </label>
                            <div class="col-md-9">
                                <select class="form-control" name="variations[{!!$variation->id!!}][sizes][]" multiple>
                                    @foreach(\App\Size::all() as $size)
                                        @if (!\App\Item::where('variation_id', $variation->id)->where('size_id', $size->id)->get()->isEmpty() )
                                            <option value="{!!$size->id!!}" selected="selected">{!!$size->name!!}</option>
                                        @else
                                            <option value="{!!$size->id!!}">{!!$size->name!!}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>