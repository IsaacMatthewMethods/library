<?php
require 'functions.php';
requireAdmin();

// Handle user actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $userId = intval($_GET['id']);
    
    switch ($_GET['action']) {
        case 'delete':
            $conn->query("DELETE FROM users WHERE id = $userId");
            break;
        case 'make_admin':
            $conn->query("UPDATE users SET role = 'admin' WHERE id = $userId");
            break;
        case 'remove_admin':
            $conn->query("UPDATE users SET role = 'user' WHERE id = $userId");
            break;
    }
    
    header("Location: manage_users.php");
    exit();
}

// Get all users
$users = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users | <?= SITE_NAME ?></title>
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
        <h1>Manage Users</h1>
        
        <table class="users-table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?= $user['username'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= ucfirst($user['role']) ?></td>
                        <td><?= date('M j, Y', strtotime($user['created_at'])) ?></td>
                        <td class="actions">
                            <?php if ($user['role'] === 'admin' && $user['id'] !== $_SESSION['user_id']): ?>
                                <a href="manage_users.php?action=remove_admin&id=<?= $user['id'] ?>" class="btn">Remove Admin</a>
                            <?php elseif ($user['role'] === 'user'): ?>
                                <a href="manage_users.php?action=make_admin&id=<?= $user['id'] ?>" class="btn">Make Admin</a>
                            <?php endif; ?>
                            
                            <?php if ($user['id'] !== $_SESSION['user_id']): ?>
                                <a href="manage_users.php?action=delete&id=<?= $user['id'] ?>" class="btn delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</body>
</html>