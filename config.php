<?php
/**
 * eLibrary Configuration File
 * Prevents multiple loading and handles all setup
 */

// Prevent direct access
if (!defined('PROJECT_ROOT')) {
    define('PROJECT_ROOT', __DIR__);
}

// Check if config already loaded
if (defined('ELIBRARY_CONFIG_LOADED')) {
    return;
}

// Enable error reporting for development
if (!defined('ENVIRONMENT')) {
    define('ENVIRONMENT', 'development'); // Change to 'production' when live
}

if (ENVIRONMENT === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

// ========== DATABASE CONFIGURATION ========== //
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'elibrary');

// ========== APPLICATION CONFIGURATION ========== //
define('SITE_NAME', 'KadPoly eLibrary');
define('SITE_THEME', '#1a5e1a');
define('BASE_URL', 'http://localhost/elibrary/');
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10MB

// ========== SESSION HANDLING ========== //
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 86400, // 1 day
        'path' => '/',
        'secure' => false,    // Set to true if using HTTPS
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

// ========== DATABASE CONNECTION ========== //
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
    
    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }

    // Create database if not exists
    $conn->query("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
    $conn->select_db(DB_NAME);

    // Create tables if not exists
    $conn->query("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin','user') DEFAULT 'user',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $conn->query("CREATE TABLE IF NOT EXISTS books (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        author VARCHAR(100) NOT NULL,
        description TEXT,
        cover_image VARCHAR(255),
        file_path VARCHAR(255) NOT NULL,
        category VARCHAR(50),
        upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        uploaded_by INT
    )");

} catch (Exception $e) {
    die("System initialization failed: " . $e->getMessage());
}

// ========== FILE SYSTEM SETUP ========== //
$required_dirs = [
    'assets/covers',
    'assets/uploads'
];

foreach ($required_dirs as $dir) {
    $path = PROJECT_ROOT . '/' . $dir;
    if (!file_exists($path)) {
        mkdir($path, 0755, true);
    }
}

// Mark config as loaded
define('ELIBRARY_CONFIG_LOADED', true);

// No closing tag to prevent whitespace issues