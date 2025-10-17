<!-- login.php -->
<?php
session_start();
include 'conn.php';

if (isset($_SESSION['role'])) {
    // Redirect to dashboard based on role if already logged in
    switch ($_SESSION['role']) {
        case 'superadmin':
            header('location: superadmin_dashboard.php');
            exit();
        case 'admin':
            header('location: admin_dashboard.php');
            exit();
        case 'staff':
            header('location: staff_dashboard.php');
            exit();
        case 'user':
            header('location: user_dashboard.php');
            exit();
        default:
            // Handle invalid role scenario if needed
            break;
    }
}

// Handle login form submission (similar to index.php)
// Place your login form code here
?>
