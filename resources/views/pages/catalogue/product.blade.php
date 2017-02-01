@extends('layout.main')

@section('content')

<!-- BEGIN SIDEBAR CONTENT LAYOUT -->
<div class="page-content-container">
   <div class="page-content-row">
        <!-- BEGIN PAGE SIDEBAR -->
        <div class="page-sidebar">
            <nav class="navbar" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <!-- Collect the nav links, forms, and other content for toggling -->
                <ul class="nav navbar-nav margin-bottom-35">
                    <li class="active">
                        <a href="#">
                            <i class="icon-home"></i> {!!trans('x.Product')!!}
                        </a>
                        <li>
                            <a href="/catalogue/products/new">
                            <i class="fa fa-plus"></i> {!!trans('x.New Product')!!} 
                            </a>
                        </li>
                    </li>
                </ul>
            </nav>
        </div>
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
                                        <a href="#tab_images" data-toggle="tab"> {!!trans('x.Pictures')!!} </a>
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

                                        <style>
                                        .cbp-lightbox img {
                                            height:70px; width:auto;
                                        }
                                        .cbp-lightbox img:hover,
                                        .cbp-lightbox img:focus {
                                            opacity:0.7!important;
                                        }
                                        </style>

                                        <div id="grid-container">
                                        <ul>
                                        {{--
                                        @foreach($product->variations as $variation)
                                            <li class="cbp-item">
                                                <a class="cbp-lightbox" href="/assets/images/products/{!!\App\X::brandInUseSlug()!!}/{!!$variation->picture!!}" data-cbp-lightbox="myCustomLightbox" data-title="{!!$product->prodmodel->name!!} {!!$product->name!!} {!!$variation->color->name!!}">
                                                <img src="/assets/images/products/{!!\App\X::brandInUseSlug()!!}/{!!$variation->picture!!}">
                                                </a>
                                            </li>
                                            @foreach($variation->pictures as $picture)
                                                <li class="cbp-item">
                                                    <a class="cbp-lightbox" href="/assets/images/products/{!!\App\X::brandInUseSlug()!!}/{!!$picture->picture!!}" data-cbp-lightbox="myCustomLightbox" data-title="{!!$product->prodmodel->name!!} {!!$product->name!!} {!!$variation->color->name!!}">
                                                        <img src="/assets/images/products/{!!\App\X::brandInUseSlug()!!}/{!!$picture->picture!!}">
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endforeach
                                        --}}
                                        </ul>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-8 profile-info">
                                            <br>
                                            <p>
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
                                                        <td>{!!trans('x.Variations')!!} N.</td>
                                                        <td><strong>{!!$product->variations->count()!!}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{!!trans('x.Variations')!!}</td>
                                                        {{-- <td>
                                                            @foreach ($product->variations as $variation)
                                                                {!!$variation->color->name!!} 
                                                                [ {!!trans('x.Sizes')!!} {!!\App\Variation::renderSizes($variation) !!} ]
                                                                <br>
                                                            @endforeach
                                                        </td>
                                                        --}}
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <br><br><br>
                                                            {!!trans('x.Created')!!}
                                                        </td>
                                                        <td>
                                                            <br><br><br>
                                                            {!!\Carbon\Carbon::setLocale(Localization::getCurrentLocale())!!}
                                                            {!!$product->created_at->diffForHumans()!!}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{!!trans('x.Last Edit')!!}</td>
                                                        <td>
                                                            {!!\Carbon\Carbon::setLocale(Localization::getCurrentLocale())!!}
                                                            {!!$product->updated_at->diffForHumans()!!}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                        <br><br>
                                                        @if ($deletable)
                                                            <span id="delete-product" style="color:red; cursor:pointer">{{trans('x.Delete product')}}</span>
                                                        @else
                                                            <span style="color:grey"><i>{!!trans('x.Non deletable Product')!!}</i></span>
                                                        @endif
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane portlet-body flip-scroll" id="tab_edit">
                                        
                                        {!!Form::open(['url'=>'/catalogue/products/update', 'method'=>'GET', 'class'=>'form-horizontal'])!!}
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
                                    <div class="tab-pane portlet-body flip-scroll" id="tab_images">
                                        <div id="tab_images_uploader_container" class="margin-bottom-10">
                                            <a data-toggle="modal" data-target="#upload_picture" href="javascript:;" class="btn btn-primary">
                                                <i class="fa fa-share"></i> Upload </a>
                                                <br><br>
                                        </div>
                                        <div class="row">
                                            <div id="tab_images_uploader_filelist" class="col-md-6 col-sm-12"> </div>
                                        </div>
                                        <table class="table table-bordered table-hover flip-content">
                                            <thead class="flip-content">
                                                <tr role="row" class="heading">
                                                    <th width="20%"> {!!trans('x.Picture')!!} </th>
                                                    <th width="30%"> {!!trans('x.Type')!!} </th>
                                                    <th width="30%"> {!!trans('x.Filename')!!}</th>
                                                    <th width="10%"> {!!trans('x.Options')!!}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($product->picture !== '')
                                                <tr style="background-color:#ffd">
                                                    <td>
                                                        <img class="img-responsive" style="max-height:100px; width:auto;" src="/assets/images/products/{!!\App\X::brandInUseSlug()!!}/300/{!!$product->picture!!}" alt="" />
                                                    </td>
                                                    <td style="vertical-align:middle;">{!!trans('x.Main Picture')!!}</td>
                                                    <td style="vertical-align:middle;">{!!$product->pictures!!}</td>
                                                    <td style="vertical-align:middle;">
                                                        <button class="btn btn-danger delete-picture" data-type="product" data-id="{!!$product->id!!}"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                                @endif
                                                {{--
                                                @foreach ($product->variations as $variation)
                                                    @if ($variation->picture !== '')
                                                    <tr style="background-color:#ffe">
                                                        <td>
                                                            <img class="img-responsive" style="max-height:100px; width:auto;" src="/assets/images/products/{!!\App\X::brandInUseSlug()!!}/300/{!!$variation->picture!!}" alt="" />
                                                        </td>
                                                        <td style="vertical-align:middle;">{!!trans('x.Main Variation Picture')!!}</td>
                                                        <td style="vertical-align:middle;">{!!$variation->picture!!}</td>
                                                        <td style="vertical-align:middle;">
                                                            <button class="btn btn-danger delete-picture" data-type="variation" data-id="{!!$variation->id!!}"><i class="fa fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @foreach ($variation->pictures as $picture)
                                                    <tr>
                                                        <td>
                                                            <img class="img-responsive" style="max-height:100px; width:auto;" src="/assets/images/products/{!!\App\X::brandInUseSlug()!!}/300/{!!$picture->picture!!}" alt="" />
                                                        </td>
                                                        <td style="vertical-align:middle;">{!!trans('x.Variation Picture')!!}</td>
                                                        <td style="vertical-align:middle;">{!!$picture->picture!!}</td>
                                                        <td style="vertical-align:middle;">
                                                            <button class="btn btn-danger delete-picture" data-type="variation_picture" data-id="{!!$picture->id!!}"><i class="fa fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @endforeach
                                                --}}
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="tab_orders">
                                        <div class="table-container">
                                            <div class="portlet-body">
                                                @include('components.orders_table')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_history">
                                        <div class="table-container">
                                            (funzione in lavorazione)
                                        </div>
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

{{-- @include('modals.products.upload_picture') --}}

@stop

@section('pages-scripts')

<script type="text/javascript">

    $('#grid-container').cubeportfolio({
        "lightboxTitleSrc" : "data-title"
    });

    $(document).ready(function(){

        $('#delete-product').click(function(){
            ; // to develop
        })

        $('#select-type').on('change', function(){
            val = $(this).val();
            if (val !== 'product')
                $('#variation-select').removeAttr('disabled');
            else
                $('#variation-select').attr('disabled', 'disabled');
        });

        $('.delete-picture').on('click', function(){
            
            var btn = $(this);
            type = $(this).attr('data-type');
            id = $(this).attr('data-id');

            alertify.confirm( "{!!trans('x.Please Confirm')!!}", "{!!trans('x.Are you sure you want to delete this picture?')!!}", 
                function () {
                    // positive
                    $.ajax({
                    url: '/catalogue/product/delete-picture',
                    method: 'GET',
                    data: { type : type, id : id}
                })
                .success(function( msg ){
                    if (msg == 'ok') {
                        btn.parent('td').parent('tr').remove();
                        toastr.success('{{trans('x.Picture deleted')}}');
                    }
                })
                .fail( function(){
                    toastr.error('ajax error');
                });
                }, 
                function() {
                    ; // negative// do nothing 
                }
            );

        });
    })

</script>

@stop