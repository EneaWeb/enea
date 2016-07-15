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
                <div class="image" style="max-height: 260px;">
                    <div style="height:260px; background:url('/assets/images/products/{!!Auth::user()->options->brand_in_use->slug;!!}/300/{!!$product->picture!!}'); background-size: contain; background-position: center; background-repeat: no-repeat" alt="{!!$product->name!!}"></div>                                                          
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