{{--
<ul class="nav nav-pills">
    <li class="{{ Input::get('days') == 7 || Input::get('days') == '' ? 'active' : ''}}">
        <a href="{{ url('stats?days=7') }}">7 Days</a>
    </li>
    <li class="{{ Input::get('days') == 30 ? 'active' : ''}}">
        <a href="{{ url('stats?days=30') }}">30 Days</a>
    </li>
    <li class="{{ Input::get('days') == 60 ? 'active' : ''}}">
        <a href="{{ url('stats?days=60') }}">60 Days</a>
    </li>
    <li class="{{ Input::get('days') == 90 ? 'active' : ''}}">
        <a href="{{ url('stats?days=90') }}">90 Days</a>
    </li>
</ul>
--}}
<div id="orders-line" style="height: 250px;"></div>

<script>

    $(function() {
        filter = '';
        $.getJSON('/api1/stats/orders', function(ordersLine) {
            new Morris.Line({
                // ID of the element in which to draw the chart.
                element: 'orders-line',
                data: ordersLine,
                resize:true,
                lineColors: ['#9C1D00'],
                xkey: 'date',
                ykeys: ['total'],
                labels: ['Tot'],
                xLabelFormat: function(date) {
                    return ("0" + date.getDate()).slice(-2)+'/'+("0" + (date.getMonth() + 1)).slice(-2); 
                },
                yLabelFormat: function(y){return y.formatMoney(0, ',', '.')+' €';},
                dateFormat: function (ts) {
                    var d = new Date(ts);
                    return ("0" + d.getDate()).slice(-2)+'/'+("0" + (d.getMonth() + 1)).slice(-2); 
                }
            });
        });
    });
</script>