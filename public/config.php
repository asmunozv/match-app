<?php
session_start();

$db = new mysqli(
    getenv('DB_HOST') ?: 'db',
    getenv('DB_USER') ?: 'matchuser',
    getenv('DB_PASS') ?: 'matchpass',
    getenv('DB_NAME') ?: 'matchapp'
);
if ($db->connect_errno) {
    http_response_code(500);
    die("No se pudo conectar a la base de datos.");
}
$db->set_charset("utf8mb4");

function e($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}
function require_login() {
    if (empty($_SESSION['user_id'])) {
        header('Location: index.php');
        exit;
    }
}
