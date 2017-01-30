@extends('layout.dashboard.main')

@section('more_head')
    {{ HTML::style('/assets/css/cropper/cropper.min.css') }}
@stop
@section('more_foot')
    {{ HTML::script('/assets/js/plugins/bootstrap/bootstrap-file-input.js') }}
@stop

@section('content')                
    
    <div class="page-content-wrap">
        
        <div class="row">                        
            <div class="col-md-4 col-sm-4 col-xs-12">

                <div class="panel panel-default">                                
                    <div class="panel-body">
                        <h3><span class="fa fa-user"></span> {!!$customer->name!!} {!!$customer->surname!!}</h3>
                        <p>Customer [#{!!$customer->id!!}]</p>
                        @if ($test_position == true)
                            {!! $mapHelper->render($map) !!}
                        @else 
                            <img src="/assets/images/no-position.jpg" style="max-width:100%;"/>
                        @endif
                    </div>
                </div>
                
            </div>
            <div class="col-md-7 col-sm-8 col-xs-12">
                
                {!!Form::open(['url'=>'/customer/edit-customer', 'method'=>'POST', 'class'=>'form-horizontal'])!!}
                {!!Form::hidden('id', $customer->id)!!}
                
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3><span class="fa fa-user"></span> {!!trans('x.Profile')!!}</h3>
                        <p></p>
                    </div>
                    <div class="panel-body form-group-separated">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('x.Company Name')!!}</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'companyname', $customer->companyname, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('x.First Name')!!}*</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'name', $customer->name, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('x.Sign')!!}</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'sign', $customer->sign, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('x.Vat')!!}</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'vat', $customer->vat, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('x.Address')!!}*</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'address', $customer->address, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('x.City')!!}*</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'city', $customer->city, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('x.Province')!!}</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'province', $customer->province, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('x.Postcode')!!}</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'postcode', $customer->postcode, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('x.Country')!!}</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'country', $customer->country, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('x.Telephone')!!}</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'telephone', $customer->telephone, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('x.Mobile')!!}</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'mobile', $customer->mobile, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('x.Email')!!}</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'email', $customer->email, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('x.Language')!!}</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::select('language', $supportedLocales, $customer->language, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-xs-5">
                                {!!Form::submit(trans('x.Save'), ['class'=>'btn btn-primary btn-rounded pull-right'])!!}                                
                            </div>
                        </div>
                    </div>
                </div>
                </form>
                
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>
                            <span class="fa fa-package"></span> {!!trans('x.Delivery Addresses')!!} 
                            <a href="#" data-toggle="modal" data-target="#modal_add_delivery">
                                <button class="btn btn-main">Aggiungi</button>
                            </a>
                        </h3>
                        <div class="table-responsive">
                            <table id="customers" class="table datatable table-condensed">
                                <thead>
                                    <tr>
                                        <th>{!!trans('x.Address')!!}</th>
                                        <th>{!!trans('x.City')!!}</th>
                                        <th>{!!trans('x.Country')!!}</th>
                                        <th>{!!trans('x.Actions')!!}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{!!$customer->address!!}</td>
                                        <td>{!!$customer->city!!} ({!!$customer->province!!})</td>
                                        <td>{!!$customer->country!!}</td>
                                        <td>
                                        </td>
                                    </tr>
                                    @foreach ($customer->deliveries as $delivery)
                                    <tr>
                                        <td>{!!$delivery->address!!}</td>
                                        <td>{!!$delivery->city!!} ({!!$delivery->province!!})</td>
                                        <td>{!!$delivery->country!!}</td>
                                        <td>
                                            {{-- <span class="badge badge-danger">
                                                <a href="#" onclick="confirm_delete_customer_delivery({!!$delivery->id!!})" style="color:inherit; padding:6px">
                                                    <span class="fa fa-ban"></span>
                                                </a>
                                            </span>
                                            --}}
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

{{-- {!! $mapHelper->renderJavascripts($map) !!} --}}
{{-- {!! $mapHelper->renderStylesheets($map) !!} --}}

@include('pages.customers._modal_add_delivery')

@stop