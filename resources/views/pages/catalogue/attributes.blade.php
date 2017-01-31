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
                            <span class="caption-subject bold uppercase"> {!!trans('x.Attributes')!!}</span>
                        </div>
                        <div class="btn-group" style="margin-left:20px">
                            <a href="#" data-toggle="modal" data-target="#modal_add_attribute" class="btn sbold green"> 
                                {!!trans('x.Add New')!!} <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>

                    <div class="portlet-body">

                        <div class="mt-element-list">

                            <div class="mt-list-container list-todo" id="accordion1" role="tablist" aria-multiselectable="true">
                                <div class="list-todo-line"></div>
                                <ul>
                                    @foreach($attributes as $attr)

                                        <li class="mt-list-item">
                                            <div class="list-todo-icon bg-white">
                                                <i class="fa fa-umbrella"></i>
                                            </div>
                                            <div class="list-todo-item dark">
                                                <a class="list-toggle-container" data-toggle="collapse" data-parent="#accordion1" onclick=" " href="#task-attr-{!!$attr->id!!}" aria-expanded="false">
                                                    <div class="list-toggle done">
                                                        <div class="list-toggle-title">
                                                            <b>{!!$attr->name!!}</b> [ {!!$attr->id!!} ]
                                                        </div>
                                                        <div class="badge badge-default pull-right bold">

                                                        </div>
                                                    </div>
                                                </a>
                                                <div class="task-list panel-collapse collapse in" id="task-attr-{!!$attr->id!!}">
                                                    <ul>

                                                        {{-- TERMS --}}
                                                    
                                                        @foreach ($attr->terms as $term)

                                                        <li class="task-list-item done">
                                                            <div class="task-icon">
                                                                <a class="pending" href="#" data-toggle="modal" data-target="#modal_edit_term{!!$term->id!!}">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                            </div>
                                                            <div class="task-content">
                                                                <h4>
                                                                    @if ($term->hex !== '' && $term->hex !== NULL)
                                                                        <div style="width:20px; height:18px; display:inline-block; float:left; margin-right:10px; background-color:{!!$term->hex!!}"></div>
                                                                    @endif
                                                                    <b>{!!$term->name!!}</b> [ {!!$term->id!!} ]
                                                                </h4>
                                                            </div>
                                                        </li>
                                                        @endforeach

                                                        <li class="task-list-item done">
                                                            <div class="task-footer bg-grey">
                                                                <div class="row">
                                                                    <a class="addterm" href="#" data-toggle="modal" data-attribute_id="{!!$attr->id!!}" data-target="#modal_add_term">
                                                                        <div class="col-xs-6">
                                                                            <i class="fa fa-plus"></i>
                                                                        </div>
                                                                    </a>
                                                                    <a href="#" data-toggle="modal" data-target="#modal_edit_attribute{!!$attr->id!!}">
                                                                        <div class="col-xs-6">
                                                                            <i class="fa fa-pencil"></i>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </li>

                                                    </ul>
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

@include('modals.catalogue.add_attribute')
@include('modals.catalogue.add_term')

@foreach (\App\Attribute::all() as $attr)
    @include('modals.catalogue.edit_attribute')
@endforeach

@foreach (\App\Term::all() as $term)
    @include('modals.catalogue.edit_term')
@endforeach

@stop

@section('pages-scripts')

    <script>

        attrIdField = $('#set_attr_id');
        $('.addterm').on('click', function(){
            attrId = $(this).data('attribute_id');
            attrIdField.val(attrId);
            $('#attribute_show').html(attrId);
        });

        $('.color-selector').colorpicker({ /*options...*/ });

    </script>

@stop