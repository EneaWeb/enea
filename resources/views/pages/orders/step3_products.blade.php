@extends('layout.main')

@section('content')

<!-- BEGIN STEPS -->
    @include('components.orders_steps')
<!-- END STEPS -->

<div class="page-content-container">
	<div class="page-content-row">

        {{-- @include('sidebars.catalogue') --}}

        @if($list)
            @include('pages.catalogue._products_list')
        @elseif ($fast)
            @include('pages.orders._fast_order')
        @else
            @include('pages.catalogue._products_gallery')
        @endif

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

@stop

@section('pages-scripts')

<script>
    $('#modal_add_lines').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var product_id = button.data('product_id');
        var modal = $(this);
              
        modal.empty();
        
        $.ajax({
            type: 'POST',
            url: '/orders/new/add-lines',
            data: { '_token' : '{!!csrf_token()!!}', product_id: product_id },
            success:function(data){
                // successful request; do something with the data
                modal.append(data);
            },
            error:function(){
                // failed request; give feedback to user
                toastr.error('ajax error');
            }
        });

    })
</script>

@stop