<?php
include 'koneksi.php';

$id_diskusi = intval($_POST['id_diskusi']);
$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$komentar = mysqli_real_escape_string($conn, $_POST['komentar']);
$from = isset($_POST['from']) ? $_POST['from'] : 'info';

$sql = "INSERT INTO komentar (id_diskusi, nama, komentar) VALUES ($id_diskusi, '$nama', '$komentar')";
mysqli_query($conn, $sql);

header("Location: detail_diskusi.php?id=$id_diskusi&from=$from");
exit;

?>
