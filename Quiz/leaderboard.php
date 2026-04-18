<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

$category_filter = $_GET['category'] ?? null;
$leaderboard = get_leaderboard($category_filter, 20);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard - Quiz System</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .leaderboard-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        
        .leaderboard-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 30px;
            border-radius: var(--border-radius);
            text-align: center;
            box-shadow: var(--clay-shadow);
        }
        
        .leaderboard-header h1 {
            font-size: 1.8rem;
            margin-bottom: 8px;
        }
        
        .leaderboard-header p {
            opacity: 0.9;
            font-size: 1rem;
        }
        
        .filter-section {
            background: var(--white);
            padding: 20px;
            border-radius: var(--border-radius);
            box-shadow: var(--clay-shadow-sm);
        }
        
        .filter-section form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .filter-section label {
            font-weight: 500;
            color: var(--gray-700);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .filter-section select {
            padding: 10px 14px;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius-sm);
            font-size: 0.95rem;
            background: white;
            width: 100%;
        }
        
        .leaderboard-table {
            background: var(--white);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--clay-shadow-sm);
        }
        
        .leaderboard-table table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .leaderboard-table th {
            background: var(--primary-color);
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .leaderboard-table td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--gray-200);
            font-size: 0.9rem;
        }
        
        .leaderboard-table tr:hover {
            background: var(--gray-50);
        }
        
        .rank-badge {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 0.85rem;
        }
        
        .rank-1 { background: #fbbf24; }
        .rank-2 { background: #9ca3af; }
        .rank-3 { background: #cd7f32; }
        .rank-other { background: #6b7280; }
        
        .score-badge {
            background: #10b981;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .empty-state {
            padding: 40px;
            text-align: center;
            color: var(--gray-600);
        }
        
        .empty-state i {
            font-size: 2.5rem;
            color: var(--gray-400);
            margin-bottom: 15px;
        }
        
        .empty-state p {
            margin-bottom: 20px;
            font-size: 1rem;
        }
        
        /* Mobile table responsiveness */
        @media (max-width: 768px) {
            .leaderboard-table {
                overflow-x: auto;
            }
            
            .leaderboard-table table {
                min-width: 600px;
            }
            
            .filter-section form {
                flex-direction: column;
            }
        }
        
        @media (min-width: 769px) {
            .filter-section form {
                flex-direction: row;
                align-items: center;
            }
            
            .filter-section select {
                width: auto;
                min-width: 200px;
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
                <a href="index.php" class="nav-link">
                    <i class="fas fa-home"></i>
                    <span class="nav-text">Home</span>
                </a>
                <a href="categories.php" class="nav-link">
                    <i class="fas fa-list"></i>
                    <span class="nav-text">Categories</span>
                </a>
                <a href="leaderboard.php" class="nav-link active">
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
            <div class="leaderboard-container">
                <div class="leaderboard-header">
                    <i class="fas fa-trophy" style="font-size: 3rem; margin-bottom: 15px;"></i>
                    <h1>Leaderboard</h1>
                    <p>Top performers across all quizzes</p>
                </div>

                <div class="filter-section">
                    <form method="GET">
                        <label for="category"><i class="fas fa-filter"></i> Filter by Category:</label>
                        <select name="category" id="category" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            <option value="general" <?php echo $category_filter === 'general' ? 'selected' : ''; ?>>General Knowledge</option>
                            <option value="math" <?php echo $category_filter === 'math' ? 'selected' : ''; ?>>Mathematics</option>
                            <option value="science" <?php echo $category_filter === 'science' ? 'selected' : ''; ?>>Science</option>
                            <option value="history" <?php echo $category_filter === 'history' ? 'selected' : ''; ?>>History</option>
                            <option value="geography" <?php echo $category_filter === 'geography' ? 'selected' : ''; ?>>Geography</option>
                            <option value="programming" <?php echo $category_filter === 'programming' ? 'selected' : ''; ?>>Programming</option>
                        </select>
                    </form>
                </div>

                <div class="leaderboard-table">
                    <?php if (empty($leaderboard)): ?>
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>No results yet. Be the first to take a quiz!</p>
                            <a href="index.php" class="btn btn-primary">Start Quiz</a>
                        </div>
                    <?php else: ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Student Name</th>
                                    <th>Category</th>
                                    <th>Score</th>
                                    <th>Percentage</th>
                                    <th>Time</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($leaderboard as $index => $result): ?>
                                    <tr>
                                        <td>
                                            <div class="rank-badge rank-<?php echo $index < 3 ? $index + 1 : 'other'; ?>">
                                                <?php echo $index + 1; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($result['student_name']); ?></strong>
                                            <?php if (!empty($result['student_id'])): ?>
                                                <br><small style="color: #6b7280;"><?php echo htmlspecialchars($result['student_id']); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo ucfirst($result['category']); ?></td>
                                        <td>
                                            <span class="score-badge">
                                                <?php echo $result['score']; ?>/<?php echo $result['total']; ?>
                                            </span>
                                        </td>
                                        <td><strong><?php echo number_format($result['percentage'], 1); ?>%</strong></td>
                                        <td><?php echo format_time($result['time_taken']); ?></td>
                                        <td><?php echo date('M d, Y', strtotime($result['date'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </main>

        <footer class="footer">
            <p>&copy; <?php echo date('Y'); ?> Quiz System. All rights reserved.</p>
            <p>Minimalist Claymorphism Design</p>
        </footer>
    </div>
</body>
</html>
