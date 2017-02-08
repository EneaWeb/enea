@extends('layout.main')

@section('content')

<!-- BEGIN STEPS -->
    @include('components.orders_steps')
<!-- END STEPS -->

<div class="page-content-container">
	<div class="page-content-row">

        @include('sidebars.customers')

        <div class="page-content-col">

            <div class="col-md-12">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject font-dark sbold uppercase">
                                {{trans('x.Select Options')}}
                            </span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div class="form-body form-horizontal">
                            <div class="form-group">
                                <label for="companyname" class="col-md-3 control-labeL">{{trans('x.Select delivery address')}}</label>
                                <div class="col-md-9">
                                    <select name="customer_delivery_id" class="form-control" id="input-customer-delivery-id">
                                        <option value="0">
                                            {{$customer->address}} {{$customer->city}} {{$customer->province}}
                                        </option>
                                        @foreach ($customer->deliveries as $delivery)
                                            @if (\App\Order::getOption('price_list_id') == $delivery->id)
                                                <option value="{{$delivery->id}}" selected="selected">
                                                    {{$delivery->address}} {{$delivery->city}} {{$delivery->province}}
                                                </option>
                                            @else
                                                <option value="{{$delivery->id}}">
                                                    {{$delivery->address}} {{$delivery->city}} {{$delivery->province}}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <a href="#" data-toggle="modal" data-target="#modal_add_delivery" class="btn btn-info btn-xs" id="goto-step2" style="margin-top:6px">
                                        + {!!strtoupper(trans('x.New'))!!}
                                    </a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="companyname" class="col-md-3 control-labeL">{{trans('x.Select price list')}}</label>
                                <div class="col-md-9">
                                    <select name="price_list_id" class="form-control" id="input-price-list-id">
                                        @foreach (\App\PriceList::where('active', '1')->get() as $list)
                                            @if (\App\Order::getOption('price_list_id') == $list->id)
                                                <option value="{{$list->id}}" selected="selected">{{$list->name}}</option>
                                            @else
                                                <option value="{{$list->id}}">{{$list->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="companyname" class="col-md-3 control-labeL">{{trans('x.Select delivery date')}}</label>
                                <div class="col-md-9">
                                    <select name="season_delivery_id" class="form-control" id="input-season-delivery-id">
                                        @foreach (X::seasonDeliveryDates() as $delivery)
                                            @if (\App\Order::getOption('season_delivery_id') == $delivery->id)
                                                <option value="{{$delivery->id}}" selected="selected">{{$delivery->name}}</option>
                                            @else
                                                <option value="{{$delivery->id}}">{{$delivery->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="companyname" class="col-md-3 control-labeL">{{trans('x.Select payment method')}}</label>
                                <div class="col-md-9">
                                    <select name="payment_id" class="form-control" id="input-payment-id">
                                        @foreach (X::paymentMethods() as $payment)
                                            @if (\App\Order::getOption('payment_id') == $payment->id)
                                                <option value="{{$payment->id}}" selected="selected">{{$payment->name}}</option>
                                            @else
                                                <option value="{{$payment->id}}">{{$payment->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-3"></div>
                                <div class="col-md-9">
                                    <button type="button" class="btn btn-danger" id="goto-step3">
                                        {!!strtoupper(trans('x.Continue'))!!}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODALS --}}
@include('modals.customer.add_delivery')
{{-- note: modal ADD CUSTOMER is in sidebars.customers --}}

@stop

@section('pages-scripts')

<script>

    $('body').on('click', '#goto-step3', function(e) {
        
        e.preventDefault();
        var url = '/orders/new/step3';
        url += '?customer_delivery_id='+$('#input-customer-delivery-id').val();
        url += '&price_list_id='+$('#input-price-list-id').val();
        url += '&season_delivery_id='+$('#input-season-delivery-id').val();
        url += '&payment_id='+$('#input-payment-id').val();

        // redirect
        // alert(url); // debug
        window.location.replace(url);
    })

</script>

@stop