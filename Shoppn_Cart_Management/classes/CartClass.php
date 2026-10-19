<?php
require_once __DIR__ . '/../core/db_class.php';

class CartClass extends Database
{
    public function isInCart(int $product_id, string $ip): bool
    {
        $stmt = $this->conn->prepare('SELECT 1 FROM cart WHERE p_id = ? AND ip_add = ? LIMIT 1');
        $stmt->bind_param('is', $product_id, $ip);
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    public function addToCart(int $product_id, int $qty, string $ip, $customer_id = null): bool
    {
        if ($product_id <= 0 || $qty < 1) {
            return false;
        }

        $stmt = $this->conn->prepare('INSERT INTO cart (p_id, ip_add, qty) VALUES (?, ?, ?)');
        $stmt->bind_param('isi', $product_id, $ip, $qty);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function getCartItems(string $ip): array
    {
        $stmt = $this->conn->prepare(
            'SELECT cart.*, products.product_title, products.product_price, products.product_image FROM cart JOIN products ON cart.p_id = products.product_id WHERE cart.ip_add = ?'
        );
        $stmt->bind_param('s', $ip);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        $stmt->close();
        return $items;
    }

    public function getCartCount(string $ip): int
    {
        $stmt = $this->conn->prepare('SELECT COUNT(*) AS item_count FROM cart WHERE ip_add = ?');
        $stmt->bind_param('s', $ip);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return (int) ($row['item_count'] ?? 0);
    }

    public function getCartTotal(string $ip): float
    {
        $total = 0.0;
        foreach ($this->getCartItems($ip) as $item) {
            $total += (int) $item['qty'] * (float) $item['product_price'];
        }
        return $total;
    }

    public function removeFromCart(int $product_id, string $ip): bool
    {
        $stmt = $this->conn->prepare('DELETE FROM cart WHERE p_id = ? AND ip_add = ?');
        $stmt->bind_param('is', $product_id, $ip);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function updateQty(int $product_id, int $new_qty, string $ip): bool
    {
        if ($product_id <= 0 || $new_qty < 1) {
            return false;
        }

        $stmt = $this->conn->prepare('UPDATE cart SET qty = ? WHERE p_id = ? AND ip_add = ?');
        $stmt->bind_param('iis', $new_qty, $product_id, $ip);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
?>