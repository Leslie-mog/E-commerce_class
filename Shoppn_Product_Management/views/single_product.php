<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

$productId = filter_input(INPUT_GET, 'pro_id', FILTER_VALIDATE_INT) ?: 0;
if ($productId <= 0) {
    redirect(BASE_URL . '/index.php');
}

$controller = new ProductController();
$product = $controller->getProductById($productId);
if (!$product) {
    $_SESSION['error'] = 'Product not found.';
    redirect(BASE_URL . '/index.php');
}
?>
<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="content-wrapper">
    <?php require_once __DIR__ . '/layout/sidebar.php'; ?>
    <section class="main-content">
        <article class="single-product">
            <?php if (!empty($product['product_image'])): ?>
                <img class="single-product-image" src="<?= BASE_URL ?>/images/Products/<?= rawurlencode($product['product_image']) ?>" alt="<?= e($product['product_title']) ?>">
            <?php endif; ?>
            <div>
                <h1><?= e($product['product_title']) ?></h1>
                <p><strong>Category:</strong> <?= e($product['category_name'] ?? '') ?></p>
                <p><strong>Brand:</strong> <?= e($product['brand_name'] ?? '') ?></p>
                <p class="product-price">$<?= number_format((float) $product['product_price'], 2) ?></p>
                <p><?= nl2br(e($product['product_desc'] ?? '')) ?></p>
                <p><strong>Keywords:</strong> <?= e($product['product_keywords'] ?? '') ?></p>
                <a class="btn-primary" href="<?= BASE_URL ?>/index.php?add_cart=<?= (int) $product['product_id'] ?>">Add to Cart</a>
            </div>
        </article>
    </section>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>