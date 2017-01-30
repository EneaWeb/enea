<div class="portfolio-content">
    <div class="cbp-l-project-title">{!!$product->prodmodel->name!!} {!!$product->name!!}</div>
    <div class="cbp-l-project-subtitle"></div>

    @if ($pictures_count > 0)
      <div class="cbp-slider">
         <ul class="cbp-slider-wrap">

            @foreach($product->variations as $variation)
               <li class="cbp-slider-item">
                  <a href="/assets/images/products/{!!\App\X::brandInUseSlug()!!}/{!!$variation->picture!!}" class="cbp-lightbox" data-title="{!!$product->prodmodel->name!!} {!!$product->name!!} {!!$variation->color->name!!}"> 
                     <span>{!!$product->prodmodel->name!!} {!!$product->name!!} {!!$variation->color->name!!}</span> 
                     <img src="/assets/images/products/{!!\App\X::brandInUseSlug()!!}/{!!$variation->picture!!}" alt="">
                  </a>
               </li>
               @foreach($variation->pictures as $picture)
                  <li class="cbp-slider-item">
                     <a href="/assets/images/products/{!!\App\X::brandInUseSlug()!!}/{!!$picture->picture!!}" class="cbp-lightbox" data-title="{!!$product->prodmodel->name!!} {!!$product->name!!} {!!$variation->color->name!!}"> 
                        <span>{!!$product->prodmodel->name!!} {!!$product->name!!} {!!$variation->color->name!!}</span> 
                        <img src="/assets/images/products/{!!\App\X::brandInUseSlug()!!}/{!!$picture->picture!!}" alt="">
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
                    <strong>{!!trans('x.Model')!!}</strong>{!!$product->prodmodel->name!!}</li>
                <li>
                    <strong>{!!trans('x.Name')!!}</strong>{!!$product->name!!}</li>
                <li>
                    <strong>{!!trans('x.Slug')!!}</strong>{!!$product->slug!!}</li>
                <li>
                    <strong>{!!trans('x.Type')!!}</strong>{!!$product->type->description!!}</li>
                <li>
                    <strong>{!!trans('x.Variations')!!}</strong>{!!\App\Product::availColors($product->id)!!}</li>
                <li>
                    <strong>{!!trans('x.Sizes')!!}</strong>{!!\App\Product::availSizes($product->id)!!}</li>
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