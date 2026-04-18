<?php
session_start();

// Simple admin credentials (in production, use database with hashed passwords)
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'admin123'); // Change this!

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Invalid username or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Quiz System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            background: var(--clay-bg);
        }
        
        .login-container {
            max-width: 400px;
            width: 100%;
            background: var(--white);
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--clay-shadow);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .login-header i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        
        .login-header h1 {
            font-size: 1.5rem;
            color: var(--dark-color);
            margin-bottom: 8px;
        }
        
        .login-header p {
            color: var(--gray-600);
            font-size: 0.95rem;
        }
        
        .error-message {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: var(--border-radius-sm);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }
        
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .back-link a:hover {
            color: var(--primary-dark);
        }
        
        .credentials-note {
            margin-top: 25px;
            padding: 12px;
            background: #eff6ff;
            border-radius: var(--border-radius-sm);
            font-size: 0.85rem;
            color: var(--gray-700);
        }
        
        .credentials-note strong {
            display: block;
            margin-bottom: 4px;
        }
        
        .credentials-note em {
            color: #991b1b;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <i class="fas fa-user-shield"></i>
            <h1>Admin Login</h1>
            <p>Access the admin dashboard</p>
        </div>
        
        <?php if ($error): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>
        
        <form method="POST" class="start-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn btn-primary btn-large">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
        
        <div class="back-link">
            <a href="../index.php"><i class="fas fa-arrow-left"></i> Back to Home</a>
        </div>
        
        <div class="credentials-note">
            <strong>Default Credentials:</strong>
            Username: admin<br>
            Password: admin123<br>
            <em>⚠️ Change these in production!</em>
        </div>
    </div>
</body>
</html>
