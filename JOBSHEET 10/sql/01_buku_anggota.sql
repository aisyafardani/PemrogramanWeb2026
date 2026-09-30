-- 1. Tabel Buku 
CREATE TABLE IF NOT EXISTS buku (
    id SERIAL PRIMARY KEY,
    kode VARCHAR(50) NOT NULL UNIQUE,
    judul VARCHAR(255) NOT NULL,
    pengarang VARCHAR(255) NOT NULL,
    tahun INTEGER NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    harga INTEGER NOT NULL DEFAULT 0,
    stok INTEGER NOT NULL DEFAULT 0
);


-- 2. Tabel Transaksi / Anggota ota kamu)
CREATE TABLE IF NOT EXISTS anggota (
    id SERIAL PRIMARY KEY,
    no_nota VARCHAR(50) NOT NULL UNIQUE,
    nama_pembeli VARCHAR(255) NOT NULL,
    judul_buku VARCHAR(255) NOT NULL,
    penerbit VARCHAR(255),
    jumlah_buku INTEGER NOT NULL DEFAULT 1,
    total_transaksi INTEGER NOT NULL DEFAULT 0
);
