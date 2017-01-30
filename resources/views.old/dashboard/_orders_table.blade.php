<div class="table-responsive">
    <div class="dataTables_wrapper no-footer">
        <table id="orders" class="table table-responsive table-condensed">
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
            "order": [[ (lastColumn-2), "desc" ]],
            "language": { "url": "/assets/js/plugins/datatables/"+currentLocale+".json" },
            pageLength: "20",
        });
    });
</script>

@foreach ($orders as $order)

@if (Auth::user()->can('make invoices') )

<div class="modal animated fadeIn" id="modal_proforma_{!!$order->id!!}" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none; z-index:999999">

    <div class="modal-dialog animated zoomIn" style="width:600px">
    
        <div class="modal-content">

            <div class="modal-body">
                <h3>
                    {!!trans('x.Proforma')!!}<br>
                </h3>
                {!!Form::open(['url'=>'/proforma/pdf/download/'.$order->id, 'method'=>'POST'])!!}
                <div class="modal-body form-horizontal form-group-separated">
                    <br>                      
                    <div class="form-group">
                        <label  class="col-xs-4 col-md-4 control-label">
                           N. Fattura Proforma 
                        </label>
                        <div class="col-xs-8 col-md-8">   
                            {!!Form::input('number', 'number', '', ['class'=>'form-control'])!!}
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label  class="col-xs-4 col-md-4 control-label">
                           Descrizione
                        </label>
                        <div class="col-xs-8 col-md-8">  
                            {!!Form::input('text', 'description', '', ['class'=>'form-control'])!!}
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label  class="col-xs-4 col-md-4 control-label">
                           Percentuale
                        </label>
                        <div class="col-xs-8 col-md-8">   
                            {!!Form::input('number', 'percentage', '', ['class'=>'form-control'])!!}
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label  class="col-xs-4 col-md-4 control-label">
                        
                        </label>
                        <div class="col-xs-8 col-md-8">   
                            {!!Form::submit('Genera', ['class'=>'btn btn-danger'])!!}
                        </div>
                    </div>
                    <br>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>
<div class="modal animated fadeIn" id="modal_invoice_{!!$order->id!!}" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none; z-index:999999">

    <div class="modal-dialog animated zoomIn" style="width:600px">
    
        <div class="modal-content">

            <div class="modal-body">
                <h3>
                    {!!trans('x.Invoice')!!}<br>
                </h3>
                {!!Form::open(['url'=>'/invoice/pdf/download/'.$order->id, 'method'=>'POST'])!!}
                <div class="modal-body form-horizontal form-group-separated">
                    <br>                      
                    <div class="form-group">
                        <label  class="col-xs-4 col-md-4 control-label">
                           N. Fattura
                        </label>
                        <div class="col-xs-8 col-md-8">   
                            {!!Form::input('number', 'number', '', ['class'=>'form-control'])!!}
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label  class="col-xs-4 col-md-4 control-label">
                           Descrizione
                        </label>
                        <div class="col-xs-8 col-md-8">  
                            {!!Form::input('text', 'description', '', ['class'=>'form-control'])!!}
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label  class="col-xs-4 col-md-4 control-label">
                           Percentuale
                        </label>
                        <div class="col-xs-8 col-md-8">   
                            {!!Form::input('number', 'percentage', '', ['class'=>'form-control'])!!}
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label  class="col-xs-4 col-md-4 control-label">
                        
                        </label>
                        <div class="col-xs-8 col-md-8">   
                            {!!Form::submit('Genera', ['class'=>'btn btn-danger'])!!}
                        </div>
                    </div>
                    <br>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>
@endif

@if (Auth::user()->can('make waybills') )

<div class="modal animated fadeIn" id="modal_waybill_{!!$order->id!!}" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none; z-index:999999">

    <div class="modal-dialog animated zoomIn" style="width:600px">
    
        <div class="modal-content">

            <div class="modal-body">
                <h3>
                    {!!trans('x.Invoice')!!}<br>
                </h3>
                {!!Form::open(['url'=>'/waybill/pdf/download/'.$order->id, 'method'=>'POST'])!!}
                <div class="modal-body form-horizontal form-group-separated">
                    <br>                      
                    <div class="form-group">
                        <label  class="col-xs-4 col-md-4 control-label">
                           N. DDT
                        </label>
                        <div class="col-xs-8 col-md-8">   
                            {!!Form::input('number', 'number', '', ['class'=>'form-control'])!!}
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label  class="col-xs-4 col-md-4 control-label">
                           Data Spedizione
                        </label>
                        <div class="col-xs-8 col-md-8">   
                            {!! Form::text('date', '', ['class' => 'form-control datepicker', 'placeholder'=>'yyyy-mm-dd']) !!}
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label  class="col-xs-4 col-md-4 control-label">
                           N. Colli
                        </label>
                        <div class="col-xs-8 col-md-8">   
                            {!! Form::input('number', 'n_colli', '', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label  class="col-xs-4 col-md-4 control-label">
                           Peso (Kg)
                        </label>
                        <div class="col-xs-8 col-md-8">   
                            {!! Form::input('number', 'weight', '', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label  class="col-xs-4 col-md-4 control-label">
                           Corriere
                        </label>
                        <div class="col-xs-8 col-md-8">   
                            {!! Form::input('text', 'shipper', '', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label  class="col-xs-4 col-md-4 control-label">
                        
                        </label>
                        <div class="col-xs-8 col-md-8">   
                            {!!Form::submit('Genera', ['class'=>'btn btn-danger'])!!}
                        </div>
                    </div>
                    <br>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>
@endif

<div class="modal animated fadeIn" id="modal_edit_{!!$order->id!!}" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">

    <div class="modal-dialog animated zoomIn" style="width:334px">
    
        <div class="modal-content">

            <div class="modal-body">
                <h3>
                    {!!trans('x.Order')!!} #{!!$order->id!!} <br> {!!$order->customer->companyname!!}<br>
                </h3>
                <div class="modal-body form-horizontal form-group-separated">
                    <br>                      
                    <div class="form-group">
                        <label  class="col-xs-8 col-md-8 control-label">
                           {!!trans('x.Show order details')!!} 
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
                           {!!trans('x.Download order details')!!} 
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
                           {!!trans('x.Download Excel')!!} 
                        </label>
                        <div class="col-xs-4 col-md-4">   
                            <a href="/order/excel/{!!$order->id!!}" target="_blank" class="btn btn-warning btn-rounded btn-condensed btn-sm order-actions">
                                <span class="fa fa-download" style="font-size:40px"></span>
                            </a>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label  class="col-xs-8 col-md-8 control-label">
                           {!!trans('x.Send by email')!!} 
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
                           {!!trans('x.Show Customer')!!} 
                        </label>
                        <div class="col-xs-4 col-md-4">   
                             <a href="/customer/show/{!!$order->customer->id!!}" class="btn btn-success btn-rounded btn-condensed btn-sm order-actions">
                                    <span class="fa fa-user" style="font-size:40px"></span>
                            </a>
                        </div>
                    </div>
                    <br> 
                    @if (Auth::user()->can('make orders'))
                        <div class="form-group">
                            <label  class="col-xs-8 col-md-8 control-label">
                               {!!trans('x.Edit order')!!} 
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
                               {!!trans('x.Delete order')!!} 
                            </label>
                            <div class="col-xs-4 col-md-4">   
                                <button class="btn btn-danger btn-rounded btn-condensed btn-sm order-actions" onclick="confirm_delete_order({!!$order->id!!});">
                                    <span class="fa fa-times" style="font-size:40px"></span>
                                </button>
                            </div>
                        </div>
                        <br> 

                    @endif
                    @if (Auth::user()->can('make invoices'))
                        <div class="form-group">
                            <label  class="col-xs-8 col-md-8 control-label">
                               {!!trans('x.Create Proforma')!!} 
                            </label>
                            <div class="col-xs-4 col-md-4"> 
                                <a href="#" data-toggle="modal" data-target="#modal_proforma_{!!$order->id!!}" class="btn btn-danger btn-rounded btn-condensed btn-sm order-actions">  
                                    <span class="fa fa-file-text-o" style="font-size:40px"></span>
                                </a>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label  class="col-xs-8 col-md-8 control-label">
                               {!!trans('x.Create Invoice')!!} 
                            </label>
                            <div class="col-xs-4 col-md-4">   
                                <a href="#" data-toggle="modal" data-target="#modal_invoice_{!!$order->id!!}" class="btn btn-danger btn-rounded btn-condensed btn-sm order-actions">  
                                    <span class="fa fa-file-text" style="font-size:40px"></span>
                                </a>
                            </div>
                        </div>
                        <br>
                    @endif
                    
                    @if (Auth::user()->can('make waybills'))
                        <div class="form-group">
                            <label  class="col-xs-8 col-md-8 control-label">
                               {!!trans('x.Create Waybill')!!} 
                            </label>
                            <div class="col-xs-4 col-md-4">   
                                <a href="#" data-toggle="modal" data-target="#modal_waybill_{!!$order->id!!}" class="btn btn-danger btn-rounded btn-condensed btn-sm order-actions">  
                                    <span class="fa fa-truck" style="font-size:40px"></span>
                                </a>
                            </div>
                        </div>
                    @endif
                    
                </div>
                
            </div>
        </div>
    </div>
</div>
@endforeach