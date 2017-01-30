var TableDatatablesButtons = function() {

    var currentLocale = $('#getcurrentlocale').text();
    var languageUrl = "/assets/js/plugins/datatables/"+currentLocale+".json";

    var dashboardOrders = function() {
        var table = $('#dashboard-orders');

        var oTable = table.dataTable({

            "language": { "url": languageUrl },

            buttons: [
                { extend: 'print', className: 'btn dark btn-outline', exportOptions: { columns: ':visible' } },
                { extend: 'copy', className: 'btn red btn-outline', exportOptions: { columns: ':visible' } },
                { extend: 'pdf', className: 'btn green btn-outline', exportOptions: { columns: ':visible' } },
                { extend: 'excel', className: 'btn yellow btn-outline', exportOptions: { columns: ':visible' } },
                { extend: 'csv', className: 'btn purple btn-outline', exportOptions: { columns: ':visible' } },
                { extend: 'colvis', className: 'btn brown btn-outline', text: '<i class="fa fa-table"></i>', exportOptions: { columns: ':visible' } },
            ],

            // setup responsive extension: http://datatables.net/extensions/responsive/
            responsive: true,

            //"ordering": false, disable column ordering 
            //"paging": false, disable pagination

            "order": [
                [0, 'desc']
            ],

            "lengthMenu": [
                [5, 10, 15, 20, 30, -1],
                [5, 10, 15, 20, 30, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 15,

            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizontal scrollable datatable
            
        });
    }

    var customersList = function() {
        var table = $('#customers-list');

        var oTable = table.dataTable({

            "language": { "url": languageUrl },

            buttons: [
                { extend: 'print', className: 'btn dark btn-outline', exportOptions: { columns: ':visible' } },
                { extend: 'copy', className: 'btn red btn-outline', exportOptions: { columns: ':visible' } },
                { extend: 'pdf', className: 'btn green btn-outline', exportOptions: { columns: ':visible' } },
                { extend: 'excel', className: 'btn yellow btn-outline', exportOptions: { columns: ':visible' } },
                { extend: 'csv', className: 'btn purple btn-outline', exportOptions: { columns: ':visible' } },
                { extend: 'colvis', className: 'btn brown btn-outline', text: '<i class="fa fa-table"></i>', exportOptions: { columns: ':visible' } },
            ],

            // setup responsive extension: http://datatables.net/extensions/responsive/
            responsive: true,

            //"ordering": false, disable column ordering 
            //"paging": false, disable pagination

            "order": [
                [0, 'asc']
            ],

            "lengthMenu": [
                [10, 20, 30, 40, -1],
                [10, 20, 30, 40, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 20,

            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizontal scrollable datatable

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        });
    }

    var customerOrders = function() {
        var table = $('#customer-orders');

        var oTable = table.dataTable({

            "language": { "url": languageUrl },

            // setup responsive extension: http://datatables.net/extensions/responsive/
            responsive: true,

            //"ordering": false, disable column ordering 
            //"paging": false, disable pagination

            "order": [
                [0, 'desc']
            ],

            "lengthMenu": [
                [5, 10, 15, 20, 30, -1],
                [5, 10, 15, 20, 30, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 15,

            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizontal scrollable datatable

        });
    }

    return {

        //main function to initiate the module
        init: function() {

            if (!jQuery().dataTable) {
                return;
            }

            dashboardOrders();
            customerOrders();
            customersList();
        }

    };

}();

jQuery(document).ready(function() {
    TableDatatablesButtons.init();
});