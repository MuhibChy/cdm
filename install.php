<?php
/**
 * CDMS Installation Script
 * Run this script once to set up the system
 */

// Prevent running if already installed
if (file_exists('config.php')) {
    die('System already installed. Delete config.php to reinstall.');
}

$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;
$error = '';
$success = '';

// Handle form submissions
if ($_POST) {
    switch ($step) {
        case 1:
            // Database connection test
            $host = $_POST['db_host'];
            $username = $_POST['db_username'];
            $password = $_POST['db_password'];
            $database = $_POST['db_name'];
            
            try {
                $conn = new mysqli($host, $username, $password, $database);
                if ($conn->connect_error) {
                    throw new Exception($conn->connect_error);
                }
                
                // Store database config in session
                session_start();
                $_SESSION['db_config'] = $_POST;
                $success = 'Database connection successful!';
                header('Location: install.php?step=2');
                exit;
            } catch (Exception $e) {
                $error = 'Database connection failed: ' . $e->getMessage();
            }
            break;
            
        case 2:
            // Import database and create config
            session_start();
            if (!isset($_SESSION['db_config'])) {
                header('Location: install.php?step=1');
                exit;
            }
            
            $db_config = $_SESSION['db_config'];
            
            try {
                // Create config.php
                $config_content = "<?php\n";
                $config_content .= "// Database configuration\n";
                $config_content .= "\$db_host = '" . $db_config['db_host'] . "';\n";
                $config_content .= "\$db_username = '" . $db_config['db_username'] . "';\n";
                $config_content .= "\$db_password = '" . $db_config['db_password'] . "';\n";
                $config_content .= "\$db_name = '" . $db_config['db_name'] . "';\n";
                $config_content .= "\n// Establish database connection\n";
                $config_content .= "\$conn = new mysqli(\$db_host, \$db_username, \$db_password, \$db_name);\n";
                $config_content .= "if (\$conn->connect_error) {\n";
                $config_content .= "    die('Connection failed: ' . \$conn->connect_error);\n";
                $config_content .= "}\n";
                $config_content .= "\$conn->set_charset('utf8');\n";
                $config_content .= "?>";
                
                file_put_contents('config.php', $config_content);
                
                // Import database if SQL file exists
                if (file_exists('database/cdms.sql')) {
                    $conn = new mysqli($db_config['db_host'], $db_config['db_username'], $db_config['db_password'], $db_config['db_name']);
                    $sql = file_get_contents('database/cdms.sql');
                    
                    if ($conn->multi_query($sql)) {
                        do {
                            if ($result = $conn->store_result()) {
                                $result->free();
                            }
                        } while ($conn->next_result());
                    }
                }
                
                // Create necessary directories
                $dirs = ['uploads', 'files', 'backup', 'logs'];
                foreach ($dirs as $dir) {
                    if (!is_dir($dir)) {
                        mkdir($dir, 0755, true);
                    }
                }
                
                // Clear session
                session_destroy();
                
                $success = 'Installation completed successfully!';
                $step = 3;
            } catch (Exception $e) {
                $error = 'Installation failed: ' . $e->getMessage();
            }
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CDMS Installation</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <style>
        .install-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
        }
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        .step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
            font-weight: bold;
        }
        .step.active {
            background: #007bff;
            color: white;
        }
        .step.completed {
            background: #28a745;
            color: white;
        }
    </style>
</head>
<body class="hold-transition">

<div class="install-container">
    <div class="card">
        <div class="card-header text-center">
            <h1><i class="fas fa-cogs"></i> CDMS Installation</h1>
        </div>
        <div class="card-body">
            
            <!-- Step Indicator -->
            <div class="step-indicator">
                <div class="step <?= $step >= 1 ? ($step > 1 ? 'completed' : 'active') : '' ?>">1</div>
                <div class="step <?= $step >= 2 ? ($step > 2 ? 'completed' : 'active') : '' ?>">2</div>
                <div class="step <?= $step >= 3 ? 'active' : '' ?>">3</div>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>
            
            <?php if ($step == 1): ?>
                <h3>Step 1: Database Configuration</h3>
                <p>Please enter your database connection details:</p>
                
                <form method="post">
                    <div class="form-group">
                        <label>Database Host</label>
                        <input type="text" name="db_host" class="form-control" value="localhost" required>
                    </div>
                    <div class="form-group">
                        <label>Database Username</label>
                        <input type="text" name="db_username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Database Password</label>
                        <input type="password" name="db_password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Database Name</label>
                        <input type="text" name="db_name" class="form-control" value="cdms" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Test Connection</button>
                </form>
                
            <?php elseif ($step == 2): ?>
                <h3>Step 2: Install Database</h3>
                <p>Database connection successful. Click below to complete the installation:</p>
                
                <form method="post">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        This will create the configuration file and import the database schema.
                    </div>
                    <button type="submit" class="btn btn-success">Complete Installation</button>
                </form>
                
            <?php elseif ($step == 3): ?>
                <h3>Step 3: Installation Complete</h3>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    CDMS has been successfully installed!
                </div>
                
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Important Security Steps:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Delete this installation file (install.php)</li>
                        <li>Change default user passwords</li>
                        <li>Set proper file permissions</li>
                        <li>Enable HTTPS in production</li>
                    </ul>
                </div>
                
                <div class="text-center">
                    <a href="index.php" class="btn btn-primary btn-lg">
                        <i class="fas fa-sign-in-alt"></i> Go to Login
                    </a>
                </div>
                
            <?php endif; ?>
            
        </div>
    </div>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
