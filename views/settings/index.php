<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Settings - Simple IPAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f0f4f8; margin: 0; }
        .settings-container {
            max-width: 420px;
            margin: 60px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(25, 118, 210, 0.10);
            padding: 2.5em 2em;
        }
        h1 {
            color: #1976d2;
            font-size: 2em;
            margin-bottom: 0.5em;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 1.2em;
        }
        label {
            font-weight: 600;
            color: #1a237e;
            margin-bottom: 0.3em;
        }
        input[type="text"], input[type="password"] {
            padding: 0.7em;
            border-radius: 7px;
            border: 1px solid #b6c6e6;
            font-size: 1em;
            background: #f8fafc;
        }
        .btn {
            background: linear-gradient(90deg, #1976d2 60%, #6c63ff 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.9em 0;
            font-size: 1.1em;
            font-weight: 700;
            cursor: pointer;
            margin-top: 0.5em;
            transition: background 0.2s, box-shadow 0.2s;
        }
        .btn:hover {
            background: linear-gradient(90deg, #0d47a1 60%, #6c63ff 100%);
        }
        .msg-success {
            background: #eaffea;
            color: #388e3c;
            border-radius: 7px;
            padding: 0.7em 1em;
            margin-bottom: 1em;
            text-align: center;
            font-weight: 600;
        }
        .msg-error {
            background: #ffeaea;
            color: #e53935;
            border-radius: 7px;
            padding: 0.7em 1em;
            margin-bottom: 1em;
            text-align: center;
            font-weight: 600;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 1.2em;
            font-size: 1.08em;
            font-weight: 700;
            text-decoration: none;
            background: linear-gradient(90deg, #1976d2 60%, #6c63ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
            border: none;
            padding: 0;
        }
        .back-link:hover {
            opacity: 0.7;
        }
    </style>
</head>
<body>
    <div class="settings-container">
        <a href="index.php?page=dashboard" class="back-link">&larr; Back</a>
        <h1>Account Settings</h1>
        <?php if (!empty($message)): ?>
            <div class="msg-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="msg-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" autocomplete="off">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>

            <label for="email">Email</label>
            <input type="text" id="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>

            <label for="password">New Password <span style="font-weight:400;color:#888;">(leave blank to keep current)</span></label>
            <input type="password" id="password" name="password" autocomplete="new-password">

            <label for="password2">Repeat New Password</label>
            <input type="password" id="password2" name="password2" autocomplete="new-password">

            <button class="btn" type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>