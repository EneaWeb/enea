<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Product as Product;
use Input;
use Auth;
use Image;
use \App\Variation as Variation;
use \App\Alert as Alert;
use App\Http\Requests;

class ProductController extends Controller
{
	public function index(Request $request)
	{
		// get active season value
		$active_season = \App\Option::where('name', 'active_season')->first()->value;
		// query all products for active season
		$type_id = Auth::user()->options->active_type;

		if (Input::has('active')) {
			$products = Product::where('season_id', $active_season)
								->where('active', Input::get('active'))
								->orderBy('type_id', 'asc')
								->orderBy('name', 'asc')
								->get();
		} else {
			$products = Product::where('season_id', $active_season)
								->where('active', 1)
								->orderBy('type_id', 'asc')
								->orderBy('name', 'asc')
								->get();
		}

        // if List is requested, return list view
        if ($request->has('show') && $request->get('show') == 'list')
            return view('pages.catalogue.products_list', compact('products'));

		// return view
		return view('pages.catalogue.products', compact('products'));
	}
	
	public function manage()
	{
		
		// get active season value
		$active_season = \App\Option::where('name', 'active_season')->first()->value;
		// get active type
		$type_id = Auth::user()->options->active_type;

		// query all products for active season
		
		//if (Input::has('active'))
		//	$products = Product::where('season_id', $active_season)->where('type_id', $type_id)->where('active', Input::get('active'))->get();
		//else 
		if ($type_id == 1) {
			$products = Product::where('season_id', $active_season)->where('active', 1)->get();
		} else {
			$products = Product::where('season_id', $active_season)->where('type_id', $type_id)->where('active', 1)->get();
		}

		// return view
		return view('pages.admin.manage_products', compact('products'));
	}

    public function creationMask()
    {
        return view('pages.catalogue.new_product');
    }
	
    public function create(Request $request)
    {

        extract($request->all());

        //return dd($request->all());

        /*
        *
        $variations = [
            0 => [
                terms_id => [
                    0 => {term_id},
                    1 => {term_id}
                    ....
                ],
                sku => (str),
                prices => [
                    {listId} => {price},
                    {listId} => {price},
                    ....
                ],
                sizes => [
                    0 => {sizeId},
                    1 => {sizeId},
                    2 => {sizeId},
                    ....
                ],
            ]
            ..... 
        ]
        *
        */

        $product = new \App\Product;
        $product->prodmodel_id = $prodmodel_id;
        $product->season_id = $season_id;
        $product->type_id = $type_id;
        $product->name = $name;
        $product->sku = $sku;
        $product->description = $description;
        $product->has_variations = $has_variations;
        $product->pictures = 'a:1:{i:0;s:11:"default.jpg";}';
        $product->save();

        foreach ($variations as $v) {
            $variation = new \App\Variation;
            $variation->product_id = $product->id;
            $variation->sku = $v['sku'];
            $variation->pictures = 'a:1:{i:0;s:11:"default.jpg";}';
            $variation->save();

            foreach ($v['terms_id'] as $termId) {
                $termVar = new \App\TermVariation;
                $termVar->variation_id = $variation->id;
                $termVar->term_id = $termId;
                $termVar->save();
            }

            foreach ($v['sizes'] as $k => $size) {
                $item = new \App\Item;
                $item->product_id = $product->id;
                $item->variation_id = $variation->id;
                $item->size_id = $size;
                $item->active = 1;
                $item->save();
                
                foreach ($v['prices'] as $listId => $price) {
                    $itemPrice = new \App\ItemPrice;
                    $itemPrice->item_id = $item->id;
                    $itemPrice->price_list_id = $listId;
                    $itemPrice->price = number_format($price, 2);
                    $itemPrice->save();
                }
            }

        }

        Alert::success(trans('x.Product created'));
        return redirect('/catalogue/products/'.$product->id);

    }

    public function update(Request $request)
    {

        extract($request->all());

        return dd($request->all());

        /*
        *
        $variations = [
            0 => [
                edit => 'true', // or false, if is a new variation
                terms_id => [
                    0 => {term_id},
                    1 => {term_id}
                    ....
                ],
                sku => (str),
                prices => [
                    {listId} => {price},
                    {listId} => {price},
                    ....
                ],
                sizes => [
                    0 => {sizeId},
                    1 => {sizeId},
                    2 => {sizeId},
                    ....
                ],
            ]
            ..... 
        ]
        *
        */

        $product = \App\Product::find($product_id);
        $product->prodmodel_id = $prodmodel_id;
        $product->season_id = $season_id;
        $product->type_id = $type_id;
        $product->name = $name;
        $product->sku = $sku;
        $product->description = $description;
        $product->has_variations = $has_variations;
        $product->pictures = 'a:1:{i:0;s:11:"default.jpg";}';
        $product->save();

        foreach ($variations as $k => $v) {

            if ($v['edit'] !== 'true') {
                $variation = \App\Variation::find($k);
                $variation->sku = $v['sku'];
                $variation->save();
            } else {
                $variation = new \App\Variation;
                $variation->product_id = $product->id;
                $variation->sku = $v['sku'];
                $variation->save();
            }

            foreach ($v['terms_id'] as $termId) {
                
                if ($v['edit'] !== 'true') {
                    $termVar = new \App\TermVariation;
                    $termVar->variation_id = $variation->id;
                    $termVar->term_id = $termId;
                    $termVar->save();
                }
            }

            foreach ($v['sizes'] as $k => $size) {

                if ($v['edit'] !== 'true') {
                    $item = \App\Item::where('variation_id', $variation->id)
                                    ->where('size_id', $size)
                                    ->first();
                } else {
                    $item = new \App\Item;
                    $item->product_id = $product->id;
                    $item->variation_id = $variation->id;
                    $item->size_id = $size;
                    $item->active = 1;
                    $item->save();
                }
                
                foreach ($v['prices'] as $listId => $price) {

                    if ($v['edit'] !== 'true') {
                        $itemPrice = \App\ItemPrice::where('price_list_id', $listId)
                                    ->where('item_id', $item->id)->first();
                        $itemPrice->price = number_format($price, 2);
                        $itemPrice->save();
                    } else {
                        $itemPrice = new \App\ItemPrice;
                        $itemPrice->item_id = $item->id;
                        $itemPrice->price_list_id = $listId;
                        $itemPrice->price = number_format($price, 2);
                        $itemPrice->save();
                    }
                }
            }

        }

        Alert::success(trans('x.Product modified'));
        return redirect('/catalogue/products/'.$product->id);  
    }


	public function xCreate()
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
			Alert::success(trans('x.Product saved.'));
			
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

        /*
        * start check if is deletable
        */

        $deletable = false;
        $orders = \App\Order::whereHas('order_details', function($a) use ($id) {
            $a->whereHas('item', function($q) use($id) {
                $q->where('product_id', $id);
            });
        })->get();

        if ($orders->isEmpty())
            $deletable = true;

        /*
        * end check if is deletable
        */
        
		return view('pages.catalogue.product', compact( 'product', 
                                                        'orders', 
                                                        'orders',
                                                        'deletable'));
	}

	public function preview($id)
	{
		$product = Product::find($id);
		foreach($product->variations as $variation) {
			$pictures_count = $variation->pictures->count();
		}
		$pictures_count += $product->pictures->count();
		$orders = \App\Order::whereHas('order_details', function($q) use ($id) {
			$q->where('product_id', $id);
		})->get();
		return view('pages.catalogue.product_preview', compact('product', 'pictures_count', 'orders'));
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
		Alert::success(trans('x.Product deleted'));
		
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
			Alert::success(trans('x.Product updated'));
		
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
			$product_variation = new Variation;
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
		Alert::success(trans('x.Color added'));
		
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
			foreach ($product->variations()->get() as $product_variation) {
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
			Alert::success(trans('x.Size added'));
			return redirect()->back();
		}

		// success message
		Alert::error(trans('x.Size already exhists'));
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
		Alert::success(trans('x.Price updated'));
		// redirect back
		return redirect()->back();
	}
	
	public function upload_picture(Request $request)
	{
		// reminder: fare controllo su $size = Input::file('picture')->getSize();

		$product_id = $request->get('product_id');
		$variation_id = $request->get('variation_id');
        $type = $request->get('type');
        $picture = $request->file('picture');
        $imageFullName = $product_id.
                            '-'.str_random(4).
                            '-'.str_replace(' ','-',$picture->getClientOriginalName());

        if ($picture == NULL) {
            Alert::error(trans('x.No picture selected'));
            return redirect()->back();
        }

        $imageUrl = base_path().'/public/assets/images/products/'.\App\X::brandInUseSlug().'/';
        // move the original image
        $picture->move(	$imageUrl, $imageFullName );
        // make a copy
        $img300 = Image::make($imageUrl.$imageFullName);
        // resize with aspect ration and prevent possible upsizing
        $img300->resize(null, 400, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        //save the image as a new file
        $img300->save($imageUrl.'300/'.$imageFullName);
        
        if ($type == 'product') {

            $product = \App\Product::find($product_id);
            $product->setConnection(\App\X::brandInUseSlug());
            $product->picture = $imageFullName;
            $product->save();

        } else if ($type == 'variation') {

            $variation = \App\Variation::find($variation_id);
            $variation->setConnection(\App\X::brandInUseSlug());
            $picName = $product->picture;
            $variation->picture = $imageFullName;
            $variation->save();

        } else if ($type == 'variation_picture') {

            $pVarPicture = new \App\VariationPicture;
            $pVarPicture->product_variation_id = $variation_id;
            $pVarPicture->picture = $imageFullName;
            $pVarPicture->setConnection(\App\X::brandInUseSlug());
            $pVarPicture->save();

        }
        
        Alert::success(trans('x.Picture saved'));
		
		// redirect back
		return redirect()->back();
	}
	
	public function delete_product_picture(Request $request)
	{

        $id = $request->get('id');
        $type = $request->get('type');

        if ($type == 'product') {

            $product = \App\Product::find($id);
            $product->setConnection(\App\X::brandInUseSlug());
            $picName = $product->picture;
            $product->picture = 'default.jpg';
            $product->save();

        } else if ($type == 'variation') {

            $variation = \App\Variation::find($id);
            $variation->setConnection(\App\X::brandInUseSlug());
            $picName = $variation->picture;
            $variation->picture = 'default.jpg';
            $variation->save();

        } else if ($type == 'variation_picture') {

            $pVarPicture = \App\VariationPicture::find($id);
            $picName = $pVarPicture->picture;
            $pVarPicture->setConnection(\App\X::brandInUseSlug());
            $pVarPicture->delete();

        }

        $fullUrl = base_path().'/public/assets/images/products/'.\App\X::brandInUseSlug().'/'.$picName;
        unset($fullUrl);

		// success message
		return 'ok';
		
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

    public function createVariations(Request $request)
    {
        $input = $request->get('attributes');
        $attributes = array();
        foreach ($input as $a => $attr) {
            $attributes[] = [ $attr['attribute'] =>  $attr['term'] ];
        }

        $arr = array();
        foreach ($attributes as $k => $v) {
            foreach ($v as $k => $v) {
                $arr[$k][] = $v;
            }
        }

        $variations = \App\X::arrayCartesianProduct($arr);

        return view('pages.catalogue._variations_create', compact('variations'));
    }
	
}