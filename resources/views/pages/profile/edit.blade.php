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
            <div class="col-md-3 col-sm-4 col-xs-5">
                
                <form action="#" class="form-horizontal">
                <div class="panel panel-default">                                
                    <div class="panel-body">
                        <h3><span class="fa fa-user"></span> {!!Auth::user()->profile->name!!} {!!Auth::user()->profile->surname!!}</h3>
                        <p>{!!ucfirst(Auth::user()->role())!!}</p>
                        <div class="text-center" id="user_image">
                            <img src="/assets/images/users/{!!Auth::user()->profile->avatar!!}" class="img-thumbnail">
                        </div>                                    
                    </div>
                    <div class="panel-body form-group-separated">
                        
                        <div class="form-group">                                        
                            <div class="col-md-12 col-xs-12">
                                <a href="#" class="btn btn-primary btn-block btn-rounded" data-toggle="modal" data-target="#modal_change_photo">
                                    {!!trans('auth.Change photo')!!}
                                </a>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">#ID</label>
                            <div class="col-md-9 col-xs-7">
                                <input type="text" value="{!!Auth::user()->id!!}" class="form-control" disabled="">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Login</label>
                            <div class="col-md-9 col-xs-7">
                                <input type="text" value="{!!Auth::user()->username!!}" class="form-control">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Email</label>
                            <div class="col-md-9 col-xs-7">
                                <input type="text" value="{!!Auth::user()->email!!}" class="form-control">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Password</label>
                            <div class="col-md-9 col-xs-7">
                                <input type="password" value="----------" class="form-control" disabled="">
                            </div>
                        </div>
                        
                        <div class="form-group">                                        
                            <div class="col-md-12 col-xs-12">
                                <a href="#" class="btn btn-danger btn-block btn-rounded" data-toggle="modal" data-target="#modal_change_password">
                                    {!!trans('auth.Change password')!!}
                                </a>
                            </div>
                        </div>
                        
                    </div>
                </div>
                </form>
                
            </div>
            <div class="col-md-6 col-sm-8 col-xs-7">
                
                <form action="#" class="form-horizontal">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3><span class="fa fa-pencil"></span> {!!trans('auth.Profile')!!}</h3>
                        <p></p>
                    </div>
                    <div class="panel-body form-group-separated">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('auth.Company Name')!!}</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'companyname', Auth::user()->profile->companyname, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('auth.First Name')!!}</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'name', Auth::user()->profile->name, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('auth.Surname')!!}</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'surname', Auth::user()->profile->surname, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('auth.Address')!!}</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::input('text', 'address', Auth::user()->address, ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">{!!trans('auth.Bio')!!}</label>
                            <div class="col-md-9 col-xs-7">
                                {!!Form::textarea('bio', Auth::user()->profile->bio, ['class'=>'form-control'])!!}
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
                
                <div class="panel panel-default tabs">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1" data-toggle="tab">Brands</a></li>
                        {{-- <li><a href="#tab2" data-toggle="tab">Send Message</a></li>  --}}                             
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane panel-body active brands-list" id="tab1">
                            @foreach(Auth::user()->brands as $brand)
                            <div class="list-group list-group-contacts border-bottom">
                                <a href="#" class="list-group-item">            
                                    <div class="pull-left brand-avatar-mini" style="background-image:url(/assets/images/brands/{!!$brand->logo!!})"></div>
                                    <span class="contacts-title">{!!$brand->name!!}</span>
                                    {{-- <p>Singer-Songwriter</p> --}} 
                                    <div class="list-group-controls">
                                        <button class="btn btn-primary btn-rounded"><span class="fa fa-times"></span></button>
                                    </div>
                                </a>                    
                            </div>
                            @endforeach
                        </div>                                                                     
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="panel panel-default form-horizontal">
                    <div class="panel-body">
                        <h3><span class="fa fa-info-circle"></span> Info</h3>
                        <p></p>
                    </div>
                    <div class="panel-body form-group-separated">                                    
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Last visit</label>
                            <div class="col-md-8 col-xs-7 line-height-30">{!! Carbon\Carbon::parse(Auth::user()->last_login)->format('d/m/Y h:m')!!}</div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Registration</label>
                            <div class="col-md-8 col-xs-7 line-height-30">{!!Auth::user()->created_at!!}</div>
                        </div>
                    </div>
                    
                </div>
                
                {{--
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3><span class="fa fa-cog"></span> Settings</h3>
                        <p>Sample of settings block</p>
                    </div>
                    <div class="panel-body form-horizontal form-group-separated">                                    
                        <div class="form-group">
                            <label class="col-md-6 col-xs-6 control-label">Notifications</label>
                            <div class="col-md-6 col-xs-6">
                                <label class="switch">
                                    <input type="checkbox" checked="" value="1">
                                    <span></span>
                                </label>
                            </div>
                        </div>                                    
                        <div class="form-group">
                            <label class="col-md-6 col-xs-6 control-label">Mailing</label>
                            <div class="col-md-6 col-xs-6">
                                <label class="switch">
                                    <input type="checkbox" checked="" value="1">
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-6 col-xs-6 control-label">Priority</label>
                            <div class="col-md-6 col-xs-6">
                                <label class="switch">
                                    <input type="checkbox" value="0">
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                --}}
            </div>
            
        </div>
    </div>

        {{-- MODALS --}}
        <div class="modal animated fadeIn" id="modal_change_photo" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="smallModalHead">Change photo</h4>
                    </div>                    
                    <form id="cp_crop" method="post" action="assets/crop_image.php">
                    <div class="modal-body">
                        <div class="text-center" id="cp_target">Use form below to upload file. Only .jpg files.</div>
                        <input type="hidden" name="cp_img_path" id="cp_img_path"/>
                        <input type="hidden" name="ic_x" id="ic_x"/>
                        <input type="hidden" name="ic_y" id="ic_y"/>
                        <input type="hidden" name="ic_w" id="ic_w"/>
                        <input type="hidden" name="ic_h" id="ic_h"/>                        
                    </div>                    
                    </form>
                    <form id="cp_upload" method="post" enctype="multipart/form-data" action="assets/upload_image.php">
                    <div class="modal-body form-horizontal form-group-separated">
                        <div class="form-group">
                            <label class="col-md-4 control-label">New Photo</label>
                            <div class="col-md-4">
                                <input type="file" class="fileinput btn-info" name="file" id="cp_photo" data-filename-placement="inside" title="Select file"/>
                            </div>                            
                        </div>                        
                    </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="cp_accept">Accept</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal animated fadeIn" id="modal_change_password" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="smallModalHead">Change password</h4>
                    </div>
                    <div class="modal-body">
                        <p></p>
                    </div>
                    {!!Form::open(['url'=>'/profile/change-password', 'method'=>'POST'])!!}   
                    <div class="modal-body form-horizontal form-group-separated">
                        <div class="form-group">
                            {!!Form::label('old_password', trans('messages.Old Password'), ['class'=>'col-md-3 control-label'])!!}
                            <div class="col-md-9">
                                {!!Form::input('text', 'old_password', '', ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!!Form::label('new_password', trans('messages.New Password'), ['class'=>'col-md-3 control-label'])!!}
                            <div class="col-md-9">
                                {!!Form::input('text', 'new_password', '', ['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!!Form::label('confirm_new_password', trans('messages.Confirm New Password'), ['class'=>'col-md-3 control-label'])!!}
                            <div class="col-md-9">
                                {!!Form::input('text', 'confirm_new_password', '', ['class'=>'form-control'])!!}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {!!Form::submit(trans('auth.Save'), ['class'=>'btn btn-danger'])!!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">{!!trans('auth.close')!!}</button>
                    </div>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>        
        {{-- EOF MODALS --}}
        
        {{-- BLUEIMP GALLERY --}}
        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
            <div class="slides"></div>
            <h3 class="title"></h3>
            <a class="prev">‹</a>
            <a class="next">›</a>
            <a class="close">×</a>
            <a class="play-pause"></a>
            <ol class="indicator"></ol>
        </div>      
        {{-- END BLUEIMP GALLERY --}}    
    
@stop