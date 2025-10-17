<?php include 'session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CDMS | List of Sales Agents</title>
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
                    <div class="col-sm-6"></div><!-- /.col -->
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
                                    <span class="badge" style="width:10px; height: 10px; display: inline-block; border-radius: 100%; background-color: #0f5132;"></span>&nbsp; List of Sales Agents
                                </h3>
                                <div class="card-tools" style="margin-right: 2px;">
                                    <button class="btn xhire-success btn-sm" style="font-size:12px;" data-toggle="modal" data-target="#createAgentModal"><i class="fas fa-plus"></i> Add Sales Agent</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="agentsTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Agent ID</th>
                                            <th>First Name</th>
                                            <th>Middle Initial</th>
                                            <th>Last Name</th>
                                            <th>Gender</th>
                                            <th>Sales Manager</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $stmt = $conn->prepare("SELECT sa.*, sm.firstname AS manager_firstname, sm.lastname AS manager_lastname 
                                                                FROM sales_agents sa 
                                                                LEFT JOIN sales_managers sm ON sa.manager_id = sm.manager_id");
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                $agent_id = htmlspecialchars($row['agent_id']);
                                                $firstname = htmlspecialchars($row['firstname']);
                                                $middle_initial = htmlspecialchars($row['middle_initial']);
                                                $lastname = htmlspecialchars($row['lastname']);
                                                $gender = htmlspecialchars($row['gender']);
                                                $manager_firstname = htmlspecialchars($row['manager_firstname']);
                                                $manager_lastname = htmlspecialchars($row['manager_lastname']);
                                                echo "<tr>";
                                                echo "<td style='text-transform: capitalize;'>{$agent_id}</td>";
                                                echo "<td style='text-transform: capitalize;'>{$firstname}</td>";
                                                echo "<td style='text-transform: capitalize;'>{$middle_initial}</td>";
                                                echo "<td style='text-transform: capitalize;'>{$lastname}</td>";
                                                echo "<td>{$gender}</td>";
                                                echo "<td style='text-transform: capitalize;'>{$manager_firstname} {$manager_lastname}</td>";
                                                echo "<td>
                                                        <div class='btn-group'>
                                                            <button type='button' class='btn-xs btn btn-default'>View Details</button>
                                                            <button type='button' class='btn-xs btn btn-default dropdown-toggle dropdown-icon' data-toggle='dropdown'>
                                                                <span class='sr-only'>Toggle Dropdown</span>
                                                            </button>
                                                            <div class='dropdown-menu' role='menu'>
                                                                <a class='dropdown-item' data-toggle='modal' data-target='#updateAgentModal' 
                                                                   onclick='fillUpdateForm({$agent_id}, \"{$firstname}\", \"{$middle_initial}\", \"{$lastname}\", \"{$gender}\")' 
                                                                   style='font-size:12px;'>Update Records</a>
                                                                <div class='dropdown-divider'></div>
                                                                <a class='dropdown-item deleteBtn' data-id='{$agent_id}' style='font-size:12px;'>Delete Records</a>
                                                            </div>
                                                        </div>
                                                      </td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='7'>No sales agents found</td></tr>";
                                        }

                                        $stmt->close();
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
<?php include 'superadmin_sales_agent_modal.php'; ?>
<?php include 'scripts/superadmin_sales_agent_scripts.php'; ?>
</body>
</html>
