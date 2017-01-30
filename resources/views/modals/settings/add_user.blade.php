<div class="modal animated fadeIn" id="modal_add_user" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">
    <div class="modal-dialog animated zoomIn">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="smallModalHead">{!! trans('x.Invite an user to work with you') !!}!</h4>
            </div>
            <div class="modal-body">
                <p>{!!trans("x.Please insert the <b>name</b> and the <b>email address</b> of the user you want to add on your network." )!!}</p>
                <p>{!!trans("x.If the user is already registered on our system, will be automatically added to your network. <br>Otherwhise he will get <b>an email</b> and will be invited to confirm and join your brand network." )!!}</p>
            </div>
            {!!Form::open(array('url' => '/admin/add-user', 'method'=>'POST'))!!}
            <div class="modal-body form-horizontal form-group-separated">         
                <div class="form-group">
                    @if (Auth::user()->can('manage brands'))
                        {!!Form::label('role', trans('x.Role').'*', ['class' => 'col-md-3 control-label'])!!}
                        <div class="col-md-8">
                            {!!Form::select('role', \App\Role::where('name', '!=', 'superuser')->lists('name', 'name'), '', ['class' => 'form-control', 'placeholder' => trans('x.Select Role')])!!}
                        </div>
                    @endif
                </div>             
                <div class="form-group">
                    {!!Form::label('companyname', trans('x.Company Name').'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        {!!Form::input('text', 'companyname', '', ['class' => 'form-control', 'placeholder' => trans('x.Company Name')])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('email', 'Email'.'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        {!!Form::input('text', 'email', '', ['class' => 'form-control', 'placeholder' => trans('x.User Email')])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('season_list_id', trans('x.Season Lists').'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        {!!Form::select('season_list_id', \App\SeasonList::return_user_lists(), '', ['class'=>'selectpicker form-control', 'multiple'=>'multiple', 'name'=>'season_list_id[]'])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('message', trans('x.Message').'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        {{ Form::textarea('message', trans('x.invite_user_message', ['brandname' => Auth::user()->options->brand_in_use->name, 'UserNameSurname' => Auth::user()->profile->name_surname()]), ['class' => 'form-control']) }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {!!Form::submit(trans('x.Invite now'), ['class' => 'btn btn-danger'])!!}
                <button type="button" class="btn btn-default" data-dismiss="modal">{!!trans('x.Close')!!}</button>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
 </div>