<script>
  $(document).ready(function() {
    // Initialize DataTable
    var table = $("#customerOrdersTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": [
            {
                extend: 'colvis',
                className: 'btn btn-primary btn-sm',
                text: '<i class="fa fa-eye-slash"></i> Column Visibility'
            }
        ]
    });

    // Initialize date range picker
    $('#reservation').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        startDate: moment().startOf('month'),
        endDate: moment().endOf('month')
    });

    // Handle date range changes
    $('#reservation').on('apply.daterangepicker', function(ev, picker) {
        var startDate = picker.startDate.format('YYYY-MM-DD');
        var endDate = picker.endDate.format('YYYY-MM-DD');

        $.ajax({
            url: 'fetch_orders.php', // PHP file handling table data
            type: 'POST',
            data: { start_date: startDate, end_date: endDate },
            success: function(response) {
                $('#customerOrdersTable tbody').html(response);
            }
        });
    });

    // Export filtered data function
    function exportFilteredData(customerType) {
        var dateRange = $('#reservation').data('daterangepicker');
        var startDate = dateRange.startDate.format('YYYY-MM-DD');
        var endDate = dateRange.endDate.format('YYYY-MM-DD');
        $.ajax({
            url: 'export_data.php',
            type: 'POST',
            data: {
                start_date: startDate,
                end_date: endDate,
                customer_type: customerType
            },
            success: function(response) {
                // Create a blob and a link to download the file
                var blob = new Blob([response], { type: 'text/csv' });
                var link = document.createElement("a");
                link.href = URL.createObjectURL(blob);
                link.download = "customer_orders_export.csv";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            },
            error: function(xhr, status, error) {
                console.error("Error: ", xhr.responseText);
            }
        });
    }

    // Export buttons click event
    $("#exportB2B").on("click", function() {
        exportFilteredData("B2B");
    });

    $("#exportB2C").on("click", function() {
        exportFilteredData("B2C");
    });

    $("#exportB2G").on("click", function() {
        exportFilteredData("B2G");
    });

    $("#exportMasterList").on("click", function() {
        var dateRange = $('#reservation').data('daterangepicker');
        var startDate = dateRange.startDate.format('YYYY-MM-DD');
        var endDate = dateRange.endDate.format('YYYY-MM-DD');
        $.ajax({
            url: 'export_master_list.php',
            type: 'POST',
            data: {
                start_date: startDate,
                end_date: endDate
            },
            success: function(response) {
                // Same blob handling as in exportFilteredData
                var blob = new Blob([response], { type: 'text/csv' });
                var link = document.createElement("a");
                link.href = URL.createObjectURL(blob);
                link.download = "customer_orders_master_list.csv";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            },
            error: function(xhr, status, error) {
                console.error("Error: ", xhr.responseText);
            }
        });
    });
});

</script>