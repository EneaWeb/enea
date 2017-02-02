<div class="mt-element-list list-terms list-existent-terms" data-terms="{{ implode('-',$variation->terms()->pluck('id')->toArray()) }}">
    <div class="mt-list-container list-default ext-1 group">
        <a class="list-toggle-container" data-toggle="collapse" href="#var-{!!$variation->id!!}" aria-expanded="false">
            <div class="list-toggle">
                {!!implode(' + ',$variation->terms()->pluck('name')->toArray())!!}
                <span class="pull-right"><i class="fa fa-trash delete-variation" data-variation="{!!$variation->id!!}"></i></span>
            </div>
        </a>
        <div class="panel-collapse collapse variation-container" id="var-{!!$variation->id!!}">
            <ul>
                <li class="mt-list-item">
                    <div class="form-horizontal">

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
                        <div class="form-group">
                            <label class="col-md-3 control-label">{!!trans('x.Description')!!}</label>
                            <div class="col-md-9">
                                <textarea name="variations[{!!$variation->id!!}][description]" rows="3" class="form-control">
                                    {!!$variation->description!!}
                                </textarea>
                            </div>
                        </div>
                        @foreach (\App\PriceList::where('active', '1')->get() as $list)
                            <div class="form-group">
                                <label class="col-md-3 control-label">{!!$list->name!!} (EUR)</label>
                                <div class="col-md-9">
                                    <input type="number" step="0.01" name="variations[{!!$variation->id!!}][prices][{!!$list->id!!}]" class="form-control price" value="{!!number_format( $variation->items->first()->prices->where('price_list_id', $list->id)->first()->price, 2) !!}" placeholder="0.00"/>
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group">
                            <label class="col-md-3 control-label">
                                {!!trans('x.Sizes')!!}<br>
                                ({!!trans('x.Multiple selection')!!})
                            </label>
                            <div class="col-md-9">
                                <select class="form-control sizes" name="variations[{!!$variation->id!!}][sizes][]" style="height:200px" multiple>
                                    @foreach(\App\Size::all() as $size)
                                        @if (!\App\Item::where('variation_id', $variation->id)->where('size_id', $size->id)->get()->isEmpty() )
                                            <option value="{!!$size->id!!}" selected="selected">{!!$size->name!!}</option>
                                        @else
                                            <option value="{!!$size->id!!}">{!!$size->name!!}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-9">
                                <br>
                                <span class="apply-to-all" data-container="var-{!!$variation->id!!}" style="cursor:pointer">{!!trans('x.Apply to all')!!}</span>
                                <hr>
                            </div>
                            <label class="col-md-3 control-label">{!!trans('x.Pictures')!!}</label>
                            <div class="deletable-pictures" class="col-md-9" id="deletable-pictures-{!!$variation->id!!}">
                                @foreach (unserialize($variation->pictures) as $picture)
                                    <div class="deletable-picture">
                                        <img src="{{\App\X::s3_products_thumb($picture)}}" style="width:100%; height:auto;">
                                        <input type="hidden" name="variations[{!!$variation->id!!}][pictures][]" value="{{$picture}}"/>
                                        <span class="boxclose" id="boxclose"><icon class="fa fa-close"></fa></span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-12" style="margin-botton: 40px;">
                                <div class="dropzone dropzone-file-area" id="dropzone-{!!$variation->id!!}" style="margin: 16px;">
                                    <h4 class="sbold">{{trans('x.Drop files here or click to upload pictures')}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>


<script>

    $(document).ready(function(){

        // make dropzone elements sortable
        $("#deletable-pictures-{!!$variation->id!!}").sortable({
            items: '.deletable-picture',
            cursor: 'move',
            opacity: 0.5,
            containment: "#deletable-pictures-{!!$variation->id!!}",
            tolerance: 'pointer'
        });
        
        // initiate dropzone
        Dropzone.autoDiscover = false;
        $("#dropzone-{!!$variation->id!!}").dropzone({
            dictDefaultMessage: "",
            init: function() {
                this.on("addedfile", function(e) {
                    $('.dz-success-mark, .dz-error-message, .dz-error-mark, .dz-remove').remove();
                    var n = Dropzone.createElement("<a href='javascript:;'' class='btn red btn-sm'>{{trans('x.Delete')}}</a>"),
                        t = this;
                    n.addEventListener("click", function(n) {
                        n.preventDefault(), 
                        n.stopPropagation(), 
                        t.removeFile(e)
                    }), e.previewElement.appendChild(n)
                })
            },
            url: "/catalogue/upload-picture",
            addRemoveLinks: true,
            success: function (file, response) {
                file.previewElement.classList.add("dz-success");
                var imgName = response;
                console.log("Uploaded Variation image : " + imgName);
                // create input to populate array of images
                $('<input>').attr({
                    type : 'hidden',
                    name : 'variations[{!!$variation->id!!}][pictures][]',
                    value : imgName
                }).appendTo(file.previewElement);
            },
            error: function (file, response) {
                file.previewElement.classList.add("dz-error");
            }
        });

        // make dropzone elements sortable
        $("#dropzone-{!!$variation->id!!}").sortable({
            items: '.dz-preview',
            cursor: 'move',
            opacity: 0.5,
            containment: '#dropzone-{!!$variation->id!!}',
            distance: 20,
            tolerance: 'pointer'
        });

    });
    
</script>