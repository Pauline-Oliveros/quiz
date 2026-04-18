// Main JavaScript file for general functionality

document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const menuToggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('.nav');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            nav.classList.toggle('active');
        });
    }

    // Form validation for start form
    const startForm = document.querySelector('.start-form');
    if (startForm) {
        startForm.addEventListener('submit', function(e) {
            const studentName = document.getElementById('student_name');
            const category = document.getElementById('category');
            const difficulty = document.getElementById('difficulty');
            
            if (!studentName.value.trim()) {
                e.preventDefault();
                alert('Please enter your name');
                studentName.focus();
                return false;
            }
            
            if (!category.value) {
                e.preventDefault();
                alert('Please select a category');
                category.focus();
                return false;
            }
            
            if (!difficulty.value) {
                e.preventDefault();
                alert('Please select a difficulty level');
                difficulty.focus();
                return false;
            }
        });
    }

    // Add loading animation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            }
        });
    });

    // Smooth animations on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe feature cards
    document.querySelectorAll('.feature-card, .stat-card, .answer-item').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(el);
    });

    // Add tooltips
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    tooltipElements.forEach(el => {
        el.addEventListener('mouseenter', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = this.getAttribute('data-tooltip');
            tooltip.style.cssText = `
                position: absolute;
                background: #1f2937;
                color: white;
                padding: 8px 12px;
                border-radius: 6px;
                font-size: 0.875rem;
                z-index: 1000;
                pointer-events: none;
                white-space: nowrap;
            `;
            document.body.appendChild(tooltip);
            
            const rect = this.getBoundingClientRect();
            tooltip.style.top = (rect.top - tooltip.offsetHeight - 10) + 'px';
            tooltip.style.left = (rect.left + rect.width / 2 - tooltip.offsetWidth / 2) + 'px';
            
            this._tooltip = tooltip;
        });
        
        el.addEventListener('mouseleave', function() {
            if (this._tooltip) {
                this._tooltip.remove();
                this._tooltip = null;
            }
        });
    });

    // Print functionality
    const printButtons = document.querySelectorAll('[onclick*="print"]');
    printButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            window.print();
        });
    });

    // Confirmation dialogs
    const confirmLinks = document.querySelectorAll('a[href*="reset"], a[href*="delete"]');
    confirmLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to proceed?')) {
                e.preventDefault();
            }
        });
    });
});

// Utility functions
function showLoader() {
    const loader = document.createElement('div');
    loader.id = 'page-loader';
    loader.innerHTML = '<div class="spinner"></div>';
    loader.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    `;
    document.body.appendChild(loader);
}

function hideLoader() {
    const loader = document.getElementById('page-loader');
    if (loader) {
        loader.remove();
    }
}

// Add spinner styles
const spinnerStyle = document.createElement('style');
spinnerStyle.textContent = `
    .spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #f3f4f6;
        border-top: 5px solid #4f46e5;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
`;
document.head.appendChild(spinnerStyle);
