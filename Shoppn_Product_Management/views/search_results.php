<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

$query = $_GET['user_query'] ?? '';
$query = is_string($query) ? trim($query) : '';
$controller = new ProductController();
$products = $query === '' ? [] : $controller->searchProducts($query);
?>
<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="content-wrapper">
    <?php require_once __DIR__ . '/layout/sidebar.php'; ?>
    <section class="main-content">
        <h1>Search Results</h1>
        <?php if ($query !== ''): ?>
            <p>Results for “<?= e($query) ?>”</p>
        <?php endif; ?>
        <div class="product-grid">
            <?php if (empty($products)): ?>
                <p><em>No products found.</em></p>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <?php require __DIR__ . '/layout/product_card.php'; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>