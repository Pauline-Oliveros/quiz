<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

if (!isset($_SESSION['quiz_started']) || $_SESSION['quiz_started'] !== true) {
    header('Location: index.php');
    exit();
}

$certificate = generate_certificate(
    $_SESSION['student_name'],
    $_SESSION['score'],
    count($_SESSION['questions']),
    $_SESSION['category'],
    date('F d, Y')
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Completion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Georgia', serif;
            background: #f3f4f6;
            padding: 40px 20px;
        }
        
        .certificate-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 60px;
            border: 20px solid #4f46e5;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            position: relative;
        }
        
        .certificate-border {
            border: 3px solid #fbbf24;
            padding: 40px;
        }
        
        .certificate-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .certificate-logo {
            font-size: 4rem;
            color: #4f46e5;
            margin-bottom: 20px;
        }
        
        .certificate-title {
            font-size: 3rem;
            color: #1f2937;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 3px;
        }
        
        .certificate-subtitle {
            font-size: 1.5rem;
            color: #6b7280;
            font-style: italic;
        }
        
        .certificate-body {
            text-align: center;
            margin: 40px 0;
        }
        
        .certificate-text {
            font-size: 1.2rem;
            color: #374151;
            line-height: 2;
            margin-bottom: 30px;
        }
        
        .student-name {
            font-size: 3rem;
            color: #4f46e5;
            font-weight: bold;
            margin: 30px 0;
            text-decoration: underline;
            text-decoration-color: #fbbf24;
            text-decoration-thickness: 3px;
        }
        
        .certificate-details {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin: 40px 0;
            text-align: center;
        }
        
        .detail-item {
            padding: 20px;
            background: #f9fafb;
            border-radius: 8px;
        }
        
        .detail-label {
            font-size: 0.9rem;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }
        
        .detail-value {
            font-size: 1.5rem;
            color: #1f2937;
            font-weight: bold;
        }
        
        .certificate-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 60px;
            padding-top: 30px;
            border-top: 2px solid #e5e7eb;
        }
        
        .signature-section {
            text-align: center;
        }
        
        .signature-line {
            width: 200px;
            border-top: 2px solid #1f2937;
            margin: 20px auto 10px;
        }
        
        .signature-label {
            font-size: 0.9rem;
            color: #6b7280;
        }
        
        .certificate-id {
            text-align: center;
            margin-top: 30px;
            font-size: 0.9rem;
            color: #9ca3af;
        }
        
        .action-buttons {
            text-align: center;
            margin-top: 30px;
        }
        
        .btn {
            padding: 12px 30px;
            margin: 0 10px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        
        .btn-primary {
            background: #4f46e5;
            color: white;
        }
        
        .btn-secondary {
            background: #6b7280;
            color: white;
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .action-buttons {
                display: none;
            }
            
            .certificate-container {
                box-shadow: none;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="certificate-border">
            <div class="certificate-header">
                <div class="certificate-logo">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h1 class="certificate-title">Certificate</h1>
                <p class="certificate-subtitle">of Achievement</p>
            </div>
            
            <div class="certificate-body">
                <p class="certificate-text">This is to certify that</p>
                
                <div class="student-name">
                    <?php echo htmlspecialchars($certificate['student_name']); ?>
                </div>
                
                <p class="certificate-text">
                    has successfully completed the <strong><?php echo $certificate['category']; ?></strong> quiz<br>
                    and demonstrated excellent knowledge in the subject area
                </p>
                
                <div class="certificate-details">
                    <div class="detail-item">
                        <div class="detail-label">Score</div>
                        <div class="detail-value"><?php echo $certificate['score']; ?>/<?php echo $certificate['total']; ?></div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Percentage</div>
                        <div class="detail-value"><?php echo number_format($certificate['percentage'], 1); ?>%</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Grade</div>
                        <div class="detail-value"><?php echo $certificate['grade']; ?></div>
                    </div>
                </div>
            </div>
            
            <div class="certificate-footer">
                <div class="signature-section">
                    <div class="signature-line"></div>
                    <p class="signature-label">Date</p>
                    <p><strong><?php echo $certificate['date']; ?></strong></p>
                </div>
                
                <div class="signature-section">
                    <div class="signature-line"></div>
                    <p class="signature-label">Authorized Signature</p>
                    <p><strong>Quiz Administrator</strong></p>
                </div>
            </div>
            
            <div class="certificate-id">
                Certificate ID: <?php echo $certificate['certificate_id']; ?>
            </div>
        </div>
    </div>
    
    <div class="action-buttons">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Print Certificate
        </button>
        <a href="results.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Results
        </a>
    </div>
</body>
</html>
