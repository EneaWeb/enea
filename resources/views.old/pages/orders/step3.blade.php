@extends('layout.dashboard.main')

@section('more_head')

@stop
@section('more_foot')

@stop

@section('content')                
    <div class="page-content-wrap">
        
        <div class="page-title">                    
            <h2>{!!trans('x.New Order')!!}</h2>
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
                                        <span class="stepDesc">Step 1<br><small>{!!trans('x.Select Customer')!!}</small></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="done" isdone="1" style="cursor:default">
                                        <span class="stepNumber">2</span>
                                        <span class="stepDesc">Step 2<br><small>{!!trans('x.First Informations')!!}</small></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="selected" isdone="0" style="cursor:default">
                                        <span class="stepNumber">3</span>
                                        <span class="stepDesc">Step 3<br><small>{!!trans('x.Select Products')!!}</small></span>                   
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="disabled" isdone="0" style="cursor:default">
                                        <span class="stepNumber">4</span>
                                        <span class="stepDesc">Step 4<br><small>{!!trans('x.Confirm')!!}</small></span>                   
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
                            {!!trans('x.Select Products')!!}
                             &nbsp; <a href="/order/new/save-order"><button class="btn btn-danger">
                             {!!strtoupper(trans('x.Complete Order'))!!}
                             </button></a>
                        </h3>  
                        <button class="btn btn-main" style="float:right; margin-right:20px; cursor:default"><strong>
                            {{--Articoli:--}}  {!!trans('x.N. Items')!!}:  {!!$qty!!} / Tot € {!!$subtotal!!}
                        </strong></button>  
                        
                        <a href="/list-gallery" id="list-gallery" class="btn btn-info" style="float:right; margin-right:20px;">
                            <span>{!!trans('x.Gallery/List View')!!}</span>
                        </a>              
                    </div>
                    <div class="panel-body">
                    
                        <div class="panel-content">
                            {{--*/ $brand_slug = Auth::user()->options->brand_in_use->slug; /*--}}
                            @if (!Session::has('list'))
                                @include('pages.orders.step3_gallery')
                            @else
                                @include('pages.orders.step3_list')
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>   
        </div>
    </div>

{{-- MODAL ADD LINES --}}
<div class="modal animated fadeIn" 
    id="modal_add_lines" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="smallModalHead" 
    aria-hidden="true" 
    style="display: none;">
</div>
{{-- END MODAL ADD LINES --}}

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