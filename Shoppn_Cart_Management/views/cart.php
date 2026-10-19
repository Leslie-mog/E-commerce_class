<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';

$controller = new CartController();
$ip = get_ip();
$items = $controller->getCartItems($ip);
$subtotal = $controller->getCartTotal($ip);
?>
<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="content-wrapper">
    <?php require_once __DIR__ . '/layout/sidebar.php'; ?>
    <section class="main-content">
        <h1>Shopping Cart</h1>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= e($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-error"><?= e($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if ($items === []): ?>
            <p>Your cart is empty.</p>
            <a class="btn-primary" href="<?= BASE_URL ?>/index.php">Continue Shopping</a>
        <?php else: ?>
            <form id="remove-cart-form" action="<?= BASE_URL ?>/actions/remove_from_cart_action.php" method="POST"></form>
            <form id="update-cart-form" action="<?= BASE_URL ?>/actions/update_qty_action.php" method="POST">
                <div class="cart-table-wrap">
                    <table class="admin-table cart-table">
                        <thead>
                            <tr>
                                <th>Remove</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td>
                                        <input form="remove-cart-form" type="checkbox" name="remove[]" value="<?= (int) $item['p_id'] ?>" aria-label="Remove <?= e($item['product_title']) ?>">
                                    </td>
                                    <td class="cart-product">
                                        <?php if (!empty($item['product_image'])): ?>
                                            <img src="<?= BASE_URL ?>/images/Products/<?= rawurlencode($item['product_image']) ?>" alt="<?= e($item['product_title']) ?>">
                                        <?php endif; ?>
                                        <span><?= e($item['product_title']) ?></span>
                                    </td>
                                    <td>
                                        <input type="number" name="qty[]" min="1" step="1" required value="<?= max(1, (int) $item['qty']) ?>" aria-label="Quantity for <?= e($item['product_title']) ?>">
                                        <input type="hidden" name="update[]" value="<?= (int) $item['p_id'] ?>">
                                    </td>
                                    <td>$<?= number_format((float) $item['product_price'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="cart-subtotal">
                                <th colspan="3">Subtotal</th>
                                <td>$<?= number_format($subtotal, 2) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="cart-actions">
                    <button class="btn-primary" type="submit">Update Quantity</button>
                    <button class="btn-primary" type="submit" form="remove-cart-form">Remove from Cart</button>
                    <a class="btn-link" href="<?= BASE_URL ?>/index.php">Continue Shopping</a>
                    <a class="btn-primary" href="<?= BASE_URL ?>/views/checkout.php">Checkout</a>
                </div>
            </form>
        <?php endif; ?>
    </section>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>