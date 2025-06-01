<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil dan validasi data dari form
    $id_kuis = isset($_POST['id_kuis']) ? (int) $_POST['id_kuis'] : 0;
    $question = trim($_POST['question']);
    $option_a = trim($_POST['option_a']);
    $option_b = trim($_POST['option_b']);
    $option_c = trim($_POST['option_c']);
    $option_d = trim($_POST['option_d']);
    $correct_answer = strtoupper(trim($_POST['correct_answer'])); // A/B/C/D

    // Cek semua input terisi
    if ($id_kuis && $question && $option_a && $option_b && $option_c && $option_d && in_array($correct_answer, ['A', 'B', 'C', 'D'])) {
        // Masukkan ke database
        $sql = "INSERT INTO soal (id_kuis, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "issssss", $id_kuis, $question, $option_a, $option_b, $option_c, $option_d, $correct_answer);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Redirect ke halaman quiz detail
        header("Location: quiz.php?id=$id_kuis");
        exit();
    } else {
        // Jika input tidak lengkap atau salah
        echo "Gagal: Semua kolom harus diisi dan jawaban benar harus berupa A/B/C/D.";
    }
}
?>
