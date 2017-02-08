@extends('layout.main')

@section('content')

<div class="page-content-container">
	<div class="page-content-row">

        <!-- BEGIN PAGE SIDEBAR -->

            @include('sidebars.settings')

        <!-- END PAGE SIDEBAR -->
        <div class="page-content-col">

            <div class="col-md-12">
                <div class="portlet light bordered">

                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase"> {!!trans('x.Price Lists')!!}</span>
                        </div>
                        <div class="btn-group" style="margin-left:20px">
                            <a href="#" data-toggle="modal" data-target="#modal_add_list" class="btn sbold green"> 
                                {!!trans('x.Add New')!!} <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>

                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="customers-list">
                            <thead>
                                <tr>
                                    <th>{!!trans('x.ID')!!}</th>
                                    <th>{!!trans('x.Name')!!}</th>
                                    <th>{!!trans('x.Active')!!}</th>
                                    <th>{!!trans('x.Orders')!!}</th>
                                    <th>{!!trans('x.Options')!!}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lists as $list)
                                <tr>
                                    <td>{!!$list->id!!}</td>
                                    <td>{!!$list->name!!}</td>
                                    <td>{!!$list->active == '1' ? trans('x.Active') : trans('x.Inactive')!!}</td>
                                    <td>
                                        {!!\App\Order::where('list_id', $list->id)->count()!!}
                                    </td>
                                    <td>
                                        <button href="#" data-toggle="modal" data-target="#modal_edit_list{{$list->id}}" class="btn btn-default btn-rounded btn-condensed btn-sm"><span class="fa fa-pencil"></span></button>

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

{{-- add MODALS --}}

@include('modals.settings.add_list')

@foreach ($lists as $list)
    @include('modals.settings.edit_list')
@endforeach


@stop