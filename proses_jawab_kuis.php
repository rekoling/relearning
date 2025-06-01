<?php
include 'koneksi.php';

if (!isset($_POST['jawaban']) || !isset($_POST['id_kuis'])) {
    echo "Data tidak lengkap.";
    exit;
}

$jawaban_user = $_POST['jawaban'];
$id_kuis = intval($_POST['id_kuis']);

// Ambil soal kuis
$soal_query = mysqli_query($conn, "SELECT * FROM soal WHERE id_kuis = $id_kuis");

$total_soal = 0;
$jawaban_benar = 0;

while ($s = mysqli_fetch_assoc($soal_query)) {
    $id_soal = $s['id'];
    $jawaban_benar_soal = strtoupper($s['jawaban_benar']);

    $total_soal++;
    if (isset($jawaban_user[$id_soal]) && strtoupper($jawaban_user[$id_soal]) === $jawaban_benar_soal) {
        $jawaban_benar++;
    }
}

$skor = ($total_soal > 0) ? ($jawaban_benar / $total_soal * 100) : 0;

// Simpan hasil kuis
$sql_insert = "INSERT INTO hasil_kuis (id_kuis, total_soal, jawaban_benar, skor) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql_insert);
if (!$stmt) {
    die("Prepare statement gagal: " . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmt, "iiid", $id_kuis, $total_soal, $jawaban_benar, $skor);

if (!mysqli_stmt_execute($stmt)) {
    die("Gagal menyimpan hasil kuis: " . mysqli_stmt_error($stmt));
}

$id_hasil = mysqli_insert_id($conn);
if (!$id_hasil) {
    die("Gagal mendapatkan ID hasil kuis baru.");
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

// Redirect ke hasil kuis
$from = $_POST['from'] ?? 'info';
header("Location: hasil_kuis.php?id_hasil=$id_hasil&from=$from");
exit;

?>
