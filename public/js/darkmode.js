// darkmode.js - This file should be placed in the public/js directory

// Dark mode functionality
document.addEventListener('DOMContentLoaded', function() {
    // Check for saved theme preference or use system preference
    if (localStorage.getItem('dark-mode') === 'true' || 
        (!localStorage.getItem('dark-mode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        updateToggleState(true);
    } else {
        document.documentElement.classList.remove('dark');
        updateToggleState(false);
    }

    // Add event listeners to toggle buttons
    document.querySelectorAll('.darkmode-toggle').forEach(toggle => {
        toggle.addEventListener('click', function() {
            toggleDarkMode();
        });
    });
    
    // Initialize code editor themes if they exist
    initializeCodeEditors();
});

// Toggle between dark and light modes
function toggleDarkMode() {
    if (document.documentElement.classList.contains('dark')) {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('dark-mode', 'false');
        updateToggleState(false);
    } else {
        document.documentElement.classList.add('dark');
        localStorage.setItem('dark-mode', 'true');
        updateToggleState(true);
    }
    
    // Update code editors if they exist
    updateCodeEditorThemes();
}

// Update the visual state of all toggle buttons
function updateToggleState(isDarkMode) {
    document.querySelectorAll('.darkmode-label').forEach(label => {
        if (isDarkMode) {
            label.textContent = 'Light Mode';
        } else {
            label.textContent = 'Dark Mode';
        }
    });
}

// Initialize code editors with the current theme
function initializeCodeEditors() {
    // Check if CodeMirror is being used (you can replace this with your actual code editor library)
    if (typeof CodeMirror !== 'undefined') {
        const isDarkMode = document.documentElement.classList.contains('dark');
        const theme = isDarkMode ? 'dracula' : 'default';
        
        // Find all CodeMirror instances and update their theme
        document.querySelectorAll('.CodeMirror').forEach(editor => {
            const cm = editor.CodeMirror;
            if (cm) {
                cm.setOption('theme', theme);
            }
        });
    }
}

// Update code editor themes when dark mode is toggled
function updateCodeEditorThemes() {
    if (typeof CodeMirror !== 'undefined') {
        const isDarkMode = document.documentElement.classList.contains('dark');
        const theme = isDarkMode ? 'dracula' : 'default';
        
        document.querySelectorAll('.CodeMirror').forEach(editor => {
            const cm = editor.CodeMirror;
            if (cm) {
                cm.setOption('theme', theme);
            }
        });
    }
}

// Enhanced UI interactions
document.addEventListener('DOMContentLoaded', function() {
    // Add hover animations to cards
    document.querySelectorAll('.material-card, .challenge-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.querySelector('.card-icon')?.classList.add('animate-pulse');
        });
        
        card.addEventListener('mouseleave', function() {
            this.querySelector('.card-icon')?.classList.remove('animate-pulse');
        });
    });
    
    // Initialize difficulty level indicators
    document.querySelectorAll('[data-difficulty]').forEach(element => {
        const difficulty = element.getAttribute('data-difficulty');
        const classList = element.classList;
        
        if (difficulty === 'easy') {
            classList.add('challenge-difficulty-easy');
        } else if (difficulty === 'medium') {
            classList.add('challenge-difficulty-medium');
        } else if (difficulty === 'hard') {
            classList.add('challenge-difficulty-hard');
        }
    });
    
    // Add smooth scroll behavior to anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});