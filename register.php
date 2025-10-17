<?php
session_start();
include 'conn.php';

$errors = array();

function registerUser($conn, $username, $password, $firstname, $lastname, $role, $profile_photo) {
    global $errors;

    // Sanitize inputs
    $username = mysqli_real_escape_string($conn, trim($username));
    $password_hash = password_hash($password, PASSWORD_DEFAULT); // Hash password
    $firstname = mysqli_real_escape_string($conn, trim($firstname));
    $lastname = mysqli_real_escape_string($conn, trim($lastname));
    $role = mysqli_real_escape_string($conn, trim($role));

    // Validate profile photo upload
    if ($profile_photo['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($profile_photo['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a valid image
        $check = getimagesize($profile_photo['tmp_name']);
        if ($check === false) {
            $errors[] = "File is not an image.";
            return;
        }

        // Check file size
        if ($profile_photo['size'] > 500000) {
            $errors[] = "Sorry, your file is too large.";
            return;
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            $errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            return;
        }

        // Check if file upload is successful
        if (move_uploaded_file($profile_photo['tmp_name'], $target_file)) {
            $profile_photo_path = $target_file;

            // Insert user data into database
            $sql = "INSERT INTO users (username, password, firstname, lastname, role, profile_photo) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param('ssssss', $username, $password_hash, $firstname, $lastname, $role, $profile_photo_path);
                if ($stmt->execute()) {
                    $_SESSION['success'] = "Account has been successfully created.";
                    header('Location: index.php');
                    exit();
                } else {
                    $errors[] = "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $errors[] = "Error preparing statement: " . $conn->error;
            }
        } else {
            $errors[] = "Sorry, there was an error uploading your file.";
        }
    } else {
        $errors[] = "File upload error: " . $profile_photo['error'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $role = $_POST['role'];
    $profile_photo = $_FILES['profile_photo'];

    // Call function to register user
    registerUser($conn, $username, $password, $firstname, $lastname, $role, $profile_photo);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register | Client Database Management</title>
  <?php include 'header_scripts.php'; ?>
  <link rel="shortcut icon" href="dist/img/xchire-logo.png" type="image/x-icon">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-navy">
    <div class="card-header text-center">
      <img src="dist/img/xchire.png" alt="AdminLTE Logo" class="brand-image" style="height: 50px; width: 200px;">   
    </div>
    <div class="card-body">
      <p class="login-box-msg" style="font-size: 12px;">Create a new account</p>
      <?php if (!empty($errors)): ?>
            <div class="error-message">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
      <form method="post" action="" enctype="multipart/form-data">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" name="username" style="font-size: 12px;" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" style="font-size: 12px;" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Firstname" name="firstname" style="font-size: 12px;" required>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Lastname" name="lastname" style="font-size: 12px;" required>
        </div>
        <div class="input-group mb-3">
          <select class="form-control" style="font-size: 12px;" id="role" name="role" required>
            <option value="" disabled selected>Role</option>
            <option value="superadmin">Super Admin</option>
          </select>
        </div>
        <div class="input-group mb-3">
          <input type="file" class="form-control" id="profile_photo" name="profile_photo" accept="image/*" style="font-size: 12px;">
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" name="register" class="btn bg-navy btn-block" style="font-size: 12px;">Create Account</button>
          </div>
        </div>
      </form>

      <div class="social-auth-links text-center mt-2 mb-3">
        <a href="index.php" class="btn btn-block bg-black" style="font-size: 12px;">Already Have an Account?</a>
      </div>
    </div>
  </div>
</div>
<?php include 'footer_scripts.php'; ?>
</body>
</html>
