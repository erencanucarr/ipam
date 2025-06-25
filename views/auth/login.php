<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Simple IPAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #1976d2 0%, #6c63ff 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        .login-container {
            max-width: 420px;
            margin: 80px auto;
            background: #fff;
            padding: 2.5em 2em 2em 2em;
            border-radius: 22px;
            box-shadow: 0 8px 32px rgba(25, 118, 210, 0.18), 0 2px 8px rgba(108, 99, 255, 0.10);
            position: relative;
            overflow: hidden;
        }
        .login-container::before {
            content: "";
            position: absolute;
            top: -60px;
            right: -60px;
            width: 140px;
            height: 140px;
            background: linear-gradient(135deg, #6c63ff 60%, #1976d2 100%);
            border-radius: 50%;
            opacity: 0.18;
            z-index: 0;
        }
        .login-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 1.2em;
        }
        .login-logo svg {
            width: 56px;
            height: 56px;
            display: block;
        }
        h2 {
            text-align: center;
            color: #1a237e;
            margin-bottom: 1.2em;
            letter-spacing: 1px;
            font-size: 2em;
            font-weight: 700;
            z-index: 1;
            position: relative;
        }
        .form-group { margin-bottom: 1.2em; }
        label { display: block; margin-bottom: 0.5em; color: #1a237e; font-weight: 500; }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 0.7em;
            border: 1.5px solid #b0bec5;
            border-radius: 8px;
            font-size: 1em;
            background: #f8fafc;
            transition: border 0.2s, box-shadow 0.2s;
            box-shadow: 0 1px 4px rgba(25, 118, 210, 0.04);
        }
        input[type="email"]:focus, input[type="password"]:focus {
            border: 2px solid #1976d2;
            outline: none;
            box-shadow: 0 0 0 2px #1976d233;
        }
        .error {
            color: #b00;
            margin-bottom: 1em;
            text-align: center;
            font-weight: 500;
        }
        button {
            width: 100%;
            padding: 0.9em;
            background: linear-gradient(90deg, #1976d2 60%, #6c63ff 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1.15em;
            font-weight: 700;
            margin-top: 0.5em;
            box-shadow: 0 2px 8px rgba(25, 118, 210, 0.10);
            transition: background 0.2s, box-shadow 0.2s;
            letter-spacing: 0.5px;
        }
        button:hover {
            background: linear-gradient(90deg, #0d47a1 60%, #6c63ff 100%);
            box-shadow: 0 4px 16px rgba(25, 118, 210, 0.18);
        }
        .register-link {
            display: block;
            margin-top: 1.5em;
            text-align: center;
            color: #1976d2;
            text-decoration: none;
            font-weight: 500;
            font-size: 1.05em;
            transition: color 0.2s;
        }
        .register-link:hover {
            color: #0d47a1;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-logo">
            <!-- Creative SVG icon for IPAM -->
            <svg viewBox="0 0 64 64" fill="none">
                <circle cx="32" cy="32" r="30" fill="#1976d2" opacity="0.12"/>
                <rect x="18" y="18" width="28" height="28" rx="8" fill="#6c63ff"/>
                <rect x="24" y="24" width="16" height="16" rx="4" fill="#fff"/>
                <circle cx="32" cy="32" r="4" fill="#1976d2"/>
            </svg>
        </div>
        <h2>IPAM Admin Login</h2>
        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" action="index.php?page=login">
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>