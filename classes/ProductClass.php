<?php
// classes/ProductClass.php
require_once __DIR__ . '/../core/db_class.php';

class ProductClass extends Database
{
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
