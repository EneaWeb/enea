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
    <link href="/assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css" />
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
    <link href="/assets/layouts/layout5/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/layouts/layout5/css/custom.min.css" rel="stylesheet" type="text/css" />

    {{ HTML::style('/assets/global/plugins/bootstrap-toastr/toastr.min.css') }}

    {{ HTML::style('/assets/css/alertify.min.css') }}
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="/favicon.ico" /> 
    </head>
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

    </style>