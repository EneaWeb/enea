&nbsp;&nbsp; <h6>{!!trans('messages.Income per List')!!}</h6>
<div id="orders-donut-tot" style="max-width:200px; max-height:200px"></div>

<script>
/*
 * Play with this code and it'll update in the panel opposite.
 *
 * Why not try some of the options above?
 */
filter = '';
$.getJSON('/api1/stats/orders-seasonlist-tot?'+filter, function(ordersDonut) {
	new Morris.Donut({
		element: 'orders-donut-tot',
		data: ordersDonut,
		resize:true,
		formatter: function(x){return Math.round(x).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+' €';},
	});
});
</script>