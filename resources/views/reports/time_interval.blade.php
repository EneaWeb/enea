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
                        <h2 class="panel-title"><strong>{!! trans('menu.Sold per Time Interval')!!}</strong></h2><br>
                        <div class="clearfix"></div>
                        <p> &nbsp;&nbsp;Nella lista sono indicate solo le date in cui sono stati effettuati ordini</p>
                        <br>
                        <div class="form-group col-md-3">
                            <select id="select-date" class="form-control">
                                <option value="" selected="selected" disabled >Seleziona la data di partenza (inclusa)</option>
                                @foreach ($dates as $date)
                                    <option value="{!!$date!!}">{!!\Carbon\Carbon::parse($date)->format('d-m-Y')!!}</option>
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
                $('#select-date').change(function(){
                    
                    pageLoadingFrame("show");
                    date = $(this).val();
                    
                    $.ajax({
                        method: "POST",
                        url: "/report/select-date",
                        data: { _token: '{!!csrf_token()!!}', date: date }
                    })
                    .done(function( msg ) {
                        pageLoadingFrame("hide");
                        $('#ajax-table-container').html( msg );
                        
                        var currentLocale = $('#getcurrentlocale').text();
                        var myOrderColumn = $('#sold-by-date').find('th:last').index()-2;
                        
                        $('#sold-by-date').DataTable( {
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

                                           return (a + b).toLocaleString('it');
                                        }, 0 );

                                    // Update footer
                                    $( api.column( this ).footer() ).html( total );

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