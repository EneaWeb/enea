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
                            <i class="icon-home"></i> {!!trans('x.Users')!!} 
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
                            <span class="caption-subject bold uppercase"> {!!trans('x.Users List')!!}</span>
                        </div>
                        <div class="btn-group" style="margin-left:20px">
                            <a id="modal_add_user_button" href="#" data-toggle="modal" data-target="#modal_add_user" class="btn sbold green"> 
                                {!!trans('x.Add New')!!} <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>

                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="customers-list">
                            <thead>
                                <tr>
                                    <th>{!!trans('x.Company Name')!!}</th>
                                    <th>{!!trans('x.Email')!!}</th>
                                    <th>{!!trans('x.Role')!!}</th>
                                    <th>{!!trans('x.Last Access')!!}</th>
                                    <th>{!!trans('x.Options')!!}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{!!$user->profile->companyname!!}</td>
                                    <td>{!!$user->email!!}</td>
                                    <td>{!!ucfirst($user->role())!!}</td>
                                    <td>{!!\Carbon\Carbon::setLocale(Localization::getCurrentLocale())!!}{!!$user->updated_at->diffForHumans()!!}</td>
                                    <td>
                                        @if ($user->id != Auth::user()->id)
                                            <button onClick="confirm_unlink_user({!!$user->id!!});" class="btn btn-danger btn-rounded btn-condensed btn-sm" ><span class="fa fa-times"></span></button>
                                        @endif
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

{{-- MODALS --}}
@include('modals.settings.add_user')

@stop