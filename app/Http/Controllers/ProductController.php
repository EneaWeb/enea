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
use Storage;

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
        $pictures = [
            0 => {fileName},
            1 => {fileName},
            2 => {fileName}
            ....
        ]
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
                pictures => [
                    0 => {fileName},
                    1 => {fileName},
                    2 => {fileName},
                    ....
                ]
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
        // get pictures
        $pictures = $request->get('pictures');
        $product->pictures = ($pictures == NULL || empty($pictures)) ? 'a:1:{i:0;s:11:"default.jpg";}' : serialize($pictures);
        // prepare and save
        $product->prepare();
        $product->save();

        foreach ($variations as $v) {
            $variation = new \App\Variation;
            $variation->product_id = $product->id;
            $variation->sku = $v['sku'];
            // get pictures
            $pictures = $v['pictures'];
            $variation->pictures = ($pictures == NULL || empty($pictures)) ? 'a:1:{i:0;s:11:"default.jpg";}' : serialize($pictures);
            // prepare and save
            $variation->prepare();
            $variation->save();

            foreach ($v['terms_id'] as $termId) {
                $termVar = new \App\TermVariation;
                $termVar->variation_id = $variation->id;
                $termVar->term_id = $termId;
                $termVar->prepare();
                $termVar->save();
            }

            foreach ($v['sizes'] as $k => $size) {
                $item = new \App\Item;
                $item->product_id = $product->id;
                $item->variation_id = $variation->id;
                $item->size_id = $size;
                $item->active = 1;
                $item->prepare();
                $item->save();
                
                foreach ($v['prices'] as $listId => $price) {
                    $itemPrice = new \App\ItemPrice;
                    $itemPrice->item_id = $item->id;
                    $itemPrice->price_list_id = $listId;
                    $itemPrice->price = number_format($price, 2);
                    $itemPrice->prepare();
                    $itemPrice->save();
                }
            }

        }

        // log creation
        $product->log('C');

        Alert::success(trans('x.Product created'));
        return redirect('/catalogue/products/'.$product->id);

    }

    public function update(Request $request)
    {

        extract($request->all());

        // debug
        //return dd($request->all());

        /*
        *
        delete-variation = [
            0 => {variationId_toDelete},
            1 => {variationId_toDelete}
            ...
        ],
        $pictures = [
            0 => {fileName},
            1 => {fileName},
            2 => {fileName}
            ....
        ]
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
                pictures => [
                    0 => {fileName},
                    1 => {fileName},
                    2 => {fileName},
                    ....
                ]
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
        // get pictures
        $pictures = $request->get('pictures');
        $product->pictures = ($pictures == NULL || empty($pictures)) ? 'a:1:{i:0;s:11:"default.jpg";}' : serialize($pictures);
        // save
        $product->prepare();
        $product->save();

        // if we have to delete variations
        if ($request->has('delete_variation')) {
            foreach ($delete_variation as $k => $variationId) {
                // if there are no orders with that variation
                if (\App\OrderDetail::where('variation_id', $variationId)->get()->isEmpty()) {
                    // delete variation from DB
                    \App\Variation::find($variationId)->delete();
                    // delete all term_variation associations
                    \App\TermVariation::where('variation_id', $variationId)->delete();
                    // loop through items
                    foreach (\App\Item::where('variation_id', $variationId)->first() as $varItem) {
                        // delete all item prices
                        foreach ($varItem->prices() as $varItemPrice) {
                            $varItemPrice->prepare();
                            $varItemPrice->delete();
                        }
                        $varItem->prepare();
                        $varItem->delete();
                    }
                }
            }
        }

        foreach ($variations as $k => $v) {

            // if is edited
            if ($v['edit'] === 'true') {
                // get variation object
                $variation = \App\Variation::find($k);
                // update SKU
                $variation->sku = $v['sku'];
                // get pictures
                $pictures = $v['pictures'];
                $variation->pictures = ($pictures == NULL || empty($pictures)) ? 'a:1:{i:0;s:11:"default.jpg";}' : serialize($pictures);
                
                // save
                $variation->prepare();
                $variation->save();

            // if is a new variation
            } else {

                // create variation object and store to db
                $variation = new \App\Variation;
                $variation->product_id = $product->id;
                $variation->sku = $v['sku'];
                // get pictures
                $pictures = $v['pictures'];
                $variation->pictures = ($pictures == NULL || empty($pictures)) ? 'a:1:{i:0;s:11:"default.jpg";}' : serialize($pictures);
                // save
                $variation->prepare();
                $variation->save();

                // for each variation term
                foreach ($v['terms_id'] as $termId) {
                    // create term_variation association and store to db
                    $termVar = new \App\TermVariation;
                    $termVar->variation_id = $variation->id;
                    $termVar->term_id = $termId;
                    $termVar->prepare();
                    $termVar->save();
                }
            }

            // for each variation size
            foreach ($v['sizes'] as $k => $size) {

                // check if the size has already items (so if is not a NEW added size)
                $noSize = \App\Item::where('variation_id', $variation->id)
                                    ->where('size_id', $size)->get()->isEmpty();

                // if is a new size, or we are creating a brand new variation
                if ($noSize || $v['edit'] !== 'true') {
                    // create item object and store to db
                    $item = new \App\Item;
                    $item->product_id = $product->id;
                    $item->variation_id = $variation->id;
                    $item->size_id = $size;
                    $item->active = 1;
                    $item->prepare();
                    $item->save();

                    // for each price list (so for each price to store)
                    foreach ($v['prices'] as $listId => $price) {
                        // create itemPrice object and store to db
                        $itemPrice = new \App\ItemPrice;
                        $itemPrice->item_id = $item->id;
                        $itemPrice->price_list_id = $listId;
                        $itemPrice->price = number_format($price, 2);
                        $itemPrice->prepare();
                        $itemPrice->save();
                    }
                
                // if the size is already knowk
                } else {
                    // get size object
                    $item = \App\Item::where('variation_id', $variation->id)
                                    ->where('size_id', $size)->first();
                    // update all prices
                    foreach ($v['prices'] as $listId => $price) {
                        $itemPrice = \App\ItemPrice::where('price_list_id', $listId)
                                    ->where('item_id', $item->id)->first();
                        $itemPrice->price = number_format($price, 2);
                        $itemPrice->prepare();
                        $itemPrice->save();
                    }
                }
            }

            // check if there are LESS sizes then original, so some size is deletable
            $deletableSizes = array_diff($variation->getSizesArray(), $v['sizes']);
            if (!empty($deletableSizes)) 
            {
                // loop through deletable sizes
                foreach ($deletableSizes as $sizeId)
                {
                    // get correspondente item object
                    $itemToDelete = \App\Item::where('variation_id', $variation->id)
                                            ->where('size_id', $sizeId)->first();
                    // if there are not orders with this Item
                    if (\App\OrderDetail::where('item_id', $itemToDelete->id)->get()->isEmpty()) {
                        // delete orrespondent prices
                        foreach ($itemToDelete->prices() as $varItemPrice) {
                            $varItemPrice->prepare();
                            $varItemPrice->delete();
                        }
                        // delete item
                        $itemToDelete->prepare();
                        $itemToDelete->delete();
                    }
                }
            }
        }

        // log update
        $product->log('U');

        Alert::success(trans('x.Product updated'));
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
			$product->prepare();
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
				$itemprice->prepare();
				$itemprice->save();
				//return 'case 1 itemprice '.$itemprice;
				// se esiste
			} else {
				// recupero la linea e aggiorno i dati. salvo.
				$itemprice = \App\ItemPrice::where('item_id', $k)->where('season_list_id', $season_list_id)->first();
				$itemprice->price = str_replace(',','.',$val);
				$itemprice->prepare();
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
		$product->prepare();
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
		$product->prepare();
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
			$product_variation->prepare();
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
				$product_variation->prepare();
				// save
				$item->prepare();
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
				$newItem->prepare();
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
						$itemprice->prepare();
						// save
						$itemprice->save();
					// se esiste già la linea, aggiorno il prezzo
					} else {
						$itemprice = \App\Itemprice::where('item_id', $item->id)
											->where('season_list_id', $seasonlist_id)
											->first();
						$itemprice->price = number_format($price, 2);
						// setConnection -required- for BRAND DB
						$itemprice->prepare();
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

        // get file object
        $image = $request->file('file');

        // get correct path for uploading : /{products}/{brand_slug}/
        $path = '/products/'.\App\X::brandInUseSlug().'/';

        // get file extension
        $ext = $image->getClientOriginalExtension();

        // create new unique filename for the storage, composed as:
        // {originalName}-{random5str}.{ext}
        $fileName = str_replace(' ','-',str_replace('.'.$ext,'',$image->getClientOriginalName())).'-'.str_random(5).'.'.$ext;
        
        // check if file is an image
        if(substr($image->getMimeType(), 0, 5) !== 'image') {
            return 'not an image';
        }

        // create Image instance for 2000 x 2000 picture
        $image_normal = Image::make($image)->resize(null, 2000, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        // create Image instance for 400 x 400 picture
        $image_thumb = Image::make($image)->resize(null, 400, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        // save 2000 x 2000 to Filesystem
        $image_normal = $image_normal->stream();
        Storage::disk('s3')->put($path.$fileName, $image_normal->__toString());

        // save 400 x 400 to Filesystem
        $image_thumb = $image_thumb->stream();
        Storage::disk('s3')->put($path.'400/'.$fileName, $image_thumb->__toString());

        // return filename of uploaded file
        return $fileName;
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
            $product->prepare();
            $product->save();

        } else if ($type == 'variation') {

            $variation = \App\Variation::find($id);
            $variation->setConnection(\App\X::brandInUseSlug());
            $picName = $variation->picture;
            $variation->picture = 'default.jpg';
            $variation->prepare();
            $variation->save();

        } else if ($type == 'variation_picture') {

            $pVarPicture = \App\VariationPicture::find($id);
            $picName = $pVarPicture->picture;
            $pVarPicture->prepare();
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