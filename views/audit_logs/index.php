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
    <div class="container">
        <h1>Audit Log</h1>
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
                        <td><?= ucfirst(htmlspecialchars($log['action'])) ?></td>
                        <td><?= ucfirst(htmlspecialchars($log['target_type'])) ?> #<?= $log['target_id'] ?></td>
                        <td><?= htmlspecialchars($log['description']) ?></td>
                        <td><?= htmlspecialchars($log['device_ip'] ?? '-') ?></td>
                        <td><?= isset($log['created_at']) ? date('H:i:s', strtotime($log['created_at'])) : '-' ?></td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
        <a class="back-link" href="index.php?page=dashboard">Back to Dashboard</a>
    </div>
</body>
</html>