<?php
include 'koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID kuis tidak ditemukan.";
    exit;
}

$id_kuis = intval($_GET['id']);

// Ambil data kuis dan soal
$kuis = mysqli_query($conn, "SELECT * FROM kuis WHERE id = $id_kuis");
if (!$data_kuis = mysqli_fetch_assoc($kuis)) {
    echo "Kuis tidak ditemukan.";
    exit;
}

$soal = mysqli_query($conn, "SELECT * FROM soal WHERE id_kuis = $id_kuis ORDER BY id ASC");

$soal_arr = [];
while($row = mysqli_fetch_assoc($soal)){
    $soal_arr[] = $row;
}

$from = isset($_GET['from']) ? $_GET['from'] : 'info';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Quiz - <?= htmlspecialchars($data_kuis['judul']) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    html, body {
      height: 100%;
      margin: 0;
      background: #f4f7fa;
    }
    .full-height {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .quiz-wrapper {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .quiz-container {
      width: 100%;
      max-width: 900px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
      padding: 40px;
      margin: 40px 20px;
    }
    .question {
      display: none;
    }
    .question.active {
      display: block;
    }
    .options .form-check {
      margin-bottom: 12px;
    }
    .navigation {
      margin-top: 20px;
      display: flex;
      justify-content: space-between;
    }
    .progress-indicator {
      margin-bottom: 20px;
    }
    .progress-indicator span {
      display: inline-block;
      width: 32px;
      height: 32px;
      line-height: 32px;
      background: #dee2e6;
      color: #495057;
      border-radius: 50%;
      text-align: center;
      margin-right: 5px;
      cursor: pointer;
      transition: background 0.2s;
    }
    .progress-indicator span.answered {
      background: #0d6efd;
      color: white;
    }
    .progress-indicator span.active {
      border: 2px solid #0d6efd;
    }
    .btn-kembali {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

<div class="full-height">

  <div class="quiz-wrapper">
    <div class="quiz-container">

      <!-- Tombol kembali -->
      <a href="<?= htmlspecialchars($from) ?>.php" class="btn btn-outline-secondary btn-sm btn-kembali">← Kembali ke Beranda</a>

      <!-- Judul kuis -->
      <h2><?= htmlspecialchars($data_kuis['judul']) ?></h2>
      <p><?= nl2br(htmlspecialchars($data_kuis['deskripsi'])) ?></p>

      <!-- Form kuis -->
<form id="quizForm" action="proses_jawab_kuis.php" method="POST">
  <input type="hidden" name="id_kuis" value="<?= $id_kuis ?>">
  <input type="hidden" name="from" value="<?= htmlspecialchars($from) ?>">

  <div class="progress-indicator" id="progressIndicator">
    <?php for($i=0; $i < count($soal_arr); $i++): ?>
      <span data-index="<?= $i ?>" title="Soal <?= $i+1 ?>"><?= $i+1 ?></span>
    <?php endfor; ?>
  </div>

  <?php foreach($soal_arr as $index => $s): ?>
    <div class="question <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>">
      <p><strong>Soal <?= $index+1 ?>:</strong> <?= htmlspecialchars($s['pertanyaan']) ?></p>
      <div class="options">
        <?php
          $ops = ['a','b','c','d'];
          foreach($ops as $op):
            if(!empty($s["opsi_".$op])):
              $id_input = "q{$index}_{$op}";
        ?>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="jawaban[<?= $s['id'] ?>]" id="<?= $id_input ?>" value="<?= strtoupper($op) ?>">
            <label class="form-check-label" for="<?= $id_input ?>"><?= htmlspecialchars($s["opsi_".$op]) ?></label>
          </div>
        <?php
            endif;
          endforeach;
        ?>
      </div>
    </div>
  <?php endforeach; ?>

        <div class="navigation">
          <button type="button" id="prevBtn" class="btn btn-secondary" disabled>← Sebelumnya</button>
          <button type="button" id="nextBtn" class="btn btn-primary">Berikutnya →</button>
          <button type="submit" id="submitBtn" class="btn btn-success d-none">Kirim Jawaban</button>
        </div>
      </form>
    </div>
  </div>

</div>

<script>
  const questions = document.querySelectorAll('.question');
  const progressSpans = document.querySelectorAll('#progressIndicator span');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const submitBtn = document.getElementById('submitBtn');
  let currentQuestion = 0;

  function showQuestion(index) {
    questions.forEach((q,i) => {
      q.classList.toggle('active', i === index);
    });
    progressSpans.forEach((span,i) => {
      span.classList.toggle('active', i === index);
    });

    prevBtn.disabled = index === 0;
    nextBtn.classList.toggle('d-none', index === questions.length - 1);
    submitBtn.classList.toggle('d-none', index !== questions.length - 1);
  }

  function updateAnswered() {
    questions.forEach((q,i) => {
      const radios = q.querySelectorAll('input[type=radio]');
      let answered = false;
      radios.forEach(r => {
        if(r.checked) answered = true;
      });
      if(answered) {
        progressSpans[i].classList.add('answered');
      } else {
        progressSpans[i].classList.remove('answered');
      }
    });
  }

  progressSpans.forEach(span => {
    span.addEventListener('click', () => {
      const idx = parseInt(span.dataset.index);
      currentQuestion = idx;
      showQuestion(currentQuestion);
    });
  });

  prevBtn.addEventListener('click', () => {
    if (currentQuestion > 0) {
      currentQuestion--;
      showQuestion(currentQuestion);
    }
  });

  nextBtn.addEventListener('click', () => {
    if (currentQuestion < questions.length - 1) {
      currentQuestion++;
      showQuestion(currentQuestion);
    }
  });

  document.querySelectorAll('input[type=radio]').forEach(radio => {
    radio.addEventListener('change', () => {
      updateAnswered();
    });
  });

  showQuestion(currentQuestion);

  // Validasi sebelum submit
document.getElementById('quizForm').addEventListener('submit', function(e) {
  const unanswered = [];
  questions.forEach((q, i) => {
    const radios = q.querySelectorAll('input[type=radio]');
    let answered = false;
    radios.forEach(r => {
      if (r.checked) answered = true;
    });
    if (!answered) {
      unanswered.push(i + 1); // index soal dimulai dari 1
    }
  });

  if (unanswered.length > 0) {
    e.preventDefault();
    alert("Silakan isi semua soal terlebih dahulu sebelum mengumpulkan kuis.\nBelum dijawab: Soal " + unanswered.join(", "));
    showQuestion(unanswered[0] - 1); // arahkan ke soal pertama yang kosong
  }
});

</script>

</body>
</html>
