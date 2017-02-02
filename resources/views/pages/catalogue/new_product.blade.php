@extends('layout.main')

@section('content')

<!-- BEGIN SIDEBAR CONTENT LAYOUT -->
<div class="page-content-container">
   <div class="page-content-row">
        <!-- BEGIN PAGE SIDEBAR -->

            @include('sidebars.catalogue')

        <!-- END PAGE SIDEBAR -->
                  
        <div class="page-content-col">

        {!!Form::open(['url'=>'/catalogue/products/new', 'method'=>'POST'])!!}

            <!-- BEGIN PAGE BASE CONTENT -->
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption">
                                {!!trans('x.New Product')!!}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="tabbable-bordered">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_edit" data-toggle="tab"> {!!trans('x.Edit')!!} </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    
                                    <div class="tab-pane portlet-body flip-scroll active" id="tab_edit">
                                        
                                        <div class="row">
                                        
                                            <div class="col-md-6 col-lg-5 form-horizontal">

                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">{!!trans('x.Season')!!}</label>
                                                        <div class="col-md-9">
                                                            {!!Form::select('season_id', \App\Season::pluck('name', 'id'), '', ['class'=>'form-control'])!!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">{!!trans('x.Type')!!}</label>
                                                        <div class="col-md-9">
                                                            {!!Form::select('type_id', \App\Type::pluck('name', 'id'), '', ['class'=>'form-control'])!!}
                                                        </div>
                                                    </div>
                                                
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">{!!trans('x.Model')!!}</label>
                                                        <div class="col-md-9">
                                                            {!!Form::select('prodmodel_id', \App\ProdModel::pluck('name', 'id'), '', ['class'=>'form-control'])!!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">{!!trans('x.Name')!!}</label>
                                                        <div class="col-md-9">
                                                            {!!Form::text('name', '', ['class'=>'form-control'])!!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">SKU</label>
                                                        <div class="col-md-9">
                                                            {!!Form::text('sku', '', ['class'=>'form-control'])!!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">{!!trans('x.Description')!!}</label>
                                                        <div class="col-md-9">
                                                            {!!Form::textarea('description', '', ['class'=>'form-control'])!!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">{!!trans('x.Has variations')!!}</label>
                                                        <div class="col-md-9">
                                                            {!!Form::select('has_variations', ['1'=>trans('x.Yes')], '', ['class'=>'form-control'])!!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">{!!trans('x.Active')!!}</label>
                                                        <div class="col-md-9">
                                                            {!!Form::select('active', ['1'=>trans('x.Yes'), '0'=>trans('x.No')], '', ['class'=>'form-control'])!!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group" style="margin-botton: 40px;">
                                                        <div class="dropzone dropzone-file-area" id="dropzone" style="margin: 16px;">
                                                            <h4 class="sbold">{{trans('x.Drop files here or click to upload pictures')}}</h4>
                                                        </div>
                                                    </div>

                                                    <div class="form-group" style="text-align:right">
                                                    <br><br>
                                                        {!!Form::submit(trans('x.Save'), ['class'=>'btn btn-danger btn-lg'])!!}
                                                    </div>
                                                    
                                            </div>

                                            <div class="col-md-6 col-lg-7">

                                                <div class="portlet light bordered">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="icon-settings font-dark"></i>
                                                            <span class="caption-subject font-dark sbold uppercase">{!!trans('x.Variations Creation')!!}</span>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body form-horizontal">

                                                        <div class="form-group">

                                                            <label for="multiple" class="col-md-3 control-label">{!!trans('x.Attributes')!!}</label>
                                                            <div class="col-md-9">
                                                                <select id="variations" class="form-control select2-multiple" multiple>
                                                                    @foreach(\App\Attribute::all() as $attribute)
                                                                        <optgroup label="{!!$attribute->name!!}">
                                                                        @foreach ($attribute->terms as $term)
                                                                            <option value="{!!$term->id!!}" data-attribute="{!!$term->attribute->id!!}">{!!$term->name!!}</option>
                                                                        @endforeach
                                                                        </optgroup>
                                                                    @endforeach
                                                                </select>

                                                                <br>

                                                                <button type="button" class="btn btn-info" id="create-variations">
                                                                    {!!trans('x.Create variations from attributes')!!}
                                                                </button>
                                                                <a href="#" data-toggle="modal" data-target="#modal_add_term" class="btn btn-danger">
                                                                    {!!trans('x.+ Attr')!!}
                                                                </a>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="portlet light bordered">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="icon-settings font-dark"></i>
                                                            <span class="caption-subject font-dark sbold uppercase">{!!trans('x.Variations')!!}</span>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body form-horizontal">
                                                        <div class="form-group">
                                                            <div class="col-md-12" id="variations-container">
                                                            
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE BASE CONTENT -->

        {!!Form::close()!!}
        
        </div>
        
   </div>
</div>
<!-- END SIDEBAR CONTENT LAYOUT -->

@include('modals.catalogue.add_term')

@stop

{{-- file script form multi select2 : [..]/component-selec2.min.js --}}

@section('pages-scripts')

<script>

    // initiate dropzone
    Dropzone.autoDiscover = false;
    $("#dropzone").dropzone({
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
            // debug
            console.log("Uploaded Product image : " + imgName);
            // 
            if (response !== 'not an image') {
                file.previewElement.classList.add("dz-success");
                var imgName = response;
                // create input to populate array of images
                $('<input>').attr({
                    type : 'hidden',
                    name : 'pictures[]',
                    value : imgName
                }).appendTo(file.previewElement);
            }
        },
        error: function (file, response) {
            file.previewElement.classList.add("dz-error");
        }
    });

    // make dropzone elements sortable
    $("#dropzone").sortable({
        items: '.dz-preview',
        cursor: 'move',
        opacity: 0.5,
        containment: '#dropzone',
        distance: 20,
        tolerance: 'pointer'
    });

    // apply to all button function
    $(document).on('click', '.apply-to-all', function(){
        // get variation container to duplicate (where the click was done)
        containerId = '#'+$(this).data('container');

        console.log(containerId);
        // get price for each list and size values
        prices = $(containerId+' .price');
        sizes = $(containerId+' .sizes').val();

        // put prices in an array
        pricesArr = new Array();
        $.each( prices, function( key, val ) {
            pricesArr.push( $(prices[key]).val() );
        });

        // find all other variation containers and loop
        varContainers = $('.variation-container');
        $.each( varContainers, function( key, val ) 
        {
            // find all prices in variation containers and loop
            varPrices = $(varContainers[key]).find('.price');
            $.each( varPrices, function( key, val ) 
            {   // apply prices
                $(varPrices[key]).val(pricesArr[key]);
            });
            // apply sizes
            $(varContainers[key]).find('.sizes').val(sizes);
        });
    });

    // on delete variation (created on the fly) click
    $(document).on('click', '.delete-variation-otf', function(e){
        e.preventDefault();
        // just remove variation portlet
        $(this).parent().parent().parent().parent().remove();
    });

    $('#create-variations').on('click', function(){

        priceLists = JSON.parse('{!!\App\PriceList::pluck('id')->toJSON()!!}');

        var content = '';
        var attributes = new Array();
        $('#variations :selected').each(function(i, selected){ 
            thisTerm = $(selected).val();
            thisAttribute = $(selected).data('attribute');
            attributes.push({ attribute: thisAttribute, term: thisTerm });
        });

        $.ajax({
            url : '/catalogue/products/create-variations',
            method : 'GET',
            data: { _token: '{!!csrf_token()!!}', attributes : attributes }
        })
        .success(function(msg){
                $('#variations-container').empty().hide().html(msg).fadeIn();
        })
        .error(function(){
            alert('ajax error');
        })

    })

</script>

@stop
