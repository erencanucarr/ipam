<?php
$page_title = 'Subnets - IPAM System';
$current_page = 'subnets';
ob_start();
?>

<div class="page-header">
    <h1 class="page-title">Subnets</h1>
    <p class="page-description">Manage your network subnets and IP address ranges</p>
</div>

<!-- Search/Filter Form -->
<div class="card mb-6">
    <div class="card-header">
        <h3 class="text-lg font-semibold">Search & Filter</h3>
    </div>
    <div class="card-body">
        <form method="get" action="index.php" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <input type="hidden" name="page" value="subnets">
            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input 
                    id="name" 
                    type="text" 
                    name="name" 
                    class="form-input" 
                    placeholder="Search by name"
                    value="<?= htmlspecialchars($_GET['name'] ?? '') ?>"
                >
            </div>
            <div class="form-group">
                <label for="network" class="form-label">Network</label>
                <input 
                    id="network" 
                    type="text" 
                    name="network" 
                    class="form-input" 
                    placeholder="Search by network"
                    value="<?= htmlspecialchars($_GET['network'] ?? '') ?>"
                >
            </div>
            <div class="form-group">
                <label for="cidr" class="form-label">CIDR</label>
                <input 
                    id="cidr" 
                    type="text" 
                    name="cidr" 
                    class="form-input" 
                    placeholder="Search by CIDR"
                    value="<?= htmlspecialchars($_GET['cidr'] ?? '') ?>"
                >
            </div>
            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <input 
                    id="description" 
                    type="text" 
                    name="description" 
                    class="form-input" 
                    placeholder="Search by description"
                    value="<?= htmlspecialchars($_GET['description'] ?? '') ?>"
                >
            </div>
            <div class="flex gap-3 items-end">
                <button type="submit" class="btn btn-primary">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Filter
                </button>
                <a href="index.php?page=subnets" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Actions -->
<div class="page-actions">
    <a href="index.php?page=subnets&action=create" class="btn btn-primary">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Add Subnet
    </a>
    <a href="index.php?page=subnets&action=export&format=json" class="btn btn-success">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Export JSON
    </a>
    <a href="index.php?page=subnets&action=export&format=xml" class="btn btn-primary">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Export XML
    </a>
    <a href="index.php?page=subnets&action=export&format=csv" class="btn btn-warning">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Export CSV
    </a>
    
    <form class="flex gap-3 items-center" action="index.php?page=subnets&action=import" method="post" enctype="multipart/form-data">
        <input type="file" name="file" id="file" class="hidden" accept=".json,.xml,.csv">
        <label for="file" class="btn btn-info cursor-pointer">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
            </svg>
            Choose File
        </label>
        <span id="fileName" class="text-sm text-gray-600"></span>
        <button type="submit" class="btn btn-primary">Import</button>
    </form>
</div>

<!-- Subnets Table -->
<div class="card">
    <div class="card-header">
        <h3 class="text-lg font-semibold">Subnet List</h3>
    </div>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Network</th>
                    <th>CIDR</th>
                    <th>Description</th>
                    <th>Total IPs</th>
                    <th>Used IPs</th>
                    <th>Available</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($subnets)): ?>
                    <?php foreach ($subnets as $subnet): ?>
                        <tr>
                            <td>
                                <div class="font-medium text-gray-900"><?= htmlspecialchars($subnet['name']) ?></div>
                            </td>
                            <td>
                                <code class="text-sm bg-gray-100 px-2 py-1 rounded"><?= htmlspecialchars($subnet['network']) ?></code>
                            </td>
                            <td>
                                <span class="badge badge-primary">/<?= htmlspecialchars($subnet['cidr']) ?></span>
                            </td>
                            <td>
                                <div class="text-gray-600"><?= htmlspecialchars($subnet['description'] ?? '') ?></div>
                            </td>
                            <td>
                                <span class="font-medium"><?= $subnet['total_ips'] ?? 0 ?></span>
                            </td>
                            <td>
                                <span class="font-medium text-danger-color"><?= $subnet['used_ips'] ?? 0 ?></span>
                            </td>
                            <td>
                                <span class="font-medium text-success-color"><?= $subnet['available_ips'] ?? 0 ?></span>
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="index.php?page=ips&subnet_id=<?= $subnet['id'] ?>" class="btn btn-sm btn-primary">
                                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        IPs
                                    </a>
                                    <a href="index.php?page=subnets&action=edit&id=<?= $subnet['id'] ?>" class="btn btn-sm btn-secondary">
                                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <a href="index.php?page=subnets&action=delete&id=<?= $subnet['id'] ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure you want to delete this subnet?')">
                                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center py-8">
                            <div class="empty-state">
                                <svg class="empty-state-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                <div class="empty-state-title">No subnets found</div>
                                <div class="empty-state-description">Get started by creating your first subnet.</div>
                                <a href="index.php?page=subnets&action=create" class="btn btn-primary">
                                    Create First Subnet
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.getElementById('file').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || '';
    document.getElementById('fileName').textContent = fileName;
});
</script>

<?php
$content = ob_get_clean();
require_once 'views/layouts/app.php';
?>