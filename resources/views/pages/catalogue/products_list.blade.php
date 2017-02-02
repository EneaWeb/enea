@extends('layout.main')

@section('content')

<!-- BEGIN SIDEBAR CONTENT LAYOUT -->
<div class="page-content-container">
    <div class="page-content-row">
        <!-- BEGIN PAGE SIDEBAR -->

            @include('sidebars.catalogue')
            
        <!-- END PAGE SIDEBAR -->
        <div class="page-content-col">

            <!-- BEGIN PAGE BASE CONTENT -->
            <div class="portfolio-content portfolio-1">

                <div style="display:inline-block; float:right">
                    <a class="btn btn-default" href="/catalogue/products?show=gallery">
                        <i class="icon-home"></i> Gallery 
                    </a>
                    <a class="btn btn-info" href="/catalogue/products?show=list">
                        <i class="icon-home"></i> {!!trans('x.List')!!} 
                    </a>
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
                    <div class="col-md-12">
                        <input type="text" id="theInput" onkeyup="myFunction()" class="form-control" placeholder="{!!trans('x.Search')!!} ...">
                        <div style="height:40px"></div>
                    </div>

                    <table id="products" class="table table-hover">

                        <tr class="header">
                            <th style="width:20%;">Img</th>
                            <th style="width:20%;">{!!trans('x.Model')!!} - {!!trans('x.Product')!!}</th>
                            <th style="width:30%;">{!!trans('x.Variations')!!}</th>
                            <th style="width:30%;">{!!trans('x.Sizes')!!}</th>
                        </tr>

                    @foreach($products as $product)

                        <tr onclick="location.href='/catalogue/products/{!!$product->id!!}'">
                            <td style="vertical-align:middle; cursor:pointer;"><img src="/assets/images/products/{!!\App\X::brandInUseSlug()!!}/300/{!!$product->picture!!}" style="max-height:70px" /></td>
                            <td style="vertical-align:middle; cursor:pointer;">{!!$product->prodmodel->name!!} {!!$product->name!!}</td>
                            <td style="vertical-align:middle; cursor:pointer;">{!!\App\Product::availColors($product->id)!!}</td>
                            <td style="vertical-align:middle; cursor:pointer;">{!!\App\Product::renderSizes($product->id)!!}</td>
                        </tr>

                    @endforeach

                    </table>

                    <script>
                        function myFunction() {
                            // Declare variables 
                            var input, filter, table, tr, td, i;
                            input = document.getElementById("theInput");
                            filter = input.value.toUpperCase();
                            table = document.getElementById("products");
                            tr = table.getElementsByTagName("tr");

                            // Loop through all table rows, and hide those who don't match the search query
                            for (i = 0; i < tr.length; i++) {
                                td = tr[i].getElementsByTagName("td")[1];
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
    </div>
</div>
<!-- END SIDEBAR CONTENT LAYOUT -->

@stop