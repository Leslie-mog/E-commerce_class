<?php
// classes/ProductClass.php
require_once __DIR__ . '/../core/db_class.php';

class ProductClass extends Database
{
    public function addProduct(
        int $cat,
        int $brand,
        string $title,
        float $price,
        string $desc,
        string $image_filename,
        string $keywords
    ): bool {
        $stmt = $this->conn->prepare(
            "INSERT INTO products (product_cat, product_brand, product_title, product_price, product_desc, product_image, product_keywords) VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param('iisdsss', $cat, $brand, $title, $price, $desc, $image_filename, $keywords);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function updateProduct(
        int $id,
        int $cat,
        int $brand,
        string $title,
        float $price,
        string $desc,
        string $image_filename,
        string $keywords
    ): bool {
        $stmt = $this->conn->prepare(
            "UPDATE products SET product_cat = ?, product_brand = ?, product_title = ?, product_price = ?, product_desc = ?, product_image = ?, product_keywords = ? WHERE product_id = ?"
        );
        $stmt->bind_param('iisdsssi', $cat, $brand, $title, $price, $desc, $image_filename, $keywords, $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function getProductById(int $id)
    {
        $stmt = $this->conn->prepare(
            "SELECT p.*, c.cat_name AS category_name, b.brand_name AS brand_name FROM products p LEFT JOIN categories c ON p.product_cat = c.cat_id LEFT JOIN brands b ON p.product_brand = b.brand_id WHERE p.product_id = ?"
        );
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row ?: false;
    }

    public function getFeaturedProducts(int $limit = 6): array
    {
        $stmt = $this->conn->prepare(
            "SELECT p.*, c.cat_name AS category_name, b.brand_name AS brand_name FROM products p LEFT JOIN categories c ON p.product_cat = c.cat_id LEFT JOIN brands b ON p.product_brand = b.brand_id ORDER BY RAND() LIMIT ?"
        );
        $stmt->bind_param('i', $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $stmt->close();
        return $products;
    }

    public function getAllProducts(): array
    {
        $stmt = $this->conn->prepare(
            "SELECT p.*, c.cat_name AS category_name, b.brand_name AS brand_name FROM products p LEFT JOIN categories c ON p.product_cat = c.cat_id LEFT JOIN brands b ON p.product_brand = b.brand_id ORDER BY p.product_title ASC"
        );
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $stmt->close();
        return $products;
    }

    public function getProductsByCategory(int $cat_id): array
    {
        return $this->getProductsByFilter('product_cat', $cat_id);
    }

    public function getProductsByBrand(int $brand_id): array
    {
        return $this->getProductsByFilter('product_brand', $brand_id);
    }

    private function getProductsByFilter(string $column, int $id): array
    {
        $stmt = $this->conn->prepare(
            "SELECT p.*, c.cat_name AS category_name, b.brand_name AS brand_name FROM products p LEFT JOIN categories c ON p.product_cat = c.cat_id LEFT JOIN brands b ON p.product_brand = b.brand_id WHERE p.$column = ? ORDER BY p.product_title ASC"
        );
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $stmt->close();
        return $products;
    }

    public function searchProducts(string $query): array
    {
        $stmt = $this->conn->prepare(
            "SELECT p.*, c.cat_name AS category_name, b.brand_name AS brand_name FROM products p LEFT JOIN categories c ON p.product_cat = c.cat_id LEFT JOIN brands b ON p.product_brand = b.brand_id WHERE p.product_title LIKE ? OR p.product_keywords LIKE ? ORDER BY p.product_title ASC"
        );
        $term = '%' . $query . '%';
        $stmt->bind_param('ss', $term, $term);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $stmt->close();
        return $products;
    }

    /**
     * Add a new brand.
     */
    public function addBrand(string $name): bool
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO brands (brand_name) VALUES (?)"
        );
        $stmt->bind_param('s', $name);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    /**
     * Get all brands, ordered by name.
     */
    public function getAllBrands(): array
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM brands ORDER BY brand_name ASC"
        );
        $stmt->execute();
        $result = $stmt->get_result();
        $brands = [];
        while ($row = $result->fetch_assoc()) {
            $brands[] = $row;
        }
        $stmt->close();
        return $brands;
    }

    /**
     * Get a brand by ID.
     */
    public function getBrandById(int $id)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM brands WHERE brand_id = ?"
        );
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row ?: false;
    }

    /**
     * Update a brand.
     */
    public function updateBrand(int $id, string $name): bool
    {
        $stmt = $this->conn->prepare(
            "UPDATE brands SET brand_name = ? WHERE brand_id = ?"
        );
        $stmt->bind_param('si', $name, $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    /**
     * Add a new category.
     */
    public function addCategory(string $name): bool
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO categories (cat_name) VALUES (?)"
        );
        $stmt->bind_param('s', $name);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    /**
     * Get all categories, ordered by name.
     */
    public function getAllCategories(): array
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM categories ORDER BY cat_name ASC"
        );
        $stmt->execute();
        $result = $stmt->get_result();
        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
        $stmt->close();
        return $categories;
    }

    /**
     * Get a category by ID.
     */
    public function getCategoryById(int $id)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM categories WHERE cat_id = ?"
        );
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row ?: false;
    }

    /**
     * Update a category.
     */
    public function updateCategory(int $id, string $name): bool
    {
        $stmt = $this->conn->prepare(
            "UPDATE categories SET cat_name = ? WHERE cat_id = ?"
        );
        $stmt->bind_param('si', $name, $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
?>
