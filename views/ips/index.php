<?php
$page_title = 'IP Addresses - ' . htmlspecialchars($subnet['name']) . ' - IPAM System';
$current_page = 'ips';

ob_start();
?>

<div class="page-header">
    <div class="flex items-center gap-4">
        <a href="index.php?page=subnets" class="btn btn-secondary">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Subnets
        </a>
        <div>
            <h1 class="page-title">IP Addresses</h1>
            <p class="page-description">Managing IP addresses for subnet: <?= htmlspecialchars($subnet['name']) ?></p>
        </div>
    </div>
</div>

<!-- Subnet Information -->
<div class="card mb-6">
    <div class="card-header">
        <h3 class="text-lg font-semibold">Subnet Information</h3>
    </div>
    <div class="card-body">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <span class="text-gray-600 text-sm">Network</span>
                <div class="font-semibold text-lg"><?= htmlspecialchars($subnet['network']) ?>/<?= htmlspecialchars($subnet['cidr']) ?></div>
            </div>
            <div>
                <span class="text-gray-600 text-sm">Total IPs</span>
                <div class="font-semibold text-lg"><?= number_format($subnet['total_ips']) ?></div>
            </div>
            <div>
                <span class="text-gray-600 text-sm">Available IPs</span>
                <div class="font-semibold text-lg text-success-color"><?= number_format($subnet['available_ips']) ?></div>
            </div>
        </div>
        <?php if (!empty($subnet['description'])): ?>
            <div class="mt-4 pt-4 border-t border-gray-200">
                <span class="text-gray-600 text-sm">Description</span>
                <div class="text-gray-700"><?= htmlspecialchars($subnet['description']) ?></div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Page Actions -->
<div class="page-actions mb-6">
    <a href="index.php?page=ips&action=create&subnet_id=<?= $subnet['id'] ?>" class="btn btn-primary">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Add IP Address
    </a>
    <a href="index.php?page=ips&action=export&subnet_id=<?= $subnet['id'] ?>&format=csv" class="btn btn-secondary">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Export CSV
    </a>
    <a href="index.php?page=ips&action=export&subnet_id=<?= $subnet['id'] ?>&format=json" class="btn btn-secondary">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Export JSON
    </a>
</div>

<!-- IP Addresses Table -->
<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>IP Address</th>
                <th>Status</th>
                <th>Hostname</th>
                <th>Description</th>
                <th>Client</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ips as $ip): ?>
                <tr class="<?= $ip['status'] === 'assigned' ? 'ip-row-assigned' : ($ip['status'] === 'free' ? 'ip-row-free' : 'ip-row-reserved') ?>">
                    <td class="font-mono font-semibold"><?= htmlspecialchars($ip['address']) ?></td>
                    <td>
                        <?php if ($ip['status'] === 'assigned'): ?>
                            <span class="badge badge-danger">Assigned</span>
                        <?php elseif ($ip['status'] === 'free'): ?>
                            <span class="badge badge-success">Free</span>
                        <?php else: ?>
                            <span class="badge badge-warning">Reserved</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($ip['hostname'] ?: '-') ?></td>
                    <td><?= htmlspecialchars($ip['description'] ?: '-') ?></td>
                    <td><?= htmlspecialchars(isset($ip['client']) ? $ip['client'] : '-') ?></td>
                    <td class="actions">
                        <a href="index.php?page=ips&action=edit&id=<?= $ip['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="index.php?page=ips&action=delete&id=<?= $ip['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if (empty($ips)): ?>
    <div class="text-center py-12">
        <svg width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-400 mx-auto mb-4">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">No IP Addresses Found</h3>
        <p class="text-gray-600 mb-6">This subnet doesn't have any IP addresses yet. Add the first one to get started.</p>
        <a href="index.php?page=ips&action=create&subnet_id=<?= $subnet['id'] ?>" class="btn btn-primary">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add First IP Address
        </a>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
require_once 'views/layouts/app.php';
?> 