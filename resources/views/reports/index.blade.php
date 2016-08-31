@extends('layout.dashboard.main')

@section('more_head')

@stop
@section('more_foot')

@stop

@section('content')                
    <div class="page-content-wrap">
        
        <div class="page-title">                    
            <h2>{!!trans('menu.Report')!!}</h2>
            <span style="float:right">
                <a href="/"><button class="btn btn-warning">//</button></a>
            </span>
        </div> 

        <div class="row">
            <div class="col-md-12">
            
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title"><strong>{!! trans('messages.Sold by model')!!}</strong></h2>
                        <div class="btn-group pull-right">
                            <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                            <ul class="dropdown-menu">
                                <li><a href="#" onClick ="$('#sold-by-item').tableExport({type:'csv',escape:'false'});">
                                    <i class="fa fa-align-left fa-2x" aria-hidden="true"></i> CSV
                                </a></li>
                                <li><a href="#" onClick ="$('#sold-by-item').tableExport({type:'txt',escape:'false'});">
                                    <i class="fa fa-file-text-o fa-2x" aria-hidden="true"></i> TXT
                                </a></li>
                                <li><a href="#" onClick ="$('#sold-by-item').tableExport({type:'xml',escape:'false'});">
                                    <i class="fa fa-rss fa-2x" aria-hidden="true"></i> XML
                                </a></li>
                                <li class="divider"></li>
                                <li><a href="#" onClick ="$('#sold-by-item').tableExport({type:'excel',escape:'false'});">
                                    <i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i> Excel
                                </a></li>
                                <li><a href="#" onClick ="$('#sold-by-item').tableExport({type:'doc',escape:'false'});">
                                    <i class="fa fa-file-word-o fa-2x" aria-hidden="true"></i> Word
                                </a></li>
                                <li class="divider"></li>
                                <li><a href="#" onClick ="$('#sold-by-item').tableExport({type:'png',escape:'false'});">
                                    <i class="fa fa-file-image-o fa-2x" aria-hidden="true"></i> PNG
                                </a></li>
                                <li><a href="#" onClick ="$('#sold-by-item').tableExport({type:'pdf',escape:'false'});">
                                    <i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i> PDF
                                </a></li>
                            </ul>
                        </div>                                    
                        
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <div class="dataTables_wrapper no-footer">
                                <table id="sold-by-item" class="table table-responsive table-condensed">
                                    <thead>
                                        <tr>
                                            <th>{!!trans('auth.Picture')!!}</th>
                                            <th>{!!trans('auth.Model')!!}</th>
                                            @foreach (\App\Size::all() as $size)
                                                <th>{!!$size->name!!}</th>
                                            @endforeach
                                            <th>{!!trans('auth.Qty')!!}</th>
                                            <th>{!!trans('auth.Total')!!}</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            @foreach (\App\Size::all() as $size)
                                                <th></th>
                                            @endforeach
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($product_ids as $product_id)
                                            <tr>
                                                <td>
                                                    <a href="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/{!!\App\Product::find($product_id)->picture!!}" data-toggle="lightbox">
                                                        <img src="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/300/{!!\App\Product::find($product_id)->picture!!}" style="max-height:50px"/>
                                                    </a>
                                                </td>
                                                <td>
                                                    <strong>
                                                        {!!\App\Product::find($product_id)->prodmodel->name!!} {!!\App\Product::find($product_id)->name!!}
                                                    </strong>
                                                </td>
                                                @foreach (\App\Size::all() as $size)
                                                    <td>{!!
                                                        \App\OrderDetail::where('product_id', $product_id)
                                                            ->whereHas('item', function($query) use ($size) {
                                                            $query->where('items.size_id', '=', $size->id);
                                                        })->sum('qty');
                                                    !!}</td>
                                                @endforeach
                                                <th>{!!\App\OrderDetail::where('product_id', $product_id)->sum('qty')!!}</th>
                                                <th style="text-align:right">
                                                    € {!!number_format(\App\OrderDetail::where('product_id', $product_id)->sum('total_price'), false, ',', '.')!!}
                                                </th>
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
        <script>
            $(document).ready(function() {
                
                var currentLocale = $('#getcurrentlocale').text();
                var lastColumn = $('#sold-by-item').find('th:last').index();
                var lastColumnMinusOne = lastColumn-1;
                
                $('#sold-by-item').DataTable( {
                    "order": [[ lastColumnMinusOne, "desc" ]],
                    "language": { "url": "/assets/js/plugins/datatables/"+currentLocale+".json" },
                    sScrollX: "100%",
                    paginate: false,
                    bSort: false
                });
                
                       var currentLocale = $('#getcurrentlocale').text();
                        var myOrderColumn = $('#sold-by-delivery').find('th:last').index()-2;
                        
                        $('#sold-by-delivery').DataTable( {
                            "order": [[ myOrderColumn]],
                            "language": { "url": "/assets/js/plugins/datatables/"+currentLocale+".json" },
                            sScrollX: "100%",
                            paginate: false,
                            bSort: true
                        });
                       
            } );
        </script>
    </div>

@stop