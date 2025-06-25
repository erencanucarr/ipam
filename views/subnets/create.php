<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Subnet - Simple IPAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f0f4f8;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 60px auto;
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
        .form-group { margin-bottom: 1.2em; }
        label { display: block; margin-bottom: 0.5em; color: #1a237e; font-weight: 500; }
        input, textarea, select {
            width: 100%;
            padding: 0.7em;
            border: 1px solid #b0bec5;
            border-radius: 6px;
            font-size: 1em;
            background: #f8fafc;
            transition: border 0.2s;
        }
        input:focus, textarea:focus, select:focus {
            border: 1.5px solid #1976d2;
            outline: none;
        }
        .cidr-buttons {
            margin-bottom: 0.5em;
            text-align: center;
        }
        .cidr-buttons button {
            width: auto;
            display: inline-block;
            background: #1976d2;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 0.5em 1.2em;
            font-size: 1em;
            font-weight: 500;
            margin-right: 0.5em;
            margin-bottom: 0.2em;
            cursor: pointer;
            transition: background 0.2s;
        }
        .cidr-buttons button:hover {
            background: #0d47a1;
        }
        button[type="submit"] {
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
        button[type="submit"]:hover {
            background: #0d47a1;
        }
        a {
            display: block;
            margin-top: 1.5em;
            text-align: center;
            color: #6c63ff;
            text-decoration: none;
            font-weight: 500;
            font-size: 1.1em;
            transition: color 0.2s;
        }
        a:hover {
            color: #1a237e;
        }
    </style>
    <script>
        function setCIDR(val) {
            document.getElementById('cidr').value = val;
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Add Subnet</h1>
        <form method="POST" action="index.php?page=subnets&action=create">
            <div class="form-group">
                <label for="network">Network Address</label>
                <input id="network" name="network" required placeholder="e.g. 192.168.1.0">
            </div>
            <div class="form-group">
                <label for="cidr">CIDR</label>
                <div class="cidr-buttons">
                    <button type="button" onclick="setCIDR(24)">/24</button>
                    <button type="button" onclick="setCIDR(29)">/29</button>
                    <button type="button" onclick="setCIDR(25)">/25</button>
                </div>
                <select id="cidr" name="cidr" required style="width:100%;height:2.5em;">
                    <?php for ($i = 32; $i >= 8; $i--): ?>
                        <option value="<?= $i ?>" <?= $i == 24 ? 'selected' : '' ?>>/<?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Subnet Name</label>
                <input id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description (optional)</label>
                <textarea id="description" name="description"></textarea>
            </div>
            <button type="submit">Create and Generate IPs</button>
        </form>
        <a href="index.php?page=subnets">Back to Subnets</a>
    </div>
</body>
</html>