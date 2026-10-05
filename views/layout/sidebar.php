<?php
// views/layout/sidebar.php
require_once __DIR__ . '/../../controllers/ProductController.php';

$controller = new ProductController();
$categories = $controller->getAllCategories();
$brands = $controller->getAllBrands();
?>
<aside class="sidebar">
    <h3>Categories</h3>
    <ul>
        <?php if (empty($categories)): ?>
            <li><em>No categories yet</em></li>
        <?php else: ?>
            <?php foreach ($categories as $category): ?>
                <li><a href="#"><?= e($category['cat_name']) ?></a></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <h3>Brands</h3>
    <ul>
        <?php if (empty($brands)): ?>
            <li><em>No brands yet</em></li>
        <?php else: ?>
            <?php foreach ($brands as $brand): ?>
                <li><a href="#"><?= e($brand['brand_name']) ?></a></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</aside>