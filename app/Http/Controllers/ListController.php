<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use \App\PriceList as PriceList;
use \App\Alert as Alert;
use App\Http\Requests;

class ListController extends Controller
{

    public function index()
    {
        $lists = PriceList::all();
        return view('pages.settings.lists', compact('lists'));
    }

	public function create(Request $request)
	{
		// try to validate the Input
		$v = PriceList::validate($request->all());
		
		// if everything ok...
		if ( $v->passes() ) {
			
			// create a new instance
			$season_list = new PriceList();
			// populate 
            $season_list->id = $request->get('id');
			$season_list->name = $request->get('name');
			// setConnection -required- for BRAND DB
			$season_list->setConnection(\App\X::brandInUseSlug());
			// save the line(s)
			$season_list->save();

			// success message
			Alert::success(trans('x.Price List saved'));
		
		// if not ok...
		} else {
			
			// prepare error message composed by validation messages
			$messages = ''; foreach($v->messages()->messages() as $error) { $messages .= $error[0].'<br>'; } Alert::error($messages);
		}
		
		// redirect back
		return redirect()->back();
	}
	
	public function delete($id)
	{

        // check if it has been used previously in some orders
        $orders = \App\Order::where('season_list_id', $id)->count();
        if ($orders >= 1) {
            Alert::error(trans('x.This list can\'t be deleted as it has been used in '.orders.' orders'));
            return redirect()->back();
        }

		// get the delivery from ID
		$season_list = PriceList::find($id);
		// delete it
		$season_list->delete();
		// success message
		Alert::success(trans('x.Price List deleted'));
		// redirect back
		return redirect()->back();
	}
	
	public function edit(Request $request)
	{
		// try to validate the Input
		$v = PriceList::validate($request->all());
		
		// if everything ok...
		if ( $v->passes() ) {
				
			// get the delivery from ID
			$list = PriceList::find($request->get('list_id'));
			// edit the informations
			$list->name = $request->get('name');
			$list->active = $request->get('active');
			// setConnection -required- for BRAND DB
			$list->setConnection(\App\X::brandInUseSlug());
			// save the line(s)
			$list->save();

			// success message
			Alert::success(trans('x.Price List updated'));
		
		// if not ok...
		} else {
			
			// prepare error message composed by validation messages
			$messages = ''; foreach($v->messages()->messages() as $error) { $messages .= $error[0].'<br>'; } Alert::error($messages);
		}
		
		// redirect back
		return redirect()->back();
	}
	
}
