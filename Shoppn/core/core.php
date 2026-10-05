<?php
// core/core.php

// --- Error logging setup ---
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../error/error.log');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// --- Session ---
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!defined('BASE_URL')) {
    define('BASE_URL', '/Shoppn');
}
// --- Timezone ---
date_default_timezone_set('Africa/Accra');   // adjust to your region

// --- Load DB base class ---
require_once __DIR__ . '/db_class.php';

// --- Shared helpers ---

/**
 * Get the client's IP address.
 */
function get_ip(): string
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    }
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}
if (!defined('BASE_URL')) {
    define('BASE_URL', '/shoppn');   // adjust if your folder name differs
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

/**
 * Is a customer logged in?
 */
function is_logged_in(): bool
{
    return isset($_SESSION['customer_id']);
}

/**
 * Is the current user an admin?
 */
function is_admin(): bool
{
    return isset($_SESSION['user_role']) && (int) $_SESSION['user_role'] === 1;
}

/**
 * Force login — redirect to login page if not logged in.
 */
function require_login(): void
{
    if (!is_logged_in()) {
        $_SESSION['error'] = 'Please log in to continue.';
        redirect('../views/login.php');
    }
}

/**
 * Force admin — redirect home if not admin.
 */
function require_admin(): void
{
    if (!is_admin()) {
        $_SESSION['error'] = 'Admin access required.';
        redirect('../index.php');
    }
}

/**
 * Escape output for HTML.
 */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
?>