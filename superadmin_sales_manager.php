<?php include 'session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CDMS | Sales Manager List</title>
  <?php include 'header_scripts.php'; ?>
  <link rel="shortcut icon" href="dist/img/xchire-logo.png" type="image/x-icon">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <?php include 'superadmin_navbar_section.php'; ?> 
  <?php include 'superadmin_main_sidebar.php'; ?>  
  <?php include 'superadmin_profile_modal.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!-- Optional space for additional content -->
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#" style="font-size:12px;">Home</a></li>
              <li class="breadcrumb-item active" style="font-size:12px;">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
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
                  <span class="badge" style="width:10px; height: 10px; display: inline-block; border-radius: 100%; background-color: #0f5132;"></span>&nbsp; List of Managers
                </h3>
                <div class="card-tools" style="margin-right: 2px;">
                  <button class="btn xhire-success btn-sm" style="font-size:12px;" data-toggle="modal" data-target="#createManagerModal">
                    <i class="fas fa-plus"></i> Add Manager Account
                  </button>
                </div>
                <br>
              </div>
              <div class="card-body">
                <table id="managersTable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>First Name</th>
                      <th>Middle Initial</th>
                      <th>Last Name</th>
                      <th>Gender</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Query to fetch all sales managers
                    $sql = "SELECT * FROM sales_managers";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            $manager_id = htmlspecialchars($row['manager_id']);
                            $firstname = htmlspecialchars($row['firstname']);
                            $middle_initial = htmlspecialchars($row['middle_initial']);
                            $lastname = htmlspecialchars($row['lastname']);
                            $gender = htmlspecialchars($row['gender']);
                            
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['firstname']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['middle_initial']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['lastname']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                            echo "<td>
                                <div class='btn-group'>
                                  <button type='button' class='btn-xs btn btn-default'>View Details</button>
                                  <button type='button' class='btn-xs btn btn-default dropdown-toggle dropdown-icon' data-toggle='dropdown'>
                                    <span class='sr-only'>Toggle Dropdown</span>
                                  </button>
                                  <div class='dropdown-menu' role='menu'>
                                    <a class='dropdown-item' onclick='viewManagerDetails(" . intval($row['manager_id']) . ")'>View Records</a>
                                    <a class='dropdown-item' data-toggle='modal' data-target='#updateManagerModal' onclick='fillUpdateForm({$manager_id}, \"{$firstname}\", \"{$middle_initial}\", \"{$lastname}\", \"{$gender}\")' style='font-size:12px;'>Update Records</a>
                                    <div class='dropdown-divider'></div>
                                    <a class='dropdown-item deleteBtn' data-id='{$manager_id}' style='font-size:12px;'>Delete Records</a>
                                  </div>
                                </div>
                              </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No managers found</td></tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div><!-- /.content -->
  </div><!-- /.content-wrapper -->

  <?php include 'footer.php'; ?>
</div><!-- /.wrapper -->

<?php include 'footer_scripts.php'; ?>
<?php include 'superadmin_sales_manager_modal.php'; ?>
<?php include 'scripts/superadmin_sales_manager_scripts.php'; ?>
</body>
</html>
