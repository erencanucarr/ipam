-- IMPORTANT: For a clean install, run this file in two steps if you get "Unknown column" errors:
-- 1. Run ONLY the DROP TABLE statements below first, to remove old tables and constraints.
-- 2. Then run the rest of the file (CREATE TABLE + INSERT) after the drops succeed.

-- DROP TABLES FOR CLEAN INSTALL (order matters for FKs)
DROP TABLE IF EXISTS audit_logs;
DROP TABLE IF EXISTS ip_addresses;
DROP TABLE IF EXISTS subnets;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS help_docs;

-- USERS TABLE
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    role ENUM('admin','user','support') NOT NULL DEFAULT 'user'
);

-- SUBNETS TABLE
CREATE TABLE IF NOT EXISTS subnets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    network VARCHAR(255) NOT NULL,
    cidr INT NOT NULL,
    description VARCHAR(255)
);

-- IP ADDRESSES TABLE
CREATE TABLE IF NOT EXISTS ip_addresses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subnet_id INT NOT NULL,
    address VARCHAR(255) NOT NULL,
    mask VARCHAR(32) NOT NULL DEFAULT '255.255.255.0',
    status ENUM('assigned', 'free', 'reserved') NOT NULL DEFAULT 'free',
    description VARCHAR(255),
    client VARCHAR(255),
    FOREIGN KEY (subnet_id) REFERENCES subnets(id) ON DELETE CASCADE
);

-- AUDIT LOGS TABLE
CREATE TABLE IF NOT EXISTS audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(50) NOT NULL,
    target_type VARCHAR(50) NOT NULL,
    target_id INT NOT NULL,
    description VARCHAR(255),
    device_ip VARCHAR(45),
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- HELP DOCS TABLE
CREATE TABLE IF NOT EXISTS help_docs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author VARCHAR(100) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- DEFAULT ADMIN USER
INSERT INTO users (email, password, name, role) VALUES
('admin@example.com', MD5('admin123'), 'Admin', 'admin')
ON DUPLICATE KEY UPDATE email=email;

-- 
-- The following ALTER statements were previously in separate files and are now included for reference:
--
-- ALTER TABLE audit_logs
--   ADD COLUMN device_ip VARCHAR(45) AFTER description,
--   ADD COLUMN created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER device_ip;
--
-- ALTER TABLE users
--   ADD COLUMN role ENUM('admin','user') NOT NULL DEFAULT 'user' AFTER password;