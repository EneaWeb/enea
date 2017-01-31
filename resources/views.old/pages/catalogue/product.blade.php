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
                            <img src="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/{!!$variation->picture!!}",
                                data-big="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/{!!$variation->picture!!}"
                            >
                        </a>
                        @foreach ($variation->pictures as $variation_picture)
                            <a href="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/{!!$variation_picture->picture!!}">
                                <img src="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/{!!$variation_picture->picture!!}",
                                    data-big="/assets/images/products/{!!Auth::user()->options->brand_in_use->slug!!}/{!!$variation_picture->picture!!}"
                                >
                            </a>
                        @endforeach
                    @endforeach
                @endif
                
            </div>
        </div>  
        
        <div class="col-md-6">
        
            <div class="panel panel-default">
                <div class="panel-body">                            
                    <div class="tocify-content">                        
                        <div class="form-group">
                            {!!Form::label('name', trans('x.Name'), ['class' => 'col-md-3 control-label'])!!}
                            <div class="col-md-8">
                                <h3>{!!$product->name!!}</h3>
                                <h6>{!!$product->slug!!}</h6>
                                <p>{!!$product->description!!}</p>
                            </div>
                        </div>
                                             
                    </div>
                </div> 
            </div>
            
            <div class="panel panel-default">

                {!!Form::hidden('id', $product->id)!!}
                    <div class="panel-body">                            
                        <div class="form-group">
                            {!!Form::label('season_id', trans('x.Season'), ['class' => 'col-md-3 control-label'])!!}
                            <div class="col-md-8">
                                <h6>{!!$product->season->name!!}</h6>
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group">
                            {!!Form::label('prodmodel_id', trans('x.Model'), ['class' => 'col-md-3 control-label'])!!}
                            <div class="col-md-8">
                                <h6>{!!$product->prodmodel->name!!}</h6>
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group">
                            {!!Form::label('has_variations', trans('x.With Variations'), ['class' => 'col-md-3 control-label'])!!}
                            <div class="col-md-8">
                                <h6>{!!($product->has_variations == 1) ? trans('x.Yes') : trans('x.No') !!}</h6>
                            </div>
                        </div>
                        <br><br>
                    </div>
            </div>
            
            <!-- START TABS -->                                
            <div class="panel panel-default tabs">           

                <ul class="nav nav-tabs" role="tablist">
                    {{-- */ $i = 1 /* --}}
                    @foreach(\App\Variation::where('product_id', $product->id)
                                                    ->where('active', 1)
                                                    ->pluck('color_id') as $color_id)
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
                    @foreach(\App\Variation::where('product_id', $product->id)
                                                    ->where('active', 1)
                                                    ->get() as $variation)
                        <div class="tab-pane @if($i2==1) active @endif" id="tab-{!!$variation->color_id!!}">
                            
                        @if (Auth::user()->can('manage lists'))
                            @foreach(\App\SeasonList::where('season_id', \App\Option::where('name', 'active_season')->first()->value)->get() as $season_list)
                           
                            {{-- print List name --}}
                            {!!strtoupper($season_list->name)!!}<br><br>
                            
                            {{-- print table with sizes --}}
                            <table class="table-condensed table-bordered">
                                <tr>
                                    <th>Size /</th>
                                    @foreach (\App\Item::where('product_variation_id', $variation->id)
                                                        ->get() as $item)
                                        <th>{!!$item->size->name!!}</th>
                                    @endforeach
                                </tr><tr>
                                    <th>Eur /</th>
                                   @foreach (\App\Item::where('product_variation_id', $variation->id)
                                                        ->get() as $item)
                                    <td>
                                        {!!\App\ItemPrice::where('item_id', $item->id)
                                                ->where('season_list_id', $season_list->id)->first()['price'] !!}
                                    </td>
                                    @endforeach
                                </tr>
                            </table><br>
                            @endforeach
                        @else
                            @foreach(Auth::user()->season_lists()->where('season_id', \App\Option::where('name', 'active_season')->first()->value)->get() as $season_list)
                            
                            {{-- print List name --}}
                            {!!strtoupper($season_list->name)!!}<br><br>
                            
                            {{-- print table with sizes --}}
                            <table class="table-condensed table-bordered">
                                <tr>
                                    <th>Size /</th>
                                    @foreach (\App\Item::where('product_variation_id', $variation->id)
                                                        ->get() as $item)
                                        <th>{!!$item->size->name!!}</th>
                                    @endforeach
                                </tr><tr>
                                    <th>Eur /</th>
                                   @foreach (\App\Item::where('product_variation_id', $variation->id)
                                                        ->get() as $item)
                                    <td>
                                        {!!\App\ItemPrice::where('item_id', $item->id)
                                                ->where('season_list_id', $season_list->id)->first()['price'] !!}
                                    </td>
                                    @endforeach
                                </tr>
                            </table><br>
                            @endforeach
                        @endif
                        </div>
                    {{-- */ $i2++ /* --}}
                    @endforeach
                </div>
            </div>
            <!-- END TABS -->
                                  
        </div>

    </div>
    
<script>
$(document).ready(function(){
    Galleria.run('#gallery');
});
</script>
@stop