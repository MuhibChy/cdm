<?php
session_start();
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $department_assignment = mysqli_real_escape_string($conn, $_POST['department_assignment']);
    $id_number = mysqli_real_escape_string($conn, $_POST['id_number']);

    // Handle file upload
    if (isset($_FILES["profile_photo"]) && $_FILES["profile_photo"]["error"] == 0) {
        $target_dir = "uploads/";
        $profile_photo = $target_dir . basename($_FILES["profile_photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($profile_photo, PATHINFO_EXTENSION));

        // Check if file is an actual image
        $check = getimagesize($_FILES["profile_photo"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $response = [
                'status' => 'error',
                'message' => 'File is not an image.'
            ];
            echo json_encode($response);
            exit();
        }

        // Check if file already exists
        if (file_exists($profile_photo)) {
            $response = [
                'status' => 'error',
                'message' => 'Sorry, file already exists.'
            ];
            echo json_encode($response);
            exit();
        }

        // Check file size
        if ($_FILES["profile_photo"]["size"] > 5000000) { // 5MB max size
            $response = [
                'status' => 'error',
                'message' => 'Sorry, your file is too large.'
            ];
            echo json_encode($response);
            exit();
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $response = [
                'status' => 'error',
                'message' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.'
            ];
            echo json_encode($response);
            exit();
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $response = [
                'status' => 'error',
                'message' => 'Sorry, your file could not be uploaded.'
            ];
            echo json_encode($response);
            exit();
        } else {
            if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $profile_photo)) {
                // File upload succeeded
                // Prepare and execute the SQL statement
                $sql = "INSERT INTO users (firstname, lastname, username, password, role, profile_photo, department_assignment, id_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssssss", $firstname, $lastname, $username, $password, $role, $profile_photo, $department_assignment, $id_number);

                if ($stmt->execute()) {
                    $response = [
                        'status' => 'success',
                        'message' => 'User Created Successfully!'
                    ];
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'There was an error creating the user.',
                        'error' => $stmt->error
                    ];
                }

                $stmt->close();
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Sorry, there was an error uploading your file.'
                ];
            }
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'No file was uploaded or there was an error with the file upload.'
        ];
    }

    mysqli_close($conn);
    echo json_encode($response);
    exit();
}
?>
