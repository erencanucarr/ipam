<?php

class User
{
    public static function findByEmail($email)
    {
        $conn = self::getConnection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $meta = $stmt->result_metadata();
        if (!$meta) return null;
        $fields = $meta->fetch_fields();
        $row = [];
        $bindArgs = [];
        foreach ($fields as $field) {
            $row[$field->name] = null;
            $bindArgs[] = &$row[$field->name];
        }
        call_user_func_array([$stmt, 'bind_result'], $bindArgs);
        if ($stmt->fetch()) {
            return $row;
        }
        return null;
    }

    public static function findById($id)
    {
        $conn = self::getConnection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        $meta = $stmt->result_metadata();
        if (!$meta) return null;
        $fields = $meta->fetch_fields();
        $row = [];
        $bindArgs = [];
        foreach ($fields as $field) {
            $row[$field->name] = null;
            $bindArgs[] = &$row[$field->name];
        }
        call_user_func_array([$stmt, 'bind_result'], $bindArgs);
        if ($stmt->fetch()) {
            return $row;
        }
        return null;
    }

    public static function getAll()
    {
        $conn = self::getConnection();
        $stmt = $conn->prepare("SELECT id, name, email, role FROM users");
        $stmt->execute();
        $stmt->store_result();
        $meta = $stmt->result_metadata();
        $users = [];
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
                    $users[] = $row;
                }
            }
        }
        $stmt->close();
        $conn->close();
        return $users;
    }

    public static function create($name, $email, $password, $role = 'user')
    {
        $conn = self::getConnection();
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("ssss", $name, $email, $hashed, $role);
        $stmt->execute();
        $conn->close();
        return $stmt->insert_id;
    }

    public static function updatePassword($id, $password)
    {
        $conn = self::getConnection();
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
        $stmt->bind_param("si", $hashed, $id);
        $stmt->execute();
        $conn->close();
        return $stmt->affected_rows;
    }

    public static function update($id, $name, $email, $role = 'user')
    {
        $conn = self::getConnection();
        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, role=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $email, $role, $id);
        $stmt->execute();
        $conn->close();
        return $stmt->affected_rows;
    }

    public static function delete($id)
    {
        $conn = self::getConnection();
        $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $conn->close();
        return $stmt->affected_rows;
    }

    public static function verify($email, $password)
    {
        $user = self::findByEmail($email);
        if ($user) {
            // If password is hashed with password_hash()
            if (password_verify($password, $user['password'])) {
                return $user;
            }
            // Legacy support: if password is MD5, allow login and rehash
            if ($user['password'] === md5($password)) {
                // Rehash and update to secure hash
                self::updatePassword($user['id'], $password);
                // Refetch user to get new hash
                $user = self::findById($user['id']);
                return $user;
            }
        }
        return false;
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