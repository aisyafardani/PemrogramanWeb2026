<?php
$host = getenv('DB_HOST') ?: 'ep-aged-cake-b48l14co-pooler.c-6.us-east-2.aws.neon.tech';
$port = getenv('DB_PORT') ?: '5432';
$db   = getenv('DB_NAME') ?: 'neondb';
$user = getenv('DB_USER') ?: 'neondb_owner';
$pass = getenv('DB_PASSWORD') ?: 'npg_xTJorXn97OdH';

// Ambil Endpoint ID (bagian paling depan dari host)
// Contoh: 'ep-aged-cake-b48l14co' dari 'ep-aged-cake-b48l14co-pooler...'
$endpointId = explode('.', $host)[0];

try {
    // Tambahkan parameter options=endpoint=... pada DSN
    $dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require;options=endpoint=$endpointId";
    
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Koneksi database berhasil!";
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}