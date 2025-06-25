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
        require 'views/auth/login.php';
    }

    public function logout()
    {
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }
}