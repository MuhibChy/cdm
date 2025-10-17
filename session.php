<?php
session_start();
include 'conn.php';

// Redirect to index.php if user role is not 'user'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'superadmin') {
    header('location: index.php');
    exit();
}

// Fetch user details from session
$user_id = $_SESSION['user_id'];
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$profile_photo = $_SESSION['profile_photo'];
$department_assignment = $_SESSION['department_assignment'];
$id_number = $_SESSION['id_number'];
$email = $_SESSION['email'];
$contact_number = $_SESSION['contact_number'];
$gender = $_SESSION['gender'];
$nickname = $_SESSION['nickname'];


// Retrieve user details from database based on session user ID
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Update session variables with fetched data for consistency
    $_SESSION['firstname'] = $row['firstname'];
    $_SESSION['lastname'] = $row['lastname'];
    $_SESSION['profile_photo'] = $row['profile_photo'];

    // Assign variables for use in the page
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $profile_photo = $row['profile_photo']; // Assuming the profile picture is stored in database
} else {
    // Handle error if user is not found
    echo "Error: User not found";
}

date_default_timezone_set('Asia/Manila');

// Logout handling
if (isset($_POST['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to login page after logout
    header("location: index.php");
    exit();
}

/// Query to get count of users per role (excluding 'superadmin')
$sql = "SELECT role, COUNT(*) as count FROM users WHERE role != 'superadmin' GROUP BY role";
$result = $conn->query($sql);

$roles = [];
$count = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $roles[] = $row['role'];
        $count[] = $row['count'];
    }
} else {
    echo "No users found";
}

?>