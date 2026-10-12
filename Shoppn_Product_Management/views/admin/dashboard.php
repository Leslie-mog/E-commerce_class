<?php
// views/admin/dashboard.php
require_once __DIR__ . '/../../core/core.php';
require_once __DIR__ . '/../../controllers/ProductController.php';

require_admin();

$controller = new ProductController();
$brands = $controller->getAllBrands();
$categories = $controller->getAllCategories();

$brand_count = count($brands);
$category_count = count($categories);
?>
<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="content-wrapper">
    <?php require_once __DIR__ . '/../layout/sidebar.php'; ?>

    <section class="main-content">
        <h2>Admin Dashboard</h2>

        <div class="dashboard-summary">
            <div class="summary-card">
                <h3><?= $brand_count ?></h3>
                <p>Total Brands</p>
                <a href="<?= BASE_URL ?>/views/admin/brand.php" class="btn-link">Manage →</a>
            </div>

            <div class="summary-card">
                <h3><?= $category_count ?></h3>
                <p>Total Categories</p>
                <a href="<?= BASE_URL ?>/views/admin/category.php" class="btn-link">Manage →</a>
            </div>

            <div class="summary-card">
                <h3>0</h3>
                <p>Total Products</p>
                <a href="<?= BASE_URL ?>/views/admin/product.php" class="btn-link">Manage →</a>
            </div>
        </div>

        <div class="dashboard-grid">
            <section class="dashboard-section">
                <h3>Recent Brands</h3>
                <?php if (empty($brands)): ?>
                    <p><em>No brands yet. <a href="<?= BASE_URL ?>/views/admin/brand.php">Add one</a></em></p>
                <?php else: ?>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Brand</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($brands, 0, 5) as $brand): ?>
                                <tr>
                                    <td><?= e($brand['brand_name']) ?></td>
                                    <td>
                                        <a href="<?= BASE_URL ?>/views/admin/brand.php?edit_id=<?= e($brand['brand_id']) ?>" class="btn-link">Edit</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php if ($brand_count > 5): ?>
                        <p><a href="<?= BASE_URL ?>/views/admin/brand.php">View all <?= $brand_count ?> brands →</a></p>
                    <?php endif; ?>
                <?php endif; ?>
            </section>

            <section class="dashboard-section">
                <h3>Recent Categories</h3>
                <?php if (empty($categories)): ?>
                    <p><em>No categories yet. <a href="<?= BASE_URL ?>/views/admin/category.php">Add one</a></em></p>
                <?php else: ?>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($categories, 0, 5) as $category): ?>
                                <tr>
                                    <td><?= e($category['cat_name']) ?></td>
                                    <td>
                                        <a href="<?= BASE_URL ?>/views/admin/category.php?edit_id=<?= e($category['cat_id']) ?>" class="btn-link">Edit</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php if ($category_count > 5): ?>
                        <p><a href="<?= BASE_URL ?>/views/admin/category.php">View all <?= $category_count ?> categories →</a></p>
                    <?php endif; ?>
                <?php endif; ?>
            </section>
        </div>
    </section>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
