<?php

namespace App\Database;

use PDO;
use PDOStatement;

class QueryBuilder
{
    private PDO $pdo;
    private string $table = '';
    private array $wheres = [];
    private array $bindings = [];
    private string $orderBy = '';
    private string $limit = '';
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function table(string $table): self
    {
        $this->table = $table;
        return $this;
    }
    
    public function where(string $column, string $operator, $value): self
    {
        $placeholder = ':' . $column . '_' . count($this->bindings);
        $this->wheres[] = "$column $operator $placeholder";
        $this->bindings[$placeholder] = $value;
        return $this;
    }
    
    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->orderBy = "ORDER BY $column $direction";
        return $this;
    }
    
    public function limit(int $limit, int $offset = 0): self
    {
        $this->limit = "LIMIT $limit" . ($offset > 0 ? " OFFSET $offset" : '');
        return $this;
    }
    
    public function get(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        
        if (!empty($this->wheres)) {
            $sql .= ' WHERE ' . implode(' AND ', $this->wheres);
        }
        
        if ($this->orderBy) {
            $sql .= ' ' . $this->orderBy;
        }
        
        if ($this->limit) {
            $sql .= ' ' . $this->limit;
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bindings);
        
        return $stmt->fetchAll();
    }
    
    public function first(): ?array
    {
        $this->limit(1);
        $results = $this->get();
        return $results[0] ?? null;
    }
    
    public function insert(array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute($data);
    }
    
    public function update(array $data): bool
    {
        $sets = [];
        foreach ($data as $column => $value) {
            $sets[] = "$column = :$column";
        }
        
        $sql = "UPDATE {$this->table} SET " . implode(', ', $sets);
        
        if (!empty($this->wheres)) {
            $sql .= ' WHERE ' . implode(' AND ', $this->wheres);
            $data = array_merge($data, $this->bindings);
        }
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }
    
    public function delete(): bool
    {
        $sql = "DELETE FROM {$this->table}";
        
        if (!empty($this->wheres)) {
            $sql .= ' WHERE ' . implode(' AND ', $this->wheres);
        }
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($this->bindings);
    }
    
    public function execute(string $sql, array $bindings = []): PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($bindings);
        return $stmt;
    }
}