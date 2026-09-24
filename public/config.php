<?php
session_start();

$url = getenv('DATABASE_URL');
if (!$url) {
    http_response_code(500);
    die('DATABASE_URL no está configurada.');
}

$parts = parse_url($url);
if (!$parts || empty($parts['host']) || empty($parts['user']) || empty($parts['pass'])) {
    http_response_code(500);
    die('DATABASE_URL no es válida.');
}

$host = $parts['host'];
$port = $parts['port'] ?? 5432;
$dbname = ltrim($parts['path'] ?? '/postgres', '/');
$user = urldecode($parts['user']);
$pass = urldecode($parts['pass']);

try {
    $pdo = new PDO(
        "pgsql:host={$host};port={$port};dbname={$dbname};sslmode=require",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (Throwable $e) {
    http_response_code(500);
    die('No se pudo conectar a la base de datos.');
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function require_login() {
    if (empty($_SESSION['user_id'])) {
        header('Location: index.php');
        exit;
    }
}
