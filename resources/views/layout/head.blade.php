    <!-- BEGIN HEAD -->
    <head>
    <meta charset="utf-8" />
    <title>{!! Config::get('app.name') !!}{!!(isset($pageTitle)) ? ' | '.$pageTitle : '' !!}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN LAYOUT FIRST STYLES -->
    <link href="/assets/css/oswald.css" rel="stylesheet" type="text/css" />
    <!-- END LAYOUT FIRST STYLES -->
    <!-- BEGIN GLOBAL MANDATORY STYLES -->

    <link href="/assets/global/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css" />
    
    <link href="/assets/css/open-sans.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <link href="/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/jquery-colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    {{ HTML::style('/assets/css/flag-icon.min.css') }}
    <link href="/assets/global/plugins/cubeportfolio/css/cubeportfolio.css" rel="stylesheet" type="text/css" />
    <link href="/assets/pages/css/portfolio.min.css" rel="stylesheet" type="text/css" />
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="/assets/global/css/components-md.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="/assets/global/css/plugins-md.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="/assets/pages/css/profile-2.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/layouts/layout5/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/layouts/layout5/css/custom.min.css" rel="stylesheet" type="text/css" />

    <link href="/assets/pages/css/invoice-2.min.css" rel="stylesheet" type="text/css" />

    <link href="/assets/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css" />

    {{ HTML::style('/assets/global/plugins/bootstrap-toastr/toastr.min.css') }}

    {{ HTML::style('/assets/css/alertify.min.css') }}
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="/favicon.ico" /> 
    <!-- END HEAD -->

    <style>

    .select2-results__option {
        padding-left:10px!important;
    }

    .select2-results__group {
        color:black!important;
        font-size:14px!important;
        padding-left:0px!important;
    }

    .boxclose {
        background-color:#d41515;
        font-size:10px;
        line-height:1;
        padding: 1px 6px 3px 6px;
        border-radius:50%;
        color:white;
        position:absolute;
        right:-4px;
        top:-4px;
        cursor:pointer;
        opacity:0.5;
    }

    .boxclose:hover,
    .boxclose:focus {
        opacity:1;
    }

    .deletable-pictures .deletable-picture {
        max-width:100px;
        display:inline-block;
        position:relative;
        margin:6px;
    }

    td.td-add-line {
        max-width: 50px!important;
        border:none!important;
        padding:0px!important;
    }

    td.td-add-line > input {
        height: 30px; 
        padding:0px 0px 0px 5px!important;
        text-align:center!important;
    }

    </style>

    <script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script>


    /**
    * Number.prototype.format(n, x, s, c)
    * 
    * @param integer n: length of decimal
    * @param integer x: length of whole part
    * @param mixed   s: sections delimiter
    * @param mixed   c: decimal delimiter
    */
    Number.prototype.format = function(n=2, x=3, s, c) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
            num = this.toFixed(Math.max(0, ~~n));

        return (c ? num.replace(',', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || '.'))+' €';
    };


    </script>
    </head>