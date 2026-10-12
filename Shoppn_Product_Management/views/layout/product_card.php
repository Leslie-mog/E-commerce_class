<article class="product-card">
    <a class="product-card-image" href="<?= BASE_URL ?>/views/single_product.php?pro_id=<?= (int) $product['product_id'] ?>">
        <?php if (!empty($product['product_image'])): ?>
            <img src="<?= BASE_URL ?>/images/Products/<?= rawurlencode($product['product_image']) ?>" alt="<?= e($product['product_title']) ?>" loading="lazy">
        <?php else: ?>
            <span>No image available</span>
        <?php endif; ?>
    </a>
    <div class="product-card-content">
        <h3><a href="<?= BASE_URL ?>/views/single_product.php?pro_id=<?= (int) $product['product_id'] ?>"><?= e($product['product_title']) ?></a></h3>
        <p class="product-price">$<?= number_format((float) $product['product_price'], 2) ?></p>
        <div class="product-card-actions">
            <a class="btn-link" href="<?= BASE_URL ?>/views/single_product.php?pro_id=<?= (int) $product['product_id'] ?>">Details</a>
            <a class="btn-primary" href="<?= BASE_URL ?>/index.php?add_cart=<?= (int) $product['product_id'] ?>">Add to Cart</a>
        </div>
    </div>
</article>