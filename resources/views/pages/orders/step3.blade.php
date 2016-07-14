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
                            {{--Articoli:--}}  N. Pezzi:  {!!$qty!!} / Tot € {!!$subtotal!!}
                        </strong></button>                      
                    </div>
                    <div class="panel-body">
                    
                        <div class="panel-content">

                            <div class="gallery" id="links">
                            
                            {{--*/ $brand_slug = Auth::user()->options->brand_in_use->slug; /*--}}
                            @foreach($products as $product)
                            
                                {{-- CUSTOMIZER --}}
                                @if (($brand_slug == 'cinziaaraia') && $product->slug == '_custom')
                                    {{-- CUSTOMIZER --}}
                                    <a class="gallery-item" href="/customizer/{!!$brand_slug!!}" class="tile tile-primary">
                                @else
                                    <a class="gallery-item" href="#" data-toggle="modal" data-target="#modal_add_lines" data-product_id="{!!$product->id!!}" class="tile tile-primary">
                                @endif
                                    <div class="image" style="max-height: 322px;">
                                        <div style="height:322px; background:url('/assets/images/products/{!!$brand_slug!!}/300/{!!$product->picture!!}'); background-size: contain; background-position: center; background-repeat: no-repeat" alt="{!!$product->name!!}"></div>                                                    
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

<div class="modal animated fadeIn" id="modal_add_lines" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">


</div>

<script>
    $('#modal_add_lines').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var product_id = button.data('product_id') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
              
        modal.empty();
        
        $.ajax({
          type: 'POST',
          url: '/add-lines/api-product-id',
          data: { '_token' : '{!!csrf_token()!!}', product_id: product_id },
          success:function(data){
            // successful request; do something with the data
            modal.append(data);
          },
          error:function(){
            // failed request; give feedback to user
            alert('ajax error');
          }
        });

    })
</script>

@stop