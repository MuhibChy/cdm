<?php include 'session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CDMS | Database Details</title>
  <?php include 'header_scripts.php'; ?>
  <link rel="shortcut icon" href="dist/img/xchire-logo.png" type="image/x-icon">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
<?php include 'navbar_section.php'; ?> 
<?php include 'main_sidebar.php'; ?>  
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
              <li class="breadcrumb-item active" style="font-size:12px;">Database Management</li>
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
            <div class="card card-navy card-outline">
              <div class="card-header">
                <h5 class="m-0" style="font-size:12px; font-weight: bold;">PHPMyadmin Database</h5>
                <br>
                <button class="btn bg-navy btn-sm" style="font-size:12px;" data-toggle="modal" data-target="#importModal">Import Database</button>
                <button class="btn bg-olive btn-sm" style="font-size:12px;" data-toggle="modal" data-target="#exportModal">Export Database</button>
              </div>
              <div class="card-body">
<?php
// Include your connection file (e.g., conn.php)
include 'conn.php';

// Query to get list of tables and their sizes
$sql = "SELECT table_name AS table_name, 
               ROUND(((data_length + index_length) / 1024 / 1024), 2) AS size_mb 
        FROM information_schema.tables 
        WHERE table_schema = DATABASE()";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching table sizes: " . mysqli_error($conn));
}
?>

<table id="usersTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Table Name</th>
            <th>Size (MB)</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tableName = htmlspecialchars($row['table_name']);
                $sizeMb = htmlspecialchars($row['size_mb']);
                echo "<tr>";
                echo "<td>$tableName</td>";
                echo "<td>$sizeMb MB</td>";
                echo "<td>
                    <form method='post' action='superadmin_phpmyadmin_repair_database.php' style='display:inline;'>
                        <input type='hidden' name='table_name' value='$tableName'>
                        <button type='submit' class='btn btn-warning btn-sm' style='font-size:12px;'>Repair</button>
                    </form>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No tables found</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php
mysqli_close($conn);
?>

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
<?php include 'profile_modal.php'; ?>
<?php include 'user_modal.php'; ?>
<script>
    $(document).ready(function() {
        $("#usersTable").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "buttons": []
        }).buttons().container().appendTo('#usersTable_wrapper .col-md-6:eq(0)');
    });

    function confirmLogout() {
        if (confirm("Are you sure you want to logout?")) {
            window.location.href = 'logout.php';
        }
    }

    function fillUpdateForm(user_id, firstname, lastname, username, role, department_assignment, id_number) {
        $('#update_user_id').val(user_id);
        $('#update_firstname').val(firstname);
        $('#update_lastname').val(lastname);
        $('#update_username').val(username);
        $('#update_role').val(role);
        $('#update_department_assignment').val(department_assignment);
        $('#update_id_number').val(id_number);
    }

    function confirmDelete(user_id) {
        $('#delete_user_id').val(user_id);
    }
</script>
