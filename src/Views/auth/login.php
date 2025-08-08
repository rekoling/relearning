<?php
$title = 'Login - ' . config('app.name');
ob_start();
?>

<div class="auth-container">
    <!-- Illustration Section -->
    <section class="illustration-section">
        <div class="illustration-container">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135810.png" alt="E-Learning Illustration" class="illustration-img">
            <h2 class="illustration-title">Selamat Datang di <?= config('app.name') ?></h2>
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

    <!-- Login Form Section -->
    <section class="login-section">
        <div class="login-container">
            <div class="login-card">
                <div class="logo">
                    <img src="<?= asset('images/logo.png') ?>" alt="Logo" width="70" height="70">
                </div>
                <h1 class="login-title">Welcome Back</h1>
                <p class="login-subtitle">Please enter your details to sign in</p>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-error">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_GET['register']) && $_GET['register'] === 'success'): ?>
                    <div class="alert alert-success">
                        Registration successful! Please log in with your credentials.
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="<?= url('index.php') ?>">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    
                    <div class="input-group">
                        <label for="email" class="input-label">Email Address</label>
                        <input type="email" id="email" name="email" class="input-field" 
                               placeholder="Enter your email" 
                               value="<?= htmlspecialchars($old_input['email'] ?? '') ?>" required>
                        <?php if (isset($errors['email'])): ?>
                            <span class="error-text"><?= htmlspecialchars($errors['email'][0]) ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="input-group">
                        <label for="password" class="input-label">Password</label>
                        <div class="password-container">
                            <input type="password" id="password" name="password" class="input-field"
                                   placeholder="Enter your password" required>
                            <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility()"></i>
                        </div>
                        <?php if (isset($errors['password'])): ?>
                            <span class="error-text"><?= htmlspecialchars($errors['password'][0]) ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="input-group">
                        <label for="role" class="input-label">Login sebagai</label>
                        <select id="role" name="role" class="input-field" required>
                            <option value="">Pilih Peran</option>
                            <option value="mahasiswa" <?= ($old_input['role'] ?? '') === 'mahasiswa' ? 'selected' : '' ?>>Mahasiswa</option>
                            <option value="dosen" <?= ($old_input['role'] ?? '') === 'dosen' ? 'selected' : '' ?>>Dosen</option>
                        </select>
                        <?php if (isset($errors['role'])): ?>
                            <span class="error-text"><?= htmlspecialchars($errors['role'][0]) ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="remember-forgot">
                        <label class="remember-me">
                            <input type="checkbox" name="remember"> Remember me
                        </label>
                        <a href="#" class="forgot-password">Forgot password?</a>
                    </div>

                    <button type="submit" class="login-button">Sign In</button>
                </form>

                <div class="divider">or continue with</div>

                <div class="social-login">
                    <a href="#" class="social-icon"><i class="fab fa-google"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-apple"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                </div>

                <p class="register-link">Don't have an account? <a href="<?= url('register.php') ?>">Sign up</a></p>
            </div>
        </div>
    </section>
</div>

<style>
/* Include the existing CSS from index.css here for now */
/* This should be moved to public/assets/css/app.css */
</style>

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

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
?>