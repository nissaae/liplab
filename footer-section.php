<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced LipLab Footer</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            background: #f9fafb;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Demo content to show footer in context */
        .demo-content {
            flex: 1;
            padding: 4rem 2rem;
            text-align: center;
            background: linear-gradient(135deg, #fef7ff 0%, #f3e8ff 100%);
        }

        .demo-content h1 {
            font-size: 2.5rem;
            color: #1f2937;
            margin-bottom: 1rem;
        }

        .demo-content p {
            font-size: 1.125rem;
            color: #6b7280;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Enhanced Footer CTA Section */
        .footer-cta-section {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #334155 50%, #475569 75%, #64748b 100%);
            padding: 5rem 0;
            margin-top: 4rem;
            border-radius: 32px 32px 0 0;
            position: relative;
            overflow: hidden;
        }

        .footer-cta-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 20%, rgba(236, 72, 153, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(139, 92, 246, 0.1) 0%, transparent 50%),
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .footer-cta-section::after {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg, transparent, rgba(236, 72, 153, 0.03), transparent);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            to {
                transform: rotate(360deg);
            }
        }

        .cta-content {
            text-align: center;
            position: relative;
            z-index: 3;
            max-width: 700px;
            margin: 0 auto;
        }

        .cta-title {
            font-size: 3rem;
            font-weight: 900;
            color: white;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            background: linear-gradient(135deg, #fff 0%, #e2e8f0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .cta-subtitle {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 3rem;
            line-height: 1.6;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-button {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background: linear-gradient(135deg, #ec4899 0%, #f43f5e 50%, #ef4444 100%);
            color: white;
            text-decoration: none;
            padding: 1.25rem 3rem;
            border-radius: 16px;
            font-weight: 700;
            font-size: 1.125rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 
                0 10px 40px rgba(236, 72, 153, 0.3),
                0 4px 20px rgba(236, 72, 153, 0.2);
            position: relative;
            overflow: hidden;
        }

        .cta-button::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
        }

        .cta-button:hover::before {
            left: 100%;
        }

        .cta-button:hover {
            background: linear-gradient(135deg, #db2777 0%, #e11d48 50%, #dc2626 100%);
            transform: translateY(-3px);
            box-shadow: 
                0 15px 50px rgba(236, 72, 153, 0.4),
                0 8px 30px rgba(236, 72, 153, 0.3);
        }

        .cta-button svg {
            transition: transform 0.3s ease;
        }

        .cta-button:hover svg {
            transform: translateX(3px);
        }

        /* Enhanced Main Footer */
        .main-footer {
            background: linear-gradient(135deg, #fefcff 0%, #fdf2f8 100%);
            padding: 4rem 0 2rem;
            border-top: 1px solid rgba(236, 72, 153, 0.08);
            position: relative;
        }

        .main-footer::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(236, 72, 153, 0.3), transparent);
        }

        .footer-content {
            display: grid;
            grid-template-columns: 1.2fr 2fr;
            gap: 5rem;
            margin-bottom: 4rem;
        }

        /* Enhanced Footer Brand */
        .footer-brand {
            display: flex;
            flex-direction: column;
            align-items: flex-start; /* agar teks dan ikon rata kiri */
            gap: 1rem; /* jarak antar elemen */
            max-width: 450px;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .footer-logo .logo-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #ec4899 0%, #f43f5e 50%, #ef4444 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 900;
            font-size: 1.5rem;
            box-shadow: 
                0 8px 25px rgba(236, 72, 153, 0.3),
                0 3px 10px rgba(236, 72, 153, 0.2);
        }

        .footer-logo .logo-text {
            font-size: 1.75rem;
            font-weight: 800;
            color: #1f2937;
        }

        .footer-description {
            color: #64748b;
            line-height: 1.5;
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }

        .footer-social {
            display: flex;
            gap: 1.25rem;
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            background: rgba(236, 72, 153, 0.08);
            color: #ec4899;
            border-radius: 14px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .social-link::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #ec4899, #f43f5e);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .social-link:hover::before {
            opacity: 1;
        }

        .social-link:hover {
            color: white;
            transform: translateY(-3px);
            box-shadow: 
                0 10px 30px rgba(236, 72, 153, 0.3),
                0 4px 15px rgba(236, 72, 153, 0.2);
        }

        .social-link svg {
            position: relative;
            z-index: 2;
            transition: transform 0.3s ease;
        }

        .social-link:hover svg {
            transform: scale(1.1);
        }

        /* Enhanced Footer Links */
        .footer-links {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 3rem;
        }

        .footer-column {
            opacity: 0;
            transform: translateY(20px);
            animation: slideInUp 0.6s ease-out forwards;
        }

        .footer-column:nth-child(1) { animation-delay: 0.1s; }
        .footer-column:nth-child(2) { animation-delay: 0.2s; }
        .footer-column:nth-child(3) { animation-delay: 0.3s; }

        .footer-column-title {
            font-size: 1.125rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 2rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .footer-column-title::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(135deg, #ec4899, #f43f5e);
            border-radius: 2px;
        }

        .footer-link-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-link-list li {
            margin-bottom: 1rem;
        }

        .footer-link {
            color: #64748b;
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            display: block;
            padding: 0.5rem 0;
            position: relative;
            font-weight: 500;
        }

        .footer-link::before {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(135deg, #ec4899, #f43f5e);
            transition: width 0.3s ease;
        }

        .footer-link:hover::before {
            width: 100%;
        }

        .footer-link:hover {
            color: #ec4899;
            transform: translateX(8px);
        }

        /* Enhanced Footer Bottom */
        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid rgba(236, 72, 153, 0.1);
            position: relative;
        }

        .footer-bottom::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(236, 72, 153, 0.2), transparent);
        }

        .footer-copyright p {
            color: #94a3b8;
            font-size: 0.9rem;
            margin: 0;
            font-weight: 500;
        }

        .footer-legal {
            display: flex;
            gap: 2.5rem;
        }

        .legal-link {
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
        }

        .legal-link::after {
            content: "";
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 0;
            height: 1px;
            background: #ec4899;
            transition: width 0.3s ease;
        }

        .legal-link:hover::after {
            width: 100%;
        }

        .legal-link:hover {
            color: #ec4899;
        }

        /* Container */
        .container {
            max-width: 1250px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Animations */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .footer-content {
                grid-template-columns: 1fr;
                gap: 4rem;
            }

            .footer-links {
                grid-template-columns: repeat(2, 1fr);
                gap: 2.5rem;
            }

            .cta-title {
                font-size: 2.5rem;
            }

            .cta-subtitle {
                font-size: 1.125rem;
            }
        }

        @media (max-width: 768px) {
            .footer-cta-section {
                padding: 4rem 0;
                margin-top: 3rem;
                border-radius: 24px 24px 0 0;
            }

            .cta-title {
                font-size: 2rem;
            }

            .cta-subtitle {
                font-size: 1rem;
            }

            .cta-button {
                padding: 1rem 2rem;
                font-size: 1rem;
            }

            .footer-links {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .footer-bottom {
                flex-direction: column;
                gap: 1.5rem;
                text-align: center;
            }

            .footer-legal {
                gap: 2rem;
            }
        }

        @media (max-width: 480px) {
            .footer-cta-section {
                padding: 3rem 0;
                border-radius: 20px 20px 0 0;
            }

            .cta-title {
                font-size: 1.75rem;
            }

            .cta-button {
                padding: 1rem 1.5rem;
                font-size: 0.95rem;
            }

            .main-footer {
                padding: 3rem 0 1.5rem;
            }

            .footer-brand {
                text-align: center;
            }

            .footer-social {
                justify-content: center;
            }

            .footer-legal {
                flex-direction: column;
                gap: 1rem;
            }

            .container {
                padding: 0 1rem;
            }
        }
    </style>
</head>
<body>

    <!-- Enhanced Main Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <!-- Brand Section -->
                <div class="footer-brand">
                    <div class="footer-logo">
                        <div class="logo-icon">L</div>
                        <span class="logo-text">LipLab</span>
                    </div>
                    <p class="footer-description">
                        LipLab empowers beauty enthusiasts to discover their perfect lip shades through powered analysis — making beauty insights easier to find, understand, and act on.
                    </p>
                    <div class="footer-social">
                        <a href="#" class="social-link" aria-label="Twitter">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="Instagram">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="LinkedIn">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="GitHub">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Footer Links -->
                <div class="footer-links">
                    <!-- Product Column -->
                    <div class="footer-column">
                        <h4 class="footer-column-title">Features</h4>
                        <ul class="footer-link-list">
                            <li><a href="#" class="footer-link">Shade Finder</a></li>
                            <li><a href="#" class="footer-link">Dupe Finder</a></li>
                            <li><a href="#" class="footer-link">Virtual Try-On</a></li>
                            <li><a href="#" class="footer-link">Color Analysis</a></li>
                            <li><a href="#" class="footer-link">Beauty Quiz</a></li>
                        </ul>
                    </div>

                    <!-- Resources Column -->
                    <div class="footer-column">
                        <h4 class="footer-column-title">Resources</h4>
                        <ul class="footer-link-list">
                            <li><a href="#" class="footer-link">Beauty Guide</a></li>
                            <li><a href="#" class="footer-link">Tutorials</a></li>
                            <li><a href="#" class="footer-link">Blog</a></li>
                            <li><a href="#" class="footer-link">Help Center</a></li>
                            <li><a href="#" class="footer-link">API Docs</a></li>
                        </ul>
                    </div>

                    <div class="footer-column">
                        <h4 class="footer-column-title">About Us</h4>
                        <ul class="footer-link-list">
                            <li><a href="#" class="footer-link">Careers</a></li>
                            <li><a href="#" class="footer-link">Contact</a></li>
                            <li><a href="#" class="footer-link">Partners</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="footer-copyright">
                    <p>&copy; 2025 LipLab. All rights reserved.</p>
                </div>
                <div class="footer-legal">
                    <a href="#" class="legal-link">Privacy Policy</a>
                    <a href="#" class="legal-link">Terms of Service</a>
                    <a href="#" class="legal-link">Cookie Settings</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>