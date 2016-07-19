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
<div id="stats-container" style="height: 250px;"></div>

<script>
    Number.prototype.formatMoney = function(c, d, t){
    var n = this, 
        c = isNaN(c = Math.abs(c)) ? 2 : c, 
        d = d == undefined ? "." : d, 
        t = t == undefined ? "," : t, 
        s = n < 0 ? "-" : "", 
        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
        j = (j = i.length) > 3 ? j % 3 : 0;
       return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
     };
    $(function() {
        filter = '';
        $.getJSON('/api1/stats/orders?'+filter, function(data) {
            new Morris.Line({
                // ID of the element in which to draw the chart.
                element: 'stats-container',
                data: data,
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