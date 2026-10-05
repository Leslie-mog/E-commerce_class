<?php
// actions/add_category_action.php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Invalid request method.';
    redirect(BASE_URL . '/views/admin/category.php');
}

$cat_name = trim($_POST['cat_name'] ?? '');

if (empty($cat_name)) {
    $_SESSION['error'] = 'Category name cannot be empty.';
    redirect(BASE_URL . '/views/admin/category.php');
}

$controller = new ProductController();
$ok = $controller->addCategory($cat_name);

if (!$ok) {
    $_SESSION['error'] = 'Could not add category. Please try again.';
} else {
    $_SESSION['success'] = 'Category added successfully.';
}

redirect(BASE_URL . '/views/admin/category.php');
?>
