@extends('layout.dashboard.main')

@section('more_head')

@stop
@section('more_foot')

@stop

@section('content')                
    <div class="page-content-wrap">
        
        <div class="page-title">                    
            <h2>Permissions</h2>
        </div> 

        <div class="row">
            <div class="col-md-12">
            
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <br><br>
                        <div class="col-md-7">
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