<table class="table table-striped table-bordered table-hover" id="dashboard-orders">
   <thead>
      <tr>
            <th>{!!trans('x.Id')!!}</th>
            <th>{!!trans('x.Customer')!!}</th>
            @if (Auth::user()->can('manage orders'))
                  <th>{!!trans('x.Agent')!!}</th>
            @endif
            <th>{!!trans('x.Prods')!!}</th>
            <th>{!!trans('x.Pcs')!!}</th>
            <th>{!!trans('x.Total')!!}</th>
            <th>{!!trans('x.Date')!!}</th>
            <th>{!!trans('x.Delivery')!!}</th>
            <th>{!!trans('x.Options')!!}</th>
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
                  <td style="text-align:right">{!!number_format($order->total, false, ',', '.')!!} €</td>
                  <td>
                        {{ $order->created_at->format('d/m/y') }}
                  </td>
                  <td>{{ $order->season_delivery->name }}</td>
                  <td>
                     <a href="#" data-toggle="modal" data-target="#modal_edit" data-order_id="{!!$order->id!!}" class="btn btn-sm">
                        <span class="fa fa-cogs"></span>
                     </a>
                  </td>
            </tr>
            @endforeach
      @endif
   </tbody>
</table>

{{-- MODAL ADD LINES --}}
<div class="modal animated fadeIn" 
    id="modal_edit" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="smallModalHead" 
    aria-hidden="true" 
    style="display: none;">
</div>
{{-- END MODAL ADD LINES --}}