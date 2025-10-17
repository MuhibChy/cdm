<script>
$(document).ready(function() {
    // Initialize DataTable
    $("#customerOrdersTable").DataTable({
        "order": [[0, "desc"]], // Sort by the first column (ID) in descending order
        "pageLength": 5,
        "responsive": true, 
        "lengthChange": false, 
        "autoWidth": false
    }).buttons().container().appendTo('#customerOrdersTable_wrapper .col-md-6:eq(0)');

    // Event listener for manager select change
    $('#managerSelect').on('change', function() {
        var manager_id = $(this).val();
        if (manager_id) {
            $.ajax({
                url: 'fetch_agents.php',
                type: 'POST',
                data: {manager_id: manager_id},
                success: function(response) {
                    $('#agentSelect').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
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
        url: 'user_get_customer_full_order_details.php',
        type: 'POST',
        data: { order_id: order_id },
        success: function(response) {
            $('#customerOrderDetailsModal .modal-body').html(response);
            $('#customerOrderDetailsModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', status, error);
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
</script>