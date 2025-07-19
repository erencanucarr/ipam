<?php
$page_title = 'Help & Documentation - IPAM System';
$current_page = 'help';

ob_start();
?>

<div class="page-header">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="page-title">Help & Documentation</h1>
            <p class="page-description">Find answers to common questions and learn how to use the IPAM system effectively.</p>
        </div>
        <a href="index.php?page=help&action=submit" class="btn btn-primary">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Article
        </a>
    </div>
</div>

<!-- Getting Started Guide -->
<div class="card mb-8">
    <div class="card-header">
        <h3 class="text-lg font-semibold">Getting Started with IPAM</h3>
    </div>
    <div class="card-body">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-primary-color text-white rounded-full flex items-center justify-center text-sm font-semibold">1</div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Account Management</h4>
                        <p class="text-gray-600 text-sm">Admins can create user accounts from the User Management page.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-primary-color text-white rounded-full flex items-center justify-center text-sm font-semibold">2</div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Subnets</h4>
                        <p class="text-gray-600 text-sm">Add a subnet from the Subnets page using the "Add Subnet" button.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-primary-color text-white rounded-full flex items-center justify-center text-sm font-semibold">3</div>
                    <div>
                        <h4 class="font-semibold text-gray-900">IP Management</h4>
                        <p class="text-gray-600 text-sm">Click a subnet to add or edit IPs. Use the "Add IP" or "Edit" buttons.</p>
                    </div>
                </div>
            </div>
            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-success-color text-white rounded-full flex items-center justify-center text-sm font-semibold">4</div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Support Role</h4>
                        <p class="text-gray-600 text-sm">Support users can only edit IPs in subnets.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-success-color text-white rounded-full flex items-center justify-center text-sm font-semibold">5</div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Viewing</h4>
                        <p class="text-gray-600 text-sm">All users can view subnets and IPs.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-warning-color text-white rounded-full flex items-center justify-center text-sm font-semibold">6</div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Need More Help?</h4>
                        <p class="text-gray-600 text-sm">See the articles below or add your own tips!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Help Articles -->
<?php if (!empty($docs)): ?>
    <div class="space-y-6">
        <?php foreach ($docs as $doc): ?>
            <div class="card">
                <div class="card-body">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-primary-color to-blue-600 text-white rounded-full flex items-center justify-center text-lg font-bold">
                            <?= strtoupper(substr($doc['author'], 0, 1)) ?>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($doc['title']) ?></h3>
                                <span class="badge badge-primary">Help Article</span>
                            </div>
                            <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                                <span class="flex items-center gap-1">
                                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <?= htmlspecialchars($doc['author']) ?>
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <?= htmlspecialchars($doc['created_at']) ?>
                                </span>
                            </div>
                            <div class="prose prose-sm max-w-none">
                                <?= $doc['content'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="card">
        <div class="card-body text-center py-12">
            <svg width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-400 mx-auto mb-4">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Help Articles Yet</h3>
            <p class="text-gray-600 mb-6">Be the first to add a help article and help others learn!</p>
            <a href="index.php?page=help&action=submit" class="btn btn-primary">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Add First Article
            </a>
        </div>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
require_once 'views/layouts/app.php';
?>