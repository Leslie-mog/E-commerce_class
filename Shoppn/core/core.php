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
    $app_root = realpath(__DIR__ . '/..');
    $script_file = realpath($_SERVER['SCRIPT_FILENAME'] ?? '');
    $script_name = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');

    if ($app_root !== false && $script_file !== false && strpos($script_file, $app_root . DIRECTORY_SEPARATOR) === 0) {
        $relative_script = str_replace(DIRECTORY_SEPARATOR, '/', substr($script_file, strlen($app_root) + 1));
        $script_suffix = '/' . $relative_script;
        $base_url = substr($script_name, -strlen($script_suffix)) === $script_suffix
            ? substr($script_name, 0, -strlen($script_suffix))
            : '';
    } else {
        $base_url = '';
    }

    define('BASE_URL', rtrim($base_url, '/'));
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