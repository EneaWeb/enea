@extends('layout.dashboard.main')

@section('more_head')

@stop
@section('more_foot')

@stop

@section('content')  



<div class="content-frame">   

    <div class="panel">
    
        <div class="panel-body gallery" id="links">

        @foreach($products as $product)
            <a class="gallery-item" href="/catalogue/product/{!!$product->id!!}" title="{!!$product->name!!}" data-gallery="">
                <div class="image" style="max-height: 338px;">
                    <img src="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug;!!}/{!!$product->picture!!}" alt="{!!$product->name!!}">                                                             
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
    </div>       

</div>


@stop