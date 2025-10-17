<?php
// Include your database connection file
include 'conn.php';

// Response array
$response = array();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security

    $update_user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $update_firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $update_lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $update_username = mysqli_real_escape_string($conn, $_POST['username']);
    $update_role = mysqli_real_escape_string($conn, $_POST['role']);
    $update_department_assignment = mysqli_real_escape_string($conn, $_POST['department_assignment']);
    $update_id_number = mysqli_real_escape_string($conn, $_POST['id_number']);

    // Update query
    $sql = "UPDATE users SET firstname='$update_firstname', lastname='$update_lastname', username='$update_username', role='$update_role', department_assignment='$update_department_assignment', id_number='$update_id_number' WHERE user_id='$update_user_id'";        

    if (mysqli_query($conn, $sql)) {
        // If update is successful, send success response
        $response['status'] = 'success';
        $response['message'] = 'User updated successfully!';
    } else {
        // If there's an error with the query, send error response
        $response['status'] = 'error';
        $response['message'] = 'Error updating record: ' . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
} else {
    // Invalid request
    $response['status'] = 'error';
    $response['message'] = 'Invalid request.';
}

// Send response as JSON
echo json_encode($response);
?>
