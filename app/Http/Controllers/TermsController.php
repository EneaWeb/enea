<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Alert as Alert;

class TermsController extends Controller
{
	public function create(Request $request) {

        $attributeId = $request->get('attribute_id');
        $name = $request->get('name');
        $id = $request->get('id');
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

        $id = $request->get('id');
        $name = $request->get('name');
        $hex = $request->get('hex');

        $term->id = $id;
        $term->name = $name;
        $term->hex = $hex;

        $term->save();

        Alert::success(trans('x.Attribute Changed'));
        return redirect()->back();

    }
}
