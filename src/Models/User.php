<?php

namespace App\Models;

use App\Utils\Security;

class User extends BaseModel
{
    protected string $table = 'users';
    protected array $fillable = [
        'username', 'email', 'password', 'role', 'status'
    ];
    
    public function authenticate(string $email, string $password, string $role): ?array
    {
        $user = $this->query
            ->table($this->table)
            ->where('email', '=', $email)
            ->where('role', '=', $role)
            ->first();
        
        if ($user && Security::verifyPassword($password, $user['password'])) {
            return $user;
        }
        
        return null;
    }
    
    public function emailExists(string $email): bool
    {
        $user = $this->findBy('email', $email);
        return $user !== null;
    }
    
    public function createUser(array $userData): bool
    {
        // Hash the password before storing
        if (isset($userData['password'])) {
            $userData['password'] = Security::hashPassword($userData['password']);
        }
        
        // Set default status if not provided
        if (!isset($userData['status'])) {
            $userData['status'] = 'active';
        }
        
        return $this->create($userData);
    }
    
    public function getActiveUsers(): array
    {
        return $this->query
            ->table($this->table)
            ->where('status', '=', 'active')
            ->get();
    }
    
    public function getUsersByRole(string $role): array
    {
        return $this->query
            ->table($this->table)
            ->where('role', '=', $role)
            ->where('status', '=', 'active')
            ->orderBy('username', 'ASC')
            ->get();
    }
    
    public function updatePassword(int $userId, string $newPassword): bool
    {
        $hashedPassword = Security::hashPassword($newPassword);
        
        return $this->update($userId, ['password' => $hashedPassword]);
    }
    
    public function deactivateUser(int $userId): bool
    {
        return $this->update($userId, ['status' => 'inactive']);
    }
    
    public function activateUser(int $userId): bool
    {
        return $this->update($userId, ['status' => 'active']);
    }
}