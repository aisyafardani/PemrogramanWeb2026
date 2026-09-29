<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$id        = $_POST['id'] ?? null;
$kodeBuku  = trim($_POST['kode_buku'] ?? '');
$judul     = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tahun     = $_POST['tahun'] ?? '';
$harga     = $_POST['harga'] ?? '';
$stok      = $_POST['stok'] ?? '';
$kategori  = trim($_POST['kategori'] ?? '');

if (!$id) {
    header('Location: list.php');
    exit;
}

$errors = [];
if ($judul === '') {
    $errors[] = "Judul wajib diisi.";
}
if ($pengarang === '') {
    $errors[] = "Pengarang wajib diisi.";
}
if (!is_numeric($tahun) || $tahun < 1900 || $tahun > 2026) {
    $errors[] = "Tahun harus di antara 1900-2026.";
}
if (!is_numeric($harga) || $harga < 0) {
    $errors[] = "Harga tidak boleh negatif.";
}
if (!is_numeric($stok) || $stok < 0) {
    $errors[] = "Stok tidak boleh negatif.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$stmt = $pdo->prepare(
    "UPDATE buku 
     SET kode = :kode, judul = :judul, pengarang = :pengarang, tahun = :tahun, harga = :harga, stok = :stok, kategori = :kategori 
     WHERE id = :id"
);
$stmt->execute([
    'kode'      => $kodeBuku,
    'judul'     => $judul,
    'pengarang' => $pengarang,
    'tahun'     => (int) $tahun,
    'harga'     => (int) $harga,
    'stok'      => (int) $stok,
    'kategori'  => $kategori,
    'id'        => $id,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Buku berhasil diperbarui.'];
header('Location: list.php');
exit;
