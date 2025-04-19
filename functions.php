<?php
require 'config.php';

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Check if user is admin
function isAdmin() {
    return isLoggedIn() && $_SESSION['role'] === 'admin';
}

// Redirect if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

// Redirect if not admin
function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        header("Location: index.php");
        exit();
    }
}

// Get all books
function getBooks($search = '') {
    global $conn;
    $sql = "SELECT * FROM books";
    if ($search) {
        $sql .= " WHERE title LIKE ? OR author LIKE ?";
        $stmt = $conn->prepare($sql);
        $searchTerm = "%$search%";
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
    } else {
        $stmt = $conn->prepare($sql);
    }
    $stmt->execute();
    return $stmt->get_result();
}

// Upload file helper
function uploadFile($file, $targetDir) {
    $fileName = uniqid() . '-' . basename($file["name"]);
    $targetFile = $targetDir . $fileName;
    
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $fileName;
    }
    return false;
}
?>