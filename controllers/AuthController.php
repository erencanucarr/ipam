<?php

class AuthController
{
    public function login()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            require_once 'models/User.php';
            
            if (defined('MOCK_MODE') && MOCK_MODE) {
                // Mock login for development
                if ($email === 'admin@example.com' && $password === 'admin') {
                    $_SESSION['user_id'] = 1;
                    $_SESSION['user_name'] = 'Admin User';
                    $_SESSION['user_role'] = 'admin';
                    header('Location: index.php?page=dashboard');
                    exit;
                } elseif ($email === 'support@example.com' && $password === 'support') {
                    $_SESSION['user_id'] = 2;
                    $_SESSION['user_name'] = 'Support User';
                    $_SESSION['user_role'] = 'support';
                    header('Location: index.php?page=dashboard');
                    exit;
                } elseif ($email === 'user@example.com' && $password === 'user') {
                    $_SESSION['user_id'] = 3;
                    $_SESSION['user_name'] = 'Regular User';
                    $_SESSION['user_role'] = 'user';
                    header('Location: index.php?page=dashboard');
                    exit;
                } else {
                    $error = 'Invalid email or password.';
                }
            } else {
                $user = User::verify($email, $password);
                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_role'] = $user['role'];
                    header('Location: index.php?page=dashboard');
                    exit;
                } else {
                    $error = 'Invalid email or password.';
                }
            }
        }
        require 'views/auth/login.php';
    }

    public function logout()
    {
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }
}