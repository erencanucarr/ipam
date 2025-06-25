<?php

require_once 'models/User.php';

class UserController
{
    public function handle()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
            header('Location: index.php?page=login');
            exit;
        }

        $action = $_GET['action'] ?? 'list';
        $id = isset($_GET['id']) ? intval($_GET['id']) : null;

        if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'user';
            if ($name && $email && $password) {
                User::create($name, $email, $password, $role);
                header('Location: index.php?page=users');
                exit;
            } else {
                $error = "All fields are required.";
            }
            require 'views/users/create.php';
        } elseif ($action === 'create') {
            require 'views/users/create.php';
        } elseif ($action === 'edit' && $id && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $role = $_POST['role'] ?? 'user';
            if ($name && $email) {
                User::update($id, $name, $email, $role);
                header('Location: index.php?page=users');
                exit;
            } else {
                $error = "All fields are required.";
            }
            $user = User::findById($id);
            require 'views/users/edit.php';
        } elseif ($action === 'edit' && $id) {
            $user = User::findById($id);
            require 'views/users/edit.php';
        } elseif ($action === 'delete' && $id) {
            User::delete($id);
            header('Location: index.php?page=users');
            exit;
        } else {
            $users = User::getAll();
            require 'views/users/index.php';
        }
    }

    // For router compatibility
    public function index()
    {
        $this->handle();
    }
}