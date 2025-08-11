<?php

namespace App\Models;

class Material extends BaseModel
{
    protected string $table = 'materi';
    protected array $fillable = [
        'judul', 'deskripsi', 'isi', 'gambar', 'isi_materi'
    ];
    
    public function getPublishedMaterials(): array
    {
        return $this->query
            ->table($this->table)
            ->orderBy('tanggal_upload', 'DESC')
            ->get();
    }
    
    public function searchMaterials(string $searchTerm): array
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE judul LIKE :search 
                   OR deskripsi LIKE :search 
                   OR isi_materi LIKE :search
                ORDER BY tanggal_upload DESC";
        
        $stmt = $this->query->execute($sql, [
            'search' => '%' . $searchTerm . '%'
        ]);
        
        return $stmt->fetchAll();
    }
    
    public function getMaterialWithContent(int $id): ?array
    {
        return $this->find($id);
    }
    
    public function createMaterial(array $materialData): bool
    {
        // Set upload timestamp
        $materialData['tanggal_upload'] = date('Y-m-d H:i:s');
        
        return $this->create($materialData);
    }
    
    public function softDelete(int $id): bool
    {
        $material = $this->find($id);
        
        if ($material) {
            // Move to deleted materials table
            $deletedData = [
                'id_materi' => $material['id'],
                'judul' => $material['judul'],
                'deskripsi' => $material['deskripsi'],
                'gambar' => $material['gambar'],
                'waktu_hapus' => date('Y-m-d H:i:s')
            ];
            
            $this->query
                ->table('hapus')
                ->insert($deletedData);
            
            // Remove from main table
            return $this->delete($id);
        }
        
        return false;
    }
    
    public function getDeletedMaterials(): array
    {
        return $this->query
            ->table('hapus')
            ->orderBy('waktu_hapus', 'DESC')
            ->get();
    }
}