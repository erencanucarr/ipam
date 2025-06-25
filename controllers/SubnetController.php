<?php

require_once 'models/Subnet.php';
require_once 'models/AuditLog.php';

class SubnetController
{
    public function handle()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'support') {
            header('Location: index.php?page=ips');
            exit;
        }

        $action = $_GET['action'] ?? 'list';
        $id = isset($_GET['id']) ? intval($_GET['id']) : null;

        if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'network' => $_POST['network'] ?? '',
                'cidr' => intval($_POST['cidr'] ?? 24),
                'description' => $_POST['description'] ?? ''
            ];
            $subnet_id = Subnet::create($data);
            // Generate all IPs for the subnet
            require_once 'models/IpAddress.php';
            $mask = cidrToMask($data['cidr']);
            $ips = generateIPs($data['network'], $data['cidr']);
            $created = 0;
            // Prepare batch data for all IPs
            $ipDataArray = [];
            foreach ($ips as $ip) {
                $ipDataArray[] = [
                    'subnet_id' => $subnet_id,
                    'address' => $ip,
                    'mask' => $mask,
                    'status' => 'free',
                    'description' => '',
                    'client' => ''
                ];
            }
            $created = IpAddress::createBatch($ipDataArray);
            error_log("Subnet $subnet_id: Generated " . count($ips) . " IPs, created $created IPs.");
            AuditLog::create($_SESSION['user_id'], 'create', 'subnet', $subnet_id, 'Created subnet: ' . $data['name']);
            header('Location: index.php?page=subnets');
            exit;
        }

        if ($action === 'edit' && $id && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'network' => $_POST['network'] ?? '',
                'cidr' => intval($_POST['cidr'] ?? 24),
                'description' => $_POST['description'] ?? ''
            ];
            Subnet::update($id, $data);
            AuditLog::create($_SESSION['user_id'], 'update', 'subnet', $id, 'Updated subnet: ' . $data['name']);
            header('Location: index.php?page=subnets');
            exit;
        }

        if ($action === 'delete' && $id) {
            $subnet = Subnet::find($id);
            Subnet::delete($id);
            AuditLog::create($_SESSION['user_id'], 'delete', 'subnet', $id, 'Deleted subnet: ' . ($subnet['name'] ?? ''));
            header('Location: index.php?page=subnets');
            exit;
        }

        if ($action === 'create') {
            require 'views/subnets/create.php';
        } elseif ($action === 'edit' && $id) {
            $subnet = Subnet::find($id);
            require 'views/subnets/edit.php';
        } else {
            $subnets = Subnet::all();
            require 'views/subnets/index.php';
        }
    }
}
/* Helper: Convert CIDR to mask */
function cidrToMask($cidr)
{
    $mask = [];
    for ($i = 0; $i < 4; $i++) {
        if ($cidr >= 8) {
            $mask[] = 255;
            $cidr -= 8;
        } else {
            $mask[] = 256 - pow(2, 8 - $cidr);
            $cidr = 0;
        }
    }
    return implode('.', $mask);
}

/* Helper: Generate all host IPs for a subnet */
function generateIPs($ip, $cidr)
{
    $ips = [];
    $ip_long = ip2long($ip);
    $mask = -1 << (32 - $cidr);
    $network_long = $ip_long & $mask;
    $host_bits = 32 - $cidr;
    $num_ips = pow(2, $host_bits);

    // For /31 and /32, special handling (RFC 3021)
    if ($cidr == 31) {
        $ips[] = long2ip($network_long);
        $ips[] = long2ip($network_long + 1);
    } elseif ($cidr == 32) {
        $ips[] = long2ip($network_long);
    } else {
        for ($i = 1; $i < $num_ips - 1; $i++) { // skip network and broadcast
            $ips[] = long2ip($network_long + $i);
        }
    }
    return $ips;
}