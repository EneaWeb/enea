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
                        <a href="/catalogue/products?show=gallery">
                        <i class="icon-home"></i> Gallery 
                        </a>
                    </li>
                    <li>
                        <a href="/catalogue/products?show=list">
                        <i class="icon-note"></i> {!!trans('x.List')!!} 
                        </a>
                    </li>
                    <li>
                        <a href="/catalogue/products/new">
                        <i class="fa fa-plus"></i> {!!trans('x.New Product')!!} 
                        </a>
                    </li>
                </ul>
            </nav>
         </div>
         <!-- END PAGE SIDEBAR -->
         <div class="page-content-col">

            <!-- BEGIN PAGE BASE CONTENT -->
            <div class="portfolio-content portfolio-1">

                <div style="display:inline-block; float:right">
                    <a class="btn btn-info" href="/catalogue/products?show=gallery">
                        <i class="icon-home"></i> Gallery 
                    </a>
                    <a class="btn btn-default" href="/catalogue/products?show=list">
                        <i class="icon-home"></i> {!!trans('x.List')!!} 
                    </a>
                </div>
                
                <div id="js-filters-juicy-projects" class="cbp-l-filters-button">
                    <div data-filter="*" class="cbp-filter-item-active cbp-filter-item btn dark btn-outline uppercase"> {!!trans('x.All')!!}
                        <div class="cbp-filter-counter"></div>
                    </div>
                    @foreach (\App\Product::groupBy('type_id')->pluck('type_id') as $type_id)
                        <div data-filter=".{!!$type_id!!}" class="cbp-filter-item btn dark btn-outline uppercase"> {!!trans('x.'.\App\Type::find($type_id)->slug)!!}
                            <div class="cbp-filter-counter"></div>
                        </div>
                    @endforeach
                </div>

                <div id="js-grid-juicy-projects" class="cbp">

                    @foreach($products as $product)

                        <div class="cbp-item {!!$product->type->id!!}">
                            <div class="cbp-caption">
                            <div class="cbp-caption-defaultWrap">
                                <div style="width: 100%; height: 260px; overflow: hidden; background-color:white; vertical-align:middle">
                                    <img style="width: auto; height: auto; max-width:100%; max-height:100%; margin: auto;" src="/assets/images/products/{!!\App\X::brandInUseSlug()!!}/300/{!!$product->picture!!}"/>
                                </div>
                            </div>
                            <div class="cbp-caption-activeWrap">
                                <div class="cbp-l-caption-alignCenter">
                                    <div class="cbp-l-caption-body">
                                        <a href="/catalogue/product-preview/{!!$product->id!!}" class="cbp-singlePage btn white uppercase" rel="nofollow"> 
                                        <i class="fa fa-search"></i>
                                        </a>
                                        <a href="/catalogue/products/{!!$product->id!!}" class="btn white uppercase" rel="nofollow"> 
                                        <i class="fa fa-pencil"></i>
                                        </a>
                                        @foreach($product->variations as $variation)
                                        @if ($product->variations->first() == $variation)
                                            <a href="/assets/images/products/{!!\App\X::brandInUseSlug()!!}/{!!$variation->picture!!}" class="cbp-lightbox btn white uppercase" data-title="{!!$product->prodmodel->name!!} {!!$product->name!!} {!!$variation->color->name!!}"><i class="fa fa-picture-o"></i></a>
                                        @else
                                            <a href="/assets/images/products/{!!\App\X::brandInUseSlug()!!}/{!!$variation->picture!!}" class="cbp-lightbox btn white uppercase" style="display:none" data-title="{!!$product->prodmodel->name!!} {!!$product->name!!} {!!$variation->color->name!!}">.</a>
                                        @endif
                                        @foreach($variation->pictures as $picture)
                                            <a href="/assets/images/products/{!!\App\X::brandInUseSlug()!!}/{!!$picture->picture!!}" class="cbp-lightbox btn white uppercase" style="display:none" data-title="{!!$product->prodmodel->name!!} {!!$product->name!!} {!!$variation->color->name!!}">.</a>
                                        @endforeach
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="cbp-l-grid-projects-title uppercase text-center uppercase text-center">{!!$product->prodmodel->name!!} {!!$product->name!!}</div>
                            <div class="cbp-l-grid-projects-desc uppercase text-center uppercase text-center">{!!trans('x.'.$product->type->slug)!!}</div>
                        </div>

                    @endforeach

                </div>
            </div>
            <!-- END PAGE BASE CONTENT -->
        </div>
    </div>
</div>
<!-- END SIDEBAR CONTENT LAYOUT -->

@stop