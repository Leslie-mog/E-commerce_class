<?php
// controllers/ProductController.php
require_once __DIR__ . '/../classes/ProductClass.php';

class ProductController
{
    private ProductClass $model;

    public function __construct()
    {
        $this->model = new ProductClass();
    }

    public function addProduct(
        int $cat,
        int $brand,
        string $title,
        float $price,
        string $desc,
        string $image_filename,
        string $keywords
    ): bool {
        return $this->model->addProduct($cat, $brand, $title, $price, $desc, $image_filename, $keywords);
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
        return $this->model->updateProduct($id, $cat, $brand, $title, $price, $desc, $image_filename, $keywords);
    }

    public function getProductById(int $id)
    {
        return $this->model->getProductById($id);
    }

    public function getFeaturedProducts(int $limit = 6): array
    {
        return $this->model->getFeaturedProducts($limit);
    }

    public function getAllProducts(): array
    {
        return $this->model->getAllProducts();
    }

    public function getProductsByCategory(int $cat_id): array
    {
        return $this->model->getProductsByCategory($cat_id);
    }

    public function getProductsByBrand(int $brand_id): array
    {
        return $this->model->getProductsByBrand($brand_id);
    }

    public function searchProducts(string $query): array
    {
        return $this->model->searchProducts($query);
    }

    /**
     * Add a new brand.
     */
    public function addBrand(string $name): bool
    {
        return $this->model->addBrand($name);
    }

    /**
     * Get all brands.
     */
    public function getAllBrands(): array
    {
        return $this->model->getAllBrands();
    }

    /**
     * Get a brand by ID.
     */
    public function getBrandById(int $id)
    {
        return $this->model->getBrandById($id);
    }

    /**
     * Update a brand.
     */
    public function updateBrand(int $id, string $name): bool
    {
        return $this->model->updateBrand($id, $name);
    }

    /**
     * Add a new category.
     */
    public function addCategory(string $name): bool
    {
        return $this->model->addCategory($name);
    }

    /**
     * Get all categories.
     */
    public function getAllCategories(): array
    {
        return $this->model->getAllCategories();
    }

    /**
     * Get a category by ID.
     */
    public function getCategoryById(int $id)
    {
        return $this->model->getCategoryById($id);
    }

    /**
     * Update a category.
     */
    public function updateCategory(int $id, string $name): bool
    {
        return $this->model->updateCategory($id, $name);
    }
}
?>
