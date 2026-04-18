# Quiz System - Quick Start Guide

## 🚀 Getting Started

### Prerequisites
- XAMPP installed and running
- Apache and MySQL services started
- PHP 7.4 or higher

### Installation Path
```
C:\xampp\htdocs\Quiz test-pauline\quiz\Quiz\
```

## 📂 File Structure

```
Quiz/
├── index.php              # Home page with quiz start form
├── categories.php         # Browse quiz categories
├── quiz.php              # Take the quiz
├── results.php           # View quiz results
├── leaderboard.php       # View leaderboard
├── certificate.php       # Generate certificate
├── assets/
│   ├── css/
│   │   ├── style.css     # Main responsive CSS
│   │   └── home-additions.css
│   └── js/
│       ├── main.js       # General JavaScript
│       └── quiz.js       # Quiz-specific JavaScript
├── admin/
│   ├── login.php         # Admin login
│   └── dashboard.php     # Admin dashboard
├── includes/
│   ├── config.php        # Configuration
│   └── functions.php     # Helper functions
└── data/
    ├── questions/        # Question JSON files
    └── results/          # Results JSON files
```

## 🎯 How to Access

### 1. Start XAMPP
- Open XAMPP Control Panel
- Start Apache
- Start MySQL (if using database)

### 2. Access the Application

**Home Page:**
```
http://localhost/Quiz%20test-pauline/quiz/Quiz/index.php
```

**Categories:**
```
http://localhost/Quiz%20test-pauline/quiz/Quiz/categories.php
```

**Leaderboard:**
```
http://localhost/Quiz%20test-pauline/quiz/Quiz/leaderboard.php
```

**Admin Login:**
```
http://localhost/Quiz%20test-pauline/quiz/Quiz/admin/login.php
```

## 👤 User Flow

### Taking a Quiz

1. **Start from Home or Categories**
   - Option A: Go to `index.php` and fill the form
   - Option B: Go to `categories.php` and click a category

2. **Fill Quiz Details**
   - Enter your name (required)
   - Enter student ID (optional)
   - Select category (auto-filled if from categories page)
   - Select difficulty (Easy/Medium/Hard)
   - Enable timer (optional)

3. **Take the Quiz**
   - Answer each question
   - Click "Next Question" to proceed
   - Timer counts down if enabled
   - Progress bar shows completion

4. **View Results**
   - See your grade and percentage
   - Review correct/incorrect answers
   - Download certificate
   - View leaderboard
   - Take another quiz

## 🔐 Admin Access

### Login Credentials
```
Username: admin
Password: admin123
```

⚠️ **Important**: Change these credentials in production!

### Admin Features
- View statistics
- See recent quiz results
- Monitor student performance
- Access all quiz data

## 📱 Responsive Design

### Desktop View (≥768px)
- Full navigation with text
- Multi-column layouts
- Larger typography
- Enhanced hover effects

### Mobile View (<768px)
- Icon-only navigation
- Single-column layouts
- Touch-friendly buttons
- Optimized spacing

### Tablet View (768px-1024px)
- Balanced layout
- 2-3 column grids
- Comfortable reading size

## 🎨 Design Features

### Claymorphism Style
- Soft, elevated shadows
- Light background (#e0e5ec)
- Smooth border radius (15-25px)
- 3D clay-like appearance

### Color Scheme
- **Primary**: Indigo (#6366f1)
- **Secondary**: Purple (#8b5cf6)
- **Success**: Green (#10b981)
- **Danger**: Red (#ef4444)
- **Warning**: Amber (#f59e0b)
- **Info**: Cyan (#06b6d4)

## ⚙️ Configuration

### Adding Questions

Edit: `data/questions/general.json`

```json
{
  "question": "Your question here?",
  "options": ["Option A", "Option B", "Option C", "Option D"],
  "correct_answer": "Option A",
  "explanation": "Explanation here"
}
```

### Changing Admin Credentials

Edit: `admin/login.php`

```php
define('ADMIN_USERNAME', 'your_username');
define('ADMIN_PASSWORD', 'your_password');
```

## 🔧 Troubleshooting

### Issue: Page Not Loading
**Solution**: Check XAMPP Apache is running

### Issue: CSS Not Loading
**Solution**: Clear browser cache (Ctrl+F5)

### Issue: Quiz Not Starting
**Solution**: Check session is enabled in php.ini

### Issue: Results Not Saving
**Solution**: Check file permissions on `data/results/` folder

### Issue: Mobile View Not Working
**Solution**: Ensure viewport meta tag is present (already included)

## 📊 Testing the Application

### Quick Test Flow:
1. Visit `index.php`
2. Enter name: "Test User"
3. Select category: "General Knowledge"
4. Select difficulty: "Easy"
5. Click "Start Quiz"
6. Answer all questions
7. View results
8. Check leaderboard

### Mobile Testing:
1. Open browser DevTools (F12)
2. Click device toolbar icon
3. Select mobile device
4. Test all pages

## 🎯 Key Features

✅ **Responsive Design** - Works on all devices
✅ **Claymorphism UI** - Modern, professional look
✅ **Category Selection** - Browse and select categories
✅ **Timed Quizzes** - Optional timer per question
✅ **Progress Tracking** - Visual progress bar
✅ **Results Review** - See correct/incorrect answers
✅ **Leaderboard** - Compete with others
✅ **Certificate** - Download completion certificate
✅ **Admin Panel** - Monitor and manage quizzes

## 📱 Mobile Features

- Touch-friendly interface
- Icon-only navigation
- Full-width buttons
- Optimized forms
- Horizontal scroll tables
- Smooth animations

## 🚀 Performance Tips

1. **Clear Cache**: Regularly clear browser cache
2. **Optimize Images**: Compress any images used
3. **Minimize Requests**: CSS/JS already optimized
4. **Enable Compression**: Enable gzip in Apache

## 📞 Support

### Common Questions

**Q: How do I add more categories?**
A: Edit the categories array in `categories.php` and add corresponding question files

**Q: Can I change the timer duration?**
A: Yes, edit the timer value in `quiz.php` (currently 30 seconds)

**Q: How do I reset all quiz data?**
A: Delete contents of `data/results/results.json` (keep empty array `[]`)

**Q: Can I customize colors?**
A: Yes, edit CSS variables in `assets/css/style.css` `:root` section

## 🎓 Best Practices

1. **Regular Backups**: Backup `data/` folder regularly
2. **Security**: Change admin credentials
3. **Testing**: Test on multiple devices
4. **Updates**: Keep PHP and XAMPP updated
5. **Monitoring**: Check error logs regularly

## 📈 Next Steps

1. ✅ Test all functionality
2. ✅ Customize questions
3. ✅ Change admin password
4. ✅ Test on mobile devices
5. ✅ Deploy to production (if needed)

---

## 🎉 You're Ready!

The quiz system is now fully functional with:
- ✅ Responsive claymorphism design
- ✅ Mobile-friendly interface
- ✅ Professional color scheme
- ✅ All features working

**Start URL**: `http://localhost/Quiz%20test-pauline/quiz/Quiz/index.php`

Enjoy your modern, professional quiz system! 🚀

---

**Version**: 2.0
**Last Updated**: April 17, 2026
**Status**: Production Ready
