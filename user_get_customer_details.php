<?php
include 'conn.php';

if (isset($_POST['customer_id'])) {
    $customerId = $_POST['customer_id'];

    // Ensure customer_id is not empty and valid
    if (!empty($customerId) && is_numeric($customerId)) {
        // Escape user input for security
        $customerId = mysqli_real_escape_string($conn, $customerId);

        // Query to fetch customer details
        $sql = "SELECT * FROM customers WHERE customer_id = $customerId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Display customer details in form fields
            echo "
                <div class='form-row'>
                <div class='form-group col-md-12'>
                    <label for='company_name' style='font-size:12px;'>Company Name</label>
                    <input type='text' class='form-control form-control-sm' id='company_name' name='company_name' value='" . $row['company_name'] . "' readonly style='font-size:12px; text-transform: capitalize;'>
                </div>
                <div class='form-group col-md-4'>
                    <label for='firstname' style='font-size:12px;'>First Name</label>
                    <input type='text' class='form-control form-control-sm' id='firstname' name='firstname' value='" . $row['firstname'] . "' readonly style='font-size:12px; text-transform: capitalize;'>
                </div>
                <div class='form-group col-md-4'>
                    <label for='lastname' style='font-size:12px;'>Last Name</label>
                    <input type='text' class='form-control form-control-sm' id='lastname' name='lastname' value='" . $row['lastname'] . "' readonly style='font-size:12px; text-transform: capitalize;'>
                </div>
                <div class='form-group col-md-4'>
                    <label for='middle_initial' style='font-size:12px;'>Middle Initial</label>
                    <input type='text' class='form-control form-control-sm' id='middle_initial' name='middle_initial' value='" . $row['middle_initial'] . "' readonly style='font-size:12px;'>
                </div>
                <div class='form-group col-md-6'>
                    <label for='contact_number' style='font-size:12px;'>Contact Number</label>
                    <input type='text' class='form-control form-control-sm' id='contact_number' name='contact_number' value='" . $row['contact_number'] . "' readonly style='font-size:12px;'>
                </div>
                <div class='form-group col-md-6'>
                    <label for='email_address' style='font-size:12px;'>Email Address</label>
                    <input type='email' class='form-control form-control-sm' id='email_address' name='email_address' value='" . $row['email_address'] . "' readonly style='font-size:12px;'>
                </div>
                <div class='form-group col-md-12'>
                    <label for='gender' style='font-size:12px;'>Gender</label>
                    <input type='text' class='form-control form-control-sm' id='gender' name='gender' value='" . $row['gender'] . "' readonly style='font-size:12px;'>
                </div>
                <div class='form-group col-md-12'>
                    <label for='city_address' style='font-size:12px;'>City Address</label>
                    <input type='text' class='form-control form-control-sm' id='city_address' name='city_address' value='" . $row['city_address'] . "' readonly style='font-size:12px; text-transform: capitalize;'>
                </div>
                </div>
            ";
        } else {
            echo "<p>No customer found with ID: $customerId</p>";
        }
    } else {
        echo "<p style='font-size:10px; color:red;'>Please Select Customer</p>";
    }
} else {
    echo "<p>Customer ID not provided</p>";
}

// Close connection
mysqli_close($conn);
?>
