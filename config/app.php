<?php

return [
    'name' => $_ENV['APP_NAME'] ?? 'E-Learning System',
    'env' => $_ENV['APP_ENV'] ?? 'production',
    'debug' => filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN),
    'url' => $_ENV['APP_URL'] ?? 'http://localhost',
    
    'session' => [
        'lifetime' => (int) ($_ENV['SESSION_LIFETIME'] ?? 3600),
        'secure' => $_ENV['APP_ENV'] === 'production',
        'httponly' => true,
        'samesite' => 'Strict'
    ],
    
    'csrf' => [
        'token_name' => $_ENV['CSRF_TOKEN_NAME'] ?? 'csrf_token'
    ],
    
    'uploads' => [
        'max_size' => (int) ($_ENV['UPLOAD_MAX_SIZE'] ?? 10485760), // 10MB
        'materials_path' => $_ENV['UPLOAD_MATERIALS_PATH'] ?? 'uploads/materials/',
        'profiles_path' => $_ENV['UPLOAD_PROFILES_PATH'] ?? 'uploads/profiles/',
        'discussions_path' => $_ENV['UPLOAD_DISCUSSIONS_PATH'] ?? 'uploads/discussions/',
        'allowed_images' => explode(',', $_ENV['ALLOWED_IMAGE_EXTENSIONS'] ?? 'jpg,jpeg,png,gif'),
        'allowed_documents' => explode(',', $_ENV['ALLOWED_DOCUMENT_EXTENSIONS'] ?? 'pdf,doc,docx,ppt,pptx')
    ]
];