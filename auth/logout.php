<?php
// auth/logout.php
session_start();

$_SESSION = array();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

session_destroy();

if (isset($_COOKIE['remember_token'])) {
    setcookie('remember_token', '', time() - 3600, '/', '', true, true);
}

// Sửa: Về trang chủ (lên 1 cấp từ auth/ ra root)
header("Location: ../index.php");
exit;
?>