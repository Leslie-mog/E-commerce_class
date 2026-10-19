<?php
require_once __DIR__ . '/../classes/CartClass.php';

class CartController
{
    private CartClass $model;

    public function __construct()
    {
        $this->model = new CartClass();
    }

    public function isInCart(int $product_id, string $ip): bool
    {
        return $this->model->isInCart($product_id, $ip);
    }

    public function addToCart(int $product_id, int $qty, string $ip, $customer_id = null): bool
    {
        return $this->model->addToCart($product_id, $qty, $ip, $customer_id);
    }

    public function getCartItems(string $ip): array
    {
        return $this->model->getCartItems($ip);
    }

    public function getCartCount(string $ip): int
    {
        return $this->model->getCartCount($ip);
    }

    public function getCartTotal(string $ip): float
    {
        return $this->model->getCartTotal($ip);
    }

    public function removeFromCart(int $product_id, string $ip): bool
    {
        return $this->model->removeFromCart($product_id, $ip);
    }

    public function updateQty(int $product_id, int $new_qty, string $ip): bool
    {
        return $this->model->updateQty($product_id, $new_qty, $ip);
    }
}
?>