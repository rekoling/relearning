<?php
session_start();
require 'koneksi.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = ?");
    $stmt->bind_param("ss", $email, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['email'] = $user['email'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['status'] = $user['status'];

            if ($user['role'] === 'mahasiswa') {
                header('Location: profile.php');
            } else {
                header('Location: profiled.php');
            }
            exit;
        } else {
            $errors['login'] = 'Password salah.';
        }
    } else {
        $errors['login'] = 'Akun tidak ditemukan atau peran salah.';
    }
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Learning System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <!-- Bagian Illustrasi -->
    <section class="illustration-section">
        <div class="illustration-container">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135810.png" alt="E-Learning Illustration" class="illustration-img">
            <h2 class="illustration-title">Selamat Datang di Learnfy</h2>
            <p class="illustration-text">Tingkatkan keterampilan Anda dengan kursus berkualitas tinggi dari instruktur ahli di berbagai bidang.</p>
            
            <div class="features">
                <div class="feature-item">
                    <i class="fas fa-book-open feature-icon"></i>
                    <span>100+ Kursus</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-chalkboard-teacher feature-icon"></i>
                    <span>Instruktur Berpengalaman</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-certificate feature-icon"></i>
                    <span>Sertifikat Penyelesaian</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Bagian Form Login -->
    <section class="login-section">
        <div class="login-container">
            <div class="login-card">
                <div class="logo">
                <img src="images/logo.png" alt="Learnfy Logo" width="70" height="70">
                </div>
                <h1 class="login-title">Welcome Back</h1>
                <p class="login-subtitle">Please enter your details to sign in</p>
                
                <?php if (!empty($errors['login'])): ?>
                    <div style="color: var(--error-color); margin-bottom: 1.5rem; padding: 0.8rem; background-color: rgba(255, 68, 68, 0.1); border-radius: 8px;">
                        <?php echo $errors['login']; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="input-group">
                        <label for="email" class="input-label">Email Address</label>
                        <input type="email" id="email" name="email" class="input-field"
                               placeholder="Enter your email"
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                    </div>

                    <div class="input-group">
                        <label for="password" class="input-label">Password</label>
                        <div class="password-container">
                            <input type="password" id="password" name="password" class="input-field"
                                   placeholder="Enter your password" required>
                            <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility()"></i>
                        </div>
                    </div>

                    <div class="input-group">
    <label for="role" class="input-label">Login sebagai</label>
    <select id="role" name="role" class="input-field" required>
        <option value="">Pilih Peran</option>
        <option value="mahasiswa" <?php echo (isset($_POST['role']) && $_POST['role'] === 'mahasiswa') ? 'selected' : ''; ?>>Mahasiswa</option>
        <option value="dosen" <?php echo (isset($_POST['role']) && $_POST['role'] === 'dosen') ? 'selected' : ''; ?>>Dosen</option>
    </select>
</div>

                    <div class="remember-forgot">
                        <label class="remember-me">
                            <input type="checkbox" name="remember" <?php echo isset($_POST['remember']) ? 'checked' : ''; ?>> Remember me
                        </label>
                        <a href="forgot-password.php" class="forgot-password">Forgot password?</a>
                    </div>

                    <button type="submit" class="login-button">Sign In</button>
                </form>

                <div class="divider">or continue with</div>

                <div class="social-login">
                    <a href="#" class="social-icon"><i class="fab fa-google"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-apple"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                </div>

                <p class="register-link">Don't have an account? <a href="register.php">Sign up</a></p>
            </div>
        </div>
    </section>

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>