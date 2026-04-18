# Quiz System - v2.0 Responsive Claymorphism Edition

> **🎉 NEW in v2.0**: Complete responsive redesign with modern claymorphism UI, mobile-first approach, and enhanced user experience!

A professional, feature-rich quiz application built with PHP and HTML for educational purposes.

## 🆕 What's New in v2.0

- ✅ **Responsive Claymorphism Design** - Modern 3D clay-like UI
- ✅ **Mobile-First Approach** - Optimized for all devices
- ✅ **Professional Color Scheme** - Indigo, purple, and gradient accents
- ✅ **Enhanced Navigation** - Icon-only on mobile, full text on desktop
- ✅ **Improved Category Flow** - Click category to auto-fill form
- ✅ **Touch-Friendly Interface** - 44x44px minimum touch targets
- ✅ **Smooth Animations** - GPU-accelerated transitions
- ✅ **Better UX** - Auto-scroll, visual feedback, and more

📖 **See full documentation**: [DESIGN-UPDATE.md](DESIGN-UPDATE.md), [QUICK-START-GUIDE.md](QUICK-START-GUIDE.md)

---

## Features

### Core Features
- **Multiple Categories**: General Knowledge, Mathematics, Science, History, Geography, Programming
- **Difficulty Levels**: Easy (10 questions), Medium (15 questions), Hard (20 questions)
- **Timed Mode**: Optional 30-second timer per question
- **Progress Tracking**: Real-time score display and progress bar
- **Instant Feedback**: Immediate results after quiz completion
- **Answer Review**: Detailed review of all answers with explanations

### Professional Features
- **Student Identification**: Name and optional Student ID tracking
- **Leaderboard System**: Compete with other students
- **Certificate Generation**: Downloadable certificates for completed quizzes
- **Grade Calculation**: Automatic grading (A+, A, B, C, D, F)
- **Performance Analysis**: Visual breakdown of correct/incorrect answers
- **Results History**: All quiz results saved for future reference
- **Responsive Design**: Works on desktop, tablet, and mobile devices
- **Print Support**: Print results and certificates

### User Experience
- **Modern UI**: Clean, professional interface with smooth animations
- **Keyboard Navigation**: Use number keys (1-6) to select answers
- **Visual Feedback**: Color-coded answers and progress indicators
- **Help Section**: Contextual tips during quiz
- **Randomized Questions**: Questions shuffled for each attempt
- **Session Management**: Secure session handling

## Installation

### Requirements
- PHP 7.4 or higher
- Web server (Apache, Nginx, or PHP built-in server)
- Modern web browser

### Setup Instructions

1. **Extract Files**
   ```bash
   # Extract the Quiz folder to your web server directory
   # For XAMPP: C:/xampp/htdocs/Quiz
   # For WAMP: C:/wamp64/www/Quiz
   ```

2. **Configure Settings**
   - Open `includes/config.php`
   - Update database settings if using MySQL (optional)
   - Adjust time limits and passing percentages as needed

3. **Set Permissions**
   ```bash
   # Make sure these directories are writable
   chmod 755 data/
   chmod 755 data/results/
   chmod 755 data/questions/
   chmod 755 uploads/
   ```

4. **Start the Application**
   
   **Option 1: Using PHP Built-in Server**
   ```bash
   cd Quiz
   php -S localhost:8000
   ```
   Then open: http://localhost:8000

   **Option 2: Using XAMPP/WAMP**
   - Place Quiz folder in htdocs/www directory
   - Open: http://localhost/Quiz

## Usage

### Taking a Quiz

1. **Start Page**
   - Enter your name and optional Student ID
   - Select a category
   - Choose difficulty level
   - Enable timer if desired
   - Click "Start Quiz"

2. **During Quiz**
   - Read each question carefully
   - Select your answer by clicking an option
   - Use keyboard shortcuts (1-6) for quick selection
   - Click "Next Question" to proceed
   - Timer counts down if enabled

3. **After Completion**
   - View your score and grade
   - Review all answers with explanations
   - Download certificate
   - Check leaderboard ranking
   - Take another quiz

### Adding Custom Questions

Create a JSON file in `data/questions/` directory:

**Example: `data/questions/math.json`**
```json
[
  {
    "question": "What is 5 + 7?",
    "options": ["10", "11", "12", "13"],
    "correct_answer": "12",
    "difficulty": "easy",
    "explanation": "5 + 7 equals 12",
    "image": ""
  },
  {
    "question": "Solve: 3x = 15",
    "options": ["3", "4", "5", "6"],
    "correct_answer": "5",
    "difficulty": "medium",
    "explanation": "Divide both sides by 3: x = 15/3 = 5",
    "image": ""
  }
]
```

## File Structure

```
Quiz/
├── index.php              # Home page and quiz start
├── quiz.php               # Quiz interface
├── results.php            # Results and answer review
├── leaderboard.php        # Leaderboard display
├── certificate.php        # Certificate generation
├── categories.php         # Category selection page
├── includes/
│   ├── config.php         # Configuration settings
│   └── functions.php      # Helper functions
├── assets/
│   ├── css/
│   │   └── style.css      # Main stylesheet
│   └── js/
│       ├── main.js        # General JavaScript
│       └── quiz.js        # Quiz-specific JavaScript
├── data/
│   ├── questions/         # Question JSON files
│   └── results/           # Quiz results storage
├── uploads/               # Image uploads
└── README.md             # This file
```

## Customization

### Changing Colors
Edit `assets/css/style.css` and modify CSS variables:
```css
:root {
    --primary-color: #4f46e5;
    --secondary-color: #7c3aed;
    --success-color: #10b981;
    --danger-color: #ef4444;
}
```

### Adjusting Timer
Edit `includes/config.php`:
```php
define('TIMER_DURATION', 30); // seconds per question
```

### Modifying Passing Grade
Edit `includes/config.php`:
```php
define('PASSING_PERCENTAGE', 60); // 60% to pass
```

### Adding New Categories
1. Create question file: `data/questions/your-category.json`
2. Add category to `index.php` and `categories.php`

## Features for Educational Use

### For Students
- Track progress across multiple quizzes
- Compete on leaderboard
- Earn certificates
- Review mistakes with explanations
- Practice with different difficulty levels

### For Teachers/Administrators
- Easy question management (JSON format)
- View all student results
- Export results for grading
- Customize categories and difficulty
- Set time limits per question
- Adjust passing percentages

## Browser Support

- Chrome (recommended)
- Firefox
- Safari
- Edge
- Opera

## Security Features

- Session-based authentication
- Input sanitization
- XSS protection
- CSRF prevention
- Secure file handling

## Troubleshooting

### Quiz won't start
- Check if sessions are enabled in PHP
- Verify file permissions on data directories
- Clear browser cache and cookies

### Questions not loading
- Ensure JSON files are properly formatted
- Check file paths in config.php
- Verify read permissions on question files

### Results not saving
- Check write permissions on data/results/
- Ensure sufficient disk space
- Verify PHP error logs

## Future Enhancements

- Database integration (MySQL/PostgreSQL)
- Admin dashboard
- Question bank management
- Multi-language support
- Email notifications
- Advanced analytics
- Question difficulty rating
- Timed full quiz mode
- Practice mode (no scoring)

## Credits

- Font Awesome for icons
- Google Fonts for typography
- PHP for backend logic

## License

This project is created for educational purposes. Feel free to modify and use for your institution.

## Support

For issues or questions, please check the documentation or contact your system administrator.

---

**Version**: 1.0.0  
**Last Updated**: 2026  
**Author**: Quiz System Team
