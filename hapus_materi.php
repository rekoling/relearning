<?php
include 'koneksi.php'; // Pastikan koneksi sudah benar

if (isset($_POST['hapus_ids'])) {
    $ids = $_POST['hapus_ids'];

    foreach ($ids as $id) {
        // Salin dulu ke tabel hapus
        $query = "INSERT INTO hapus (id, judul, deskripsi, gambar) 
                  SELECT id, judul, deskripsi, gambar FROM materi WHERE id = $id";
        mysqli_query($conn, $query);

        // Baru hapus dari tabel materi
        $delete = "DELETE FROM materi WHERE id = $id";
        mysqli_query($conn, $delete);
    }

    header("Location: info.php"); // Redirect ke halaman utama
    exit;
} else {
    echo "Tidak ada data yang dikirim.";
}
?>
