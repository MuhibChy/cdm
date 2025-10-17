<?php
// Include your database connection file
include 'conn.php';

// Check if email is set and not empty
if (isset($_POST['email']) && !empty($_POST['email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if email exists in customers table
    $checkEmailQuery = "SELECT * FROM customers WHERE email_address = '$email'";
    $result = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($result) > 0) {
        // Email address exists
        echo 'exists';
    } else {
        // Email address does not exist
        echo 'available';
    }
} else {
    // Email not provided or empty
    echo 'error';
}

// Close connection
mysqli_close($conn);
?>
