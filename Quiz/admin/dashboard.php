<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: login.php');
    exit();
}

require_once '../includes/config.php';
require_once '../includes/functions.php';

// Get statistics
$results_file = RESULTS_PATH . 'results.json';
$total_quizzes = 0;
$total_students = 0;
$avg_score = 0;
$recent_results = [];

if (file_exists($results_file)) {
    $json_data = file_get_contents($results_file);
    $all_results = json_decode($json_data, true) ?? [];
    
    $total_quizzes = count($all_results);
    $unique_students = array_unique(array_column($all_results, 'student_name'));
    $total_students = count($unique_students);
    
    if ($total_quizzes > 0) {
        $avg_score = array_sum(array_column($all_results, 'percentage')) / $total_quizzes;
    }
    
    // Get recent 10 results
    $recent_results = array_slice(array_reverse($all_results), 0, 10);
}

// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Quiz System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .dashboard-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        
        .dashboard-header {
            background: var(--white);
            padding: 25px;
            border-radius: var(--border-radius);
            box-shadow: var(--clay-shadow-sm);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .dashboard-header h1 {
            font-size: 1.5rem;
            color: var(--dark-color);
            margin-bottom: 5px;
        }
        
        .dashboard-header p {
            color: var(--gray-600);
            font-size: 0.95rem;
        }
        
        .time-display {
            color: var(--gray-600);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .admin-nav {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .admin-nav a {
            padding: 10px 16px;
            background: var(--white);
            border-radius: var(--border-radius-sm);
            text-decoration: none;
            color: var(--dark-color);
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: var(--clay-shadow-sm);
            transition: var(--transition);
            font-size: 0.9rem;
            border: 1px solid var(--gray-200);
        }
        
        .admin-nav a:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--clay-shadow-hover);
            border-color: var(--primary-color);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .stat-card {
            background: var(--white);
            padding: 20px;
            border-radius: var(--border-radius);
            box-shadow: var(--clay-shadow-sm);
            transition: var(--transition);
            border: 1px solid var(--gray-200);
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--clay-shadow-hover);
            border-color: var(--primary-color);
        }
        
        .stat-card i {
            font-size: 1.8rem;
            margin-bottom: 12px;
        }
        
        .stat-card h3 {
            font-size: 1.5rem;
            margin-bottom: 5px;
            color: var(--dark-color);
        }
        
        .stat-card p {
            color: var(--gray-600);
            font-size: 0.9rem;
        }
        
        .recent-results {
            background: var(--white);
            padding: 25px;
            border-radius: var(--border-radius);
            box-shadow: var(--clay-shadow-sm);
            border: 1px solid var(--gray-200);
        }
        
        .recent-results h2 {
            font-size: 1.3rem;
            margin-bottom: 20px;
            color: var(--dark-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .results-table {
            width: 100%;
            border-collapse: collapse;
            overflow-x: auto;
            display: block;
        }
        
        .results-table th {
            background: var(--gray-100);
            padding: 10px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 0.85rem;
            border-bottom: 2px solid var(--gray-200);
        }
        
        .results-table td {
            padding: 10px 12px;
            border-bottom: 1px solid var(--gray-200);
            font-size: 0.85rem;
        }
        
        .results-table tr:hover {
            background: var(--gray-50);
        }
        
        .difficulty-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
        }
        
        .difficulty-easy {
            background: #d1fae5;
            color: #065f46;
        }
        
        .difficulty-medium {
            background: #fed7aa;
            color: #92400e;
        }
        
        .difficulty-hard {
            background: #fecaca;
            color: #991b1b;
        }
        
        .empty-state {
            text-align: center;
            color: var(--gray-600);
            padding: 40px;
        }
        
        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .admin-nav {
                justify-content: center;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .results-table {
                min-width: 600px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="logo">
                <i class="fas fa-brain"></i>
                <h1>Quiz System - Admin</h1>
            </div>
            <nav class="nav">
                <a href="../index.php" class="nav-link">
                    <i class="fas fa-home"></i>
                    <span class="nav-text">Home</span>
                </a>
                <a href="dashboard.php" class="nav-link active">
                    <i class="fas fa-chart-line"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <a href="?action=logout" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="nav-text">Logout</span>
                </a>
            </nav>
        </header>

        <main class="main-content">
            <div class="dashboard-container">
                <div class="dashboard-header">
                    <div>
                        <h1>Admin Dashboard</h1>
                        <p>Welcome back, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</p>
                    </div>
                    <div class="time-display">
                        <i class="fas fa-clock"></i> <?php echo date('F d, Y - h:i A'); ?>
                    </div>
                </div>

                <div class="admin-nav">
                    <a href="dashboard.php">
                        <i class="fas fa-chart-line"></i> Overview
                    </a>
                    <a href="manage-questions.php">
                        <i class="fas fa-question-circle"></i> Manage Questions
                    </a>
                    <a href="view-results.php">
                        <i class="fas fa-file-alt"></i> All Results
                    </a>
                    <a href="settings.php">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                </div>

                <div class="stats-grid">
                    <div class="stat-card">
                        <i class="fas fa-clipboard-list" style="color: #4f46e5;"></i>
                        <h3><?php echo $total_quizzes; ?></h3>
                        <p>Total Quizzes Taken</p>
                    </div>
                    
                    <div class="stat-card">
                        <i class="fas fa-users" style="color: #10b981;"></i>
                        <h3><?php echo $total_students; ?></h3>
                        <p>Unique Students</p>
                    </div>
                    
                    <div class="stat-card">
                        <i class="fas fa-chart-bar" style="color: #f59e0b;"></i>
                        <h3><?php echo number_format($avg_score, 1); ?>%</h3>
                        <p>Average Score</p>
                    </div>
                    
                    <div class="stat-card">
                        <i class="fas fa-calendar-day" style="color: #3b82f6;"></i>
                        <h3><?php echo date('d'); ?></h3>
                        <p>Day of Month</p>
                    </div>
                </div>

                <div class="recent-results">
                    <h2><i class="fas fa-history"></i> Recent Quiz Results</h2>
                    
                    <?php if (empty($recent_results)): ?>
                        <div class="empty-state">
                            <p>No quiz results yet.</p>
                        </div>
                    <?php else: ?>
                        <table class="results-table">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Category</th>
                                    <th>Difficulty</th>
                                    <th>Score</th>
                                    <th>Percentage</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_results as $result): ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo htmlspecialchars($result['student_name']); ?></strong>
                                            <?php if (!empty($result['student_id'])): ?>
                                                <br><small style="color: #6b7280;"><?php echo htmlspecialchars($result['student_id']); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo ucfirst($result['category']); ?></td>
                                        <td>
                                            <span class="difficulty-badge difficulty-<?php echo $result['difficulty']; ?>">
                                                <?php echo ucfirst($result['difficulty']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo $result['score']; ?>/<?php echo $result['total']; ?></td>
                                        <td>
                                            <strong style="color: <?php echo $result['percentage'] >= 60 ? '#10b981' : '#ef4444'; ?>">
                                                <?php echo number_format($result['percentage'], 1); ?>%
                                            </strong>
                                        </td>
                                        <td><?php echo date('M d, Y H:i', strtotime($result['date'])); ?></td>
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
