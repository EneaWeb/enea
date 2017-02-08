<!-- END PAGE SIDEBAR -->
<div class="page-content-col">

    <!-- BEGIN PAGE BASE CONTENT -->
    <div class="portfolio-content portfolio-1">

        <div style="display:inline-block; float:right">
            <a class="btn btn-info" href="?show=gallery">
                <i class="fa fa-picture-o"></i>
            </a>
            <a class="btn btn-default" href="?show=list">
                <i class="fa fa-list"></i>
            </a>
            @if (X::isOrderInProgress())
                <a class="btn btn-default" href="?show=fast">
                    <i class="fa fa-fast-forward"></i>
                </a>
            @endif
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
                            <img style="width: auto; height: auto; max-width:100%; max-height:100%; margin: auto;" src="{{\App\X::s3_products_thumb($product->featuredPicture())}}"/>
                        </div>
                    </div>
                    <div class="cbp-caption-activeWrap">
                        <div class="cbp-l-caption-alignCenter">
                            <div class="cbp-l-caption-body">
                                <a href="/catalogue/product-preview/{!!$product->id!!}" class="cbp-singlePage btn white uppercase" rel="nofollow"> 
                                    <i class="fa fa-search"></i>
                                </a>

                                @if (Request::segment(2) == 'orders')
                                    <a href="#" data-toggle="modal" data-target="#modal_add_lines" data-product_id="{!!$product->id!!}" class="btn white uppercase" rel="nofollow"> 
                                        <i class="fa fa-plus"></i>
                                    </a>
                                @else
                                    <a href="/catalogue/products/{!!$product->id!!}" class="btn white uppercase" rel="nofollow"> 
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                @endif

                                <?php $i = 0; ?>
                                @foreach($product->variations as $variation)
                                @foreach($variation->getPictures() as $picture)
                                    <a href="{{\App\X::s3_products($picture)}}" class="cbp-lightbox btn white uppercase" data-title="{!!$product->prodmodel->name!!} {!!$product->name!!} {!!$variation->renderTerms()!!}" @if($i>0) style="display:none;" @endif >
                                        <i class="fa fa-picture-o"></i>
                                    </a>
                                    <?php $i++;?>
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