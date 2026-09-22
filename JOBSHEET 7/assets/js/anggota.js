// Mengambil & menampilkan Daftar Anggota secara asinkron dari data/anggota.json
async function muatDaftarAnggota() {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");
    if (!tbody) return;

    loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        await new Promise((resolve) => setTimeout(resolve, 600));

        const res = await fetch("../data/anggota.json");
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }
        const daftarTransaksi = await res.json();

        daftarTransaksi.forEach(function (item) {
            const tr = document.createElement("tr");
            tr.innerHTML =
                "<td>" + item.no_nota + "</td>" +
                "<td>" + item.nama_pembeli + "</td>" +
                "<td>" + item.judul_buku + "</td>" +
                "<td>" + item.jumlah_buku + "</td>" +
                "<td>Rp " + item.total_transaksi.toLocaleString("id-ID") + "</td>" +
                "<td>" +
                "<button type=\"button\">Edit</button> " +
                "<button type=\"button\" class=\"btn-hapus\">Hapus</button>" +
                "</td>";
            tbody.appendChild(tr);
        });
    } catch (err) {
        tbody.innerHTML =
            "<tr><td colspan=\"5\">Gagal memuat data: " + err.message + "</td></tr>";
    } finally {
        loading.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", muatDaftarAnggota);
