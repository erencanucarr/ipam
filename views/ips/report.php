<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IP Usage & Conflict Report - Simple IPAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f0f4f8; margin: 0; padding: 0; }
        .container { max-width: 1100px; margin: 40px auto; background: #fff; padding: 2.5em 2em 2em 2em; border-radius: 20px; box-shadow: 0 4px 24px rgba(0,0,0,0.10), 0 1.5px 4px rgba(0,0,0,0.08);}
        h1 { text-align: center; color: #1a237e; margin-bottom: 1.5em; letter-spacing: 1px;}
        h2 { color: #1976d2; margin-top: 2em; margin-bottom: 0.7em;}
        table { width: 100%; border-collapse: collapse; background: #f8fafc; border-radius: 10px; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.04);}
        th, td { padding: 0.8em 0.7em; text-align: left; }
        th { background: #e3eafc; color: #1a237e; font-size: 1.05em; }
        tr:nth-child(even) { background: #f0f4f8; }
        tr:hover { background: #e3eafc; transition: background 0.2s; }
        .back-link { display: block; margin-top: 2em; text-align: center; color: #6c63ff; text-decoration: none; font-weight: 500; font-size: 1.1em; transition: color 0.2s;}
        .back-link:hover { color: #1a237e; }
        .section { margin-bottom: 2.5em; }
        .badge { display: inline-block; padding: 0.2em 0.7em; border-radius: 6px; font-size: 0.95em; font-weight: 600;}
        .badge.used { background: #388e3c; color: #fff; }
        .badge.free { background: #b0bec5; color: #222; }
        .badge.conflict { background: #e53935; color: #fff; }
    </style>
</head>
<body>
    <div class="container">
        <h1>IP Usage & Conflict Report</h1>

        <div class="section">
            <h2>IP Conflicts (Duplicate IPs)</h2>
            <?php if (empty($conflicts)): ?>
                <p style="color:#388e3c;">No duplicate IP addresses found.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>IP Address</th>
                            <th>Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($conflicts as $row): ?>
                            <tr>
                                <td><span class="badge conflict"><?= htmlspecialchars($row['address']) ?></span></td>
                                <td><?= $row['count'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <div class="section">
            <h2>Subnet Utilization</h2>
            <table>
                <thead>
                    <tr>
                        <th>Subnet Name</th>
                        <th>Network</th>
                        <th>CIDR</th>
                        <th>Total IPs</th>
                        <th>Used</th>
                        <th>Free</th>
                        <th>Usage (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($utilization as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['subnet']['name']) ?></td>
                            <td><?= htmlspecialchars($row['subnet']['network']) ?></td>
                            <td><?= htmlspecialchars($row['subnet']['cidr']) ?></td>
                            <td><?= $row['total'] ?></td>
                            <td><span class="badge used"><?= $row['used'] ?></span></td>
                            <td><span class="badge free"><?= $row['free'] ?></span></td>
                            <td><?= $row['percent_used'] ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="section">
            <h2>Unused IP Addresses</h2>
            <?php if (empty($unused_ips)): ?>
                <p style="color:#388e3c;">No unused (free) IP addresses found.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Subnet ID</th>
                            <th>IP Address</th>
                            <th>Description</th>
                            <th>Client</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($unused_ips as $ip): ?>
                            <tr>
                                <td><?= htmlspecialchars($ip['subnet_id']) ?></td>
                                <td><?= htmlspecialchars($ip['address']) ?></td>
                                <td><?= htmlspecialchars($ip['description']) ?></td>
                                <td><?= htmlspecialchars($ip['client']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <a class="back-link" href="index.php?page=dashboard">&larr; Back to Dashboard</a>
    </div>
</body>
</html>