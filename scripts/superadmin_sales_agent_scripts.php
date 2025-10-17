<script>
     $(document).ready(function() {
            $("#agentsTable").DataTable({
                "responsive": true, 
                "lengthChange": false, 
                "autoWidth": false,
                "buttons": [
                
                ]
            }).buttons().container().appendTo('#agentsTable_wrapper .col-md-6:eq(0)');
        });

    function confirmLogout() {
        if (confirm("Are you sure you want to logout?")) {
            window.location.href = 'logout.php';
        }
    }

    // Fill update form with existing data
    window.fillUpdateForm = function(agent_id, firstname, middle_initial, lastname, gender, manager_id) {
        $('#updateAgentId').val(agent_id);
        $('#updateFirstname').val(firstname);
        $('#updateMiddleInitial').val(middle_initial);
        $('#updateLastname').val(lastname);
        $('#updateGender').val(gender);
        $('#updateManagerId').val(manager_id);
    };

    function submitUpdateForm() {
        var formData = $('#updateAgentForm').serialize();

        $.ajax({
            url: 'superadmin_sales_agent_update.php',
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

    document.querySelectorAll('.deleteBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                let agentId = this.getAttribute('data-id');
                Swal.fire({
                    title: 'Delete Agent Record',
                    text: 'Are you sure you want to delete this Agent information? This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ae0d01',
                    cancelButtonColor: '#535353',
                    confirmButtonText: 'Delete Record',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteCustomer(agentId); // Call the delete function here
                    }
                });
            });
        });
    
    // Function para sa pag-delete ng customer gamit ang AJAX
  function deleteCustomer(agentId) {
    // AJAX request para mag-delete ng customer
    $.ajax({
      url: 'superadmin_salest_agent_delete.php', // Palitan ang 'delete_customer.php' ng tamang endpoint sa iyong server
      type: 'POST',
      data: { agent_id: agentId },
      success: function(response) {
        // Kung ang delete ay matagumpay
        Swal.fire({
          title: 'Deleted!',
          text: 'Agents has been deleted successfully.',
          icon: 'success',
          timer: 1500,
          showConfirmButton: false
        });
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

    $(document).ready(function() {
        $('#createAgentForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: 'superadmin_sales_agent_create.php',
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
                            $('#createAgentModal').modal('hide');
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