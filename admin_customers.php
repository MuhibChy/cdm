<?php include 'admin_session.php'; ?>  
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CDMS | Create Clients</title>
  <?php include 'header_scripts.php'; ?>
  <link rel="shortcut icon" href="dist/img/xchire-logo.png" type="image/x-icon">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <?php include 'admin_navbarsection.php'; ?> 
  <?php include 'admin_profile_modal.php'; ?>
  <?php include 'admin_main_sidebar.php'; ?>  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php include 'admin_alert.php'; ?>  
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6"></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#" style="font-size:12px;">Home</a></li>
              <li class="breadcrumb-item active" style="font-size:12px;">Customers</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card xhire-outline">
              <div class="card-header">
                <h3 class="card-title d-flex" style="font-size:12px; font-weight: bold; color: black; align-items: center;">
                  <span class="badge" style="width:10px; height: 10px; display: inline-block; border-radius: 100%; background-color: #0f5132;"></span>&nbsp; List of Clients
                </h3>
                <div class="card-tools" style="margin-right: 2px;">
                  <button class="btn xhire-success btn-sm" style="font-size:12px;" data-toggle="modal" data-target="#createCustomerModal">
                    <i class="fas fa-plus"></i> Add Client
                  </button>
                </div>
              </div>
              
              <div class="card-body">
                <table id="customerOrdersTable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Client Name</th>
                      <th>Company Name</th>
                      <th>Contact Number</th>
                      <th>Email</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Database credentials
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $database = "cdms";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $database);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // SQL query to fetch data
                    $sql = "SELECT * FROM customers";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td style='text-transform: capitalize'>".htmlspecialchars($row["firstname"], ENT_QUOTES, 'UTF-8')." ".htmlspecialchars($row["lastname"], ENT_QUOTES, 'UTF-8')."</td>";
                            echo "<td>".htmlspecialchars($row["company_name"], ENT_QUOTES, 'UTF-8')."</td>";
                            echo "<td>".htmlspecialchars($row["contact_number"], ENT_QUOTES, 'UTF-8')."</td>";
                            echo "<td>".htmlspecialchars($row["email_address"], ENT_QUOTES, 'UTF-8')."</td>";
                            echo "<td>
                                    <div class='btn-group'>
                                      <button type='button' class='btn-xs btn btn-default'>View Details</button>
                                      <button type='button' class='btn-xs btn btn-default dropdown-toggle dropdown-icon' data-toggle='dropdown'>
                                        <span class='sr-only'>Toggle Dropdown</span>
                                      </button>
                                      <div class='dropdown-menu' role='menu'>
                                        <a class='dropdown-item' data-toggle='modal' data-target='#updateCustomerModal' onclick='fillUpdateForm(".htmlspecialchars($row['customer_id'], ENT_QUOTES, 'UTF-8').", \"".htmlspecialchars($row['company_name'], ENT_QUOTES, 'UTF-8')."\", \"".htmlspecialchars($row['firstname'], ENT_QUOTES, 'UTF-8')."\", \"".htmlspecialchars($row['middle_initial'], ENT_QUOTES, 'UTF-8')."\", \"".htmlspecialchars($row['lastname'], ENT_QUOTES, 'UTF-8')."\", \"".htmlspecialchars($row['contact_number'], ENT_QUOTES, 'UTF-8')."\", \"".htmlspecialchars($row['email_address'], ENT_QUOTES, 'UTF-8')."\", \"".htmlspecialchars($row['gender'], ENT_QUOTES, 'UTF-8')."\", \"".htmlspecialchars($row['city_address'], ENT_QUOTES, 'UTF-8')."\")' style='font-size:12px;'>Update Records</a>
                                        <div class='dropdown-divider'></div>
                                        <a class='dropdown-item' data-toggle='modal' data-target='#deleteCustomerModal' onclick='confirmDelete(".htmlspecialchars($row['customer_id'], ENT_QUOTES, 'UTF-8').")' style='font-size:12px;'>Delete Records</a>
                                      </div>
                                    </div>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No records found</td></tr>";
                    }

                    // Close connection
                    $conn->close();
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include 'footer.php'; ?>
</div>
<?php include 'footer_scripts.php'; ?>
</body>
</html>
<?php include 'admin_customer_modal.php'; ?>
<?php include 'scripts/admin_customer_scripts.php'; ?>