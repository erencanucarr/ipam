<?php
session_start();
require_once 'config.php';

// Simple autoloader for controllers and models
spl_autoload_register(function ($class) {
    foreach (['controllers', 'models'] as $dir) {
        $file = __DIR__ . "/$dir/$class.php";
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Determine requested page
$page = isset($_GET['page']) ? $_GET['page'] : (isset($_SESSION['user_id']) ? 'dashboard' : 'login');

// Routing
switch ($page) {
    case 'login':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;
    case 'logout':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;
    case 'dashboard':
        require_once 'controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->index();
        break;
    case 'subnets':
        require_once 'controllers/SubnetController.php';
        $controller = new SubnetController();
        $controller->handle();
        break;
    case 'ips':
        require_once 'controllers/IpAddressController.php';
        $controller = new IpAddressController();
        $controller->handle();
        break;
    case 'audit_logs':
        require_once 'controllers/AuditLogController.php';
        $controller = new AuditLogController();
        $controller->index();
        break;
    case 'users':
        require_once 'controllers/UserController.php';
        $controller = new UserController();
        $controller->index();
        break;
    case 'help':
        require_once 'controllers/HelpController.php';
        $controller = new HelpController();
        if (isset($_GET['action']) && $_GET['action'] === 'submit') {
            $controller->submit();
        } else {
            $controller->index();
        }
        break;
    case 'settings':
        require_once 'controllers/SettingsController.php';
        $controller = new SettingsController();
        $controller->index();
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        echo "Page not found.";
        break;
}