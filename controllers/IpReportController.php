<?php

require_once 'models/IpAddress.php';
require_once 'models/Subnet.php';

class IpReportController
{
    public function handle()
    {
        // 1. IP Conflicts: addresses that appear more than once
        $conn = IpAddress::getConnection();
        $conflict_sql = "SELECT address, COUNT(*) as count FROM ip_addresses GROUP BY address HAVING count > 1 ORDER BY count DESC";
        $conflicts = [];
        $result = $conn->query($conflict_sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $conflicts[] = $row;
            }
        }
        error_log("[IPREPORT] Conflicts found: " . count($conflicts) . " | Sample: " . json_encode(array_slice($conflicts,0,2)));

        // 2. Subnet Utilization
        $subnets = Subnet::all();
        $utilization = [];
        foreach ($subnets as $subnet) {
            $subnet_id = $subnet['id'];
            $total = 0; $used = 0; $free = 0;
            $conn2 = IpAddress::getConnection();
            $stmt = $conn2->prepare("SELECT status, COUNT(*) as cnt FROM ip_addresses WHERE subnet_id=? GROUP BY status");
            $stmt->bind_param("i", $subnet_id);
            $stmt->execute();
            $stmt->bind_result($status, $cnt);
            while ($stmt->fetch()) {
                $total += $cnt;
                if ($status === 'used') $used += $cnt;
                if ($status === 'free') $free += $cnt;
            }
            $stmt->close();
            $conn2->close();
            $utilization[] = [
                'subnet' => $subnet,
                'total' => $total,
                'used' => $used,
                'free' => $free,
                'percent_used' => $total > 0 ? round($used * 100 / $total, 1) : 0
            ];
        }
        error_log("[IPREPORT] Subnet utilization entries: " . count($utilization) . " | Sample: " . json_encode(array_slice($utilization,0,2)));

        // 3. Unused IPs (status = free)
        $conn3 = IpAddress::getConnection();
        $unused_ips = [];
        $result = $conn3->query("SELECT * FROM ip_addresses WHERE status='free' ORDER BY subnet_id, address");
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $unused_ips[] = $row;
            }
        }
        error_log("[IPREPORT] Unused IPs found: " . count($unused_ips) . " | Sample: " . json_encode(array_slice($unused_ips,0,2)));
        $conn3->close();

        require 'views/ips/report.php';
    }
}