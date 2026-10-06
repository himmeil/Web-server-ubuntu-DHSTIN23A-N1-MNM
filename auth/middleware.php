<?php
// auth/middleware.php

session_start();

/**
 * Kiểm tra user đã login chưa
 */
function requireLogin() {
    if (!isset($_SESSION['user'])) {
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        header("Location: /auth/login.php");
        exit;
    }
}

/**
 * Kiểm tra admin
 */
function requireAdmin() {
    requireLogin();
    if ($_SESSION['user']['role'] !== 'admin') {
        http_response_code(403);
        die("Truy cập bị từ chối. Bạn không có quyền admin.");
    }
}

/**
 * Kiểm tra customer
 */
function requireCustomer() {
    requireLogin();
    if ($_SESSION['user']['role'] !== 'customer') {
        header("Location: /admin/dashboard.php");
        exit;
    }
}

/**
 * Lấy thông tin user hiện tại
 */
function currentUser() {
    return $_SESSION['user'] ?? null;
}

/**
 * Kiểm tra đã login chưa (boolean)
 */
function isLoggedIn() {
    return isset($_SESSION['user']);
}

/**
 * Kiểm tra là admin không (boolean)
 */
function isAdmin() {
    return isLoggedIn() && $_SESSION['user']['role'] === 'admin';
}
?>