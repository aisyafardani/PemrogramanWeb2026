<?php
$page_title = "Tambah Anggota";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

        <section>
            <h2>Tambah Transaksi Pembelian</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
            <?php endif; ?>

            <form id="form-tambah" method="post" action="proses_tambah.php">
                <p>
                    <label for="no_nota">No. Nota / Transaksi</label><br>
                    <input type="text" id="no_nota" name="no_nota">
                </p>
                <p>
                    <label for="nama">Nama Pembeli / Anggota</label><br>
                    <input type="text" id="nama" name="nama">
                </p>
                <p>
                    <label for="judul_buku">Judul Buku</label><br>
                    <input type="text" id="judul_buku" name="judul_buku">
                </p>
                <p>
                    <label for="penerbit">Nama Penerbit</label><br>
                    <input type="text" id="penerbit" name="penerbit">
                </p>
                <p>
                    <label for="stok">Jumlah Beli</label><br>
                    <input type="number" id="stok" name="stok">
                </p>
                <p>
                    <button type="submit">Simpan Transaksi</button>
                </p>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
