<?php
session_start();
session_regenerate_id(true);

// Include the database connection
include 'conn.php';

// Redirect to index.php if user role is not 'user'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header('location: index.php');
    exit();
}

// Fetch user details from session
$user_id = $_SESSION['user_id'];

// Validate user ID to ensure it's an integer
if (!filter_var($user_id, FILTER_VALIDATE_INT)) {
    echo "Invalid user ID.";
    exit();
}

// Prepare and execute query to retrieve user details from the database based on session user ID
$sql = "SELECT firstname, lastname, profile_photo, department_assignment, id_number, email, contact_number, gender, nickname
        FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Update session variables with fetched data for consistency
    $_SESSION['firstname'] = $row['firstname'];
    $_SESSION['lastname'] = $row['lastname'];
    $_SESSION['profile_photo'] = $row['profile_photo'];
    $_SESSION['department_assignment'] = $row['department_assignment'];
    $_SESSION['id_number'] = $row['id_number'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['contact_number'] = $row['contact_number'];
    $_SESSION['gender'] = $row['gender'];
    $_SESSION['nickname'] = $row['nickname'];

    // Assign variables for use in the page with htmlspecialchars for XSS protection
    $firstname = htmlspecialchars($row['firstname'], ENT_QUOTES, 'UTF-8');
    $lastname = htmlspecialchars($row['lastname'], ENT_QUOTES, 'UTF-8');
    $profile_photo = htmlspecialchars($row['profile_photo'], ENT_QUOTES, 'UTF-8');
    $department_assignment = htmlspecialchars($row['department_assignment'], ENT_QUOTES, 'UTF-8');
    $id_number = htmlspecialchars($row['id_number'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8');
    $contact_number = htmlspecialchars($row['contact_number'], ENT_QUOTES, 'UTF-8');
    $gender = htmlspecialchars($row['gender'], ENT_QUOTES, 'UTF-8');
    $nickname = htmlspecialchars($row['nickname'], ENT_QUOTES, 'UTF-8');
} else {
    // Handle error if user is not found
    echo "Error: User not found";
    exit();
}

date_default_timezone_set('Asia/Manila');

// Logout handling
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to login page after logout
    header("location: index.php");
    exit();
}

// Close the database connection
$conn->close();
?>
