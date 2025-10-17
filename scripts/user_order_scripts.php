<script>
    $(document).ready(function() {
        $("#customerOrdersTable").DataTable({
            "order": [[0, "desc"]], // Sort by the first column (ID) in descending order
            "pageLength": 5,
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false
        }).buttons().container().appendTo('#customerOrdersTable_wrapper .col-md-6:eq(0)');

        // Optional: Add your other functions here, like getCustomerDetails and confirmLogout
    });


    $(document).ready(function() {
    $('#managerSelect').on('change', function() {
        var manager_id = $(this).val();
        if (manager_id) {
            $.ajax({
                url: 'user_fetch_agents.php',
                type: 'POST',
                data: {manager_id: manager_id},
                success: function(response) {
                    $('#agentSelect').html(response);
                }
            });
        } else {
            $('#agentSelect').html('<option value="">Select Sales Agent</option>');
        }
    });
    });

    // Function to view customer order details
        window.viewCustomerOrderDetails = function(order_id) {
            $.ajax({
                url: 'user_get_customer_order_details.php',
                type: 'POST',
                data: { order_id: order_id },
                success: function(response) {
                    $('#customerOrderDetailsModal .modal-body').html(response);
                    $('#customerOrderDetailsModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        };

        // Function to fill Update Customer Order Modal
window.fillUpdateCustomerOrder = function(order_id, payment_reference_number, sales_order_reference_number, payment_remarks, warehouse_email, order_status) {
    $('#updateOrderId').val(order_id);
    
    $('#updatePaymentReferenceNumber').val(payment_reference_number);
    $('#updateSalesOrderReferenceNumber').val(sales_order_reference_number);
    $('#updatePaymentRemarks').val(payment_remarks);
    $('#updateWarehouseEmail').val(warehouse_email);
    $('#updateOrderStatus').val(order_status);
}


$(document).ready(function() {
        $('#updateCustomerOrderForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: 'user_payment_update.php',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                console.log(response); // Debugging line
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        $('#updateCustomerOrderModal').modal('hide');
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText); // Debugging line
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong.',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        });
    });
});


        $(document).ready(function() {
    // Function to filter orders by date
    $('#orderDate').change(function() {
        var selectedDate = $(this).val();

        // AJAX call to fetch filtered orders
        $.ajax({
            url: 'user_filter_date_orders.php',
            type: 'POST',
            data: { orderDate: selectedDate },
            success: function(response) {
                $('#customerOrdersTable tbody').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
});

        $(function () {
    bsCustomFileInput.init();
        })
</script>