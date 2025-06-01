<?php
include 'koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM kuis WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Kuis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h3>Edit Kuis</h3>
    <form action="update_kuis.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $data['id']; ?>">

        <div class="mb-3">
            <label for="judul" class="form-label">Judul Kuis</label>
            <input type="text" class="form-control" name="judul" value="<?= $data['judul']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" name="deskripsi" required><?= $data['deskripsi']; ?></textarea>
        </div>

        <div class="mb-3">
            <label for="gambar" class="form-label">Ganti Gambar (opsional)</label>
            <input type="file" class="form-control" name="gambar">
            <p class="mt-2">Gambar saat ini: <br>
                <img src="gambar/<?= $data['gambar']; ?>" alt="gambar kuis" width="200">
            </p>
        </div>

        <button type="submit" class="btn btn-primary">Update Kuis</button>
        <a href="info.php" class="btn btn-secondary">Batal</a>
    </form>
</body>
</html>
