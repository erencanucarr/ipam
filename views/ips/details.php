<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IP Details - <?= htmlspecialchars($ip['address']) ?> - Simple IPAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f0f4f8;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 700px;
            margin: 40px auto;
            background: #fff;
            padding: 2.5em 2em 2em 2em;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10), 0 1.5px 4px rgba(0,0,0,0.08);
        }
        .section-title {
            background: #1976d2;
            color: #fff;
            padding: 0.7em 1em;
            font-weight: 700;
            border-radius: 6px 6px 0 0;
            font-size: 1.1em;
            letter-spacing: 1px;
        }
        .details-table, .history-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2em;
        }
        .details-table th, .details-table td,
        .history-table th, .history-table td {
            border: 1px solid #b0bec5;
            padding: 0.7em 1em;
            font-size: 1em;
        }
        .details-table th {
            background: #e3eafc;
            color: #1a237e;
            width: 180px;
            text-align: left;
        }
        .details-table td {
            background: #f8fafc;
        }
        .history-table th {
            background: #1976d2;
            color: #fff;
            font-weight: 600;
            text-align: left;
        }
        .history-table td {
            background: #f8fafc;
        }
        .actions {
            margin-top: 1.5em;
            display: flex;
            gap: 1.5em;
        }
        .actions a {
            background: #1976d2;
            color: #fff;
            padding: 0.7em 1.5em;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            font-size: 1em;
            box-shadow: 0 2px 8px rgba(25, 118, 210, 0.08);
            transition: background 0.2s;
        }
        .actions a:hover {
            background: #0d47a1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="section-title">ADDRESS MANAGEMENT</div>
        <table class="details-table">
            <tr>
                <th>IP</th>
                <td><?= htmlspecialchars($ip['address']) ?></td>
            </tr>
            <tr>
                <th>MASK</th>
                <td><?= htmlspecialchars($ip['mask']) ?></td>
            </tr>
            <tr>
                <th>DESCRIPTION</th>
                <td><?= htmlspecialchars($ip['description']) ?></td>
            </tr>
            <tr>
                <th>CLIENT</th>
                <td><?= htmlspecialchars($ip['client']) ?></td>
            </tr>
        </table>
        <div class="actions">
            <a href="index.php?page=ips&subnet_id=<?= $subnet['id'] ?>">GO BACK</a>
            <a href="index.php?page=ips&subnet_id=<?= $subnet['id'] ?>&action=edit&id=<?= $ip['id'] ?>">EDIT</a>
        </div>
        <div class="section-title" style="margin-top:2em;">UPDATE HISTORY</div>
        <table class="history-table">
            <thead>
                <tr>
                    <th>USERNAME</th>
                    <th>MODIFICATION TIME/DATE</th>
                    <th>HOST ADDRESS</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($history)): ?>
                    <tr><td colspan="3">No update history found.</td></tr>
                <?php else: foreach ($history as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['user_name']) ?></td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                        <td><?= htmlspecialchars($row['device_ip']) ?></td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>