<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Size as Size;
use Auth;
use Input;
use \App\Alert as Alert;
use App\Http\Requests;

class SizeController extends Controller
{
	public function index()
	{
		$sizes = Size::all();
		return view('pages.catalogue.sizes', compact('sizes'));
	}
	
	public function create(Request $request)
	{

		// try to validate the Input
		$v = Size::validate($request->all());
		
		// if everything ok...
		if ( $v->passes() ) {

			// create a new instance
			$size = new Size();
			// populate 
			$size->name = $request->get('name');
            $size->id = strtolower(trim(str_replace(' ','-',$request->get('id'))));
            $size->types = serialize($request->get('types'));
			$size->active = 1;
			// setConnection -required- for BRAND DB
			$size->setConnection(\App\X::brandInUseSlug());
			// save the line(s)
			$size->save();

			// success message
			Alert::success(trans('x.Size saved.'));
		
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
		// get the delivery from ID
		$size = Size::find($id);
		// delete it
		$size->delete();
		// success message
		Alert::success(trans('x.Size deleted'));
		// redirect back
		return redirect()->back();
	}
	
	public function edit(Request $request)
	{
		// try to validate the Input
		$v = Size::validate($request->all());
		
		// if everything ok...
		if ( $v->passes() ) {
				
			$size = \App\Size::find($request->get('size_id'));
            $id = $request->get('id');
            $name = $request->get('name');
            $active = $request->get('active');
            $types = serialize($request->get('types'));

            $size->id = $id;
            $size->name = $name;
            $size->active = $active;
            $size->types = $types;
            $size->save();

			// success message
			Alert::success(trans('x.Size updated'));
		
		// if not ok...
		} else {
			
			// prepare error message composed by validation messages
			$messages = ''; foreach($v->messages()->messages() as $error) { $messages .= $error[0].'<br>'; } Alert::error($messages);
		}
		
		// redirect back
		return redirect()->back();
	}

    public function reorder(Request $request)
    {
        $sizes = \App\Size::all();
        $ids = json_decode($request->get('ids'), true);
        $newSizes = array();

        foreach ($ids as $id) {
            $oldSize = \App\Size::find($id);
            $size = new \App\Size;
            $size->id = $id;
            $size->name = $oldSize->name;
            $size->active = 1;
            $size->types = $oldSize->types;

            $newSizes[] = $size;
        }

        \App\Size::truncate();

        foreach ($newSizes as $size) {
            $size->save();
        }
        
    }
	
	
}
