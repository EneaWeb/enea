&nbsp;&nbsp; <h6>{!!trans('messages.Income per Type')!!}</h6>
<div id="orders-types" style="max-width:200px; max-height:200px; margin-left:auto; margin-right:auto;"></div>

<script>
/*
 * Play with this code and it'll update in the panel opposite.
 *
 * Why not try some of the options above?
 */
$(function() {
	$.getJSON('/api1/stats/orders-types', function(ordersDonut) {
		new Morris.Donut({
			element: 'orders-types',
			data: ordersDonut,
			colors:['#176E29', '#690B58', '#A1A311', '#6B0C68', '#6E6B0F'],
			resize:true,
			formatter: function(x){return Math.round(x).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+' €';},
		});
	});
});
</script>