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
                            <i class="icon-home"></i> {!!trans('x.Seasons')!!} 
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
                            <span class="caption-subject bold uppercase"> {!!trans('x.Seasons')!!}</span>
                        </div>
                        <div class="btn-group" style="margin-left:20px">
                            <a id="modal_add_customer_button" href="#" data-toggle="modal" data-target="#" class="btn sbold green"> 
                                {!!trans('x.Add New')!!} <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>

                    <div class="portlet-body">

                        <div class="mt-element-list">

                            <div class="mt-list-container list-todo" id="accordion1" role="tablist" aria-multiselectable="true">
                                <div class="list-todo-line"></div>
                                <ul>
                                    @foreach($seasons as $season)
                                        <li class="mt-list-item">
                                            <div class="list-todo-icon bg-white">
                                                <i class="fa fa-umbrella"></i>
                                            </div>
                                            <div class="list-todo-item dark">
                                                <a class="list-toggle-container" data-toggle="collapse" data-parent="#accordion1" onclick=" " href="#task-season-{!!$season->id!!}" aria-expanded="false">
                                                    <div class="list-toggle done">
                                                        <div class="list-toggle-title">
                                                            <b>{!!$season->name!!}</b> [ {!!$season->slug!!} ]
                                                        </div>
                                                        <div class="badge badge-default pull-right bold">
                                                        &nbsp; {!!\App\Order::where('season_id', $season->id)->count()!!} {!!trans('x.Orders')!!} &nbsp;
                                                        </div>
                                                    </div>
                                                </a>
                                                <div class="task-list panel-collapse collapse in" id="task-season-{!!$season->id!!}">
                                                    <ul>

                                                        {{-- LISTINI PREZZI --}}

                                                        <li class="mt-list-item">
                                                            <div class="list-todo-icon bg-white">
                                                                <i class="fa fa-euro"></i>
                                                            </div>
                                                            <div class="list-todo-item yellow">
                                                                <a class="list-toggle-container" data-toggle="collapse" data-parent="#accordion1" onclick=" " href="#task-lists" aria-expanded="false">
                                                                    <div class="list-toggle done">
                                                                        <div class="list-toggle-title bold">
                                                                            {!!trans('x.Price Lists')!!}
                                                                        </div>
                                                                        <div class="badge badge-default pull-right bold">
                                                                            {!!$season->season_lists->count()!!}
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <div class="task-list panel-collapse collapse in" id="task-lists">
                                                                <ul>
                                                                    @foreach ($season->season_lists as $list)
                                                                    <li class="task-list-item done">
                                                                        <div class="task-icon">
                                                                            <a href="javascript:;">
                                                                                <i class="fa fa-credit-card"></i>
                                                                            </a>
                                                                        </div>
                                                                        <div class="task-status">
                                                                            <a class="pending" href="#" data-toggle="modal" data-target="#modal_edit_list{!!$list->id!!}">
                                                                                <i class="fa fa-pencil"></i>
                                                                            </a>
                                                                        </div>
                                                                        <div class="task-content">
                                                                            <h4>
                                                                                <b>{!!$list->name!!}</b> [ {!!$list->slug!!} ]
                                                                            </h4>
                                                                            <p>
                                                                                <strong>
                                                                                    {!!\App\Order::where('season_id', $season->id)
                                                                                                ->where('season_list_id', $list->id)
                                                                                                ->count()!!} 
                                                                                </strong>
                                                                                {!!trans('x.Orders made with this Price List')!!}
                                                                            </p>
                                                                        </div>
                                                                    </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </li>

                                                        {{-- OPZIONI DI PAGAMENTO --}}

                                                        <li class="mt-list-item">
                                                            <div class="list-todo-icon bg-white">
                                                                <i class="fa fa-truck"></i>
                                                            </div>
                                                            <div class="list-todo-item green">
                                                                <a class="list-toggle-container" data-toggle="collapse" data-parent="#accordion1" onclick=" " href="#task-deliveries" aria-expanded="false">
                                                                    <div class="list-toggle done">
                                                                        <div class="list-toggle-title bold">
                                                                            {!!trans('x.Delivery Dates')!!}
                                                                        </div>
                                                                        <div class="badge badge-default pull-right bold">
                                                                            {!!$season->season_deliveries->count()!!}
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <div class="task-list panel-collapse collapse in" id="task-deliveries">
                                                                <ul>
                                                                    @foreach ($season->season_deliveries as $delivery)
                                                                    <li class="task-list-item done">
                                                                        <div class="task-icon">
                                                                            <a href="javascript:;">
                                                                                <i class="fa fa-calendar"></i>
                                                                            </a>
                                                                        </div>
                                                                        <div class="task-status">
                                                                            <a class="pending" href="#" data-toggle="modal" data-target="#modal_edit_delivery{!!$list->id!!}">
                                                                                <i class="fa fa-pencil"></i>
                                                                            </a>
                                                                        </div>
                                                                        <div class="task-content">
                                                                            <h4>
                                                                                <b>{!!$delivery->name!!}</b> [ {!!$delivery->slug!!} ]
                                                                            </h4>
                                                                            <p>
                                                                                <strong>
                                                                                    {!!\App\Order::where('season_id', $season->id)
                                                                                                ->where('season_delivery_id', $delivery->id)
                                                                                                ->count() !!}
                                                                                </strong>
                                                                                {!!trans('x.Orders made with this Delivery Date')!!}
                                                                            </p>
                                                                        </div>
                                                                    </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </li>

                                                    </ul>
                                                    <a class="task-trash" href="javascript:;">
                                                        <div class="task-footer bg-grey">
                                                            <div class="row">
                                                                <div class="col-xs-12">
                                                                        <i class="fa fa-trash"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>   

                                    @endforeach
                                </ul>
                            </div>
                        </div>

                    </div>
                    
                </div>
            </div>

        </div>
    </div>
</div>

{{-- add MODALS --}}

@include('modals.seasons.add_list')
@include('modals.seasons.add_delivery')

@foreach (\App\SeasonList::all() as $list)
    @include('modals.seasons.edit_list')
@endforeach

@foreach (\App\SeasonDelivery::all() as $delivery)
    @include('modals.seasons.edit_delivery')
@endforeach


@stop