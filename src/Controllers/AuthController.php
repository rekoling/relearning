<?php

namespace App\Controllers;

use App\Models\User;
use App\Utils\Validator;
use App\Utils\Security;

class AuthController extends BaseController
{
    private User $userModel;
    
    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }
    
    public function showLogin(): void
    {
        if ($this->isAuthenticated()) {
            $this->redirectToDashboard();
        }
        
        $this->view('auth/login');
    }
    
    public function login(): void
    {
        if (!$this->validateCSRF()) {
            $this->view('auth/login', ['error' => 'Invalid CSRF token']);
            return;
        }
        
        $validator = new Validator($this->getAllInput());
        $validator
            ->required('email', 'Email is required')
            ->email('email', 'Please enter a valid email address')
            ->required('password', 'Password is required')
            ->required('role', 'Please select a role')
            ->in('role', ['mahasiswa', 'dosen'], 'Invalid role selected');
        
        if ($validator->fails()) {
            $this->view('auth/login', [
                'errors' => $validator->getErrors(),
                'old_input' => $this->getAllInput()
            ]);
            return;
        }
        
        $email = $this->sanitize($this->getInput('email'));
        $password = $this->getInput('password');
        $role = $this->sanitize($this->getInput('role'));
        
        $user = $this->userModel->authenticate($email, $password, $role);
        
        if ($user) {
            $this->createSession($user);
            $this->redirectToDashboard();
        } else {
            $this->view('auth/login', [
                'error' => 'Invalid credentials or role mismatch',
                'old_input' => $this->getAllInput()
            ]);
        }
    }
    
    public function showRegister(): void
    {
        if ($this->isAuthenticated()) {
            $this->redirectToDashboard();
        }
        
        $this->view('auth/register');
    }
    
    public function register(): void
    {
        if (!$this->validateCSRF()) {
            $this->view('auth/register', ['error' => 'Invalid CSRF token']);
            return;
        }
        
        $validator = new Validator($this->getAllInput());
        $validator
            ->required('username', 'Username is required')
            ->minLength('username', 3, 'Username must be at least 3 characters')
            ->maxLength('username', 50, 'Username must not exceed 50 characters')
            ->required('email', 'Email is required')
            ->email('email', 'Please enter a valid email address')
            ->required('password', 'Password is required')
            ->minLength('password', 8, 'Password must be at least 8 characters')
            ->required('role', 'Please select a role')
            ->in('role', ['mahasiswa', 'dosen'], 'Invalid role selected');
        
        if ($validator->fails()) {
            $this->view('auth/register', [
                'errors' => $validator->getErrors(),
                'old_input' => $this->getAllInput()
            ]);
            return;
        }
        
        $email = $this->sanitize($this->getInput('email'));
        
        // Check if email already exists
        if ($this->userModel->emailExists($email)) {
            $this->view('auth/register', [
                'error' => 'Email address is already registered',
                'old_input' => $this->getAllInput()
            ]);
            return;
        }
        
        $userData = [
            'username' => $this->sanitize($this->getInput('username')),
            'email' => $email,
            'password' => $this->getInput('password'),
            'role' => $this->sanitize($this->getInput('role'))
        ];
        
        if ($this->userModel->createUser($userData)) {
            $this->redirect('/index.php?register=success');
        } else {
            $this->view('auth/register', [
                'error' => 'Registration failed. Please try again.',
                'old_input' => $this->getAllInput()
            ]);
        }
    }
    
    public function logout(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        
        $this->redirect('/index.php');
    }
    
    private function createSession(array $user): void
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['status'] = $user['status'];
        $_SESSION['login_time'] = time();
    }
    
    private function redirectToDashboard(): void
    {
        $role = $_SESSION['role'] ?? '';
        
        if ($role === 'mahasiswa') {
            $this->redirect('/profile.php');
        } else {
            $this->redirect('/profiled.php');
        }
    }
}