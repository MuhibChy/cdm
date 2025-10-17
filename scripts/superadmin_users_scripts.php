<script>
$(document).ready(function() {
    $("#usersTable").DataTable({
        "responsive": true, 
        "lengthChange": false, 
        "autoWidth": false,
        "buttons": []
    }).buttons().container().appendTo('#usersTable_wrapper .col-md-6:eq(0)');

    $('#createForm').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this); // Use FormData to include file uploads

        $.ajax({
            type: 'POST',
            url: 'superadmin_user_create.php',
            data: formData,
            processData: false,
            contentType: false,
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
                        $('#createModal').modal('hide');
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

function fillUpdateForm(user_id, firstname, lastname, username, role, department_assignment, id_number) {
        $('#update_user_id').val(user_id);
        $('#update_firstname').val(firstname);
        $('#update_lastname').val(lastname);
        $('#update_username').val(username);
        $('#update_role').val(role);
        $('#update_department_assignment').val(department_assignment);
        $('#update_id_number').val(id_number);
    }

// AJAX submission for updating customer records
    function submitUpdateForm() {
      var formData = $('#updateForm').serialize();

      $.ajax({
        url: 'superadmin_user_update.php',
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

$(document).ready(function() {
    // Add click event listener to dynamically created delete buttons
    $(document).on('click', '.deleteBtn', function() {
        let userId = $(this).data('id');
        Swal.fire({
            title: 'Delete User Record',
            text: 'Are you sure you want to delete this user? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ae0d01',
            cancelButtonColor: '#535353',
            confirmButtonText: 'Delete Record',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteCustomer(userId); // Call delete function
            }
        });
    });

    // Function to delete user via AJAX
    function deleteCustomer(userId) {
        $.ajax({
            url: 'superadmin_user_delete.php', // Ensure this matches your server script
            type: 'POST',
            data: { user_id: userId },
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'User has been deleted successfully.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        // Reload table or remove the row from the DOM
                        location.reload(); // Reload page to update the table
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to delete user.',
                    icon: 'error',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    }
});

</script>