<?php
include 'koneksi.php';

$from = $_GET['from'] ?? 'info';


if (!isset($_GET['id_hasil'])) {
    echo "ID hasil tidak ditemukan.";
    exit;
}

$id_hasil = intval($_GET['id_hasil']);

$sql = "SELECT h.*, k.judul AS judul_kuis 
        FROM hasil_kuis h 
        LEFT JOIN kuis k ON h.id_kuis = k.id
        WHERE h.id = $id_hasil";
$result = mysqli_query($conn, $sql);

if (!$data = mysqli_fetch_assoc($result)) {
    echo "Data hasil tidak ditemukan.";
    exit;
}

$total_soal = $data['total_soal'];
$jawaban_benar = $data['jawaban_benar'];
$skor = $data['skor'];
$judul_kuis = $data['judul_kuis'];

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Hasil Kuis - <?= htmlspecialchars($judul_kuis) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
    }
    .score-card {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      padding: 30px;
      max-width: 600px;
      margin: auto;
      margin-top: 60px;
    }
    .score-title {
      font-weight: 700;
      font-size: 28px;
    }
    .score-value {
      font-size: 48px;
      font-weight: bold;
      color: #0d6efd;
    }
  </style>
</head>
<body>
<div class="score-card text-center">
  <h2 class="score-title mb-4">🎉 Hasil Kuis: <?= htmlspecialchars($judul_kuis) ?></h2>
  <p class="mb-2">Jumlah Soal: <strong><?= $total_soal ?></strong></p>
  <p class="mb-2">Jawaban Benar: <strong><?= $jawaban_benar ?></strong></p>
  <div class="mt-4 mb-3">
    <div class="score-value"><?= round($skor) ?>%</div>
    <div class="progress mt-3" style="height: 25px;">
      <div class="progress-bar bg-success" role="progressbar" style="width: <?= round($skor) ?>%;" aria-valuenow="<?= round($skor) ?>" aria-valuemin="0" aria-valuemax="100">
        <?= round($skor) ?>%
      </div>
    </div>
  </div>
  <a href="<?= htmlspecialchars($from) ?>.php" class="btn btn-outline-primary mt-4 px-4">Kembali ke Daftar Kuis</a>
</div>
</body>
</html>
