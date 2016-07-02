@extends('layout.full')

@section('body')
    
    <div class="registration-container registration-extended">            
        <div class="registration-box animated fadeInDown">
            <div class="registration-logo"></div>
            <div class="registration-body">
                <div class="row">
                {!!Form::open(['url'=>'/registration/confirm-registration', 'method'=>'POST'])!!}
                
                    <div class="col-md-6">
                        <div class="registration-title"><strong>{!!trans('messages.Last step to sign up')!!}</strong></div>
                        <br>
                        <div class="form-group">
                            <div class="col-md-12">
                                {!!Form::label('username', 'Username')!!}
                                {!!Form::input('text', 'username', Input::get('usr'), ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group">
                            <div class="col-md-12">
                                {!!Form::label('email', 'Email')!!}
                                {!!Form::input('text', 'email', Input::get('mail'), ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group">
                            <div class="col-md-12">
                                {!!Form::label('password', 'Password')!!}
                                {!!Form::input('text', 'password', Input::get('pas'), ['class'=>'form-control'])!!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="registration-title"><strong>{!!trans('messages.Personal Informations')!!}</strong></div>
                        <div class="registration-subtitle"> {!!trans('messages.Please fill all the fields below')!!} </div>
                        <br>
                        <div class="form-group">
                            <div class="col-md-12">
                                {!!Form::label('new_password', trans('messages.New Password'))!!}
                                {!!Form::input('text', 'new_password', '', ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group">
                            <div class="col-md-12">
                                {!!Form::label('confirm_new_password', trans('messages.Confirm New Password'))!!}
                                {!!Form::input('text', 'confirm_new_password', '', ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group">
                            <div class="col-md-12">
                                {!!Form::label('companyname', trans('auth.Company Name'))!!}
                                {!!Form::input('text', 'companyname', '', ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <br><br><br><br>
                        <div class="form-group push-up-30">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                                {!!Form::submit(trans('messages.Confirm'), ['class'=>'btn btn-danger btn-block'])!!}
                            </div>
                        </div>
                    </div>
                    
                {!!Form::close()!!}
                </div>
            </div>
            <div class="registration-footer">
                <div class="pull-left">
                    © 2016 Enea
                </div>
                {{-- <div class="pull-right">
                    <a href="#">About</a> |
                    <a href="#">Privacy</a> |
                    <a href="#">Contact Us</a>
                </div> --}}
            </div>
        </div>
    </div>

@stop