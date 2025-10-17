<?php
session_start();
include 'conn.php'; // Ensure this file includes your database connection

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);
    $profile_photo = $_FILES['photo'];

    // File upload handling
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($profile_photo["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is an image
    $check = getimagesize($profile_photo["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $_SESSION['error'] = "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($profile_photo["size"] > 500000) {
        $_SESSION['error'] = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        header('Location: register.php');
        exit();
    } else {
        // Attempt to upload file
        if (move_uploaded_file($profile_photo["tmp_name"], $target_file)) {
            // Prepare SQL query to prevent SQL injection
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, password, role, profile_photo) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            
            if ($stmt) {
                $stmt->bind_param('ssss', $username, $hashed_password, $role, $target_file);

                if ($stmt->execute()) {
                    $_SESSION['success'] = "User registered successfully.";
                    header('Location: login.php');
                    exit();
                } else {
                    $_SESSION['error'] = "Error: " . $stmt->error;
                }
                
                $stmt->close();
            } else {
                $_SESSION['error'] = "Error preparing statement: " . $conn->error;
            }
        } else {
            $_SESSION['error'] = "Sorry, there was an error uploading your file.";
        }
        
        header('Location: register.php');
        exit();
    }
} else {
    $_SESSION['error'] = 'Please fill out the registration form.';
    header('Location: register.php');
    exit();
}

$conn->close();
?>
