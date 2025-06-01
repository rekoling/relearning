<?php
require_once 'koneksi.php';  // koneksi ke database

// ... kode HTML dan PHP lainnya ...

$sql = "SELECT * FROM materi ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

// cek hasil query dll...
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-Learning Platform</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Chart.js CSS -->
  <link href="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.css" rel="stylesheet">
  <!-- DataTables CSS -->
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body><link rel="stylesheet" href="infoo.css">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-custom">
  <div class="container-fluid">
    <!-- Hamburger Menu -->
    <button class="btn btn-outline-light me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar" aria-label="Toggle sidebar">
      <i class="bi bi-list" style="font-size: 1.5rem;"></i>
    </button>

    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center" href="infoo.php">
      <img src="images/logo.png" alt="Learnfy Logo" width="55" height="55" class="me-2">
      Learnfy
    </a>

    <!-- Mobile Toggler -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Main Menu -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="infoo.php" aria-current="page"><i class="bi bi-house-door me-1"></i> Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#konten"><i class="bi bi-journal-text me-1"></i> Materi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#kuis"><i class="bi bi-question-circle me-1"></i> Kuis</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#diskusi"><i class="bi bi-chat-dots me-1"></i> Diskusi</a>
        </li>
      </ul>

       <!-- Profile Dropdown -->
      <div class="dropdown me-3">
        <a href="#" class="nav-link dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Profile menu">
          <i class="bi bi-person-circle"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
          <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person me-2"></i> Profil</a></li>
          <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Pengaturan</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="index.php"><i class="bi bi-box-arrow-in-right me-2"></i> Login</a></li>
          <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
        </ul>
      </div>

      <!-- Search Bar -->
      <form class="d-flex search-bar" role="search">
        <input class="form-control me-2" type="search" placeholder="Cari..." aria-label="Search">
        <button class="btn btn-outline-light" type="submit" aria-label="Search"><i class="bi bi-search"></i></button>
      </form>
    </div>
  </div>
</nav>

<!-- Sidebar Offcanvas -->
<div class="offcanvas offcanvas-start sidebar" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasSidebarLabel"><i class="bi bi-bar-chart me-2"></i>Statistik & Menu</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <!-- Quiz Statistics -->
    <div class="mb-4">
      <h3 class="h5"><i class="bi bi-bar-chart me-2"></i>Statistik Kuis</h3>
      <div id="quizChartContainer">
        <canvas id="quizChart"></canvas>
      </div>
    </div>
    <hr>

    <!-- Learning Progress -->
    <div class="mb-4">
      <h3 class="h5"><i class="bi bi-graph-up me-2"></i>Progress Belajar</h3>
      <div class="progress mb-3">
        <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
      </div>
    </div>
    <hr>

    <!-- Upcoming Assignments -->
    <div class="mb-4">
      <h3 class="h5"><i class="bi bi-calendar-check me-2"></i>Tugas Mendatang</h3>
      <ul class="list-unstyled">
        <li class="mb-2">
          <a href="#" class="text-decoration-none d-flex align-items-start">
            <i class="bi bi-file-earmark-text me-2 mt-1"></i>
            <span>Tugas Pemrograman Dasar<br><small class="text-muted">Deadline: 25 November 2023</small></span>
          </a>
        </li>
        <li class="mb-2">
          <a href="#" class="text-decoration-none d-flex align-items-start">
            <i class="bi bi-file-earmark-text me-2 mt-1"></i>
            <span>Kuis Desain Grafis<br><small class="text-muted">Deadline: 30 November 2023</small></span>
          </a>
        </li>
      </ul>
    </div>
    <hr>

    <!-- Leaderboard -->
    <div class="mb-4">
      <h3 class="h5"><i class="bi bi-trophy me-2"></i>Leaderboard</h3>
      <ol class="list-unstyled">
        <li class="mb-2"><i class="bi bi-1-circle-fill text-warning me-2"></i>User1 - 95 Poin</li>
        <li class="mb-2"><i class="bi bi-2-circle-fill text-secondary me-2"></i>User2 - 90 Poin</li>
        <li class="mb-2"><i class="bi bi-3-circle-fill text-danger me-2"></i>User3 - 88 Poin</li>
      </ol>
    </div>
    <hr>

    <!-- Recommended Materials -->
    <div class="mb-4">
      <h3 class="h5"><i class="bi bi-book me-2"></i>Rekomendasi Materi</h3>
      <ul class="list-unstyled">
        <li class="mb-2">
          <a href="#" class="text-decoration-none d-flex align-items-start">
            <i class="bi bi-file-earmark-text me-2 mt-1"></i>
            <span>Belajar Data Science untuk Pemula</span>
          </a>
        </li>
        <li class="mb-2">
          <a href="#" class="text-decoration-none d-flex align-items-start">
            <i class="bi bi-file-earmark-text me-2 mt-1"></i>
            <span>Advanced Python Programming</span>
          </a>
        </li>
      </ul>
    </div>
    <hr>

    <!-- Notifications -->
    <div class="mb-4">
      <h3 class="h5"><i class="bi bi-bell me-2"></i>Notifikasi</h3>
      <ul class="list-unstyled">
        <li>
          <a href="#" class="text-decoration-none d-flex align-items-center">
            <i class="bi bi-bell-fill me-2"></i>
            <span>Anda memiliki 2 notifikasi baru</span>
          </a>
        </li>
      </ul>
    </div>
    <hr>

    <!-- Recent Activity -->
    <div class="mb-4">
      <h3 class="h5"><i class="bi bi-clock-history me-2"></i>Aktivitas Terbaru</h3>
      <ul class="list-unstyled">
        <li class="mb-2">
          <i class="bi bi-check-circle-fill text-success me-2"></i>
          <span>Anda baru saja menyelesaikan Kuis Desain Grafis</span>
        </li>
        <li class="mb-2">
          <i class="bi bi-folder-fill text-primary me-2"></i>
          <span>Anda membuka materi "Manajemen Proyek"</span>
        </li>
      </ul>
    </div>
    <hr>

    <!-- Announcements -->
    <div class="mb-4">
      <h3 class="h5"><i class="bi bi-megaphone me-2"></i>Pengumuman</h3>
      <div class="d-flex">
        <i class="bi bi-info-circle-fill text-primary me-2 mt-1"></i>
        <p>Ujian akhir akan dilaksanakan pada 30 November 2023.</p>
      </div>
    </div>
    <hr>

    <!-- Quick Links -->
    <div class="mb-4">
      <h3 class="h5"><i class="bi bi-link me-2"></i>Tautan Cepat</h3>
      <ul class="list-unstyled">
        <li class="mb-2">
          <a href="#" class="text-decoration-none d-flex align-items-center">
            <i class="bi bi-file-earmark-text me-2"></i>
            <span>Materi Terbaru</span>
          </a>
        </li>
        <li class="mb-2">
          <a href="#" class="text-decoration-none d-flex align-items-center">
            <i class="bi bi-question-circle me-2"></i>
            <span>Kuis Mendatang</span>
          </a>
        </li>
        <li class="mb-2">
          <a href="#" class="text-decoration-none d-flex align-items-center">
            <i class="bi bi-chat-dots me-2"></i>
            <span>Forum Diskusi</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>

<!-- Main Content -->
<section id="konten">
  <main class="main-content">
    <div class="container-fluid">
      <div class="row">
        <section class="col-md-12 p-4">

          <!-- Section: Daftar Materi -->
          <section id="materi" class="section-container mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h2 class="section-title">
                <i class="bi bi-journal-text me-2"></i>Daftar Materi
              </h2>
            </div>

            <?php
            $sql = "SELECT * FROM materi ORDER BY id DESC";
            $result = mysqli_query($conn, $sql);
            ?>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
              <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <div class="col">
                  <div class="card h-100">
                    <img src="images/<?= htmlspecialchars($row['gambar']) ?>" class="card-img-top" alt="Gambar Materi">
                    <div class="card-body">
                      <h5 class="card-title"><?= htmlspecialchars($row['judul']) ?></h5>
                      <p class="card-text"><?= nl2br(htmlspecialchars($row['deskripsi'])) ?></p>
                      <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Materi</span>
                        <a href="detail_materi.php?id=<?= $row['id'] ?>&from=infoo" class="btn btn-primary btn-sm">Buka Materi</a>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
          </section>

          <!-- Section: Daftar Kuis -->
          <section id="kuis" class="section-container mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h2 class="section-title">
                <i class="bi bi-journal-check me-2"></i>Daftar Kuis
              </h2>
            </div>

            <?php
            $sql = "SELECT * FROM kuis ORDER BY id DESC";
            $result = mysqli_query($conn, $sql);
            ?>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
              <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <div class="col">
                  <div class="card h-100">
                    <img src="images/<?= htmlspecialchars($row['gambar']) ?>" class="card-img-top" alt="Gambar Kuis">
                    <div class="card-body">
                      <h5 class="card-title"><?= htmlspecialchars($row['judul']) ?></h5>
                      <p class="card-text"><?= nl2br(htmlspecialchars($row['deskripsi'])) ?></p>
                      <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Kuis</span>
                        <a href="detail_kuis.php?id=<?= $row['id'] ?>&from=infoo" class="btn btn-primary btn-sm">Lihat Kuis</a>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
          </section>

          <!-- Section: Daftar Diskusi -->
          <section id="diskusi" class="section-container mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h2 class="section-title"><i class="bi bi-chat-dots me-2"></i>Forum Diskusi</h2>
            </div>

            <?php
            $sql = "
SELECT d.*, COUNT(k.id) AS jumlah_komentar 
FROM diskusi d
LEFT JOIN komentar k ON k.id_diskusi = d.id
GROUP BY d.id
ORDER BY d.id DESC
";
$result = mysqli_query($conn, $sql);

            ?>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
              <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <div class="col">
                  <div class="card h-100 shadow-sm">
                    <a href="detail_diskusi.php?id=<?= $row['id'] ?>&from=infoo" class="text-decoration-none text-dark">
                      <img src="images/<?= htmlspecialchars($row['gambar']) ?>" class="card-img-top" alt="Gambar Diskusi" style="height: 180px; object-fit: cover;">
                      <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['judul']) ?></h5>
                        <p class="card-text text-truncate"><?= strip_tags($row['isi']) ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                          <small class="text-muted">Oleh: <?= htmlspecialchars($row['pengguna']) ?></small>
                          <span class="badge bg-secondary">
                            <i class="bi bi-chat-left-text me-1"></i>
                            <?= $row['jumlah_komentar'] ?? 0 ?>
                          </span>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
          </section>

        </section>
      </div>
    </div>
  </main>
</section>


        <!-- Section: Daftar Pengguna -->
<section id="pengguna" class="section-container mb-5 px-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="section-title"><i class="bi bi-people me-2"></i>Daftar Pengguna</h2>
  </div>

  <div class="table-responsive">
    <table id="usersTable" class="table table-striped table-hover align-middle" style="width:100%">
      <thead class="table-light">
        <tr>
          <th>Nama</th>
          <th>Email</th>
          <th>Role</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
<?php
require 'koneksi.php';
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $badgeRole = $row['role'] === 'dosen' ? 'bg-warning text-dark' : 'bg-primary';
    $labelRole = $row['role'] === 'dosen' ? 'Teacher' : 'Student';

    $badgeStatus = $row['status'] === 'active' ? 'bg-success' : 'bg-secondary';

    echo "<tr>
            <td>{$row['username']}</td>
            <td>{$row['email']}</td>
            <td><span class='badge {$badgeRole}'>{$labelRole}</span></td>
            <td><span class='badge {$badgeStatus}'>" . ucfirst($row['status']) . "</span></td>
            <td>
              <div class='btn-group' role='group'>
                <button class='btn btn-sm btn-outline-primary' title='Lihat Detail'><i class='bi bi-eye'></i></button>
                <button class='btn btn-sm btn-outline-secondary' title='Edit Pengguna'><i class='bi bi-pencil'></i></button>
              </div>
            </td>
          </tr>";
}
?>
</tbody>

    </table>
  </div>


      </section>
    </div>
  </div>
</main>



<!-- Footer -->
<footer class="container-sections">
  <div class="footer-sections">
    <div class="footer-section">
      <h4>Tentang Learnfy</h4>
      <a href="#">Visi & Misi</a>
      <a href="#">Tim Pengajar</a>
      <a href="#">Metodologi</a>
      <a href="#">Testimoni</a>
      <a href="#">Karir</a>
    </div>
    <div class="footer-section">
      <h4>Kategori Belajar</h4>
      <a href="#">Pemrograman</a>
      <a href="#">Desain Grafis</a>
      <a href="#">Bisnis</a>
      <a href="#">Bahasa</a>
      <a href="#">Pengembangan Diri</a>
    </div>
    <div class="footer-section">
      <h4>Dukungan</h4>
      <a href="#">Pusat Bantuan</a>
      <a href="#">Kebijakan Privasi</a>
      <a href="#">Syarat & Ketentuan</a>
      <a href="#">FAQ</a>
      <a href="#">Hubungi Kami</a>
    </div>
    <div class="footer-section">
      <h4>Sumber Daya</h4>
      <a href="#">Blog</a>
      <a href="#">Panduan Belajar</a>
      <a href="#">Template Gratis</a>
      <a href="#">Glosarium</a>
      <a href="#">Event</a>
    </div>
  </div>

  <div class="footer-subscribe text-center">
    <h4>Berlangganan Newsletter</h4>
    <p>Dapatkan update materi baru, tips belajar, dan penawaran khusus langsung ke inbox Anda.</p>
    <form class="subscribe-form">
      <input type="email" class="form-control" placeholder="Alamat email Anda" required>
      <button type="submit" class="btn btn-custom">Berlangganan</button>
    </form>
  </div>

  <div class="footer-social text-center">
    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
    <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
  </div>

  <div class="footer-copyright text-center">
    <p>© 2025 Learnfy. Seluruh hak cipta dilindungi undang-undang.</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script>
   <!-- Pastikan Chart.js sudah terpasang -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const canvas = document.getElementById('quizChart');
  
  // Cek apakah canvas ditemukan
  if (!canvas) {
    console.error('Elemen canvas dengan id "quizChart" tidak ditemukan.');
    return;
  }

  const ctx = canvas.getContext('2d');
  if (!ctx) {
    console.error('Gagal mendapatkan context 2D dari canvas.');
    return;
  }

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Quiz 1', 'Quiz 2', 'Quiz 3', 'Quiz 4', 'Quiz 5'],
      datasets: [{
        label: 'Nilai Rata-rata',
        data: [85, 90, 78, 92, 88], // Data nilai rata-rata kuis
        backgroundColor: 'rgba(143, 144, 255, 0.5)',
        borderColor: '#8F90FF',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          max: 100
        }
      }
    }
  });
});
</script>
<script>
      $(document).ready(function () {
    $('#usersTable').DataTable();
  });
  </script>
</body>