<?php
session_start();

// Handle quiz reset first
if (isset($_GET['action']) && $_GET['action'] === 'reset') {
    session_destroy();
    session_start(); // Restart session after destroy
}

// Initialize session variables - Always reset if not explicitly started
if (!isset($_SESSION['quiz_started'])) {
    $_SESSION['quiz_started'] = false;
}

// Reset session if quiz is not started
if ($_SESSION['quiz_started'] === false) {
    $_SESSION['current_question'] = 0;
    $_SESSION['score'] = 0;
    $_SESSION['answers'] = [];
    $_SESSION['start_time'] = null;
    $_SESSION['questions'] = [];
    $_SESSION['student_name'] = '';
    $_SESSION['student_id'] = '';
    $_SESSION['category'] = '';
    $_SESSION['difficulty'] = '';
    $_SESSION['timed_mode'] = false;
}

require_once 'includes/config.php';
require_once 'includes/functions.php';

$page_title = "Quiz System";

// Get statistics for display
$stats = get_quiz_statistics();

// Check if category was selected from categories page
$selected_category = isset($_GET['selected_category']) ? $_GET['selected_category'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Minimalist Claymorphism Overrides */
        :root {
            --clay-bg: #f0f4f8;
            --clay-shadow: 8px 8px 16px rgba(163, 177, 198, 0.3), 
                          -8px -8px 16px rgba(255, 255, 255, 0.8);
            --clay-shadow-sm: 4px 4px 8px rgba(163, 177, 198, 0.2), 
                            -4px -4px 8px rgba(255, 255, 255, 0.6);
            --clay-shadow-hover: 10px 10px 20px rgba(163, 177, 198, 0.4), 
                               -10px -10px 20px rgba(255, 255, 255, 0.7);
            --border-radius: 20px;
            --border-radius-sm: 12px;
        }
        
        body {
            background: var(--clay-bg);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: #334155;
            line-height: 1.5;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Minimalist Header */
        .header {
            background: var(--clay-bg);
            padding: 20px 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--clay-shadow);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .logo i {
            font-size: 1.8rem;
            color: var(--primary-color);
        }
        
        .logo h1 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
        }
        
        /* Minimalist Navigation */
        .nav {
            display: flex;
            gap: 8px;
        }
        
        .nav-link {
            padding: 10px 16px;
            border-radius: var(--border-radius-sm);
            text-decoration: none;
            color: #64748b;
            font-weight: 500;
            font-size: 0.9rem;
            background: var(--clay-bg);
            box-shadow: var(--clay-shadow-sm);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .nav-link:hover {
            color: var(--primary-color);
            box-shadow: var(--clay-shadow-inset);
        }
        
        .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            box-shadow: var(--clay-shadow-sm);
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 30px;
        }
        
        /* Welcome Card */
        .welcome-card {
            background: white;
            padding: 40px;
            border-radius: var(--border-radius);
            box-shadow: var(--clay-shadow);
            text-align: center;
        }
        
        .welcome-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }
        
        .welcome-card h2 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            color: #1e293b;
        }
        
        .welcome-card > p {
            color: #64748b;
            margin-bottom: 30px;
        }
        
        /* Minimalist Form */
        .start-form {
            max-width: 500px;
            margin: 0 auto;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #475569;
            font-size: 0.9rem;
        }
        
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: var(--border-radius-sm);
            font-size: 0.95rem;
            background: white;
            transition: all 0.2s ease;
        }
        
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        
        .checkbox-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        
        /* Minimalist Button */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: var(--clay-shadow-sm);
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--clay-shadow-hover);
        }
        
        /* Stats Section */
        .stats-section {
            background: white;
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--clay-shadow);
        }
        
        .stats-section h3 {
            text-align: center;
            margin-bottom: 25px;
            color: #1e293b;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .mini-stat-card {
            background: var(--clay-bg);
            padding: 20px;
            border-radius: var(--border-radius);
            box-shadow: var(--clay-shadow-sm);
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.2s ease;
        }
        
        .mini-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--clay-shadow-hover);
        }
        
        .mini-stat-card i {
            font-size: 1.8rem;
            color: var(--primary-color);
        }
        
        .mini-stat-card h4 {
            font-size: 1.5rem;
            color: #1e293b;
            margin-bottom: 4px;
        }
        
        .mini-stat-card p {
            color: #64748b;
            font-size: 0.85rem;
        }
        
        /* Footer */
        .footer {
            text-align: center;
            padding: 25px;
            color: #64748b;
            font-size: 0.9rem;
            margin-top: 30px;
        }
        
        .footer p {
            margin: 4px 0;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                padding: 20px;
            }
            
            .nav {
                width: 100%;
                justify-content: center;
            }
            
            .nav-link .nav-text {
                display: none;
            }
            
            .nav-link {
                padding: 12px;
                min-width: 50px;
                justify-content: center;
            }
            
            .welcome-card {
                padding: 25px;
            }
            
            .stats-cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="logo">
                <i class="fas fa-brain"></i>
                <h1>Quiz System</h1>
            </div>
            <nav class="nav">
                <a href="index.php" class="nav-link active">
                    <i class="fas fa-home"></i>
                    <span class="nav-text">Home</span>
                </a>
                <a href="categories.php" class="nav-link">
                    <i class="fas fa-list"></i>
                    <span class="nav-text">Categories</span>
                </a>
                <a href="leaderboard.php" class="nav-link">
                    <i class="fas fa-trophy"></i>
                    <span class="nav-text">Leaderboard</span>
                </a>
                <a href="admin/login.php" class="nav-link">
                    <i class="fas fa-user-shield"></i>
                    <span class="nav-text">Admin</span>
                </a>
            </nav>
        </header>

        <main class="main-content">
            <div class="welcome-card">
                <i class="fas fa-graduation-cap welcome-icon"></i>
                <h2>Welcome to Quiz System</h2>
                <p>Test your knowledge with our minimalist quiz platform</p>
                
                <form action="quiz.php" method="POST" class="start-form">
                    <div class="form-group">
                        <label for="student_name">Your Name</label>
                        <input type="text" id="student_name" name="student_name" required 
                               placeholder="Enter your full name">
                    </div>
                    
                    <div class="form-group">
                        <label for="student_id">Student ID (Optional)</label>
                        <input type="text" id="student_id" name="student_id" 
                               placeholder="Enter your student ID">
                    </div>

                    <div class="form-group">
                        <label for="category">Select Category</label>
                        <select id="category" name="category" required>
                            <option value="">Choose a category...</option>
                            <option value="general" <?php echo ($selected_category === 'general') ? 'selected' : ''; ?>>General Knowledge</option>
                            <option value="math" <?php echo ($selected_category === 'math') ? 'selected' : ''; ?>>Mathematics</option>
                            <option value="science" <?php echo ($selected_category === 'science') ? 'selected' : ''; ?>>Science</option>
                            <option value="history" <?php echo ($selected_category === 'history') ? 'selected' : ''; ?>>History</option>
                            <option value="geography" <?php echo ($selected_category === 'geography') ? 'selected' : ''; ?>>Geography</option>
                            <option value="programming" <?php echo ($selected_category === 'programming') ? 'selected' : ''; ?>>Programming</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="difficulty">Difficulty Level</label>
                        <select id="difficulty" name="difficulty" required>
                            <option value="">Choose difficulty...</option>
                            <option value="easy">Easy (10 questions)</option>
                            <option value="medium">Medium (15 questions)</option>
                            <option value="hard">Hard (20 questions)</option>
                        </select>
                    </div>

                    <div class="form-group checkbox-group">
                        <label>
                            <input type="checkbox" name="timed_mode" value="1">
                            <span>Enable Timer (30 seconds per question)</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-primary">
                        <i class="fas fa-play"></i> Start Quiz
                    </button>
                </form>
            </div>

            <!-- Statistics Section -->
            <div class="stats-section">
                <h3><i class="fas fa-chart-bar"></i> Quiz Statistics</h3>
                <div class="stats-cards">
                    <div class="mini-stat-card">
                        <i class="fas fa-clipboard-list"></i>
                        <div>
                            <h4><?php echo $stats['total_quizzes']; ?></h4>
                            <p>Quizzes Taken</p>
                        </div>
                    </div>
                    <div class="mini-stat-card">
                        <i class="fas fa-users"></i>
                        <div>
                            <h4><?php echo $stats['total_students']; ?></h4>
                            <p>Students</p>
                        </div>
                    </div>
                    <div class="mini-stat-card">
                        <i class="fas fa-star"></i>
                        <div>
                            <h4><?php echo number_format($stats['avg_score'], 1); ?>%</h4>
                            <p>Average Score</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="footer">
            <p>&copy; <?php echo date('Y'); ?> Quiz System. All rights reserved.</p>
            <p>Minimalist Claymorphism Design</p>
        </footer>
    </div>

    <script>
        <?php if ($selected_category): ?>
        // Scroll to the form when category is pre-selected
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.start-form');
            if (form) {
                form.scrollIntoView({ behavior: 'smooth', block: 'center' });
                // Highlight the form briefly
                form.style.boxShadow = '0 0 20px rgba(99, 102, 241, 0.3)';
                setTimeout(() => {
                    form.style.boxShadow = '';
                }, 2000);
            }
        });
        <?php endif; ?>
    </script>
</body>
</html>
