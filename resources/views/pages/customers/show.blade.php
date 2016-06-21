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
                        {!! $mapHelper->renderHtmlContainer($map) !!}
                    </div>
                </div>
                
            </div>
            <div class="col-md-7 col-sm-8 col-xs-12">
                
                <form action="#" class="form-horizontal">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3><span class="fa fa-user"></span> {!!trans('auth.Profile')!!}</h3>
                        <p></p>
                    </div>
                    <div class="panel-body form-group-separated">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('auth.Company Name')!!}</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'companyname', $customer->companyname, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('auth.First Name')!!}</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'name', $customer->name, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('auth.Surname')!!}</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'surname', $customer->surname, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('auth.Sign')!!}</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'sign', $customer->sign, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('auth.Vat')!!}</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'vat', $customer->vat, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('auth.Address')!!}</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'address', $customer->address.' - '.$customer->postcode.' '.$customer->city.' '.$customer->province, ['class'=>'form-control'])!!}
                            </div>
                        </div>  
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('auth.Telephone')!!}</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'telephone', $customer->telephone, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('auth.Mobile')!!}</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'mobile', $customer->mobile, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('auth.Email')!!}</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'email', $customer->email, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-xs-5">
                                {!!Form::submit(trans('menu.Save'), ['class'=>'btn btn-primary btn-rounded pull-right'])!!}                                
                            </div>
                        </div>
                    </div>
                </div>
                </form>
                
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>
                            <span class="fa fa-package"></span> {!!trans('auth.Delivery Addresses')!!} 
                            <a href="#" data-toggle="modal" data-target="#modal_add_delivery">
                                <button class="btn btn-main">Aggiungi</button>
                            </a>
                        </h3>
                        <div class="table-responsive">
                            <table id="customers" class="table datatable table-condensed">
                                <thead>
                                    <tr>
                                        <th>{!!trans('auth.Address')!!}</th>
                                        <th>{!!trans('auth.City')!!}</th>
                                        <th>{!!trans('auth.Country')!!}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{!!$customer->address!!}</td>
                                        <td>{!!$customer->city!!} ({!!$customer->province!!})</td>
                                        <td>{!!$customer->country!!}</td>
                                    </tr>
                                    @foreach ($customer->deliveries as $delivery)
                                    <tr>
                                        <td>{!!$delivery->address!!}</td>
                                        <td>{!!$delivery->city!!} ({!!$delivery->province!!})</td>
                                        <td>{!!$delivery->country!!}</td>
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

{!! $mapHelper->renderJavascripts($map) !!}
{!! $mapHelper->renderStylesheets($map) !!}
@include('pages.customers._modal_add_delivery')

@stop