<?php
include 'conn.php'; // Ensure this file includes your database connection and constants

function generateBackup($conn) {
    // Get the database name
    $result = mysqli_query($conn, "SELECT DATABASE() AS db_name");
    if (!$result) {
        die("Error retrieving database name: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);
    $database_name = $row['db_name'];

    // Generate filename
    $backup_file = 'backups/' . $database_name . '_' . date('Ymd_His') . '.sql';

    // Escape shell arguments to avoid injection risks
    $escaped_db_user = escapeshellarg(DB_USER);
    $escaped_db_password = escapeshellarg(DB_PASSWORD);
    $escaped_db_host = escapeshellarg(DB_HOST);
    $escaped_database_name = escapeshellarg($database_name);
    $escaped_backup_file = escapeshellarg($backup_file);

    // Create the backup
    $command = "mysqldump --user=$escaped_db_user --password=$escaped_db_password --host=$escaped_db_host $escaped_database_name > $escaped_backup_file";
    exec($command, $output, $return_var);

    if ($return_var !== 0) {
        die("Error creating backup. Command output: " . implode("\n", $output));
    }

    // Get the size of the backup file
    $database_size = round(filesize($backup_file) / 1024 / 1024, 2); // Size in MB

    // Insert backup information into the database
    $stmt = $conn->prepare("INSERT INTO backups (database_name, database_size, backup_date, file_path) VALUES (?, ?, NOW(), ?)");
    $stmt->bind_param("sds", $database_name, $database_size, $backup_file);
    if (!$stmt->execute()) {
        die("Error inserting backup record: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();

    return $backup_file;
}

// Call the function to generate the backup
$backup_file = generateBackup($conn);

// Output the backup file path for download
echo "Backup created successfully: <a href='$backup_file' download>Download Backup</a>";
?>
