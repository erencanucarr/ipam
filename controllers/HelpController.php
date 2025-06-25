<?php

require_once 'models/HelpDoc.php';

class HelpController
{
    public function index()
    {
        // Support users can view help docs, but not add/edit/delete
        $docs = HelpDoc::all();
        require 'views/help/index.php';
    }

    public function submit()
    {
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'support') {
            header('Location: index.php?page=help');
            exit;
        }
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $author = $_SESSION['user_name'] ?? 'Anonymous';
            if ($title && $content) {
                HelpDoc::create($title, $content, $author);
                header('Location: index.php?page=help');
                exit;
            } else {
                $error = "Title and content are required.";
            }
        }
        require 'views/help/submit.php';
    }
}