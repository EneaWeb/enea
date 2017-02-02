@extends('layout.main')

@section('content')

<div class="page-content-container">
	<div class="page-content-row">

        <!-- BEGIN PAGE SIDEBAR -->

            @include('sidebars.customers')

        <!-- END PAGE SIDEBAR -->
        <div class="page-content-col">

            <div class="col-md-12">
                <div class="portlet light bordered">

                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase"> {!!trans('x.Customers List')!!}</span>
                        </div>
                        <div class="btn-group" style="margin-left:20px">
                            <a id="modal_add_customer_button" href="#" data-toggle="modal" data-target="#modal_add_customer" class="btn sbold green"> 
                                {!!trans('x.Add New')!!} <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>

                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="customers-list">
                            <thead>
                                <tr>
                                    <th>{!!trans('x.Company Name')!!}</th>
                                    <th>{!!trans('x.Orders')!!}</th>
                                    <th>{!!trans('x.Sign')!!}</th>
                                    <th>{!!trans('x.City')!!}</th>
                                    <th>{!!trans('x.Country')!!}</th>
                                    <th>{!!trans('x.Language')!!}</th>
                                    <th>{!!trans('x.Created At')!!}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                <?php $ordersCount = \App\Order::where('customer_id', $customer->id)->count(); ?>
                                <tr {!! $ordersCount == 0 ? 'style="color:#aaa"' : ''!!}>
                                    <td><a href="/customer/show/{!!$customer->id!!}"{!! $ordersCount == 0 ? 'style="color:#9babb9"' : ''!!}>{!!$customer->companyname!!}</a></td>
                                    <td>{!!$ordersCount!!}</td>
                                    <td>{!!$customer->sign!!}</td>
                                    <td>{!!$customer->city!!} {!!$customer->province != '' ? '('.$customer->province.')' : ''!!}</td>
                                    <td>{!!$customer->country!!}</td>
                                    <td>{!!strtoupper($customer->language)!!}</td>
                                    <td>{!!$customer->created_at->format('d/m/y')!!}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>

        </div>
    </div>
</div>

{{-- MODALS --}}
@include('modals.customer.add_customer')

@stop