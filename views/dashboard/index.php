<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Simple IPAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #e3eafc 0%, #f0f4f8 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        .dashboard-outer {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding: 40px 0;
        }
        .dashboard-container {
            display: flex;
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 8px 32px rgba(25, 118, 210, 0.13), 0 2px 8px rgba(108, 99, 255, 0.10);
            overflow: hidden;
            min-width: 850px;
            max-width: 1100px;
            width: 100%;
        }
        .sidebar {
            background: linear-gradient(135deg, #1976d2 60%, #6c63ff 100%);
            color: #fff;
            width: 260px;
            min-height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2.5em 1.2em 2em 1.2em;
            box-sizing: border-box;
        }
        .sidebar .avatar {
            width: 70px;
            height: 70px;
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2em;
            color: #1976d2;
            font-weight: 700;
            margin-bottom: 1.2em;
            box-shadow: 0 2px 8px rgba(25, 118, 210, 0.10);
        }
        .sidebar .user-name {
            font-size: 1.25em;
            font-weight: 700;
            margin-bottom: 0.3em;
            text-align: center;
        }
        .sidebar .role-badge {
            display: inline-block;
            background: #fff;
            color: #1976d2;
            font-size: 1em;
            font-weight: 600;
            border-radius: 6px;
            padding: 0.2em 0.9em;
            margin-bottom: 0.7em;
            letter-spacing: 0.5px;
            text-align: center;
        }
        .sidebar .meta-info {
            margin-bottom: 1.5em;
            text-align: center;
        }
        .sidebar .meta-info .meta-label {
            font-size: 0.98em;
            color: #e3eafc;
            margin-bottom: 0.2em;
            display: block;
        }
        .sidebar .meta-info .meta-value {
            font-size: 1.05em;
            color: #fff;
            font-weight: 500;
            margin-bottom: 0.3em;
        }
        .sidebar-section {
            width: 100%;
            background: rgba(255,255,255,0.08);
            border-radius: 10px;
            margin-bottom: 1.2em;
            padding: 1em 0.7em 0.7em 0.7em;
            box-sizing: border-box;
        }
        .sidebar-section h4 {
            margin: 0 0 0.5em 0;
            font-size: 1.08em;
            font-weight: 700;
            color: #e3eafc;
            letter-spacing: 0.5px;
        }
        .sidebar-links {
            display: flex;
            flex-direction: column;
            gap: 0.5em;
        }
        .sidebar-link {
            color: #fff;
            text-decoration: none;
            font-size: 1em;
            font-weight: 500;
            padding: 0.3em 0.7em;
            border-radius: 6px;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5em;
        }
        .sidebar-link:hover {
            background: rgba(255,255,255,0.18);
        }
        .sidebar-link svg {
            width: 18px;
            height: 18px;
            vertical-align: middle;
        }
        .sidebar-info-list {
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 0.98em;
        }
        .sidebar-info-list li {
            margin-bottom: 0.3em;
            color: #e3eafc;
            display: flex;
            align-items: center;
            gap: 0.5em;
        }
        .sidebar-info-list svg {
            width: 16px;
            height: 16px;
            vertical-align: middle;
        }
        .sidebar .logout-btn {
            margin-top: auto;
            background: #e53935;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.7em 1.5em;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(229, 57, 53, 0.10);
            transition: background 0.2s;
            width: 100%;
        }
        .sidebar .logout-btn:hover {
            background: #b71c1c;
        }
        .main-content {
            flex: 1;
            padding: 2.5em 2.5em 2em 2.5em;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        .dashboard-title {
            font-size: 2.2em;
            font-weight: 700;
            color: #1a237e;
            margin-bottom: 0.2em;
            letter-spacing: 1px;
        }
        .dashboard-desc {
            color: #444;
            font-size: 1.13em;
            margin-bottom: 2em;
        }
        .dashboard-actions {
            display: flex;
            gap: 1.2em;
            margin-bottom: 2.2em;
        }
        .dashboard-actions a {
            flex: 1 1 0;
            background: linear-gradient(90deg, #1976d2 60%, #6c63ff 100%);
            color: #fff;
            padding: 0.6em 0;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1em;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            box-shadow: 0 2px 8px rgba(25, 118, 210, 0.08);
            transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
            letter-spacing: 0.5px;
        }
        .dashboard-actions a:hover {
            background: linear-gradient(90deg, #0d47a1 60%, #6c63ff 100%);
            box-shadow: 0 4px 16px rgba(25, 118, 210, 0.18);
            transform: translateY(-2px) scale(1.03);
        }
        .dashboard-stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(2, 1fr);
            gap: 1.5em;
            width: 100%;
            margin-bottom: 1.5em;
        }
        .stat-box {
            background: #e3eafc;
            border-radius: 14px;
            padding: 1.5em 1.1em 1.2em 1.1em;
            text-align: center;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(25, 118, 210, 0.07);
            transition: box-shadow 0.2s, transform 0.2s;
            position: relative;
        }
        .stat-box:hover {
            box-shadow: 0 6px 24px rgba(25, 118, 210, 0.16);
            transform: translateY(-2px) scale(1.04);
            z-index: 2;
        }
        .stat-icon {
            margin-bottom: 0.5em;
            font-size: 2em;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .stat-box.users { background: #e3eafc; }
        .stat-box.subnets { background: #e3eafc; }
        .stat-box.ips { background: #e3eafc; }
        .stat-box.free { background: #eaffea; }
        .stat-box.assigned { background: #ffeaea; }
        .stat-box.reserved { background: #f4f4f4; }
        .stat-value {
            font-size: 2.1em;
            font-weight: 700;
            color: #1976d2;
        }
        .stat-box.free .stat-value { color: #388e3c; }
        .stat-box.assigned .stat-value { color: #e53935; }
        .stat-box.reserved .stat-value { color: #757575; }
        .stat-label {
            color: #1a237e;
            font-weight: 700;
            margin-top: 0.2em;
            font-size: 1.08em;
            letter-spacing: 0.5px;
            text-shadow: 0 1px 2px #fff, 0 0 2px #e3eafc;
        }
        .stat-box.free .stat-label { color: #388e3c; text-shadow: 0 1px 2px #fff, 0 0 2px #eaffea; }
        .stat-box.assigned .stat-label { color: #e53935; text-shadow: 0 1px 2px #fff, 0 0 2px #ffeaea; }
        .stat-box.reserved .stat-label { color: #757575; text-shadow: 0 1px 2px #fff, 0 0 2px #f4f4f4; }
        @media (max-width: 1100px) {
            .dashboard-container { min-width: 0; flex-direction: column; }
            .sidebar { width: 100%; flex-direction: row; justify-content: flex-start; align-items: center; padding: 1.5em 1em; }
            .sidebar .logout-btn { width: auto; margin-left: auto; }
            .main-content { padding: 1.5em 1em; }
        }
        @media (max-width: 800px) {
            .dashboard-outer { padding: 10px 0; }
            .dashboard-container { min-width: 0; flex-direction: column; }
            .sidebar { width: 100%; flex-direction: row; justify-content: flex-start; align-items: center; padding: 1em 0.5em; }
            .sidebar .logout-btn { width: auto; margin-left: auto; }
            .main-content { padding: 1em 0.5em; }
            .dashboard-stats-grid { grid-template-columns: 1fr; grid-template-rows: repeat(6, 1fr); }
        }
    </style>
</head>
<?php
// Fetch latest Help Docs (show 1-2 articles)
require_once __DIR__ . '/../../models/HelpDoc.php';
$dashboard_help_docs = array_slice(HelpDoc::all(), 0, 2);
?>
<body>
    <div class="dashboard-outer">
        <div class="dashboard-container">
            <div class="sidebar">
                <div class="avatar">
                    <?= strtoupper(substr($_SESSION['user_name'] ?? 'A', 0, 1)) ?>
                </div>
                <div class="user-name"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?></div>
                <div class="role-badge"><?= htmlspecialchars($_SESSION['user_role'] ?? 'admin') ?></div>
                <div class="meta-info">
                    <span class="meta-label">Date & Time</span>
                    <span class="meta-value"><?= date('d.m.Y H:i') ?></span>
                    <span class="meta-label">Login IP</span>
                    <span class="meta-value"><?= $_SERVER['REMOTE_ADDR'] ?? 'N/A' ?></span>
                </div>
                <div class="sidebar-section">
                    <h4>Quick Links</h4>
                    <div class="sidebar-links">
                        <a class="sidebar-link" href="index.php?page=settings">
                            <svg fill="none" viewBox="0 0 20 20"><path d="M11.3 1.046a1 1 0 00-2.6 0l-.25.832a1 1 0 01-.95.69H5.5a1 1 0 00-.98 1.197l.16.832a1 1 0 01-.287.95l-.66.66a1 1 0 000 1.414l.66.66a1 1 0 01.287.95l-.16.832A1 1 0 005.5 11.432h1.999a1 1 0 01.95.69l.25.832a1 1 0 002.6 0l.25-.832a1 1 0 01.95-.69H14.5a1 1 0 00.98-1.197l-.16-.832a1 1 0 01.287-.95l.66-.66a1 1 0 000-1.414l-.66-.66a1 1 0 01-.287-.95l.16-.832A1 1 0 0014.5 3.568h-1.999a1 1 0 01-.95-.69l-.25-.832z" fill="#e3eafc"/></svg>
                            Settings
                        </a>
                        <?php if ($_SESSION['user_role'] !== 'support'): ?>
                        <a class="sidebar-link" href="index.php?page=help">
                            <svg fill="none" viewBox="0 0 20 20"><path d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zm-8 4a1 1 0 100-2 1 1 0 000 2zm1-7a1 1 0 00-2 0c0 1 2 1.5 2 3h-2" stroke="#e3eafc" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Help & Docs
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="sidebar-section">
                    <h4>System Info</h4>
                    <ul class="sidebar-info-list">
                        <li>
                            <svg fill="none" viewBox="0 0 20 20"><rect x="2" y="4" width="16" height="12" rx="2" fill="#e3eafc"/></svg>
                            PHP <?= phpversion() ?>
                        </li>
                        <li>
                            <svg fill="none" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8" fill="#e3eafc"/></svg>
                            Server: <?= $_SERVER['SERVER_NAME'] ?? 'N/A' ?>
                        </li>
                        <li>
                            <svg fill="none" viewBox="0 0 20 20"><rect x="4" y="8" width="12" height="4" rx="2" fill="#e3eafc"/></svg>
                            App v1.0
                        </li>
                    </ul>
                </div>
                <div class="sidebar-section">
                    <h4>Dev Info</h4>
                    <div style="margin-bottom:0.7em;">
                        <span style="display:flex;align-items:center;gap:0.5em;">
                            <!-- User/Dev Icon -->
                            <svg width="18" height="18" fill="none" viewBox="0 0 20 20"><circle cx="10" cy="7" r="4" fill="#e3eafc"/><path d="M2 18a8 8 0 1116 0H2z" fill="#e3eafc"/></svg>
                            <span style="font-weight:600;">Eren Can Uçar</span>
                        </span>
                        <span style="display:flex;align-items:center;gap:0.5em;margin-top:0.2em;">
                            <!-- Mail Icon -->
                            <svg width="18" height="18" fill="none" viewBox="0 0 20 20"><rect x="2" y="4" width="16" height="12" rx="3" fill="#e3eafc"/><path d="M4 6l6 5 6-5" stroke="#1976d2" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <span style="font-size:0.98em;">dev@eren.gg</span>
                        </span>
                    </div>
                    <div style="display:flex;gap:1em;align-items:center;">
                        <a href="https://www.linkedin.com/in/erencanucarr/" target="_blank" title="LinkedIn" style="display:flex;align-items:center;">
                            <!-- LinkedIn SVG -->
                            <svg width="22" height="22" fill="none" viewBox="0 0 24 24"><rect width="24" height="24" rx="5" fill="#e3eafc"/><path d="M7.75 8.5a1.25 1.25 0 11-2.5 0 1.25 1.25 0 012.5 0zM6.5 10.25h2.5v7.25h-2.5V10.25zM11.25 10.25h2.4v1.02h.03c.33-.62 1.13-1.27 2.32-1.27 2.48 0 2.94 1.63 2.94 3.75v4.25h-2.5v-3.77c0-.9-.02-2.06-1.25-2.06-1.25 0-1.44.98-1.44 1.99v3.84h-2.5v-7.25z" fill="#1976d2"/></svg>
                        </a>
                        <a href="https://github.com/erencanucarr" target="_blank" title="GitHub" style="display:flex;align-items:center;">
                            <!-- GitHub SVG -->
                            <svg width="22" height="22" fill="none" viewBox="0 0 24 24"><rect width="24" height="24" rx="5" fill="#e3eafc"/><path d="M12 2C6.48 2 2 6.58 2 12.26c0 4.48 2.87 8.28 6.84 9.63.5.09.68-.22.68-.48 0-.24-.01-.87-.01-1.7-2.78.62-3.37-1.36-3.37-1.36-.45-1.18-1.1-1.5-1.1-1.5-.9-.63.07-.62.07-.62 1 .07 1.53 1.05 1.53 1.05.89 1.56 2.34 1.11 2.91.85.09-.66.35-1.11.63-1.37-2.22-.26-4.56-1.14-4.56-5.07 0-1.12.38-2.03 1-2.75-.1-.26-.44-1.3.1-2.7 0 0 .83-.27 2.75 1.02A9.36 9.36 0 0112 6.84c.84.004 1.68.11 2.47.32 1.92-1.29 2.75-1.02 2.75-1.02.54 1.4.2 2.44.1 2.7.62.72 1 1.63 1 2.75 0 3.94-2.34 4.81-4.57 5.07.36.32.68.94.68 1.9 0 1.37-.01 2.47-.01 2.81 0 .27.18.58.69.48C19.13 20.54 22 16.74 22 12.26 22 6.58 17.52 2 12 2z" fill="#1976d2"/></svg>
                        </a>
                    </div>
                </div>
                <form method="post" action="index.php?page=logout" style="width:100%;">
<?php if (!empty($_SESSION['flash_success'])): ?>
    <div style="background:#eaffea;color:#388e3c;border:1.5px solid #388e3c;padding:1em 1.2em;border-radius:8px;font-weight:600;margin-bottom:1.2em;">
        <?= htmlspecialchars($_SESSION['flash_success']) ?>
    </div>
    <?php unset($_SESSION['flash_success']); ?>
<?php endif; ?>
<?php if (!empty($_SESSION['flash_error'])): ?>
    <div style="background:#ffeaea;color:#e53935;border:1.5px solid #e53935;padding:1em 1.2em;border-radius:8px;font-weight:600;margin-bottom:1.2em;">
        <?= htmlspecialchars($_SESSION['flash_error']) ?>
    </div>
    <?php unset($_SESSION['flash_error']); ?>
<?php endif; ?>
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
            <div class="main-content">
                <div class="dashboard-title">IPAM Admin Dashboard</div>
                <div class="dashboard-desc">
                    Welcome to your dashboard. Manage subnets, IP addresses, users, and view audit logs with ease.
                </div>
                <div class="dashboard-actions">
                    <?php if ($_SESSION['user_role'] !== 'support'): ?>
                    <a href="index.php?page=users">User Management</a>
                    <a href="index.php?page=subnets">Subnets</a>
                    <a href="index.php?page=audit_logs">Audit Log</a>
                    <a href="index.php?page=ipreport">IP Usage & Conflict Report</a>
                    <?php endif; ?>
                </div>
                <hr style="border: none; border-top: 2px solid #e3eafc; margin: 0 0 2em 0;">
                <div class="dashboard-stats-grid">
                    <div class="stat-box users">
                        <div class="stat-icon">
                            <!-- User SVG (person) -->
                            <svg width="32" height="32" fill="none" viewBox="0 0 32 32">
                                <circle cx="16" cy="12" r="6" fill="#1976d2"/>
                                <path d="M6 26c0-3.3137 4.477-6 10-6s10 2.6863 10 6v2H6v-2z" fill="#b6c6e6"/>
                            </svg>
                        </div>
                        <div class="stat-value"><?= $user_count ?? 0 ?></div>
                        <div class="stat-label">Users</div>
                    </div>
                    <div class="stat-box subnets">
                        <div class="stat-icon">
                            <!-- Subnet SVG (network/branch) -->
                            <svg width="32" height="32" fill="none" viewBox="0 0 32 32">
                                <circle cx="8" cy="24" r="4" fill="#1976d2"/>
                                <circle cx="24" cy="24" r="4" fill="#1976d2"/>
                                <circle cx="16" cy="8" r="4" fill="#1976d2"/>
                                <path d="M16 12v4M16 16l-4 4M16 16l4 4" stroke="#1976d2" stroke-width="2"/>
                            </svg>
                        </div>
                        <div class="stat-value"><?= $subnet_count ?? 0 ?></div>
                        <div class="stat-label">Subnets</div>
                    </div>
                    <div class="stat-box ips">
                        <div class="stat-icon">
                            <!-- IP SVG (globe) -->
                            <svg width="32" height="32" fill="none" viewBox="0 0 32 32">
                                <circle cx="16" cy="16" r="12" fill="#6c63ff" opacity="0.18"/>
                                <ellipse cx="16" cy="16" rx="8" ry="12" stroke="#6c63ff" stroke-width="2"/>
                                <ellipse cx="16" cy="16" rx="12" ry="8" stroke="#6c63ff" stroke-width="2"/>
                                <circle cx="16" cy="16" r="2" fill="#6c63ff"/>
                            </svg>
                        </div>
                        <div class="stat-value"><?= $ip_count ?? 0 ?></div>
                        <div class="stat-label">Total IPs</div>
                    </div>
                    <div class="stat-box free">
                        <div class="stat-icon">
                            <!-- Free SVG (checkmark) -->
                            <svg width="32" height="32" fill="none" viewBox="0 0 32 32">
                                <circle cx="16" cy="16" r="12" fill="#388e3c" opacity="0.13"/>
                                <path d="M10 17l4 4 8-8" stroke="#388e3c" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="stat-value"><?= $free_count ?? 0 ?></div>
                        <div class="stat-label">Free</div>
                    </div>
                    <div class="stat-box assigned">
                        <div class="stat-icon">
                            <!-- Assigned SVG (plug) -->
                            <svg width="32" height="32" fill="none" viewBox="0 0 32 32">
                                <rect x="10" y="18" width="12" height="6" rx="3" fill="#e53935" opacity="0.13"/>
                                <rect x="14" y="8" width="4" height="10" rx="2" fill="#e53935"/>
                                <rect x="12" y="6" width="2" height="4" rx="1" fill="#e53935"/>
                                <rect x="18" y="6" width="2" height="4" rx="1" fill="#e53935"/>
                            </svg>
                        </div>
                        <div class="stat-value"><?= $assigned_count ?? 0 ?></div>
                        <div class="stat-label">Assigned</div>
                    </div>
                    <div class="stat-box reserved">
                        <div class="stat-icon">
                            <!-- Reserved SVG (lock) -->
                            <svg width="32" height="32" fill="none" viewBox="0 0 32 32">
                                <rect x="8" y="16" width="16" height="10" rx="4" fill="#757575" opacity="0.13"/>
                                <rect x="12" y="20" width="8" height="4" rx="2" fill="#757575"/>
                                <rect x="12" y="12" width="8" height="6" rx="4" fill="#757575"/>
                            </svg>
                        </div>
                        <div class="stat-value"><?= $reserved_count ?? 0 ?></div>
                        <div class="stat-label">Reserved</div>
                    </div>
                </div>
                <!-- Help & Docs section below stats grid -->
                <div style="margin: 2.5em 0 0.5em 0;">
                    <hr style="border: none; border-top: 2px solid #e3eafc; margin-bottom: 1.5em;">
                    <div style="font-size:1.18em;font-weight:700;color:#1976d2;margin-bottom:0.7em;">Help & Docs</div>
                    <?php if (!empty($dashboard_help_docs)): ?>
                        <?php foreach ($dashboard_help_docs as $doc): ?>
                            <div style="background:#f8fafc;border-radius:12px;padding:1.2em 1em;margin-bottom:1.2em;box-shadow:0 2px 8px rgba(25,118,210,0.06);">
                                <div style="font-size:1.1em;font-weight:700;color:#1976d2;margin-bottom:0.2em;"><?= $doc['title'] ?></div>
                                <div style="font-size:0.98em;color:#888;margin-bottom:0.5em;">
                                    By <?= $doc['author'] ?> &middot; <?= $doc['created_at'] ?>
                                </div>
                                <div style="color:#222;font-size:1.05em;"><?= $doc['content'] ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="color:#888;">No help articles yet. Add one from the Help & Docs page.</div>
                    <?php endif; ?>
                    <div style="text-align:right;">
                        <a href="index.php?page=help" style="color:#1976d2;font-weight:600;text-decoration:underline;">See all Help Docs &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>