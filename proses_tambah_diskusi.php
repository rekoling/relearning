<?php
include 'koneksi.php';

$judul = $_POST['judul'];
$isi = $_POST['isi'];
$pengguna = $_POST['pengguna'];
$gambar = $_FILES['gambar']['name'];

if ($gambar != '') {
  $tmp = $_FILES['gambar']['tmp_name'];
  move_uploaded_file($tmp, "images/" . $gambar);
} else {
  $gambar = 'default.jpg'; // gunakan default jika tidak ada gambar
}

$sql = "INSERT INTO diskusi (judul, isi, pengguna, gambar) VALUES ('$judul', '$isi', '$pengguna', '$gambar')";
mysqli_query($conn, $sql);

header("Location: info.php"); // atau halaman forum kamu
exit;
