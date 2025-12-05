// Toast Notification Function
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toast-message');

    toastMessage.textContent = message;
    toast.classList.remove('error');

    if (type === 'error') {
        toast.classList.add('error');
    }

    toast.classList.add('show');

    setTimeout(() => {
        toast.classList.remove('show');
    }, 4000);
}

// Password Strength Calculator
function calculatePasswordStrength(password) {
    let strength = 0;

    if (password.length >= 8) strength += 25;
    if (password.length >= 12) strength += 25;
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 25;
    if (/[0-9]/.test(password)) strength += 12.5;
    if (/[^a-zA-Z0-9]/.test(password)) strength += 12.5;

    return Math.min(strength, 100);
}

// Update Password Strength UI
function updatePasswordStrength(password) {
    const strengthContainer = document.getElementById('password-strength');
    const strengthFill = document.getElementById('strength-fill');
    const strengthText = document.getElementById('strength-text');

    if (password.length === 0) {
        strengthContainer.style.display = 'none';
        return;
    }

    strengthContainer.style.display = 'block';
    const strength = calculatePasswordStrength(password);

    // Remove all classes
    strengthFill.className = 'strength-fill';
    strengthText.className = 'strength-text';

    // Add appropriate class based on strength
    if (strength < 30) {
        strengthFill.classList.add('weak');
        strengthText.classList.add('weak');
        strengthText.textContent = 'Lemah';
    } else if (strength < 60) {
        strengthFill.classList.add('medium');
        strengthText.classList.add('medium');
        strengthText.textContent = 'Cukup';
    } else if (strength < 80) {
        strengthFill.classList.add('good');
        strengthText.classList.add('good');
        strengthText.textContent = 'Bagus';
    } else {
        strengthFill.classList.add('strong');
        strengthText.classList.add('strong');
        strengthText.textContent = 'Kuat';
    }
}

// Form Validation
function validateField(field, value) {
    const errorElement = document.getElementById(`${field}-error`);
    const input = document.getElementById(field);
    let errorMessage = '';

    switch(field) {
        case 'name':
            if (!value.trim()) {
                errorMessage = 'Nama lengkap wajib diisi';
            }
            break;

        case 'email':
            if (!value.trim()) {
                errorMessage = 'Email wajib diisi';
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                errorMessage = 'Format email tidak valid';
            }
            break;

        case 'username':
            if (!value.trim()) {
                errorMessage = 'Username wajib diisi';
            } else if (value.length < 3) {
                errorMessage = 'Username minimal 3 karakter';
            }
            break;

        case 'password':
            if (!value) {
                errorMessage = 'Password wajib diisi';
            } else if (value.length < 8) {
                errorMessage = 'Password minimal 8 karakter';
            }
            break;

        case 'password_confirmation':
            const password = document.getElementById('password').value;
            if (!value) {
                errorMessage = 'Konfirmasi password wajib diisi';
            } else if (value !== password) {
                errorMessage = 'Password tidak cocok';
            }
            break;
    }

    if (errorMessage) {
        errorElement.textContent = errorMessage;
        errorElement.classList.add('show');
        input.classList.add('error');
        return false;
    } else {
        errorElement.classList.remove('show');
        input.classList.remove('error');
        return true;
    }
}

// Initialize Toggle Password
function initializePasswordToggles() {
    const toggleButtons = document.querySelectorAll('.toggle-password');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('.eye-icon');

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                    <line x1="1" y1="1" x2="23" y2="23"/>
                `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/>
                    <circle cx="12" cy="12" r="3"/>
                `;
            }
        });
    });
}

// Initialize Real-time Validation
function initializeRealTimeValidation() {
    const fields = ['name', 'email', 'username', 'password', 'password_confirmation'];

    fields.forEach(field => {
        const input = document.getElementById(field);

        if (input) {
            // Validate on blur
            input.addEventListener('blur', function() {
                validateField(field, this.value);
            });

            // Clear error on input
            input.addEventListener('input', function() {
                const errorElement = document.getElementById(`${field}-error`);
                if (errorElement.classList.contains('show')) {
                    validateField(field, this.value);
                }

                // Update password strength for password field
                if (field === 'password') {
                    updatePasswordStrength(this.value);
                }

                // Check password match for confirmation field
                if (field === 'password_confirmation') {
                    validateField(field, this.value);
                }
            });

            // Add focus animation
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        }
    });

    // Real-time password match validation
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');

    if (password && passwordConfirmation) {
        password.addEventListener('input', function() {
            if (passwordConfirmation.value) {
                validateField('password_confirmation', passwordConfirmation.value);
            }
        });
    }
}

// Form Submit Handler
function initializeFormSubmit() {
    const form = document.getElementById('signupForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoader = submitBtn.querySelector('.btn-loader');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Validate all fields
        const fields = ['name', 'email', 'username', 'password', 'password_confirmation'];
        let isValid = true;

        fields.forEach(field => {
            const input = document.getElementById(field);
            if (!validateField(field, input.value)) {
                isValid = false;
            }
        });

        if (!isValid) {
            showToast('Mohon perbaiki error terlebih dahulu', 'error');
            return;
        }

        // Show loading state
        submitBtn.disabled = true;
        btnText.style.display = 'none';
        btnLoader.style.display = 'flex';

        // Submit form (in real scenario, this would be an actual form submission)
        // For demo purposes, we'll simulate a delay
        setTimeout(() => {
            // If you want to actually submit the form to Laravel:
            form.submit();

            // For demo purposes:
            showToast('Akun berhasil dibuat! Selamat datang di Alchemy 🎉', 'success');

            // Reset form after success
            setTimeout(() => {
                form.reset();
                updatePasswordStrength('');
                submitBtn.disabled = false;
                btnText.style.display = 'inline';
                btnLoader.style.display = 'none';

                // Uncomment this if you want to redirect after registration:
                window.location.href = '/login';
            }, 1500);
        }, 2000);
    });
}

// Add input animations
function addInputAnimations() {
    const inputs = document.querySelectorAll('input');

    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.transform = 'translateY(-2px)';
        });

        input.addEventListener('blur', function() {
            this.style.transform = 'translateY(0)';
        });
    });
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializePasswordToggles();
    initializeRealTimeValidation();
    initializeFormSubmit();
    addInputAnimations();

    // Add entrance animation to form elements
    const formGroups = document.querySelectorAll('.form-group');
    formGroups.forEach((group, index) => {
        group.style.opacity = '0';
        group.style.transform = 'translateY(20px)';

        setTimeout(() => {
            group.style.transition = 'all 0.5s ease';
            group.style.opacity = '1';
            group.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Show success message if there's a session status (from Laravel)
    const statusElements = document.querySelectorAll('.status');
    statusElements.forEach(element => {
        if (element.textContent.trim()) {
            showToast(element.textContent.trim(), 'success');
        }
    });
});
