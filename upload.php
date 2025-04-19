<?php
require 'functions.php';
requireAdmin();

// Handle book deletion
if (isset($_GET['delete'])) {
    $bookId = intval($_GET['delete']);
    $conn->query("DELETE FROM books WHERE id = $bookId");
    header("Location: admin.php");
    exit();
}

// Handle book upload
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    
    // Upload cover image
    $coverImage = '';
    if ($_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
        $coverImage = uploadFile($_FILES['cover_image'], 'assets/covers/');
    }
    
    // Upload book file
    $filePath = '';
    if ($_FILES['book_file']['error'] === UPLOAD_ERR_OK) {
        $filePath = uploadFile($_FILES['book_file'], 'assets/uploads/');
    }
    
    if ($title && $author && $filePath) {
        $stmt = $conn->prepare("INSERT INTO books (title, author, description, cover_image, file_path, category, uploaded_by) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssi", $title, $author, $description, $coverImage, $filePath, $category, $_SESSION['user_id']);
        
        if ($stmt->execute()) {
            header("Location: admin.php");
            exit();
        } else {
            $error = "Failed to upload book. Please try again.";
        }
    } else {
        $error = "Please fill all required fields and upload a book file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Book | <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <a href="index.php" class="logo">
                <i class="fas fa-book-open"></i> <?= SITE_NAME ?>
            </a>
            <nav>
                <a href="admin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="upload.php"><i class="fas fa-upload"></i> Upload Books</a>
                <a href="manage_users.php"><i class="fas fa-users"></i> Manage Users</a>
                <a href="index.php"><i class="fas fa-home"></i> Home</a>
                <a href="login.php?logout=1"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <h1>Upload New Book</h1>
        
        <?php if ($error): ?>
            <div class="alert"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data" class="book-upload-form">
            <div class="form-group">
                <label for="title">Book Title *</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="author">Author *</label>
                <input type="text" id="author" name="author" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="4"></textarea>
            </div>
            
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" id="category" name="category" class="form-control">
            </div>
            
            <div class="form-group">
                <label for="cover_image">Cover Image</label>
                <input type="file" id="cover_image" name="cover_image" class="form-control" accept="image/*">
            </div>
            
            <div class="form-group">
                <label for="book_file">Book File (PDF/EPUB) *</label>
                <input type="file" id="book_file" name="book_file" class="form-control" required accept=".pdf,.epub">
            </div>
            
            <button type="submit" class="form-submit">Upload Book</button>
        </form>
    </main>
</body>
</html>