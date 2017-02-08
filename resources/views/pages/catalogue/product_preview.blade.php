<div class="portfolio-content">
    <div class="cbp-l-project-title">{!!$product->prodmodel->name!!} {!!$product->name!!}</div>
    <div class="cbp-l-project-subtitle"></div>

    @if ($pictures_count > 0)
      <div class="cbp-slider">
         <ul class="cbp-slider-wrap">

            @foreach($product->variations as $variation)
            @foreach($variation->getPictures() as $picture)

                <li class="cbp-slider-item">
                    <a href="{{\App\X::s3_products($picture)}}" class="cbp-lightbox" data-title="{!!$product->prodmodel->name!!} {!!$product->name!!} {!!$variation->renderTerms()!!}"> 
                        <span>{!!$product->prodmodel->name!!} {!!$product->name!!} {!!$variation->renderTerms()!!}</span> 
                        <img src="{{\App\X::s3_products($picture)}}" alt="">
                    </a>
                </li>
            @endforeach
            @endforeach

         </ul>
      </div>
   @endif

    <div class="cbp-l-project-container">
        <div class="cbp-l-project-desc">
            <div class="cbp-l-project-desc-title">
                <span>{!!trans('x.Description')!!}</span>
            </div>
            <div class="cbp-l-project-desc-text">
               {!!$product->description !== '' ? $product->description : '...'!!}
            </div>
        </div>
        <div class="cbp-l-project-details">
            <div class="cbp-l-project-details-title">
                <span>{!!trans('x.Details')!!}</span>
            </div>
            <ul class="cbp-l-project-details-list">
                <li>
                    <strong>{!!trans('x.Model')!!}</strong>
                    {!!$product->prodmodel->name!!}
                </li>
                <li>
                    <strong>{!!trans('x.Name')!!}</strong>
                    {!!$product->name!!}
                </li>
                <li>
                    <strong>SKU</strong>
                    {!!$product->sku!!}
                </li>
                <li>
                    <strong>{!!trans('x.Type')!!}</strong>
                    {!!$product->type->name!!}
                </li>
                <li>
                    <strong style="vertical-align:top">{!!trans('x.Variations')!!}</strong>
                    <span style="display:inline-block">{!!$product->renderVariations()!!}</span>
                </li>
                <li>
                    <strong>{!!trans('x.Sizes')!!}</strong>
                    {!!$product->renderSizes()!!}
                </li>
            </ul>
        </div>
    </div>
    <div class="cbp-l-project-container">
        <div class="cbp-l-project-related">
            <div class="cbp-l-project-desc-title">
                <span>Orders</span>
            </div>

            @include('components.orders_table')

        </div>
    </div>
    <br>
    <br>
    <br>
</div>