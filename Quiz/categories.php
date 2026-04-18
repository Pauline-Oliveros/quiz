<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

$categories = [
    [
        'id' => 'general',
        'name' => 'General Knowledge',
        'icon' => 'fa-brain',
        'description' => 'Test your knowledge on various topics',
        'color' => '#4f46e5'
    ],
    [
        'id' => 'math',
        'name' => 'Mathematics',
        'icon' => 'fa-calculator',
        'description' => 'Solve mathematical problems and equations',
        'color' => '#10b981'
    ],
    [
        'id' => 'science',
        'name' => 'Science',
        'icon' => 'fa-flask',
        'description' => 'Explore physics, chemistry, and biology',
        'color' => '#3b82f6'
    ],
    [
        'id' => 'history',
        'name' => 'History',
        'icon' => 'fa-landmark',
        'description' => 'Journey through historical events',
        'color' => '#f59e0b'
    ],
    [
        'id' => 'geography',
        'name' => 'Geography',
        'icon' => 'fa-globe',
        'description' => 'Discover countries, capitals, and landmarks',
        'color' => '#06b6d4'
    ],
    [
        'id' => 'programming',
        'name' => 'Programming',
        'icon' => 'fa-code',
        'description' => 'Test your coding knowledge',
        'color' => '#8b5cf6'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Categories - Quiz System</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .categories-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 30px;
        }
        
        .categories-header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .categories-header h1 {
            font-size: 1.8rem;
            color: var(--dark-color);
            margin-bottom: 8px;
        }
        
        .categories-header p {
            color: var(--gray-600);
            font-size: 1rem;
        }
        
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .category-card {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 25px;
            text-align: center;
            box-shadow: var(--clay-shadow-sm);
            transition: var(--transition);
            cursor: pointer;
            border: 1px solid var(--gray-200);
        }
        
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--clay-shadow-hover);
            border-color: var(--primary-color);
        }
        
        .category-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 1.5rem;
            color: white;
            box-shadow: var(--clay-shadow-sm);
        }
        
        .category-card h3 {
            font-size: 1.2rem;
            margin-bottom: 8px;
            color: var(--dark-color);
        }
        
        .category-card p {
            color: var(--gray-600);
            margin-bottom: 15px;
            font-size: 0.9rem;
            line-height: 1.4;
        }
        
        .category-btn {
            background: var(--primary-color);
            color: white;
            padding: 8px 16px;
            border-radius: var(--border-radius-sm);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            transition: var(--transition);
            font-size: 0.9rem;
        }
        
        .category-card:hover .category-btn {
            background: var(--primary-dark);
        }
        
        @media (max-width: 768px) {
            .categories-grid {
                grid-template-columns: 1fr;
            }
            
            .category-card {
                padding: 20px;
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
                <a href="categories.php" class="nav-link active">
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
            <div class="categories-container">
                <div class="categories-header">
                    <h1>Choose Your Category</h1>
                    <p>Select a category to start your quiz journey</p>
                </div>

                <div class="categories-grid">
                    <?php foreach ($categories as $category): ?>
                        <div class="category-card" onclick="selectCategory('<?php echo $category['id']; ?>')">
                            <div class="category-icon" style="background: <?php echo $category['color']; ?>">
                                <i class="fas <?php echo $category['icon']; ?>"></i>
                            </div>
                            <h3><?php echo $category['name']; ?></h3>
                            <p><?php echo $category['description']; ?></p>
                            <span class="category-btn">
                                Start Quiz <i class="fas fa-arrow-right"></i>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>

        <footer class="footer">
            <p>&copy; <?php echo date('Y'); ?> Quiz System. All rights reserved.</p>
            <p>Minimalist Claymorphism Design</p>
        </footer>
    </div>

    <script>
        function selectCategory(categoryId) {
            // Redirect to index.php with the selected category
            window.location.href = 'index.php?selected_category=' + categoryId;
        }
    </script>
</body>
</html>
