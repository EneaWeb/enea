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

            <div class="panel panel-default">
                <div class="panel-body">
                    <h5>{!!$product->season->name!!} - mod. {!!trans('messages.'.$product->model->type->name)!!}</h5>
                    <h1> {!!$product->model->name!!} / <u>{!!$product->name!!}</u></h1>
                    <h4><i>cod. {!!$product->slug!!}</i></h4>
                    <p>{!!$product->description!!}
                    <br>
                                         
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
                
            </div>
        </div> 

    </div>
        
    
<script>
$(document).ready(function(){
    Galleria.run('#gallery');
});
</script>
@stop