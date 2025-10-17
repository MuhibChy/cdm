<script>
    $(document).ready(function() {
      $("#customerOrdersTable").DataTable({
        "pageLength": 5,
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false
      }).buttons().container().appendTo('#customerOrdersTable_wrapper .col-md-6:eq(0)');

      $('#managerSelect').on('change', function() {
        var manager_id = $(this).val();
        if (manager_id) {
          $.ajax({
            url: 'user_fetch_agents.php',
            type: 'POST',
            data: { manager_id: manager_id },
            success: function(response) {
              $('#agentSelect').html(response);
            }
          });
        } else {
          $('#agentSelect').html('<option value="">Select Sales Agent</option>');
        }
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
      window.fillUpdateCustomerOrder = function(order_id, delivery_reference_number, date_closed, order_status) {
        $('#updateOrderId').val(order_id);
        $('#updateDeliveryReferenceNumber').val(delivery_reference_number);
        $('#updateClosedDate').val(date_closed);
        $('#updateOrderStatus').val(order_status);
      };

      $('#updateCustomerOrderForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
          type: 'POST',
          url: 'user_closed_update.php',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
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

      window.recoverOrder = function(orderId) {
        Swal.fire({
          title: 'Are you sure?',
          text: "You want to recover this order?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, recover it!'
        }).then((result) => {
          if (result.isConfirmed) {
            // Make an AJAX call to update the order status
            fetch('user_void_transaction.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
              },
              body: new URLSearchParams({
                'order_id': orderId,
                'order_status': 'Leads Generation'
              })
            })
            .then(response => response.json())
            .then(data => {
              if (data.status === 'success') {
                Swal.fire(
                  'Recovered!',
                  'The order has been recovered.',
                  'success'
                ).then(() => {
                  location.reload(); // Reload the page to reflect the changes
                });
              } else {
                Swal.fire(
                  'Error!',
                  data.message,
                  'error'
                );
              }
            })
            .catch(error => {
              Swal.fire(
                'Error!',
                'There was an error updating the order.',
                'error'
              );
            });
          }
        });
      };
    });
  </script>