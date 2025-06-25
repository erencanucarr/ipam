<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subnets - Simple IPAM</title>
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
        .top-bar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 1em;
        }
        .top-bar a {
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
        .top-bar a:hover {
            background: #0d47a1;
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
        .actions a {
            margin-right: 0.7em;
            color: #1976d2;
            text-decoration: none;
            font-weight: 500;
            border-bottom: 1px solid transparent;
            transition: color 0.2s, border-bottom 0.2s;
        }
        .actions a:hover {
            color: #0d47a1;
            border-bottom: 1px solid #1976d2;
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
        <h1>Subnets</h1>
        <div class="top-bar">
            <a href="index.php?page=subnets&action=create">Add Subnet</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Network</th>
                    <th>CIDR</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($subnets)): ?>
                    <tr><td colspan="5">No subnets found.</td></tr>
                <?php else: foreach ($subnets as $subnet): ?>
                    <tr>
                        <td><?= htmlspecialchars($subnet['name']) ?></td>
                        <td><?= htmlspecialchars($subnet['network']) ?></td>
                        <td><?= htmlspecialchars($subnet['cidr']) ?></td>
                        <td><?= htmlspecialchars($subnet['description']) ?></td>
                        <td class="actions">
                            <a href="index.php?page=ips&subnet_id=<?= $subnet['id'] ?>">Details</a>
                            <a href="index.php?page=subnets&action=edit&id=<?= $subnet['id'] ?>">Edit</a>
                            <a href="index.php?page=subnets&action=delete&id=<?= $subnet['id'] ?>" onclick="return confirm('Delete this subnet?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
        <a class="back-link" href="index.php?page=dashboard">Back to Dashboard</a>
    </div>
</body>
</html>