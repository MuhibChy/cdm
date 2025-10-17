# Client Database Management System (CDMS)

A comprehensive web-based client database management system designed for businesses to manage customer relationships, track orders, and streamline sales processes.

## 🚀 Live Demo

**GitHub Pages Demo**: [View Static Demo](https://yourusername.github.io/cdm/demo.html)

> **Note**: The GitHub Pages version is a static demo showcasing the UI and features. For full functionality, deploy to a PHP hosting service.

## 📋 Features

### Multi-Role Authentication System
- **Super Administrator**: Complete system control, user management, database operations
- **Administrator**: Customer management, order oversight, reporting
- **Sales Agent**: Lead management, customer engagement, order processing

### Core Functionality
- 📊 **Dashboard Analytics**: Real-time metrics and performance indicators
- 👥 **Customer Management**: Complete customer database with detailed profiles
- 🛒 **Order Tracking**: Full order lifecycle management (Leads → Engagement → Proposal → Order → Payment → Delivery → Closed)
- 🔔 **Real-time Notifications**: System-wide notification system
- 📈 **Advanced Reporting**: Export data in CSV, Excel, and PDF formats
- 📱 **Responsive Design**: Mobile-friendly interface using AdminLTE framework

### Sales Pipeline Management
1. **Leads**: Initial customer contact and qualification
2. **Engagement**: Active communication and relationship building
3. **Proposal**: Formal proposal submission and negotiation
4. **Order**: Confirmed orders and processing
5. **Payment**: Payment tracking and confirmation
6. **Delivery**: Order fulfillment and delivery tracking
7. **Closed**: Completed transactions

## 🛠️ Technology Stack

- **Backend**: PHP 8.x, MySQL/MariaDB
- **Frontend**: HTML5, CSS3, JavaScript, jQuery
- **Framework**: AdminLTE 3.x (Bootstrap 4)
- **Database**: MySQL with comprehensive relational structure
- **Dependencies**: PHPMailer for email functionality

## 📁 Project Structure

```
cdm/
├── demo.html                          # GitHub Pages demo entry point
├── *_dashboard_demo.html              # Static demo dashboards
├── index.php                          # Main login page
├── conn.php                           # Database connection
├── composer.json                      # PHP dependencies
├── database/
│   └── cdms.sql                       # Database schema and sample data
├── dist/                              # AdminLTE theme assets
├── plugins/                           # Third-party plugins
├── admin_*.php                        # Admin panel files
├── user_*.php                         # User panel files
├── superadmin_*.php                   # Super admin files
└── README.md                          # This file
```

## 🚀 Deployment Options

### Option 1: GitHub Pages (Static Demo Only)

1. **Fork this repository**
2. **Enable GitHub Pages**:
   - Go to repository Settings
   - Scroll to "Pages" section
   - Select "Deploy from a branch"
   - Choose "main" branch and "/ (root)" folder
   - Save settings

3. **Access your demo**:
   - URL: `https://yourusername.github.io/repository-name/demo.html`

### Option 2: Full PHP Deployment

#### Prerequisites
- PHP 8.0 or higher
- MySQL 5.7 or higher / MariaDB 10.3+
- Web server (Apache/Nginx)
- Composer (for dependencies)

#### Hosting Providers (Recommended)
- **Shared Hosting**: Hostinger, Bluehost, SiteGround
- **VPS/Cloud**: DigitalOcean, Linode, AWS EC2
- **Free Options**: 000webhost, InfinityFree (limited features)

#### Installation Steps

1. **Upload Files**:
   ```bash
   # Via FTP/SFTP or hosting file manager
   # Upload all files except demo HTML files
   ```

2. **Database Setup**:
   ```sql
   # Create database
   CREATE DATABASE cdms;
   
   # Import schema
   mysql -u username -p cdms < database/cdms.sql
   ```

3. **Configure Database Connection**:
   ```php
   # Edit conn.php or set environment variables
   DB_HOST=localhost
   DB_USERNAME=your_db_user
   DB_PASSWORD=your_db_password
   DB_NAME=cdms
   ```

4. **Install Dependencies**:
   ```bash
   composer install
   ```

5. **Set Permissions**:
   ```bash
   chmod 755 uploads/
   chmod 755 files/
   chmod 644 *.php
   ```

6. **Default Login Credentials**:
   - Check the database dump for default users
   - **Super Admin**: Usually admin/admin123
   - **Change default passwords immediately**

### Option 3: Local Development (XAMPP/WAMP)

1. **Install XAMPP/WAMP**
2. **Copy project to htdocs**:
   ```
   C:\xampp\htdocs\cdm\
   ```
3. **Start Apache and MySQL**
4. **Import database via phpMyAdmin**
5. **Access**: `http://localhost/cdm`

## 🔧 Configuration

### Environment Variables
Create a `.env` file or set server environment variables:

```env
DB_HOST=localhost
DB_USERNAME=your_username
DB_PASSWORD=your_password
DB_NAME=cdms
DEBUG=false
```

### Email Configuration
Edit PHPMailer settings in relevant files for notification emails.

### Security Considerations
- Change default passwords
- Update database credentials
- Enable HTTPS in production
- Regular security updates
- Implement proper backup procedures

## 📊 Database Schema

The system uses a comprehensive MySQL database with the following key tables:

- `users` - System users and authentication
- `customers` - Customer information and profiles
- `admin_notifications` - System notifications
- `backups` - Database backup records
- Additional tables for orders, transactions, and system logs

## 🎨 Customization

### Branding
- Replace logo files in `dist/img/`
- Update company information in templates
- Modify color schemes in CSS files

### Features
- Add custom fields to customer profiles
- Extend notification system
- Create additional reports
- Integrate with external APIs

## 🐛 Troubleshooting

### Common Issues

1. **Database Connection Failed**:
   - Verify database credentials in `conn.php`
   - Ensure MySQL service is running
   - Check database exists and user has permissions

2. **Login Issues**:
   - Verify user exists in database
   - Check password hashing (uses PHP `password_verify()`)
   - Clear browser cache and cookies

3. **File Upload Problems**:
   - Check folder permissions (755 for directories)
   - Verify PHP upload limits in `php.ini`
   - Ensure upload directories exist

4. **Email Notifications Not Working**:
   - Configure PHPMailer settings
   - Check SMTP credentials
   - Verify server email capabilities

## 📝 License

This project is open source. Please check the license file for specific terms.

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📞 Support

For support and questions:
- Create an issue in the GitHub repository
- Check the troubleshooting section
- Review the database schema documentation

## 🔄 Updates and Maintenance

### Regular Maintenance
- Database backups (automated via system)
- Security updates
- Performance monitoring
- User access reviews

### Version History
- v1.0.0 - Initial release with core functionality
- Demo version - Static GitHub Pages compatible version

---

**⚠️ Important Security Note**: Always change default passwords and keep the system updated. This system handles sensitive business data and should be properly secured in production environments.

**🎯 Demo Limitations**: The GitHub Pages demo is static and doesn't include server-side functionality. For full features including database operations, user authentication, and dynamic content, deploy to a PHP-compatible hosting service.
