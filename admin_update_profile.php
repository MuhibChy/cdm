<?php
session_start();
include 'conn.php';

// Fetch user ID from session
$user_id = $_SESSION['user_id']; 

// Get form data
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$gender = $_POST['gender'];
$contact_number = $_POST['contact_number'];
$email = $_POST['email'];
$nickname = $_POST['nickname'];

// Prepare and execute SQL statement for updating user details
$sql = "UPDATE users SET firstname=?, lastname=?, gender=?, contact_number=?, email=?, nickname=? WHERE user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssi", $firstname, $lastname, $gender, $contact_number, $email, $nickname, $user_id);

if ($stmt->execute()) {
    // Handle profile photo upload if a file is provided
    if (!empty($_FILES['profile_photo']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["profile_photo"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["profile_photo"]["size"] > 15728640) { // 15MB in bytes
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk === 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
                // Prepare and execute SQL statement for updating profile photo path
                $sql = "UPDATE users SET profile_photo=? WHERE user_id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $target_file, $user_id);

                if ($stmt->execute()) {
                    echo "The file " . htmlspecialchars(basename($_FILES["profile_photo"]["name"])) . " has been uploaded and profile updated.";
                } else {
                    echo "Sorry, there was an error updating your profile photo in the database.";
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Redirect to admin_dashboard.php or another appropriate page
    header('Location: admin_dashboard.php');
    exit();
} else {
    echo "Error updating profile: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
