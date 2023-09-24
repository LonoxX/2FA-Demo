<?php
session_start();

$session_uid = $_SESSION['uid'] ?? '';
$session_googleCode = $_SESSION['googleCode'] ?? '';

if (empty($session_uid) || empty($session_googleCode)) {
    $url = './index.php';
    header("Location: $url");
    exit;
}
?>
