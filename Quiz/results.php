<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

if (!isset($_SESSION['quiz_started']) || $_SESSION['quiz_started'] !== true) {
    header('Location: index.php');
    exit();
}

$total_questions = count($_SESSION['questions']);
$score = $_SESSION['score'];
$percentage = ($score / $total_questions) * 100;
$time_elapsed = time() - $_SESSION['start_time'];
$grade = get_grade($percentage);

// Save results to database/file
save_quiz_result([
    'student_name' => $_SESSION['student_name'],
    'student_id' => $_SESSION['student_id'],
    'category' => $_SESSION['category'],
    'difficulty' => $_SESSION['difficulty'],
    'score' => $score,
    'total' => $total_questions,
    'percentage' => $percentage,
    'time_taken' => $time_elapsed,
    'date' => date('Y-m-d H:i:s')
]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="results-container">
        <div class="results-card">
            <div class="results-header">
                <div class="grade-circle grade-<?php echo strtolower($grade['letter']); ?>">
                    <span class="grade-letter"><?php echo $grade['letter']; ?></span>
                    <span class="grade-percentage"><?php echo number_format($percentage, 1); ?>%</span>
                </div>
                <h1><?php echo $grade['message']; ?></h1>
                <p class="student-name"><?php echo htmlspecialchars($_SESSION['student_name']); ?></p>
            </div>

            <div class="results-stats">
                <div class="stat-card">
                    <i class="fas fa-check-circle"></i>
                    <div class="stat-info">
                        <span class="stat-value"><?php echo $score; ?></span>
                        <span class="stat-label">Correct Answers</span>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-times-circle"></i>
                    <div class="stat-info">
                        <span class="stat-value"><?php echo $total_questions - $score; ?></span>
                        <span class="stat-label">Wrong Answers</span>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-clock"></i>
                    <div class="stat-info">
                        <span class="stat-value"><?php echo format_time($time_elapsed); ?></span>
                        <span class="stat-label">Time Taken</span>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-chart-line"></i>
                    <div class="stat-info">
                        <span class="stat-value"><?php echo number_format($percentage, 1); ?>%</span>
                        <span class="stat-label">Score</span>
                    </div>
                </div>
            </div>

            <div class="performance-analysis">
                <h3><i class="fas fa-chart-bar"></i> Performance Analysis</h3>
                <div class="analysis-bar">
                    <div class="analysis-segment correct" style="width: <?php echo $percentage; ?>%">
                        <span><?php echo $score; ?> Correct</span>
                    </div>
                    <div class="analysis-segment incorrect" style="width: <?php echo 100 - $percentage; ?>%">
                        <span><?php echo $total_questions - $score; ?> Wrong</span>
                    </div>
                </div>
            </div>

            <div class="review-section">
                <h3><i class="fas fa-list-check"></i> Answer Review</h3>
                <div class="answers-list">
                    <?php foreach ($_SESSION['questions'] as $index => $question): ?>
                        <div class="answer-item <?php echo $_SESSION['answers'][$index]['is_correct'] ? 'correct' : 'incorrect'; ?>">
                            <div class="answer-header">
                                <span class="question-num">Question <?php echo $index + 1; ?></span>
                                <span class="answer-status">
                                    <?php if ($_SESSION['answers'][$index]['is_correct']): ?>
                                        <i class="fas fa-check-circle"></i> Correct
                                    <?php else: ?>
                                        <i class="fas fa-times-circle"></i> Incorrect
                                    <?php endif; ?>
                                </span>
                            </div>
                            <p class="question-text"><?php echo htmlspecialchars($question['question']); ?></p>
                            <div class="answer-details">
                                <p><strong>Your answer:</strong> 
                                    <span class="<?php echo $_SESSION['answers'][$index]['is_correct'] ? 'text-success' : 'text-danger'; ?>">
                                        <?php echo htmlspecialchars($_SESSION['answers'][$index]['selected']); ?>
                                    </span>
                                </p>
                                <?php if (!$_SESSION['answers'][$index]['is_correct']): ?>
                                    <p><strong>Correct answer:</strong> 
                                        <span class="text-success">
                                            <?php echo htmlspecialchars($_SESSION['answers'][$index]['correct']); ?>
                                        </span>
                                    </p>
                                <?php endif; ?>
                                <?php if (!empty($question['explanation'])): ?>
                                    <p class="explanation">
                                        <i class="fas fa-info-circle"></i>
                                        <?php echo htmlspecialchars($question['explanation']); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="results-actions">
                <a href="certificate.php" class="btn btn-success">
                    <i class="fas fa-certificate"></i> Download Certificate
                </a>
                <a href="leaderboard.php" class="btn btn-info">
                    <i class="fas fa-trophy"></i> View Leaderboard
                </a>
                <a href="index.php?action=reset" class="btn btn-primary">
                    <i class="fas fa-redo"></i> Take Another Quiz
                </a>
                <button onclick="window.print()" class="btn btn-secondary">
                    <i class="fas fa-print"></i> Print Results
                </button>
            </div>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>
</html>
