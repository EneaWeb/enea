&nbsp;&nbsp; <h6>N. {!!trans('messages.Orders per List')!!}</h6>
<div id="orders-donut-n" style="max-width:200px; max-height:200px; margin-left:auto; margin-right:auto;"></div>

<script>
/*
 * Play with this code and it'll update in the panel opposite.
 *
 * Why not try some of the options above?
 */
$(function() {
	$.getJSON('/api1/stats/orders-seasonlist-n', function(ordersDonut) {
		new Morris.Donut({
			element: 'orders-donut-n',
			data: ordersDonut,
			colors:['#7D0C0C', '#236CAA', '#225F0A', '#6B0C68', '#6E6B0F'],
			resize:true,
		});
	});
});
</script>