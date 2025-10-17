<?php 
include 'user_session.php'; 
include 'conn.php'; // Ensure this is included only after user_session.php to prevent unauthorized access
?>

<!DOCTYPE html>
<html lang="en">
<head> 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CDMS | Dashboard</title>
  <?php include 'header_scripts.php'; ?>
  <!-- SweetAlert CSS and JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Favicon -->
  <link rel="shortcut icon" href="dist/img/xchire-logo.png" type="image/x-icon">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <?php include 'user_navbarsection.php'; ?>
  <?php include 'user_profile_modal.php'; ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include 'user_main_sidebar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php include 'user_alert.php'; ?>  
    <?php include 'user_content_header.php'; ?>  
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card xhire-outline">
              <div class="card-header">
                <h3 class="card-title d-flex" style="font-size:12px; font-weight: bold; color: black; align-items: center;"><span class="badge" style="width:10px; height: 10px; display: inline-block; border-radius: 100%; background-color: #0f5132;"></span>&nbsp; List of Clients</h3>
                <div class="card-tools" style="margin-right: 2px;">
                  <button class="btn btn-sm xhire-success" data-toggle="modal" data-target="#createCustomerModal">
                  <i class="fas fa-plus"></i>&nbsp; Add Clients
                </button>
                </div>
              </div>
              <div class="card-body">
                <table id="usersTable1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>First Name</th>
                      <th>Middle Initial</th>
                      <th>Last Name</th>
                      <th>Contact Number</th>
                      <th>Email Address</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Use prepared statements to prevent SQL injection
                    $stmt = $conn->prepare("SELECT * FROM customers ORDER BY customer_id DESC");
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        $customer_id = htmlspecialchars($row['customer_id']);
                        $firstname = htmlspecialchars($row['firstname']);
                        $middle_initial = htmlspecialchars($row['middle_initial']);
                        $lastname = htmlspecialchars($row['lastname']);
                        $contact_number = htmlspecialchars($row['contact_number']);
                        $email_address = htmlspecialchars($row['email_address']);
                        $company_name = htmlspecialchars($row['company_name']);
                        $gender = htmlspecialchars($row['gender']);
                        $city_address = htmlspecialchars($row['city_address']);

                        echo "<tr>";
                        echo "<td>{$customer_id}</td>";
                        echo "<td style='text-transform:capitalize;'>{$firstname}</td>";
                        echo "<td>{$middle_initial}</td>";
                        echo "<td style='text-transform:capitalize;'>{$lastname}</td>";
                        echo "<td>{$contact_number}</td>";
                        echo "<td>{$email_address}</td>";
                        echo "<td>";
                        echo "<div class='btn-group'>
                                <button type='button' class='btn-xs btn btn-default'> View Details</button>
                                <button type='button' class='btn-xs btn btn-default dropdown-toggle dropdown-icon' data-toggle='dropdown'>
                                  <span class='sr-only'>Toggle Dropdown</span>
                                </button>
                                <div class='dropdown-menu' role='menu'>
                                  <a class='dropdown-item' data-toggle='modal' data-target='#updateCustomerModal' onclick='fillUpdateForm({$customer_id}, \"{$company_name}\", \"{$firstname}\", \"{$middle_initial}\", \"{$lastname}\", \"{$contact_number}\", \"{$email_address}\", \"{$gender}\", \"{$city_address}\")' style='font-size:12px;'>Update Records</a>
                                  <div class='dropdown-divider'></div>
                                  <a class='dropdown-item deleteBtn' data-id='{$customer_id}' style='font-size:12px;'>Delete Records</a>
                                </div>
                              </div>";
                        echo "</td>";
                        echo "</tr>";
                      }
                    } else {
                      echo "<tr><td colspan='7'>No users found</td></tr>";
                    }

                    $stmt->close();
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div><!-- /.col-md-6 -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div><!-- /.content -->
  </div><!-- /.content-wrapper -->
</div><!-- ./wrapper -->
<!-- Footer -->
  <?php include 'footer.php'; ?>
  <?php include 'footer_scripts.php'; ?>
  <?php include 'user_customer_modal.php'; ?>
  <?php include 'scripts/user_dashboard_scripts.php';?>
</body>
</html>
