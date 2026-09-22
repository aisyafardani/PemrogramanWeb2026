<?php
session_start();

$judul = trim($_POST['judul'] ?? '');
$kategori = trim($_POST['kategori'] ?? '');
$harga = ($_POST['harga'] ?? '');
$stok = ($_POST['stok'] ?? '');

// Validasi server-side — wajib ada meski sudah divalidasi JS di Jobsheet 5,
// karena validasi client bisa dilewati (nonaktifkan JS / kirim request manual).
$errors = [];
if ($judul === '') {
    $errors[] = "Judul wajib diisi.";
}
if ($kategori === '') {
    $errors[] = "Kategori wajib diisi.";
}
if (!is_numeric($harga) || $harga < 0) {
    $errors[] = "Harga harus berupa angka dan tidak boleh negatif.";
}
if (!is_numeric($stok) || $stok < 0) {
    $errors[] = "Stok harus berupa angka dan tidak boleh negatif.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

if (!isset($_SESSION['buku'])) {
    $_SESSION['buku'] = [];
}

$nextId   = count($_SESSION['buku']) + 1;
$kodeBuku = 'BK-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

$_SESSION['buku'][] = [
    'kode'     => $kodeBuku,
    'judul'    => $judul,
    'kategori' => $kategori,
    'harga'    => (int) $harga,
    'stok'     => (int) $stok,
];

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Buku berhasil ditambahkan.'];
header('Location: list.php');
exit;
