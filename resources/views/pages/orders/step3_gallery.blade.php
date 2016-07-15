<div class="gallery" id="links">

    @foreach($products as $product)

        {{-- CUSTOMIZER --}}
        @if (($brand_slug == 'cinziaaraia') && $product->slug == '_custom')
            {{-- CUSTOMIZER --}}
            <a class="gallery-item" href="/customizer/{!!$brand_slug!!}" class="tile tile-primary">
        @else
            <a class="gallery-item" href="#" data-toggle="modal" data-target="#modal_add_lines" data-product_id="{!!$product->id!!}" class="tile tile-primary">
        @endif
            <div class="image" style="max-height: 260px;">
                <div style="height:260px; background:url('/assets/images/products/{!!$brand_slug!!}/300/{!!$product->picture!!}'); background-size: contain; background-position: center; background-repeat: no-repeat" alt="{!!$product->name!!}"></div>                                                    
            </div>
            <div class="meta">
                <strong>{!!$product->name!!}</strong>
                <span>[ {!!$product->slug!!} ]</span>
            </div>
        </a>

    @endforeach
     
</div>
     
@if( Request::input('page') != 'all')
    <div class="row">
        <div class="col-md-12 pagination">
            <ul class="pagination">
                {!! $products->render() !!}
            <div class="clearfix"></div>
        </div>
    </div>
@endif