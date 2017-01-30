@extends('layout.main')

@section('content')

<div class="page-content-container">
	<div class="page-content-row">

        <!-- BEGIN PAGE SIDEBAR -->
        <div class="page-sidebar">
            <nav class="navbar" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <!-- Collect the nav links, forms, and other content for toggling -->
                <ul class="nav navbar-nav margin-bottom-35">
                    <li class="active">
                        <a href="#">
                            <i class="icon-home"></i> {!!trans('x.Payment Options')!!} 
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- END PAGE SIDEBAR -->
        <div class="page-content-col">

            <div class="col-md-12">
                <div class="portlet light bordered">

                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase"> {!!trans('x.Payment Options')!!}</span>
                        </div>
                        <div class="btn-group" style="margin-left:20px">
                            <a id="modal_add_user_button" href="#" data-toggle="modal" data-target="#modal_add_payment" class="btn sbold green"> 
                                {!!trans('x.Add New')!!} <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>

                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="customers-list">
                            <thead>
                                <tr>
                                    <th>{!!trans('x.Name')!!}</th>
                                    <th>Slug</th>
                                    <th>{!!trans('x.Days')!!}</th>
                                    <th>{!!trans('x.Variation')!!}</th>
                                    <th>{!!trans('x.Orders')!!}</th>
                                    <th>{!!trans('x.Options')!!}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                <tr>
                                    <td>{!!$payment->name!!}</td>
                                    <td>{!!$payment->slug!!}</td>
                                    <td>{!!$payment->days!!}</td>
                                    <td>{!!($payment->action != '') ? $payment->action.$payment->amount.'%' : '' !!} </td>
                                    <td>
                                        {!!\App\Order::where('payment_id', $payment->id)->count()!!}
                                    </td>
                                    <td>
                                        <button href="#" data-toggle="modal" data-target="#modal_edit_payments" data-payment_id="{!!$payment->id!!}" class="btn btn-default btn-rounded btn-condensed btn-sm"><span class="fa fa-pencil"></span></button>

                                        <button type="button" @if(!\App\Order::where('payment_id', $payment->id)->get()->isEmpty()) disabled @endif class="btn btn-danger btn-rounded btn-condensed btn-sm" onClick="confirm_delete_payment({!!$payment->id!!});"><span class="fa fa-times"></span></button>

                                    </td>
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

{{-- MODAL --}}
<div class="modal animated fadeIn" 
    id="modal_edit_payments" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="smallModalHead" 
    aria-hidden="true" 
    style="display: none;">
</div>
{{-- END MODAL--}}

@include('modals.settings.add_payment')

@stop

@section('pages-scripts')

    <script>
        $('body').on('show.bs.modal', '#modal_edit_payments', function (event) {

            var button = $(event.relatedTarget) // Button that triggered the modal
            var payment_id = button.data('payment_id') // Extract info from data-* attributes

            if (payment_id !== undefined) {

                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                    
                modal.empty();
                
                $.ajax({
                    type: 'GET',
                    url: '/api/settings/modal-edit',
                    data: { '_token' : '{!!csrf_token()!!}', payment_id: payment_id },
                    success:function(data){
                    // successful request; do something with the data
                    modal.append(data);
                    },
                    error:function(){
                    // failed request; give feedback to user
                    alert('ajax error');
                    }
                });   
            }
        })
    </script>
@stop