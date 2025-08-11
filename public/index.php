<?php

require_once __DIR__ . '/../src/bootstrap.php';

use App\Controllers\AuthController;

$authController = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController->login();
} else {
    $authController->showLogin();
}