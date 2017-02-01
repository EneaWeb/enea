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
                            <i class="icon-home"></i> {!!trans('x.Permissions')!!} 
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
                            <span class="caption-subject bold uppercase"> {!!trans('x.Permissions')!!}</span>
                        </div>
                        <div class="btn-group" style="margin-left:20px">
                            <a id="modal_add_user_button" href="#" data-toggle="modal" data-target="#" class="btn sbold green"> 
                                {!!trans('x.Add New')!!} <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>

                    <div class="portlet-body">
                        {!!Form::open(['url' =>'/save-manage-permissions', 'method'=>'POST'])!!}
                            <table class="table table-bordered">
                                {!!$table!!}
                            </table>
                            {!!Form::submit('SAVE', ['class'=>'btn btn-danger'])!!}
                        {!!Form::close()!!}
                        <br><br> 
                    </div>
                    
                </div>
            </div>

        </div>
    </div>
</div>

@stop