<?php
/**
 * CDMS Configuration Example
 * Copy this file to config.php and update with your settings
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'your_database_username');
define('DB_PASSWORD', 'your_database_password');
define('DB_NAME', 'cdms');

// Application Settings
define('APP_NAME', 'Client Database Management System');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'https://yourdomain.com');

// Security Settings
define('SESSION_TIMEOUT', 3600); // 1 hour in seconds
define('PASSWORD_MIN_LENGTH', 8);
define('MAX_LOGIN_ATTEMPTS', 5);

// Email Configuration (for notifications)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'your-email@gmail.com');
define('SMTP_PASSWORD', 'your-app-password');
define('SMTP_FROM_EMAIL', 'noreply@yourdomain.com');
define('SMTP_FROM_NAME', 'CDMS System');

// File Upload Settings
define('UPLOAD_MAX_SIZE', 5242880); // 5MB in bytes
define('ALLOWED_FILE_TYPES', 'jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx');
define('UPLOAD_PATH', 'uploads/');

// System Settings
define('TIMEZONE', 'America/New_York');
define('DATE_FORMAT', 'Y-m-d H:i:s');
define('CURRENCY_SYMBOL', '$');

// Debug Settings (NEVER enable in production)
define('DEBUG_MODE', false);
define('LOG_ERRORS', true);
define('ERROR_LOG_FILE', 'logs/error.log');

// Backup Settings
define('BACKUP_PATH', 'backup/');
define('AUTO_BACKUP', true);
define('BACKUP_RETENTION_DAYS', 30);

// Notification Settings
define('ENABLE_EMAIL_NOTIFICATIONS', true);
define('ENABLE_SYSTEM_NOTIFICATIONS', true);
define('NOTIFICATION_RETENTION_DAYS', 90);

// Pagination Settings
define('RECORDS_PER_PAGE', 25);
define('MAX_RECORDS_PER_PAGE', 100);

// Security Headers
if (!DEBUG_MODE) {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
}

// Set timezone
date_default_timezone_set(TIMEZONE);

// Error reporting based on debug mode
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    if (LOG_ERRORS) {
        ini_set('log_errors', 1);
        ini_set('error_log', ERROR_LOG_FILE);
    }
}
?>
