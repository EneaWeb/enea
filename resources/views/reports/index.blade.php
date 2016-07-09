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
                        <h3 class="panel-title">DataTable Export</h3>
                        <div class="btn-group pull-right">
                            <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                            <ul class="dropdown-menu">
                                <li><a href="#" onClick ="$('#sold').tableExport({type:'csv',escape:'false'});">
                                    <i class="fa fa-align-left fa-2x" aria-hidden="true"></i> CSV
                                </a></li>
                                <li><a href="#" onClick ="$('#sold').tableExport({type:'txt',escape:'false'});">
                                    <i class="fa fa-file-text-o fa-2x" aria-hidden="true"></i> TXT
                                </a></li>
                                <li><a href="#" onClick ="$('#sold').tableExport({type:'xml',escape:'false'});">
                                    <i class="fa fa-rss fa-2x" aria-hidden="true"></i> XML
                                </a></li>
                                <li class="divider"></li>
                                <li><a href="#" onClick ="$('#sold').tableExport({type:'excel',escape:'false'});">
                                    <i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i> Excel
                                </a></li>
                                <li><a href="#" onClick ="$('#sold').tableExport({type:'doc',escape:'false'});">
                                    <i class="fa fa-file-word-o fa-2x" aria-hidden="true"></i> Word
                                </a></li>
                                <li class="divider"></li>
                                <li><a href="#" onClick ="$('#sold').tableExport({type:'png',escape:'false'});">
                                    <i class="fa fa-file-image-o fa-2x" aria-hidden="true"></i> PNG
                                </a></li>
                                <li><a href="#" onClick ="$('#sold').tableExport({type:'pdf',escape:'false'});">
                                    <i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i> PDF
                                </a></li>
                            </ul>
                        </div>                                    
                        
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="sold" class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th>{!!trans('auth.Picture')!!}</th>
                                        <th>{!!trans('auth.Model')!!}</th>
                                        <th>{!!trans('auth.Product')!!}</th>
                                        <th>{!!trans('auth.Quantity')!!}</th>
                                        <th>{!!trans('auth.Total')!!}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product_ids as $product_id)
                                        <tr>
                                            <td>
                                                <img src="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/300/{!!\App\Product::find($product_id)->picture!!}" style="max-height:70px"/>
                                            </td>
                                            <td>
                                                {!!\App\Product::find($product_id)->prodmodel->name!!}
                                            </td>
                                            <td>
                                                {!!\App\Product::find($product_id)->name!!}
                                            </td>
                                            <td>
                                                {!!\App\OrderDetail::where('product_id', $product_id)->sum('qty')!!}
                                            </td>
                                            <td style="text-align:right">
                                                € {!!number_format(\App\OrderDetail::where('product_id', $product_id)->sum('total_price'), 2, ',', '.')!!}
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
        <script>
            $(document).ready(function() {
                var currentLocale = $('#getcurrentlocale').text();
                $('#sold').DataTable( {
                    "order": [[ 3, "desc" ]],
                    "language": { "url": "/assets/js/plugins/datatables/"+currentLocale+".json" }
                });
            } );
        </script>
    </div>

@stop