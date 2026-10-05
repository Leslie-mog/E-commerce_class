<?php
// actions/login_action.php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CustomerController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../views/login.php');
}

$email = trim(strip_tags($_POST['email'] ?? ''));
$pass = $_POST['password'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $pass === '') {
    $_SESSION['error'] = 'Please enter a valid email and password.';
    redirect('../views/login.php');
}

$controller = new CustomerController();
$result = $controller->login($email, $pass);

if (!$result['success']) {
    $_SESSION['error'] = $result['error'];
    $_SESSION['old_email'] = $email;
    redirect('../views/login.php');
}

$c = $result['customer'];
$_SESSION['customer_id'] = (int) $c['customer_id'];
$_SESSION['customer_name'] = $c['customer_name'];
$_SESSION['customer_email'] = $c['customer_email'];
$_SESSION['user_role'] = (int) $c['user_role'];
$_SESSION['success'] = 'Welcome back, ' . $c['customer_name'] . '!';

redirect(BASE_URL . '/index.php');
?>