<?php
include 'koneksi.php';

if (isset($_POST['hapus_ids'])) {
    $ids = $_POST['hapus_ids'];

    foreach ($ids as $id) {
        $id = intval($id); // Hindari injeksi SQL

        // Cek apakah kolom 'jenis' ada di tabel 'hapus'
        $checkColumn = mysqli_query($conn, "SHOW COLUMNS FROM hapus LIKE 'jenis'");
        $hasJenis = mysqli_num_rows($checkColumn) > 0;

        if ($hasJenis) {
            // Jika kolom jenis ada, insert dengan jenis
            $query = "INSERT IGNORE INTO hapus (id, judul, deskripsi, gambar, jenis) 
                      SELECT id, judul, isi, gambar, 'diskusi' FROM diskusi WHERE id = $id";
        } else {
            // Jika tidak ada, insert tanpa jenis
            $query = "INSERT IGNORE INTO hapus (id, judul, deskripsi, gambar) 
                      SELECT id, judul, isi, gambar FROM diskusi WHERE id = $id";
        }

        mysqli_query($conn, $query);

        // Hapus dari tabel diskusi
        $delete = "DELETE FROM diskusi WHERE id = $id";
        mysqli_query($conn, $delete);
    }

    header("Location: info.php");
    exit;
} else {
    echo "Tidak ada data yang dikirim.";
}
?>
