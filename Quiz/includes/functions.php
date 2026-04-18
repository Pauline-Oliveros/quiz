<?php
/**
 * Sanitize user input
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Load questions based on category and difficulty
 */
function load_questions($category, $difficulty) {
    $questions_file = QUESTIONS_PATH . $category . '.json';
    
    if (!file_exists($questions_file)) {
        // Return default questions if file doesn't exist
        return get_default_questions($category, $difficulty);
    }
    
    $json_data = file_get_contents($questions_file);
    $all_questions = json_decode($json_data, true);
    
    if (!$all_questions || !is_array($all_questions)) {
        return get_default_questions($category, $difficulty);
    }
    
    // Filter by difficulty
    $filtered_questions = array_filter($all_questions, function($q) use ($difficulty) {
        return isset($q['difficulty']) && $q['difficulty'] === $difficulty;
    });
    
    // If no questions match difficulty, get all questions
    if (empty($filtered_questions)) {
        $filtered_questions = $all_questions;
    }
    
    // Determine number of questions
    $num_questions = match($difficulty) {
        'easy' => 10,
        'medium' => 15,
        'hard' => 20,
        default => 10
    };
    
    // Shuffle and limit questions
    $filtered_questions = array_values($filtered_questions); // Re-index array
    shuffle($filtered_questions);
    return array_slice($filtered_questions, 0, min($num_questions, count($filtered_questions)));
}

/**
 * Get default questions if no file exists
 */
function get_default_questions($category, $difficulty = 'easy') {
    $questions = [
        [
            'question' => 'What is the capital of France?',
            'options' => ['Berlin', 'Madrid', 'Paris', 'Lisbon'],
            'correct_answer' => 'Paris',
            'difficulty' => 'easy',
            'explanation' => 'Paris is the capital and most populous city of France.',
            'image' => ''
        ],
        [
            'question' => 'Which programming language is used for web development?',
            'options' => ['Python', 'JavaScript', 'C++', 'Java'],
            'correct_answer' => 'JavaScript',
            'difficulty' => 'easy',
            'explanation' => 'JavaScript is the primary language for client-side web development.',
            'image' => ''
        ],
        [
            'question' => 'What is 2 + 2?',
            'options' => ['3', '4', '5', '6'],
            'correct_answer' => '4',
            'difficulty' => 'easy',
            'explanation' => 'Basic arithmetic: 2 + 2 equals 4.',
            'image' => ''
        ],
        [
            'question' => 'Which planet is known as the Red Planet?',
            'options' => ['Earth', 'Mars', 'Jupiter', 'Venus'],
            'correct_answer' => 'Mars',
            'difficulty' => 'easy',
            'explanation' => 'Mars appears red due to iron oxide on its surface.',
            'image' => ''
        ],
        [
            'question' => 'Who wrote "Hamlet"?',
            'options' => ['Charles Dickens', 'William Shakespeare', 'Mark Twain', 'J.K. Rowling'],
            'correct_answer' => 'William Shakespeare',
            'difficulty' => 'medium',
            'explanation' => 'Hamlet is one of Shakespeare\'s most famous tragedies.',
            'image' => ''
        ],
        [
            'question' => 'What is the chemical symbol for gold?',
            'options' => ['Go', 'Gd', 'Au', 'Ag'],
            'correct_answer' => 'Au',
            'difficulty' => 'medium',
            'explanation' => 'Au comes from the Latin word "aurum" meaning gold.',
            'image' => ''
        ],
        [
            'question' => 'In what year did World War II end?',
            'options' => ['1943', '1944', '1945', '1946'],
            'correct_answer' => '1945',
            'difficulty' => 'medium',
            'explanation' => 'World War II ended in 1945 with the surrender of Japan.',
            'image' => ''
        ],
        [
            'question' => 'What is the largest ocean on Earth?',
            'options' => ['Atlantic Ocean', 'Indian Ocean', 'Arctic Ocean', 'Pacific Ocean'],
            'correct_answer' => 'Pacific Ocean',
            'difficulty' => 'easy',
            'explanation' => 'The Pacific Ocean covers about 46% of Earth\'s water surface.',
            'image' => ''
        ],
        [
            'question' => 'What is the speed of light?',
            'options' => ['299,792 km/s', '150,000 km/s', '500,000 km/s', '1,000,000 km/s'],
            'correct_answer' => '299,792 km/s',
            'difficulty' => 'hard',
            'explanation' => 'The speed of light in vacuum is approximately 299,792 kilometers per second.',
            'image' => ''
        ],
        [
            'question' => 'Who painted the Mona Lisa?',
            'options' => ['Vincent van Gogh', 'Pablo Picasso', 'Leonardo da Vinci', 'Michelangelo'],
            'correct_answer' => 'Leonardo da Vinci',
            'difficulty' => 'easy',
            'explanation' => 'Leonardo da Vinci painted the Mona Lisa in the early 16th century.',
            'image' => ''
        ],
        [
            'question' => 'What is the boiling point of water?',
            'options' => ['90°C', '100°C', '110°C', '120°C'],
            'correct_answer' => '100°C',
            'difficulty' => 'easy',
            'explanation' => 'Water boils at 100°C (212°F) at sea level.',
            'image' => ''
        ],
        [
            'question' => 'How many continents are there?',
            'options' => ['5', '6', '7', '8'],
            'correct_answer' => '7',
            'difficulty' => 'easy',
            'explanation' => 'There are 7 continents: Africa, Antarctica, Asia, Europe, North America, Australia, and South America.',
            'image' => ''
        ],
        [
            'question' => 'What is the largest mammal?',
            'options' => ['Elephant', 'Blue Whale', 'Giraffe', 'Polar Bear'],
            'correct_answer' => 'Blue Whale',
            'difficulty' => 'easy',
            'explanation' => 'The blue whale is the largest animal ever known to have lived on Earth.',
            'image' => ''
        ],
        [
            'question' => 'Who invented the telephone?',
            'options' => ['Thomas Edison', 'Alexander Graham Bell', 'Nikola Tesla', 'Benjamin Franklin'],
            'correct_answer' => 'Alexander Graham Bell',
            'difficulty' => 'medium',
            'explanation' => 'Alexander Graham Bell patented the telephone in 1876.',
            'image' => ''
        ],
        [
            'question' => 'What is the smallest prime number?',
            'options' => ['0', '1', '2', '3'],
            'correct_answer' => '2',
            'difficulty' => 'medium',
            'explanation' => '2 is the smallest and only even prime number.',
            'image' => ''
        ],
        [
            'question' => 'What is the capital of Japan?',
            'options' => ['Osaka', 'Kyoto', 'Tokyo', 'Hiroshima'],
            'correct_answer' => 'Tokyo',
            'difficulty' => 'easy',
            'explanation' => 'Tokyo is the capital and largest city of Japan.',
            'image' => ''
        ],
        [
            'question' => 'How many sides does a hexagon have?',
            'options' => ['5', '6', '7', '8'],
            'correct_answer' => '6',
            'difficulty' => 'easy',
            'explanation' => 'A hexagon is a polygon with 6 sides.',
            'image' => ''
        ],
        [
            'question' => 'What is the square root of 144?',
            'options' => ['10', '11', '12', '13'],
            'correct_answer' => '12',
            'difficulty' => 'medium',
            'explanation' => '12 × 12 = 144, so the square root of 144 is 12.',
            'image' => ''
        ],
        [
            'question' => 'Which gas do plants absorb from the atmosphere?',
            'options' => ['Oxygen', 'Nitrogen', 'Carbon Dioxide', 'Hydrogen'],
            'correct_answer' => 'Carbon Dioxide',
            'difficulty' => 'easy',
            'explanation' => 'Plants absorb carbon dioxide during photosynthesis.',
            'image' => ''
        ],
        [
            'question' => 'What is the hardest natural substance?',
            'options' => ['Gold', 'Iron', 'Diamond', 'Platinum'],
            'correct_answer' => 'Diamond',
            'difficulty' => 'medium',
            'explanation' => 'Diamond is the hardest naturally occurring substance known.',
            'image' => ''
        ]
    ];
    
    // Determine number of questions based on difficulty
    $num_questions = match($difficulty) {
        'easy' => 10,
        'medium' => 15,
        'hard' => 20,
        default => 10
    };
    
    shuffle($questions);
    return array_slice($questions, 0, min($num_questions, count($questions)));
}

/**
 * Calculate grade based on percentage
 */
function get_grade($percentage) {
    if ($percentage >= 90) {
        return ['letter' => 'A+', 'message' => 'Outstanding Performance!', 'color' => 'success'];
    } elseif ($percentage >= 80) {
        return ['letter' => 'A', 'message' => 'Excellent Work!', 'color' => 'success'];
    } elseif ($percentage >= 70) {
        return ['letter' => 'B', 'message' => 'Good Job!', 'color' => 'info'];
    } elseif ($percentage >= 60) {
        return ['letter' => 'C', 'message' => 'You Passed!', 'color' => 'warning'];
    } elseif ($percentage >= 50) {
        return ['letter' => 'D', 'message' => 'Needs Improvement', 'color' => 'warning'];
    } else {
        return ['letter' => 'F', 'message' => 'Keep Practicing', 'color' => 'danger'];
    }
}

/**
 * Format time in minutes and seconds
 */
function format_time($seconds) {
    $minutes = floor($seconds / 60);
    $seconds = $seconds % 60;
    return sprintf('%d:%02d', $minutes, $seconds);
}

/**
 * Save quiz result to file
 */
function save_quiz_result($result) {
    $results_file = RESULTS_PATH . 'results.json';
    
    // Load existing results
    $results = [];
    if (file_exists($results_file)) {
        $json_data = file_get_contents($results_file);
        $results = json_decode($json_data, true) ?? [];
    }
    
    // Add new result
    $result['id'] = uniqid();
    $results[] = $result;
    
    // Save to file
    file_put_contents($results_file, json_encode($results, JSON_PRETTY_PRINT));
    
    return true;
}

/**
 * Get leaderboard data
 */
function get_leaderboard($category = null, $limit = 10) {
    $results_file = RESULTS_PATH . 'results.json';
    
    if (!file_exists($results_file)) {
        return [];
    }
    
    $json_data = file_get_contents($results_file);
    $results = json_decode($json_data, true) ?? [];
    
    // Filter by category if specified
    if ($category) {
        $results = array_filter($results, function($r) use ($category) {
            return $r['category'] === $category;
        });
    }
    
    // Sort by percentage (descending) and time (ascending)
    usort($results, function($a, $b) {
        if ($a['percentage'] === $b['percentage']) {
            return $a['time_taken'] - $b['time_taken'];
        }
        return $b['percentage'] - $a['percentage'];
    });
    
    return array_slice($results, 0, $limit);
}

/**
 * Get quiz statistics for home page
 */
function get_quiz_statistics() {
    $results_file = RESULTS_PATH . 'results.json';
    
    $stats = [
        'total_quizzes' => 0,
        'total_students' => 0,
        'avg_score' => 0
    ];
    
    if (!file_exists($results_file)) {
        return $stats;
    }
    
    $json_data = file_get_contents($results_file);
    $all_results = json_decode($json_data, true) ?? [];
    
    $stats['total_quizzes'] = count($all_results);
    
    if ($stats['total_quizzes'] > 0) {
        $unique_students = array_unique(array_column($all_results, 'student_name'));
        $stats['total_students'] = count($unique_students);
        $stats['avg_score'] = array_sum(array_column($all_results, 'percentage')) / $stats['total_quizzes'];
    }
    
    return $stats;
}

/**
 * Generate certificate
 */
function generate_certificate($student_name, $score, $total, $category, $date) {
    $percentage = ($score / $total) * 100;
    $grade = get_grade($percentage);
    
    return [
        'student_name' => $student_name,
        'score' => $score,
        'total' => $total,
        'percentage' => $percentage,
        'grade' => $grade['letter'],
        'category' => ucfirst($category),
        'date' => $date,
        'certificate_id' => strtoupper(uniqid('CERT-'))
    ];
}
?>
