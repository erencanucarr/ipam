<?php

class IpAddress
{
    public static function allBySubnet($subnet_id)
    {
        $conn = self::getConnection();
        $stmt = $conn->prepare("SELECT * FROM ip_addresses WHERE subnet_id = ? ORDER BY id ASC");
        $stmt->bind_param("i", $subnet_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $ips = [];
        while ($row = $result->fetch_assoc()) {
            $ips[] = $row;
        }
        $conn->close();
        return $ips;
    }

    public static function find($id)
    {
        $conn = self::getConnection();
        $stmt = $conn->prepare("SELECT * FROM ip_addresses WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $ip = $result->fetch_assoc();
        $conn->close();
        return $ip;
    }

    public static function create($data)
    {
        $conn = self::getConnection();
        $stmt = $conn->prepare("INSERT INTO ip_addresses (subnet_id, address, mask, status, description, client) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die("SQL Error in IpAddress::create: " . $conn->error);
        }
        $stmt->bind_param("isssss", $data['subnet_id'], $data['address'], $data['mask'], $data['status'], $data['description'], $data['client']);
        $stmt->execute();
        $conn->close();
        return $stmt->insert_id;
    }

    /**
     * Batch insert multiple IP addresses in a single transaction.
     * @param array $ipDataArray Array of associative arrays with keys: subnet_id, address, mask, status, description, client
     * @return int Number of inserted rows
     */
    public static function createBatch($ipDataArray)
    {
        if (empty($ipDataArray)) return 0;
        $conn = self::getConnection();
        $conn->begin_transaction();
        $stmt = $conn->prepare("INSERT INTO ip_addresses (subnet_id, address, mask, status, description, client) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            $conn->rollback();
            $conn->close();
            die("SQL Error in IpAddress::createBatch: " . $conn->error);
        }
        foreach ($ipDataArray as $data) {
            $stmt->bind_param(
                "isssss",
                $data['subnet_id'],
                $data['address'],
                $data['mask'],
                $data['status'],
                $data['description'],
                $data['client']
            );
            $stmt->execute();
        }
        $affected = $stmt->affected_rows;
        $stmt->close();
        $conn->commit();
        $conn->close();
        return $affected;
    }

    public static function update($id, $data)
    {
        $conn = self::getConnection();
        $stmt = $conn->prepare("UPDATE ip_addresses SET address=?, mask=?, status=?, description=?, client=? WHERE id=?");
        $stmt->bind_param("sssssi", $data['address'], $data['mask'], $data['status'], $data['description'], $data['client'], $id);
        $stmt->execute();
        $conn->close();
        return $stmt->affected_rows;
    }

    public static function delete($id)
    {
        $conn = self::getConnection();
        $stmt = $conn->prepare("DELETE FROM ip_addresses WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $conn->close();
        return $stmt->affected_rows;
    }

    private static function getConnection()
    {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
}