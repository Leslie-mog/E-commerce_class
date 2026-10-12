<?php
// views/admin/category.php
require_once __DIR__ . '/../../core/core.php';
require_once __DIR__ . '/../../controllers/ProductController.php';

require_admin();

$controller = new ProductController();
$edit_category = null;
$edit_id = (int) ($_GET['edit_id'] ?? 0);

if ($edit_id > 0) {
    $edit_category = $controller->getCategoryById($edit_id);
}
?>
<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="content-wrapper">
    <?php require_once __DIR__ . '/../layout/sidebar.php'; ?>

    <section class="main-content">
        <h2><?php echo $edit_id > 0 ? 'Edit Category' : 'Add Category'; ?></h2>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= e($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error"><?= e($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST" action="<?php echo $edit_id > 0 ? BASE_URL . '/actions/update_category_action.php' : BASE_URL . '/actions/add_category_action.php'; ?>">
            <?php if ($edit_id > 0 && $edit_category): ?>
                <input type="hidden" name="cat_id" value="<?= e($edit_category['cat_id']) ?>">
            <?php endif; ?>

            <label for="cat_name">Category Name:</label>
            <input
                type="text"
                id="cat_name"
                name="cat_name"
                value="<?php echo $edit_category ? e($edit_category['cat_name']) : ''; ?>"
                required>

            <button type="submit" class="btn-primary" style="margin-top: 0.5rem;">
                <?php echo $edit_id > 0 ? 'Update Category' : 'Add Category'; ?>
            </button>
        </form>

        <h3 style="margin-top: 2rem;">All Categories</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $categories = $controller->getAllCategories();
                if (empty($categories)): ?>
                    <tr>
                        <td colspan="3"><em>No categories yet.</em></td>
                    </tr>
                <?php else:
                    foreach ($categories as $category): ?>
                        <tr>
                            <td><?= e($category['cat_id']) ?></td>
                            <td><?= e($category['cat_name']) ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>/views/admin/category.php?edit_id=<?= e($category['cat_id']) ?>" class="btn-link">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach;
                endif; ?>
            </tbody>
        </table>
    </section>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
