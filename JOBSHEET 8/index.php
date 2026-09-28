<?php
$page_title = "Beranda";
include __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/koneksi.php';

$totalBuku = $pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn();
$totalAnggota = $pdo->query("SELECT COUNT(*) FROM anggota")->fetchColumn();
?>

        <section>
            <h2>Selamat Datang di Sistem Pembelian Buku</h2>
            <p>Aplikasi sederhana untuk mengelola data produk dan transaksi pembelian buku.</p>
        </section>

        <section>
            <h2>Ringkasan</h2>
            <div class="dashboard-cards">
                <article>
                    <h3>Total Stok Buku</h3>
                    <p><?php echo $totalBuku; ?></p>
                </article>
                <article>
                    <h3>Total Transaksi</h3>
                    <p><?php echo $totalAnggota; ?></p>
                </article>
                <article>
                    <h3>Buku Terjual</h3>
                    <p>0</p>
                </article>
            </div>
        </section>
<?php include __DIR__ . '/includes/footer.php'; ?>
