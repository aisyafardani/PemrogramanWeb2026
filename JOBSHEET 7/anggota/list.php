<?php
$page_title = "Daftar Anggota";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
$daftarAnggota = $_SESSION['anggota'] ?? [];
?>
        <section>
            <h2>Daftar Trasaksi Pembelian</h2>
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
                    <!-- Baris akan diisi dinamis oleh assets/js/anggota.js via fetch('../data/anggota.json') -->
                </tbody>
            </table>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 TOKU-Mini &mdash; Jobsheet 6</p>
    </footer>
    <script src="../assets/js/app.js"></script>
    <script src="../assets/js/anggota.js"></script>
</body>
</html>
