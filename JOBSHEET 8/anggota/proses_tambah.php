<?php
session_start();

$noNota = trim($_POST['no_nota'] ?? '');
$nama = trim($_POST['nama'] ?? '');
$judulBuku = trim($_POST['judul_buku'] ?? '');
$penerbit = trim($_POST['penerbit'] ?? '');
$stok = trim($_POST['stok'] ?? '');
$harga = trim($_POST['harga'] ?? 0);

$errors = [];
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}
if ($judulBuku === '') {
    $errors[] = "Judul Buku wajib diisi.";
}

if (!is_numeric($stok) || $stok <= 0) {
    $errors[] = "Jumlah beli/stok wajib berupa angka lebih dari 0.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

if (!isset($_SESSION['anggota'])) {
    $_SESSION['anggota'] = [];
}

if ($noNota === '') {
    $nextId = count($_SESSION['anggota']) + 1;
    $noNota = 'NOTA-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
}

$_SESSION['anggota'][] = [
    'no_nota'         => $noNota,
    'nama_pembeli'    => $nama,
    'judul_buku'      => $judulBuku,
    'penerbit'        => $penerbit,
    'jumlah_buku'     => (int) $stok,
    'total_transaksi' => (int) $stok * (int) $harga, // atau dikalkulasikan sesuai harga per buku
];

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Transaksi berhasil ditambahkan.'];
header('Location: list.php');
exit;