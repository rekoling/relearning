-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Jun 2025 pada 15.27
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_relearning`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `diskusi`
--

CREATE TABLE `diskusi` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `tanggal_post` datetime DEFAULT current_timestamp(),
  `isi` text DEFAULT NULL,
  `pengguna` varchar(255) DEFAULT NULL,
  `jumlah_komentar` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `diskusi`
--

INSERT INTO `diskusi` (`id`, `judul`, `deskripsi`, `gambar`, `tanggal_post`, `isi`, `pengguna`, `jumlah_komentar`) VALUES
(1, 'Manajemen Proyek', NULL, 'forum3.jpeg', '2025-05-18 13:10:00', 'bantu saya belajar manajemen secara fundamental', 'Aji', 3),
(2, 'Design Web', NULL, 'forum2.jpeg', '2025-05-18 13:29:43', 'Bagaimana cara mendesign di Canva', 'Harun', 2),
(3, 'Pemrograman Dasar', NULL, 'forum1.jpeg', '2025-05-18 13:30:46', 'Ajarkan saya membuat program berbasis web', 'Ferry', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hapus`
--

CREATE TABLE `hapus` (
  `id` int(11) NOT NULL,
  `id_materi` int(11) DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `waktu_hapus` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `hapus`
--

INSERT INTO `hapus` (`id`, `id_materi`, `judul`, `deskripsi`, `gambar`, `waktu_hapus`) VALUES
(4, NULL, 'biologi', 'makanan', '˖  ⋆   ARCANE, LEAGUE OF LEGENDS ࿐໋.jpeg', NULL),
(5, NULL, 'Design Grafis', 'dfdas', 'wallpaperflare.com_wallpaper (12).jpg', NULL),
(6, NULL, 'gaff', 'fsafas', 'wallpaperflare.com_wallpaper (12).jpg', NULL),
(7, NULL, 'kljaaj', 'adfadf', 'wallpaperflare.com_wallpaper (12).jpg', NULL),
(8, NULL, 'werf', 'ref', 'wallpaperflare.com_wallpaper (12).jpg', NULL),
(9, NULL, 'jhvjhkbgjhgb', 'hbh', 'wallpaperflare.com_wallpaper (12).jpg', NULL),
(10, NULL, 'bahasa inggris', 'tes toefle ', 'english.jpeg', NULL),
(11, NULL, 'asfd', 'asdf', 'wallpaperflare.com_wallpaper (12).jpg', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_kuis`
--

CREATE TABLE `hasil_kuis` (
  `id` int(11) NOT NULL,
  `id_kuis` int(11) DEFAULT NULL,
  `total_soal` int(11) DEFAULT NULL,
  `jawaban_benar` int(11) DEFAULT NULL,
  `skor` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `hasil_kuis`
--

INSERT INTO `hasil_kuis` (`id`, `id_kuis`, `total_soal`, `jawaban_benar`, `skor`) VALUES
(1, 3, 3, 0, 0),
(2, 5, 2, 2, 100),
(3, 5, 2, 1, 50),
(4, 5, 2, 2, 100),
(5, 5, 2, 0, 0),
(6, 1, 3, 2, 66.66666666666666),
(7, 2, 3, 3, 100),
(8, 3, 3, 0, 0),
(9, 2, 3, 0, 0),
(10, 3, 3, 0, 0),
(11, 1, 3, 0, 0),
(12, 2, 3, 3, 100),
(13, 3, 3, 0, 0),
(14, 6, 2, 2, 100);

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar`
--

CREATE TABLE `komentar` (
  `id` int(11) NOT NULL,
  `id_diskusi` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `komentar` text NOT NULL,
  `tanggal_post` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `komentar`
--

INSERT INTO `komentar` (`id`, `id_diskusi`, `nama`, `komentar`, `tanggal_post`) VALUES
(1, 1, 'imam', 'apa itu ji', '2025-05-18 06:11:45'),
(2, 1, 'Dhimas', 'aji banyak gaya wkwk', '2025-05-18 06:13:23'),
(3, 2, 'imam', 'diam lah kau run', '2025-05-19 01:30:28'),
(4, 3, 'fitra', 'jangan lah bernafas kau fer', '2025-05-19 01:31:18'),
(5, 2, 'han', 'sabar run\r\n', '2025-05-29 17:39:11'),
(6, 1, 'han', 'awoksokao', '2025-05-29 17:39:47'),
(7, 3, 'imam', 'diamlah fer\r\n', '2025-05-30 13:00:48'),
(8, 1, 'fitra', 'apa sih ji', '2025-05-30 13:01:45'),
(9, 3, 'han', 'oke fer', '2025-05-30 13:02:58'),
(10, 3, 'e', 'waduh', '2025-05-30 13:24:28'),
(11, 3, 'imam', 'apa ini', '2025-05-30 13:26:05'),
(12, 3, 'han', 'oke', '2025-05-30 13:29:41'),
(13, 3, 'ya', 're', '2025-05-30 13:30:53'),
(14, 2, 'fan', 'ada', '2025-05-30 13:38:27'),
(15, 2, 'han', 'oke', '2025-05-30 13:38:55'),
(16, 2, 'fitra', 'ga', '2025-05-30 13:45:35'),
(17, 2, 'imam', 'ya', '2025-05-30 13:47:01'),
(18, 1, 'Dhimas', 'aokoskokao', '2025-05-31 12:15:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kuis`
--

CREATE TABLE `kuis` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `tanggal_upload` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kuis`
--

INSERT INTO `kuis` (`id`, `judul`, `deskripsi`, `gambar`, `tanggal_upload`) VALUES
(1, 'Kuis Dasar-Dasar Manajemen Proyek', 'Kuis ini bertujuan untuk menguji pemahaman dasar mahasiswa mengenai konsep dasar manajemen proyek.\r\n', 'quiz3.jpeg', '2025-05-18 12:49:39'),
(2, 'Kuis Desain Grafis ', 'Kuis ini menguji pemahaman awal tentang konsep dasar desain grafis, termasuk elemen, prinsip, dan perangkat lunak yang umum digunakan.', 'quiz2.jpeg', '2025-05-18 13:00:26'),
(3, 'Kuis Pemrograman Dasar', 'Kuis ini dirancang untuk mengukur pemahaman dasar mahasiswa tentang konsep dasar pemrograman, sintaks, logika dasar, dan tipe data.', 'quiz1.jpeg', '2025-05-18 13:05:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `materi`
--

CREATE TABLE `materi` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `isi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `tanggal_upload` datetime DEFAULT current_timestamp(),
  `isi_materi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `materi`
--

INSERT INTO `materi` (`id`, `judul`, `deskripsi`, `isi`, `gambar`, `tanggal_upload`, `isi_materi`) VALUES
(1, 'Manajemen Proyek', 'Pelajari dasar-dasar Manajemen Proyek tingkat pemula dengan studi kasus dunia nyata.', NULL, 'project.jpeg', '2025-05-18 12:34:24', 'Dasar Manajemen Proyek\r\nMemahami konsep dasar, prinsip, dan metodologi dalam manajemen proyek modern.\r\n\r\nPerencanaan Proyek\r\nTeknik menyusun rencana proyek yang efektif termasuk scope, timeline, dan alokasi sumber daya.\r\n\r\nManajemen Tim\r\nStrategi membangun dan memimpin tim proyek yang produktif dan kolaboratif.\r\n\r\nMonitoring & Evaluasi\r\nTeknik memantau progres proyek dan mengevaluasi kinerja terhadap target yang ditetapkan.\r\n\r\nManajemen Risiko\r\nIdentifikasi, analisis, dan mitigasi risiko potensial dalam pelaksanaan proyek.\r\n\r\nPelaporan Proyek\r\nPenyusunan laporan proyek yang efektif untuk berbagai stakeholder.'),
(2, 'Design Grafis', 'Kuasaikan prinsip-prinsip desain visual dan alat kreatif untuk mengekspresikan ide-ide Anda', NULL, 'web.jpeg', '2025-05-18 12:37:41', 'Prinsip Desain\r\nPelajari prinsip dasar desain seperti kontras, keseimbangan, hierarki, dan kesatuan untuk menciptakan karya visual yang efektif.\r\n\r\nTeori Warna\r\nMemahami psikologi warna, skema warna, dan bagaimana memilih kombinasi warna yang harmonis untuk desain Anda.\r\n\r\nTipografi\r\nPengenalan jenis font, pairing font, dan teknik penggunaan tipografi untuk meningkatkan komunikasi visual.\r\n\r\nKomposisi\r\nTeknik pengaturan elemen visual seperti rule of thirds, golden ratio, dan focal point untuk desain yang menarik.\r\n\r\nSoftware Tools\r\nPengenalan tools desain grafis populer seperti Adobe Photoshop, Illustrator, dan Figma beserta kegunaannya.\r\n\r\nFormat File\r\nMemahami perbedaan format file gambar (JPG, PNG, SVG, AI) dan kapan menggunakannya.'),
(3, 'Pemrograman Dasar Komputer', 'Pelajari dasar-dasar pemrograman menggunakan Python dengan pendekatan praktis dan contoh nyata.', NULL, 'program.jpeg', '2025-05-18 12:39:52', 'Pengenalan Variabel\r\nPelajari konsep dasar variabel dalam pemrograman, tipe data, dan cara pendeklarasiannya dalam berbagai bahasa pemrograman.\r\n\r\nStruktur Kontrol\r\nMemahami percabangan (if-else) dan perulangan (for, while) sebagai dasar logika pemrograman.\r\n\r\nFungsi dan Prosedur\r\nKonsep modularisasi kode dengan fungsi dan prosedur untuk membuat program yang lebih terstruktur.\r\n\r\nDebugging Dasar\r\nTeknik identifikasi dan perbaikan kesalahan umum dalam kode pemrograman.\r\n\r\nBest Practices\r\nPola penulisan kode yang baik dan prinsip-prinsip dasar clean code untuk pemula.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `soal`
--

CREATE TABLE `soal` (
  `id` int(11) NOT NULL,
  `id_kuis` int(11) DEFAULT NULL,
  `pertanyaan` text DEFAULT NULL,
  `opsi_a` text DEFAULT NULL,
  `opsi_b` text DEFAULT NULL,
  `opsi_c` text DEFAULT NULL,
  `opsi_d` text DEFAULT NULL,
  `jawaban_benar` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `soal`
--

INSERT INTO `soal` (`id`, `id_kuis`, `pertanyaan`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `jawaban_benar`) VALUES
(1, 1, 'Apa yang dimaksud dengan manajemen proyek?', 'Proses menghasilkan keuntungan sebesar-besarnya dari suatu usaha', 'Proses pengorganisasian acara perusahaan', 'Proses perencanaan, pelaksanaan, dan pengendalian proyek untuk mencapai tujuan tertentu', 'Proses mempercepat pengerjaan tugas harian', 'c'),
(2, 1, 'Manakah yang bukan merupakan tujuan utama manajemen proyek?', ' Menyelesaikan proyek tepat waktu', ' Meningkatkan beban kerja tim', ' Mengelola anggaran proyek', 'Memenuhi kebutuhan stakeholder', 'b'),
(3, 1, 'Apa yang dimaksud dengan ruang lingkup proyek?', 'Wilayah geografis tempat proyek berlangsung', 'Waktu yang dibutuhkan untuk menyelesaikan proyek', 'Batasan dan deliverables yang harus dicapai dalam proyek', 'Biaya keseluruhan proyek', 'c'),
(4, 2, 'Apa yang dimaksud dengan desain grafis?', 'Seni menggambar di atas kertas', 'Proses menyusun gambar di galeri seni', 'Seni dan praktik merencanakan serta memproyeksikan ide melalui konten visual', 'Mendesain struktur bangunan secara digital', 'c'),
(5, 2, 'Manakah dari berikut ini yang merupakan elemen dasar dalam desain grafis?', 'Warna, bentuk, garis', 'Kata, paragraf, bab', 'Volume, suhu, tekanan', 'Nada, tempo, irama', 'a'),
(6, 2, 'Aplikasi manakah yang paling sering digunakan untuk desain grafis vektor?', 'Adobe Photoshop', 'Adobe Illustrator', 'Corel VideoStudio', ' Audacity', 'b'),
(7, 3, 'Apa itu variabel dalam pemrograman?', 'Tempat menyimpan file proyek', 'Fungsi untuk mencetak hasil', 'Lokasi memori untuk menyimpan data sementara', 'Kode untuk menghentikan program', 'c'),
(8, 3, 'Manakah dari berikut ini yang merupakan tipe data dalam pemrograman?', 'Integer, String, Boolean', 'Looping, Function, Class', ' If, Else, Switch', 'Public, Private, Protected', 'A'),
(9, 3, 'Apa hasil dari kode berikut dalam bahasa Python: print(3 + 5 * 2)?', '13', ' 16', '10', '11', 'A');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('mahasiswa','dosen') NOT NULL,
  `status` varchar(50) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `status`) VALUES
(1, 'rehan nabawy', 'rehan@gmail.com', '$2y$10$3adkU4MgxGaMgiPCbDFIHOWOyoUtg4LPKVSIS9XauHa6oTJchrQKq', 'mahasiswa', 'active'),
(2, 'dosenku', 'dosen@gmail.com', '$2y$10$TrWoAaGVh/qx6ijMs1AfION5Xax862TS.7Lbc5ma4TYWtsSlXNc/6', 'dosen', 'active'),
(3, 'fitra', 'fitra@gmail.com', '$2y$10$am8dmSY2XAemB.mC5YTjcOi.MSiz6vbSrww2N1lXipgXBadrH33vu', 'dosen', 'active'),
(4, 'aji riansyah', 'aji@gmail.com', '$2y$10$mYyKZ7y/pMqrlpSyH56WROZ9A7o2M.lZ004hrxau9p3Kb8vpZLjuW', 'mahasiswa', 'active'),
(5, 'dhimas fahreza', 'dhimas@gmail.com', '$2y$10$M4M6iO/RlNsNWuJ7yOwQQO/ARLHtDGMZuHBez3ys5E.0hewvqpW82', 'mahasiswa', 'active');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `diskusi`
--
ALTER TABLE `diskusi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `hapus`
--
ALTER TABLE `hapus`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `hasil_kuis`
--
ALTER TABLE `hasil_kuis`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_diskusi` (`id_diskusi`);

--
-- Indeks untuk tabel `kuis`
--
ALTER TABLE `kuis`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `soal`
--
ALTER TABLE `soal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kuis` (`id_kuis`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `diskusi`
--
ALTER TABLE `diskusi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `hapus`
--
ALTER TABLE `hapus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `hasil_kuis`
--
ALTER TABLE `hasil_kuis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `komentar`
--
ALTER TABLE `komentar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `kuis`
--
ALTER TABLE `kuis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `materi`
--
ALTER TABLE `materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `soal`
--
ALTER TABLE `soal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `komentar_ibfk_1` FOREIGN KEY (`id_diskusi`) REFERENCES `diskusi` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `soal`
--
ALTER TABLE `soal`
  ADD CONSTRAINT `soal_ibfk_1` FOREIGN KEY (`id_kuis`) REFERENCES `kuis` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
