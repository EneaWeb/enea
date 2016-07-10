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
                    		<!-- <a href="/catalogue/order/edit/{!!$order->id!!}" class="btn btn-default btn-rounded btn-condensed btn-sm"><span class="fa fa-pencil"></span></a> -->
                            <a href="/order/details/{!!$order->id!!}"><button class="btn btn-info btn-rounded btn-condensed btn-sm"><span class="fa fa-search-plus"></span></button></a>
                            
                            <a href="/order/pdf/download/{!!$order->id!!}"><button class="btn btn-info btn-rounded btn-condensed btn-sm"><span class="fa fa-download"></span></button></a>    
                            
                            <!--<a href="/order/email/{!!$order->id!!}?back=1"><button class="btn btn-warning btn-rounded btn-condensed btn-sm"><span class="fa fa-envelope"></span></button></a>  -->                    
                            
                        	<button class="btn btn-danger btn-rounded btn-condensed btn-sm" onclick="confirm_delete_order({!!$order->id!!});"><span class="fa fa-times"></span></button>
                            <div style="width:110px; height:1px; clear:both;">&nbsp;</div>
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