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
          url: 'fetch_agents.php',
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

  function viewCustomerOrderDetails(order_id) {
    $.ajax({
      url: 'get_customer_order_details.php',
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
  }

  function fillUpdateForm(customer_id, company_name, firstname, middle_initial, lastname, contact_number, email_address, gender, city_address) {
    $('#updateCustomerId').val(customer_id);
    $('#updateCompanyName').val(company_name);
    $('#updateFirstName').val(firstname);
    $('#updateMiddleInitial').val(middle_initial);
    $('#updateLastName').val(lastname);
    $('#updateContactNumber').val(contact_number);
    $('#updateEmailAddress').val(email_address);
    $('#updateGender').val(gender);
    $('#updateCityAddress').val(city_address);
  }

  function submitUpdateForm() {
        var formData = $('#updateCustomerForm').serialize();

        $.ajax({
            url: 'admin_update_customer.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status == 'success') {
                    Swal.fire({
                        title: 'Success!',
                        text: res.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload(); // Reload the page to see the updated data
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: res.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while updating the customer.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    }

  function confirmDelete(customer_id) {
    $('#deleteCustomerId').val(customer_id);
  }


  $(document).ready(function() {
        $('#createForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: 'admin_create_customer.php',
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
                            $('#createCustomerModal').modal('hide');
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
</script>
