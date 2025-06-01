<?php
include 'koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID materi tidak tersedia.";
    exit;
}

$id = intval($_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM materi WHERE id = $id");
$materi = mysqli_fetch_assoc($query);

if (!$materi) {
    echo "Materi tidak ditemukan.";
    exit;
}

$gambarHeader = 'images/' . htmlspecialchars($materi['gambar']);

$from = isset($_GET['from']) ? $_GET['from'] : 'info'; // default info.php

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($materi['judul']) ?> | E-Learning</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f9fafa;
      color: #333;
    }

    .materi-header {
      background: url('<?= $gambarHeader ?>') center center / cover no-repeat;
      color: white;
      padding: 80px 0;
      position: relative;
    }

    .materi-header::after {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.55); /* Overlay gelap agar teks terbaca */
      z-index: 1;
    }

    .materi-header .container {
      position: relative;
      z-index: 2;
    }

    .materi-header h1 {
      font-size: 2.8rem;
      font-weight: bold;
    }

    .materi-content {
      background: white;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.05);
    }

    .materi-text p {
      font-size: 1.1rem;
      line-height: 1.8;
      margin-bottom: 1.5rem;
    }

    .sidebar-box {
      background: #ffffff;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.03);
    }

    .back-btn {
      margin-top: 20px;
    }

    .info-label {
      font-weight: 500;
      color: #555;
    }

    @media (max-width: 768px) {
      .materi-content {
        padding: 20px;
      }
    }
  </style>
</head>
<body>

  <!-- Header -->
  <section class="materi-header text-center text-white">
    <div class="container">
      <h1><?= htmlspecialchars($materi['judul']) ?></h1>
      <p class="lead mt-3"><?= htmlspecialchars($materi['deskripsi']) ?></p>
    </div>
  </section>

  <!-- Main Content -->
  <div class="container my-5">
    <div class="row g-4">
      <!-- Materi Content -->
      <div class="col-lg-8">
        <div class="materi-content">
          <div class="materi-text">
            <?= nl2br($materi['isi_materi']) ?>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="col-lg-4">
        <div class="sidebar-box">
          <h5 class="mb-3">Info Materi</h5>
          <p><span class="info-label">ID:</span> <?= $materi['id'] ?></p>
          <p><span class="info-label">Judul:</span> <?= htmlspecialchars($materi['judul']) ?></p>
         <a href="<?= $from ?>.php" class="btn btn-secondary mt-3">← Kembali ke Beranda</a>

        </div>
      </div>
    </div>
  </div>

</body>
</html>
