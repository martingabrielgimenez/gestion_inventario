<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../auth/login.php');
    exit;
}

function isAdmin() {
    return $_SESSION['user']['role'] === 'admin';
}
