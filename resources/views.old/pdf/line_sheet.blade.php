<html style="width:100%">
<head>
    <title>{!!$brand->name!!} Line Sheet {!!\App\Season::find(\App\Option::where('name', 'active_season')->first()->value)->name!!}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
    body {
        padding:50px;
    }
    * { box-sizing:border-box; margin:0; font-weight:normal;}
    html, p {font-size:11px; line-height:16px;}
    
    div.page-break { page-break-inside:avoid; page-break-after:always; }
    
    h6 {
        font-size:13px;
        line-height:20px;
    }
    h3 {
        font-size:17px;
        line-height:24px;
    }
    h4 {
        font-size:15px;
        line-height:23px;
    }
    h1 {
        font-size:26px;
        line-height:36px;
    }
    table.bordered td,
    table.bordered th {
        padding:6px 20px;
        line-height:20px;
    }

    .clearfix {
      overflow: auto;
      zoom: 1;
    }
    img {
        border:none;
        margin:0px;
        padding:0px;
    }
    </style>
    <title>
        {!!$brand->name!!} Line Sheet {!!\App\Season::find(\App\Option::where('name', 'active_season')->first()->value)->name!!}
    </title>
</head>
<body style="width:100%">
<div id="container" style="font-family:'Open Sans', sans-serif; width:100%;">
    <div style="display:inline-block; float:left; width:36%; text-align:left">
        <img src="{{public_path()}}/assets/images/brands/{!!$brand->logo!!}" style="max-height:150px; margin-left:30px"/>
    </div>
    <div style="display:inline-block; float:left; width:64%; text-align:left">
        <h1 style="text-align:right; margin-right:20px">
        <br>
            LINE SHEET {!!\App\Season::find(\App\Option::where('name', 'active_season')->first()->value)->name!!}<br>   
            {!!strtoupper(\App\Type::find(Auth::user()->options->active_type)->slug)!!} / 
            @if($seasonlist!='clean')
                LIST {!!strtoupper($seasonlist->name)!!}
            @endif
            
        </h1>
    </div>
    <br><br>
    <table class="bordered" style="width:100%;">
        @foreach ($products as $product)
        @if ($product->slug != '_custom')
            <tr><td colspan="2"><div style="">&nbsp;</div></td></tr>
            <tr>
                <th style="text-align:center; width:400px; border-top:20px solid white; border-bottom:20px solid white; background-color: #F1F1F1;">
                    @if ($product->picture != 'default.jpg')
                     <img style="max-width:280px" src="{!!public_path()!!}/assets/images/products/{!!$brand->slug!!}/300/{!!$product->picture!!}"/>
                    @endif
                </th>
                <th style="text-align:left; background-color:#F1F1F1; border-top:20px solid white; border-bottom:20px solid white;"><h1><u>{!!$product->prodmodel->name!!} / {!!$product->name!!}</u></h1>
                <p>{!!$product->description!!}</p>
                </th>
            </tr>
            @foreach ($product->variations as $variation)
            
                <tr>
                    <td style="text-align:center; width:400px; background-color: #F1F1F1;">
                        @if ($variation->picture != 'default.jpg')
                            <img style="max-width:138px" src="{!!public_path()!!}/assets/images/products/{!!$brand->slug!!}/300/{!!$variation->picture!!}"/>
                        @endif
                        @foreach (array_slice(\App\VariationPicture::where('product_variation_id', $variation->id)->get()->toArray(), 0, 2) as $variation_picture)
                            <img style="max-width:138px" src="{!!public_path()!!}/assets/images/products/{!!$brand->slug!!}/300/{!!$variation_picture['picture']!!}"/>
                            &nbsp;
                        @endforeach
                    </td>
                    <td style="text-align:left; background-color:#F1F1F1;">
                        <h3>
                            {!!$product->prodmodel->name!!} {!!$product->name!!}
                        </h3>
                        <h3>
                            {!!\App\Color::find($variation->color_id)->name!!}
                        </h3>
                        @if ($seasonlist != 'clean')
                            <h3>
                                {{--{!!$seasonlist->name!!}:--}} € {!!number_format(\App\ItemPrice::where('season_list_id', $seasonlist->id)->where('item_id', \App\Item::where('product_variation_id', $variation->id)->first()['id'])->first()['price'], 2, ',','.')!!}
                            </h3>
                        @endif
                    </td>
                </tr>
            
            @endforeach
        @endif
        @endforeach  
    
    </table>
    
</div>
</body>
</html>