<?php
$page_title = 'Create User - IPAM System';
$current_page = 'register';
ob_start();
?>

<div class="container-sm">
    <div class="card">
        <div class="card-body">
            <div class="text-center mb-8">
                <div class="logo-icon" style="width: 64px; height: 64px; margin: 0 auto 1.5rem; font-size: 1.5rem;">IP</div>
                <h1 class="page-title">Create New User</h1>
                <p class="text-gray-600">Add a new user to the IPAM System</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <form method="post" action="index.php?page=register">
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input 
                        id="name" 
                        type="text" 
                        name="name" 
                        class="form-input" 
                        required 
                        autofocus
                        placeholder="Enter full name"
                    >
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        class="form-input" 
                        required
                        placeholder="Enter email address"
                    >
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        class="form-input" 
                        required
                        placeholder="Enter password"
                    >
                </div>

                <div class="form-group">
                    <label for="role" class="form-label">User Role</label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="">Select a role</option>
                        <option value="user">User (View Only)</option>
                        <option value="admin">Admin (Full Access)</option>
                        <option value="support">Support (Limited Access)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-full">
                    Create User
                </button>
            </form>

            <div class="text-center mt-6">
                <a href="index.php?page=dashboard" class="btn btn-secondary">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once 'views/layouts/app.php';
?>