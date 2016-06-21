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
                            {!!Form::label('picture', trans('auth.Add/replace Main Picture'), ['class' => 'col-md-3 control-label'])!!}
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
                            {!!Form::label('picture', trans('auth.Add more gallery images'), ['class' => 'col-md-3 control-label'])!!}
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
                        @foreach(\App\Product::product_colors($product->id) as $color_id)
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
                        @foreach(\App\Product::product_colors($product->id) as $color_id)
                            <div class="tab-pane @if($i2==1) active @endif" id="tab-{!!$color_id!!}">
                                @foreach (\App\SeasonList::where('season_id', \App\Option::where('name', 'active_season')->first()->value)->get() as $season_list)
                                {!!strtoupper($season_list->name)!!}<br><br>
                                <table class="table-condensed table-bordered">
                                    <tr>
                                        <th>Size /</th>
                                        @foreach (\App\Size::all() as $size)
                                            <th>{!!$size->name!!}</th>
                                        @endforeach
                                    </tr><tr>
                                        <th>Eur /</th>
                                        @foreach (\App\Size::all() as $size)
                                        <td>
                                            {!!\App\Item::price_from_parameters($season_list->id, $product->id, $size->id, $color_id)!!}
                                        </td>
                                        @endforeach
                                    </tr>
                                </table><br>
                                @endforeach
                            </div>
                        {{-- */ $i2++ /* --}}
                        @endforeach
                    </div>
                </div>
                <!-- END TABS -->  
            
            <div class="panel panel-default">
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