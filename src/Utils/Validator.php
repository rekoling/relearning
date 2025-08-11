<?php

namespace App\Utils;

class Validator
{
    private array $errors = [];
    private array $data = [];
    
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    
    public function required(string $field, string $message = null): self
    {
        if (!isset($this->data[$field]) || trim($this->data[$field]) === '') {
            $this->errors[$field][] = $message ?? "The {$field} field is required.";
        }
        
        return $this;
    }
    
    public function email(string $field, string $message = null): self
    {
        if (isset($this->data[$field]) && !Security::validateEmail($this->data[$field])) {
            $this->errors[$field][] = $message ?? "The {$field} must be a valid email address.";
        }
        
        return $this;
    }
    
    public function minLength(string $field, int $min, string $message = null): self
    {
        if (isset($this->data[$field]) && strlen($this->data[$field]) < $min) {
            $this->errors[$field][] = $message ?? "The {$field} must be at least {$min} characters.";
        }
        
        return $this;
    }
    
    public function maxLength(string $field, int $max, string $message = null): self
    {
        if (isset($this->data[$field]) && strlen($this->data[$field]) > $max) {
            $this->errors[$field][] = $message ?? "The {$field} must not exceed {$max} characters.";
        }
        
        return $this;
    }
    
    public function in(string $field, array $values, string $message = null): self
    {
        if (isset($this->data[$field]) && !in_array($this->data[$field], $values, true)) {
            $this->errors[$field][] = $message ?? "The {$field} field must be one of: " . implode(', ', $values);
        }
        
        return $this;
    }
    
    public function numeric(string $field, string $message = null): self
    {
        if (isset($this->data[$field]) && !is_numeric($this->data[$field])) {
            $this->errors[$field][] = $message ?? "The {$field} must be a number.";
        }
        
        return $this;
    }
    
    public function fileSize(string $field, int $maxSize, string $message = null): self
    {
        if (isset($_FILES[$field]) && $_FILES[$field]['size'] > $maxSize) {
            $maxSizeMB = round($maxSize / 1024 / 1024, 2);
            $this->errors[$field][] = $message ?? "The {$field} file size must not exceed {$maxSizeMB}MB.";
        }
        
        return $this;
    }
    
    public function fileType(string $field, array $allowedTypes, string $message = null): self
    {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
            $filename = $_FILES[$field]['name'];
            if (!Security::isAllowedFileType($filename, $allowedTypes)) {
                $this->errors[$field][] = $message ?? "The {$field} must be one of: " . implode(', ', $allowedTypes);
            }
        }
        
        return $this;
    }
    
    public function passes(): bool
    {
        return empty($this->errors);
    }
    
    public function fails(): bool
    {
        return !$this->passes();
    }
    
    public function getErrors(): array
    {
        return $this->errors;
    }
    
    public function getFirstError(string $field): ?string
    {
        return $this->errors[$field][0] ?? null;
    }
}