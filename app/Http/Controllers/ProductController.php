<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Product as Product;
use Input;
use Auth;
use Image;
use \App\ProductVariation as ProductVariation;
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
			$products = Product::where('season_id', $active_season)->where('active', Input::get('active'))->orderBy('name', 'desc')->paginate(28);
		else 
			$products = Product::where('season_id', $active_season)->where('active', 1)->orderBy('name', 'desc')->paginate(28);
		
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
			$product->type_id = Input::get('type_id');
			$product->season_id = Input::get('season_id');
			$product->has_variations = Input::get('has_variations');
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
		$product->type_id = Input::get('type_id');
		$product->season_id = Input::get('season_id');
		$product->has_variations = Input::get('has_variations');
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
		
		//ATTENZIONE - DA SISTEMARE
		// se bisogna creare delle varianti per ogni prodotto
		if ($product->has_variations == 1){
			// ad ogni colore corrisponde una product_variation
			$product_variation = new ProductVariation;
			$product_variation->product_id = $product->id;
			$product_variation->active = 1;
			$product_variation->picture = 'default.jpg';
			$product_variation->color_id = Input::get('color_id');
			// setConnection -required- for BRAND DB
			$product_variation->setConnection(Auth::user()->options->brand_in_use->slug);
			// save
			$product_variation->save();

			// BRUTALE
			// salvo per ogni taglia una riga di item con il relativo colore
			foreach (\App\Size::all() as $size)
			{
				$item = new \App\Item;
				$item->product_id = Input::get('id');
				$item->product_variation_id = $product_variation->id;
				$item->size_id = $size->id;
				$item->active = 1;
				// setConnection -required- for BRAND DB
				$product->setConnection(Auth::user()->options->brand_in_use->slug);
				// save
				$item->save();
			}
		}

		// success message
		Alert::success(trans('messages.Color added'));
		
		return redirect()->back();
	}
	
	public function bulk_update_prices()
	{
		
		// NOTA ATTENZIONE
		// se non ci sono colori, non crea nulla ma manda messaggio conferma success
		
		// get product
		$product_id = Input::get('id');
		$product = Product::find($product_id);
		// elimino il product id dall'array
		
		// recupero in un array $input tutti i listini=>prezzi
		$input = Input::all();
		// tolgo dall'array l'id del prodotto per tenere solo i listini
		unset($input['id']);
		
		foreach ($input as $seasonlist_id => $price)
		{
			foreach (\App\Item::where('product_id', $product_id)->get() as $item) {
				
				// se non esiste già, devo creare la linea di item_price
				if (\App\ItemPrice::where('item_id', $item->id)
				    	->where('season_list_id', $seasonlist_id)
				    	->get()
				    	->isEmpty() ) {
					$itemprice = new \App\ItemPrice;
					$itemprice->item_id = $item->id;
					$itemprice->season_list_id = $seasonlist_id;
					$itemprice->price = number_format($price, 2);
					// setConnection -required- for BRAND DB
					$itemprice->setConnection(Auth::user()->options->brand_in_use->slug);
					// save
					$itemprice->save();
				// se esiste già la linea, aggiorno il prezzo
				} else {
					$itemprice = \App\Itemprice::where('item_id', $item->id)
										->where('season_list_id', $seasonlist_id)
										->first();
					$itemprice->price = number_format($price, 2);
					// setConnection -required- for BRAND DB
					$itemprice->setConnection(Auth::user()->options->brand_in_use->slug);
					// save
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
									
			$imageUrl = base_path().'/public/assets/images/products/'.Auth::user()->options->brand_in_use->slug.'/';
			// move the original image
			Input::file('picture')->move(	$imageUrl, $imageFullName );
			// make a copy
			$img300 = Image::make($imageUrl.$imageFullName);
			// resize with aspect ration and prevent possible upsizing
			$img300->resize(null, 400, function ($constraint) {
			    $constraint->aspectRatio();
			    $constraint->upsize();
			});
			//save the image as a new file
			$img300->save($imageUrl.'300/'.$imageFullName);
			
			if (Input::get('product_variation_id') == 0) {
				$product = Product::find($product_id);
				$product->picture = $imageFullName;
				//
				$product->setConnection(Auth::user()->options->brand_in_use->slug);
				// save
				$product->save();
			} else {
				$product_variation = ProductVariation::find(Input::get('product_variation_id'));
				$product_variation->picture = $imageFullName;
				//
				$product_variation->setConnection(Auth::user()->options->brand_in_use->slug);
				// save
				$product_variation->save();
			}
			
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

			$imageUrl = base_path().'/public/assets/images/products/'.Auth::user()->options->brand_in_use->slug.'/';
			// move the original image
			Input::file('picture')->move(	$imageUrl, $imageFullName );
			// make a copy
			$img300 = Image::make($imageUrl.$imageFullName);
			// resize with aspect ration and prevent possible upsizing
			$img300->resize(null, 400, function ($constraint) {
			    $constraint->aspectRatio();
			    $constraint->upsize();
			});
			//save the image as a new file
			$img300->save($imageUrl.'300/'.$imageFullName);
			
			if (Input::get('product_variation_id') == 0) {
				$product_picture = new \App\ProductPicture;
				$product_picture->product_id = Input::get('id');
				$product_picture->picture = $imageFullName;
				//
				$product_picture->setConnection(Auth::user()->options->brand_in_use->slug);
				// save
				$product_picture->save();
				// success message
			} else {
				$product_variation_picture = new \App\ProductVariationPicture;
				$product_variation_picture->product_variation_id = Input::get('product_variation_id');
				$product_variation_picture->picture = $imageFullName;
				//
				$product_variation_picture->setConnection(Auth::user()->options->brand_in_use->slug);
				// save
				$product_variation_picture->save();
				// success message
			}
			
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
	
	public function delete_variation_picture($id)
	{
		$picture = \App\ProductVariationPicture::find($id);
		$picture->setConnection(Auth::user()->options->brand_in_use->slug);
		$picture->delete();
		
		// success message
		Alert::success(trans('messages.Picture deleted'));
		return redirect()->back();
		
	}
	
}