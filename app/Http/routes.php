<?php
Route::get('/cust', 'CustomerController@add');
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
Route::get('profile', function(){
	$profile = new \App\Profile;
	$profile->user_id = Auth::user()->id;
	$profile->name = 'Giovanni';
	$profile->surname= 'Cellie';
	$profile->avatar = 'avatar.jpg';
	$profile->save();
});
*/

Route::get('/createuser', function(){
	$user = new \App\User;
	$user->username = '88showroom';
	$user->email = 'milano@88showroom.com';
	$user->password = bcrypt('milano88');
	$user->active = 1;
	$user->save();
	
	$user_profile = new \App\Profile;
	$user_profile->name = 'Francesca';
	$user_profile->user_id = $user->id;
	$user_profile->companyname = '88 Showroom';
	$user_profile->surname = 'Quadrelli';
	$user_profile->avatar = '88showroom.jpg';
	$user_profile->save();
	
	$user->assignRole('agent');
	
	$brand_user = new \App\Brand_User;
	$brand_user->user_id = $user->id;
	$brand_user->brand_id = \App\Option::where('name', 'active_brand')->first()->value;
	$brand_user->save();
	
	$options = new \App\UserOption;
	$option->user_id = $user->id;
	$option->active_brand = \App\Option::where('name', 'active_brand')->first()->value;
	$option->save();
	
	return 'User created.';
});



/*

Route::get('/create-roles', function(){
	$superuser = Spatie\Permission\Models\Role::create(['name' => 'superuser']);
	$admin = Spatie\Permission\Models\Role::create(['name' => 'admin']);
	$manager = Spatie\Permission\Models\Role::create(['name' => 'manager']);
	$agent = Spatie\Permission\Models\Role::create(['name' => 'agent']);
	
	$manage_brands = Spatie\Permission\Models\Permission::create(['name' => 'manage brands']);	
	
	$superuser->givePermissionTo('manage brands');
	$admin->givePermissionTo('manage brands');
	$manager->givePermissionTo('manage brands');
});

*/

/*
*	AUTH // 
*/

Route::get('/order/pdf/{id}', 'PDFController@order_confirmation_view');
Route::get('/order/attachment/{id}', 'PDFController@order_confirmation_download');
Route::get('/email/confirmation/{id}', function($id) {
   $confirm = \App\EneaMail::order_confirmation($id);
});;


Route::group([
	'prefix'     => Localization::setLocale(),
	'middleware' => [
		'web',
		'auth',
		'cors',
	  	'localization-session-redirect',
	  	'localization-redirect',
	],
], function() {
	
	/** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
	Route::get('/test', function() { App\Alert::success('Ciaooo! Provo il successo!!'); return view('test'); });
	
	Route::get('/session/clear', function()
	{
		Session::forget('order');
	});
	
	Route::get('/session', function(){ return dd(Session::all()); });
	Route::get('/logout', 'Auth\AuthController@logout');
	Route::get('/dashboard', 'DashboardController@index');
	Route::get('/profile/edit', 'ProfileController@edit');
	Route::get('/set-locale/{locale_key}', 'DashboardController@set_locale');
	Route::get('/admin/users', 'ManageUsersController@index');
	Route::get('/admin/products', 'ProductController@manage');
	Route::get('/admin/types', 'TypeController@index');
	Route::get('/admin/types/update', 'TypeController@update');
	Route::get('/', function(){
		return redirect('/dashboard');
	});
	Route::get('/customers', 'CustomerController@index');
	Route::get('/customer/show/{id}', 'CustomerController@show');
	Route::get('/customer/delete-delivery/{id}', 'CustomerController@delete_delivery');
	Route::get('/set-current-brand/{brand_id}', 'ProfileController@set_current_brand');
	Route::get('/admin/unlink-user-from-brand/{user_id}', 'ManageUsersController@unlink_user_from_brand');
	Route::get('/admin/payments', 'PaymentController@index');
	Route::get('/admin/payment/edit', 'PaymentController@edit');
	Route::get('/admin/payment/delete/{id}', 'PaymentController@delete');
	Route::get('/catalogue/variations', 'VariationController@index');
	Route::get('/catalogue/attribute-value/delete/{id}', 'AttributeValueController@delete');
	Route::get('/catalogue/seasons', 'SeasonController@index');
	Route::get('/catalogue/season/{id}', 'SeasonController@getSeason');
	Route::get('/catalogue/seasons/delivery/delete-delivery/{id}', 'SeasonDeliveryController@delete');
	Route::get('/catalogue/seasons/delivery/edit', 'SeasonDeliveryController@edit');
	Route::get('/catalogue/seasons/list/delete-list/{id}', 'SeasonListController@delete');
	Route::get('/catalogue/seasons/list/edit', 'SeasonListController@edit');
	Route::get('/catalogue/models/', 'ProdModelController@index');
	Route::get('/catalogue/model/edit', 'ProdModelController@edit');
	Route::get('/catalogue/variation/edit', 'VariationController@edit');
	Route::get('/catalogue/model/delete/{id}', 'ProdModelController@delete');
	Route::get('/catalogue/products/', 'ProductController@index');
	Route::get('/catalogue/product/{id}', 'ProductController@show');
	Route::get('/catalogue/product/edit/{id}', 'ProductController@manage_single');
	Route::get('/catalogue/colors/', 'ColorController@index');
	Route::get('/catalogue/color/delete/{id}', 'ColorController@delete');
	Route::get('/catalogue/color/edit', 'ColorController@edit');
	Route::get('/catalogue/sizes/', 'SizeController@index');
	Route::get('/catalogue/size/delete/{id}', 'SizeController@delete');
	Route::get('/catalogue/size/edit', 'SizeController@edit');
	Route::get('/catalogue/products/add-color', 'ProductController@add_color');
	Route::get('/catalogue/products/bulk-update-prices', 'ProductController@bulk_update_prices');
	Route::get('/catalogue/product/delete-picture/{id}', 'ProductController@delete_product_picture');
	Route::get('/order/new', 'OrderController@create');
	Route::get('/order/new/step2', 'OrderController@step2');
	Route::get('/order/new/step3', 'OrderController@step3');
	Route::get('/order/new/save-order', 'OrderController@step4');
	Route::get('/order/new/confirm', 'OrderController@confirm');
	Route::get('/order/details/{id}', 'OrderController@details');
	Route::get('/order/delete-order/{id}', 'OrderController@delete');
	Route::get('/order/email/{id}', 'OrderController@send_mail');
	Route::get('/catalogue/linesheet/{id}', 'PDFController@linesheet');
	Route::get('/registration/new', 'ManageUsersController@register');

	Route::get('/customizer/cinziaaraia', 'CustomizerController@cinziaaraia_index');
	Route::get('/order/pdf/download/{id}', 'PDFController@order_confirmation_download');
	
	// end localization middleware
});


Route::group([
	'prefix'     => Localization::setLocale(),
	'middleware' => [
		'web',
		'cors',
	  	'localization-session-redirect',
	  	'localization-redirect',
	],
], function() {
	
	Route::get('/login', 'Auth\AuthController@login');
	
});

	Route::post('/authenticate', 'Auth\AuthController@authenticate');
	Route::post('/profile/edit/save', 'Auth\AuthController@profile_edit_save');
	Route::post('/catalogue/attributes/new', 'AttributeController@create');
	Route::post('/catalogue/variations/new', 'VariationController@create');
	Route::post('/catalogue/attribute-values/new', 'AttributeValueController@create');
	Route::post('/catalogue/season/new', 'SeasonController@create');
	Route::post('/catalogue/season/select', 'OptionController@set_active_season');
	Route::post('/catalogue/seasons/change', 'SeasonController@change');
	Route::post('/catalogue/seasons/delivery/new', 'SeasonDeliveryController@create');
	Route::post('/catalogue/seasons/list/new', 'SeasonListController@create');
	Route::post('/admin/payment/new', 'PaymentController@create');
	Route::post('/admin/add-user', 'ManageUsersController@add_user');
	Route::post('/customers/new', 'CustomerController@create');
	Route::post('/customer-delivery/new', 'CustomerDeliveryController@create');
	Route::post('/catalogue/models/new', 'ProdModelController@create');
	Route::post('/catalogue/products/new', 'ProductController@create');
	Route::post('/catalogue/size/new', 'SizeController@create');
	Route::post('/catalogue/colors/new', 'ColorController@create');
	Route::post('/catalogue/product/edit-product', 'ProductController@edit');
	Route::post('/catalogue/products/add-main-picture', 'ProductController@add_main_picture');
	Route::post('/catalogue/products/add-product-picture', 'ProductController@add_product_picture');
	Route::post('/order/new/save-line', 'OrderController@save_line');
	Route::post('/customer/edit-customer', 'CustomerController@edit');
	Route::post('/registration/confirm', 'ManageUsersController@confirm_registration');
	
	Route::post('/customizer/cinziaaraia/rotate', 'CustomizerController@rotate');
	
	Route::get('/customers/api-companyname', function(){
		return \App\Customer::lists('companyname')->toJson();
	});
	Route::get('/customers/api-sign', function(){
		return \App\Customer::lists('sign')->toJson();
	});
	Route::get('/customers/api-customer-data', function(){
		$companyname = Input::get('companyname');
		return \App\Customer::where('companyname', $companyname)->first()->toJson();
	});
	
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


/*

*/