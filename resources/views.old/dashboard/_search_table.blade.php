<h6>{!!trans('x.Search for a model in all the orders')!!} (autocomplete)</h6><br>
    {!!Form::input(
        'text', 
        'autocomplete',
        '', 
        ['class'=>'form-control ui-autocomplete-input', 'id'=>'products-full-autocomplete', 'placeholder'=>trans('x.Start searching..'), 'style'=>'max-width:500px']
    )!!}
    <br><br>
<div class="table-responsive">
    <div class="dataTables_wrapper no-footer">
        <table id="orders-search" class="table table-responsive table-condensed">
            <thead>
                <tr>
                    <th>{!!trans('x.Id')!!}</th>
                    <th>{!!trans('x.Pieces')!!}</th>
                    <th>{!!trans('x.Customer')!!}</th>
                    <th>{!!trans('x.Agent')!!}</th>
                    <th>{!!trans('x.Options')!!}</th>
                </tr>
            </thead>
            <tbody id="search-table-content">

            </tbody>
        </table>
    </div>
</div>

@foreach ($orders as $order)

@endforeach

<script>
    $( window ).load(function() {
        $.getJSON('/customers/api-products', function(data) {
            $( "#products-full-autocomplete" ).autocomplete({
                source: data,
                select: function(event, ui) {
                    if(ui.item){
                        
                        $.ajax({
                            type: 'GET',
                            data: {
                                'name' : ui.item.value,
                                format: 'json'
                            },
                            url: '/customers/api-products-data',
                            success: function(data) {
                                $('#search-table-content').html(data);
                            },
                            error: function() {
                                console.log('ajax error');
                            }
                        });
                        
                    }
                }
            });
        });
    });
</script>
<br><br><br><br>