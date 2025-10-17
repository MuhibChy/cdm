<script>
    // DataTable initialization
    $(document).ready(function() {
      $("#usersTable1").DataTable({
        "order": [[0, "desc"]], // Sort by the first column (ID) in descending order
        "pageLength": 5,
        "responsive": true, 
        "lengthChange": false, 
        "autoWidth": false,
        "buttons": []
      }).buttons().container().appendTo('#usersTable1_wrapper .col-md-6:eq(0)');
    });

    // Logout confirmation
    function confirmLogout() {
      if (confirm("Are you sure you want to logout?")) {
        window.location.href = 'logout.php';
      }
    }

    // Fill update form with customer details
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

    // AJAX submission for updating customer records
    function submitUpdateForm() {
      var formData = $('#updateCustomerForm').serialize();

      $.ajax({
        url: 'user_update_customer.php',
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

    // AJAX submission for creating customer records
    $(document).ready(function() {
      $('#createCustomerForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
          type: 'POST',
          url: 'user_create_customer.php',
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

    // AJAX submission for deleting customer records
    // Pag-click ng Delete button
    document.querySelectorAll('.deleteBtn').forEach(btn => {
    btn.addEventListener('click', function() {
      let customerId = this.getAttribute('data-id');
      Swal.fire({
        title: 'Delete Client Record',
        text: 'Are you sure you want to delete this client information? This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ae0d01',
        cancelButtonColor: '#535353',
        confirmButtonText: 'Delete Record',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          deleteCustomer(customerId); // Tawagin ang delete function dito
        }
      });
    });
  });

  // Function para sa pag-delete ng customer gamit ang AJAX
  function deleteCustomer(customerId) {
    // AJAX request para mag-delete ng customer
    $.ajax({
      url: 'user_delete_customer.php', // Palitan ang 'delete_customer.php' ng tamang endpoint sa iyong server
      type: 'POST',
      data: { customer_id: customerId },
      success: function(response) {
        // Kung ang delete ay matagumpay
        Swal.fire({
          title: 'Deleted!',
          text: 'Customer has been deleted successfully.',
          icon: 'success',
          timer: 1500,
          showConfirmButton: false
        });
        // Optional: Dito ilalagay ang code para mag-refresh ng table o i-remove ang row na na-delete
        // Halimbawa:
        // document.getElementById('row_' + customerId).remove();
      },
      error: function(xhr, status, error) {
        // Kung may error sa delete
        Swal.fire({
          title: 'Error!',
          text: 'Failed to delete customer.',
          icon: 'error',
          timer: 1500,
          showConfirmButton: false
        });
      }
    });
  }
  </script>