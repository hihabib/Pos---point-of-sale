<?php
require_once __DIR__ . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username === '' || $password === '') {
    header('Location: index.php');
    exit;
}

$u = $conn->real_escape_string($username);
$p = md5($password);

$sql = "SELECT id, username, role FROM users WHERE username='$u' AND password='$p' LIMIT 1";
$res = $conn->query($sql);
if ($res && $res->num_rows === 1) {
    $row = $res->fetch_assoc();
    $_SESSION['user'] = $row;
    if ($row['role'] === 'manager') {
        header('Location: manager_products.php');
        exit;
    } else {
        header('Location: outlet.php');
        exit;
    }
}

header('Location: index.php');
exit;
