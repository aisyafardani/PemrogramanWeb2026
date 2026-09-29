<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$id        = $_POST['id'] ?? null;
$noNota    = trim($_POST['no_nota'] ?? '');
$nama      = trim($_POST['nama'] ?? '');
$judulBuku = trim($_POST['judul_buku'] ?? '');
$penerbit  = trim($_POST['penerbit'] ?? '');
$stok      = trim($_POST['stok'] ?? '');
$harga     = trim($_POST['harga'] ?? 0);

if (!$id) {
    header('Location: list.php');
    exit;
}

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
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$totalTransaksi = (int) $stok * (int) $harga;

$stmt = $pdo->prepare(
    "UPDATE anggota 
     SET no_nota = :no_nota, nama_pembeli = :nama_pembeli, judul_buku = :judul_buku, 
         penerbit = :penerbit, jumlah_buku = :jumlah_buku, total_transaksi = :total_transaksi 
     WHERE id = :id"
);

$stmt->execute([
    'no_nota'         => $noNota,
    'nama_pembeli'    => $nama,
    'judul_buku'      => $judulBuku,
    'penerbit'        => $penerbit,
    'jumlah_buku'     => (int) $stok,
    'total_transaksi' => $totalTransaksi,
    'id'              => $id,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Transaksi berhasil diperbarui.'];
header('Location: list.php');
exit;
