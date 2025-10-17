<?php
session_start();

// Include database connection
include 'conn.php';

// Redirect to index.php if user role is not 'admin'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('location: index.php');
    exit();
}

// Session timeout management (e.g., 30 minutes)
$inactive = 1800; // 30 minutes in seconds
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $inactive) {
    session_unset();     // Unset $_SESSION variable for the run-time 
    session_destroy();   // Destroy session data in storage
    header('location: index.php');
    exit();
}
$_SESSION['last_activity'] = time(); // Update last activity time stamp

// Regenerate session ID to prevent session fixation
if (!isset($_SESSION['created'])) {
    $_SESSION['created'] = time();
} elseif (time() - $_SESSION['created'] > 1800) { // Regenerate session ID every 30 minutes
    session_regenerate_id(true); // Change session ID for the current session and invalidate old session ID
    $_SESSION['created'] = time(); // Update creation time
}

// Fetch user details from session
$user_id = $_SESSION['user_id'];
$firstname = htmlspecialchars($_SESSION['firstname'], ENT_QUOTES, 'UTF-8');
$lastname = htmlspecialchars($_SESSION['lastname'], ENT_QUOTES, 'UTF-8');
$profile_photo = htmlspecialchars($_SESSION['profile_photo'], ENT_QUOTES, 'UTF-8');
$department_assignment = htmlspecialchars($_SESSION['department_assignment'], ENT_QUOTES, 'UTF-8');
$id_number = htmlspecialchars($_SESSION['id_number'], ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($_SESSION['email'], ENT_QUOTES, 'UTF-8');
$contact_number = htmlspecialchars($_SESSION['contact_number'], ENT_QUOTES, 'UTF-8');
$gender = htmlspecialchars($_SESSION['gender'], ENT_QUOTES, 'UTF-8');
$nickname = htmlspecialchars($_SESSION['nickname'], ENT_QUOTES, 'UTF-8');

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
    $firstname = htmlspecialchars($row['firstname'], ENT_QUOTES, 'UTF-8');
    $lastname = htmlspecialchars($row['lastname'], ENT_QUOTES, 'UTF-8');
    $profile_photo = htmlspecialchars($row['profile_photo'], ENT_QUOTES, 'UTF-8'); // Assuming the profile picture is stored in the database
} else {
    // Handle error if user is not found
    echo "Error: User not found";
}

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
?>
