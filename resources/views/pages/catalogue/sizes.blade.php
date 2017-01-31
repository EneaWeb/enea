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
                            <i class="icon-home"></i> {!!trans('x.Sizes')!!} 
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
                            <span class="caption-subject bold uppercase"> {!!trans('x.Sizes')!!}</span>
                        </div>
                        <div class="btn-group" style="margin-left:20px">
                            <a href="#" data-toggle="modal" data-target="#modal_add_size" class="btn sbold green"> 
                                {!!trans('x.Add New')!!} <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>

                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover ui-sortable" id="sizes-list">
                            <thead>
                                <tr>
                                    <th style="width:20px">{!!trans('x.Reorder')!!}</th>
                                    <th>{!!trans('x.ID')!!}</th>
                                    <th>{!!trans('x.Name')!!}</th>
                                    <th>{!!trans('x.Types')!!} (default)</th>
                                    <th>{!!trans('x.Options')!!}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sizes as $size)
                                    <tr>
                                        <td style="text-align:center; cursor:pointer"><i class="fa fa-bars"></i></td>
                                        <td class="id">{!!$size->id!!}</td>
                                        <td>{!!$size->name!!}</td>
                                        <td>{!!$size->renderTypes()!!}</td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#modal_edit_size{!!$size->id!!}" class="btn btn-danger btn-rounded btn-condensed btn-sm">
                                                <i class="fa fa-pencil"></i>
                                            </a>
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
@include('modals.catalogue.add_size')

@foreach ($sizes as $size)
    @include('modals.catalogue.edit_size')
@endforeach

@stop

@section('pages-scripts')

<script>

	//Helper function to keep table row from collapsing when being sorted
	var fixHelperModified = function(e, tr) {
		var $originals = tr.children();
		var $helper = tr.clone();
		$helper.children().each(function(index)
		{
			$(this).width($originals.eq(index).width())
		});
		return $helper;
	};

    function reorderSizes()
    {
        var ids = [];
        $('#sizes-list tbody tr td:nth-child(2)').each( function(){
        //add item to array
            ids.push($(this).html());
        });

        $.ajax({
            method : "POST",
            url : "/catalogue/size/reorder",
            data : {
                _token : '{!!csrf_token()!!}',
                ids : JSON.stringify(ids)
            }
        })
        .success(function( msg ) {
            toastr.success('{!!trans("x.Sizes reordered")!!}');
        })
        .error(function( msg ) {
            toastr.error('ajax error');
        })
    }

	//Make slides table sortable
	$("#sizes-list tbody").sortable({
		helper: fixHelperModified,
		stop: function(event,ui) {
            reorderSizes();
		}
	}).disableSelection();

    //Delete button in table rows
    $(document).on('click','.btn-delete',function() {
        tableID = '#' + $(this).closest('table').attr('id');
			$(this).closest('tr').remove();
    });

</script>
@stop