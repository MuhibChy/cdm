<?php
include 'session.php';
include 'conn.php';

// Initialize variables with default values
$database_name = 'Unknown';
$database_size = '0';

// Handle Export
if (isset($_POST['export'])) {
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = mysqli_fetch_assoc(mysqli_query($conn, "SELECT DATABASE() AS db_name"))['db_name'];
    
    if ($database) {
        exportDatabase($host, $user, $password, $database);
    } else {
        echo 'Error retrieving database name.';
    }
}

// Handle Import
if (isset($_FILES['import_file']) && $_FILES['import_file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['import_file']['tmp_name'];
    importDatabase($conn, $fileTmpPath);
} elseif (isset($_FILES['import_file']['error']) && $_FILES['import_file']['error'] !== UPLOAD_ERR_OK) {
    echo 'Error uploading file: ' . $_FILES['import_file']['error'];
}

// Retrieve Database Info
$result = mysqli_query($conn, "SELECT DATABASE() AS db_name");
if ($row = mysqli_fetch_assoc($result)) {
    $database_name = $row['db_name'];
}

$size_result = mysqli_query($conn, "SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS db_size_mb FROM information_schema.tables WHERE table_schema = DATABASE()");
if ($size_row = mysqli_fetch_assoc($size_result)) {
    $database_size = $size_row['db_size_mb'];
}

// Close the connection
mysqli_close($conn);

function exportDatabase($host, $user, $password, $database) {
    // Connect to the database
    $conn = new mysqli($host, $user, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Set the content type and filename for download
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="database_backup_' . date('YmdHis') . '.sql"');
    header('Expires: 0');
    header('Pragma: public');
    header('Cache-Control: must-revalidate');

    // Initialize variables
    $tables = array();
    $sql = '';

    // Get list of tables
    $result = $conn->query('SHOW TABLES');
    if (!$result) {
        die("Error fetching tables: " . $conn->error);
    }

    while ($row = $result->fetch_row()) {
        $tables[] = $row[0];
    }

    // Loop through tables and generate SQL
    foreach ($tables as $table) {
        $result = $conn->query('SELECT * FROM ' . $table);
        if (!$result) {
            die("Error fetching data from table $table: " . $conn->error);
        }

        $num_fields = $result->field_count;
        $sql .= 'DROP TABLE IF EXISTS `' . $table . '`;';
        $createTableResult = $conn->query('SHOW CREATE TABLE ' . $table);
        if (!$createTableResult) {
            die("Error fetching table structure for $table: " . $conn->error);
        }
        $createTableRow = $createTableResult->fetch_row();
        $sql .= "\n\n" . $createTableRow[1] . ";\n\n";

        while ($row = $result->fetch_row()) {
            $sql .= 'INSERT INTO `' . $table . '` VALUES(';
            for ($i = 0; $i < $num_fields; $i++) {
                $row[$i] = $conn->real_escape_string($row[$i]);
                $sql .= '"' . $row[$i] . '"';
                if ($i < ($num_fields - 1)) {
                    $sql .= ',';
                }
            }
            $sql .= ");\n";
        }

        $sql .= "\n\n";
    }

    // Close the connection
    $conn->close();

    // Output the SQL content
    echo $sql;
    exit;
}

function importDatabase($conn, $filePath) {
    // Read the SQL file
    $sql = file_get_contents($filePath);
    if ($sql === false) {
        die('Error reading file.');
    }

    // Execute the SQL commands
    if ($conn->multi_query($sql)) {
        do {
            // Store the result to clear the connection
            if ($result = $conn->store_result()) {
                $result->free();
            }
        } while ($conn->more_results() && $conn->next_result());
        echo 'Database imported successfully.';
    } else {
        echo 'Error importing database: ' . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CDMS | Database</title>
  <?php include 'header_scripts.php'; ?>
  <link rel="shortcut icon" href="dist/img/xchire-logo.png" type="image/x-icon">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
<?php include 'superadmin_navbar_section.php'; ?>
<?php include 'superadmin_main_sidebar.php'; ?>
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
                <div class="d-flex align-items-center mt-2">
                    <!-- Export Form -->
                    <form method="post" action="" class="mr-2">
                        <button type="submit" name="export" class="btn bg-navy btn-sm" style="font-size:12px;">Export Database</button>
                    </form>
                    <!-- Import Form -->
                    <form method="post" action="" enctype="multipart/form-data" class="d-flex align-items-center mr-2">
                        <input type="file" name="import_file" class="form-control form-control-sm mr-2" required>
                        <button type="submit" name="import" class="btn bg-olive btn-sm" style="font-size:12px;">Import</button>
                    </form>
                </div>
              </div>

              <div class="card-body">
                <table id="usersTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Database Name</th>
                            <th>Size (MB)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo htmlspecialchars($database_name); ?></td>
                            <td><?php echo htmlspecialchars($database_size); ?> MB</td>
                        </tr>
                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </div><!-- /.col-md-6 -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include 'footer.php'; ?>
<?php include 'footer_scripts.php'; ?>
<?php include 'superadmin_profile_modal.php'; ?>
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
</body>
</html>
