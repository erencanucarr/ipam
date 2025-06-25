<?php

class AuditLog
{
    public static function all($limit = 100)
    {
        $conn = self::getConnection();
        $stmt = $conn->prepare("SELECT audit_logs.*, users.name as user_name FROM audit_logs LEFT JOIN users ON audit_logs.user_id = users.id ORDER BY audit_logs.id DESC LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $meta = $stmt->result_metadata();
        $logs = [];
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
                    $logs[] = $row;
                }
            }
        }
        $conn->close();
        return $logs;
    }

    // New: Search/filter logs by user, action, date (all params optional)
    public static function search($user_id = null, $action = null, $date = null, $limit = 100)
    {
        $conn = self::getConnection();
        $query = "SELECT audit_logs.*, users.name as user_name FROM audit_logs LEFT JOIN users ON audit_logs.user_id = users.id WHERE 1=1";
        $params = [];
        $types = "";

        if ($user_id) {
            $query .= " AND audit_logs.user_id = ?";
            $params[] = $user_id;
            $types .= "i";
        }
        if ($action) {
            $query .= " AND audit_logs.action = ?";
            $params[] = $action;
            $types .= "s";
        }
        if ($date) {
            $query .= " AND DATE(audit_logs.created_at) = ?";
            $params[] = $date;
            $types .= "s";
        }
        $query .= " ORDER BY audit_logs.id DESC LIMIT ?";
        $params[] = $limit;
        $types .= "i";

        $stmt = $conn->prepare($query);
        if ($types) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $meta = $stmt->result_metadata();
        $logs = [];
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
                    $logs[] = $row;
                }
            }
        }
        $conn->close();
        return $logs;
    }

    public static function create($user_id, $action, $target_type, $target_id, $description = null)
    {
        $conn = self::getConnection();
        $device_ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
        $created_at = date('Y-m-d H:i:s');
        $stmt = $conn->prepare("INSERT INTO audit_logs (user_id, action, target_type, target_id, description, device_ip, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ississs", $user_id, $action, $target_type, $target_id, $description, $device_ip, $created_at);
        $stmt->execute();
        $conn->close();
        return $stmt->insert_id;
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