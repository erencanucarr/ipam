<?php

require_once 'models/AuditLog.php';

class AuditLogController
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'support') {
            header('Location: index.php?page=ips');
            exit;
        }
        $logs = AuditLog::all();
        require 'views/audit_logs/index.php';
    }
}