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
        // Filtering
        $user_id = isset($_GET['user_id']) && $_GET['user_id'] !== '' ? intval($_GET['user_id']) : null;
        $action = isset($_GET['action']) && $_GET['action'] !== '' ? $_GET['action'] : null;
        $date = isset($_GET['date']) && $_GET['date'] !== '' ? $_GET['date'] : null;
        $logs = AuditLog::search($user_id, $action, $date, 100);

        // For filter form prefill
        $filter_user_id = $user_id;
        $filter_action = $action;
        $filter_date = $date;

        require 'views/audit_logs/index.php';
    }
}