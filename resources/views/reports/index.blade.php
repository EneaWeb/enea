@extends('layout.dashboard.main')

@section('more_head')

@stop
@section('more_foot')

@stop

@section('content')                
    <div class="page-content-wrap">
        
        <div class="page-title">                    
            <h2>{!!trans('menu.Report')!!}</h2>
        </div> 

        <div class="row">
            <div class="col-md-12">
            
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title"><strong>{!! trans('messages.Sold by model')!!}</strong></h2>
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
                                                <td>{!!\App\OrderDetail::where('product_id', $product_id)->sum('qty')!!}</td>
                                                <td style="text-align:right">
                                                    € {!!number_format(\App\OrderDetail::where('product_id', $product_id)->sum('total_price'), false, ',', '.')!!}
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
                    bSort: true,
                    deferRender: true,
                    dom: 'Bfrtip',
                    buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdf'
                    ],
                });

            } );
        </script>
    </div>

@stop