# Simple PHP IPAM (IP Address Management System)

A modern, secure, and lightweight IP Address Management (IPAM) system built with pure PHP and MySQL.  
Designed for easy deployment on any standard Linux hosting (cPanel, Plesk, DirectAdmin, etc.) without any framework dependencies.

---

## 🚀 Features

- **User Management:**  
  - Role-based access: Admin, User, Support  
  - Secure authentication and session management  
  - User-friendly success and error messages after all actions

- **Subnet & IP Management:**  
  - Create, edit, delete, and list subnets  
  - Bulk IP address generation and management  
  - Assign statuses, descriptions, and clients to IPs  
  - **Export/Import subnets** in JSON, XML, and CSV formats  
  - **Advanced search/filter** for subnets

- **IP Conflict & Usage Reporting:**  
  - Detects duplicate/conflicting IPs  
  - Subnet utilization and unused IPs report  
  - Accessible from the dashboard

- **Audit Logging:**  
  - Tracks all critical actions (user, subnet, IP changes)  
  - Viewable audit log with user and device info  
  - **Advanced filtering** (by user, action, date) and color-coded actions  
  - Modern, readable UI

- **Email Notification System:**  
  - Sends notification emails (e.g., on user creation)  
  - Easy to configure sender address

- **Help Docs System:**  
  - Integrated, SQL-based help documentation  
  - Users can view help articles directly in the dashboard

- **Modern UI:**  
  - Responsive, mobile-friendly dashboard  
  - Clean, user-friendly design  
  - Compact, visually balanced action buttons  
  - All notification and error messages are clear and visually distinct

- **Performance Optimizations:**  
  - Batch IP insertions for large subnets  
  - Optimized queries and memory usage  
  - Fast and scalable for large networks

- **Security:**  
  - Passwords stored with `password_hash()`  
  - Input validation and output escaping  
  - Role-based access control

- **Easy Setup:**  
  - No frameworks required  
  - Works out-of-the-box on shared hosting  
  - Simple SQL migrations included

---

## 🖥️ Hosting & Compatibility

- Compatible with **cPanel**, **Plesk**, and all major Linux hosting panels
- Runs on any LAMP/LEMP stack (Linux + Apache/Nginx + MySQL + PHP)
- No special server configuration required

---

## ⚙️ Requirements

- PHP 7.4 or higher (PHP 8.x fully supported)
- MySQL 5.7 or higher
- MySQLi extension enabled
- Apache or Nginx web server
- Standard Linux hosting (cPanel, Plesk, DirectAdmin, etc.)
- (Optional) SSL certificate for secure access

---

## 📦 Installation

1. **Clone or Download the Repository**
   ```bash
   git clone https://github.com/yourusername/php-ipam.git
   ```
2. **Upload Files to Your Server**
   - Use FTP, SFTP, or your hosting panel’s file manager.

3. **Create the Database**
   - Import the provided `database.sql` file into your MySQL server.

4. **Configure Database Connection**
   - Edit the `config.php` file with your database credentials.

5. **Set File Permissions**
   - Ensure PHP can read/write necessary files and folders.

6. **Access the Application**
   - Open your site in a browser and log in with the default admin account.

---

## 🔑 Default Admin Account

After installation, you can log in with the following default admin credentials:

- **Email:** `admin@example.com`
- **Password:** `admin123`

> ⚠️ **Important:** For security, change the default admin password immediately after your first login.

---

## 🛡️ Security Notes

- All passwords are securely hashed.
- Role-based access ensures only authorized users can perform sensitive actions.
- Always use HTTPS in production.

---

## 📚 Screenshots

_Add screenshots of the dashboard, subnet management, IP listing, and help docs here._

---

## 📝 License

This project is open source and available under the MIT License.

---

## 🙋‍♂️ Contributing

Pull requests and suggestions are welcome!  
Feel free to open an issue or contact me for feedback.

---

## 📣 Contact

- **Developer:** Eren Can Uçar  
- **Email:** dev@eren.gg  
- **LinkedIn:** [linkedin.com/in/erencanucarr](https://www.linkedin.com/in/erencanucarr/)  
- **GitHub:** [github.com/erencanucarr](https://github.com/erencanucarr)

---

> _A simple, modern, and secure IPAM solution for everyone!_