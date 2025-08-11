<?php

namespace App\Models;

class Quiz extends BaseModel
{
    protected string $table = 'kuis';
    protected array $fillable = [
        'judul', 'deskripsi', 'gambar'
    ];
    
    public function getAllQuizzes(): array
    {
        return $this->query
            ->table($this->table)
            ->orderBy('tanggal_upload', 'DESC')
            ->get();
    }
    
    public function getQuizWithQuestions(int $quizId): ?array
    {
        $quiz = $this->find($quizId);
        
        if ($quiz) {
            $questions = $this->query
                ->table('soal')
                ->where('id_kuis', '=', $quizId)
                ->get();
            
            $quiz['questions'] = $questions;
        }
        
        return $quiz;
    }
    
    public function createQuiz(array $quizData): int
    {
        $quizData['tanggal_upload'] = date('Y-m-d H:i:s');
        
        if ($this->create($quizData)) {
            return (int) $this->getLastInsertId();
        }
        
        return 0;
    }
    
    public function addQuestion(int $quizId, array $questionData): bool
    {
        $questionData['id_kuis'] = $quizId;
        
        return $this->query
            ->table('soal')
            ->insert($questionData);
    }
    
    public function getQuestions(int $quizId): array
    {
        return $this->query
            ->table('soal')
            ->where('id_kuis', '=', $quizId)
            ->get();
    }
    
    public function submitQuizAnswers(int $quizId, array $answers): array
    {
        $questions = $this->getQuestions($quizId);
        $totalQuestions = count($questions);
        $correctAnswers = 0;
        
        foreach ($questions as $question) {
            $questionId = $question['id'];
            $correctAnswer = $question['jawaban_benar'];
            $userAnswer = $answers[$questionId] ?? null;
            
            if ($userAnswer && strtolower($userAnswer) === strtolower($correctAnswer)) {
                $correctAnswers++;
            }
        }
        
        $score = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;
        
        // Save quiz result
        $resultData = [
            'id_kuis' => $quizId,
            'total_soal' => $totalQuestions,
            'jawaban_benar' => $correctAnswers,
            'skor' => $score
        ];
        
        $this->query
            ->table('hasil_kuis')
            ->insert($resultData);
        
        return [
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'score' => round($score, 2)
        ];
    }
    
    public function getQuizResults(int $quizId): array
    {
        return $this->query
            ->table('hasil_kuis')
            ->where('id_kuis', '=', $quizId)
            ->orderBy('id', 'DESC')
            ->get();
    }
}