<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$judul = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tahun     = $_POST['tahun'] ?? '';
$harga     = $_POST['harga'] ?? '';
$stok      = $_POST['stok'] ?? '';
$kategori  = trim($_POST['kategori'] ?? '');

// Validasi server-side — wajib ada meski sudah divalidasi JS di Jobsheet 5,
// karena validasi client bisa dilewati (nonaktifkan JS / kirim request manual).
$errors = [];
if ($judul === '') {
    $errors[] = "Judul buku wajib diisi.";
}
if ($pengarang === '') {
    $errors[] = "Pengarang wajib diisi.";
}
if (!is_numeric($tahun) || $tahun < 1900 || $tahun > (int)date('Y')) {
    $errors[] = "Tahun terbit harus berupa angka di antara 1900 - " . date('Y') . ".";
}
if (!is_numeric($harga) || $harga < 0) {
    $errors[] = "Harga tidak boleh negatif.";
}
if (!is_numeric($stok) || $stok < 0) {
    $errors[] = "Stok tidak boleh negatif.";
}
if ($kategori === '') {
    $errors[] = "Kategori wajib dipilih.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

$stmtCount = $pdo->query("SELECT COUNT(*) FROM buku");
$nextId = $stmtCount->fetchColumn() + 1;
$kodeBuku = 'BK-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

// Simpan ke PostgreSQL menggunakan Prepared Statement
$stmt = $pdo->prepare(
    "INSERT INTO buku (kode, judul, pengarang, tahun, kategori, harga, stok)
     VALUES (:kode, :judul, :pengarang, :tahun, :kategori, :harga, :stok)
     RETURNING id"
);

$stmt->execute([
    'kode'      => $kodeBuku,
    'judul'     => $judul,
    'pengarang' => $pengarang,
    'tahun'     => (int) $tahun,
    'harga'     => (int) $harga,
    'stok'      => (int) $stok,
    'kategori'  => $kategori,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Buku berhasil ditambahkan.'];
header('Location: list.php');
exit;
