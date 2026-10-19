<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';

$productId = filter_input(INPUT_GET, 'add_cart', FILTER_VALIDATE_INT) ?: 0;
if ($productId <= 0) {
    $_SESSION['error'] = 'Choose a valid product to add to your cart.';
    redirect(BASE_URL . '/index.php');
}

$ip = get_ip();
$controller = new CartController();
if ($controller->isInCart($productId, $ip)) {
    $_SESSION['error'] = 'This item is already in your cart. Go to cart to update quantity.';
    redirect(BASE_URL . '/views/cart.php');
}

if (!$controller->addToCart($productId, 1, $ip, $_SESSION['customer_id'] ?? null)) {
    $_SESSION['error'] = 'Could not add this item to your cart. Please try again.';
    redirect(BASE_URL . '/index.php');
}

$_SESSION['success'] = 'Item added to your cart.';
$referrer = $_SERVER['HTTP_REFERER'] ?? '';
$refererPath = parse_url($referrer, PHP_URL_PATH);
$refererHost = parse_url($referrer, PHP_URL_HOST);
$requestHost = parse_url('//' . ($_SERVER['HTTP_HOST'] ?? ''), PHP_URL_HOST);
if (is_string($refererPath) && substr($refererPath, 0, 1) === '/' && substr($refererPath, 0, 2) !== '//'
    && (!$refererHost || ($requestHost && strcasecmp($refererHost, $requestHost) === 0))) {
    $query = parse_url($referrer, PHP_URL_QUERY);
    redirect($refererPath . ($query ? '?' . $query : ''));
}
redirect(BASE_URL . '/index.php');
?>