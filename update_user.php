<?php
session_start();
include 'conn.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $role = $_POST['role'];
    $department_assignment = $_POST['department_assignment'];
    $id_number = $_POST['id_number'];

    // Update the user information
    $sql = "UPDATE users SET firstname = ?, lastname = ?, username = ?, role = ?, department_assignment = ?, id_number = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $firstname, $lastname, $username, $role, $department_assignment, $id_number, $user_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "User updated successfully!";
    } else {
        $_SESSION['error'] = "Failed to update user.";
    }

    $stmt->close();
}

header('Location: users.php');
exit();
?>
