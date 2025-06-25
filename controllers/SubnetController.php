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

        // EXPORT logic
        if ($action === 'export' && isset($_GET['format'])) {
            $format = strtolower($_GET['format']);
            $subnets = Subnet::all();
            if ($format === 'json') {
                header('Content-Type: application/json');
                header('Content-Disposition: attachment; filename="subnets.json"');
                echo json_encode($subnets, JSON_PRETTY_PRINT);
                exit;
            } elseif ($format === 'xml') {
                header('Content-Type: application/xml');
                header('Content-Disposition: attachment; filename="subnets.xml"');
                $xml = new SimpleXMLElement('<subnets/>');
                foreach ($subnets as $subnet) {
                    $item = $xml->addChild('subnet');
                    foreach ($subnet as $k => $v) {
                        $item->addChild($k, htmlspecialchars($v));
                    }
                }
                echo $xml->asXML();
                exit;
            } elseif ($format === 'csv') {
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="subnets.csv"');
                $out = fopen('php://output', 'w');
                if (!empty($subnets)) {
                    fputcsv($out, array_keys($subnets[0]));
                    foreach ($subnets as $row) {
                        fputcsv($out, $row);
                    }
                }
                fclose($out);
                exit;
            } else {
                header('Location: index.php?page=subnets');
                exit;
            }
        }

        // IMPORT logic
        if ($action === 'import' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_FILES['import_file']) || $_FILES['import_file']['error'] !== UPLOAD_ERR_OK) {
                header('Location: index.php?page=subnets&error=upload');
                exit;
            }
            $file = $_FILES['import_file']['tmp_name'];
            $filename = $_FILES['import_file']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $imported = 0;
            $subnets = [];
            if ($ext === 'json') {
                $data = json_decode(file_get_contents($file), true);
                if (is_array($data)) $subnets = $data;
            } elseif ($ext === 'xml') {
                $xml = simplexml_load_file($file);
                if ($xml && isset($xml->subnet)) {
                    foreach ($xml->subnet as $item) {
                        $row = [];
                        foreach ($item as $k => $v) $row[$k] = (string)$v;
                        $subnets[] = $row;
                    }
                }
            } elseif ($ext === 'csv') {
                $handle = fopen($file, 'r');
                if ($handle) {
                    $header = fgetcsv($handle);
                    while (($row = fgetcsv($handle)) !== false) {
                        $subnets[] = array_combine($header, $row);
                    }
                    fclose($handle);
                }
            }
            // Insert subnets
            foreach ($subnets as $row) {
                if (!isset($row['name'], $row['network'], $row['cidr'])) continue;
                $data = [
                    'name' => $row['name'],
                    'network' => $row['network'],
                    'cidr' => intval($row['cidr']),
                    'description' => $row['description'] ?? ''
                ];
                Subnet::create($data);
                $imported++;
            }
            header('Location: index.php?page=subnets&imported=' . $imported);
            exit;
        }

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