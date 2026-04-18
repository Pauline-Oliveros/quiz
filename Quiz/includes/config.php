<?php
// Database configuration (if using database)
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'quiz_system');

// Application settings
define('SITE_NAME', 'Quiz System');
define('ADMIN_EMAIL', 'admin@quizsystem.com');
define('RESULTS_PER_PAGE', 10);
define('PASSING_PERCENTAGE', 60);

// Time settings
define('TIMER_DURATION', 30); // seconds per question
define('SESSION_TIMEOUT', 3600); // 1 hour

// File paths
define('UPLOAD_PATH', __DIR__ . '/../uploads/');
define('RESULTS_PATH', __DIR__ . '/../data/results/');
define('QUESTIONS_PATH', __DIR__ . '/../data/questions/');

// Create necessary directories
$directories = [UPLOAD_PATH, RESULTS_PATH, QUESTIONS_PATH];
foreach ($directories as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

// Timezone
date_default_timezone_set('UTC');
?>
