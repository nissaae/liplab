<?php
// Memasukkan file config untuk memulai session
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Your Shade - LipLab</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="find-shade.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="nav-brand">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                <div class="logo">L</div>
                <span class="brand-text">LipLab</span>
            </a>
            <div class="nav-menu">
                <a href="find-shade.php" class="nav-link">Find Shade</a>
                <a href="find-dupe.php" class="nav-link">Find Dupe</a>
                <a href="profile.php" class="nav-link">Profile</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="logout.php" class="btn-primary">Sign Out</a>
                <?php else: ?>
                    <a href="login.php" class="btn-primary">Sign In</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="main-content">
        <div class="container">
            <div class="page-header">
                <h1 class="page-title">Find Your Perfect Shade</h1>
                <p class="page-subtitle">
                    Upload a photo and let our web analyze your skin tone to recommend the perfect lip shades for you
                </p>
            </div>

            <div class="content-grid">
                <div class="upload-section">
                    <div class="glass-card">
                        <div class="card-header">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                                <circle cx="12" cy="13" r="4"/>
                            </svg>
                            <h2>Upload Your Photo</h2>
                        </div>
                        
                        <form action="analyze-process.php" method="post" enctype="multipart/form-data">
                            <div class="upload-area" id="uploadArea">
                                <div class="upload-placeholder" id="uploadPlaceholder">
                                    <div class="upload-icon">
                                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                            <polyline points="7,10 12,15 17,10"/>
                                            <line x1="12" y1="15" x2="12" y2="3"/>
                                        </svg>
                                    </div>
                                    <h3>Drop your photo here or click to browse</h3>
                                    <p>Supports JPG, PNG files up to 10MB</p>
                                    <button type="button" class="btn-upload" id="browseBtn">Choose Photo</button>
                                </div>
                                
                                <div class="upload-preview" id="uploadPreview" style="display: none;">
                                    <img id="previewImage" alt="Uploaded photo">
                                    <div class="preview-actions">
                                        <button type="button" class="btn-secondary" id="changePhotoBtn">Change Photo</button>
                                    </div>
                                </div>
                            </div>
                            
                            <input type="file" name="photo" id="fileInput" accept="image/*" style="display: none;" required>
                            
                            <button type="submit" class="btn-analyze" id="analyzeBtn" style="display: none;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <span>Analyze & Find Shades</span>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="tips-section">
                    <div class="glass-card">
                        <div class="card-header">
                            <h2>Photo Tips</h2>
                        </div>
                        
                        <div class="tips-list">
                            <div class="tip-item">
                                <div class="tip-number">1</div>
                                <div class="tip-content">
                                    <h4>Good Lighting</h4>
                                    <p>Use natural daylight for the most accurate skin tone analysis</p>
                                </div>
                            </div>
                            
                            <div class="tip-item">
                                <div class="tip-number">2</div>
                                <div class="tip-content">
                                    <h4>Clear Face Shot</h4>
                                    <p>Make sure your face is clearly visible and well-lit</p>
                                </div>
                            </div>
                            
                            <div class="tip-item">
                                <div class="tip-number">3</div>
                                <div class="tip-content">
                                    <h4>No Makeup</h4>
                                    <p>For best results, use a photo without makeup or filters</p>
                                </div>
                            </div>
                            
                            <div class="tip-item">
                                <div class="tip-number">4</div>
                                <div class="tip-content">
                                    <h4>Neutral Background</h4>
                                    <p>A plain background helps our AI focus on your skin tone</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="analysis-modal" id="analysisModal">
        </div>

   <?php include 'footer-section.php'; ?>
   <script src="find-shade.js"></script>
</body>
</html>