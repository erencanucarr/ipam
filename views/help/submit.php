<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Help Article - Simple IPAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f0f4f8;
            margin: 0;
            padding: 0;
        }
        .help-container {
            max-width: 500px;
            margin: 50px auto;
            background: #fff;
            padding: 2.5em 2em 2em 2em;
            border-radius: 22px;
            box-shadow: 0 8px 32px rgba(25, 118, 210, 0.13), 0 2px 8px rgba(108, 99, 255, 0.10);
            position: relative;
        }
        h2 {
            text-align: center;
            color: #1a237e;
            margin-bottom: 1.5em;
            letter-spacing: 1px;
        }
        .form-group { margin-bottom: 1.2em; }
        label { display: block; margin-bottom: 0.5em; color: #1a237e; font-weight: 500; }
        input, textarea {
            width: 100%;
            padding: 0.7em;
            border: 1px solid #b0bec5;
            border-radius: 6px;
            font-size: 1em;
            background: #f8fafc;
            transition: border 0.2s;
        }
        input:focus, textarea:focus {
            border: 1.5px solid #1976d2;
            outline: none;
        }
        textarea {
            min-height: 120px;
            resize: vertical;
        }
        .error {
            color: #b00;
            margin-bottom: 1em;
            text-align: center;
            font-weight: 500;
        }
        button {
            width: 100%;
            padding: 0.9em;
            background: #1976d2;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 1.1em;
            font-weight: 600;
            margin-top: 0.5em;
            box-shadow: 0 2px 8px rgba(25, 118, 210, 0.08);
            transition: background 0.2s;
        }
        button:hover {
            background: #0d47a1;
        }
        .back-link {
            display: block;
            margin-top: 2em;
            text-align: center;
            color: #6c63ff;
            text-decoration: none;
            font-weight: 500;
            font-size: 1.1em;
            transition: color 0.2s;
        }
        .back-link:hover {
            color: #1a237e;
        }
    </style>
</head>
<body>
    <div class="help-container">
        <h2>Add Help Article</h2>
        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" action="index.php?page=help&action=submit">
            <div class="form-group">
                <label for="title">Title</label>
                <input id="title" type="text" name="title" required autofocus>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" name="content" required></textarea>
            </div>
            <button type="submit">Submit Article</button>
        </form>
        <a class="back-link" href="index.php?page=help">&larr; Back to Help Docs</a>
    </div>
</body>
</html>