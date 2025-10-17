<?php
// Include mo ang iyong database connection
include 'conn.php';

// Tingnan mo kung may POST request para sa customer_id
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['customer_id'])) {
    $customerId = $_POST['customer_id'];

    // Gumawa ng SQL query para ide-delete ang customer base sa customer_id
    $sql = "DELETE FROM customers WHERE customer_id = ?";

    // Prepare statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("i", $customerId);

    // Execute statement
    if ($stmt->execute()) {
        // Kung matagumpay ang pag-delete, magbalik ng success message
        echo json_encode(array("status" => "success", "message" => "Customer successfully deleted."));
    } else {
        // Kung may error sa pag-delete, magbalik ng error message
        echo json_encode(array("status" => "error", "message" => "Failed to delete customer."));
    }

    // Isara ang statement
    $stmt->close();
}

// Isara ang connection
$conn->close();
?>
