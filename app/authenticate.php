<?php
include('functions.php');

$username = $_GET['username'] ?? '';
$password = $_GET['password'] ?? '';

$config = getConfigData();

if (isset($config['user']) && $password == $config['password']) {
    $_SESSION['username'] = $username;
    header('Location: dashboard.php');
    exit;
} else {
    header('Location: login.php?error=true');
    exit;
}