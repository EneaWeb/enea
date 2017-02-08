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
                        <a href="index.html">
                            <i class="icon-home"></i> Home </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon-note "></i> Reports </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon-user"></i> User Activity </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon-basket "></i> Marketplace </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon-bell"></i> Templates </a>
                    </li>
                </ul>
                <h3>Quick Actions</h3>
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">
                            <i class="icon-envelope "></i> Inbox
                            <label class="label label-danger">New</label>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon-paper-clip "></i> Task </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon-star"></i> Projects </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon-pin"></i> Events
                            <span class="badge badge-success">2</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- END PAGE SIDEBAR -->
        <div class="page-content-col">
            <!-- BEGIN PAGE BASE CONTENT -->
            <div class="profile">
                <div class="tabbable-line tabbable-full-width">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_overview" data-toggle="tab"> {{trans('x.Overview')}} </a>
                        </li>
                        <li>
                            <a href="#tab_1_3" data-toggle="tab"> Account </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_overview">
                            <div class="row">
                                <div class="col-md-3">
                                    <ul class="list-unstyled profile-nav">
                                        <li>
                                            <img src="{!!$profile->avatar()!!}" class="img-responsive pic-bordered" alt="" />
                                        </li>
                                        <li><a href="">Avatar</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-8 profile-info">
                                            <h1 class="font-green sbold uppercase">
                                                {{$profile->companyname}}
                                            </h1>
                                            <h4 class="font-green sbold uppercase">
                                                @if ($profile->companyname !== $profile->name.' '.$profile->surname) 
                                                    {{$profile->name}} {{$profile->surname}} 
                                                @endif
                                            </h4>
                                            <p> 
                                                {{$profile->bio}}
                                            </p>
                                            <p>
                                                <a href="javascript:;"> {{$profile->website}} </a>
                                            </p>
                                            <ul class="list-inline">
                                                <li>
                                                    <i class="fa fa-map-marker"></i> {{$profile->country}} </li>
                                                <li>
                                                    <i class="fa fa-star"></i> {{$user->role()}} </li>
                                            </ul>
                                        </div>
                                        <!--end col-md-8-->
                                        <div class="col-md-4">
                                            <div class="portlet sale-summary">
                                                <div class="portlet-title">
                                                    <div class="caption font-red sbold"> Sales Summary </div>
                                                    <div class="tools">
                                                        <a class="reload" href="javascript:;"> </a>
                                                    </div>
                                                </div>
                                                <div class="portlet-body">
                                                    <ul class="list-unstyled">
                                                        <li>
                                                            <span class="sale-info"> TODAY SOLD
                                                                <i class="fa fa-img-up"></i>
                                                            </span>
                                                            <span class="sale-num"> 23 </span>
                                                        </li>
                                                        <li>
                                                            <span class="sale-info"> WEEKLY SALES
                                                                <i class="fa fa-img-down"></i>
                                                            </span>
                                                            <span class="sale-num"> 87 </span>
                                                        </li>
                                                        <li>
                                                            <span class="sale-info"> TOTAL SOLD </span>
                                                            <span class="sale-num"> 2377 </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end col-md-4-->
                                    </div>
                                    <!--end row-->
                                    <div class="tabbable-line tabbable-custom-profile">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_brands" data-toggle="tab"> Brands </a>
                                            </li>
                                            <li>
                                                <a href="#tab_history" data-toggle="tab"> {{trans('x.Personal history')}} </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab_brands">
                                                <div class="portlet-body">
                                                    <table class="table table-striped table-bordered table-advance table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <i class="fa fa-university"></i> Brand </th>
                                                                <th class="hidden-xs">
                                                                    <i class="fa fa-shopping-cart"></i> {{trans('x.Orders')}} </th>
                                                                <th>
                                                                    <i class="fa fa-euro"></i> {{trans('x.Income')}} </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($user->brands as $brand)
                                                            <tr>
                                                                <td> <a href="{{$brand->website}}" target="_blank"> {{$brand->name}} </a> </td>
                                                                <td style="text-align:right"> {{\App\Order::count()}}</td>
                                                                <td style="text-align:right"> {{\App\Order::sum('total')}} € </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!--tab-pane-->
                                            <div class="tab-pane" id="tab_history">
                                                <div class="tab-pane active" id="tab_1_1_1">
                                                    <div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
                                                        
                                                        @include('components.log_lines')

                                                    </div>
                                                </div>
                                            </div>
                                            <!--tab-pane-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--tab_1_2-->
                        <div class="tab-pane" id="tab_1_3">
                            <div class="row profile-account">
                                <div class="col-md-3">
                                    <ul class="ver-inline-menu tabbable margin-bottom-10">
                                        <li class="active">
                                            <a data-toggle="tab" href="#tab_personal-info">
                                                <i class="fa fa-cog"></i> {{trans('x.Personal info')}} </a>
                                            <span class="after"> </span>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#tab_change-avatar">
                                                <i class="fa fa-picture-o"></i> {{trans('x.Change Avatar')}} </a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#tab_change-password">
                                                <i class="fa fa-lock"></i> {{trans('x.Change Password')}} </a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#tab_settings">
                                                <i class="fa fa-eye"></i> {{trans('x.Personal Settings')}} </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-9">
                                    <div class="tab-content">
                                        <div id="tab_personal-info" class="tab-pane active">
                                            <form role="form" action="#">
                                                <div class="form-group">
                                                    <label class="control-label">First Name</label>
                                                    <input type="text" placeholder="John" class="form-control" /> </div>
                                                <div class="form-group">
                                                    <label class="control-label">Last Name</label>
                                                    <input type="text" placeholder="Doe" class="form-control" /> </div>
                                                <div class="form-group">
                                                    <label class="control-label">Mobile Number</label>
                                                    <input type="text" placeholder="+1 646 580 DEMO (6284)" class="form-control" /> </div>
                                                <div class="form-group">
                                                    <label class="control-label">Interests</label>
                                                    <input type="text" placeholder="Design, Web etc." class="form-control" /> </div>
                                                <div class="form-group">
                                                    <label class="control-label">Occupation</label>
                                                    <input type="text" placeholder="Web Developer" class="form-control" /> </div>
                                                <div class="form-group">
                                                    <label class="control-label">About</label>
                                                    <textarea class="form-control" rows="3" placeholder="We are KeenThemes!!!"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Website Url</label>
                                                    <input type="text" placeholder="http://www.mywebsite.com" class="form-control" /> </div>
                                                <div class="margiv-top-10">
                                                    <a href="javascript:;" class="btn green"> Save Changes </a>
                                                    <a href="javascript:;" class="btn default"> Cancel </a>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="tab_change-avatar" class="tab-pane">
                                            
                                            <div class="dropzone dropzone-file-area" id="dropzone" style="margin: 16px;">
                                                <h4 class="sbold">{{trans('x.Drop files here or click to upload the picture')}}</h4>
                                            </div>

                                        </div>
                                        <div id="tab_change-password" class="tab-pane">
                                            <form action="#">
                                                <div class="form-group">
                                                    <label class="control-label">Current Password</label>
                                                    <input type="password" class="form-control" /> </div>
                                                <div class="form-group">
                                                    <label class="control-label">New Password</label>
                                                    <input type="password" class="form-control" /> </div>
                                                <div class="form-group">
                                                    <label class="control-label">Re-type New Password</label>
                                                    <input type="password" class="form-control" /> </div>
                                                <div class="margin-top-10">
                                                    <a href="javascript:;" class="btn green"> Change Password </a>
                                                    <a href="javascript:;" class="btn default"> Cancel </a>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="tab_settings" class="tab-pane">
                                            Function not available
                                        </div>
                                    </div>
                                </div>
                                <!--end col-md-9-->
                            </div>
                        </div>
                        <!--end tab-pane-->
                    </div>
                </div>
            </div>
            <!-- END PAGE BASE CONTENT -->
        </div>
    </div>
</div>

@stop

@section('pages-scripts')

<script>

    // initiate dropzone
    Dropzone.autoDiscover = false;
    $("#dropzone").dropzone({
        dictDefaultMessage: "",
        maxFiles:1,
        init: function() {
            this.on("addedfile", function() {
                if (this.files[1]!=null){
                    this.removeFile(this.files[0]);
                }
            });
            this.on("addedfile", function(e) {
                $('.dz-success-mark, .dz-error-message, .dz-error-mark, .dz-remove').remove();
                var n = Dropzone.createElement("<a href='javascript:;'' class='btn red btn-sm'>{{trans('x.Delete')}}</a>"),
                    t = this;
                n.addEventListener("click", function(n) {
                    n.preventDefault(), 
                    n.stopPropagation(), 
                    t.removeFile(e)
                }), e.previewElement.appendChild(n)
            })
        },
        url: "/users/upload-picture",
        addRemoveLinks: true,
        success: function (file, response) {
            // 
            if (response !== 'not an image') {
                location.href='/users/profile';
            }
        },
        error: function (file, response) {
            toastr.error('ajax error');
        }
    });

    </script>

@stop