<?php
$page_title = "Edit Transaksi";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM anggota WHERE id = :id");
$stmt->execute(['id' => $id]);
$transaksi = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$transaksi) {
    header('Location: list.php');
    exit;
}
?>
        $hargaSatuan = ($transaksi['jumlah_buku'] > 0) ? ($transaksi['total_transaksi'] / $transaksi['jumlah_buku']) : 0;
        ?>
        <section>
            <h2>Edit Transaksi Pembelian</h2>

            <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <form id="form-tambah" method="post" action="proses_edit.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($transaksi['id']); ?>">
        <p>
            <label for="no_nota">No. Nota / Transaksi</label><br>
            <input type="text" id="no_nota" name="no_nota" value="<?php echo htmlspecialchars($transaksi['no_nota'] ?? ''); ?>">
        </p>
        <p>
            <label for="nama">Nama Pembeli</label><br>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($transaksi['nama_pembeli'] ?? ''); ?>" required>
        </p>
        <p>
            <label for="judul_buku">Judul Buku</label><br>
            <input type="text" id="judul_buku" name="judul_buku" value="<?php echo htmlspecialchars($transaksi['judul_buku'] ?? ''); ?>" required>
        </p>
        <p>
            <label for="penerbit">Nama Penerbit</label><br>
            <input type="text" id="penerbit" name="penerbit" value="<?php echo htmlspecialchars($transaksi['penerbit'] ?? ''); ?>">
        </p>
        <p>
            <label for="harga">Harga Per Buku (Rp)</label><br>
            <input type="number" id="harga" name="harga" value="<?php echo htmlspecialchars($hargaSatuan); ?>">
        </p>
        <p>
            <label for="stok">Jumlah Beli</label><br>
            <input type="number" id="stok" name="stok" value="<?php echo htmlspecialchars($transaksi['jumlah_buku'] ?? 0); ?>">
        </p>
        <p>
            <button type="submit">Update Transaksi</button>
        </p>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
