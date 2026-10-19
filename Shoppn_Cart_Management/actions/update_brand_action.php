<?php
// actions/update_brand_action.php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Invalid request method.';
    redirect(BASE_URL . '/views/admin/brand.php');
}

$brand_id = (int) ($_POST['brand_id'] ?? 0);
$brand_name = trim($_POST['brand_name'] ?? '');

if ($brand_id <= 0) {
    $_SESSION['error'] = 'Invalid brand ID.';
    redirect(BASE_URL . '/views/admin/brand.php');
}

if (empty($brand_name)) {
    $_SESSION['error'] = 'Brand name cannot be empty.';
    redirect(BASE_URL . '/views/admin/brand.php');
}

$controller = new ProductController();
$ok = $controller->updateBrand($brand_id, $brand_name);

if (!$ok) {
    $_SESSION['error'] = 'Could not update brand. Please try again.';
} else {
    $_SESSION['success'] = 'Brand updated successfully.';
}

redirect(BASE_URL . '/views/admin/brand.php');
?>
