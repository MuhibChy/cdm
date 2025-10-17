<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "cdms"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get gender data
function getGenderData($conn) {
    $query = "SELECT gender, COUNT(*) as count FROM customers GROUP BY gender";
    $result = $conn->query($query);

    $genderData = [];
    while ($row = $result->fetch_assoc()) {
        $genderData[] = $row;
    }

    return $genderData;
}

// Function to get customer type data
function getCustomerTypeData($conn) {
    $query = "SELECT customer_type, COUNT(*) as count FROM customer_orders GROUP BY customer_type";
    $result = $conn->query($query);

    $customerTypeData = [];
    while ($row = $result->fetch_assoc()) {
        $customerTypeData[] = $row;
    }

    return $customerTypeData;
}

// Fetch gender and customer type data
$genderData = getGenderData($conn);
$customerTypeData = getCustomerTypeData($conn);

// Close connection
$conn->close();

// Combine data into one response
$response = [
    'genderData' => $genderData,
    'customerTypeData' => $customerTypeData
];

// Output data as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
