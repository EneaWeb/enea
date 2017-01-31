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
                                    <a href="#" class="done" isdone="1" style="cursor:default">
                                        <span class="stepNumber">3</span>
                                        <span class="stepDesc">Step 3<br><small>{!!trans('x.Select Products')!!}</small></span>                   
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="selected" isdone="0" style="cursor:default">
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
                            {!!trans('x.Order Summary')!!}
                        </h3>                        
                    </div>
                    <div class="panel-body">
                    
                        <div class="panel-content">

                        {!!Form::open(['url'=>'/order/new/confirm', 'method'=>'GET'])!!}
                        
                            <div class="modal-body form-horizontal form-group-separated">
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        {!!trans('x.Customer')!!}:
                                    </h6>
                                    <h6 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        {!!\App\Customer::find($fullOrder['customer_id'])->companyname!!} /
                                        {!!\App\Customer::find($fullOrder['customer_id'])->name!!} 
                                        {!!\App\Customer::find($fullOrder['customer_id'])->surname!!}
                                    </h6>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        {!!trans('x.Billing Informations')!!}:
                                    </h6>
                                    <h6 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        {!!\App\Customer::find($fullOrder['customer_id'])->address!!} - 
                                        {!!\App\Customer::find($fullOrder['customer_id'])->postcode!!} 
                                        {!!\App\Customer::find($fullOrder['customer_id'])->city!!} 
                                        ({!!\App\Customer::find($fullOrder['customer_id'])->province!!}) -
                                        {!!\App\Customer::find($fullOrder['customer_id'])->country!!} <br> 
                                        {!!trans('x.Vat')!!} {!!\App\Customer::find($fullOrder['customer_id'])->vat!!}
                                    </h6>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        {!!trans('x.Shipping Informations')!!}
                                    </h6>
                                    <h6 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                    @if($fullOrder['customer_delivery_id'] != 0)
                                        {!!\App\CustomerDelivery::find($fullOrder['customer_delivery_id'])->address!!} - 
                                        {!!\App\CustomerDelivery::find($fullOrder['customer_delivery_id'])->postcode!!} 
                                        {!!\App\CustomerDelivery::find($fullOrder['customer_delivery_id'])->city!!} 
                                        ({!!\App\CustomerDelivery::find($fullOrder['customer_delivery_id'])->province!!}) -
                                        {!!\App\CustomerDelivery::find($fullOrder['customer_delivery_id'])->country!!}
                                    @else
                                        {!!\App\Customer::find($fullOrder['customer_id'])->address!!} - 
                                        {!!\App\Customer::find($fullOrder['customer_id'])->postcode!!} 
                                        {!!\App\Customer::find($fullOrder['customer_id'])->city!!} 
                                        ({!!\App\Customer::find($fullOrder['customer_id'])->province!!}) -
                                        {!!\App\Customer::find($fullOrder['customer_id'])->country!!}
                                    @endif
                                    </h6>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        {!!trans('x.Price List')!!}:
                                    </h6>
                                    <h6 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        {!!\App\SeasonList::find($fullOrder['season_list_id'])->name!!}
                                    </h6>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        {!!trans('x.Delivery Time')!!}:
                                    </h6>
                                    <h6 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        {!!\App\SeasonDelivery::find($fullOrder['season_delivery_id'])->name!!}
                                    </h6>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        {!!trans('x.Payment Conditions')!!}:
                                    </h6>
                                    <h6 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        {!!\App\Payment::find($fullOrder['payment_id'])->name!!}
                                    </h6>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        {!!trans('x.Details')!!}
                                    </h6>
                                    <h6 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        <table class="table-condensed table-bordered" style="margin-left:auto; margin-right:auto; border-collapse: collapse; width:100%;">
                                            <tr>
                                                <th></th>
                                                @foreach (\App\Size::orderBy('name')->get() as $size)
                                                    <th style="text-align:center">
                                                        {!!$size->name!!}
                                                    </th>
                                                @endforeach
                                            </tr>
                                            
                                            @foreach (Session::get('order.products_array') as $product_id => $product_variations)
                                            @foreach ($product_variations as $key => $product_variation_id)
                                            
                                                <tr>
                                                    <th style="border-left:5px solid {!!\App\Color::find(
                                                                    \App\Variation::find($product_variation_id)
                                                                        ->color_id)->hex!!}">
                                                                    
                                                        {!!\App\Product::find($product_id)->prodmodel->name!!} / 
                                                        {!!\App\Product::find($product_id)->name!!} - 
                                                        {!!\App\Color::find(
                                                                    \App\Variation::find($product_variation_id)
                                                                        ->color_id)->name!!}
                                                    </th>
                                                    @foreach (\App\Size::orderBy('name')->get() as $size)
                                                    <td style="text-align:center">
                                                        @if ( !empty( \App\Item::where('product_variation_id', $product_variation_id)->where('size_id', $size->id)->get() ) )
                                                            
                                                            {{--*/ $item_id = \App\Item::where('product_variation_id', $product_variation_id)
                                                            ->where('size_id', $size->id)->value('id'); /*--}}
                                                            @if (array_key_exists($item_id, Session::get('order.items')))
                                                                {!! Session::get('order.items.'.$item_id) !!}
                                                            @endif
                                                            
                                                        @endif
                                                    </td>
                                                    @endforeach
                                                </tr>
                                            
                                            @endforeach
                                            @endforeach
                                        </table>
                                    </h6>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        {!!trans('x.Pieces N.')!!}:
                                    </h6>
                                    <h3 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        {!!$qty!!}
                                    </h3>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        {!!trans('x.Subtotal')!!}:
                                        <br>
                                        {!!trans('x.Variations')!!}:
                                    </h6>
                                    <h6 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        € {!!number_format($subtotal, 2, ',', '.');!!}
                                        <br>
                                        {!!\App\Payment::find($fullOrder['payment_id'])->action!!}
                                        {!!\App\Payment::find($fullOrder['payment_id'])->amount !!}
                                        @if (\App\Payment::find($fullOrder['payment_id'])->amount != '') % @else / @endif
                                    </h6>
                                </div>
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        {!!strtoupper(trans('x.Total'))!!}:
                                    </h6>
                                    <h3 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        € {!!number_format($total, 2, ',', '.');!!}
                                    </h3>
                                </div>
                                <div class="form-group">
                                    <h3 class="col-md-3 col-xs-12 control-label">
                                        {!!trans('x.Add Notes')!!}:
                                    </h3>
                                    <h3 class="col-md-8 col-xs-12 control-label" style="text-align:left">
                                        {!!Form::textarea('note', (Session::has('order.custom')) ? 'CUSTOM : '.Session::get('order.custom') : '', ['class'=>'form-control'])!!}
                                    </h3>
                                </div>
                            </div>
                            
                            <div class="modal-body form-horizontal form-group-separated">
                                <br>                      
                                <div class="form-group">
                                    <h6 class="col-md-3 col-xs-12 control-label">
                                        {!!trans('x.Click to Confirm')!!}:
                                    </h6>
                                    <div class="col-md-6 col-xs-12">
                                        <button type="button" onclick="location.href='{{ URL::to('/order/new/step3') }}';" class="btn btn-warning">
                                            {!!trans('x.Add/Edit products') !!}
                                        </button>
                                        {!!Form::submit(trans('x.Confirm'), ['class'=>'btn btn-danger'])!!}
                                    </div>
                                    <div class="clearfix"></div><br>
                                </div>
                            </div>
 
                        {!!Form::close()!!}

                        </div>
                    </div>
                </div>
            </div>   
        </div>
    </div>

@stop