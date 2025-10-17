<script>
    $(document).ready(function() {
        $("#managersTable").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "buttons": []
        }).buttons().container().appendTo('#managersTable_wrapper .col-md-6:eq(0)');

        $("#agentsTables").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false
        }).buttons().container().appendTo('#agentsTables_wrapper .col-md-6:eq(0)');
    });

    function confirmLogout() {
        if (confirm("Are you sure you want to logout?")) {
            window.location.href = 'logout.php';
        }
    }

    function fillUpdateForm(id, firstname, middle_initial, lastname, gender) {
        $('#updateManagerId').val(id);
        $('#updateManagerFirstname').val(firstname);
        $('#updateManagerMiddleInitial').val(middle_initial);
        $('#updateManagerLastname').val(lastname);
        $('#updateManagerGender').val(gender);
    }

    function submitUpdateForm() {
        var formData = $('#updateManagerForm').serialize();

        $.ajax({
            url: 'superadmin_update_manager.php',
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
            let managerId = this.getAttribute('data-id');
            Swal.fire({
                title: 'Delete Manager Record',
                text: 'Are you sure you want to delete this Manager information? This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ae0d01',
                cancelButtonColor: '#535353',
                confirmButtonText: 'Delete Record',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteCustomer(managerId); // Call the delete function here
                }
            });
        });
    });

    function deleteCustomer(managerId) {
        $.ajax({
            url: 'superadmin_delete_manager.php',
            type: 'POST',
            data: { manager_id: managerId },
            success: function(response) {
                Swal.fire({
                    title: 'Deleted!',
                    text: 'Manager has been deleted successfully.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
                // Optional: Refresh the table or remove the deleted row
                // Example: document.getElementById('row_' + managerId).remove();
            },
            error: function(xhr, status, error) {
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
        $('#createManagerForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: 'superadmin_create_manager.php',
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
                            $('#createManagerModal').modal('hide');
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

    function viewManagerDetails(managerId) {
    $.ajax({
        url: 'fetch_manager_details.php',
        type: 'GET',
        data: { manager_id: managerId },
        success: function(response) {
            const data = JSON.parse(response);
            const manager = data.manager;
            const agents = data.agents;

            $('#managerId').val(manager.manager_id);
            $('#managerFirstName').val(manager.firstname);
            $('#managerMiddleInitial').val(manager.middle_initial);
            $('#managerLastName').val(manager.lastname);
            $('#managerGender').val(manager.gender);

            let agentsTableContent = '';
            agents.forEach(agent => {
                agentsTableContent += `
                    <tr>
                        <td>${agent.agent_id}</td>
                        <td>${agent.firstname}</td>
                        <td>${agent.middle_initial}</td>
                        <td>${agent.lastname}</td>
                        <td>${agent.gender}</td>
                    </tr>
                `;
            });

            // Destroy the existing DataTable if it exists
            if ($.fn.DataTable.isDataTable('#agentsTables')) {
                $('#agentsTables').DataTable().clear().destroy();
            }

            $('#agentsTables tbody').html(agentsTableContent);

            // Re-initialize DataTable
            $('#agentsTables').DataTable({
                "responsive": true, 
                "lengthChange": false, 
                "autoWidth": false
            });

            $('#viewManagerModal').modal('show');
        }
    });
}


</script>
