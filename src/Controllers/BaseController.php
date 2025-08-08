<?php

namespace App\Controllers;

use App\Utils\Security;

abstract class BaseController
{
    protected array $data = [];
    
    public function __construct()
    {
        Security::setSecurityHeaders();
        $this->ensureSession();
    }
    
    protected function ensureSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    protected function view(string $view, array $data = []): void
    {
        $this->data = array_merge($this->data, $data);
        
        // Add CSRF token to all views
        $this->data['csrf_token'] = Security::generateCSRFToken();
        
        // Add user session data if logged in
        if ($this->isAuthenticated()) {
            $this->data['user'] = [
                'id' => $_SESSION['user_id'] ?? null,
                'username' => $_SESSION['username'] ?? '',
                'email' => $_SESSION['email'] ?? '',
                'role' => $_SESSION['role'] ?? '',
                'status' => $_SESSION['status'] ?? ''
            ];
        }
        
        $viewPath = __DIR__ . "/../Views/{$view}.php";
        
        if (file_exists($viewPath)) {
            extract($this->data);
            require $viewPath;
        } else {
            http_response_code(404);
            echo "View not found: {$view}";
        }
    }
    
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }
    
    protected function isAuthenticated(): bool
    {
        return isset($_SESSION['email']) && isset($_SESSION['role']);
    }
    
    protected function requireAuth(): void
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('/index.php');
        }
    }
    
    protected function requireRole(string $role): void
    {
        $this->requireAuth();
        
        if ($_SESSION['role'] !== $role) {
            http_response_code(403);
            echo "Access denied. Required role: {$role}";
            exit;
        }
    }
    
    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    protected function validateCSRF(): bool
    {
        $token = $_POST['csrf_token'] ?? $_GET['csrf_token'] ?? '';
        return Security::verifyCSRFToken($token);
    }
    
    protected function getInput(string $key, $default = null)
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }
    
    protected function getAllInput(): array
    {
        return array_merge($_GET, $_POST);
    }
    
    protected function sanitize(string $input): string
    {
        return Security::sanitizeInput($input);
    }
    
    protected function handleFileUpload(string $fieldName, string $uploadPath, array $allowedTypes): ?string
    {
        if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
            return null;
        }
        
        $file = $_FILES[$fieldName];
        
        if (!Security::isAllowedFileType($file['name'], $allowedTypes)) {
            return null;
        }
        
        $filename = Security::generateSecureFilename($file['name']);
        $destination = rtrim($uploadPath, '/') . '/' . $filename;
        
        // Ensure upload directory exists
        $directory = dirname($destination);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $filename;
        }
        
        return null;
    }
}