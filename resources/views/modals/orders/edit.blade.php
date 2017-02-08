<style>
#modal_edit a.btn {
	width: 60px!important;
}
</style>

<div id="modal_edit_window" class="modal-dialog animated zoomIn" style="width:334px">

	<div class="modal-content">

		<div class="modal-body">
			<h3 style="text-align:center">
				{!!trans('x.Order')!!} #{!!$order->id!!} <br> {!!$order->customer->companyname!!}<br>
			</h3>
			<div class="modal-body form-horizontal form-group-separated">
				<br>                      
				<div class="form-group">
					<label  class="col-xs-8 col-md-8 control-label">
						{!!trans('x.Show order details')!!} 
					</label>
					<div class="col-xs-4 col-md-4">   
						<a href="/orders/pdf/{!!$order->id!!}" target="_blank" class="btn btn-info btn-rounded btn-condensed btn-sm order-actions">
							<span class="fa fa-2x fa-search-plus"></span>
						</a>
					</div>
				</div>
				<div class="form-group">
					<label  class="col-xs-8 col-md-8 control-label">
						{!!trans('x.Download order details')!!} 
					</label>
					<div class="col-xs-4 col-md-4">   
						<a href="/orders/pdf/download/{!!$order->id!!}" class="btn btn-info btn-rounded btn-condensed btn-sm order-actions">
							<span class="fa fa-2x fa-download"></span>
						</a> 
					</div>
				</div>
				<div class="form-group">
					<label  class="col-xs-8 col-md-8 control-label">
						{!!trans('x.Download Excel')!!} 
					</label>
					<div class="col-xs-4 col-md-4">   
						<a href="/orders/excel/{!!$order->id!!}" target="_blank" class="btn btn-warning btn-rounded btn-condensed btn-sm order-actions">
							<span class="fa fa-2x fa-download"></span>
						</a>
					</div>
				</div>
				<div class="form-group">
					<label  class="col-xs-8 col-md-8 control-label">
						{!!trans('x.Send by email')!!} 
					</label>
					<div class="col-xs-4 col-md-4">   
						<a href="/orders/email/{!!$order->id!!}?back=1" class="btn btn-info btn-rounded btn-condensed btn-sm order-actions">
							<span class="fa fa-2x fa-envelope"></span>
						</a>
					</div>
				</div>
				<div class="form-group">
					<label  class="col-xs-8 col-md-8 control-label">
						{!!trans('x.Show Customer')!!} 
					</label>
					<div class="col-xs-4 col-md-4">   
                        <a href="/customer/show/{!!$order->customer->id!!}" class="btn btn-success btn-rounded btn-condensed btn-sm order-actions">
                            <span class="fa fa-2x fa-user"></span>
                        </a>
                    </div>
				</div>
				@if (Auth::user()->can('make orders'))
                    <div class="form-group">
                        <label  class="col-xs-8 col-md-8 control-label">
                            {!!trans('x.Edit order')!!} 
                        </label>
                        <div class="col-xs-4 col-md-4">   
                            <a href="/orders/edit/{!!$order->id!!}" class="btn btn-warning btn-rounded btn-condensed btn-sm order-actions">
                            <span class="fa fa-2x fa-pencil"></span>
                            </a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-xs-8 col-md-8 control-label">
                            {!!trans('x.Delete order')!!} 
                        </label>
                        <div class="col-xs-4 col-md-4">   
                            <a class="btn btn-danger btn-rounded btn-condensed btn-sm order-actions" onclick="confirm_delete_order({!!$order->id!!});">
                            <span class="fa fa-2x fa-times"></span>
                            </a>
                        </div>
                    </div>
				@endif
				@if (Auth::user()->can('make invoices'))
                    <div class="form-group">
                        <label  class="col-xs-8 col-md-8 control-label">
                            {!!trans('x.Create Proforma')!!} 
                        </label>
                        <div class="col-xs-4 col-md-4"> 
                            <a href="#" data-toggle="modal" data-target="#modal_proforma_{!!$order->id!!}" class="btn btn-danger btn-rounded btn-condensed btn-sm order-actions">  
                            <span class="fa fa-2x fa-file-text-o"></span>
                            </a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-xs-8 col-md-8 control-label">
                            {!!trans('x.Create Invoice')!!} 
                        </label>
                        <div class="col-xs-4 col-md-4">   
                            <a href="#" data-toggle="modal" data-target="#modal_invoice_{!!$order->id!!}" class="btn btn-danger btn-rounded btn-condensed btn-sm order-actions">  
                            <span class="fa fa-2x fa-file-text"></span>
                            </a>
                        </div>
                    </div>
				@endif
				
				@if (Auth::user()->can('make waybills'))
				<div class="form-group">
					<label  class="col-xs-8 col-md-8 control-label">
						{!!trans('x.Create Waybill')!!} 
					</label>
					<div class="col-xs-4 col-md-4">   
						<a href="#" data-toggle="modal" data-target="#modal_waybill_{!!$order->id!!}" class="btn btn-danger btn-rounded btn-condensed btn-sm order-actions">  
						<span class="fa fa-2x fa-truck"></span>
						</a>
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>
</div>


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