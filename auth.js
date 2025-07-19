// Authentication JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initializeAuthPages();
});

function initializeAuthPages() {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    // This part is for showing the "Oops! You haven't logged in" message. It's correct.
    const redirectMessage = sessionStorage.getItem('login_redirect_message');
    if (redirectMessage) {
        showNotification(redirectMessage, 'error');
        sessionStorage.removeItem('login_redirect_message');
    }
    
    if (loginForm) {
        setupLoginForm();
    }
    
    if (registerForm) {
        setupRegisterForm();
    }
    
    animateBackgroundElements();
}

// --- UPDATED LOGIN FUNCTION ---
function setupLoginForm() {
    const form = document.getElementById('loginForm');
    const submitBtn = form.querySelector('.auth-button');
    const buttonText = submitBtn.querySelector('span');
    const buttonLoader = submitBtn.querySelector('.button-loader');
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        
        if (validateLoginForm(email, password)) {
            showLoading(submitBtn, buttonText, buttonLoader);
            
            try {
                const response = await fetch('/api/auth/login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, password }),
                });

                const result = await response.json();

                if (response.ok) {
                    // Store user data to keep them logged in
                    localStorage.setItem('liplab_user', JSON.stringify(result.user));
                    showNotification('Login successful! Welcome back!', 'success');
                    // Redirect to profile page
                    setTimeout(() => { window.location.href = 'profile.php'; }, 1500);
                } else if (response.status === 404) {
                    // Handle "user not found" specifically
                    showNotification(result.error || "You haven't registered yet.", 'error');
                    setTimeout(() => { window.location.href = 'register.php'; }, 1500);
                } else {
                    // Handle other errors like wrong password
                    showNotification(result.error || 'Login failed!', 'error');
                }
            } catch (error) {
                console.error('Login request failed:', error);
                showNotification('Could not connect to the server. Please try again.', 'error');
            } finally {
                hideLoading(submitBtn, buttonText, buttonLoader);
            }
        }
    });
    
    // Your real-time validation can stay the same
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    emailInput.addEventListener('blur', () => validateEmail(emailInput));
    passwordInput.addEventListener('blur', () => validatePassword(passwordInput));
}


// --- UPDATED REGISTRATION FUNCTION ---
function setupRegisterForm() {
    const form = document.getElementById('registerForm');
    const submitBtn = form.querySelector('.auth-button');
    const buttonText = submitBtn.querySelector('span');
    const buttonLoader = submitBtn.querySelector('.button-loader');
    const passwordInput = document.getElementById('registerPassword');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = {
            firstName: document.getElementById('firstName').value,
            lastName: document.getElementById('lastName').value,
            email: document.getElementById('registerEmail').value,
            password: passwordInput.value,
            confirmPassword: confirmPasswordInput.value,
            agreeTerms: document.getElementById('agreeTerms').checked,
        };
        
        if (validateRegisterForm(formData)) {
            showLoading(submitBtn, buttonText, buttonLoader);
            
            try {
                const response = await fetch('/api/auth/register', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(formData)
                });

                const result = await response.json();

                if (response.ok) {
                    showNotification('Account created successfully! Please log in.', 'success');
                    // Redirect to login page after successful registration
                    setTimeout(() => { window.location.href = 'login.php'; }, 1500);
                } else {
                    // Show error from server (e.g., "Email is already registered")
                    showNotification(result.error || 'Registration failed!', 'error');
                }
            } catch (error) {
                console.error('Registration request failed:', error);
                showNotification('Could not connect to the server. Please try again.', 'error');
            } finally {
                hideLoading(submitBtn, buttonText, buttonLoader);
            }
        }
    });
    
    // Your validation event listeners can stay the same
    passwordInput.addEventListener('input', () => updatePasswordStrength(passwordInput.value));
    confirmPasswordInput.addEventListener('input', () => validatePasswordMatch());
    document.getElementById('firstName').addEventListener('blur', (e) => validateRequired(e.target));
    document.getElementById('lastName').addEventListener('blur', (e) => validateRequired(e.target));
    document.getElementById('registerEmail').addEventListener('blur', (e) => validateEmail(e.target));
}


// --- ALL HELPER FUNCTIONS (No changes needed here) ---

function validateLoginForm(email, password) {
    let isValid = true;
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    if (!validateEmail(emailInput)) isValid = false;
    if (!validatePassword(passwordInput)) isValid = false;
    return isValid;
}

function validateRegisterForm(formData) {
    let isValid = true;
    if (!formData.firstName.trim()) {
        showFieldError('firstName', 'First name is required');
        isValid = false;
    }
    if (!formData.lastName.trim()) {
        showFieldError('lastName', 'Last name is required');
        isValid = false;
    }
    if (!validateEmail(document.getElementById('registerEmail'))) {
        isValid = false;
    }
    if (!validatePassword(document.getElementById('registerPassword'))) {
        isValid = false;
    }
    if (formData.password !== formData.confirmPassword) {
        showFieldError('confirmPassword', 'Passwords do not match');
        isValid = false;
    }
    if (!formData.agreeTerms) {
        showNotification('Please agree to the Terms of Service and Privacy Policy', 'error');
        isValid = false;
    }
    return isValid;
}

function validateEmail(input) {
    const email = input.value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email) {
        showFieldError(input.id, 'Email is required');
        return false;
    }
    if (!emailRegex.test(email)) {
        showFieldError(input.id, 'Please enter a valid email address');
        return false;
    }
    showFieldSuccess(input.id);
    return true;
}

function validatePassword(input) {
    const password = input.value;
    if (!password) {
        showFieldError(input.id, 'Password is required');
        return false;
    }
    if (password.length < 8) {
        showFieldError(input.id, 'Password must be at least 8 characters long');
        return false;
    }
    showFieldSuccess(input.id);
    return true;
}

function validateRequired(input) {
    const value = input.value.trim();
    if (!value) {
        const label = input.closest('.form-group').querySelector('label');
        showFieldError(input.id, `${label.textContent} is required`);
        return false;
    }
    showFieldSuccess(input.id);
    return true;
}

function validatePasswordMatch() {
    const password = document.getElementById('registerPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    if (confirmPassword && password !== confirmPassword) {
        showFieldError('confirmPassword', 'Passwords do not match');
        return false;
    }
    if (confirmPassword && password === confirmPassword) {
        showFieldSuccess('confirmPassword');
        return true;
    }
    return true;
}

function updatePasswordStrength(password) {
    const strengthBar = document.querySelector('.strength-fill');
    const strengthText = document.querySelector('.strength-text');
    if (!strengthBar || !strengthText) return;
    let strength = 0;
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    
    let strengthLabel = 'Weak';
    strengthBar.className = 'strength-fill weak';
    if (strength > 2) {
        strengthLabel = 'Medium';
        strengthBar.className = 'strength-fill medium';
    }
    if (strength > 4) {
        strengthLabel = 'Strong';
        strengthBar.className = 'strength-fill strong';
    }
    
    strengthBar.style.width = (strength / 5) * 100 + '%';
    strengthText.textContent = password ? `Password strength: ${strengthLabel}` : 'Password strength';
}

function showFieldError(fieldId, message) {
    const input = document.getElementById(fieldId);
    const wrapper = input.closest('.input-wrapper') || input.closest('.select-wrapper');
    wrapper.classList.remove('success');
    wrapper.classList.add('error');
    let errorDiv = wrapper.parentNode.querySelector('.error-message');
    if (!errorDiv) {
        errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        wrapper.parentNode.appendChild(errorDiv);
    }
    errorDiv.textContent = message;
    errorDiv.style.cssText = 'color: #ef4444; font-size: 0.8rem; margin-top: 0.25rem;';
}

function showFieldSuccess(fieldId) {
    const input = document.getElementById(fieldId);
    const wrapper = input.closest('.input-wrapper') || input.closest('.select-wrapper');
    wrapper.classList.remove('error');
    wrapper.classList.add('success');
    const errorDiv = wrapper.parentNode.querySelector('.error-message');
    if (errorDiv) {
        errorDiv.remove();
    }
}

function showLoading(button, textElement, loaderElement) {
    button.disabled = true;
    textElement.style.display = 'none';
    loaderElement.style.display = 'block';
}

function hideLoading(button, textElement, loaderElement) {
    button.disabled = false;
    textElement.style.display = 'block';
    loaderElement.style.display = 'none';
}

function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = input.nextElementSibling.querySelector('svg');
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>`;
    } else {
        input.type = 'password';
        icon.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
    }
}

function animateBackgroundElements() {
    // This is fine as is
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.style.cssText = `
        position: fixed; top: 2rem; right: 2rem;
        background: ${type === 'error' ? 'linear-gradient(135deg, #ef4444, #dc2626)' : 'linear-gradient(135deg, #10b981, #059669)'};
        color: white; padding: 1rem 1.5rem; border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); z-index: 10001;
        transform: translateX(120%); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-weight: 600; backdrop-filter: blur(10px); max-width: 350px;
    `;
    notification.textContent = message;
    document.body.appendChild(notification);
    setTimeout(() => { notification.style.transform = 'translateX(0)'; }, 100);
    setTimeout(() => {
        notification.style.transform = 'translateX(120%)';
        setTimeout(() => { if (notification.parentNode) { notification.parentNode.removeChild(notification); }}, 300);
    }, 4000);
}

// Social login handlers can remain the same
document.addEventListener('click', function(e) {
    if (e.target.closest('.google-button')) handleSocialLogin('Google');
    else if (e.target.closest('.facebook-button')) handleSocialLogin('Facebook');
});

function handleSocialLogin(provider) {
    showNotification(`Connecting with ${provider}...`, 'info');
    setTimeout(() => {
        showNotification(`${provider} login successful!`, 'success');
        setTimeout(() => { window.location.href = 'profile.php'; }, 1500);
    }, 2000);
}