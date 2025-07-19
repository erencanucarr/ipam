<?php
$page_title = 'Dashboard - IPAM System';
$current_page = 'dashboard';

// Fetch latest Help Docs (show 1-2 articles)
require_once __DIR__ . '/../../models/HelpDoc.php';
$dashboard_help_docs = array_slice(HelpDoc::all(), 0, 2);

ob_start();
?>

<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <p class="page-description">Welcome to your IPAM System dashboard. Manage your network infrastructure efficiently.</p>
</div>

<!-- Quick Actions -->
<div class="page-actions">
    <?php if ($_SESSION['user_role'] !== 'support'): ?>
        <a href="index.php?page=users" class="btn btn-primary">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
            </svg>
            User Management
        </a>
        <a href="index.php?page=subnets" class="btn btn-primary">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            Manage Subnets
        </a>
        <a href="index.php?page=audit_logs" class="btn btn-primary">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Audit Logs
        </a>
        <a href="index.php?page=ipreport" class="btn btn-primary">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            IP Reports
        </a>
    <?php endif; ?>
</div>

<!-- Statistics Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mb-8">
    <div class="card">
        <div class="card-body text-center">
            <div class="mb-4">
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-primary-color mx-auto">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
            </div>
            <div class="text-3xl font-bold text-gray-900 mb-2"><?= $user_count ?? 0 ?></div>
            <div class="text-gray-600 font-medium">Total Users</div>
        </div>
    </div>

    <div class="card">
        <div class="card-body text-center">
            <div class="mb-4">
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-primary-color mx-auto">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div class="text-3xl font-bold text-gray-900 mb-2"><?= $subnet_count ?? 0 ?></div>
            <div class="text-gray-600 font-medium">Active Subnets</div>
        </div>
    </div>

    <div class="card">
        <div class="card-body text-center">
            <div class="mb-4">
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-primary-color mx-auto">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="text-3xl font-bold text-gray-900 mb-2"><?= $ip_count ?? 0 ?></div>
            <div class="text-gray-600 font-medium">Total IP Addresses</div>
        </div>
    </div>

    <div class="card">
        <div class="card-body text-center">
            <div class="mb-4">
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-success-color mx-auto">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="text-3xl font-bold text-success-color mb-2"><?= $free_count ?? 0 ?></div>
            <div class="text-gray-600 font-medium">Available IPs</div>
        </div>
    </div>

    <div class="card">
        <div class="card-body text-center">
            <div class="mb-4">
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-danger-color mx-auto">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div class="text-3xl font-bold text-danger-color mb-2"><?= $assigned_count ?? 0 ?></div>
            <div class="text-gray-600 font-medium">Assigned IPs</div>
        </div>
    </div>

    <div class="card">
        <div class="card-body text-center">
            <div class="mb-4">
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-warning-color mx-auto">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <div class="text-3xl font-bold text-warning-color mb-2"><?= $reserved_count ?? 0 ?></div>
            <div class="text-gray-600 font-medium">Reserved IPs</div>
        </div>
    </div>
</div>

<!-- System Information -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-semibold">System Information</h3>
        </div>
        <div class="card-body">
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">PHP Version</span>
                    <span class="font-medium"><?= phpversion() ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Server</span>
                    <span class="font-medium"><?= $_SERVER['SERVER_NAME'] ?? 'N/A' ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Application Version</span>
                    <span class="font-medium">v1.0</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Current User</span>
                    <span class="font-medium"><?= htmlspecialchars($_SESSION['user_name'] ?? 'N/A') ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">User Role</span>
                    <span class="badge badge-primary"><?= htmlspecialchars($_SESSION['user_role'] ?? 'user') ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Login IP</span>
                    <span class="font-medium"><?= $_SERVER['REMOTE_ADDR'] ?? 'N/A' ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-semibold">Developer Information</h3>
        </div>
        <div class="card-body">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="font-medium">Eren Can Uçar</span>
                </div>
                <div class="flex items-center gap-3">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-gray-600">dev@eren.gg</span>
                </div>
                <div class="flex gap-3">
                    <a href="https://www.linkedin.com/in/erencanucarr/" target="_blank" class="btn btn-sm btn-secondary">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                        LinkedIn
                    </a>
                    <a href="https://github.com/erencanucarr" target="_blank" class="btn btn-sm btn-secondary">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                        GitHub
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Help & Documentation -->
<?php if (!empty($dashboard_help_docs)): ?>
<div class="card">
    <div class="card-header">
        <h3 class="text-lg font-semibold">Recent Help Articles</h3>
    </div>
    <div class="card-body">
        <div class="space-y-4">
            <?php foreach ($dashboard_help_docs as $doc): ?>
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-900 mb-2"><?= htmlspecialchars($doc['title']) ?></h4>
                    <p class="text-sm text-gray-500 mb-2">
                        By <?= htmlspecialchars($doc['author']) ?> • <?= htmlspecialchars($doc['created_at']) ?>
                    </p>
                    <p class="text-gray-700"><?= htmlspecialchars($doc['content']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="mt-4 text-right">
            <a href="index.php?page=help" class="btn btn-primary">
                View All Help Articles
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</div>
<?php endif; ?>

<?php
$content = ob_get_clean();
require_once 'views/layouts/app.php';
?>