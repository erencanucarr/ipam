<?php

require_once 'models/IpAddress.php';
require_once 'models/Subnet.php';
require_once 'models/AuditLog.php';

class IpAddressController
{
    public function handle()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $role = $_SESSION['user_role'] ?? 'user';
        $subnet_id = isset($_GET['subnet_id']) ? intval($_GET['subnet_id']) : null;
        $action = $_GET['action'] ?? 'list';
        $id = isset($_GET['id']) ? intval($_GET['id']) : null;

        if (!$subnet_id) {
            header('Location: index.php?page=subnets');
            exit;
        }

        if (in_array($action, ['create', 'edit', 'delete'])) {
            if (!in_array($role, ['admin', 'support'])) {
                header('Location: index.php?page=ips&subnet_id=' . $subnet_id);
                exit;
            }
        }

        switch ($action) {
            case 'create':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->create($subnet_id);
                } else {
                    $this->showCreateForm($subnet_id);
                }
                break;
            case 'edit':
                if ($id && $_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->edit($id, $subnet_id);
                } else {
                    $this->showEditForm($id, $subnet_id);
                }
                break;
            case 'delete':
                if ($id) {
                    $this->delete($id, $subnet_id);
                }
                break;
            default:
                $this->list($subnet_id);
                break;
        }
    }

    private function create($subnet_id)
    {
        $data = [
            'subnet_id' => $subnet_id,
            'address' => $_POST['address'] ?? '',
            'mask' => $_POST['mask'] ?? '255.255.255.0',
            'status' => $_POST['status'] ?? 'free',
            'description' => $_POST['description'] ?? '',
            'client' => $_POST['client'] ?? ''
        ];
        $ip_id = IpAddress::create($data);
        AuditLog::create($_SESSION['user_id'], 'create', 'ip_address', $ip_id, 'Added IP: ' . $data['address']);
        header('Location: index.php?page=ips&subnet_id=' . $subnet_id);
        exit;
    }

    private function edit($id, $subnet_id)
    {
        $data = [
            'address' => $_POST['address'] ?? '',
            'mask' => $_POST['mask'] ?? '255.255.255.0',
            'status' => $_POST['status'] ?? 'free',
            'description' => $_POST['description'] ?? '',
            'client' => $_POST['client'] ?? ''
        ];
        IpAddress::update($id, $data);
        AuditLog::create($_SESSION['user_id'], 'update', 'ip_address', $id, 'Updated IP: ' . $data['address']);
        header('Location: index.php?page=ips&subnet_id=' . $subnet_id);
        exit;
    }

    private function delete($id, $subnet_id)
    {
        $ip = IpAddress::find($id);
        IpAddress::delete($id);
        AuditLog::create($_SESSION['user_id'], 'delete', 'ip_address', $id, 'Deleted IP: ' . ($ip['address'] ?? ''));
        header('Location: index.php?page=ips&subnet_id=' . $subnet_id);
        exit;
    }

    private function showCreateForm($subnet_id)
    {
        $subnet = Subnet::find($subnet_id);
        require 'views/ips/create.php';
    }

    private function showEditForm($id, $subnet_id)
    {
        $subnet = Subnet::find($subnet_id);
        $ip = IpAddress::find($id);
        require 'views/ips/edit.php';
    }

    private function list($subnet_id)
    {
        $subnet = Subnet::find($subnet_id);
        $ips = IpAddress::allBySubnet($subnet_id);
        // Optimize: Fetch all relevant audit logs for these IPs in a single query
        $ip_ids = array_column($ips, 'id');
        $ip_histories = [];
        require_once 'models/User.php';
        require_once 'models/AuditLog.php';
        if (!empty($ip_ids)) {
            $placeholders = implode(',', array_fill(0, count($ip_ids), '?'));
            $types = str_repeat('i', count($ip_ids));
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $sql = "SELECT * FROM audit_logs WHERE target_type = 'ip_address' AND target_id IN ($placeholders) ORDER BY created_at DESC LIMIT 500";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param($types, ...$ip_ids);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $tid = intval($row['target_id']);
                $ip_histories[$tid][] = [
                    'user_name' => $row['user_name'] ?? 'System',
                    'created_at' => isset($row['created_at']) ? date('Y-m-d H:i:s', strtotime($row['created_at'])) : '-',
                    'device_ip' => $row['device_ip'] ?? '-'
                ];
            }
            $stmt->close();
            $conn->close();
        }
        require 'views/ips/index.php';
    }
}