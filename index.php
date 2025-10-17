<?php
session_start();
include 'conn.php';

// Ensure that POST data is being processed
if (isset($_POST['login'])) {
    // Fetch and sanitize input data
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validate input
    if (empty($username) || empty($password)) {
        $alertType = 'error';
        $alertMessage = 'Please enter both username and password.';
    } else {
        // Prepare SQL query to prevent SQL injection
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . htmlspecialchars($conn->error));
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows < 1) {
            $alertType = 'error';
            $alertMessage = 'Cannot find an account with the username.';
        } else {
            $row = $result->fetch_assoc();
            // Verify password
            if (password_verify($password, $row['password'])) {
                // Regenerate session ID to prevent session fixation
                session_regenerate_id(true);

                // Store user data in session variables
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['firstname'] = $row['firstname'];
                $_SESSION['lastname'] = $row['lastname'];
                $_SESSION['profile_photo'] = $row['profile_photo'];
                $_SESSION['department_assignment'] = $row['department_assignment'];
                $_SESSION['id_number'] = $row['id_number'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['gender'] = $row['gender'];
                $_SESSION['contact_number'] = $row['contact_number'];
                $_SESSION['nickname'] = $row['nickname'];

                // Redirect based on role
                $redirectUrl = '';
                switch ($row['role']) {
                    case 'superadmin':
                        $redirectUrl = 'superadmin_dashboard.php';
                        break;
                    case 'admin':
                        $redirectUrl = 'admin_dashboard.php';
                        break;
                    case 'user':
                        $redirectUrl = 'user_dashboard.php';
                        break;
                    default:
                        $alertType = 'error';
                        $alertMessage = 'Unknown role.';
                        break;
                }

                if (!isset($alertType)) {
                    echo '<script>
                            document.addEventListener("DOMContentLoaded", function() {
                                Toastify({
                                    text: "Login successful, redirecting...",
                                    duration: 3000,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    backgroundColor: "linear-gradient(to right, #1d2e28, #18392b)",
                                }).showToast();
                                setTimeout(function() {
                                    window.location.href = "' . htmlspecialchars($redirectUrl, ENT_QUOTES, 'UTF-8') . '";
                                }, 3000);
                            });
                          </script>';
                }
            } else {
                $alertType = 'error';
                $alertMessage = 'Incorrect password.';
            }
        }
        $stmt->close();
        $conn->close();
    }

    if (isset($alertType) && $alertType === 'error') {
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Toastify({
                        text: "' . htmlspecialchars($alertMessage, ENT_QUOTES, 'UTF-8') . '",
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#8B0000",
                    }).showToast();
                });
              </script>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Client Database Management</title>
  <?php include 'header_scripts.php'; ?>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <link rel="shortcut icon" href="dist/img/xchire-logo.png" type="image/x-icon">
</head>
<body>
<section class="h-100 gradient-form" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center">
                  <img src="dist/img/xchire.png" style="width: 185px;" alt="logo">
                </div>
                <br>
                <form method="post" action="">
                  <p style="text-align: center;">Client Database Management System</p>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form2Example11" style="font-size:12px;">Username</label>
                    <input type="text" class="form-control" placeholder="Username" name="username" style="font-size: 12px;" required>
                  </div>
                  <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form2Example22" style="font-size:12px;">Password</label>
                    <input type="password" class="form-control" placeholder="Password" name="password" style="font-size: 12px;" required>
                  </div>

                  <div class="text-center pt-1 mb-5 pb-1">
                    <button type="submit" name="login" class="btn xhire-astros btn-block" style="font-size: 12px;">Sign In</button>
                  </div>
                </form>

              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center" style="background-image: url('dist/img/client.jpg'); background-position: center; background-size: cover;">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include 'footer_scripts.php'; ?>
</body>
</html>
<style type="text/css">
.gradient-custom-2 {
/* fallback for old browsers */
background: #fccb90;

/* Chrome 10-25, Safari 5.1-6 */
background: -webkit-linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);

/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
}

@media (min-width: 768px) {
.gradient-form {
height: 100vh !important;
}
}
@media (min-width: 769px) {
.gradient-custom-2 {
border-top-right-radius: .3rem;
border-bottom-right-radius: .3rem;
}
}
</style>