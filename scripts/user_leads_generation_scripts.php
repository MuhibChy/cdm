<script>
    $(document).ready(function() {
        $("#customerOrdersTable").DataTable({
            "order": [[0, "desc"]], // Sort by the first column (ID) in descending order
            "pageLength": 5,
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "buttons": [] // No buttons initially
        }).buttons().container().appendTo('#customerOrdersTable_wrapper .col-md-6:eq(0)');

        // Function to filter orders by date
        $('#orderDate').change(function() {
            var selectedDate = $(this).val();

            // AJAX call to fetch filtered orders
            $.ajax({
                url: 'user_filter_date_leads.php',
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

        // Optional: Add your other functions here, like getCustomerDetails and confirmDeleteCustomerOrder
    });

    // AJAX submission for creating customer records
    $(document).ready(function() {
      $('#createCustomerOrderForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
          type: 'POST',
          url: 'user_customer_create_order.php',
          data: $(this).serialize(),
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
                $('#createCustomerOrderModal').modal('hide');
                location.reload();
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: response.message + (response.error ? ': ' + response.error : ''),
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

    // Fill update form with customer details
    function fillUpdateForm(order_id, reference_number, latest_engagement_date, remarks, uploaded_file, order_status) {
        $('#updateOrderId').val(order_id);
        $('#updateReferenceNumber').val(reference_number);
        $('#updateLatestEngagementDate').val(latest_engagement_date);
        $('#updateRemarks').val(remarks);
        $('#updateUploadedFile').val(uploaded_file);
        $('#updateOrderStatus').val(order_status);
    }

    $(document).ready(function() {
    $('#updateCustomerOrderForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: 'user_update_customer_order.php',
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
                        text: response.message + (response.error ? ': ' + response.error : ''),
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

    $(function () {
    bsCustomFileInput.init();
        });

    function getCustomerDetails(customerId) {
        // AJAX call to fetch customer details based on customer ID
        $.ajax({
            url: 'user_get_customer_details.php',
            type: 'POST',
            data: { customer_id: customerId },
            success: function(response) {
                $('#customerDetails').html(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

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

$(function () {
    $('#reservationdatetime').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        useCurrent: false
    });
});
</script>