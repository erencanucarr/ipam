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
        
        if (defined('MOCK_MODE') && MOCK_MODE) {
            // Mock create
            global $mock_data;
            $newId = count($mock_data['ip_addresses']) + 1;
            $newIp = [
                'id' => $newId,
                'subnet_id' => $subnet_id,
                'ip' => $data['address'],
                'status' => $data['status'],
                'hostname' => $data['client'],
                'description' => $data['description']
            ];
            $mock_data['ip_addresses'][] = $newIp;
            $ip_id = $newId;
        } else {
            $ip_id = IpAddress::create($data);
            AuditLog::create($_SESSION['user_id'], 'create', 'ip_address', $ip_id, 'Added IP: ' . $data['address']);
        }
        
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
        
        if (defined('MOCK_MODE') && MOCK_MODE) {
            // Mock update
            global $mock_data;
            foreach ($mock_data['ip_addresses'] as &$ip) {
                if ($ip['id'] == $id) {
                    $ip['ip'] = $data['address'];
                    $ip['status'] = $data['status'];
                    $ip['hostname'] = $data['client'];
                    $ip['description'] = $data['description'];
                    break;
                }
            }
        } else {
            IpAddress::update($id, $data);
            AuditLog::create($_SESSION['user_id'], 'update', 'ip_address', $id, 'Updated IP: ' . $data['address']);
        }
        
        header('Location: index.php?page=ips&subnet_id=' . $subnet_id);
        exit;
    }

    private function delete($id, $subnet_id)
    {
        if (defined('MOCK_MODE') && MOCK_MODE) {
            // Mock delete
            global $mock_data;
            $ip = null;
            foreach ($mock_data['ip_addresses'] as $key => $ip_data) {
                if ($ip_data['id'] == $id) {
                    $ip = $ip_data;
                    unset($mock_data['ip_addresses'][$key]);
                    $mock_data['ip_addresses'] = array_values($mock_data['ip_addresses']);
                    break;
                }
            }
        } else {
            $ip = IpAddress::find($id);
            IpAddress::delete($id);
            AuditLog::create($_SESSION['user_id'], 'delete', 'ip_address', $id, 'Deleted IP: ' . ($ip['address'] ?? ''));
        }
        
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
        
        if (defined('MOCK_MODE') && MOCK_MODE) {
            // Mock IP list
            global $mock_data;
            $ips = array_filter($mock_data['ip_addresses'], function($ip) use ($subnet_id) {
                return $ip['subnet_id'] == $subnet_id;
            });
            $ip_histories = [];
        } else {
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
                $stmt->store_result();
                $meta = $stmt->result_metadata();
                if ($meta) {
                    $fields = $meta->fetch_fields();
                    while ($stmt->fetch()) {
                        $row = [];
                        $bindArgs = [];
                        foreach ($fields as $field) {
                            $row[$field->name] = null;
                            $bindArgs[] = &$row[$field->name];
                        }
                        call_user_func_array([$stmt, 'bind_result'], $bindArgs);
                        if ($stmt->fetch()) {
                            $tid = intval($row['target_id']);
                            $ip_histories[$tid][] = [
                                'user_name' => $row['user_name'] ?? 'System',
                                'created_at' => isset($row['created_at']) ? date('Y-m-d H:i:s', strtotime($row['created_at'])) : '-',
                                'device_ip' => $row['device_ip'] ?? '-'
                            ];
                        }
                    }
                }
                $stmt->close();
                $conn->close();
            }
        }
        
        require 'views/ips/index.php';
    }
}