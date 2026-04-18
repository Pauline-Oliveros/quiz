// Quiz JavaScript functionality

document.addEventListener('DOMContentLoaded', function() {
    // Option selection animation
    const optionCards = document.querySelectorAll('.option-card');
    
    optionCards.forEach(card => {
        card.addEventListener('click', function() {
            // Remove selection from all cards
            optionCards.forEach(c => c.classList.remove('selected'));
            
            // Add selection to clicked card
            this.classList.add('selected');
            
            // Check the radio button
            const radio = this.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
            }
        });
    });

    // Form validation
    const quizForm = document.getElementById('quiz-form');
    if (quizForm) {
        quizForm.addEventListener('submit', function(e) {
            const selectedAnswer = document.querySelector('input[name="answer"]:checked');
            
            if (!selectedAnswer) {
                e.preventDefault();
                alert('Please select an answer before proceeding.');
                return false;
            }
        });
    }

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key >= '1' && e.key <= '6') {
            const index = parseInt(e.key) - 1;
            const options = document.querySelectorAll('.option-card');
            if (options[index]) {
                options[index].click();
            }
        }
        
        // Submit on Enter key
        if (e.key === 'Enter' && document.activeElement.tagName !== 'BUTTON') {
            const submitBtn = document.getElementById('submit-btn');
            if (submitBtn) {
                submitBtn.click();
            }
        }
    });

    // Prevent accidental page refresh
    window.addEventListener('beforeunload', function(e) {
        if (document.getElementById('quiz-form')) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // Add smooth scroll behavior
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Utility function to format time
function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const secs = seconds % 60;
    return `${minutes}:${secs.toString().padStart(2, '0')}`;
}

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
        color: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        animation: slideIn 0.3s ease;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .option-card.selected {
        border-color: #4f46e5;
        background: #f9fafb;
        transform: translateX(5px);
    }
`;
document.head.appendChild(style);
