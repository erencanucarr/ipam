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
            flex-wrap: wrap;
            gap: 0.7em;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 1.5em;
        }
        .top-bar a,
        .top-bar button,
        .import-form label.custom-file-label {
            display: inline-block;
            background: #1976d2;
            color: #fff;
            padding: 0.7em 1.5em;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            font-size: 1em;
            box-shadow: 0 2px 8px rgba(25, 118, 210, 0.08);
            transition: background 0.2s;
            border: none;
            cursor: pointer;
            margin: 0;
            vertical-align: middle;
        }
        .top-bar a.export-json { background: #388e3c; }
        .top-bar a.export-xml { background: #1976d2; }
        .top-bar a.export-csv { background: #fbc02d; color: #333; }
        .top-bar a:hover,
        .top-bar button:hover,
        .import-form label.custom-file-label:hover {
            background: #0d47a1;
            color: #fff;
        }
        .top-bar a.export-json:hover { background: #256029; }
        .top-bar a.export-csv:hover { background: #f9a825; color: #222; }
        .import-form {
            display: flex;
            align-items: center;
            gap: 0.5em;
            margin-left: 0.5em;
        }
        .import-form input[type="file"] {
            display: none;
        }
        .import-form label.custom-file-label {
            background: #0288d1;
            color: #fff;
            border: none;
            padding: 0.7em 1.5em;
            border-radius: 6px;
            font-weight: 500;
            font-size: 1em;
            box-shadow: 0 2px 8px rgba(2, 136, 209, 0.08);
            transition: background 0.2s;
            cursor: pointer;
        }
        .import-form .file-name {
            margin-left: 0.5em;
            font-size: 0.98em;
            color: #333;
            background: #f0f4f8;
            border-radius: 4px;
            padding: 0.4em 0.8em;
            min-width: 120px;
            border: 1px solid #e0e0e0;
        }
        .import-form button {
            background: #1976d2;
            color: #fff;
            border: none;
            padding: 0.7em 1.5em;
            border-radius: 6px;
            font-weight: 500;
            font-size: 1em;
            box-shadow: 0 2px 8px rgba(2, 136, 209, 0.08);
            transition: background 0.2s;
            cursor: pointer;
        }
        .import-form button:hover {
            background: #01579b;
        }
        /* Responsive for small screens */
        @media (max-width: 600px) {
            .top-bar {
                flex-direction: column;
                align-items: stretch;
                gap: 0.5em;
            }
            .import-form {
                margin-left: 0;
                flex-direction: column;
                align-items: stretch;
            }
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
            <a href="index.php?page=subnets&action=export&format=json" class="export-json">Export JSON</a>
            <a href="index.php?page=subnets&action=export&format=xml" class="export-xml">Export XML</a>
            <a href="index.php?page=subnets&action=export&format=csv" class="export-csv">Export CSV</a>
            <form class="import-form" action="index.php?page=subnets&action=import" method="post" enctype="multipart/form-data">
                <input type="file" id="import_file" name="import_file" accept=".json,.xml,.csv" required style="display:none;">
                <label for="import_file" class="custom-file-label">Choose File</label>
                <span class="file-name" id="file-name">No file chosen</span>
                <button type="submit">Import</button>
            </form>
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
        <script>
        // Show selected file name
        document.querySelector('.import-form input[type="file"]').addEventListener('change', function() {
            document.getElementById('file-name').textContent = this.files[0] ? this.files[0].name : 'No file chosen';
        });
        </script>
        </body>
        </html>