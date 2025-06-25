<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management - Simple IPAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #e3eafc 0%, #f0f4f8 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        .users-container {
            max-width: 700px;
            margin: 50px auto;
            background: #fff;
            padding: 2.5em 2em 2em 2em;
            border-radius: 22px;
            box-shadow: 0 8px 32px rgba(25, 118, 210, 0.13), 0 2px 8px rgba(108, 99, 255, 0.10);
            position: relative;
        }
        .users-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2em;
        }
        .users-title {
            font-size: 2em;
            font-weight: 700;
            color: #1a237e;
            letter-spacing: 1px;
        }
        .add-user-btn {
            background: linear-gradient(90deg, #1976d2 60%, #6c63ff 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.7em 1.5em;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(25, 118, 210, 0.10);
            transition: background 0.2s;
            text-decoration: none;
        }
        .add-user-btn:hover {
            background: linear-gradient(90deg, #0d47a1 60%, #6c63ff 100%);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5em;
        }
        th, td {
            padding: 1em 0.7em;
            text-align: left;
        }
        th {
            background: #e3eafc;
            color: #1a237e;
            font-weight: 700;
            font-size: 1.05em;
            border-bottom: 2px solid #b6c6e6;
        }
        tr {
            background: #fff;
            transition: background 0.2s;
        }
        tr:hover {
            background: #f0f4f8;
        }
        td {
            border-bottom: 1px solid #e3eafc;
            font-size: 1em;
        }
        .role-badge {
            display: inline-block;
            background: linear-gradient(90deg, #1976d2 60%, #6c63ff 100%);
            color: #fff;
            font-size: 0.95em;
            font-weight: 500;
            border-radius: 6px;
            padding: 0.2em 0.8em;
            letter-spacing: 0.5px;
        }
        .action-btn {
            background: #fff;
            color: #1976d2;
            border: 1px solid #1976d2;
            border-radius: 6px;
            padding: 0.4em 1em;
            font-size: 0.98em;
            font-weight: 600;
            cursor: pointer;
            margin-right: 0.5em;
            transition: background 0.2s, color 0.2s;
            text-decoration: none;
        }
        .action-btn.edit:hover {
            background: #1976d2;
            color: #fff;
        }
        .action-btn.delete {
            border-color: #e53935;
            color: #e53935;
        }
        .action-btn.delete:hover {
            background: #e53935;
            color: #fff;
        }
        .back-btn {
            display: inline-block;
            margin-top: 1em;
            color: #1976d2;
            text-decoration: none;
            font-weight: 600;
            font-size: 1em;
            transition: color 0.2s;
        }
        .back-btn:hover {
            color: #0d47a1;
        }
        @media (max-width: 600px) {
            .users-container {
                padding: 1em 0.3em;
            }
            th, td {
                padding: 0.7em 0.3em;
            }
        }
    </style>
</head>
<body>
    <div class="users-container">
        <div class="users-header">
            <div class="users-title">User Management</div>
            <a href="index.php?page=users&action=create" class="add-user-btn">+ Add User</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th style="text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><span class="role-badge"><?= htmlspecialchars($user['role']) ?></span></td>
                            <td style="text-align:center;">
                                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                                    <a href="index.php?page=users&action=edit&id=<?= urlencode($user['id']) ?>" class="action-btn edit">Edit</a>
                                    <a href="index.php?page=users&action=delete&id=<?= urlencode($user['id']) ?>" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                <?php elseif ($_SESSION['user_role'] === 'support'): ?>
                                    <a href="index.php?page=users&action=edit&id=<?= urlencode($user['id']) ?>" class="action-btn edit">Edit</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center; color:#888;">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="index.php" class="back-btn">&larr; Back to Dashboard</a>
    </div>
</body>
</html>