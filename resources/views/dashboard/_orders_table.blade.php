<div class="table-responsive">
    <div class="dataTables_wrapper no-footer">
        <table id="orders" class="table table-responsive table-condensed">
            <thead>
                <tr>
                    <th>{!!trans('auth.Id')!!}</th>
                    <th>{!!trans('auth.Customer')!!}</th>
                    @if (Auth::user()->can('manage orders'))
                        <th>{!!trans('messages.Agent')!!}</th>
                    @endif
                    <th>{!!trans('messages.Prods')!!}</th>
                    <th>{!!trans('messages.Pcs')!!}</th>
                    <th>{!!trans('auth.Total')!!} €</th>
                    <th>{!!trans('auth.Date')!!}</th>
                    <th>{!!trans('messages.Delivery')!!}</th>
                    <th>{!!trans('auth.Options')!!}</th>
                </tr>
            </thead>
            <tbody>
                @if ($orders != NULL)
                @foreach ($orders as $order)
                    <tr>
                        <td>
                            <a href="/order/pdf/{!!$order->id!!}" target="_blank">
                                {!!$order->id!!}
                            </a>
                        </td>
                        <td>
                            <a href="/customer/show/{!!$order->customer_id!!}">
                                {!!\App\Customer::find($order->customer_id)->companyname!!}
                            </a>
                        </td>
                        @if (Auth::user()->can('manage orders'))
                            <td>{!!$order->user->profile->companyname!!}</td>
                        @endif
                        <td>{!!$order->products_qty!!}</td>
                        <td>{!!$order->items_qty!!}</td>
                        <td style="text-align:right">{!!number_format($order->total, 2, ',', '.')!!}</td>
                        <td>
                            {{ $order->created_at->format('d/m/y') }}
                        </td>
                        <td>{{ $order->season_delivery->name }}</td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#modal_edit_{!!$order->id!!}" class="btn btn-danger btn-rounded btn-condensed btn-sm">
                                <span class="fa fa-cogs"></span>
                            </a>
                		</td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        var currentLocale = $('#getcurrentlocale').text();
        var lastColumn = $('#orders').find('th:last').index();
        $('#orders').DataTable( {
            "order": [[ (lastColumn-1), "desc" ]],
            "language": { "url": "/assets/js/plugins/datatables/"+currentLocale+".json" }
        });
    });
</script>

@foreach ($orders as $order)
<div class="modal animated fadeIn" id="modal_edit_{!!$order->id!!}" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">

    <div class="modal-dialog animated zoomIn" style="width:334px">
    
        <div class="modal-content">

            <div class="modal-body">
                <h3>
                    {!!trans('messages.Order')!!} #{!!$order->id!!} <br> {!!$order->customer->companyname!!}<br>
                </h3>
                <div class="modal-body form-horizontal form-group-separated">
                    <br>                      
                    <div class="form-group">
                        <label  class="col-xs-8 col-md-8 control-label">
                           {!!trans('messages.Show order details')!!} 
                        </label>
                        <div class="col-xs-4 col-md-4">   
                            <a href="/order/pdf/{!!$order->id!!}" target="_blank" class="btn btn-info btn-rounded btn-condensed btn-sm order-actions">
                                <span class="fa fa-search-plus" style="font-size:40px"></span>
                            </a>
                        </div>
                    </div>
                    <br> 
                    <div class="form-group">
                        <label  class="col-xs-8 col-md-8 control-label">
                           {!!trans('messages.Download order details')!!} 
                        </label>
                        <div class="col-xs-4 col-md-4">   
                            <a href="/order/pdf/download/{!!$order->id!!}" class="btn btn-info btn-rounded btn-condensed btn-sm order-actions">
                                <span class="fa fa-download" style="font-size:40px"></span>
                            </a> 
                        </div>
                    </div>
                    <br> 
                    <div class="form-group">
                        <label  class="col-xs-8 col-md-8 control-label">
                           {!!trans('messages.Send by email')!!} 
                        </label>
                        <div class="col-xs-4 col-md-4">   
                             <a href="/order/email/{!!$order->id!!}?back=1" class="btn btn-info btn-rounded btn-condensed btn-sm order-actions">
                                    <span class="fa fa-envelope" style="font-size:40px"></span>
                            </a>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label  class="col-xs-8 col-md-8 control-label">
                           {!!trans('messages.Show Customer')!!} 
                        </label>
                        <div class="col-xs-4 col-md-4">   
                             <a href="/customer/show/{!!$order->customer->id!!}" class="btn btn-success btn-rounded btn-condensed btn-sm order-actions">
                                    <span class="fa fa-user" style="font-size:40px"></span>
                            </a>
                        </div>
                    </div>
                    <br> 
                    <div class="form-group">
                        <label  class="col-xs-8 col-md-8 control-label">
                           {!!trans('messages.Edit order')!!} 
                        </label>
                        <div class="col-xs-4 col-md-4">   
                            <a href="/order/edit/{!!$order->id!!}" class="btn btn-warning btn-rounded btn-condensed btn-sm order-actions">
                                <span class="fa fa-pencil" style="font-size:40px"></span>
                            </a>
                        </div>
                    </div>
                    <br> 
                    <div class="form-group">
                        <label  class="col-xs-8 col-md-8 control-label">
                           {!!trans('messages.Delete order')!!} 
                        </label>
                        <div class="col-xs-4 col-md-4">   
                            <button class="btn btn-danger btn-rounded btn-condensed btn-sm order-actions" onclick="confirm_delete_order({!!$order->id!!});">
                                <span class="fa fa-times" style="font-size:40px"></span>
                            </button>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endforeach