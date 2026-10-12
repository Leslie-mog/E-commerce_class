<?php
// views/layout/header.php
if (!defined('BASE_URL')) {
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
    $basePath = $scriptName;

    if (preg_match('#/(?:views|actions|controllers|classes|core|css|js|images)/#', $scriptName)) {
        $basePath = preg_replace('#/(?:views|actions|controllers|classes|core|css|js|images)/(?:.*)$#', '', $scriptName);
    } elseif (basename($scriptName) === 'index.php') {
        $basePath = dirname($scriptName);
    } else {
        $basePath = dirname($scriptName);
    }

    $basePath = str_replace('\\', '/', $basePath);
    $basePath = rtrim($basePath, '/');

    if ($basePath === '.' || $basePath === '/' || $basePath === '') {
        $basePath = '';
    }

    define('BASE_URL', $basePath);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoppn — Online Store</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
</head>

<body>
    <header class="site-header">
        <div class="logo">
            <a href="<?= BASE_URL ?>/index.php" class="brand-name">Shoppn</a>
        </div>

        <form class="search-bar" action="<?= BASE_URL ?>/views/search_results.php" method="GET">
            <input type="text" name="user_query" placeholder="Search products..." required>
            <button type="submit">Search</button>
        </form>

        <nav class="main-nav">
            <ul>
                <li><a href="<?= BASE_URL ?>/index.php">Home</a></li>

                <?php if (is_admin()): ?>
                    <li><a href="<?= BASE_URL ?>/views/admin/brand.php">Manage Brands</a></li>
                    <li><a href="<?= BASE_URL ?>/views/admin/category.php">Manage Categories</a></li>
                    <li><a href="<?= BASE_URL ?>/views/admin/product.php">Manage Products</a></li>
                <?php endif; ?>

                <?php if (is_logged_in()): ?>
                    <li>Welcome, <?= e($_SESSION['customer_name'] ?? 'User') ?></li>
                    <li><a href="<?= BASE_URL ?>/views/account/my_account.php">My Account</a></li>
                    <li><a href="<?= BASE_URL ?>/logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?= BASE_URL ?>/views/register.php">Register</a></li>
                    <li><a href="<?= BASE_URL ?>/views/login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main class="site-main"></main>