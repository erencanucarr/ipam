<?php
$page_title = 'Login - IPAM System';
$current_page = 'login';
ob_start();
?>

<div class="container-sm">
    <div class="card">
        <div class="card-body">
            <div class="text-center mb-8">
                <div class="logo-icon" style="width: 64px; height: 64px; margin: 0 auto 1.5rem; font-size: 1.5rem;">IP</div>
                <h1 class="page-title">Welcome Back</h1>
                <p class="text-gray-600">Sign in to your IPAM System account</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="post" action="index.php?page=login">
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        class="form-input" 
                        required 
                        autofocus
                        placeholder="Enter your email"
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
                        placeholder="Enter your password"
                    >
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-full">
                    Sign In
                </button>
            </form>

            <div class="text-center mt-6">
                <p class="text-gray-600">
                    Don't have an account? 
                    <a href="index.php?page=register" class="text-primary-color font-medium">Create one</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once 'views/layouts/app.php';
?>