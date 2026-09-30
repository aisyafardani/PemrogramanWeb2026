<?php
$page_title = "Beranda";
include __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/koneksi.php';

$totalBuku = $pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn();
$totalPelanggan = $pdo->query("SELECT COUNT(DISTINCT nama_pembeli) FROM anggota")->fetchColumn();
$totalTransaksi = $pdo->query("SELECT COUNT(*) FROM anggota")->fetchColumn();
$totalPenjualan = $pdo->query("SELECT COALESCE(SUM(total_transaksi), 0) FROM anggota")->fetchColumn();

$penjualanPerKategori = $pdo->query("
    SELECT 
        b.kategori, 
        COALESCE(SUM(a.jumlah_buku), 0) AS total_buku_terjual,
        COUNT(a.id) AS total_transaksi
    FROM anggota a
    JOIN buku b ON a.judul_buku = b.judul
    GROUP BY b.kategori
    ORDER BY total_buku_terjual DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

        <section>
            <h2>Selamat Datang di Sistem Pembelian Buku</h2>
            <p>Aplikasi sederhana untuk mengelola data produk dan transaksi pembelian buku.</p>
        </section>

        <section>
            <h2>Laporan Penjualan</h2>
            <div class="dashboard-cards">
                <article>
                    <h3>Total Produk</h3>
                    <p><?php echo $totalBuku; ?></p>
                </article>
                <article>
                    <h3>Total Pelanggan</h3>
                    <p><?php echo $totalPelanggan; ?></p>
                </article>
                <article>
                    <h3>Total Transaksi</h3>
                    <p><?php echo $totalTransaksi; ?></p>
                </article>
                <article>
                    <h3>Total Penjualan</h3>
                    <p>Rp <?php echo number_format($totalPenjualan, 0, ',', '.'); ?></p>
                </article>
            </div>
        </section>

        <section style="margin-top: 25px;">
            <h2>Penjualan Berdasarkan Kategori Buku</h2>
            <?php if (empty($penjualanPerKategori)): ?>
                <p>Belum ada transaksi penjualan.</p>
            <?php else: ?>
                <div class="kategori-cards">
                    <?php foreach ($penjualanPerKategori as $row): ?>
                        <article class="card-kategori">
                            <h3><?php echo htmlspecialchars(ucwords($row['kategori'])); ?></h3>
                            <p class="jumlah-terjual"><?php echo $row['total_buku_terjual']; ?> Buku Terjual</p>
                            <span class="total-transaksi"><?php echo $row['total_transaksi']; ?>x Transaksi</span>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

<?php include __DIR__ . '/includes/footer.php'; ?>
