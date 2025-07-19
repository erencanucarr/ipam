<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'IPAM System' ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="public/css/main.css">
    <link rel="stylesheet" href="public/css/layout.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🌐</text></svg>">
</head>
<body>
    <?php if (isset($_SESSION['user_id'])): ?>
        <!-- Authenticated Layout -->
        <div class="main-layout">
            <!-- Sidebar -->
            <aside class="sidebar" id="sidebar">
                <div class="sidebar-header">
                    <a href="index.php?page=dashboard" class="logo">
                        <div class="logo-icon">IP</div>
                        <span>IPAM System</span>
                    </a>
                </div>
                
                <nav class="sidebar-nav">
                    <div class="nav-section">
                        <div class="nav-section-title">Main</div>
                        <div class="nav-item">
                            <a href="index.php?page=dashboard" class="nav-link <?= $current_page === 'dashboard' ? 'active' : '' ?>">
                                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"/>
                                </svg>
                                Dashboard
                            </a>
                        </div>
                        <div class="nav-item">
                            <a href="index.php?page=subnets" class="nav-link <?= $current_page === 'subnets' ? 'active' : '' ?>">
                                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                Subnets
                            </a>
                        </div>
                        <div class="nav-item">
                            <a href="index.php?page=ips" class="nav-link <?= $current_page === 'ips' ? 'active' : '' ?>">
                                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                IP Addresses
                            </a>
                        </div>
                    </div>
                    
                    <?php if ($_SESSION['user_role'] !== 'support'): ?>
                    <div class="nav-section">
                        <div class="nav-section-title">Management</div>
                        <div class="nav-item">
                            <a href="index.php?page=users" class="nav-link <?= $current_page === 'users' ? 'active' : '' ?>">
                                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                </svg>
                                Users
                            </a>
                        </div>
                        <div class="nav-item">
                            <a href="index.php?page=audit_logs" class="nav-link <?= $current_page === 'audit_logs' ? 'active' : '' ?>">
                                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Audit Logs
                            </a>
                        </div>
                        <div class="nav-item">
                            <a href="index.php?page=ipreport" class="nav-link <?= $current_page === 'ipreport' ? 'active' : '' ?>">
                                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                Reports
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="nav-section">
                        <div class="nav-section-title">Support</div>
                        <div class="nav-item">
                            <a href="index.php?page=help" class="nav-link <?= $current_page === 'help' ? 'active' : '' ?>">
                                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Help & Docs
                            </a>
                        </div>
                        <div class="nav-item">
                            <a href="index.php?page=settings" class="nav-link <?= $current_page === 'settings' ? 'active' : '' ?>">
                                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Settings
                            </a>
                        </div>
                    </div>
                </nav>
            </aside>
            
            <!-- Mobile Overlay -->
            <div class="sidebar-overlay" id="sidebarOverlay"></div>
            
            <!-- Main Content -->
            <main class="main-content">
                <!-- Header -->
                <header class="header">
                    <div class="header-content">
                        <button class="mobile-menu-toggle" id="mobileMenuToggle">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        
                        <div class="header-nav">
                            <a href="index.php?page=dashboard" class="<?= $current_page === 'dashboard' ? 'active' : '' ?>">Dashboard</a>
                            <a href="index.php?page=subnets" class="<?= $current_page === 'subnets' ? 'active' : '' ?>">Subnets</a>
                            <a href="index.php?page=ips" class="<?= $current_page === 'ips' ? 'active' : '' ?>">IP Addresses</a>
                        </div>
                        
                        <div class="user-menu">
                            <div class="user-info">
                                <div class="user-name"><?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></div>
                                <div class="user-role"><?= htmlspecialchars($_SESSION['user_role'] ?? 'user') ?></div>
                            </div>
                            <div class="user-avatar">
                                <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
                            </div>
                            <form method="post" action="index.php?page=logout" style="display: inline;">
                                <button type="submit" class="btn btn-sm btn-secondary">Logout</button>
                            </form>
                        </div>
                    </div>
                </header>
                
                <!-- Page Content -->
                <div class="content-wrapper">
                    <?php if (!empty($_SESSION['flash_success'])): ?>
                        <div class="alert alert-success">
                            <?= htmlspecialchars($_SESSION['flash_success']) ?>
                        </div>
                        <?php unset($_SESSION['flash_success']); ?>
                    <?php endif; ?>
                    
                    <?php if (!empty($_SESSION['flash_error'])): ?>
                        <div class="alert alert-error">
                            <?= htmlspecialchars($_SESSION['flash_error']) ?>
                        </div>
                        <?php unset($_SESSION['flash_error']); ?>
                    <?php endif; ?>
                    
                    <?= $content ?? '' ?>
                </div>
            </main>
        </div>
        
        <!-- JavaScript for Mobile Menu -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const sidebar = document.getElementById('sidebar');
                const sidebarOverlay = document.getElementById('sidebarOverlay');
                const mobileMenuToggle = document.getElementById('mobileMenuToggle');
                
                function toggleSidebar() {
                    sidebar.classList.toggle('open');
                    sidebarOverlay.classList.toggle('open');
                }
                
                function closeSidebar() {
                    sidebar.classList.remove('open');
                    sidebarOverlay.classList.remove('open');
                }
                
                mobileMenuToggle.addEventListener('click', toggleSidebar);
                sidebarOverlay.addEventListener('click', closeSidebar);
                
                // Close sidebar on window resize if screen becomes larger
                window.addEventListener('resize', function() {
                    if (window.innerWidth > 1024) {
                        closeSidebar();
                    }
                });
            });
        </script>
        
    <?php else: ?>
        <!-- Unauthenticated Layout (Login/Register) -->
        <div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <?= $content ?? '' ?>
        </div>
    <?php endif; ?>
</body>
</html> 