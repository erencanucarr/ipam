<?php

class Subnet
{
    public static function all()
    {
        $conn = self::getConnection();
        $stmt = $conn->prepare("SELECT * FROM subnets ORDER BY id DESC");
        $stmt->execute();
        $stmt->store_result();
        $meta = $stmt->result_metadata();
        $subnets = [];
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
                    $subnets[] = $row;
                }
            }
        }
        $stmt->close();
        $conn->close();
        return $subnets;
    }

    public static function getAll()
    {
        return self::all();
    }

    public static function find($id)
    {
        $conn = self::getConnection();
        $stmt = $conn->prepare("SELECT * FROM subnets WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        $meta = $stmt->result_metadata();
        $subnet = null;
        if ($meta) {
            $fields = $meta->fetch_fields();
            $row = [];
            $bindArgs = [];
            foreach ($fields as $field) {
                $row[$field->name] = null;
                $bindArgs[] = &$row[$field->name];
            }
            call_user_func_array([$stmt, 'bind_result'], $bindArgs);
            if ($stmt->fetch()) {
                $subnet = $row;
            }
        }
        $stmt->close();
        $conn->close();
        return $subnet;
    }

    public static function create($data)
    {
        $conn = self::getConnection();
        $stmt = $conn->prepare("INSERT INTO subnets (name, network, cidr, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $data['name'], $data['network'], $data['cidr'], $data['description']);
        $stmt->execute();
        $conn->close();
        return $stmt->insert_id;
    }

    public static function update($id, $data)
    {
        $conn = self::getConnection();
        $stmt = $conn->prepare("UPDATE subnets SET name=?, network=?, cidr=?, description=? WHERE id=?");
        $stmt->bind_param("ssisi", $data['name'], $data['network'], $data['cidr'], $data['description'], $id);
        $stmt->execute();
        $conn->close();
        return $stmt->affected_rows;
    }

    public static function delete($id)
    {
        $conn = self::getConnection();
        $stmt = $conn->prepare("DELETE FROM subnets WHERE id=?");
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