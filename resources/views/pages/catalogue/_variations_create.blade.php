@foreach ($variations as $k => $variation)

    <div class="mt-element-list list-terms" data-terms="{{ implode('-',$variation) }}">
        <div class="mt-list-container list-default ext-1 group">
            <a class="list-toggle-container" data-toggle="collapse" href="#var-gen-{!!$k!!}" aria-expanded="false">
                <div class="list-toggle">
                    <?php $arr = []; ?>
                    @foreach ($variation as $termId) 
                        <?php $arr[] = \App\Term::find($termId)->name; ?>
                    @endforeach
                    {!!implode(' + ',$arr)!!}
                    <span class="pull-right delete-variation-otf"><i class="fa fa-trash"></i></span>
                </div>
            </a>
            <div class="panel-collapse collapse variation-container" id="var-gen-{!!$k!!}">
                <ul>
                    <li class="mt-list-item">
                        <div class="form-horizontal">

                            @foreach ($variation as $x => $term_id)
                                <input type="hidden" name="variations[{!!$k!!}][terms_id][]" class="variationid" value="{!!$term_id!!}" />
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
                                        <input type="number" step="0.01" name="variations[{!!$k!!}][prices][{!!$list->id!!}]" class="form-control price" placeholder="0.00"/>
                                    </div>
                                </div>
                            @endforeach
                            <div class="form-group">
                                <label class="col-md-3 control-label">
                                    {!!trans('x.Sizes')!!}<br>
                                    ({!!trans('x.Multiple selection')!!})
                                </label>
                                <div class="col-md-9">
                                    <select class="form-control sizes" name="variations[{!!$k!!}][sizes][]" multiple>
                                        @foreach(\App\Size::all() as $size)
                                            <option value="{!!$size->id!!}">{!!$size->name!!}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-9">
                                    <br>
                                    <span class="apply-to-all" data-container="var-gen-{!!$k!!}" style="cursor:pointer">{!!trans('x.Apply to all')!!}</span>
                                </div>
                                <div class="col-md-12" style="margin-botton: 40px;">
                                    <div class="dropzone dropzone-file-area" id="dropzone-{!!$k!!}" style="margin: 16px;">
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
        
        // initiate dropzone
        Dropzone.autoDiscover = false;
        $("#dropzone-{!!$k!!}").dropzone({
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
                    name : 'variations[{!!$k!!}][pictures][]',
                    value : imgName
                }).appendTo(file.previewElement);
            },
            error: function (file, response) {
                file.previewElement.classList.add("dz-error");
            }
        });

        // make dropzone elements sortable
        $("#dropzone-{!!$k!!}").sortable({
            items: '.dz-preview',
            cursor: 'move',
            opacity: 0.5,
            containment: '#dropzone-{!!$k!!}',
            distance: 20,
            tolerance: 'pointer'
        });

    });
    
</script>

@endforeach