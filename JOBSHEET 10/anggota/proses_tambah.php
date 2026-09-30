<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/koneksi.php';

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

if ($noNota === '') {
    $stmtLast = $pdo->query("SELECT MAX(id) FROM anggota");
    $lastId = $stmtLast->fetchColumn();
    $nextId = $lastId ? $lastId + 1 : 1;
    $no_nota = 'NOTA-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
}

$totalTransaksi = (int) $stok * (int) $harga;

// Simpan ke PostgreSQL menggunakan Prepared Statement
$stmt = $pdo->prepare(
    "INSERT INTO anggota (no_nota, nama_pembeli, judul_buku, penerbit, jumlah_buku, total_transaksi)
     VALUES (:no_nota, :nama_pembeli, :judul_buku, :penerbit, :jumlah_buku, :total_transaksi)
     RETURNING id"
);

$stmt->execute([
    'no_nota'         => $noNota,
    'nama_pembeli'    => $nama,
    'judul_buku'      => $judulBuku,
    'penerbit'        => $penerbit,
    'jumlah_buku'     => (int) $stok,
    'total_transaksi' => $totalTransaksi,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Transaksi berhasil ditambahkan.'];
header('Location: list.php');
exit;