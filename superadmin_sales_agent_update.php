<?php
// Include your database connection file
include 'conn.php';

// Response array
$response = array();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security

    $updateAgentId = mysqli_real_escape_string($conn, $_POST['agent_id']);
    $updateFirstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $updateMiddleInitial = mysqli_real_escape_string($conn, $_POST['middle_initial']);
    $updateLastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $updateGender = mysqli_real_escape_string($conn, $_POST['gender']);
    $updateManagerId = mysqli_real_escape_string($conn, $_POST['manager_id']);

    // Update query
    $sql = "UPDATE sales_agents SET firstname='$updateFirstname', middle_initial='$updateMiddleInitial', lastname='$updateLastname', gender='$updateGender', manager_id='$updateManagerId' WHERE agent_id='$updateAgentId'";        

    if (mysqli_query($conn, $sql)) {
        // If update is successful, send success response
        $response['status'] = 'success';
        $response['message'] = 'Sales manager updated successfully!';
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
