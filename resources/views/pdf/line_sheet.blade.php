<html style="width:100%">
<head>
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
    }
    h3 {
        font-size:17px;
    }
    h4 {
        font-size:15px;
    }
    h1 {
        font-size:26px;
    }
    table.bordered td,
    table.bordered th {
        padding:6px 20px;
    }

    .clearfix {
      overflow: auto;
      zoom: 1;
    }
    </style>
    <title>
        {!!$brand->name!!} Line Sheet {!!\App\Season::find(\App\Option::where('name', 'active_season')->first()->value)->name!!}
    </title>
</head>
<body style="width:100%">
<div id="container" style="font-family:'Open Sans', sans-serif; width:100%;">
    <div style="display:inline-block; float:left; width:36%; text-align:left">
        <img src="{{public_path()}}/assets/images/brands/{!!$brand->logo!!}" style="max-height:150px"/>
    </div>
    <div style="display:inline-block; float:left; width:64%; text-align:left">
        <h1>
        <br><br><br><br>
            {!!strtoupper($brand->name)!!} LINE SHEET {!!\App\Season::find(\App\Option::where('name', 'active_season')->first()->value)->name!!}
        </h1>
    </div>
    <br><br>
    <table class="bordered" style="width:100%;">
        @foreach ($products as $product)
        @if ($product->slug != '_custom')
            <tr><td></td></tr>
            <tr>
                <th style="text-align:right; width:310px">
                    <img style="max-width:300px" src="{!!public_path()!!}/assets/images/products/{!!$brand->slug!!}/{!!$product->picture!!}"/>
                </th>
                <th style="text-align:center; background-color:#ECECEC"><h1><u>{!!$product->prodmodel->name!!} / {!!$product->name!!}</u></h1>
                <p>{!!$product->description!!}</p>
                </th>
            </tr>
            @foreach ($product->variations as $variation)
            
                <tr>
                    <td style="text-align:right; width:310px">
                        <img style="max-width:140px" src="{!!public_path()!!}/assets/images/products/{!!$brand->slug!!}/{!!$variation->picture!!}"/>
                    </td>
                    <td style="text-align:left; background-color:#ECECEC;">
                        <h3>
                            {!!$product->prodmodel->name!!} / {!!$product->name!!}
                        </h3>
                        <h3>
                            col. {!!\App\Color::find($variation->color_id)->name!!}
                        </h3>
                        <h3>
                        
                            International: € {!!\App\ItemPrice::where('season_list_id', 2)->where('item_id', \App\Item::where('product_id', $product->id)->first()['id'])->first()['price']!!}
                        </h3>
                    </td>
                </tr>
            
            @endforeach
        @endif
        @endforeach  
    
    </table>
    
</div>
</body>
</html>