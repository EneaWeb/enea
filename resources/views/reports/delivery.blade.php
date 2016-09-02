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
                            'copyHtml5',
                            'excelHtml5',
                            'csvHtml5',
                            'pdf'
                            ],
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