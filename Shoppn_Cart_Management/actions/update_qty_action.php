<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';

$cartUrl = BASE_URL . '/views/cart.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Invalid request method.';
    redirect($cartUrl);
}

$quantities = $_POST['qty'] ?? [];
$productIds = $_POST['update'] ?? [];
if (!is_array($quantities) || !is_array($productIds) || $productIds === []) {
    $_SESSION['error'] = 'No cart quantities were submitted.';
    redirect($cartUrl);
}

$controller = new CartController();
$ip = get_ip();
$hasInvalidQuantity = false;
foreach ($productIds as $key => $rawProductId) {
    $productId = filter_var($rawProductId, FILTER_VALIDATE_INT);
    $quantity = filter_var($quantities[$key] ?? null, FILTER_VALIDATE_INT);
    if ($productId === false || $productId <= 0 || $quantity === false || $quantity < 1) {
        $hasInvalidQuantity = true;
        continue;
    }
    $controller->updateQty($productId, $quantity, $ip);
}

if ($hasInvalidQuantity) {
    $_SESSION['error'] = 'Enter a quantity of at least 1 for each item.';
} else {
    $_SESSION['success'] = 'Cart quantities updated.';
}
redirect($cartUrl);
?>