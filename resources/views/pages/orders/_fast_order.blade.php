<!-- END PAGE SIDEBAR -->
<div class="page-content-col">

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

    <style>
        td {
            padding:0px!important;
            margin:0px!important;
        }
        td input {
            padding: 0px!important;
            text-align: center!important;
        }
        td select {
            padding:4px!important;
        }
        td.fast-sizes-td {
            max-width:50px!important;
        }
        ::-webkit-input-placeholder { /* WebKit, Blink, Edge */
            color:    #ededed!important;
        }
        :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
        color:    #ededed!important;
        opacity:  1;
        }
        ::-moz-placeholder { /* Mozilla Firefox 19+ */
        color:    #ededed!important;
        opacity:  1;
        }
        :-ms-input-placeholder { /* Internet Explorer 10-11 */
        color:    #ededed!important;
        }
    </style>

    <h4><b>Modalità di inserimento veloce</b></h4>
    <p>Utile per inserire ordini di cui si conoscono già i dettagli, come nella copia di ordini cartacei.<br>
    Selezionare a cascata la Tipologia, poi l'Articolo, poi la Variante, ed infine compilare la tabella taglie con le quantità necessarie.<br>
    <b>Salvare al termine della compilazione.</b></p>
    <br>

    <span id="sizes-json" style="display:none">{{\App\Size::where('active', '1')->get()->toJSON()}}</span>

    <!-- BEGIN PAGE BASE CONTENT -->
    <form id="lines-form">

    <input type="hidden" name="_token" value="{!!csrf_token()!!}" />
    
    <table class="table table-striped table-bordered">
        <thead>
            <tr class="no-count">
                <th></th>
                <th>Type</th>
                <th>Product</th>
                <th>Variation</th>
                @foreach(\App\Size::where('active', '1')->get() as $size)
                    <th>{{$size->name}}</th>
                @endforeach
            </tr>
            <tr class="no-count"><td colspan="{!!5+\App\Size::activeCount()!!}">&nbsp;</td></tr>
        </thead>
        <tbody>

            @if (X::isOrderInProgress())
            @foreach (\App\Order::reorderCart() as $variation_id => $item_qty)

            <?php $variation = \App\Variation::find($variation_id); ?>

            <tr class="fast-tr">
                <td style="width:7px!important;" class="delete-line-td">
                    <i style="padding-top:10px; padding-left:4px; cursor:pointer;" class="fa fa-minus remove-line"></i>
                </td>
                <td class="fast-type-td" style="width:66px!important">
                    <select name="fast-type" class="form-control fast-type">
                        <option disabled value>Seleziona</option>
                        @foreach (\App\Product::activeTypes() as $typeId)
                            @if ($variation->product->type_id == $typeId)
                                <option value="{{$typeId}}" selected="selected">{{substr(\App\Type::find($typeId)->name, 0, 3)}}</option>
                            @else
                                <option value="{{$typeId}}">{{substr(\App\Type::find($typeId)->name, 0, 3)}}</option>
                            @endif
                        @endforeach
                    </select>
                </td>
                <td class="fast-products-td">
                    <select name="fast-products" class="form-control fast-products">
                        <option value="{{$variation->product_id}}" selected="selected">{{$variation->product->name}}</option>
                        @foreach (\App\Product::where('active', '1')->where('type_id', $variation->product->type_id)->where('id', '!=', $variation->product_id)->get() as $product)
                            <option value="{{$product->id}}">{{$product->name}}</option>
                        @endforeach
                    </select>
                </td>
                <td class="fast-variations-td">
                    <select name="fast-variations" class="form-control fast-variations">
                        <option value="{{$variation_id}}" selected="selected">{{$variation->sku !== null ? $variation->sku : $variation->renderTerms()}}</option>
                        @foreach (\App\Variation::where('active', '1')->where('product_id', $variation->product_id)->where('id', '!=', $variation->id)->get() as $var)
                            <option value="{{$var->id}}">{{$var->sku !== '' ? $var->sku : $var->renderTerms()}}</option>
                        @endforeach
                    </select>
                </td>
                @foreach (\App\Size::activeSizes() as $size)
                    <?php $item = \App\Item::where('size_id', $size->id)->where('variation_id', $variation->id)->first(); ?>
                    @if ($item !== NULL)
                        <td class="fast-sizes-td">
                            <input type="number" min="0" class="form-control" name="{{$item->id}}" data-price="{{$item->priceForOrderList()}}" placeholder="{{$size->name}}" value="{{isset($item_qty[$item->id]) ? $item_qty[$item->id] : ''}}"/>
                        </td>
                    @else
                        <td class="fast-sizes-td"></td>
                    @endif
                @endforeach
            </tr>

            @endforeach
            @endif

            <tr class="fast-tr">
                <td style="width:7px!important;" class="delete-line-td">
                    <i style="padding-top:10px; padding-left:4px; cursor:pointer;" class="fa fa-minus remove-line"></i>
                </td>
                <td class="fast-type-td" style="width:66px!important">
                    <select name="fast-type" class="form-control fast-type">
                        <option disabled selected value>Seleziona</option>
                        @foreach (\App\Product::activeTypes() as $typeId)
                            <option value="{{$typeId}}">{{substr(\App\Type::find($typeId)->name, 0, 3)}}</option>
                        @endforeach
                    </select>
                </td>
                <td class="fast-products-td">
                    <select name="fast-products" class="form-control fast-products">
                    </select>
                </td>
                <td class="fast-variations-td">
                    <select name="fast-variations" class="form-control fast-variations">
                    </select>
                </td>
                <td class="fast-sizes-td" colspan="{{\App\Size::activeCount()}}">
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="no-count">
                <td style="padding:10px 4px!important; cursor:pointer;" onclick="addLine();"><i class="fa fa-plus"></i></td>
            </tr>
            <tr class="totals-tr no-count" style="background-color:#ddd">
                <td colspan="4"></td>
                @foreach(\App\Size::where('active', '1')->get() as $size)
                    <th class="th-total-count"></th>
                @endforeach
            </tr>
        </tfoot>
    </table>
    </form>

    <div style="background-color:#eee;"><p style="padding:6px">Qty : <b id="tot-qty">0</b></p></div>
    <div style="background-color:#eee;"><p style="padding:6px">Tot: <b id="tot-price">0</b></p></div>
    <div style="text-align:right;"><button id="button-save-line" class="btn btn-success btn-lg">SALVA</button></div>
    <!-- END PAGE BASE CONTENT -->
</div>

<script>

    $(document).ready(function(){
        $('tr.fast-tr:last').clone().prependTo('tbody').hide();
    });

    $('body').on('click', '.remove-line', function(){
        $(this).parent().parent().remove();
    });

    
    function addLine() {
        var newLine = $( "tr.fast-tr:first" ).clone().appendTo('tbody').fadeIn();
    }

     $('body').on('change', '.fast-type', function(){

        var thisSelector = $(this);
        typeId = thisSelector.val();

        $.ajax({
            method : 'GET',
            url : '/api2/products-by-type',
            data : { type_id : typeId }
        })
        .success(function( data ){

            data = JSON.parse(data);

            var newSelector = $('<select>', {
                name: 'fast-products',
                class: 'form-control fast-products'
            });

            $('<option>', {
                disabled : 'disabled',
                selected : 'selected',
                value : '',
                text: 'Select'
            }).appendTo(newSelector);

            $.each( data, function( k, product ) {
                $('<option>', {
                    value: product.id,
                    text: product.name
                }).appendTo(newSelector);
            });

            thisSelector
            .parent('td.fast-type-td')
            .parent('tr')
            .children('td.fast-products-td')
            .children('select.fast-products')
            .replaceWith(newSelector);

            thisSelector.parent().parent().find('td.fast-sizes-td').remove();
            thisSelector.parent().parent().find('.fast-variations').empty();

        })
        .error(function(){
            toastr.error('ajax error');
        })
    })

    $('body').on('change', '.fast-products', function(){

        var thisSelector = $(this);
        product_id = thisSelector.val();

        $.ajax({
            method : 'GET',
            url : '/api2/variations-by-product',
            data : { product_id : product_id }
        })
        .success(function( data ){

            data = JSON.parse(data);

            var newSelector = $('<select>', {
                name: 'fast-variations',
                class: 'form-control fast-variations'
            });

            $('<option>', {
                disabled : 'disabled',
                selected : 'selected',
                value : '',
                text: 'Select'
            }).appendTo(newSelector);

            $.each( data, function( k, variation ) {
                var sku = '';
                if (variation.sku !== '' && variation.sku !== null) {
                    sku = variation.sku;
                } else {
                    $.each( variation.terms, function( k, term ) {
                        sku += term.name+' ';
                    });
                }
                $('<option>', {
                    value: variation.id,
                    text: sku
                }).appendTo(newSelector);
            });

            thisSelector
            .parent('td.fast-products-td')
            .parent('tr')
            .children('td.fast-variations-td')
            .children('select.fast-variations')
            .replaceWith(newSelector);

            thisSelector.parent().parent().find('td.fast-sizes-td').remove();

        })
        .error(function(){
            toastr.error('ajax error');
        })
    })


    $('body').on('change', '.fast-variations', function(){
       
        var thisSelector = $(this);
        variation_id = thisSelector.val();
        var sizes = JSON.parse($('#sizes-json').html());

        $.ajax({
            method : 'GET',
            url : '/api2/items-by-variation',
            data : { variation_id : variation_id }
        })
        .success(function( data ){

            var items = JSON.parse(data);
            var newElem = '';

            $.each( sizes, function( k, size ) {
                var exists = false;
                $.each( items, function( id, itemCheck ) {
                    if (size.id == itemCheck.size_id)
                        exists = true;
                });
                if (exists) {
                    $.each( items, function( id, item ) {
                            // if item exhists with size
                            if (size.id == item.size_id) {
                                newElem += '<td class="fast-sizes-td"><input type="number" min="0" class="form-control" name="'+item.id+'" data-price="'+item.price+'" placeholder="'+size.name+'"/></td>';
                            }
                        });
                } else {
                    newElem += '<td class="fast-sizes-td"></td>';
                }
 
            });

            thisSelector.parent().parent().find('td.fast-sizes-td').remove();
            thisSelector.parent().parent().append(newElem);

        })
        .error(function(){
            toastr.error('ajax error');
        });

    });

    function updateTotals() {
        var tot = 0;
        var price = 0;
        $("tr:not('.no-count') :input:not('select')").each(function() {
            if(!isNaN($(this).val())) { 
            //Your code 
                tot += +this.value;
            }
            if(!isNaN($(this).data('price'))) { 
                price += Number($(this).attr('data-price')*this.value);
            }
        });
        $('#tot-qty').text(tot);
        $('#tot-price').text(price.format());

        var colTotals=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
                        0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        
        var $dataRows=$("tr:not('.no-count')");

        $dataRows.each(function(i) {
            $(this).find("td > input").each(function(j){  
                colTotals[j]+= Number($(this).val());
            });
        });

        $("th.th-total-count").each(function(i){  
            if (colTotals[i] !== 0)
                $(this).html(colTotals[i]);
            else
                $(this).html('');
        });

    }

    $('body').on('change', 'input', function() {
        updateTotals();
    }).change();

    $(document).ready(function(){
        updateTotals();
    })

    $('#button-save-line').on('click', function(e){
        e.preventDefault();
        $("#lines-form").ajaxSubmit({
            url : '/orders/new/save-fast', 
            type : 'POST',
            target : '#order-infos',
            success: toastr.success("{{trans('x.Order updated')}}"),
        });
    });

</script>