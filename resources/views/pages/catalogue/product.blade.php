@extends('layout.main')

@section('content')

<!-- BEGIN SIDEBAR CONTENT LAYOUT -->
<div class="page-content-container">
   <div class="page-content-row">
        <!-- BEGIN PAGE SIDEBAR -->

            @include('sidebars.catalogue')

        <!-- END PAGE SIDEBAR -->
                  
        <div class="page-content-col">
            <!-- BEGIN PAGE BASE CONTENT -->
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption">
                                {!!trans('x.Edit Product')!!}: {!!$product->name!!} [ {!!$product->variations->count()!!} {!!trans('x.Variations')!!} ]
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="tabbable-bordered">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_general" data-toggle="tab"> {!!trans('x.General')!!} </a>
                                    </li>
                                    <li>
                                        <a href="#tab_edit" data-toggle="tab"> {!!trans('x.Edit')!!} </a>
                                    </li>

                                    <li>
                                        <a href="#tab_orders" data-toggle="tab"> {!!trans('x.Orders')!!} </a>
                                    </li>
                                    <li>
                                        <a href="#tab_history" data-toggle="tab"> {!!trans('x.History')!!} </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_general">

                                        <div class="row">
                                            
                                            <div class="col-md-4">
                                                    
                                                <style>
                                                .cbp-lightbox img {
                                                    height:70px; width:auto;
                                                }
                                                .cbp-lightbox img:hover,
                                                .cbp-lightbox img:focus {
                                                    opacity:0.7!important;
                                                }
                                                </style>

                                                <div class="cbp-item">
                                                    <a class="cbp-lightbox" href="{{\App\X::s3_products($product->featuredPicture())}}" data-cbp-lightbox="myCustomLightbox" data-title="{!!$product->prodmodel->name!!} {!!$product->name!!}">
                                                        <img src="{{\App\X::s3_products_thumb($product->featuredPicture())}}" style="width:100%; height:auto;">
                                                    </a>
                                                </div>
                                            
                                                <div id="grid-container">
                                                    <ul>
                                                    @foreach($product->variations as $variation)
                                                        @foreach($variation->getPictures() as $picture)
                                                            <li class="cbp-item">
                                                                <a class="cbp-lightbox" href="{{\App\X::s3_products($picture)}}" data-cbp-lightbox="myCustomLightbox" data-title="{!!$product->prodmodel->name!!} {!!$product->name!!} {!!$variation->renderTerms()!!}">
                                                                    <img src="{{\App\X::s3_products_thumb($picture)}}">
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    @endforeach
                                                    </ul>
                                                </div>
                                            
                                            </div>
                                            
                                            <div class="col-md-8 profile-info">
                                            <br>
                                                <table class="table">
                                                    <tr>
                                                        <td>{!!trans('x.Season')!!}</td>
                                                        <td><strong>{!!$product->season->name!!}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{!!trans('x.Model')!!}</td>
                                                        <td><strong>{!!$product->prodmodel->name!!}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{!!trans('x.Product')!!}</td>
                                                        <td><strong>{!!$product->name!!}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{!!trans('x.Type')!!}</td>
                                                        <td>{!!trans('x.'.$product->type->name)!!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{!!trans('x.Description')!!}</td>
                                                        <td>{!!$product->description!!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{!!trans('x.Variations')!!} N.</td>
                                                        <td><strong>{!!$product->variations->count()!!}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{!!trans('x.Variations')!!}</td>
                                                        <td>
                                                            {!! $product->renderVariations() !!}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <br><br><br>
                                                            {!!trans('x.Created')!!}
                                                        </td>
                                                        <td>
                                                            <br><br><br>
                                                            <?php \Carbon\Carbon::setLocale(Localization::getCurrentLocale()); ?>
                                                            {!!$product->created_at->diffForHumans()!!}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{!!trans('x.Last Edit')!!}</td>
                                                        <td>
                                                            <?php \Carbon\Carbon::setLocale(Localization::getCurrentLocale()); ?>
                                                            {!!$product->updated_at->diffForHumans()!!}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                        <br><br>
                                                        @if ($deletable)
                                                            <span onclick="confirm_delete_product('{!!$product->id!!}')" style="color:red; cursor:pointer">{{trans('x.Delete product')}}</span>
                                                        @else
                                                            <span style="color:grey"><i>{!!trans('x.Non deletable Product')!!}</i></span>
                                                        @endif
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane portlet-body flip-scroll" id="tab_edit">
                                        
                                        {!!Form::open(['url'=>'/catalogue/products/update', 'method'=>'POST', 'class'=>'form-horizontal', 'id'=>'product-form'])!!}
                                        {!!Form::hidden('product_id', $product->id)!!}

                                        <div class="row">
                                        
                                            <div class="col-md-6 col-lg-5 form-horizontal">

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">{!!trans('x.Season')!!}</label>
                                                    <div class="col-md-9">
                                                        {!!Form::select('season_id', \App\Season::pluck('name', 'id'), $product->season_id, ['class'=>'form-control'])!!}
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">{!!trans('x.Type')!!}</label>
                                                    <div class="col-md-9">
                                                        {!!Form::select('type_id', \App\Type::pluck('name', 'id'), $product->type_id, ['class'=>'form-control'])!!}
                                                    </div>
                                                </div>
                                            
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">{!!trans('x.Model')!!}</label>
                                                    <div class="col-md-9">
                                                        {!!Form::select('prodmodel_id', \App\ProdModel::pluck('name', 'id'), $product->prodmodel_id, ['class'=>'form-control'])!!}
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">{!!trans('x.Name')!!}</label>
                                                    <div class="col-md-9">
                                                        {!!Form::text('name', $product->name, ['class'=>'form-control'])!!}
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">SKU</label>
                                                    <div class="col-md-9">
                                                        {!!Form::text('sku', $product->sku, ['class'=>'form-control'])!!}
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">{!!trans('x.Description')!!}</label>
                                                    <div class="col-md-9">
                                                        {!!Form::textarea('description', $product->description, ['class'=>'form-control'])!!}
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">{!!trans('x.Has variations')!!}</label>
                                                    <div class="col-md-9">
                                                        {!!Form::select('has_variations', ['1'=>trans('x.Yes'), '0'=>trans('x.No')], $product->has_variations, ['class'=>'form-control'])!!}
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">{!!trans('x.Active')!!}</label>
                                                    <div class="col-md-9">
                                                        {!!Form::select('active', ['1'=>trans('x.Yes'), '0'=>trans('x.No')], $product->active, ['class'=>'form-control'])!!}
                                                    </div>
                                                </div>

                                                <div class="form-group" style="text-align:right">
                                                    <label class="col-md-3 control-label">{!!trans('x.Pictures')!!}</label>
                                                    <div id="deletable-pictures" class="deletable-pictures col-md-9">
                                                        @foreach (unserialize($product->pictures) as $picture)
                                                            <div class="deletable-picture">
                                                                <img src="{{\App\X::s3_products_thumb($picture)}}" style="width:100%; height:auto;">
                                                                <input type="hidden" name="pictures[]" value="{{$picture}}"/>
                                                                <span class="boxclose" id="boxclose"><icon class="fa fa-close"></fa></span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="form-group" style="margin-botton: 40px;">
                                                    <div class="dropzone dropzone-file-area" id="dropzone" style="margin: 16px;">
                                                        <h4 class="sbold">{{trans('x.Drop files here or click to upload pictures')}}</h4>
                                                    </div>
                                                </div>

                                                <div class="form-group" style="text-align:right">
                                                <br><br>
                                                    <button type="button" class="btn btn-lg" onclick="location.reload()">{!!trans('x.Cancel')!!}</button>
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

                                                            <label for="multiple" class="col-md-3 control-label">
                                                                {!!trans('x.Attributes selection')!!}
                                                            </label>
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
                                                                    {!!trans('x.Generate from attributes')!!}
                                                                </button>
                                                                <a href="#" data-toggle="modal" data-target="#modal_add_term" class="btn btn-danger">
                                                                    {!!trans('x.+ Attr')!!}
                                                                </a>
                                                                <br>
                                                                <button type="button" class="btn btn-info" id="create-empty-variation" style="margin-top:4px">
                                                                    {!!trans('x.Create empty')!!}
                                                                </button>

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
                                                    <div class="portlet-body fEditorm-horizontal">
                                                        <div class="form-group">
                                                            <div class="col-md-12">
                                                                @foreach ($product->variations as $variation)
                                                                    @include('pages.catalogue._variations_edit')
                                                                @endforeach
                                                            </div>
                                                            <div class="col-md-12" id="variations-container">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        {!!Form::close()!!}

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_orders">
                                        <div class="table-container">
                                            <div class="portlet-body">
                                                @include('components.orders_table')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_history">
                                    
                                        @include('components.log_lines')
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE BASE CONTENT -->
        </div>
        
   </div>
</div>
<!-- END SIDEBAR CONTENT LAYOUT -->

@include('modals.catalogue.add_term')

@stop

@section('pages-scripts')

<script type="text/javascript">

    $('.boxclose').on('click', function(){
        $(this).parent().fadeOut(300, function() { 
            $(this).remove(); 
        });
    });

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
            console.log("Uploaded Product image : " + response);
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

    // make dropzone elements sortable
    $("#deletable-pictures").sortable({
        items: '.deletable-picture',
        cursor: 'move',
        opacity: 0.5,
        containment: "#deletable-pictures",
        distance: 20,
        tolerance: 'pointer'
    });

    // apply to all button function
    $('.apply-to-all').on('click', function($e){
        // get variation container to duplicate (where the click was done)
        containerId = '#'+$(this).data('container');
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

    $('#grid-container').cubeportfolio({
        "lightboxTitleSrc" : "data-title"
    });

    // on delete variation click
    $(document).on('click', '.delete-variation, .delete-variation-gen', function(e){
        e.preventDefault();
        var id = $(e.target).data('variation');
        // just remove variation portlet
        $(this).parent().parent().parent().parent().remove();

        $('<input>').attr({
            type: 'hidden',
            name: 'delete_variation[]',
            value: id
        }).appendTo('#product-form');

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

            // get existent terms list
            terms = $('<div>').append(msg).find('.list-terms');

            // for each terms group
            $.each(terms, function ( key, val) {

                // set canAppen var as true
                var canAppend = true;

                // get all terms already existent in DOM
                existentTerms = $('.list-terms');

                // for each existent term group
                $.each (existentTerms, function ( k, v ) {

                    // get values of existent group
                    existentTermVal = $(existentTerms[k]).data('terms');
                    // get values of new creating group
                    newTermVal = $(terms[key]).data('terms');

                    // if terms group already exists, can't append
                    if (existentTermVal === newTermVal) {
                        canAppend = false;
                    }
                })

                // if everything is ok..
                if (canAppend) {
                    // append new variation element
                    $('#variations-container').append(terms[key]);
                }
            });

        })
        .error(function(){
            toastr.error('ajax error');
        });

    });

    $('#create-empty-variation').on('click', function(){

        priceLists = JSON.parse('{!!\App\PriceList::pluck('id')->toJSON()!!}');

        $.ajax({
            url : '/catalogue/products/create-empty-variation',
            method : 'GET',
            data: { _token : '{!!csrf_token()!!}' }
        })
        .success(function(msg){
            $('#variations-container').append(msg);
        })
        .error(function(){
            toastr.error('ajax error');
        });
    });

    $('#select-type').on('change', function(){
        val = $(this).val();
        if (val !== 'product')
            $('#variation-select').removeAttr('disabled');
        else
            $('#variation-select').attr('disabled', 'disabled');
    });

</script>

@stop