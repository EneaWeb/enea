<div class="table-responsive">
    <div class="dataTables_wrapper no-footer">
        <table id="orders" class="table table-responsive table-condensed">
            <thead>
                <tr>
                    <th>{!!trans('auth.Id')!!}</th>
                    <th>{!!trans('auth.Customer')!!}</th>
                    <th>{!!trans('auth.Products')!!}</th>
                    <th>{!!trans('auth.Items')!!}</th>
                    <th>{!!trans('auth.Variation')!!}</th>
                    <th>{!!trans('auth.Total')!!} €</th>
                    <th>{!!trans('auth.Date')!!}</th>
                    <th>{!!trans('auth.Options')!!}</th>
                </tr>
            </thead>
            <tbody>
                @if ($orders != NULL)
                @foreach ($orders as $order)
                    <tr>
                        <td>
                            <a href="/order/details/{!!$order->id!!}">
                                {!!$order->id!!}
                            </a>
                        </td>
                        <td>
                            <a href="/order/details/{!!$order->id!!}">
                                {!!\App\Customer::find($order->customer_id)->companyname!!}
                            </a>
                        </td>
                        <td>{!!$order->products_qty!!}</td>
                        <td>{!!$order->items_qty!!}</td>
                        <td>{!!($order->payment_amount == '') ? '/' : $order->payment_amount.'%' !!}</td>
                        <td style="text-align:right">{!!number_format($order->total, 2, ',', '.')!!}</td>
                        <td>{{ $order->created_at->format('d/m/y H:i') }}</td>
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
                    #{!!$order->id!!} - {!!$order->customer->companyname!!}
                </h3>
                
                <a href="/order/details/{!!$order->id!!}" class="btn btn-info btn-rounded btn-condensed btn-sm">
                    <span class="fa fa-search-plus" style="font-size:40px"></span>
                </a>
                
                <a href="/order/pdf/download/{!!$order->id!!}" class="btn btn-info btn-rounded btn-condensed btn-sm">
                    <span class="fa fa-download" style="font-size:40px"></span>
                </a>    
                
                 <a href="/order/email/{!!$order->id!!}?back=1">
                    <button class="btn btn-rounded btn-condensed btn-sm disabled">
                        <span class="fa fa-envelope" style="font-size:40px"></span>
                    </button>
                </a>            
                
                <a href="/order/edit/{!!$order->id!!}" class="btn btn-warning btn-rounded btn-condensed btn-sm">
                    <span class="fa fa-pencil" style="font-size:40px"></span>
                </a>
                
                <button class="btn btn-danger btn-rounded btn-condensed btn-sm" onclick="confirm_delete_order({!!$order->id!!});">
                    <span class="fa fa-times" style="font-size:40px"></span>
                </button>
                
            </div>
        </div>
    </div>
</div>
@endforeach