<?php

namespace App\Models;

use App\Database\Connection;
use App\Database\QueryBuilder;
use PDO;

abstract class BaseModel
{
    protected PDO $pdo;
    protected QueryBuilder $query;
    protected string $table;
    protected string $primaryKey = 'id';
    protected array $fillable = [];
    
    public function __construct()
    {
        $this->pdo = Connection::getInstance();
        $this->query = new QueryBuilder($this->pdo);
    }
    
    public function find(int $id): ?array
    {
        return $this->query
            ->table($this->table)
            ->where($this->primaryKey, '=', $id)
            ->first();
    }
    
    public function findBy(string $column, $value): ?array
    {
        return $this->query
            ->table($this->table)
            ->where($column, '=', $value)
            ->first();
    }
    
    public function all(): array
    {
        return $this->query
            ->table($this->table)
            ->get();
    }
    
    public function where(string $column, string $operator, $value): QueryBuilder
    {
        return $this->query
            ->table($this->table)
            ->where($column, $operator, $value);
    }
    
    public function create(array $data): bool
    {
        $filteredData = $this->filterFillable($data);
        return $this->query
            ->table($this->table)
            ->insert($filteredData);
    }
    
    public function update(int $id, array $data): bool
    {
        $filteredData = $this->filterFillable($data);
        return $this->query
            ->table($this->table)
            ->where($this->primaryKey, '=', $id)
            ->update($filteredData);
    }
    
    public function delete(int $id): bool
    {
        return $this->query
            ->table($this->table)
            ->where($this->primaryKey, '=', $id)
            ->delete();
    }
    
    protected function filterFillable(array $data): array
    {
        if (empty($this->fillable)) {
            return $data;
        }
        
        return array_intersect_key($data, array_flip($this->fillable));
    }
    
    public function getLastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }
}