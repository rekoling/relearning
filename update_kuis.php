<?php
include 'koneksi.php';

$id = $_POST['id'];
$judul = $_POST['judul'];
$deskripsi = $_POST['deskripsi'];

if ($_FILES['gambar']['name'] != '') {
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    move_uploaded_file($tmp, "gambar/" . $gambar);
    
    $query = "UPDATE kuis SET judul='$judul', deskripsi='$deskripsi', gambar='$gambar' WHERE id='$id'";
} else {
    $query = "UPDATE kuis SET judul='$judul', deskripsi='$deskripsi' WHERE id='$id'";
}

mysqli_query($conn, $query);
header("Location: info.php");
?>
