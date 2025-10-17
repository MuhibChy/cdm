<?php
session_start();
include 'conn.php';

$user_id = $_SESSION['user_id']; // Assuming you have a user ID stored in session
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$department_assignment = $_POST['department_assignment'];
$id_number = $_POST['id_number'];
$gender = $_POST['gender'];
$contact_number = $_POST['contact_number'];
$email = $_POST['email'];
$nickname = $_POST['nickname'];

// Update firstname and lastname
$sql = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', department_assignment = '$department_assignment', id_number = '$id_number', gender = '$gender', contact_number = '$contact_number', email = '$email', nickname = '$nickname' WHERE user_id = $user_id";

if ($conn->query($sql) === TRUE) {
    // Handle profile photo upload (if any)
    if ($_FILES['profile_photo']['name']) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["profile_photo"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["profile_photo"]["size"] > 15728640) { // 15MB in bytes
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
                // Update profile photo path in database
                $sql = "UPDATE users SET profile_photo = '$target_file' WHERE user_id = $user_id";
                if ($conn->query($sql) === TRUE) {
                    echo "The file ". htmlspecialchars(basename($_FILES["profile_photo"]["name"])). " has been uploaded and profile updated.";
                } else {
                    echo "Sorry, there was an error updating your profile photo in the database.";
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Redirect to users.php or wherever appropriate
    header('Location: superadmin_dashboard.php');
} else {
    echo "Error updating profile: " . $conn->error;
}

$conn->close();
?>
