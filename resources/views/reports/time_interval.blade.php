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
                        <h2 class="panel-title"><strong>{!! trans('menu.Sold per Creation Date')!!}</strong></h2><br>
                        <div class="clearfix"></div>
                        <p> &nbsp;&nbsp;Nella lista sono indicate solo le date in cui sono stati effettuati ordini</p>
                        <br>
                        <div class="form-group col-md-3">
                            <input type="text" name="date" value="" id="mydates" />
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

                var currentLocale = $('#getcurrentlocale').text();
                var dates_js = {!!json_encode($dates_js)!!};
                console.log(dates_js);

                $.fn.datepicker.dates['it'] = {
                    days: ["Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato"],
                    daysShort: ["Dom", "Lun", "Mar", "Mer", "Gio", "Ven", "Sab"],
                    daysMin: ["Do", "Lu", "Ma", "Me", "Gi", "Ve", "Sa"],
                    months: ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"],
                    monthsShort: ["Gen", "Feb", "Mar", "Apr", "Mag", "Giu", "Lug", "Ago", "Set", "Ott", "Nov", "Dic"],
                    today: "Oggi",
                    clear: "Cancella",
                    format: "dd/mm/yyyy",
                    titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
                    weekStart: 1
                };

                $('#mydates').datepicker({
                    language: currentLocale,
                    beforeShowDay: function (date) {
                        var dt_ddmmyyyy = date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
                        return (dates_js.indexOf(dt_ddmmyyyy) != -1);
                    }, 
                    changeMonth: true, 
                    changeYear: false
                }).on('changeDate', function(e) {

                    the_date = e.date;
                    var yyyy = the_date.getFullYear().toString();
                    var mm = (the_date.getMonth()+1).toString();
                    var dd  = the_date.getDate().toString();
                    var mmChars = mm.split('');
                    var ddChars = dd.split('');
                    var date = yyyy + '-' + (mmChars[1]?mm:"0"+mmChars[0]) + '-' + (ddChars[1]?dd:"0"+ddChars[0]);
                    
                    pageLoadingFrame("show");
                    $(this).datepicker('hide');
                    
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
            
            $(window).load(function(){
                $('#mydates').focus();
            })
        </script>
    </div>

@stop