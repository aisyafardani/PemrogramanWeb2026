<?php
$page_title = "Daftar Anggota";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
$daftarAnggota = $_SESSION['anggota'] ?? [];
?>
        <section>
            <h2>Daftar Trasaksi Pembelian</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
            <?php endif; ?>

            <div class="search-box">
                <label for="search-input">Cari Nama Pembeli</label>
                <input type="text" id="search-input" placeholder="Ketik nama anggota...">
            </div>

            <p id="loading-indicator" style="display:none; text-align:center; margin-bottom:1rem;">Memuat data...</p>
            <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No. Nota</th>
                        <th>Nama Pembeli</th>
                        <th>Judul Buku</th>
                        <th>Jumlah Buku</th>
                        <th>Total Transaksi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
        
                <?php if (empty($daftarAnggota)): ?>
                    <tr>
                        <td colspan="5">Belum ada data transaksi. Silakan tambah lewat menu "Tambah Transaksi".</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($daftarAnggota as $anggota): ?>
                        <tr>
                            <td><?php echo $anggota['no_nota']; ?></td>
                            <td><?php echo $anggota['nama']; ?></td>
                            <td><?php echo $anggota['judul_buku']; ?></td>
                            <td><?php echo $anggota['penerbit']; ?></td>
                            <td><?php echo $anggota['jumlah']; ?></td>
                            <td><?php echo $anggota['total']; ?></td>
                            <td>
                                <button type="button">Edit</button>
                                <button type="button" class="btn-hapus">Hapus</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            </div>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
