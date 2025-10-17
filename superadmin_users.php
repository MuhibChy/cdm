<?php include 'session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CDMS | List of Users</title>
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
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
            <div class="card xhire-outline">
              <div class="card-header">
                <h3 class="card-title d-flex" style="font-size:12px; font-weight: bold; color: black; align-items: center;">
                                    <span class="badge" style="width:10px; height: 10px; display: inline-block; border-radius: 100%; background-color: #0f5132;"></span>&nbsp; List of Users
                                </h3>
                                <div class="card-tools" style="margin-right: 2px;">
                                    <button class="btn xhire-success btn-sm" style="font-size:12px;" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> Add User</button>
                                </div>
                <br>
              </div>
              <div class="card-body">
               <table id="usersTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>User ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            // Query to fetch all users
            $sql = "SELECT * FROM users WHERE role != 'superadmin'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['firstname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['lastname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                    echo "<td>
                        <div class='btn-group'>
                            <button type='button' class='btn-xs btn btn-default'>View Details</button>
                            <button type='button' class='btn-xs btn btn-default dropdown-toggle dropdown-icon' data-toggle='dropdown'>
                                <span class='sr-only'>Toggle Dropdown</span>
                            </button>
                            <div class='dropdown-menu' role='menu'>
                                <a class='dropdown-item' data-toggle='modal' data-target='#updateModal' onclick='fillUpdateForm(" . htmlspecialchars($row['user_id']) . ", \"" . htmlspecialchars($row['firstname']) . "\", \"" . htmlspecialchars($row['lastname']) . "\", \"" . htmlspecialchars($row['username']) . "\", \"" . htmlspecialchars($row['role']) . "\", \"" . htmlspecialchars($row['department_assignment']) . "\", \"" . htmlspecialchars($row['id_number']) . "\")' style='font-size:12px;'>Update Records</a>
                                <div class='dropdown-divider'></div>
                                <a class='dropdown-item deleteBtn' data-id='" . htmlspecialchars($row['user_id']) . "' style='font-size:12px;'>Delete Records</a>
                            </div>
                        </div>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No users found</td></tr>";
            }
        ?>
    </tbody>
</table>
    </div>
  </div>
</div>
<!-- /.col-md-6 -->
</div>
<!-- /.row -->
</div><!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include 'footer.php'; ?>
</div>
<?php include 'footer_scripts.php'; ?>
</body>
</html>
<?php include 'superadmin_user_modal.php'; ?>
<?php include 'scripts/superadmin_users_scripts.php'; ?>