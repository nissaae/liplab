<?php
// Memasukkan file config untuk memulai session
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find a Dupe - LipLab</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="find-dupe.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="nav-brand">
                <div class="logo">L</div>
                <span class="brand-text">LipLab</span>
            </a>
            <div class="nav-menu">
                <a href="find-shade.php" class="nav-link">Find Shade</a>
                <a href="find-dupe.php" class="nav-link active">Find Dupe</a>
                <a href="profile.php" class="nav-link">Profile</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="logout.php" class="btn-primary">Sign Out</a>
                <?php else: ?>
                    <a href="login.php" class="btn-primary" id="authButton">Sign In</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Find Perfect Dupes</h1>
                <p class="hero-subtitle">Discover affordable alternatives to your favorite high-end lip products without compromising on quality or color</p>
                <div class="hero-features">
                    <div class="feature-item">
                        <span class="feature-icon">💰</span>
                        <span>Save up to 80%</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">🎨</span>
                        <span>Perfect Color Match</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">⭐</span>
                        <span>Quality Guaranteed</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="search-section">
        <div class="container">
            <div class="search-container">
                <div class="search-card">
                    <h2>Search for Dupes</h2>
                    <p>Enter the product name, brand, or shade you're looking for</p>
                    
                    <form class="search-form" action="find-dupe-process.php" method="GET">
                        <div class="search-input-container">
                            <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"/>
                                <path d="m21 21-4.35-4.35"/>
                            </svg>
                            <input type="text" name="q" id="searchInput" placeholder="Type here..." class="search-input" required>
                            <button type="submit" class="search-btn" id="searchBtn">
                                <span>Search Dupes</span>
                            </button>
                        </div>
                        
                        <div class="search-filters">
                            <div class="filter-group">
                                <label for="priceRange">Max Price</label>
                                <select id="priceRange">
                                    <option value="">Any Price</option>
                                    <option value="0-10">Under $10</option>
                                    <option value="10-20">$10 - $20</option>
                                    <option value="20-30">$20 - $30</option>
                                    <option value="30-50">$30 - $50</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label for="productType">Product Type</label>
                                <select id="productType">
                                    <option value="">All Types</option>
                                    <option value="lipstick">Lipstick</option>
                                    <option value="lip-gloss">Lip Gloss</option>
                                    <option value="lip-tint">Lip Tint</option>
                                    <option value="lip-liner">Lip Liner</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label for="finish">Finish</label>
                                <select id="finish">
                                    <option value="">Any Finish</option>
                                    <option value="matte">Matte</option>
                                    <option value="satin">Satin</option>
                                    <option value="glossy">Glossy</option>
                                    <option value="sheer">Sheer</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="popular-searches">
                    <h3>Popular Dupe Searches</h3>
                    <div class="popular-tags">
                        <button class="tag-btn" onclick="searchProduct('Charlotte Tilbury Pillow Talk')">Charlotte Tilbury Pillow Talk</button>
                        <button class="tag-btn" onclick="searchProduct('Fenty Beauty Stunna')">Fenty Beauty Stunna</button>
                        <button class="tag-btn" onclick="searchProduct('Rare Beauty Soft Pinch')">Rare Beauty Soft Pinch</button>
                        <button class="tag-btn" onclick="searchProduct('Dior Addict Lip Glow')">Dior Addict Lip Glow</button>
                        <button class="tag-btn" onclick="searchProduct('MAC Ruby Woo')">MAC Ruby Woo</button>
                        <button class="tag-btn" onclick="searchProduct('YSL Rouge Volupte')">YSL Rouge Volupte</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="loading-modal" id="loadingModal">
         </div>

   <?php include 'footer-section.php'; ?>

    <script src="find-dupe.js"></script>
</body>
</html>