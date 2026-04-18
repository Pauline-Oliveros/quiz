<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Start quiz if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (!isset($_SESSION['quiz_started']) || $_SESSION['quiz_started'] === false)) {
    $_SESSION['quiz_started'] = true;
    $_SESSION['student_name'] = sanitize_input($_POST['student_name']);
    $_SESSION['student_id'] = sanitize_input($_POST['student_id'] ?? '');
    $_SESSION['category'] = sanitize_input($_POST['category']);
    $_SESSION['difficulty'] = sanitize_input($_POST['difficulty']);
    $_SESSION['timed_mode'] = isset($_POST['timed_mode']);
    $_SESSION['start_time'] = time();
    $_SESSION['current_question'] = 0;
    $_SESSION['score'] = 0;
    $_SESSION['answers'] = [];
    
    // Load questions based on category and difficulty
    $_SESSION['questions'] = load_questions($_SESSION['category'], $_SESSION['difficulty']);
}

// Redirect if quiz not started
if (!isset($_SESSION['quiz_started']) || $_SESSION['quiz_started'] !== true) {
    header('Location: index.php');
    exit();
}

// Handle answer submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'])) {
    $current_q = $_SESSION['current_question'];
    $selected_answer = sanitize_input($_POST['answer']);
    $time_taken = isset($_POST['time_taken']) ? intval($_POST['time_taken']) : 0;
    
    // Store answer
    $_SESSION['answers'][$current_q] = [
        'selected' => $selected_answer,
        'correct' => $_SESSION['questions'][$current_q]['correct_answer'],
        'is_correct' => ($selected_answer === $_SESSION['questions'][$current_q]['correct_answer']),
        'time_taken' => $time_taken
    ];
    
    // Update score
    if ($_SESSION['answers'][$current_q]['is_correct']) {
        $_SESSION['score']++;
    }
    
    // Move to next question or finish
    $_SESSION['current_question']++;
    
    if ($_SESSION['current_question'] >= count($_SESSION['questions'])) {
        header('Location: results.php');
        exit();
    }
}

$current_index = $_SESSION['current_question'];
$total_questions = count($_SESSION['questions']);
$current_question = $_SESSION['questions'][$current_index];
$progress = (($current_index) / $total_questions) * 100;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - Question <?php echo $current_index + 1; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="quiz-container">
        <div class="quiz-header">
            <div class="quiz-info-bar">
                <div class="student-info">
                    <i class="fas fa-user"></i>
                    <span><?php echo htmlspecialchars($_SESSION['student_name']); ?></span>
                </div>
                <div class="category-badge">
                    <i class="fas fa-tag"></i>
                    <span><?php echo ucfirst($_SESSION['category']); ?></span>
                </div>
                <div class="score-display">
                    <i class="fas fa-star"></i>
                    <span>Score: <?php echo $_SESSION['score']; ?><?php echo $current_index > 0 ? '/' . $current_index : ''; ?></span>
                </div>
            </div>

            <div class="progress-section">
                <div class="progress-info">
                    <span>Question <?php echo $current_index + 1; ?> of <?php echo $total_questions; ?></span>
                    <?php if ($_SESSION['timed_mode']): ?>
                        <span class="timer" id="timer">
                            <i class="fas fa-clock"></i> <span id="time-left">30</span>s
                        </span>
                    <?php endif; ?>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?php echo $progress; ?>%"></div>
                </div>
            </div>
        </div>

        <div class="question-section">
            <div class="question-card">
                <div class="question-header">
                    <span class="question-number">Q<?php echo $current_index + 1; ?></span>
                    <span class="difficulty-badge difficulty-<?php echo $_SESSION['difficulty']; ?>">
                        <?php echo ucfirst($_SESSION['difficulty']); ?>
                    </span>
                </div>
                
                <h2 class="question-text"><?php echo htmlspecialchars($current_question['question']); ?></h2>
                
                <?php if (!empty($current_question['image'])): ?>
                    <div class="question-image">
                        <img src="<?php echo htmlspecialchars($current_question['image']); ?>" 
                             alt="Question illustration">
                    </div>
                <?php endif; ?>

                <form method="POST" id="quiz-form" class="options-form">
                    <input type="hidden" name="time_taken" id="time_taken" value="0">
                    
                    <div class="options-grid">
                        <?php 
                        $option_labels = ['A', 'B', 'C', 'D', 'E', 'F'];
                        foreach ($current_question['options'] as $index => $option): 
                        ?>
                            <label class="option-card">
                                <input type="radio" name="answer" value="<?php echo htmlspecialchars($option); ?>" required>
                                <span class="option-label"><?php echo $option_labels[$index]; ?></span>
                                <span class="option-text"><?php echo htmlspecialchars($option); ?></span>
                                <span class="checkmark"><i class="fas fa-check"></i></span>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="if(confirm('Are you sure you want to quit?')) window.location.href='index.php?action=reset'">
                            <i class="fas fa-times"></i> Quit Quiz
                        </button>
                        <button type="submit" class="btn btn-primary" id="submit-btn">
                            <?php echo ($current_index + 1 < $total_questions) ? 'Next Question' : 'Finish Quiz'; ?>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="help-section">
                <div class="help-card">
                    <i class="fas fa-lightbulb"></i>
                    <p>Take your time to read the question carefully before selecting your answer.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/quiz.js"></script>
    <?php if ($_SESSION['timed_mode']): ?>
    <script>
        let timeLeft = 30;
        let timeTaken = 0;
        const timerElement = document.getElementById('time-left');
        const form = document.getElementById('quiz-form');
        const timeTakenInput = document.getElementById('time_taken');
        
        const countdown = setInterval(() => {
            timeLeft--;
            timeTaken++;
            timeTakenInput.value = timeTaken;
            timerElement.textContent = timeLeft;
            
            if (timeLeft <= 10) {
                timerElement.parentElement.classList.add('timer-warning');
            }
            
            if (timeLeft <= 0) {
                clearInterval(countdown);
                alert('Time is up! Moving to next question.');
                form.submit();
            }
        }, 1000);
        
        form.addEventListener('submit', () => {
            clearInterval(countdown);
        });
    </script>
    <?php endif; ?>
</body>
</html>
