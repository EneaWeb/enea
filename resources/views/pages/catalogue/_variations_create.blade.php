@foreach ($variations as $k => $variation)

    <div class="mt-element-list">
        <div class="mt-list-container list-default ext-1 group">
            <a class="list-toggle-container" data-toggle="collapse" href="#var-{!!$k!!}" aria-expanded="false">
                <div class="list-toggle"> {!!trans('x.Variation')!!} : 
                    @foreach ($variation as $v) 
                        +{!!\App\Term::find($v)->name!!}
                    @endforeach
                </div>
            </a>
            <div class="panel-collapse collapse" id="var-{!!$k!!}">
                <ul>
                    <li class="mt-list-item">
                        <div class="list-item-content form-horizontal">

                            @foreach ($variation as $x => $term_id)
                                <input type="hidden" name="variations[{!!$k!!}][terms_id][]" value="{!!$term_id!!}" />
                            @endforeach
                            
                            <div class="form-group">
                                <label class="col-md-3 control-label">SKU</label>
                                <div class="col-md-9">
                                    <input type="text" name="variations[{!!$k!!}][sku]" class="form-control" placeholder="SKU Code"/>
                                </div>
                            </div>
                            @foreach (\App\PriceList::where('active', '1')->get() as $list)
                                <div class="form-group">
                                    <label class="col-md-3 control-label">{!!$list->name!!} (EUR)</label>
                                    <div class="col-md-9">
                                        <input type="number" step="0.01" name="variations[{!!$k!!}][prices][{!!$list->id!!}]" class="form-control" placeholder="0.00"/>
                                    </div>
                                </div>
                            @endforeach
                            <div class="form-group">
                                <label class="col-md-3 control-label">
                                    {!!trans('x.Sizes')!!}<br>
                                    ({!!trans('x.Multiple selection')!!})
                                </label>
                                <div class="col-md-9">
                                    <select class="form-control" name="variations[{!!$k!!}][sizes][]" multiple>
                                        @foreach(\App\Size::all() as $size)
                                            <option value="{!!$size->id!!}">{!!$size->name!!}</option>
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

@endforeach