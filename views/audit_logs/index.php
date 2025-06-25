<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Audit Log - Simple IPAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f0f4f8;
            margin: 0;
            padding: 0;
        }
        .filter-form {
            display: flex;
            gap: 1em;
            margin-bottom: 1.5em;
            align-items: flex-end;
            flex-wrap: wrap;
        }
        .filter-form label {
            font-weight: 600;
            color: #1a237e;
            margin-bottom: 0.2em;
            display: block;
        }
        .filter-form select, .filter-form input[type="date"] {
            padding: 0.4em 0.7em;
            border-radius: 6px;
            border: 1px solid #b6c6e6;
            font-size: 1em;
        }
        .filter-form button {
            background: linear-gradient(90deg, #1976d2 60%, #6c63ff 100%);
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 0.5em 1.2em;
            font-size: 1em;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }
        .filter-form button:hover {
            background: linear-gradient(90deg, #0d47a1 60%, #6c63ff 100%);
        }
        .action-badge {
            display: inline-block;
            padding: 0.25em 0.8em;
            border-radius: 12px;
            font-size: 0.98em;
            font-weight: 700;
            color: #fff;
        }
        .action-create { background: #43a047; }
        .action-update { background: #1976d2; }
        .action-delete { background: #e53935; }
        .action-login, .action-logout { background: #6c63ff; }
        .action-other { background: #757575; }
        .container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            padding: 2.5em 2em 2em 2em;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10), 0 1.5px 4px rgba(0,0,0,0.08);
        }
        h1 {
            text-align: center;
            color: #1a237e;
            margin-bottom: 1.5em;
            letter-spacing: 1px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #f8fafc;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }
        th, td {
            padding: 1em 0.7em;
            text-align: left;
        }
        th {
            background: #e3eafc;
            color: #1a237e;
            font-size: 1.05em;
            position: sticky;
            top: 0;
            z-index: 2;
        }
        tr:nth-child(even) {
            background: #f0f4f8;
        }
        tr:hover {
            background: #e3eafc;
            transition: background 0.2s;
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
    <?php
    require_once __DIR__ . '/../../models/User.php';
    $users = User::getAll();
    $actions = [
        'create' => 'Create',
        'update' => 'Update',
        'delete' => 'Delete',
        'login' => 'Login',
        'logout' => 'Logout'
    ];
    ?>
    <div class="container">
        <h1>Audit Log</h1>
        <form class="filter-form" method="get" action="index.php">
            <input type="hidden" name="page" value="audit_logs">
            <div>
                <label for="user_id">User</label>
                <select name="user_id" id="user_id">
                    <option value="">All</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user['id'] ?>" <?= (isset($filter_user_id) && $filter_user_id == $user['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($user['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="action">Action</label>
                <select name="action" id="action">
                    <option value="">All</option>
                    <?php foreach ($actions as $key => $label): ?>
                        <option value="<?= $key ?>" <?= (isset($filter_action) && $filter_action == $key) ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="date">Date</label>
                <input type="date" name="date" id="date" value="<?= isset($filter_date) ? htmlspecialchars($filter_date) : '' ?>">
            </div>
            <div>
                <button type="submit">Filter</button>
            </div>
        </form>
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Action</th>
                    <th>Target</th>
                    <th>Description</th>
                    <th>IP</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($logs)): ?>
                    <tr><td colspan="6">No audit log entries found.</td></tr>
                <?php else: foreach ($logs as $log): ?>
                    <tr>
                        <td><?= htmlspecialchars($log['user_name'] ?? 'System') ?></td>
                        <td>
                            <?php
                                $action = strtolower($log['action']);
                                $badgeClass = 'action-other';
                                if ($action === 'create') $badgeClass = 'action-create';
                                elseif ($action === 'update') $badgeClass = 'action-update';
                                elseif ($action === 'delete') $badgeClass = 'action-delete';
                                elseif ($action === 'login' || $action === 'logout') $badgeClass = 'action-login';
                            ?>
                            <span class="action-badge <?= $badgeClass ?>">
                                <?= ucfirst(htmlspecialchars($log['action'])) ?>
                            </span>
                        </td>
                        <td><?= ucfirst(htmlspecialchars($log['target_type'])) ?> #<?= $log['target_id'] ?></td>
                        <td><?= htmlspecialchars($log['description']) ?></td>
                        <td><?= htmlspecialchars($log['device_ip'] ?? '-') ?></td>
                        <td>
                            <?php if (isset($log['created_at'])): ?>
                                <?= date('d.m.Y H:i:s', strtotime($log['created_at'])) ?>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
        <a class="back-link" href="index.php?page=dashboard">Back to Dashboard</a>
    </div>
</body>
</html>