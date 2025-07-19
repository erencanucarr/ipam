<?php

class HelpDoc
{
    // Assumes $mysqli is available globally from config.php
    public static function all()
    {
        if (defined('MOCK_MODE') && MOCK_MODE) {
            global $mock_data;
            $docs = [];
            foreach ($mock_data['help_docs'] as $doc) {
                $docs[] = [
                    'id' => $doc['id'],
                    'title' => htmlspecialchars($doc['title']),
                    'content' => nl2br(htmlspecialchars($doc['content'])),
                    'author' => htmlspecialchars($doc['author']),
                    'created_at' => date('d.m.Y H:i', strtotime($doc['created_at']))
                ];
            }
            return $docs;
        }
        
        $conn = self::getConnection();
        $stmt = $conn->prepare("SELECT * FROM help_docs ORDER BY created_at DESC, id DESC");
        $stmt->execute();
        $stmt->store_result();
        $meta = $stmt->result_metadata();
        $docs = [];
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
                    $docs[] = [
                        'id' => $row['id'],
                        'title' => htmlspecialchars($row['title']),
                        'content' => nl2br(htmlspecialchars($row['content'])),
                        'author' => htmlspecialchars($row['author']),
                        'created_at' => date('d.m.Y H:i', strtotime($row['created_at']))
                    ];
                }
            }
        }
        $stmt->close();
        $conn->close();
        return $docs;
    }

    public static function create($title, $content, $author)
    {
        if (defined('MOCK_MODE') && MOCK_MODE) {
            global $mock_data;
            $newId = count($mock_data['help_docs']) + 1;
            $newDoc = [
                'id' => $newId,
                'title' => $title,
                'content' => $content,
                'author' => $author,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $mock_data['help_docs'][] = $newDoc;
            return $newId;
        }
        
        $conn = self::getConnection();
        $stmt = $conn->prepare("INSERT INTO help_docs (title, content, author, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $title, $content, $author);
        $stmt->execute();
        $stmt->close();
        $conn->close();
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