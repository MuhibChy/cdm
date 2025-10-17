<?php
// Include your database connection file
include 'conn.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure the required POST parameter is set
    if (isset($_POST['deleteCustomerId']) && !empty($_POST['deleteCustomerId'])) {
        // Escape user input for security
        $customerId = $_POST['deleteCustomerId'];

        // Prepare the delete statement
        $stmt = $conn->prepare("DELETE FROM customers WHERE customer_id = ?");
        $stmt->bind_param("i", $customerId); // "i" denotes the type is integer

        if ($stmt->execute()) {
            // If deletion is successful, redirect to admin_customers.php or any desired page
            header('Location: admin_customers.php');
            exit();
        } else {
            // If there's an error with the query, display an error message
            echo "Error deleting record: " . $stmt->error;
        }

        // Close statement and connection
        $stmt->close();
    } else {
        echo "Invalid customer ID.";
    }

    $conn->close();
}
?>
