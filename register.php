

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register Akun</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="register.css">
</head>
<body>
  <div class="container">
    <div class="illustration">
      <img src="https://cdn-icons-png.flaticon.com/512/3135/3135768.png" alt="Register Illustration">
    </div>
    <div class="form-box">
      <h2>Buat Akun Baru</h2>
      <p>Silakan isi data Anda di bawah ini</p>
      <form action="proses_register.php" method="POST">
        <div class="input-group">
          <label for="username">Nama Lengkap</label>
          <input type="text" name="username" id="username" required>
        </div>
        <div class="input-group">
          <label for="email">Alamat Email</label>
          <input type="email" name="email" id="email" required>
        </div>
        <div class="input-group">
          <label for="password">Kata Sandi</label>
          <input type="password" name="password" id="password" required>
        </div>
        <div class="input-group">
          <label for="role">Peran</label>
          <select name="role" id="role" required>
            <option value="">Pilih Peran</option>
            <option value="mahasiswa">Mahasiswa</option>
            <option value="dosen">Dosen</option>
          </select>
        </div>
        <button type="submit" class="register-button">Daftar Sekarang</button>
        <p class="login-link">Sudah punya akun? <a href="index.php">Masuk</a></p>
      </form>
    </div>
  </div>
</body>
</html>

