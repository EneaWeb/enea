<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Product as Product;
use Input;
use Auth;
use \App\Alert as Alert;
use App\Http\Requests;

class ProductController extends Controller
{
	public function index()
	{
		// get active season value
		$active_season = \App\Option::where('name', 'active_season')->first()->value;
		// query all products for active season
		
		if (Input::has('active'))
			$products = Product::where('season_id', $active_season)->where('active', Input::get('active'))->orderBy('name')->paginate(28);
		else 
			$products = Product::where('season_id', $active_season)->where('active', 1)->orderBy('name')->paginate(28);
		
		// return view
		return view('pages.catalogue.products', compact('products'));
	}
	
	public function manage()
	{
		
		// get active season value
		$active_season = \App\Option::where('name', 'active_season')->first()->value;
		// query all products for active season
		
		if (Input::has('active'))
			$products = Product::where('season_id', $active_season)->where('active', Input::get('active'))->get();
		else 
			$products = Product::where('season_id', $active_season)->where('active', 1)->get();
		
		// return view
		return view('pages.admin.manage_products', compact('products'));
	}
	
	public function create()
	{
		// try to validate the Input
		$v = Product::validate(Input::all());
		
		// if everything ok...
		if ( $v->passes() ) {
			
			// create a new instance
			$product = new Product();
			// populate 
			$product->name = Input::get('name');
			$product->slug = trim(Input::get('slug'));
			$product->description = Input::get('description');
			$product->prodmodel_id = Input::get('prodmodel_id');
			$product->season_id = Input::get('season_id');
			$product->variation_id = Input::get('variation_id');
			$product->picture = 'default.jpg';
			$product->active = 1;
			// setConnection -required- for BRAND DB
			$product->setConnection(Auth::user()->options->brand_in_use->slug);
			// save the line(s)
			$product->save();

			// success message
			Alert::success(trans('messages.Product saved.'));
		
		// if not ok...
		} else {
			
			// prepare error message composed by validation messages
			$messages = ''; foreach($v->messages()->messages() as $error) { $messages .= $error[0].'<br>'; } Alert::error($messages);
		}
		
		// redirect back
		return redirect()->back();
	}
	
	public function show($id)
	{
		$product = Product::find($id);
		return view('pages.catalogue.product', compact('product'));
	}
	
	public function manage_single($id)
	{
		$product = Product::find($id);
		return view('pages.admin.manage_product', compact('product'));
	}
	
	public function edit()
	{
		// try to validate the Input
		$v = Product::validate(Input::all());
		
		// if everything ok...
		if ( $v->passes() ) {
			
		$product = Product::find(Input::get('id'));
		
		$product->name = Input::get('name');
		$product->slug = trim(Input::get('slug'));
		$product->description = Input::get('description');
		$product->prodmodel_id = Input::get('prodmodel_id');
		$product->season_id = Input::get('season_id');
		$product->variation_id = (Input::get('variation_id') != 0) ? Input::get('variation_id') : '';
		$product->active = 1;
		// setConnection -required- for BRAND DB
		$product->setConnection(Auth::user()->options->brand_in_use->slug);
		// save the line(s)
		$product->save();

			// success message
			Alert::success(trans('messages.Product updated'));
		
		// if not ok...
		} else {
			
			// prepare error message composed by validation messages
			$messages = ''; foreach($v->messages()->messages() as $error) { $messages .= $error[0].'<br>'; } Alert::error($messages);
		}
		
		// redirect back
		return redirect()->back();
	}
	
	public function add_color()
	{
		$product = Product::find(Input::get('id'));
		// BRUTALE
		// salvo per ogni taglia una riga di item con il relativo colore
		foreach (\App\Size::all() as $size)
		{

			$item = new \App\Item;
			$item->product_id = Input::get('id');
			$item->color_id = Input::get('color_id');
			$item->size_id = $size->id;
			
			// setConnection -required- for BRAND DB
			$product->setConnection(Auth::user()->options->brand_in_use->slug);
			
			$item->save();

		}
		
		// success message
		Alert::success(trans('messages.Color added'));
		
		return redirect()->back();
	}
	
	public function bulk_update_prices()
	{
		// get product
		$product_id = Input::get('id');
		$product = Product::find($product_id);
		// elimino il product id dall'array
		
		$input = Input::all();
		unset($input['id']);
		
		foreach ($input as $seasonlist_id => $price)
		{
			foreach (\App\Item::where('product_id', $product_id)->get() as $item) {
				
				if (\App\Itemprice::where('item_id', $item->id)->where('season_list_id', $seasonlist_id)->get()->isEmpty()) {
					$itemprice = new \App\ItemPrice;
					$itemprice->item_id = $item->id;
					$itemprice->season_list_id = $seasonlist_id;
					$itemprice->price = number_format($price, 2);
					$itemprice->setConnection(Auth::user()->options->brand_in_use->slug);
					$itemprice->save();
					
				} else {
					$itemprice = \App\Itemprice::where('item_id', $item->id)->where('season_list_id', $seasonlist_id)->first();
					$itemprice->price = number_format($price, 2);
					$itemprice->setConnection(Auth::user()->options->brand_in_use->slug);
					$itemprice->save();
				}

			}
		}

		// success message
		Alert::success(trans('messages.Price updated'));
		// redirect back
		return redirect()->back();
	}
	
	public function add_main_picture()
	{
		// reminder: fare controllo su $size = Input::file('picture')->getSize();
		
		$product_id = Input::get('id');
		
		if (Input::hasFile('picture')) {
			
			$imageFullName = 	$product_id.
									'-'.str_random(4).
									'-'.Input::file('picture')->getClientOriginalName();

			Input::file('picture')->move(
				base_path() . '/public/assets/images/products/'.Auth::user()->options->brand_in_use->slug.'/', $imageFullName
			);
			
			$product = Product::find($product_id);
			$product->picture = $imageFullName;
			$product->setConnection(Auth::user()->options->brand_in_use->slug);
			$product->save();
			
			// success message
			Alert::success(trans('messages.Picture added'));
		
		} else {
			
			Alert::error(trans('Uploading error. Please contact staff'));
			
		}
		
		// redirect back
		return redirect()->back();
	}
	
	public function add_product_picture()
	{
		// reminder: fare controllo su $size = Input::file('picture')->getSize();
		
		$product_id = Input::get('id');
		
		if (Input::hasFile('picture')) {
			
			$imageFullName = 	$product_id.
									'-'.str_random(4).
									'-'.Input::file('picture')->getClientOriginalName();

			Input::file('picture')->move(
				base_path() . '/public/assets/images/products/'.Auth::user()->options->brand_in_use->slug.'/', $imageFullName
			);
			
			$product_picture = new \App\ProductPicture;
			$product_picture->product_id = Input::get('id');
			$product_picture->picture = $imageFullName;
			$product_picture->setConnection(Auth::user()->options->brand_in_use->slug);
			$product_picture->save();
			
			// success message
			Alert::success(trans('messages.Picture added'));
		
		} else {
			
			Alert::error(trans('Uploading error. Please contact staff'));
			
		}
		
		// redirect back
		return redirect()->back();
	}
	
	public function delete_product_picture($id)
	{
		$picture = \App\ProductPicture::find($id);
		$picture->setConnection(Auth::user()->options->brand_in_use->slug);
		$picture->delete();
		
		// success message
		Alert::success(trans('messages.Picture deleted'));
		return redirect()->back();
		
	}
	
}