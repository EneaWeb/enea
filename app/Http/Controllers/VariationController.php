<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Auth;
use \App\Variation as Variation;
use \App\Alert as Alert;
use App\Http\Requests;
use X;
use DB;

class VariationController extends Controller
{
	public function index()
	{
		$active_season = \App\Option::where('name', 'active_season')->first()->value;
		$variations = Variation::where('season_id', $active_season)->get();
		return view('pages.catalogue.variations', compact('variations'));
	}
	
	public function create()
	{
		// try to validate the Input
		$v = Variation::validate(Input::all());
		
		// if everything ok...
		if ( $v->passes() ) {
			
			// create a new instance
			$variation = new Variation();
			// populate
			$variation->name = Input::get('name');
			$variation->slug = trim(Input::get('slug'));
			$variation->description = Input::get('description');
			$variation->season_id = Input::get('season_id');
			$variation->active = 1;
			// setConnection -required- for BRAND DB
			$variation->setConnection(Auth::user()->options->brand_in_use->slug);
			// save the line(s)
			$variation->save();

			// success message
			Alert::success(trans('x.Variation saved.'));
		
		// if not ok...
		} else {
			
			// prepare error message composed by validation messages
			$messages = ''; foreach($v->messages()->messages() as $error) { $messages .= $error[0].'<br>'; } Alert::error($messages);
		}
		
		// redirect back
		return redirect()->back();
	}
	
	public function variationByProduct(Request $request)
    {
        $product_id = $request->get('product_id');
        return \App\Variation::with('terms')->where('product_id', $product_id)->where('active', '1')->get()->toJSON();
    }

	public function itemByVariation(Request $request)
    {
        $variation_id = $request->get('variation_id');
        $price_list_id = \App\Order::getOption('price_list_id');

        $q = DB::connection(X::brandInUseSlug())
            ->table('items')
            ->where('items.variation_id', '=', $variation_id)
            ->join('item_prices', function($q) use ($price_list_id) {
                $q->on('items.id', '=', 'item_prices.item_id');
                $q->where('item_prices.price_list_id', $price_list_id);
            })
            ->select('items.*', 'item_prices.price')
            ->get();

        return json_encode($q);
    }
	
}
