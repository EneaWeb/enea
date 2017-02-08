<!-- END PAGE SIDEBAR -->
<div class="page-content-col">

    <!-- BEGIN PAGE BASE CONTENT -->
    <div class="portfolio-content portfolio-1">

        <div style="display:inline-block; float:right">
            <a class="btn btn-info" href="?show=gallery">
                <i class="fa fa-picture-o"></i>
            </a>
            <a class="btn btn-default" href="?show=list">
                <i class="fa fa-list"></i>
            </a>
            @if (X::isOrderInProgress())
                <a class="btn btn-default" href="?show=fast">
                    <i class="fa fa-fast-forward"></i>
                </a>
            @endif
        </div>

        <div id="js-filters-juicy-projects" class="cbp-l-filters-button" style="display:inline-block; float:left">
            <div data-filter="*" class="cbp-filter-item-active cbp-filter-item btn dark btn-outline uppercase"> {!!trans('x.All')!!}
                <div class="cbp-filter-counter"></div>
            </div>
            @foreach (\App\Product::groupBy('type_id')->pluck('type_id') as $type_id)
                <div data-filter=".{!!$type_id!!}" class="cbp-filter-item btn dark btn-outline uppercase"> {!!trans('x.'.\App\Type::find($type_id)->slug)!!}
                    <div class="cbp-filter-counter"></div>
                </div>
            @endforeach
        </div>


        <div>
            <div class="clearfix"></div>
            <div class="col-md-4">
                <input type="text" id="theInput-1" onkeyup="myFunction(1)" class="form-control" placeholder="{!!trans('x.Search models')!!} ...">
                <div style="height:40px"></div>
            </div>
            <div class="col-md-4">
                <input type="text" id="theInput-2" onkeyup="myFunction(2)" class="form-control" placeholder="{!!trans('x.Search products')!!} ...">
                <div style="height:40px"></div>
            </div>
            <div class="col-md-4">
                <input type="text" id="theInput-3" onkeyup="myFunction(3)" class="form-control" placeholder="{!!trans('x.Search variations')!!} ...">
                <div style="height:40px"></div>
            </div>

            <table id="products" class="table table-hover">

                <tr class="header">
                    <th style="width:20%;">Img</th>
                    <th style="width:20%;">{!!trans('x.Model')!!}</th>
                    <th style="width:20%;">{!!trans('x.Product')!!}</th>
                    <th style="width:30%;">{!!trans('x.Variations')!!}</th>
                    <th style="width:30%;">{!!trans('x.Sizes')!!}</th>
                </tr>

            @foreach($products as $product)

                @if (Request::segment(2) == 'orders')
                <tr data-toggle="modal" data-target="#modal_add_lines" data-product_id="{!!$product->id!!}">
                @else
                <tr onclick="location.href='/catalogue/products/{!!$product->id!!}'">
                @endif
                    <td style="vertical-align:middle; cursor:pointer;">
                        <img src="{{\App\X::s3_products_thumb($product->featuredPicture())}}" style="max-height:70px" /></td>
                    <td style="vertical-align:middle; cursor:pointer;">{!!$product->prodmodel->name!!}</td>
                    <td style="vertical-align:middle; cursor:pointer;">{!!$product->name!!}</td>
                    <td style="vertical-align:middle; cursor:pointer;">{!!$product->renderVariations()!!}</td>
                    <td style="vertical-align:middle; cursor:pointer;">{!!$product->renderSizes()!!}</td>
                </tr>

            @endforeach

            </table>

            <script>
                function myFunction(index) {
                    // Declare variables 
                    var input, filter, table, tr, td, i;
                    input = document.getElementById("theInput-"+index);
                    filter = input.value.toUpperCase();
                    table = document.getElementById("products");
                    tr = table.getElementsByTagName("tr");

                    // Loop through all table rows, and hide those who don't match the search query
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[index];
                        if (td) {
                            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        } 
                    }
                }

            </script>

        </div>

    </div>
    <!-- END PAGE BASE CONTENT -->
</div>