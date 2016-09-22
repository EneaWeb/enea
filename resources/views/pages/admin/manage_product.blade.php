@extends('layout.dashboard.main')

@section('more_head')

@stop
@section('more_foot')

@stop

@section('content')  

    <div class="content-frame">   

        <div class="col-md-6">
            <div id="gallery" style="height:600px">
                
                <a href="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/{!!$product->picture!!}">
                    <img src="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/{!!$product->picture!!}",
                        data-big="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/{!!$product->picture!!}"
                    >
                </a>
                
                @foreach ($product->pictures as $picture)
                <a href="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/{!!$picture->picture!!}">
                    <img src="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/{!!$picture->picture!!}",
                        data-big="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/{!!$picture->picture!!}"
                    >
                </a>
                @endforeach
                
                {{-- Se l'articolo ha delle varianti, stampo tutte le immagini --}}
                
                @if ($product->has_variations == '1')
                    @foreach ($product->variations as $variation)
                        <a href="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/{!!$variation->picture!!}">
                            <img alt="{!!\App\Color::find($variation->color_id)->name!!}" src="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/{!!$variation->picture!!}",
                                data-big="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/{!!$variation->picture!!}" 
                            >
                        </a>
                        @foreach ($variation->pictures as $variation_picture)
                            <a href="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/{!!$variation_picture->picture!!}">
                                <img alt="{!!\App\Color::find($variation->color_id)->name!!}" src="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/{!!$variation_picture->picture!!}",
                                    data-big="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/{!!$variation_picture->picture!!}"
                                >
                            </a>
                        @endforeach
                    @endforeach
                @endif
                
            </div>
        </div>  
        
        <div class="col-md-6">
        
            {!!Form::open(['url'=>'/catalogue/product/edit-product', 'method'=>'POST'])!!}
            
            <div class="panel panel-default">
                <div class="panel-body">                            
                    <div class="tocify-content">                        
                        <div class="form-group">
                            {!!Form::label('name', trans('auth.Name'), ['class' => 'col-md-3 control-label'])!!}
                            <div class="col-md-8">
                                {!!Form::input('text', 'name', $product->name, ['class' => 'form-control', 'style'=>'float:left'])!!}
                            </div>
                        </div>
                        <br><br><br>
                        <div class="form-group">
                            {!!Form::label('slug', trans('auth.Slug'), ['class' => 'col-md-3 control-label'])!!}
                            <div class="col-md-8">
                                {!!Form::input('text', 'slug', $product->slug, ['class' => 'form-control', 'style'=>'float:left'])!!}
                            </div>
                        </div>
                        <br><br>
                         <div class="form-group">
                            {!!Form::label('type_id', trans('auth.Type'), ['class' => 'col-md-3 control-label'])!!}
                            <div class="col-md-8">
                                {!!Form::select('type_id', \App\Type::lists('slug', 'id'), $product->type->id, ['class' => 'form-control'])!!}
                            </div>
                        </div>
                        <br><br>
                         <div class="form-group">
                            {!!Form::label('description', trans('auth.Description'), ['class' => 'col-md-3 control-label'])!!}
                            <div class="col-md-8">
                                {!!Form::textarea('description', $product->description, ['class' => 'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">
                                {!!Form::submit(trans('auth.Update'), ['class'=>'btn btn-main'])!!}
                            </div>
                        </div>
                                             
                    </div>
                </div> 
            </div>
            
            <div class="panel panel-default">

                {!!Form::hidden('id', $product->id)!!}
                    <div class="panel-body">                            
                        <div class="form-group">
                            {!!Form::label('season_id', trans('auth.Season'), ['class' => 'col-md-3 control-label'])!!}
                            <div class="col-md-8">
                                {!!Form::select('season_id', \App\Season::lists('name', 'id'), $product->season_id, ['class' => 'form-control'])!!}
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group">
                            {!!Form::label('prodmodel_id', trans('auth.Model'), ['class' => 'col-md-3 control-label'])!!}
                            <div class="col-md-8">
                                {!!Form::select('prodmodel_id', \App\ProdModel::lists('name', 'id'), $product->prodmodel_id, ['class' => 'form-control'])!!}
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group">
                            {!!Form::label('has_variations', trans('auth.With Variations'), ['class' => 'col-md-3 control-label'])!!}
                            <div class="col-md-8">
                                {!!Form::select('has_variations', ['1'=>trans('messages.Yes'), '0'=>trans('messages.No')], $product->has_variations, ['class' => 'form-control', 'placeholder' => trans('auth.Select')])!!}
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group">
                            <div class="col-md-8">
                                {!!Form::submit(trans('auth.Update'), ['class'=>'btn btn-main'])!!}
                            </div>
                        </div>
                    </div>
                
            </div>
            {!!Form::close()!!}
        </div> 

    </div>
        
        
    <div class="content-frame"> 

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-body"> 
                    {!!Form::open(['url'=>'/catalogue/products/add-main-picture', 'method'=>'POST', 'novalidate' => 'novalidate', 'files' => true])!!}
                        <div class="form-group">
                            {!!Form::hidden('id', $product->id)!!}
                            {!!Form::label('product_variation_id', 'Aggiungi immagine principale Per Variante Prodotto o Prodotto principale', ['class' => 'col-md-3 control-label'])!!}
                            <div class="col-md-8">
                                <select name="product_variation_id" class="form-control">
                                        <option value="0">Articolo principale</option>
                                    @foreach (\App\ProductVariation::where('product_id', $product->id)
                                                                    ->where('active', 1)
                                                                    ->get() as $variation)
                                        <option value="{!!$variation->id!!}">
                                            {!!\App\Color::find($variation->color_id)->name!!}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <br><br>
                            <div class="col-md-8">
                                {!! Form::file('picture', ['style'=>'cursor:pointer', 'class'=>'fileinput btn-danger', 'data-filename-placement'=>'inside','title'=>'Upload']) !!}
                                {!!Form::submit(trans('auth.Save'), ['class'=>'btn btn-main'])!!}
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    {!!Form::close()!!}
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-body"> 
                    {!!Form::open(['url'=>'/catalogue/products/add-product-picture', 'method'=>'POST', 'novalidate' => 'novalidate', 'files' => true])!!}
                        <div class="form-group">
                            {!!Form::hidden('id', $product->id)!!}
                            @if ($product->has_variations == 1)
                                {!!Form::label('product_variation_id', 'Aggiungi immagini aggiuntive Per Variante Prodotto', ['class' => 'col-md-3 control-label'])!!}
                            @else 
                                {!!Form::label('product_variation_id', 'Aggiungi immagini aggiuntive Per Variante Prodotto o Prodotto principale', ['class' => 'col-md-3 control-label'])!!}
                            @endif
                                <div class="col-md-8">
                                        <select name="product_variation_id" class="form-control">
                                        @if ($product->has_variations != 1)
                                            <option value="0">Articolo principale</option>
                                        @endif
                                        @foreach (\App\ProductVariation::where('product_id', $product->id)
                                                                        ->where('active', 1)
                                                                        ->get() as $variation)
                                            <option value="{!!$variation->id!!}">
                                                {!!\App\Color::find($variation->color_id)->name!!} 
                                                [{!!\App\Color::find($variation->color_id)->slug!!}]
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            <br><br>
                            <div class="col-md-8">
                                {!! Form::file('picture', ['style'=>'cursor:pointer', 'class'=>'fileinput btn-danger', 'data-filename-placement'=>'inside','title'=>'Upload']) !!}
                                {!!Form::submit(trans('auth.Save'), ['class'=>'btn btn-main'])!!}
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    {!!Form::close()!!}
                    <div class="col-md-12">
                    <br>
                        <table class="table">
                        @foreach (\App\ProductPicture::where('product_id', $product->id)->get() as $picture)
                            <tr>
                                <td>{!!$picture->picture!!}</td>
                                <td><button class="btn" onClick="confirm_remove_product_picture({!!$picture->id!!})">Remove</button></td>
                            </tr>                        
                        @endforeach
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="col-md-6">
        
            <div class="panel panel-default">
                <div class="panel-body"> 
                    {!!Form::open(['url'=>'/catalogue/products/add-color', 'method'=>'GET'])!!}
                        <div class="form-group">
                            {!!Form::hidden('id', $product->id)!!}
                            {!!Form::label('color_id', trans('auth.Add Color'), ['class' => 'col-md-3 control-label'])!!}
                            <div class="col-md-8">
                                {!!Form::select('color_id', \App\Color::orderBy('name')->lists('name', 'id'), '', ['class'=>'form-control', 'placeholder'=>trans('menu.Select')])!!}
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            {!!Form::submit(trans('auth.Save'), ['class'=>'btn btn-main'])!!}
                            <div class="clearfix"></div>
                        </div>
                    {!!Form::close()!!}
                </div>
            </div>
            
                <!-- START TABS -->                                
                <div class="panel panel-default tabs">           

                    <ul class="nav nav-tabs" role="tablist">
                        {{-- */ $i = 1 /* --}}
                        @foreach(\App\ProductVariation::where('product_id', $product->id)
                                                        ->where('active', 1)
                                                        ->lists('color_id') as $color_id)
                            <li @if($i==1) class="active" @endif>
                                <a href="#tab-{!!$color_id!!}" role="tab" data-toggle="tab" style="border:3px solid {!!\App\Color::find($color_id)->hex!!}">
                                    {!!\App\Color::find($color_id)->name!!}
                                </a>
                            </li>
                        {{-- */ $i++ /* --}}
                        @endforeach
                    </ul>
                    <div class="panel-body tab-content">
                        {{-- */ $i2 = 1 /* --}}
                        @foreach(\App\ProductVariation::where('product_id', $product->id)
                                                        ->where('active', 1)
                                                        ->get() as $variation)
                            <div class="tab-pane @if($i2==1) active @endif" id="tab-{!!$variation->color_id!!}">
                            
                                @foreach (\App\SeasonList::where('season_id', \App\Option::where('name', 'active_season')->first()->value)->get() as $season_list)
                               
                                {{-- print List name --}}
                                {!!strtoupper($season_list->name)!!}<br><br>
                                
                                {{-- print table with sizes --}}
                                {!!Form::open(['url'=>'/catalogue/products/edit-single-prices', 'method'=>'POST'])!!}
                                <table class="table-condensed table-bordered">
                                    <tr>
                                        <th>Size /</th>
                                        @foreach (\App\Size::sizes_for_type($product) as $size)
                                            <th>{!!$size->name!!}</th>
                                        @endforeach
                                    </tr><tr>
                                        <th>Eur /</th>
                                        @foreach (\App\Item::where('product_variation_id', $variation->id)
                                                            ->orderBy('size_id')->get() as $item)
                                            <td>
                                                {!!Form::number($item->id, \App\ItemPrice::where('item_id', $item->id)
                                                        ->where('season_list_id', $season_list->id)->first()['price'], ['class'=>'form-control', 'step'=>'0.1'])!!}
                                            </td>
                                        @endforeach
                                    </tr>
                                </table><br>
                                {!!Form::submit('Save')!!}
                                {!!Form::close()!!}
                                @endforeach
                            </div>
                        {{-- */ $i2++ /* --}}
                        @endforeach
                    </div>
                </div>
                <!-- END TABS -->  
            
            <div class="panel panel-default">
                <div class="panel-title">
                    <h4>Bulk edit prices</h4>
                </div>
                <div class="panel-body"> 
                    {!!Form::open(['url'=>'/catalogue/products/bulk-update-prices', 'method'=>'GET'])!!}
                        {!!Form::hidden('id', $product->id)!!}
                        @foreach (\App\SeasonList::where('season_id', \App\Option::where('name', 'active_season')->first()->value)->get() as $seasonlist)
                            <div class="form-group">
                                {!!Form::label($seasonlist->id, $seasonlist->name, ['class' => 'col-md-3 control-label'])!!}
                                <div class="col-md-8">
                                    {!!Form::input('text', $seasonlist->id, '', ['class'=>'form-control', 'placeholder'=>'€'])!!}
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        @endforeach
                        <div class="form-group">
                            {!!Form::submit(trans('auth.Save'), ['class'=>'btn btn-main'])!!}
                            <div class="clearfix"></div>
                        </div>
                    {!!Form::close()!!}
                </div>
            </div>
            
                                  
        </div>

    </div>
    
<script>
$(document).ready(function(){
    Galleria.run('#gallery');
});
</script>
@stop