// ========================================
// TOAST NOTIFICATION SYSTEM
// ========================================
class Toast {
    constructor() {
        this.toast = document.getElementById('toast');
        this.closeBtn = this.toast?.querySelector('.toast-close');
        this.initCloseButton();
    }

    initCloseButton() {
        if (this.closeBtn) {
            this.closeBtn.addEventListener('click', () => this.hide());
        }
    }

    show(type, title, message, duration = 4000) {
        if (!this.toast) return;

        // Reset classes
        this.toast.className = 'toast';
        
        // Add type class
        this.toast.classList.add(type);
        
        // Set content
        const titleEl = this.toast.querySelector('.toast-title');
        const messageEl = this.toast.querySelector('.toast-message');
        
        if (titleEl) titleEl.textContent = title;
        if (messageEl) messageEl.textContent = message;
        
        // Show toast
        setTimeout(() => {
            this.toast.classList.add('show');
        }, 100);
        
        // Auto hide
        if (duration > 0) {
            setTimeout(() => this.hide(), duration);
        }
    }

    hide() {
        if (this.toast) {
            this.toast.classList.remove('show');
        }
    }

    success(title, message, duration) {
        this.show('success', title, message, duration);
    }

    error(title, message, duration) {
        this.show('error', title, message, duration);
    }

    info(title, message, duration) {
        this.show('info', title, message, duration);
    }
}

// Initialize toast
const toast = new Toast();

// ========================================
// PASSWORD TOGGLE
// ========================================
function initPasswordToggle() {
    const toggleBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeOpen = toggleBtn?.querySelector('.eye-open');
    const eyeClosed = toggleBtn?.querySelector('.eye-closed');

    if (!toggleBtn || !passwordInput) return;

    toggleBtn.addEventListener('click', function() {
        const isPassword = passwordInput.type === 'password';
        
        // Toggle input type
        passwordInput.type = isPassword ? 'text' : 'password';
        
        // Toggle icons
        if (eyeOpen && eyeClosed) {
            eyeOpen.style.display = isPassword ? 'none' : 'block';
            eyeClosed.style.display = isPassword ? 'block' : 'none';
        }
        
        // Update aria attribute
        toggleBtn.setAttribute('aria-pressed', String(isPassword));
        
        // Focus back to input
        passwordInput.focus();
    });
}

// ========================================
// FORM VALIDATION & SUBMISSION
// ========================================
function initFormValidation() {
    const form = document.getElementById('loginForm');
    const loginBtn = document.getElementById('loginBtn');
    const btnText = loginBtn?.querySelector('.btn-text');
    const btnLoader = loginBtn?.querySelector('.btn-loader');

    if (!form) return;

    // Real-time validation
    const inputs = form.querySelectorAll('input[required]');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });

        input.addEventListener('input', function() {
            // Remove error state on typing
            const wrapper = this.closest('.input-wrapper');
            if (wrapper) {
                this.style.borderColor = '';
            }
        });
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        // Validate all fields
        let isValid = true;
        inputs.forEach(input => {
            if (!validateField(input)) {
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault();
            toast.error('Validation Error', 'Please fill in all required fields correctly.');
            return false;
        }

        // Show loading state
        if (loginBtn && btnText && btnLoader) {
            loginBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoader.style.display = 'inline-flex';
        }

        // Form will submit normally
        // Loading state will be visible until page reloads
    });
}

function validateField(input) {
    const value = input.value.trim();
    const wrapper = input.closest('.input-wrapper');
    const formGroup = input.closest('.form-group');
    let existingError = formGroup?.querySelector('.error-message');

    // Remove existing error if present
    if (existingError && !existingError.hasAttribute('data-server-error')) {
        existingError.remove();
        existingError = null;
    }

    // Email validation
    if (input.type === 'email') {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!value) {
            showFieldError(input, 'Email is required');
            return false;
        }
        if (!emailRegex.test(value)) {
            showFieldError(input, 'Please enter a valid email address');
            return false;
        }
    }

    // Password validation
    if (input.type === 'password' || input.id === 'password') {
        if (!value) {
            showFieldError(input, 'Password is required');
            return false;
        }
        if (value.length < 6) {
            showFieldError(input, 'Password must be at least 6 characters');
            return false;
        }
    }

    // Clear error state
    if (wrapper) {
        input.style.borderColor = '';
    }

    return true;
}

function showFieldError(input, message) {
    const wrapper = input.closest('.input-wrapper');
    const formGroup = input.closest('.form-group');

    // Add error border
    if (wrapper) {
        input.style.borderColor = '#ef4444';
    }

    // Check if error message already exists (don't duplicate)
    let errorMsg = formGroup?.querySelector('.error-message');
    if (errorMsg && !errorMsg.hasAttribute('data-server-error')) {
        errorMsg.textContent = message;
        return;
    }

    // Create error message
    if (formGroup && !errorMsg) {
        errorMsg = document.createElement('div');
        errorMsg.className = 'error-message';
        errorMsg.innerHTML = `
            <svg class="error-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            ${message}
        `;
        formGroup.appendChild(errorMsg);
    }
}

// ========================================
// SESSION ALERTS AUTO-HIDE
// ========================================
function initSessionAlerts() {
    const sessionAlert = document.getElementById('session-alert');
    
    if (sessionAlert) {
        // Auto hide after 5 seconds
        setTimeout(() => {
            sessionAlert.style.opacity = '0';
            sessionAlert.style.transform = 'translateY(-10px)';
            
            setTimeout(() => {
                sessionAlert.remove();
            }, 400);
        }, 5000);
    }
}

// ========================================
// INPUT ANIMATIONS
// ========================================
function initInputAnimations() {
    const inputs = document.querySelectorAll('.input-wrapper input');
    
    inputs.forEach(input => {
        // Add focus animation
        input.addEventListener('focus', function() {
            const wrapper = this.closest('.input-wrapper');
            if (wrapper) {
                wrapper.style.transform = 'scale(1.01)';
            }
        });

        input.addEventListener('blur', function() {
            const wrapper = this.closest('.input-wrapper');
            if (wrapper) {
                wrapper.style.transform = 'scale(1)';
            }
        });
    });
}

// ========================================
// CHECK FOR SUCCESS/ERROR IN URL
// ========================================
function checkURLParams() {
    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.has('registered')) {
        toast.success('Registration Successful!', 'Please login with your credentials.', 5000);
    }
    
    if (urlParams.has('logout')) {
        toast.info('Logged Out', 'You have been successfully logged out.', 4000);
    }
    
    if (urlParams.has('error')) {
        const error = urlParams.get('error');
        toast.error('Login Failed', error || 'An error occurred. Please try again.', 5000);
    }
}

// ========================================
// GOOGLE BUTTON ANIMATION
// ========================================
function initGoogleButton() {
    const googleBtn = document.querySelector('.google-btn');
    
    if (googleBtn) {
        googleBtn.addEventListener('click', function(e) {
            // Add loading state
            const originalHTML = this.innerHTML;
            this.style.opacity = '0.7';
            this.style.pointerEvents = 'none';
            
            // Show loading on button
            this.innerHTML = `
                <svg class="spinner" style="width:20px;height:20px;" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="3"/>
                </svg>
                <span>Redirecting to Google...</span>
            `;
            
            // Let the href navigate naturally
            // The page will change before we need to restore
        });
    }
}

// ========================================
// FORM AUTO-FILL DETECTION
// ========================================
function detectAutoFill() {
    const inputs = document.querySelectorAll('.input-wrapper input');
    
    // Check for autofill after a short delay
    setTimeout(() => {
        inputs.forEach(input => {
            if (input.value) {
                const wrapper = input.closest('.input-wrapper');
                if (wrapper) {
                    input.style.borderColor = '#667eea';
                    setTimeout(() => {
                        input.style.borderColor = '';
                    }, 1000);
                }
            }
        });
    }, 500);
}

// ========================================
// KEYBOARD SHORTCUTS
// ========================================
function initKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        // Alt + G for Google login
        if (e.altKey && e.key === 'g') {
            e.preventDefault();
            const googleBtn = document.querySelector('.google-btn');
            if (googleBtn) {
                googleBtn.click();
            }
        }
    });
}

// ========================================
// INITIALIZE ALL
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Alchemy Login System Initialized');
    
    initPasswordToggle();
    initFormValidation();
    initSessionAlerts();
    initInputAnimations();
    initGoogleButton();
    initKeyboardShortcuts();
    checkURLParams();
    detectAutoFill();
    
    // Show welcome message for first-time visitors
    if (!sessionStorage.getItem('visited')) {
        setTimeout(() => {
            toast.info('Welcome to Alchemy!', 'Please login or create an account to continue.', 5000);
            sessionStorage.setItem('visited', 'true');
        }, 500);
    }
});

// ========================================
// EXPORT FOR TESTING
// ========================================
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { Toast, validateField };
}