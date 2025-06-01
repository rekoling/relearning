<?php
include 'koneksi.php';

// Validasi ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='container py-5'><div class='alert alert-danger'>ID diskusi tidak valid.</div></div>";
    exit;
}

$id = intval($_GET['id']);

// Ambil data diskusi
$sql = "SELECT * FROM diskusi WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "<div class='container py-5'><div class='alert alert-danger'>Diskusi tidak ditemukan.</div></div>";
    exit;
}

$data = mysqli_fetch_assoc($result);

// Ambil komentar
$komentar = mysqli_query($conn, "SELECT * FROM komentar WHERE id_diskusi = $id ORDER BY id DESC");

// Dari halaman mana kembali
$from = isset($_GET['from']) ? $_GET['from'] : 'info';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Diskusi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
  <div class="card mb-4">
    <img src="images/<?= htmlspecialchars($data['gambar']) ?>" class="card-img-top" alt="Gambar Diskusi" style="max-height: 300px; object-fit: cover;">
    <div class="card-body">
      <h3 class="card-title"><?= htmlspecialchars($data['judul']) ?></h3>
      <p class="card-text"><?= nl2br(htmlspecialchars($data['isi'])) ?></p>
      <p class="text-muted">Dibuat oleh: <?= htmlspecialchars($data['pengguna']) ?></p>
    </div>
  </div>

  <!-- Komentar -->
  <div class="mb-4">
    <h5>Komentar</h5>
    <?php if (mysqli_num_rows($komentar) > 0): ?>
      <?php while ($k = mysqli_fetch_assoc($komentar)) : ?>
        <div class="card mb-2">
          <div class="card-body">
            <p><?= nl2br(htmlspecialchars($k['komentar'])) ?></p>
            <small class="text-muted">Oleh: <?= htmlspecialchars($k['nama']) ?></small>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="text-muted">Belum ada komentar.</p>
    <?php endif; ?>
  </div>

 <!-- Form Tambah Komentar -->
<div class="card">
  <div class="card-body">
    <form action="proses_tambah_komentar.php" method="POST">
      <input type="hidden" name="id_diskusi" value="<?= $data['id'] ?>">
      <input type="hidden" name="from" value="<?= htmlspecialchars($from) ?>">
      
      <div class="mb-3">
        <label for="nama" class="form-label">Nama Anda</label>
        <input type="text" class="form-control" name="nama" required>
      </div>
      
      <div class="mb-3">
        <label for="komentar" class="form-label">Komentar</label>
        <textarea class="form-control" name="komentar" rows="3" required></textarea>
      </div>
      
      <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary">Kirim Komentar</button>
        <a href="<?= htmlspecialchars($from) ?>.php" class="btn btn-secondary">← Kembali</a>
      </div>
    </form>
  </div>
</div>

</div>
</body>
</html>
