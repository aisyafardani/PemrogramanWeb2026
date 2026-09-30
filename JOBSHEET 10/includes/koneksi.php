<?php
$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: '5433';
$db   = getenv('DB_NAME') ?: 'toku_mini';
$user = getenv('DB_USER') ?: 'postgres';
$pass = getenv('DB_PASSWORD') ?: 'ais123';

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}