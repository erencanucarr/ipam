<?php

require_once __DIR__ . '/../models/User.php';

class SettingsController
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $user = User::findById($_SESSION['user_id']);
        $message = null;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $password2 = trim($_POST['password2'] ?? '');

            if ($name === '') {
                $error = "Name cannot be empty.";
            } elseif ($email === '') {
                $error = "Email cannot be empty.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Invalid email address.";
            } elseif ($password !== $password2) {
                $error = "Passwords do not match.";
            } else {
                // Update name and email
                $changes = [];
                if ($name !== $user['name']) $changes[] = "name";
                if ($email !== $user['email']) $changes[] = "email";
                $passwordChanged = ($password !== '');
                User::update($_SESSION['user_id'], $name, $email, $user['role']);
                if ($passwordChanged) {
                    User::updatePassword($_SESSION['user_id'], $password);
                    $changes[] = "password";
                }
                $user = User::findById($_SESSION['user_id']);
                $message = "Profile updated successfully.";
                // Update session name and email
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $email;
                // Audit log
                if (!empty($changes)) {
                    $desc = "Changed: " . implode(", ", $changes);
                    $conn = User::getConnection();
                    $stmt = $conn->prepare("INSERT INTO audit_logs (user_id, action, target_type, target_id, description, device_ip) VALUES (?, 'update', 'user', ?, ?, ?)");
                    $uid = $_SESSION['user_id'];
                    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
                    $stmt->bind_param("iiss", $uid, $uid, $desc, $ip);
                    $stmt->execute();
                    $conn->close();
                }
            }
        }

        require __DIR__ . '/../views/settings/index.php';
    }

    public function handle()
    {
        $this->index();
    }
}