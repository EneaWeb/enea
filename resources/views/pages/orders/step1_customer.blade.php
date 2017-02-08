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
                                {{trans('x.Select Customer')}}
                            </span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div class="form-body form-horizontal">
                            <div class="form-group">
                                <label for="companyname" class="col-md-3 control-labeL">{{trans('x.Search by Company Name')}}</label>
                                <div class="col-md-9">
                                    <input type="text" name="companyname" class="form-control ui-autocomplete-input col-md-6" id="customer-full-autocomplete"/>
                                    <span class="help-block">{!!trans('x.Search for a Customer by Company Name (dropdown)')!!}:</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-3"></div>
                                <div class="col-md-9">
                                    <a href="/orders/new/step2?customer_id={{\App\Order::getOption('customer_id')}}" class="btn btn-danger" id="goto-step2">
                                        {!!strtoupper(trans('x.Continue'))!!}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="portlet-body form">
                        <div class="form-body">

                            <div class="row">
                            
                                <div class="col-md-3"></div>

                                <div class="col-md-9">
                                    <form>
                                        <div class="form-group col-md-6">
                                            <label for="name" class="control-label">{{trans('x.Name')}}</label>
                                            <input type="text" name="name" disabled="disabled" class="form-control" id="input-name" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="sign" class="control-label">{{trans('x.Sign')}}</label>
                                            <input type="text" name="sign" disabled="disabled" class="form-control" id="input-sign" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="vat" class="control-label">{{trans('x.Vat')}}</label>
                                            <input type="text" name="vat" disabled="disabled" class="form-control" id="input-vat" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="address" class="control-label">{{trans('x.Address')}}</label>
                                            <input type="text" name="address" disabled="disabled" class="form-control" id="input-address" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="telephone" class="control-label">{{trans('x.Telephone')}}</label>
                                            <input type="text" name="telephone" disabled="disabled" class="form-control" id="input-telephone" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="mobile" class="control-label">{{trans('x.Mobile')}}</label>
                                            <input type="text" name="mobile" disabled="disabled" class="form-control" id="input-mobile" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="email" class="control-label">{{trans('x.Email')}}</label>
                                            <input type="email" name="email" disabled="disabled" class="form-control" id="input-email" />                  
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('pages-scripts')
    <script>

        function getUpdateCustomerInfos(customer_id) {
            $.ajax({
                type: 'GET',
                data: {
                    'customer_id' : customer_id,
                    format: 'json'
                },
                url: '/customers/api-customer-data',
                success: function(data) {
                    parsed = JSON.parse(data);
                    $('#customer-full-autocomplete').val(parsed.companyname);
                    $('#input-name').val(parsed.name);
                    $('#input-address').val(parsed.address+' '+parsed.postcode+' '+parsed.city+' - '+parsed.country);
                    $('#input-sign').val(parsed.sign);
                    $('#input-vat').val(parsed.vat);
                    $('#input-telephone').val(parsed.telephone);
                    $('#input-mobile').val(parsed.mobile);
                    $('#input-email').val(parsed.email);
                    // current locale
                    //currentlocale = $('#getcurrentlocale').text()
                    // CONTINUE button href
                    $('#goto-step2').attr("href", "/orders/new/step2?customer_id="+parsed.id);
                },
                error: function() {
                    toastr.error('ajax error');
                }
            });
        }

        $( window ).on( 'load', function() {

            @if (\App\Order::getOption('customer_id') !== '')
                getUpdateCustomerInfos("{{\App\Order::getOption('customer_id')}}")
            @endif

            $.getJSON('/customers/api-companyname', function(data) {
                $( "#customer-full-autocomplete" ).autocomplete({
                    source: data,
                    select: function(event, ui) {
                        if(ui.item){
                            customer_id = ui.item.value;
                            getUpdateCustomerInfos(customer_id);
                        }
                    }
                });
            });
        });
    </script>
@stop