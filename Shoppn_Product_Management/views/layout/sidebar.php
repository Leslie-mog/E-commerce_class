<?php
// views/layout/sidebar.php
require_once __DIR__ . '/../../controllers/ProductController.php';

$sidebarController = new ProductController();
$sidebarCategories = $sidebarController->getAllCategories();
$sidebarBrands = $sidebarController->getAllBrands();
?>
<aside class="sidebar">
    <h3>Categories</h3>
    <ul>
        <?php if (empty($sidebarCategories)): ?>
            <li><em>No categories yet</em></li>
        <?php else: ?>
            <?php foreach ($sidebarCategories as $category): ?>
                <li><a href="<?= BASE_URL ?>/index.php?cat=<?= (int) $category['cat_id'] ?>"><?= e($category['cat_name']) ?></a></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <h3>Brands</h3>
    <ul>
        <?php if (empty($sidebarBrands)): ?>
            <li><em>No brands yet</em></li>
        <?php else: ?>
            <?php foreach ($sidebarBrands as $brand): ?>
                <li><a href="<?= BASE_URL ?>/index.php?brand=<?= (int) $brand['brand_id'] ?>"><?= e($brand['brand_name']) ?></a></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</aside>