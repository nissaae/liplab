<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - LipLab</title>
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
                    <h1 class="form-title">Welcome Back</h1>
                    <p class="form-subtitle">Enter your email and password to access your account.</p>

                    <form class="login-form" id="loginForm" action="login-process.php" method="POST">
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-input" 
                                placeholder="your@email.com" 
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <div class="password-input-wrapper">
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    class="form-input" 
                                    placeholder="Enter your password" 
                                    required
                                >
                                <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                    <svg class="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="form-options">
                            <label class="checkbox-wrapper">
                                <input type="checkbox" id="remember" name="remember">
                                <span class="checkmark"></span>
                                <span class="checkbox-text">Remember Me</span>
                            </label>
                            <a href="#" class="forgot-link">Forgot Your Password?</a>
                        </div>

                        <button type="submit" class="submit-button">
                            <span>Log In</span>
                        </button>

                        <div class="divider">
                            <span>Or Login With</span>
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
                            <span>Don't Have An Account? </span>
                            <a href="register.php" class="auth-link">Register Now.</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Side - Promotional Content -->
        <div class="auth-promo-section">
            <div class="promo-content">
                <h2 class="promo-title">Discover Your Perfect Lip Shade</h2>
                <p class="promo-subtitle">Log in to access your personalized beauty dashboard and find your ideal lip colors.</p>
                
                <div class="promo-visual">
                    <div class="dashboard-mockup">
                        <!-- Beauty Dashboard Mockup -->
                        <div class="dashboard-header">
                            <div class="dashboard-stats">
                                <div class="stat-card primary">
                                    <span class="stat-label">Your Matches</span>
                                    <span class="stat-value">24</span>
                                </div>
                                <div class="stat-card">
                                    <span class="stat-label">Saved Products</span>
                                    <span class="stat-value">12</span>
                                </div>
                                <div class="stat-card">
                                    <span class="stat-label">Wishlist</span>
                                    <span class="stat-value">8</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="dashboard-content">
                            <div class="skin-tone-analysis">
                                <h4>Your Skin Tone</h4>
                                <div class="skin-tone-result">
                                    <div class="skin-tone-circle"></div>
                                    <div class="skin-tone-info">
                                        <span class="skin-tone-name">Medium Warm</span>
                                        <span class="skin-tone-confidence">95% Match</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="recent-products">
                                <h4>Recent Recommendations</h4>
                                <div class="product-list">
                                    <div class="product-item">
                                        <div class="product-color" style="background: #D4756B;"></div>
                                        <div class="product-info">
                                            <span class="product-name">Coral Bliss</span>
                                            <span class="product-brand">Beauty Co.</span>
                                        </div>
                                        <span class="product-match">92%</span>
                                    </div>
                                    <div class="product-item">
                                        <div class="product-color" style="background: #B85450;"></div>
                                        <div class="product-info">
                                            <span class="product-name">Rose Gold</span>
                                            <span class="product-brand">Glam Labs</span>
                                        </div>
                                        <span class="product-match">89%</span>
                                    </div>
                                    <div class="product-item">
                                        <div class="product-color" style="background: #A0522D;"></div>
                                        <div class="product-info">
                                            <span class="product-name">Warm Nude</span>
                                            <span class="product-brand">Pure Beauty</span>
                                        </div>
                                        <span class="product-match">87%</span>
                                    </div>
                                </div>
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

        // Form validation and submission
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            if (!email || !password) {
                e.preventDefault();
                showNotification('Please fill in all fields', 'error');
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
