<?php
// actions/update_category_action.php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Invalid request method.';
    redirect(BASE_URL . '/views/admin/category.php');
}

$cat_id = (int) ($_POST['cat_id'] ?? 0);
$cat_name = trim($_POST['cat_name'] ?? '');

if ($cat_id <= 0) {
    $_SESSION['error'] = 'Invalid category ID.';
    redirect(BASE_URL . '/views/admin/category.php');
}

if (empty($cat_name)) {
    $_SESSION['error'] = 'Category name cannot be empty.';
    redirect(BASE_URL . '/views/admin/category.php');
}

$controller = new ProductController();
$ok = $controller->updateCategory($cat_id, $cat_name);

if (!$ok) {
    $_SESSION['error'] = 'Could not update category. Please try again.';
} else {
    $_SESSION['success'] = 'Category updated successfully.';
}

redirect(BASE_URL . '/views/admin/category.php');
?>
