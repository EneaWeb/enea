@extends('layout.full')

@section('body')

  <div class="login-container login-v2">
      
      <div class="login-box animated fadeInDown" style="animation-duration: 1s;">
          <div class="login-body">
              <div class="login-title"><strong>{!!trans('x.Welcome')!!}</strong>, {!!trans('x.Please login')!!}.</div>
              
              {{Form::open(['url'=>'/authenticate', 'method'=>'POST', 'class'=>'form-horizontal'])}}
              
              <div class="form-group">
                  <div class="col-md-12">
                      <div class="input-group">
                          <div class="input-group-addon">
                              <span class="fa fa-user"></span>
                          </div>
                          {{ Form::input('text', 'username', '', ['placeholder'=>'Username', 'class'=>'form-control']) }}
                      </div>
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-md-12">
                      <div class="input-group">
                          <div class="input-group-addon">
                              <span class="fa fa-lock"></span>
                          </div>                                
                          {{ Form::input('password', 'password_true', '', ['placeholder'=>'Password', 'class'=>'form-control']) }}
                          {{ Form::input('password', 'password', '', ['placeholder'=>'Password', 'class'=>'form-control', 'style'=>'position:absolute; left:-9999px']) }}
                      </div>
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-md-6">
                      <a href="#">{!! trans('x.Forgot your password?') !!}</a>
                  </div>          
                  <div class="col-md-6 text-right">
                      <a href="#">{!! trans('x.Create an Account') !!}</a>
                  </div>              
              </div>
              <div class="form-group">
                  <div class="col-md-12">
                      <button class="btn btn-primary btn-lg btn-block"> {!! trans('x.Login') !!}</button>
                  </div>
              </div>
              {{ Form::close() }}
          </div>
          <div class="login-footer">
              <div class="pull-left">
                  © 2016 EneaWeb
              </div>
              <div class="pull-right">
                  <a href="#">About</a> |
                  <a href="#">Privacy</a> |
                  <a href="#">Contact Us</a>
              </div>
          </div>
      </div>
      
  </div>
  
@stop