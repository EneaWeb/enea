<script>
    // number format function for currency in stats
    Number.prototype.formatMoney = function(c, d, t){
    var n = this, 
        c = isNaN(c = Math.abs(c)) ? 2 : c, 
        d = d == undefined ? "." : d, 
        t = t == undefined ? "," : t, 
        s = n < 0 ? "-" : "", 
        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
        j = (j = i.length) > 3 ? j % 3 : 0;
       return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
     };
     
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

</script>
@yield('more_scripts')
@yield('more_scripts2')
@yield('more_scripts3')
@yield('more_scripts4')
@yield('more_scripts5')