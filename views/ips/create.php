<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add IP Address - <?= htmlspecialchars($subnet['name']) ?> - Simple IPAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .container { max-width: 500px; margin: 40px auto; background: #fff; padding: 2em; border-radius: 8px; box-shadow: 0 2px 8px #ccc; }
        h1 { text-align: center; }
        .form-group { margin-bottom: 1em; }
        label { display: block; margin-bottom: 0.5em; }
        input, textarea, select { width: 100%; padding: 0.5em; }
        button { width: 100%; padding: 0.7em; background: #007bff; color: #fff; border: none; border-radius: 4px; }
        button:hover { background: #0056b3; }
        a { display: block; margin-top: 1em; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add IP Address to <?= htmlspecialchars($subnet['name']) ?></h1>
        <form method="POST" action="index.php?page=ips&subnet_id=<?= $subnet['id'] ?>&action=create">
            <div class="form-group">
                <label for="address">IP Address</label>
                <input id="address" name="address" required placeholder="e.g. 192.168.1.10">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="assigned">Assigned</option>
                    <option value="free">Free</option>
                    <option value="reserved">Reserved</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description (optional)</label>
                <textarea id="description" name="description"></textarea>
            </div>
            <button type="submit">Add IP Address</button>
        </form>
        <a href="index.php?page=ips&subnet_id=<?= $subnet['id'] ?>">Back to IP Addresses</a>
    </div>
</body>
</html>