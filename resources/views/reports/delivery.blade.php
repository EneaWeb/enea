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
                        <h2 class="panel-title"><strong>{!! trans('menu.Sold per Delivery Date')!!}</strong></h2>
                        <br><br>
                        <div class="form-group col-md-3">
                            <select id="select-delivery" class="form-control">
                                <option value="" selected="selected" disabled >Seleziona il periodo di consegna</option>
                                @foreach ($season_delivery_ids as $season_delivery_id)
                                    <option value="{!!$season_delivery_id!!}">{!!\App\SeasonDelivery::find($season_delivery_id)->name!!}</option>
                                @endforeach
                            </select>
                        </div>
                        <br><br> 
                    </div>
                    <div class="panel-body" id="ajax-table-container">
                        
                    </div>
                </div>
                
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#select-delivery').change(function(){
                    
                    pageLoadingFrame("show");
                    season_delivery_id = $(this).val();
                    
                    $.ajax({
                        method: "POST",
                        url: "/report/select-delivery",
                        data: { _token: '{!!csrf_token()!!}', season_delivery_id: season_delivery_id }
                    })
                    .done(function( msg ) {
                        pageLoadingFrame("hide");
                        $('#ajax-table-container').html( msg );
                        
                        var currentLocale = $('#getcurrentlocale').text();
                        var myOrderColumn = $('#sold-by-delivery').find('th:last').index()-2;
                        
                        $('#sold-by-delivery').DataTable( {
                            "order": [[ myOrderColumn]],
                            "language": { "url": "/assets/js/plugins/datatables/"+currentLocale+".json" },
                            sScrollX: "100%",
                            paginate: false,
                            bSort: true,
                            deferRender: true,
                            dom: 'Bfrtip',
                            buttons: [
                                {
                                    extend: 'copyHtml5',
                                    footer: 'true'
                                },
                                {
                                    extend: 'excelHtml5',
                                    footer: 'true'
                                },
                                {
                                    extend: 'csvHtml5',
                                    footer: 'true'
                                },
                                {
                                    extend: 'pdf',
                                    footer: 'true'
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

                                           return (a + b).toLocaleString('it');
                                        }, 0 );

                                    // Update footer
                                    // Se è l'ultima colonna, aggiungo il simbolo Euro prima
                                    if ( this.index() == api.column(-1).index() ) {
                                        $( api.column( this ).footer() ).html('€ '+total); 
                                   } else {
                                        $( api.column( this ).footer() ).html( total );
                                   }

                                });
                            }

                        });
                
                    })
                    .fail(function() {
                        alert('ajax error');
                    });
                });
            });

        </script>
    </div>

@stop