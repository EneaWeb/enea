@extends('layout.dashboard.main')

@section('more_head')

@stop
@section('more_foot')

@stop

@section('content')  

    {{-- START BASIC ELEMENTS --}}
    <div class="content-frame">
    
        <div class="col-md-12">
            {{-- START DATATABLE EXPORT --}}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {!!trans('x.Manage Types')!!}
                    </h3>       
                </div>
                <div class="panel-body">
                    <p>
                    <br>
                        I termini "Adulto" e "Kid" sono termini generici, da utilizzare quando non c'è una differenza di genere nel prodotto.<br>
                        In caso di utilizzo di "Uomo/Dona" e "Bambino" o "Bambina", DISATTIVARE i termini generici "Adulto" e "Kid".
                    <br>    
                    <br>    
                    </p>
                    {!!Form::open(['url'=>'/admin/types/update', 'method'=>'GET', 'class'=>'form-horizontal', 'role'=>'form'])!!}
                        @foreach(\App\Type::all() as $type)
                            <div class="form-group">
                                <label class="col-md-2 col-lg-1 control-label">{!!trans('x.'.ucwords($type->name))!!}</label>
                                <div class="col-md-10 col-lg-11">
                                    <label class="switch">
                                        <input type="checkbox" {!!($type->active == 1)? 'checked="checked"' : ''!!} name="{!!$type->name!!}" value="1">
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    <div class="form-group">
                    <br><br>
                        {!!Form::submit(trans('x.Update'),['class'=>'btn btn-warning btn-lg'])!!}
                    </div>
                    {!!Form::close()!!}
                    <br><br><br>
                </div>
            </div>
        </div> 
        
    </div>

@stop
