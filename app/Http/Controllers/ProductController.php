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
		$type_id = Auth::user()->options->active_type;

		if (Input::has('active')) {
			if ($type_id == 1 || $type_id == 0) {
				$products = Product::where('season_id', $active_season)->where('active', Input::get('active'))->orderBy('name', 'desc')->paginate(32);
			} else {
				$products = Product::where('season_id', $active_season)->where('type_id', $type_id)->where('active', Input::get('active'))->orderBy('name', 'desc')->paginate(32);
			}
		}
		else {
			if ($type_id == 1 || $type_id == 0) {
				$products = Product::where('season_id', $active_season)->where('active', 1)->orderBy('name', 'desc')->paginate(32);
			} else {
				$products = Product::where('season_id', $active_season)->where('type_id', $type_id)->where('active', 1)->orderBy('name', 'desc')->paginate(32);
			}
			
		}
		
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
			
			return redirect('/catalogue/product/edit/'.$product->id);
		
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

	public function edit_single_prices()
	{
		$array = Input::all();
		unset($array['_token']);
		// get season_list_id
		$season_list_id = $array['season_list_id'];
		unset($array['season_list_id']);

		foreach ($array as $k => $val) {

			// verifico se esistono itemprices con quei parametri
			$price_test = \App\ItemPrice::where('item_id', $k)->where('season_list_id', $season_list_id)->get();
			// se non esiste
			if ($price_test->isEmpty()) {
				// Creo un nuovo record, inserisco i dati e salvo.
				$itemprice = new \App\ItemPrice;
				$itemprice->item_id = $k;
				$itemprice->season_list_id = $season_list_id;
				$itemprice->price = str_replace(',','.',$val);
				$itemprice->save();
				//return 'case 1 itemprice '.$itemprice;
				// se esiste
			} else {
				// recupero la linea e aggiorno i dati. salvo.
				$itemprice = \App\ItemPrice::where('item_id', $k)->where('season_list_id', $season_list_id)->first();
				$itemprice->price = str_replace(',','.',$val);
				$itemprice->save();
				//return 'case 2 itemprice '.$itemprice;

			}
		}

		Alert::success('Prezzi aggiornati');
		return redirect()->back();

	}
	
	public function delete($id)
	{
		$product = Product::find($id);
		$product->delete();
		
		// success message
		Alert::success(trans('messages.Product deleted'));
		
		return redirect()->back();
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
			foreach (\App\Size::sizes_for_type($product) as $size)
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

	public function add_size()
	{
		$product_id = Input::get('product_id');
		$product  = \App\Product::find($product_id);
		$size_id = Input::get('size_id');
		// verifico che non esistano già gli items con questa taglia
		$product_has_items = \App\Item::where('product_id', $product_id)->where('size_id', $size_id)->get();

		// se non ha items con quella taglia
		if ($product_has_items->isEmpty()) {
			foreach ($product->variations() as $product_variation) {
				$newItem = new \App\Item;
				$newItem->product_id = $product_id;
				$newItem->product_variation_id = $product_variation->id;
				$newItem->size_id = $size_id;
				$newItem->active = 1;
				// setConnection -required- for BRAND DB
				$newItem->setConnection(Auth::user()->options->brand_in_use->slug);
				$newItem->save();
			}
			// success message
			Alert::success(trans('messages.Size added'));
			return redirect()->back();
		}

		// success message
		Alert::error(trans('messages.Size already exhists'));
		return redirect()->back();

	}
	
	public function bulk_update_prices()
	{
		
		// NOTA ATTENZIONE
		// da fixare:
		// se non ci sono colori o non ci sono le taglie non crea nulla ma manda messaggio conferma success
		
		// TERRIBILE
		// da fixare:
		// mi fa aggiungere colori anche se non ci sono taglie => creazione items risulta nulla
		// => non posso aggiungere prezzi.. un casino
		
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

			if ($price != '') {
				
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
	
	public function api_product_id()
	{
		if (!Input::has('product_id'))
			return 'no product_id found in request';
		// retrieve data from add_lines jquery call during the step3 order process
		$product_id = Input::get('product_id');
		$product = \App\Product::find($product_id);
		
		return view('pages.orders._modal_add_lines', compact('product'));
		
	}
	
}