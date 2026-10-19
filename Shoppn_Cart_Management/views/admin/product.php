<?php
// views/admin/product.php
require_once __DIR__ . '/../../core/core.php';
require_once __DIR__ . '/../../controllers/ProductController.php';

require_admin();
$controller = new ProductController();
$categories = $controller->getAllCategories();
$brands = $controller->getAllBrands();
$products = $controller->getAllProducts();
$edit_id = filter_input(INPUT_GET, 'edit_id', FILTER_VALIDATE_INT) ?: 0;
$product = $edit_id > 0 ? $controller->getProductById($edit_id) : false;
if ($edit_id > 0 && !$product) {
    $_SESSION['error'] = 'Product not found.';
    redirect(BASE_URL . '/views/admin/product.php');
}
?>
<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="content-wrapper">
    <?php require_once __DIR__ . '/../layout/sidebar.php'; ?>

    <section class="main-content">
        <h2><?= $product ? 'Edit Product' : 'Add Product' ?></h2>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-error"><?= e($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= e($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (empty($categories) || empty($brands)): ?>
            <div class="alert alert-error">Add at least one category and one brand before creating products.</div>
        <?php else: ?>
            <form id="product-form" method="POST" enctype="multipart/form-data"
                action="<?= BASE_URL ?>/actions/<?= $product ? 'update_product_action.php' : 'add_product_action.php' ?>">
                <?php if ($product): ?>
                    <input type="hidden" name="product_id" value="<?= (int) $product['product_id'] ?>">
                    <input type="hidden" name="existing_image" value="<?= e($product['product_image'] ?? '') ?>">
                <?php endif; ?>

                <label>Product Title
                    <input type="text" name="product_title" required maxlength="255" value="<?= e($product['product_title'] ?? '') ?>">
                </label>

                <label>Price
                    <input type="number" name="product_price" required min="0" step="0.01" value="<?= e((string) ($product['product_price'] ?? '')) ?>">
                </label>

                <label>Description
                    <textarea name="product_desc" required rows="5"><?= e($product['product_desc'] ?? '') ?></textarea>
                </label>

                <label>Keywords
                    <input type="text" name="product_keywords" required maxlength="255" value="<?= e($product['product_keywords'] ?? '') ?>">
                </label>

                <label>Category
                    <select name="product_cat" required>
                        <option value="">Select a category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= (int) $category['cat_id'] ?>" <?= (int) ($product['product_cat'] ?? 0) === (int) $category['cat_id'] ? 'selected' : '' ?>><?= e($category['cat_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label>Brand
                    <select name="product_brand" required>
                        <option value="">Select a brand</option>
                        <?php foreach ($brands as $brand): ?>
                            <option value="<?= (int) $brand['brand_id'] ?>" <?= (int) ($product['product_brand'] ?? 0) === (int) $brand['brand_id'] ? 'selected' : '' ?>><?= e($brand['brand_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label>Product Image (JPEG, PNG, GIF, or WebP; max 5 MiB)
                    <input type="file" id="product_image" name="product_image" accept="image/jpeg,image/png,image/gif,image/webp" <?= $product ? '' : 'required' ?> data-required="<?= $product ? 'false' : 'true' ?>">
                    <span class="field-error" id="product-image-error" aria-live="polite"></span>
                </label>

                <?php if (!empty($product['product_image'])): ?>
                    <p>Current image:</p>
                    <img class="admin-product-preview" src="<?= BASE_URL ?>/images/Products/<?= rawurlencode($product['product_image']) ?>" alt="<?= e($product['product_title']) ?>">
                <?php endif; ?>

                <button type="submit" class="btn-primary"><?= $product ? 'Save Changes' : 'Add Product' ?></button>
                <?php if ($product): ?>
                    <a class="btn-link" href="<?= BASE_URL ?>/views/admin/product.php">Cancel</a>
                <?php endif; ?>
            </form>
        <?php endif; ?>

        <h2>Products</h2>
        <?php if (empty($products)): ?>
            <p><em>No products have been added yet.</em></p>
        <?php else: ?>
            <table class="admin-table">
                <thead><tr><th>Product</th><th>Category</th><th>Brand</th><th>Price</th><th>Action</th></tr></thead>
                <tbody>
                    <?php foreach ($products as $item): ?>
                        <tr>
                            <td><?= e($item['product_title']) ?></td>
                            <td><?= e($item['category_name'] ?? '') ?></td>
                            <td><?= e($item['brand_name'] ?? '') ?></td>
                            <td><?= number_format((float) $item['product_price'], 2) ?></td>
                            <td><a class="btn-link" href="<?= BASE_URL ?>/views/admin/product.php?edit_id=<?= (int) $item['product_id'] ?>">Edit</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
