<?php

/*
*	AUTH // 
*/


Route::get('test', function(){
    return serialize(array('default.jpg'));
});

Route::get('total-sold-by-size', function(){

	$sizesIds = \App\Size::lists('id');
	$sizesArray = array();
	foreach ($sizesIds as $k => $v) {
		$sizesArray[$v] = 0;
	}

	foreach(\App\OrderDetail::whereHas('order', function($x){ $x->where('season_id', \App\X::activeSeason()); })->get() as $orderDetail) {
			$sizeId = $orderDetail->item->size_id;
			$qty = $orderDetail->qty;
			$sizesArray[$sizeId] += $qty; 
	}

	return dd($sizesArray);
});

Route::get('test-quantita-totali', function(){
	return 
		'items_qty = '.\App\Order::sum('items_qty').'<br>'.
		'products_qty = '.\App\Order::sum('products_qty').'<br>'.
		'subtotal = '.\App\Order::sum('subtotal').'<br>'.
		'total = '.\App\Order::sum('total').'<br>';
});

Route::get('test-quantita-totali-details', function(){
	return 
		'items_qty = '.\App\OrderDetail::sum('qty').'<br>'.
		'subtotal = '.\App\OrderDetail::sum('price').'<br>'.
		'total = '.\App\OrderDetail::sum('total_price').'<br>';
});

Route::group([
	'prefix'     => Localization::setLocale(),
	'middleware' => [
		'auth',
		'cors',
	  	'localization-session-redirect',
	  	'localization-redirect',
	],
], function() {
	
	/** LOCALIZED ROUTES + AUTH ROUTES **/

	Route::get('pass', function() {
		return bcrypt('test');
	});

	Route::get('/api/order/modal-edit', 'OrderController@modalEdit');
	Route::get('/api/settings/modal-edit', 'PaymentController@modalEdit');

	// changelog
	Route::get('/changelog', function(){ return view('pages.changelog');});

	// root
	Route::get('/dashboard', 'DashboardController@index');
	Route::get('/', function(){ return redirect('/dashboard'); });

	// Working stuff
	Route::get('/session/clear', function() {	Session::forget('order'); });
	Route::get('/session', function(){ return dd(Session::all()); });
	
	// Stats
	Route::get('/api1/stats/orders', 'StatsController@orders');
	Route::get('/api1/stats/orders-seasonlist-n', 'StatsController@orders_seasonlist_n');
	Route::get('/api1/stats/orders-seasonlist-tot', 'StatsController@orders_seasonlist_tot');
	Route::get('/api1/stats/orders-types', 'StatsController@orders_type');
	Route::get('/stats/customize', 'StatsController@customize');
	
	// User Experience
	Route::get('/set-locale/{locale_key}', 'DashboardController@set_locale');
	Route::get('/logout', 'Auth\LoginController@logout');
	Route::get('/profile/edit', 'ProfileController@edit');

	// Customer
	Route::get('/customers', 'CustomerController@index');
	Route::get('/customer/show/{id}', 'CustomerController@show');
	Route::get('/customer/delete-delivery/{id}', 'CustomerController@delete_delivery');

	// Options
	Route::get('/set-current-brand/{brand_id}', 'ProfileController@set_current_brand');
	Route::get('/set-current-type/{type_id}', 'ProfileController@set_current_type');

	// Settings
	Route::get('/settings/users', 'ManageUsersController@index');
	Route::get('/settings/permissions', 'SuperuserController@manage_permissions');
	Route::get('/settings/payments', 'PaymentController@index');
	Route::get('/settings/payment/edit', 'PaymentController@edit');
	Route::get('/settings/payment/delete/{id}', 'PaymentController@delete');

	Route::get('/admin/products', 'ProductController@manage');
	Route::get('/admin/types', 'TypeController@index');
	Route::get('/admin/types/update', 'TypeController@update');
	Route::get('/admin/unlink-user-from-brand/{user_id}', 'ManageUsersController@unlink_user_from_brand');

	// Models
	Route::get('/catalogue/models/', 'ProdModelController@index');
	Route::get('/catalogue/model/edit', 'ProdModelController@edit');
	Route::get('/catalogue/model/delete/{id}', 'ProdModelController@delete');

	// Products
	Route::get('/catalogue/products/', 'ProductController@index');
    Route::get('/catalogue/products/new', 'ProductController@creationMask');
    Route::get('/catalogue/products/update', 'ProductController@update');
    Route::get('/catalogue/products/create-variations', 'ProductController@createVariations');
	Route::get('/catalogue/products/add-color', 'ProductController@add_color');
	Route::get('/catalogue/products/add-size', 'ProductController@add_size');
	Route::get('/catalogue/products/bulk-update-prices', 'ProductController@bulk_update_prices');
	Route::get('/catalogue/products/{id}', 'ProductController@show');
	Route::get('/catalogue/product-preview/{id}', 'ProductController@preview');
	Route::get('/catalogue/product/edit/{id}', 'ProductController@manage_single');
	Route::get('/catalogue/product/delete/{id}', 'ProductController@delete');
	Route::get('/catalogue/product/delete-picture', 'ProductController@delete_product_picture');
	Route::get('/catalogue/attributes', 'AttributeController@index');

	// Attribute Value
	Route::get('/catalogue/attribute-value/delete/{id}', 'AttributeValueController@delete');

	// Colors
	Route::get('/catalogue/colors/', 'ColorController@index');
	Route::get('/catalogue/color/delete/{id}', 'ColorController@delete');
	Route::get('/catalogue/color/edit', 'ColorController@edit');

	// Sizes
	Route::get('/catalogue/sizes/', 'SizeController@index');
	Route::get('/catalogue/size/delete/{id}', 'SizeController@delete');
	Route::get('/catalogue/size/edit', 'SizeController@edit');

	// Variations
	Route::get('/catalogue/variations', 'VariationController@index');
	Route::get('/catalogue/variation/edit', 'VariationController@edit');

	// Linesheet
	Route::get('/catalogue/linesheet/{id}', 'PDFController@linesheet');
	Route::get('/catalogue/linesheet/test/{id}', 'PDFController@linesheet_test');

	// Seasons
	Route::get('/catalogue/seasons', 'SeasonController@index');
	Route::get('/catalogue/seasons/delivery/delete-delivery/{id}', 'SeasonDeliveryController@delete');
	Route::get('/catalogue/seasons/delivery/edit', 'SeasonDeliveryController@edit');
	Route::get('/catalogue/seasons/delivery/delete/{id}', 'SeasonDeliveryController@delete');
	Route::get('/catalogue/seasons/list/delete/{id}', 'SeasonListController@delete');
	Route::get('/catalogue/seasons/list/edit', 'SeasonListController@edit');
	Route::get('/catalogue/season/{id}', 'SeasonController@getSeason');
	Route::get('/catalogue/terms/delete/{id}', 'TermsController@delete');
    

	// Orders
	Route::get('/order/new', 'OrderController@create');
	Route::get('/order/new/step2', 'OrderController@step2');
	Route::get('/order/new/step3', 'OrderController@step3');
	Route::get('/order/new/save-order', 'OrderController@step4');
	Route::get('/order/new/confirm', 'OrderController@confirm');
	Route::get('/order/details/{id}', 'OrderController@details');
	Route::get('/order/edit/{id}', 'OrderController@edit');
	Route::get('/order/delete-order/{id}', 'OrderController@delete');
	Route::get('/order/email/{id}', 'OrderController@send_mail');
	Route::get('/order/pdf/{id}', 'PDFController@order_confirmation_view');
	Route::get('/order/excel/{id}', 'ExcelController@order_confirmation_download');
	Route::get('/order/attachment/{id}', 'PDFController@order_confirmation_download');

	// Report
	Route::get('/report/products', 'ReportController@index');
	Route::get('/report/variations', 'ReportController@sold_variations');
	Route::get('/report/delivery', 'ReportController@sold_delivery');
	Route::get('/report/time-interval', 'ReportController@time_interval');
	Route::get('/report/zero-sold', 'ReportController@zero_sold');
	Route::get('/report/stats', 'ReportController@stats');

	// Customizer
	Route::get('/customizer/cinziaaraia', 'CustomizerController@cinziaaraia_index');
	Route::get('/order/pdf/download/{id}', 'PDFController@order_confirmation_download');

});


Route::group([
	'prefix'     => Localization::setLocale(),
	'middleware' => [
		'cors',
	  	'localization-session-redirect',
	  	'localization-redirect',
	],
], function() {

    // License 
    Route::get('/license', function(){ return view('pages.license');});

	/** LOCALIZED ROUTES - NO AUTH **/
	
	Route::get('/login', 'Auth\LoginController@login');
	Route::get('/registration/confirm', 'ManageUsersController@register');
	
});

	/** POST ROUTES **/

	Route::post('/authenticate', 'Auth\LoginController@authenticate');
	Route::post('/profile/edit/save', 'Auth\LoginController@profile_edit_save');
	Route::post('/catalogue/variations/new', 'VariationController@create');
	Route::post('/catalogue/attributes/new', 'AttributeController@create');
	Route::post('/catalogue/attributes/edit', 'AttributeController@edit');
	Route::post('/catalogue/terms/new', 'TermsController@create');
	Route::post('/catalogue/terms/edit', 'TermsController@edit');
	Route::post('/catalogue/seasons/new', 'SeasonController@create');
	Route::post('/catalogue/season/select', 'OptionController@set_active_season');
	Route::post('/catalogue/seasons/change', 'SeasonController@change');
	Route::post('/catalogue/seasons/delivery/new', 'SeasonDeliveryController@create');
	Route::post('/catalogue/seasons/list/new', 'SeasonListController@create');
	Route::post('/catalogue/size/new', 'SizeController@create');
	Route::post('/catalogue/size/edit', 'SizeController@edit');
	Route::post('/catalogue/size/reorder', 'SizeController@reorder');
	Route::post('/admin/payment/new', 'PaymentController@create');
	Route::post('/admin/add-user', 'ManageUsersController@add_user');
	Route::post('/customers/new', 'CustomerController@create');
	Route::post('/customer-delivery/new', 'CustomerDeliveryController@create');
	Route::post('/catalogue/models/new', 'ProdModelController@create');
	Route::post('/catalogue/products/new', 'ProductController@create');
	Route::post('/catalogue/colors/new', 'ColorController@create');
	Route::post('/catalogue/product/edit-product', 'ProductController@edit');
	/*
    Route::post('/catalogue/products/add-main-picture', 'ProductController@add_main_picture');
	Route::post('/catalogue/products/add-product-picture', 'ProductController@add_product_picture');
    */
    Route::post('/catalogue/products/upload-picture', 'ProductController@upload_picture');
    
	Route::post('/catalogue/products/edit-single-prices', 'ProductController@edit_single_prices');
	Route::post('/order/new/save-line', 'OrderController@save_line');
	Route::post('/customer/edit-customer', 'CustomerController@edit');
	Route::post('/registration/confirm-registration', 'ManageUsersController@confirm_registration');
	Route::post('/profile/change-password', 'ManageUsersController@change_password');
	Route::post('/proforma/pdf/download/{id}', 'PDFController@proforma');
	Route::post('/invoice/pdf/download/{id}', 'PDFController@invoice');
	Route::post('/waybill/pdf/download/{id}', 'PDFController@waybill');
	Route::post('/save-manage-permissions', 'SuperuserController@save_manage_permissions');
	Route::post('/stats/add-chart', 'StatsController@add_chart');

	
	Route::post('/customizer/cinziaaraia/rotate', 'CustomizerController@rotate');
	
	Route::get('/customers/api-companyname', function(){
		return \App\Brand::find(Auth::user()->options->brand_in_use->id)->customers()->pluck('companyname')->toJson();
	});
	Route::get('/customers/api-sign', function(){
		return \App\Brand::find(Auth::user()->options->brand_in_use->id)->customers()->pluck('sign')->toJson();
	});

	Route::get('/customers/api-products', function(){
		$export = array();
		foreach (\App\Variation::all() as $var) {
			$export[$var->id] = $var->product->prodmodel->name.' '.$var->product->name.' '.$var->color->name;
		}
		Session::put('all_variations', $export);
		$export = json_encode(array_values($export));
		return $export;
	});

	Route::get('/customers/api-products-data', function(){
		$array = Session::get('all_variations');
		$export = '';
		$variation_id = array_search(Input::get('name'), $array);
		foreach (\App\OrderDetail::where('product_variation_id', $variation_id)->groupBy('order_id')->orderBy('order_id', 'desc')->get() as $details) {
			$export .= '<tr><td><a href="/order/pdf/'.$details->order_id.'" target="_blank">'.$details->order_id.'</td>'.
							'<td>'.\App\OrderDetail::where('order_id', $details->order_id)->where('product_variation_id', $variation_id)->sum('qty').'</td>'.
							'<td><a href="/customer/show/'.$details->order->customer_id.'" >'.$details->order->customer->companyname.'</a></td>'.
							'<td>'.$details->order->user->profile->companyname.'</td>'.
							'<td><a href="#" data-toggle="modal" data-target="#modal_edit" data-order_id="'.$details->order_id.'" class="btn btn-sm"><span class="fa fa-cogs"></span></a></td></tr>';
		}
		$export .= '<tr><td></td><td><b>'.\App\OrderDetail::where('product_variation_id', $variation_id)->sum('qty').' Tot. </b></td>'.
						'<td></td><td></td><td></td>';
		return $export;
	});

	Route::get('/customers/api-customer-data', function(){
		$companyname = Input::get('companyname');
		return \App\Customer::where('companyname', $companyname)->first()->toJson();
	});
	
	Route::post('/add-lines/api-product-id', 'ProductController@api_product_id');
	
	Route::post('/report/select-delivery', 'ReportController@select_delivery');
	Route::post('/report/select-date', 'ReportController@select_date');
	
	Route::post('/minimize-maximize', function()
	{ // menu minimize-maximize session variable
		$x = 'minimized';
		if (!Session::has($x))
			Session::put($x, '1');
		else {
			if (Session::get($x) == '1')
				Session::forget($x);
			else 
				Session::put($x, '1');
		}
	});
	
	Route::get('/list-gallery', function()
	{ // menu minimize-maximize session variable
		$x = 'list';
		if (!Session::has($x))
			Session::put($x, '1');
		else {
			if (Session::get($x) == '1')
				Session::forget($x);
			else 
				Session::put($x, '1');
		}
		return redirect()->back();
	});

/*

*/