<?php
// views/admin/brand.php
require_once __DIR__ . '/../../core/core.php';
require_once __DIR__ . '/../../controllers/ProductController.php';

require_admin();

$controller = new ProductController();
$edit_brand = null;
$edit_id = (int) ($_GET['edit_id'] ?? 0);

if ($edit_id > 0) {
    $edit_brand = $controller->getBrandById($edit_id);
}
?>
<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="content-wrapper">
    <?php require_once __DIR__ . '/../layout/sidebar.php'; ?>

    <section class="main-content">
        <h2><?php echo $edit_id > 0 ? 'Edit Brand' : 'Add Brand'; ?></h2>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= e($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error"><?= e($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST" action="<?php echo $edit_id > 0 ? BASE_URL . '/actions/update_brand_action.php' : BASE_URL . '/actions/add_brand_action.php'; ?>">
            <?php if ($edit_id > 0 && $edit_brand): ?>
                <input type="hidden" name="brand_id" value="<?= e($edit_brand['brand_id']) ?>">
            <?php endif; ?>

            <label for="brand_name">Brand Name:</label>
            <input
                type="text"
                id="brand_name"
                name="brand_name"
                value="<?php echo $edit_brand ? e($edit_brand['brand_name']) : ''; ?>"
                required>

            <button type="submit" class="btn-primary" style="margin-top: 0.5rem;">
                <?php echo $edit_id > 0 ? 'Update Brand' : 'Add Brand'; ?>
            </button>
        </form>

        <h3 style="margin-top: 2rem;">All Brands</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Brand ID</th>
                    <th>Brand Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $brands = $controller->getAllBrands();
                if (empty($brands)): ?>
                    <tr>
                        <td colspan="3"><em>No brands yet.</em></td>
                    </tr>
                <?php else:
                    foreach ($brands as $brand): ?>
                        <tr>
                            <td><?= e($brand['brand_id']) ?></td>
                            <td><?= e($brand['brand_name']) ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>/views/admin/brand.php?edit_id=<?= e($brand['brand_id']) ?>" class="btn-link">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach;
                endif; ?>
            </tbody>
        </table>
    </section>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
