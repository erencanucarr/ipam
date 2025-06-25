<?php

class DashboardController
{
    public function index()
    {
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'support') {
            header('Location: index.php?page=ips');
            exit;
        }
        require_once 'models/User.php';
        require_once 'models/Subnet.php';
        require_once 'models/IpAddress.php';

        // User count
        $user_count = count(User::getAll());
        // Subnet count
        $subnet_count = count(Subnet::getAll());
        // IP counts
        $all_ips = [];
        $assigned_count = $free_count = $reserved_count = 0;
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $stmt = $conn->prepare("SELECT status FROM ip_addresses");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($status);
        while ($stmt->fetch()) {
            if ($status === 'assigned') $assigned_count++;
            elseif ($status === 'free') $free_count++;
            elseif ($status === 'reserved') $reserved_count++;
        }
        $ip_count = $assigned_count + $free_count + $reserved_count;
        $stmt->close();
        $conn->close();

        require 'views/dashboard/index.php';
    }
}