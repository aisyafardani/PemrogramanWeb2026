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
                <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #f2f2f2; text-align: left;">
                            <th>Kategori Buku</th>
                            <th>Jumlah Terjual (Eksemplar)</th>
                            <th>Total Transaksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($penjualanPerKategori as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                                <td><?php echo $row['total_buku_terjual']; ?> Buku</td>
                                <td><?php echo $row['total_transaksi']; ?> Kali</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>

<?php include __DIR__ . '/includes/footer.php'; ?>
