<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create User - Simple IPAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f0f4f8;
            margin: 0;
            padding: 0;
        }
        .register-container {
            max-width: 420px;
            margin: 80px auto;
            background: #fff;
            padding: 2.5em 2em 2em 2em;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10), 0 1.5px 4px rgba(0,0,0,0.08);
        }
        h2 {
            text-align: center;
            color: #1a237e;
            margin-bottom: 1.5em;
            letter-spacing: 1px;
        }
        .form-group { margin-bottom: 1.2em; }
        label { display: block; margin-bottom: 0.5em; color: #1a237e; font-weight: 500; }
        input, select {
            width: 100%;
            padding: 0.7em;
            border: 1px solid #b0bec5;
            border-radius: 6px;
            font-size: 1em;
            background: #f8fafc;
            transition: border 0.2s;
        }
        input:focus, select:focus {
            border: 1.5px solid #1976d2;
            outline: none;
        }
        .error {
            color: #b00;
            margin-bottom: 1em;
            text-align: center;
            font-weight: 500;
        }
        .success {
            color: #388e3c;
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
    <div class="register-container">
        <h2>Create User</h2>
        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <form method="post" action="index.php?page=register">
            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" type="text" name="name" required autofocus>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="user">User (View Only)</option>
                    <option value="admin">Admin (Full Access)</option>
                </select>
            </div>
            <button type="submit">Create User</button>
        </form>
        <a class="back-link" href="index.php?page=dashboard">Back to Dashboard</a>
    </div>
</body>
</html>