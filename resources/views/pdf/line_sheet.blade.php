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

    <h1>{!!strtoupper($brand->name)!!} LINE SHEET {!!\App\Season::find(\App\Option::where('name', 'active_season')->first()->value)->name!!}</h1>
    <br><br><br>
    <table class="bordered" style="width:100%; background-color:red">
        @foreach ($products as $product)
            <tr>
                <th style="text-align:right; width:310px">
                    <img style="max-width:300px" src="{!!public_path()!!}/assets/images/products/{!!$brand->slug!!}/{!!$product->picture!!}"/>
                </th>
                <th style="text-align:left"><h1>{!!$product->prodmodel->name!!} / {!!$product->name!!}</h1>
                <p>{!!$product->description!!}</p>
                </th>
            </tr>
            @foreach ($product->variations as $variation)
                <tr>
                    <td style="text-align:right; width:310px">
                        <img style="max-width:130px" src="{!!public_path()!!}/assets/images/products/{!!$brand->slug!!}/{!!$variation->picture!!}"/>
                    </td>
                    <td style="text-align:left">{!!\App\ItemPrice::where('season_list_id', 2)->where('item_id', \App\Item::where('product_id', $product->id)->first()['id'])->first()['price']!!}</td>
                </tr>
            @endforeach
        
        @endforeach       
    
    </table>
    
</div>
</body>
</html>