<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Cek apakah ada gambar yang di-upload
    $gambar = null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $path = 'images/' . $gambar;
        move_uploaded_file($tmp, $path);
    }

    // Ambil data kuis
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];

    // Simpan kuis ke database
    $sql = "INSERT INTO kuis (judul, deskripsi, gambar) VALUES ('$judul', '$deskripsi', '$gambar')";
    if (mysqli_query($conn, $sql)) {
        $id_kuis = mysqli_insert_id($conn);

        // Ambil array soal dari form
        $pertanyaan = $_POST['pertanyaan'];
        $opsi_a = $_POST['opsi_a'];
        $opsi_b = $_POST['opsi_b'];
        $opsi_c = $_POST['opsi_c'];
        $opsi_d = $_POST['opsi_d'];
        $jawaban_benar = $_POST['jawaban_benar'];

        // Loop untuk simpan semua soal
        for ($i = 0; $i < count($pertanyaan); $i++) {
            // Cek agar tidak menyimpan soal kosong
            if (
                !empty($pertanyaan[$i]) &&
                !empty($opsi_a[$i]) &&
                !empty($opsi_b[$i]) &&
                !empty($opsi_c[$i]) &&
                !empty($opsi_d[$i]) &&
                !empty($jawaban_benar[$i])
            ) {
                $p = mysqli_real_escape_string($conn, $pertanyaan[$i]);
                $a = mysqli_real_escape_string($conn, $opsi_a[$i]);
                $b = mysqli_real_escape_string($conn, $opsi_b[$i]);
                $c = mysqli_real_escape_string($conn, $opsi_c[$i]);
                $d = mysqli_real_escape_string($conn, $opsi_d[$i]);
                $jb = mysqli_real_escape_string($conn, $jawaban_benar[$i]);

                $sql_soal = "INSERT INTO soal (id_kuis, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar) 
                             VALUES ('$id_kuis', '$p', '$a', '$b', '$c', '$d', '$jb')";
                mysqli_query($conn, $sql_soal);
            }
        }

        // Kembali ke halaman utama
        header("Location: info.php");
    } else {
        echo "Gagal menambahkan kuis: " . mysqli_error($conn);
    }
}
?>
