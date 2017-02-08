    <div class="mt-element-list list-terms" data-terms="">
        <div class="mt-list-container list-default ext-1 group">
            <a class="list-toggle-container" data-toggle="collapse" href="#var-gen-{!!$k!!}" aria-expanded="false">
                <div class="list-toggle">
                    {{$k}}
                    <span class="pull-right delete-variation-gen"><i class="fa fa-trash"></i></span>
                </div>
            </a>
            <div class="panel-collapse collapse variation-container" id="var-gen-{!!$k!!}">
                <ul>
                    <li class="mt-list-item">
                        <div class="form-horizontal">

                            <div class="form-group">
                                <label class="col-md-3 control-label">{{trans('x.Attributes')}}</label>
                                <div class="col-md-9">
                                    <select class="form-control select2-multiple" name="variations[empty{!!$k!!}][terms_id][]" multiple>
                                        @foreach(\App\Attribute::all() as $attribute)
                                            <optgroup label="{!!$attribute->name!!}">
                                            @foreach (\App\Term::where('attribute_id', $attribute->id)->where('active', '1')->orderBy('id')->get() as $term)
                                                <option value="{!!$term->id!!}" 
                                                        data-attribute="{!!$term->attribute->id!!}">
                                                        {!!$term->name!!}
                                                </option>
                                            @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">SKU</label>
                                <div class="col-md-9">
                                    <input type="text" name="variations[empty{!!$k!!}][sku]" class="form-control" value="" placeholder="SKU Code"/>
                                </div>
                            </div>
                            @foreach (\App\PriceList::where('active', '1')->get() as $list)
                                <div class="form-group">
                                    <label class="col-md-3 control-label">{!!$list->name!!} (EUR)</label>
                                    <div class="col-md-9">
                                        <input type="number" step="0.01" name="variations[empty{!!$k!!}][prices][{!!$list->id!!}]" class="form-control price" placeholder="0.00"/>
                                    </div>
                                </div>
                            @endforeach
                            <div class="form-group">
                                <label class="col-md-3 control-label">
                                    {!!trans('x.Sizes')!!}<br>
                                    ({!!trans('x.Multiple selection')!!})
                                </label>
                                <div class="col-md-9">
                                    <select class="form-control sizes" name="variations[empty{!!$k!!}][sizes][]" multiple>
                                        @foreach(\App\Size::where('active', '1')->get() as $size)
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
                                    <div class="dropzone dropzone-file-area" id="dropzone-new-{!!$k!!}" style="margin: 16px;">
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
        
        ComponentsSelect2.init();

        // initiate dropzone
        Dropzone.autoDiscover = false;
        $("#dropzone-new-{!!$k!!}").dropzone({
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
                    name : 'variations[empty{!!$k!!}][pictures][]',
                    value : imgName
                }).appendTo(file.previewElement);
            },
            error: function (file, response) {
                file.previewElement.classList.add("dz-error");
            }
        });

        // make dropzone elements sortable
        $("#dropzone-new-{!!$k!!}").sortable({
            items: '.dz-preview',
            cursor: 'move',
            opacity: 0.5,
            containment: '#dropzone-new-{!!$k!!}',
            distance: 20,
            tolerance: 'pointer'
        });

    });
    
</script>