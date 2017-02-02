var ComponentsColorPickers = function() {

    var handleColorPicker = function () {
        if (!jQuery().colorpicker) {
            return;
        }
        $('.colorpicker-default').colorpicker({
            color: "transparent",
            format: 'rgba'
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handleColorPicker();
        }
    };

}();

jQuery(document).ready(function() {    
   ComponentsColorPickers.init(); 
});