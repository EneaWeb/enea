<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Alert as Alert;

class TermsController extends Controller
{
	public function create(Request $request) {

        $attributeId = $request->get('attribute_id');
        $name = $request->get('name');
        $id = trim(str_replace(' ','-',strtolower($request->get('id'))));
        $hex = $request->get('hex');

        $term = new \App\Term;
        $term->id = $id;
        $term->name = $name;
        $term->hex = $hex;
        $term->attribute_id = $attributeId;
        $term->save();

        Alert::success(trans('x.Attribute Created'));
        return redirect()->back();
    }

    public function edit(Request $request) {

        $termId = $request->get('term_id');
        $term = \App\Term::find($termId);

        $id = trim(str_replace(' ','-',strtolower($request->get('id'))));
        $name = $request->get('name');
        $hex = $request->get('hex');

        $term->id = $id;
        $term->name = $name;
        $term->hex = $hex;

        $term->save();

        Alert::success(trans('x.Attribute Changed'));
        return redirect()->back();

    }

    public function delete($id) {
        \App\Term::destroy($id);

        Alert::success(trans('x.Attribute Deleted'));
        return redirect()->back();
    }
}
