<?php
// actions/add_brand_action.php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Invalid request method.';
    redirect(BASE_URL . '/views/admin/brand.php');
}

$brand_name = trim($_POST['brand_name'] ?? '');

if (empty($brand_name)) {
    $_SESSION['error'] = 'Brand name cannot be empty.';
    redirect(BASE_URL . '/views/admin/brand.php');
}

$controller = new ProductController();
$ok = $controller->addBrand($brand_name);

if (!$ok) {
    $_SESSION['error'] = 'Could not add brand. Please try again.';
} else {
    $_SESSION['success'] = 'Brand added successfully.';
}

redirect(BASE_URL . '/views/admin/brand.php');
?>
