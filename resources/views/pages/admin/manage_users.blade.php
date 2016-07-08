@extends('layout.dashboard.main')

@section('more_head')

@stop
@section('more_foot')

@stop

@section('content')                
    
    <div class="page-content-wrap">
        
        <div class="page-title">                    
            <h2>{!!trans('menu.Manage Users')!!}</h2>
        </div>
        {{-- START WIDGETS --}}
        <div class="row">
            <div class="col-xs-6 col-md-6 col-lg-3">
                <div class="widget widget-primary widget-carousel">
                    <div class="owl-carousel" id="owl-example">
                        <div class=""> {{-- multiply this --}}
                            <div class="widget-item-left">
                                <br><span class="fa fa-user"></span>
                            </div>
                            <div class="widget-data">
                                <div class="widget-int num-count">
                                    {!!$users->count()!!}
                                </div>
                                <div class="widget-title">
                                    {!! trans('messages.Active users') !!}
                                </div>
                                <div class="widget-subtitle">
                                    {!! trans('messages.On brand') !!} {!!strtoupper(Auth::user()->options->brand_in_use->name)!!}
                                </div>
                            </div>                         
                        </div> {{-- stop multiply this --}} 
                    </div>                   
                </div>
            </div>
        
            <div class="col-xs-6 col-md-2 col-lg-1">
                <a href="#" data-toggle="modal" data-target="#modal_add_user" class="tile tile-danger" style="padding-top:26px; padding-bottom:17px">
                    <span class="fa fa-plus"></span>
                </a>                                     
            </div>
            
        </div>
        {{-- END WIDGETS --}}

        <div class="row">         
            <div class="col-md-12">
                {{-- START DATATABLE EXPORT --}}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            {!!trans('messages.Active Users for brand')!!}: <span class="label label-info label-form">{!!strtoupper(Auth::user()->options->brand_in_use->name)!!}</span>
                        </h3>
                        <div class="btn-group pull-right">
                            <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> 
                                {!! trans('menu.Export')!!}    
                            </button>
                            <ul class="dropdown-menu animated zoomIn">
                                <li><a href="#" onClick ="$('#users').tableExport({type:'csv',escape:'false'});">
                                    <i class="fa fa-align-left fa-2x" aria-hidden="true"></i> CSV
                                </a></li>
                                <li><a href="#" onClick ="$('#users').tableExport({type:'txt',escape:'false'});">
                                    <i class="fa fa-file-text-o fa-2x" aria-hidden="true"></i> TXT
                                </a></li>
                                <li><a href="#" onClick ="$('#users').tableExport({type:'xml',escape:'false'});">
                                    <i class="fa fa-rss fa-2x" aria-hidden="true"></i> XML
                                </a></li>
                                <li class="divider"></li>
                                <li><a href="#" onClick ="$('#users').tableExport({type:'excel',escape:'false'});">
                                    <i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i> Excel
                                </a></li>
                                <li><a href="#" onClick ="$('#users').tableExport({type:'doc',escape:'false'});">
                                    <i class="fa fa-file-word-o fa-2x" aria-hidden="true"></i> Word
                                </a></li>
                                <li class="divider"></li>
                                <li><a href="#" onClick ="$('#users').tableExport({type:'png',escape:'false'});">
                                    <i class="fa fa-file-image-o fa-2x" aria-hidden="true"></i> PNG
                                </a></li>
                                <li><a href="#" onClick ="$('#users').tableExport({type:'pdf',escape:'false'});">
                                    <i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i> PDF
                                </a></li>
                            </ul>
                        </div>
                        
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="users" class="table datatable table-condensed">
                                <thead>
                                    <tr>
                                        <th>{!!trans('auth.Name')!!}</th>
                                        <th>Email</th>
                                        <th>{!!trans('auth.Role')!!}</th>
                                        <th>{!!trans('auth.Last Login')!!}</th>
                                        <th>{!!trans('menu.Options')!!}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{!!ucfirst($user->profile->name)!!} {!!ucfirst($user->profile->surname)!!}</td>
                                        <td>{!! $user->email !!}</td>
                                        <td>{!!ucfirst($user->role())!!}</td>
                                        <td>{!!$user->last_login!!}</td>
                                        <td>
                                            @if ($user->id != Auth::user()->id)
                                                {{-- <button class="btn btn-default btn-rounded btn-condensed btn-sm"><span class="fa fa-pencil"></span></button> --}}
                                                @if($user->role() != 'superuser') {{-- CANT DELETE SUPERUSER M*F*KER --}}
                                                    <button onClick="confirm_unlink_user({!!$user->id!!});" class="btn btn-danger btn-rounded btn-condensed btn-sm" ><span class="fa fa-times"></span></button>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>                                    
                        </div>
                    </div>
                </div>
                {{-- END DATATABLE EXPORT --}}
            </div>   
        </div>
    </div>
    
{{-- MODALS --}}

<div class="modal animated fadeIn" id="modal_add_user" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">
    <div class="modal-dialog animated zoomIn">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="smallModalHead">{!! trans('menu.Invite an user to work with you') !!}!</h4>
            </div>
            <div class="modal-body">
                <p>{!!trans("messages.Please insert the <b>name</b> and the <b>email address</b> of the user you want to add on your network." )!!}</p>
                <p>{!!trans("messages.If the user is already registered on our system, will be automatically added to your network. <br>Otherwhise he will get <b>an email</b> and will be invited to confirm and join your brand network." )!!}</p>
            </div>
            {!!Form::open(array('url' => '/admin/add-user', 'method'=>'POST'))!!}
            <div class="modal-body form-horizontal form-group-separated">         
                <div class="form-group">
                    {!!Form::label('role', trans('auth.Role'), ['class' => 'col-md-3 control-label'])!!}
                    @if (Auth::user()->can('manage brand'))
                        <div class="col-md-8">
                            {!!Form::select('role', \App\Role::where('name', '!=', 'superuser')->lists('name', 'id'), '', ['class' => 'form-control', 'placeholder' => trans('auth.Select Role')])!!}
                        </div>
                    @endif
                </div>             
                <div class="form-group">
                    {!!Form::label('companyname', trans('auth.Company Name'), ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        {!!Form::input('text', 'companyname', '', ['class' => 'form-control', 'placeholder' => trans('auth.Company Name')])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('email', 'Email', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        {!!Form::input('text', 'email', '', ['class' => 'form-control', 'placeholder' => trans('auth.User Email')])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('season_list_id', 'Season List', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        <select class="selectpicker" multiple>
                          <option>Mustard</option>
                          <option>Ketchup</option>
                          <option>Relish</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('message', trans('auth.Message'), ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        {{ Form::textarea('message', trans('messages.invite_user_message', ['brandname' => Auth::user()->options->brand_in_use->name, 'UserNameSurname' => Auth::user()->profile->name_surname()]), ['class' => 'form-control']) }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {!!Form::submit(trans('menu.Invite now'), ['class' => 'btn btn-danger'])!!}
                <button type="button" class="btn btn-default" data-dismiss="modal">{!!trans('menu.Close')!!}</button>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
 </div>
    
{{-- END MODALS --}}
@stop