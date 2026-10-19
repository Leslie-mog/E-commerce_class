<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();
$redirectUrl = BASE_URL . '/views/admin/product.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Invalid request method.';
    redirect($redirectUrl);
}

$title = trim($_POST['product_title'] ?? '');
$description = trim($_POST['product_desc'] ?? '');
$keywords = trim($_POST['product_keywords'] ?? '');
$price = filter_var($_POST['product_price'] ?? null, FILTER_VALIDATE_FLOAT);
$category = filter_input(INPUT_POST, 'product_cat', FILTER_VALIDATE_INT) ?: 0;
$brand = filter_input(INPUT_POST, 'product_brand', FILTER_VALIDATE_INT) ?: 0;

if ($title === '' || $description === '' || $keywords === '' || $price === false || $price < 0 || $category <= 0 || $brand <= 0) {
    $_SESSION['error'] = 'Complete all product fields with valid values.';
    redirect($redirectUrl);
}

$file = $_FILES['product_image'] ?? null;
$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$maxFileSize = 5 * 1024 * 1024;
if (!$file || $file['error'] !== UPLOAD_ERR_OK || $file['size'] > $maxFileSize) {
    $_SESSION['error'] = 'Choose an image no larger than 5 MiB.';
    redirect($redirectUrl);
}

$fileInfo = new finfo(FILEINFO_MIME_TYPE);
$mimeType = $fileInfo->file($file['tmp_name']);
if (!in_array($mimeType, $allowedMimeTypes, true)) {
    $_SESSION['error'] = 'The image must be a JPEG, PNG, GIF, or WebP file.';
    redirect($redirectUrl);
}

$extensions = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];
$originalName = pathinfo(basename($file['name']), PATHINFO_FILENAME);
$safeName = preg_replace('/[^A-Za-z0-9_-]/', '_', $originalName);
$filename = uniqid() . '_' . ($safeName ?: 'product') . '.' . $extensions[$mimeType];
$uploadDirectory = __DIR__ . '/../images/Products/';
$directoryCreated = is_dir($uploadDirectory) || (@mkdir($uploadDirectory, 0755, true) && is_dir($uploadDirectory));
if (!$directoryCreated) {
    error_log('Product image directory is missing and could not be created: ' . $uploadDirectory);
    $_SESSION['error'] = 'The image folder is missing and the server could not create it.';
    redirect($redirectUrl);
}
if (!is_writable($uploadDirectory)) {
    error_log('Product image directory is not writable: ' . $uploadDirectory);
    $_SESSION['error'] = 'The image folder is not writable by the server. Contact your hosting provider.';
    redirect($redirectUrl);
}
if (!move_uploaded_file($file['tmp_name'], $uploadDirectory . $filename)) {
    error_log('Could not move uploaded product image into: ' . $uploadDirectory);
    $_SESSION['error'] = 'The server could not save the uploaded image. Check the server upload configuration.';
    redirect($redirectUrl);
}

$controller = new ProductController();
if (!$controller->addProduct($category, $brand, $title, (float) $price, $description, $filename, $keywords)) {
    @unlink($uploadDirectory . $filename);
    $_SESSION['error'] = 'Could not add the product. Please try again.';
    redirect($redirectUrl);
}

$_SESSION['success'] = 'Product added successfully.';
redirect($redirectUrl);