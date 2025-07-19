<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join LipLab</title>
    <link rel="stylesheet" href="auth.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
        <a href="index.php" class="back-to-home">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Back to Homepage
        </a>
    <div class="auth-container">
        <!-- Left Side - Form -->
        <div class="auth-form-section">
            <div class="form-container">
                <!-- Logo -->
                <div class="brand-logo">
                    <div class="logo-icon">L</div>
                    <span class="brand-name">LipLab</span>
                </div>

                <!-- Form Content -->
                <div class="form-content">
                    <h1 class="form-title">Join LipLab</h1>
                    <p class="form-subtitle">Create your account to discover your perfect lip shades.</p>

                    <form class="register-form" id="registerForm" action="register-process.php" method="POST">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName" class="form-label">First Name</label>
                                <input 
                                    type="text" 
                                    id="firstName" 
                                    name="firstName" 
                                    class="form-input" 
                                    placeholder="First Name" 
                                    required
                                >
                            </div>
                            <div class="form-group">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input 
                                    type="text" 
                                    id="lastName" 
                                    name="lastName" 
                                    class="form-input" 
                                    placeholder="Last Name" 
                                    required
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="registerEmail" 
                                class="form-input" 
                                placeholder="your@email.com" 
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="skinTone" class="form-label">Skin Tone (Optional)</label>
                            <select id="skinTone" name="skinTone" class="form-select">
                                <option value="">Select your skin tone</option>
                                <option value="fair-cool">Fair Cool</option>
                                <option value="fair-warm">Fair Warm</option>
                                <option value="fair-neutral">Fair Neutral</option>
                                <option value="light-cool">Light Cool</option>
                                <option value="light-warm">Light Warm</option>
                                <option value="light-neutral">Light Neutral</option>
                                <option value="medium-cool">Medium Cool</option>
                                <option value="medium-warm">Medium Warm</option>
                                <option value="medium-neutral">Medium Neutral</option>
                                <option value="deep-cool">Deep Cool</option>
                                <option value="deep-warm">Deep Warm</option>
                                <option value="deep-neutral">Deep Neutral</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <div class="password-input-wrapper">
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="registerPassword" 
                                    class="form-input" 
                                    placeholder="Create a strong password" 
                                    required
                                >
                                <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                    <svg class="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="password-strength" id="passwordStrength">
                                <div class="strength-bar">
                                    <div class="strength-fill"></div>
                                </div>
                                <span class="strength-text">Password strength</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <div class="password-input-wrapper">
                                <input 
                                    type="password" 
                                    id="confirmPassword" 
                                    name="confirmPassword" 
                                    class="form-input" 
                                    placeholder="Confirm your password" 
                                    required
                                >
                                <button type="button" class="password-toggle" onclick="togglePassword('confirmPassword')">
                                    <svg class="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="form-checkboxes">
                            <label class="checkbox-wrapper">
                                <input type="checkbox" id="agreeTerms" name="agreeTerms" required>
                                <span class="checkmark"></span>
                                <span class="checkbox-text">I agree to the <a href="#" class="terms-link">Terms of Service</a> and <a href="#" class="terms-link">Privacy Policy</a></span>
                            </label>
                            <label class="checkbox-wrapper">
                                <input type="checkbox" id="newsletter" name="newsletter">
                                <span class="checkmark"></span>
                                <span class="checkbox-text">Subscribe to our newsletter for beauty tips and exclusive offers</span>
                            </label>
                        </div>

                        <button type="submit" class="submit-button">
                            <span>Create Account</span>
                        </button>

                        <div class="divider">
                            <span>Or continue with</span>
                        </div>

                        <div class="social-buttons">
                            <button type="button" class="social-button google-button">
                                <svg width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="#ea4335" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                    <path fill="#34a853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                    <path fill="#fbbc05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.37H2.18C1.43 8.87 1 10.39 1 12s.43 3.13 1.18 4.63l2.85-2.22.81-.32z"/>
                                    <path fill="#ea4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.37l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                </svg>
                                Google
                            </button>
                            <button type="button" class="social-button apple-button">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                                </svg>
                                Apple
                            </button>
                        </div>

                        <div class="auth-footer">
                            <span>Already have an account? </span>
                            <a href="login.php" class="auth-link">Sign in here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Side - Promotional Content -->
        <div class="auth-promo-section">
            <div class="promo-content">
                <h2 class="promo-title">Start Your Beauty Journey</h2>
                <p class="promo-subtitle">Join thousands of users who have discovered their perfect lip shades with our AI-powered recommendations.</p>
                
                <div class="promo-visual">
                    <div class="features-showcase">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 11H1l4-4M1 7l4 4M23 13h-8l4 4M23 17l-4-4"/>
                                </svg>
                            </div>
                            <div class="feature-content">
                                <h4>AI Shade Matching</h4>
                                <p>Upload your photo and get personalized lip shade recommendations</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                </svg>
                            </div>
                            <div class="feature-content">
                                <h4>Save Favorites</h4>
                                <p>Create your personal collection of perfect lip shades</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                            <div class="feature-content">
                                <h4>Expert Reviews</h4>
                                <p>Read reviews and ratings from beauty experts and users</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="3"/>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                                </svg>
                            </div>
                            <div class="feature-content">
                                <h4>Personalized Dashboard</h4>
                                <p>Track your beauty journey with detailed analytics</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('.eye-icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                    <line x1="1" y1="1" x2="23" y2="23"/>
                `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                `;
            }
        }

        // Password strength checker
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.querySelector('.strength-fill');
            const strengthText = document.querySelector('.strength-text');
            
            let strength = 0;
            let strengthLabel = 'Weak';
            
            if (password.length >= 8) strength += 25;
            if (/[a-z]/.test(password)) strength += 25;
            if (/[A-Z]/.test(password)) strength += 25;
            if (/[0-9]/.test(password)) strength += 25;
            
            if (strength >= 75) strengthLabel = 'Strong';
            else if (strength >= 50) strengthLabel = 'Medium';
            
            strengthBar.style.width = strength + '%';
            strengthText.textContent = `Password strength: ${strengthLabel}`;
            
            // Color coding
            if (strength >= 75) {
                strengthBar.style.background = 'linear-gradient(135deg, #10b981, #059669)';
            } else if (strength >= 50) {
                strengthBar.style.background = 'linear-gradient(135deg, #f59e0b, #d97706)';
            } else {
                strengthBar.style.background = 'linear-gradient(135deg, #ef4444, #dc2626)';
            }
        });

        // Form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const agreeTerms = document.getElementById('agreeTerms').checked;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                showNotification('Passwords do not match', 'error');
                return;
            }
            
            if (!agreeTerms) {
                e.preventDefault();
                showNotification('Please agree to the Terms of Service', 'error');
                return;
            }
        });

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.style.cssText = `
                position: fixed; top: 2rem; right: 2rem;
                background: ${type === 'error' ? 'linear-gradient(135deg, #ef4444, #dc2626)' : 'linear-gradient(135deg, #10b981, #059669)'};
                color: white; padding: 1rem 1.5rem; border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); z-index: 10001;
                transform: translateX(120%); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                font-weight: 600; max-width: 300px;
            `;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => { notification.style.transform = 'translateX(0)'; }, 100);
            setTimeout(() => {
                notification.style.transform = 'translateX(120%)';
                setTimeout(() => { 
                    if (notification.parentNode) { 
                        notification.parentNode.removeChild(notification); 
                    }
                }, 300);
            }, 4000);
        }
    </script>
</body>
</html>
