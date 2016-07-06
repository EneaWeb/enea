<script>
    function confirm_unlink_user(userid){
        alertify.confirm( "{!!trans('validation.Please Confirm')!!}", "{!!trans('validation.Are you sure you want to unlink the user from your brand?')!!}", 
            function () {
                // positive
                window.location.href = "/admin/unlink-user-from-brand/"+userid;
            }, 
            function() {
                ; // negative// do nothing 
            }
        );
    };
    
    function confirm_delete_delivery(id){
        alertify.confirm( "{!!trans('validation.Please Confirm')!!}", "{!!trans('validation.Are you sure you want to delete this date?')!!}", 
            function () {
                // positive
                window.location.href = "/catalogue/seasons/delivery/delete-delivery/"+id;
            }, 
            function() {
                ; // negative// do nothing 
            }
        );
    };
        
    function confirm_delete_list(id){
        alertify.confirm( "{!!trans('validation.Please Confirm')!!}", "{!!trans('validation.Are you sure you want to delete this price list?')!!}", 
            function () {
                // positive
                window.location.href = "/catalogue/seasons/list/delete-list/"+id;
            }, 
            function() {
                ; // negative// do nothing 
            }
        );
    };
    
    function confirm_delete_payment(id){
        alertify.confirm( "{!!trans('validation.Please Confirm')!!}", "{!!trans('validation.Are you sure you want to delete this payment option?')!!}", 
            function () {
                // positive
                window.location.href = "/admin/payment/delete/"+id;
            }, 
            function() {
                ; // negative// do nothing 
            }
        );
    };
    
    function confirm_delete_model(id){
        alertify.confirm( "{!!trans('validation.Please Confirm')!!}", "{!!trans('validation.Are you sure you want to delete this model?')!!}", 
            function () {
                // positive
                window.location.href = "/catalogue/model/delete/"+id;
            }, 
            function() {
                ; // negative// do nothing 
            }
        );
    };
    
    function confirm_delete_variation(id){
        alertify.confirm( "{!!trans('validation.Please Confirm')!!}", "{!!trans('validation.Are you sure you want to delete this variation?')!!}", 
            function () {
                // positive
                window.location.href = "/catalogue/variation/delete/"+id;
            }, 
            function() {
                ; // negative// do nothing 
            }
        );
    };
    
    function confirm_delete_color(id){
        alertify.confirm( "{!!trans('validation.Please Confirm')!!}", "{!!trans('validation.Are you sure you want to delete this color?')!!}", 
            function () {
                // positive
                window.location.href = "/catalogue/color/delete/"+id;
            }, 
            function() {
                ; // negative// do nothing 
            }
        );
    };
    
    function confirm_delete_size(id){
        alertify.confirm( "{!!trans('validation.Please Confirm')!!}", "{!!trans('validation.Are you sure you want to delete this size?')!!}", 
            function () {
                // positive
                window.location.href = "/catalogue/size/delete/"+id;
            }, 
            function() {
                ; // negative// do nothing 
            }
        );
    };
    
    function confirm_remove_product_picture(id){
        alertify.confirm( "{!!trans('validation.Please Confirm')!!}", "{!!trans('validation.Are you sure you want to delete this picture?')!!}", 
            function () {
                // positive
                window.location.href = "/catalogue/product/delete-picture/"+id;
            }, 
            function() {
                ; // negative// do nothing 
            }
        );
    };
    
    function confirm_remove_variation_picture(id){
        alertify.confirm( "{!!trans('validation.Please Confirm')!!}", "{!!trans('validation.Are you sure you want to delete this picture?')!!}", 
            function () {
                // positive
                window.location.href = "/catalogue/product/delete-variation-picture/"+id;
            }, 
            function() {
                ; // negative// do nothing 
            }
        );
    };
        
    function confirm_delete_customer_delivery(id){
        alertify.confirm( "{!!trans('validation.Please Confirm')!!}", "{!!trans('validation.Are you sure you want to delete this option?')!!}", 
            function () {
                // positive
                window.location.href = "/customer/delete-delivery/"+id;
            }, 
            function() {
                ; // negative// do nothing 
            }
        );
    };
    
    function confirm_delete_order(id){
        alertify.confirm( "{!!trans('validation.Please Confirm')!!}", "{!!trans('validation.Are you sure you want to delete this order?')!!}", 
            function () {
                // positive
                window.location.href = "/order/delete-order/"+id;
            }, 
            function() {
                ; // negative// do nothing 
            }
        );
    };

    $( window ).load(function() {
        $.getJSON('/customers/api-companyname', function(data) {
            $( "#customer-autocomplete" ).autocomplete({
                source: data
            });
        });
        $.getJSON('/customers/api-sign', function(data) {
            $( "#sign-autocomplete" ).autocomplete({
                source: data
            });
        });
        $.getJSON('/customers/api-companyname', function(data) {
            $( "#customer-full-autocomplete" ).autocomplete({
                source: data,
                select: function(event, ui) {
                    if(ui.item){
                        
                        $.ajax({
                            type: 'GET',
                            data: {
                                'companyname' : ui.item.value,
                                format: 'json'
                            },
                            url: '/customers/api-customer-data',
                            success: function(data) {
                                parsed = JSON.parse(data);
                                $('#name').val(parsed.name);
                                $('#surname').val(parsed.surname);
                                $('#address').val(parsed.address+' '+parsed.postcode+' '+parsed.city+' - '+parsed.country);
                                $('#sign').val(parsed.sign);
                                $('#surname').val(parsed.surname);
                                $('#vat').val(parsed.vat);
                                $('#telephone').val(parsed.telephone);
                                $('#mobile').val(parsed.mobile);
                                $('#email').val(parsed.email);
                                // current locale
                                currentlocale = $('#getcurrentlocale').text()
                                // CONTINUE button href
                                $('.goto-step2').attr("href", "/order/new/step2?id="+parsed.id);
                            },
                            error: function() {
                                console.log('ajax error');
                            }
                        });
                        
                    }
                }
            });
        });
    });
        
</script>