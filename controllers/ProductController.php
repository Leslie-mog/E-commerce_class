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
