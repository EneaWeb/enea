@extends('layout.main')

@section('content')

<div class="page-content-container">
	<div class="page-content-row">

        <!-- BEGIN PAGE SIDEBAR -->

            @include('sidebars.catalogue')
            
        <!-- END PAGE SIDEBAR -->
        <div class="page-content-col">

            <div class="col-md-12">
                <div class="portlet light bordered">

                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase"> {!!trans('x.Models')!!}</span>
                        </div>
                        <div class="btn-group" style="margin-left:20px">
                            <a href="#" data-toggle="modal" data-target="#modal_add_model" class="btn sbold green"> 
                                {!!trans('x.Add New')!!} <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>

                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="sizes-list">
                            <thead>
                                <tr>
                                    <th>{!!trans('x.ID')!!}</th>
                                    <th>{!!trans('x.Name')!!}</th>
                                    <th>{!!trans('x.Slug')!!}</th>
                                    <th>{!!trans('x.Options')!!}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($models as $model)
                                    <tr>
                                        <td class="id">{!!$model->id!!}</td>
                                        <td>{!!$model->name!!}</td>
                                        <td>{!!$model->slug!!}</td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#modal_edit_model{!!$model->id!!}" class="btn btn-rounded btn-condensed btn-sm">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            @if ($model->products()->get()->isEmpty())
                                                <a href="#" onclick="confirm_delete_model('{{$model->id}}')" class="btn btn-danger btn-rounded btn-condensed btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </a>
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
@include('modals.catalogue.add_model')

@foreach ($models as $model)
    @include('modals.catalogue.edit_model')
@endforeach

@stop

@section('pages-scripts')

@stop