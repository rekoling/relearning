<?php

namespace App\Models;

class Discussion extends BaseModel
{
    protected string $table = 'diskusi';
    protected array $fillable = [
        'judul', 'deskripsi', 'gambar', 'isi', 'pengguna'
    ];
    
    public function getAllDiscussions(): array
    {
        return $this->query
            ->table($this->table)
            ->orderBy('tanggal_post', 'DESC')
            ->get();
    }
    
    public function getDiscussionWithComments(int $discussionId): ?array
    {
        $discussion = $this->find($discussionId);
        
        if ($discussion) {
            $comments = $this->query
                ->table('komentar')
                ->where('id_diskusi', '=', $discussionId)
                ->orderBy('tanggal_post', 'ASC')
                ->get();
            
            $discussion['comments'] = $comments;
            $discussion['jumlah_komentar'] = count($comments);
        }
        
        return $discussion;
    }
    
    public function createDiscussion(array $discussionData): int
    {
        $discussionData['tanggal_post'] = date('Y-m-d H:i:s');
        $discussionData['jumlah_komentar'] = 0;
        
        if ($this->create($discussionData)) {
            return (int) $this->getLastInsertId();
        }
        
        return 0;
    }
    
    public function addComment(int $discussionId, array $commentData): bool
    {
        $commentData['id_diskusi'] = $discussionId;
        $commentData['tanggal_post'] = date('Y-m-d H:i:s');
        
        $commentAdded = $this->query
            ->table('komentar')
            ->insert($commentData);
        
        if ($commentAdded) {
            // Update comment count
            $this->updateCommentCount($discussionId);
        }
        
        return $commentAdded;
    }
    
    public function getComments(int $discussionId): array
    {
        return $this->query
            ->table('komentar')
            ->where('id_diskusi', '=', $discussionId)
            ->orderBy('tanggal_post', 'ASC')
            ->get();
    }
    
    public function updateCommentCount(int $discussionId): bool
    {
        $commentCount = $this->query
            ->execute("SELECT COUNT(*) as count FROM komentar WHERE id_diskusi = :id", [
                'id' => $discussionId
            ])
            ->fetch()['count'];
        
        return $this->update($discussionId, ['jumlah_komentar' => $commentCount]);
    }
    
    public function searchDiscussions(string $searchTerm): array
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE judul LIKE :search 
                   OR deskripsi LIKE :search 
                   OR isi LIKE :search
                ORDER BY tanggal_post DESC";
        
        $stmt = $this->query->execute($sql, [
            'search' => '%' . $searchTerm . '%'
        ]);
        
        return $stmt->fetchAll();
    }
    
    public function getDiscussionsByUser(string $username): array
    {
        return $this->query
            ->table($this->table)
            ->where('pengguna', '=', $username)
            ->orderBy('tanggal_post', 'DESC')
            ->get();
    }
}