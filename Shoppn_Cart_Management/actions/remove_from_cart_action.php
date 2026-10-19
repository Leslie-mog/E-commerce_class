<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';

$cartUrl = BASE_URL . '/views/cart.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Invalid request method.';
    redirect($cartUrl);
}

$productIds = $_POST['remove'] ?? [];
if (!is_array($productIds) || $productIds === []) {
    $_SESSION['error'] = 'Select at least one item to remove.';
    redirect($cartUrl);
}

$controller = new CartController();
$ip = get_ip();
foreach ($productIds as $rawProductId) {
    $productId = filter_var($rawProductId, FILTER_VALIDATE_INT);
    if ($productId !== false && $productId > 0) {
        $controller->removeFromCart($productId, $ip);
    }
}

$_SESSION['success'] = 'Selected items were removed from your cart.';
redirect($cartUrl);
?>