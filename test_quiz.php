<?php
session_start();
echo "Testing quiz flow...\n";
echo "Session ID: " . session_id() . "\n";
echo "POST method: " . $_SERVER['REQUEST_METHOD'] . "\n";
echo "quiz_started in session: " . (isset($_SESSION['quiz_started']) ? $_SESSION['quiz_started'] : 'not set') . "\n";

// Simulate starting quiz
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_SESSION['quiz_started'])) {
    echo "Setting quiz_started to true...\n";
    $_SESSION['quiz_started'] = true;
    $_SESSION['student_name'] = 'Test Student';
    $_SESSION['category'] = 'general';
    $_SESSION['difficulty'] = 'easy';
    $_SESSION['timed_mode'] = false;
    $_SESSION['start_time'] = time();
    $_SESSION['current_question'] = 0;
    $_SESSION['score'] = 0;
    $_SESSION['answers'] = [];
    
    // Load questions
    require_once 'Quiz/includes/config.php';
    require_once 'Quiz/includes/functions.php';
    $_SESSION['questions'] = load_questions($_SESSION['category'], $_SESSION['difficulty']);
    
    echo "Questions loaded: " . count($_SESSION['questions']) . "\n";
}

// Check redirect logic
if (!isset($_SESSION['quiz_started']) || $_SESSION['quiz_started'] !== true) {
    echo "Would redirect to index.php\n";
} else {
    echo "Quiz is started, would show question\n";
}
?>