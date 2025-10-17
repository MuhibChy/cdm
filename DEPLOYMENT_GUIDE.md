# CDMS Deployment Guide

This guide provides step-by-step instructions for deploying the Client Database Management System to various hosting platforms.

## 🎯 Quick Start Checklist

- [ ] Choose hosting platform
- [ ] Upload files
- [ ] Create database
- [ ] Import database schema
- [ ] Configure database connection
- [ ] Install dependencies
- [ ] Set file permissions
- [ ] Test login functionality
- [ ] Change default passwords

## 🌐 Hosting Platform Guides

### 1. GitHub Pages (Demo Only)

**Best for**: Showcasing the UI and features

```bash
# 1. Fork/clone the repository
git clone https://github.com/yourusername/cdm.git

# 2. Enable GitHub Pages in repository settings
# 3. Set source to main branch
# 4. Access demo at: https://yourusername.github.io/cdm/demo.html
```

**Limitations**: No server-side functionality, database operations, or user authentication.

### 2. Shared Hosting (Recommended for Small-Medium Business)

#### Hostinger / Bluehost / SiteGround

**Step 1: Upload Files**
```bash
# Via File Manager or FTP
# Upload all PHP files to public_html/ or www/
# Exclude: *_demo.html files (optional)
```

**Step 2: Database Setup**
```sql
-- In cPanel/hosting control panel:
-- 1. Create MySQL database: yourdomain_cdms
-- 2. Create database user with full privileges
-- 3. Import database/cdms.sql via phpMyAdmin
```

**Step 3: Configuration**
```php
// Edit conn.php
$db_host = 'localhost'; // Usually localhost
$db_username = 'yourdomain_dbuser';
$db_password = 'your_secure_password';
$db_name = 'yourdomain_cdms';
```

**Step 4: Dependencies**
```bash
# If Composer is available:
composer install

# If not available, PHPMailer is included in vendor/
# No additional setup needed
```

### 3. VPS/Cloud Hosting (Advanced Users)

#### DigitalOcean / Linode / AWS EC2

**Step 1: Server Setup**
```bash
# Ubuntu 20.04/22.04 LTS
sudo apt update && sudo apt upgrade -y

# Install LAMP stack
sudo apt install apache2 mysql-server php php-mysql php-mbstring php-xml php-curl -y

# Enable Apache modules
sudo a2enmod rewrite
sudo systemctl restart apache2
```

**Step 2: MySQL Configuration**
```bash
# Secure MySQL installation
sudo mysql_secure_installation

# Create database and user
sudo mysql -u root -p
```

```sql
CREATE DATABASE cdms;
CREATE USER 'cdms_user'@'localhost' IDENTIFIED BY 'secure_password_here';
GRANT ALL PRIVILEGES ON cdms.* TO 'cdms_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

**Step 3: Deploy Application**
```bash
# Clone or upload to web directory
cd /var/www/html
sudo git clone https://github.com/yourusername/cdm.git
sudo chown -R www-data:www-data cdm/
sudo chmod -R 755 cdm/

# Import database
mysql -u cdms_user -p cdms < cdm/database/cdms.sql
```

**Step 4: Apache Virtual Host**
```apache
# /etc/apache2/sites-available/cdms.conf
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /var/www/html/cdm
    
    <Directory /var/www/html/cdms>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/cdms_error.log
    CustomLog ${APACHE_LOG_DIR}/cdms_access.log combined
</VirtualHost>
```

```bash
# Enable site
sudo a2ensite cdms.conf
sudo systemctl reload apache2
```

### 4. Free Hosting Options

#### 000webhost / InfinityFree

**Limitations**:
- Limited PHP functions
- Restricted database size
- No Composer support
- Advertising on free plans

**Setup Process**:
1. Create account and domain
2. Upload files via file manager
3. Create MySQL database in control panel
4. Import database schema
5. Update connection settings

## 🔧 Configuration Details

### Database Connection Options

**Option 1: Direct Configuration**
```php
// conn.php
$db_host = 'localhost';
$db_username = 'your_username';
$db_password = 'your_password';
$db_name = 'your_database';
```

**Option 2: Environment Variables**
```php
// conn.php (recommended for production)
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_username = getenv('DB_USERNAME') ?: 'root';
$db_password = getenv('DB_PASSWORD') ?: '';
$db_name = getenv('DB_NAME') ?: 'cdms';
```

### File Permissions

```bash
# Recommended permissions
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;

# Writable directories
chmod 755 uploads/
chmod 755 files/
chmod 755 backup/
```

### Security Hardening

**1. .htaccess Protection**
```apache
# .htaccess in root directory
RewriteEngine On

# Protect sensitive files
<Files "conn.php">
    Order Allow,Deny
    Deny from all
</Files>

<Files "*.sql">
    Order Allow,Deny
    Deny from all
</Files>

# Force HTTPS (if SSL available)
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

**2. Database Security**
```sql
-- Remove default/test users
DELETE FROM users WHERE username IN ('admin', 'test', 'demo');

-- Create secure admin user
INSERT INTO users (username, password, role, firstname, lastname, email) 
VALUES ('your_admin', PASSWORD('secure_password_123!'), 'superadmin', 'Your', 'Name', 'admin@yourdomain.com');
```

## 🧪 Testing Deployment

### Pre-Launch Checklist

```bash
# 1. Test database connection
curl -I http://yourdomain.com/conn.php
# Should return 403 Forbidden (protected)

# 2. Test main page
curl -I http://yourdomain.com/
# Should return 200 OK

# 3. Test login functionality
# Visit login page and attempt authentication

# 4. Check error logs
tail -f /var/log/apache2/error.log
```

### Common Issues & Solutions

**Issue**: Database connection failed
```bash
# Solution: Check credentials and MySQL service
sudo systemctl status mysql
mysql -u username -p -e "SHOW DATABASES;"
```

**Issue**: File upload errors
```bash
# Solution: Check PHP configuration
php -i | grep upload
# Increase upload_max_filesize and post_max_size if needed
```

**Issue**: Session errors
```bash
# Solution: Check session directory permissions
ls -la /var/lib/php/sessions/
sudo chown www-data:www-data /var/lib/php/sessions/
```

## 📊 Performance Optimization

### PHP Configuration
```ini
# php.ini optimizations
memory_limit = 256M
max_execution_time = 300
upload_max_filesize = 50M
post_max_size = 50M
max_input_vars = 3000
```

### MySQL Optimization
```sql
-- Enable query cache
SET GLOBAL query_cache_size = 67108864;
SET GLOBAL query_cache_type = ON;

-- Optimize tables
OPTIMIZE TABLE customers, users, admin_notifications;
```

### Apache Optimization
```apache
# Enable compression
LoadModule deflate_module modules/mod_deflate.so
<Location />
    SetOutputFilter DEFLATE
</Location>

# Enable caching
LoadModule expires_module modules/mod_expires.so
ExpiresActive On
ExpiresByType text/css "access plus 1 month"
ExpiresByType application/javascript "access plus 1 month"
ExpiresByType image/png "access plus 1 month"
```

## 🔄 Maintenance & Updates

### Regular Maintenance Tasks

```bash
# 1. Database backup (automated via system)
# 2. Update system packages
sudo apt update && sudo apt upgrade

# 3. Monitor disk space
df -h

# 4. Check error logs
tail -100 /var/log/apache2/error.log

# 5. Security updates
# Keep PHP, MySQL, and system updated
```

### Backup Strategy

```bash
# Database backup script
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u username -p cdms > backup_$DATE.sql
gzip backup_$DATE.sql

# File backup
tar -czf files_backup_$DATE.tar.gz uploads/ files/
```

## 🆘 Troubleshooting

### Debug Mode
```php
// Enable in conn.php for troubleshooting
define('DEBUG', true);
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### Log Analysis
```bash
# Apache error logs
sudo tail -f /var/log/apache2/error.log

# PHP error logs
sudo tail -f /var/log/php_errors.log

# MySQL error logs
sudo tail -f /var/log/mysql/error.log
```

---

**🚨 Security Reminder**: Always change default passwords, enable HTTPS, and keep your system updated. Never deploy with DEBUG mode enabled in production.

**📞 Support**: If you encounter issues during deployment, check the main README.md file or create an issue in the repository.
