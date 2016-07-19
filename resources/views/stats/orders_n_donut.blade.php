&nbsp;&nbsp; <h6>N. {!!trans('messages.Orders per List')!!}</h6>
<div id="orders-donut-n" style="max-width:200px; max-height:200px"></div>

<script>
/*
 * Play with this code and it'll update in the panel opposite.
 *
 * Why not try some of the options above?
 */
filter = '';
$.getJSON('/api1/stats/orders-seasonlist-n?'+filter, function(ordersDonut) {
	new Morris.Donut({
		element: 'orders-donut-n',
		data: ordersDonut,
		resize:true,
	});
});
</script>