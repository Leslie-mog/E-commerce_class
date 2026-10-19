<?php
// actions/register_action.php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CustomerController.php';

// 1. POST only
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../views/register.php');
}

// 2. Collect + sanitize
$name = trim(strip_tags($_POST['name'] ?? ''));
$email = trim(strip_tags($_POST['email'] ?? ''));
$pass = $_POST['password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';
$country = trim(strip_tags($_POST['country'] ?? ''));
$city = trim(strip_tags($_POST['city'] ?? ''));
$contact = trim(strip_tags($_POST['contact'] ?? ''));

// 3. Validate
$errors = [];

if (strlen($name) < 2) {
    $errors[] = 'Full name must be at least 2 characters.';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address.';
}
if (strlen($email) > 50) {           // matches customer_email VARCHAR(50)
    $errors[] = 'Email must be 50 characters or fewer.';
}
if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9\s]).{8,}$/', $pass)) {
    $errors[] = 'Password must be 8+ characters and include uppercase and lowercase letters, a number, and a special character.';
}
if ($pass !== $confirm) {
    $errors[] = 'Passwords do not match.';
}
if ($country === '') {
    $errors[] = 'Please select a country.';
}
if ($city === '') {
    $errors[] = 'Please enter your city.';
}
if (!preg_match('/^[0-9+\-\s]{7,15}$/', $contact)) {
    $errors[] = 'Contact number must be 7–15 digits.';
}

if (!empty($errors)) {
    $_SESSION['error'] = implode(' ', $errors);
    $_SESSION['old'] = compact('name', 'email', 'country', 'city', 'contact');
    redirect('../views/register.php');
}

// 4. Call controller
$controller = new CustomerController();
$result = $controller->register([
    'name' => $name,
    'email' => $email,
    'password' => $pass,
    'country' => $country,
    'city' => $city,
    'contact' => $contact,
]);

// 5. Handle result
if (!$result['success']) {
    $_SESSION['error'] = $result['error'];
    $_SESSION['old'] = compact('name', 'email', 'country', 'city', 'contact');
    redirect('../views/register.php');
}

// 6. Success → require the customer to log in
$_SESSION['success'] = 'Your account has been created. Please log in.';
redirect(BASE_URL . '/views/login.php');
?>