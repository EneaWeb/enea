@extends('layout.dashboard.main')

@section('more_head')

@stop
@section('more_foot')

@stop

@section('content')                
    <div class="page-content-wrap">
        
        <div class="page-title">                    
            <h2>{!!trans('menu.New Order')!!}</h2>
        </div>
        {{-- START WIDGETS --}}
        <div class="row">
            
            <div class="col-md-12">
                
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="wizard2">
                            <ul class="steps_4 anchor" style="margin-bottom:30px">
                                <li>
                                    <a href="#" class="done" isdone="1" style="cursor:default">
                                        <span class="stepNumber">1</span>
                                        <span class="stepDesc">Step 1<br><small>SELEZIONA IL CLIENTE</small></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="done" isdone="1" style="cursor:default">
                                        <span class="stepNumber">2</span>
                                        <span class="stepDesc">Step 2<br><small>INFORMAZIONI PRELIMINARI</small></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="selected" isdone="0" style="cursor:default">
                                        <span class="stepNumber">3</span>
                                        <span class="stepDesc">Step 3<br><small>INSERISCI GLI ARTICOLI</small></span>                   
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="disabled" isdone="0" style="cursor:default">
                                        <span class="stepNumber">4</span>
                                        <span class="stepDesc">Step 4<br><small>CONFERMA</small></span>                   
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        {{-- END WIDGETS --}}

        <div class="row">         
            <div class="col-md-12">
                {{-- START DATATABLE EXPORT --}}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            {!!trans('messages.Select Products')!!}
                             &nbsp; <a href="/order/new/save-order"><button class="btn btn-danger">CONCLUDI L'ORDINE</button></a>
                        </h3>  
                        <button class="btn btn-main" style="float:right; margin-right:20px; cursor:default"><strong>
                            Articoli: {!!$items_color_grouped!!} / Pezzi:  {!!$qty!!} / Tot € {!!$subtotal!!}
                        </strong></button>                      
                    </div>
                    <div class="panel-body">
                    
                        <div class="panel-content">

                            <div class="gallery" id="links">

                            @foreach($products as $product)
                                <a class="gallery-item" href="#" data-toggle="modal" data-target="#modal_add_lines_{!!$product->id!!}" class="tile tile-primary">
                                    <div class="image">
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
                </div>


            </div>   
        </div>
    </div>

@foreach($products as $product)
    @include('pages.orders._modal_add_lines')
@endforeach

@stop