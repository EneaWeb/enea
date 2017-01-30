@extends('layout.dashboard.main')

@section('more_head')

@stop
@section('more_foot')

@stop

@section('content')                
    <div class="page-content-wrap">
        
        <div class="page-title">                    
            <h2>{!!trans('x.Report')!!}</h2>
        </div> 

        <div class="row">
            <div class="col-md-12">
            
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title"><strong>{!! trans('x.Sold by model')!!}</strong></h2>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <div class="dataTables_wrapper no-footer">
                                <table id="sold-by-item" class="table table-responsive table-condensed">
                                    <thead>
                                        <tr>
                                            <th>{!!trans('x.Picture')!!}</th>
                                            <th class="export">{!!trans('x.Model')!!}</th>
                                            @foreach (\App\Size::orderBy('name')->get() as $size)
                                                <th class="sum export">{!!$size->name!!}</th>
                                            @endforeach
                                            <th class="sum export">{!!trans('x.Qty')!!}</th>
                                            <th class="sum export">{!!trans('x.Undiscounted')!!}</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            @foreach (\App\Size::orderBy('name')->get() as $size)
                                                <th style="text-align:center"></th>
                                            @endforeach
                                            <th></th>
                                            <th style="text-align:right!important"></th>
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
                                                    <strong>{!!\App\Product::find($product_id)->prodmodel->name!!} {!!\App\Product::find($product_id)->name!!}</strong>
                                                </td>
                                                @foreach (\App\Size::orderBy('name')->get() as $size)
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
                        {
                            extend: 'copyHtml5',
                            footer: 'true',
                            exportOptions: {
                                columns: '.export'
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            footer: 'true',
                            exportOptions: {
                                columns: '.export'
                            }
                        },
                        {
                            extend: 'excel',
                            footer: 'true',
                            text: 'Excel [Safari]',
                            exportOptions: {
                                columns: '.export'
                            }
                        },
                        {
                            extend: 'csvHtml5',
                            footer: 'true',
                            exportOptions: {
                                columns: '.export'
                            }
                        },
                        {
                            extend: 'pdf',
                            footer: 'true',
                            exportOptions: {
                                columns: '.export'
                            }
                        },
                    ],
                    "footerCallback": function ( row, data, start, end, display ) {
                        var api = this.api(), data;
                        
                        api.columns('.sum').every(function(){
                            var column = this;
                            // Total over all pages
                            total = api
                                .column( this, { page: 'current'} ) // rimuovi { page: 'current'} per ottenere il totale totale fisso
                                .data()
                                .reduce( function (a, b) {
                                   a = parseFloat(a.toString().replace('€ ','').replace('.',''), 10);
                                   if(isNaN(a)){ a = 0; }       

                                   b = parseFloat(b.toString().replace('€ ','').replace('.',''), 10);
                                   if(isNaN(b)){ b = 0; }

                                   return new Number(a + b);
                                }, 0 );

                            // Update footer
                            // Se è l'ultima colonna, aggiungo il simbolo Euro prima
                            if ( this.index() == api.column(-1).index() ) {
                                $( api.column( this ).footer() ).html('€ '+total.toLocaleString('it')); 
                           } else {
                                $( api.column( this ).footer() ).html( total.toLocaleString('it') );
                           }

                        });
                    }

                });

            });
        </script>
    </div>

@stop