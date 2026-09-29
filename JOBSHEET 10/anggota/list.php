<?php
$page_title = "Daftar Anggota";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$perPage = 5;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;
$keyword = trim($_GET['q'] ?? '');

if ($keyword !== '') {
    $hitung = $pdo->prepare("SELECT COUNT(*) FROM anggota WHERE nama_pembeli ILIKE :kw OR judul_buku ILIKE :kw");
    $hitung->execute(['kw' => '%' . $keyword . '%']);
    $totalRows = $hitung->fetchColumn();

    $stmt = $pdo->prepare("SELECT * FROM anggota WHERE nama_pembeli ILIKE :kw OR judul_buku ILIKE :kw ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue('kw', '%' . $keyword . '%');
} else {
    $totalRows = $pdo->query("SELECT COUNT(*) FROM anggota")->fetchColumn();
    $stmt = $pdo->prepare("SELECT * FROM anggota ORDER BY id DESC LIMIT :limit OFFSET :offset");
}

$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$daftarTransaksi = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalPages = max(1, (int) ceil($totalRows / $perPage));
?>
        <section>
            <h2>Daftar Trasaksi Pembelian</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
            <?php endif; ?>

            <div class="search-box">
                <form method="get" action="list.php">
                    <span>
                        <label for="search-input">Cari Nama Anggota</label><br>
                        <input type="text" id="search-input" name="q" value="<?php echo $keyword; ?>" placeholder="Ketik nama anggota...">
                    </span>
                    <button type="submit">Cari</button>
                </form>
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
                        <td colspan="6">Belum ada data transaksi. Silakan tambah lewat menu "Tambah Transaksi".</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($daftarAnggota as $anggota): ?>
                        <tr>
                            <td><?php echo $anggota['no_nota']; ?></td>
                            <td><?php echo $anggota['nama_pembeli']; ?></td>
                            <td><?php echo $anggota['judul_buku']; ?></td>
                            <td><?php echo $anggota['jumlah_buku']; ?></td>
                            <td><?php echo $anggota['total_transaksi']; ?></td>
                            <td>
                                 <a href="edit.php?id=<?php echo $anggota['id']; ?>" class="btn-edit">Edit</a>
                                <form class="form-hapus" method="post" action="hapus.php">
                                    <input type="hidden" name="id" value="<?php echo $anggota['id']; ?>">
                                    <button type="submit" class="btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            </div>

            <nav class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="list.php?page=<?php echo $i; ?><?php echo $keyword !== '' ? '&q=' . urlencode($keyword) : ''; ?>"
                   class="<?php echo $i === $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
            </nav>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
