<?php
require_once 'config.php'; 

try {
    $stmt_products = $pdo->prepare("SELECT * FROM products JOIN brands ON products.brand_id = brands.brand_id WHERE image_link IS NOT NULL AND image_link != '' ORDER BY products.created_at DESC LIMIT 12");
    $stmt_products->execute();
    $trendingProducts = $stmt_products->fetchAll();
} catch (PDOException $e) {
    $trendingProducts = []; // Jika gagal, tampilkan array kosong
    error_log("Gagal mengambil produk tren: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LipLab - The Ultimate Lip Shade Finder</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
<?php
$videos = [
    [
        'video_url' => 'https://www.youtube.com/watch?v=EOjXoIL9xQk',
        'id' => 'EOjXoIL9xQk',
        'title' => 'FIND Your Undertone with These 5 EASY Tests at HOME',
        'channel' => 'Monica Ravichandran',
        'duration' => '14:42'
    ],
    [
        'video_url' => 'https://www.youtube.com/watch?v=HeP_YguM46s',
        'id' => 'HeP_YguM46s',
        'title' => 'How to Find Your Skin Undertone • Easy tips',
        'channel' => 'JHaley Kim',
        'duration' => '10:00'
    ],
    [
        'video_url' => 'https://www.youtube.com/watch?v=9EiWM0gyPAE',
        'id' => '9EiWM0gyPAE',
        'title' => 'GRWM: neutral undertone makeup ft. pinkflash',
        'channel' => 'Liane San Jose',
        'duration' => '06:50'
    ],
    [
        'video_url' => 'https://www.youtube.com/watch?v=uNGxVDuq2cU',
        'id' => 'uNGxVDuq2cU',
        'title' => 'I have 50+ VIRAL lip products..LETS RANK THEM',
        'channel' => 'urmomsushi',
        'duration' => '13:53'
    ],
    [
        'video_url' => 'https://www.youtube.com/watch?v=jY2Kg9ZJGE0',
        'id' => 'jY2Kg9ZJGE0',
        'title' => 'Why that LIP COLOR doesnt look good on me? How to Choose Best LIP COLOUR for My SKIN TONE',
        'channel' => 'dear peachie',
        'duration' => '12:32'
    ],
    [
        'video_url' => 'https://www.youtube.com/watch?v=PO7HE6Gz_c8',
        'id' => 'PO7HE6Gz_c8',
        'title' => '6 Lip Combos Everyone Should Know About',
        'channel' => 'raquel',
        'duration' => '18:32'
    ]
];
?>
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <div class="logo">L</div>
                <span class="brand-text">LipLab</span>
            </div>
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

    <section class="hero">
            <div class="rising-bubbles">
                <div class="bubble"></div>
                <div class="bubble"></div>
                <div class="bubble"></div>
                <div class="bubble"></div>
                <div class="bubble"></div>
                <div class="bubble"></div>
                <div class="bubble"></div>
                <div class="bubble"></div>
                <div class="bubble"></div>
                <div class="bubble"></div>
            </div>
        <div class="hero-bg">
            <div class="floating-element element-1"></div>
            <div class="floating-element element-2"></div>
            <div class="floating-element element-3"></div>
        </div>
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">
                    <span class="title-line">Find Your Perfect</span>
                    <span class="title-line">Lip Shade</span>
                </h1>
                <p class="hero-subtitle">
                    Discover personalized lip product recommendations based on your unique skin tone or find amazing dupes for your favorite products
                </p>
                <div class="cta-cards">
                    <div class="cta-card" onclick="window.location.href='find-shade.php';" style="cursor:pointer;">
                        <div class="cta-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                                <circle cx="12" cy="13" r="4"/>
                            </svg>
                        </div>
                        <h3>Find Your Shade</h3>
                        <p>Upload a photo and get personalized recommendations</p>
                    </div>
                    <div class="cta-card" onclick="window.location.href='find-dupe.php';" style="cursor:pointer;">
                        <div class="cta-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"/>
                                <path d="m21 21-4.35-4.35"/>
                            </svg>
                        </div>
                        <h3>Find a Dupe</h3>
                        <p>Discover affordable alternatives to your favorites</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="trending">
        <div class="rising-bubbles">
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
        </div>
        <div class="hero-bg">
            <div class="floating-element element-1"></div>
            <div class="floating-element element-2"></div>
            <div class="floating-element element-3"></div>
        </div>
        <div class="container">
            <div class="section-header">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="23,6 13.5,15.5 8.5,10.5 1,18"/>
                    <polyline points="17,6 23,6 23,12"/>
                </svg>
                <h2>Trending Now</h2>
            </div>
            <div class="products-grid" id="productsGrid">
                <?php foreach ($trendingProducts as $product): ?>
                    <div class="product-card">
                        <div class="card-image">
                            <img src="<?php echo htmlspecialchars($product['image_link']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                                    <button class="heart-btn" onclick="toggleWishlist(this, <?php echo $product['product_id']; ?>)" title="Add to Wishlist">
                                        <svg class="heart-icon" viewBox="0 0 24 24">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                        </svg>
                                    </button>
                        </div>
                        <div class="card-content">
                            <div class="card-header">
                                <span class="product-type"><?php echo htmlspecialchars($product['product_type']); ?></span>
                                <div class="price">$<?php echo htmlspecialchars(number_format($product['price'], 2)); ?></div>
                            </div>
                            <h3 class="card-title"><?php echo htmlspecialchars($product['product_name']); ?></h3>
                            <p class="card-subtitle"><?php echo htmlspecialchars($product['brand_name']); ?></p>
                            <div class="recommendation-actions">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <?php if (empty($trendingProducts)): ?>
                    <p>Tidak ada produk tren yang tersedia saat ini.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="videos">
        <div class="rising-bubbles">
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
        </div>
        <div class="hero-bg">
            <div class="floating-element element-1"></div>
            <div class="floating-element element-2"></div>
            <div class="floating-element element-3"></div>
        </div>
        <div class="container">
            <div class="section-header">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon points="5,3 19,12 5,21"/>
                </svg>
                <h2>Beauty Inspiration</h2>
            </div>
            <div class="videos-grid" id="videosGrid">
                <?php foreach ($videos as $video): ?>
                    <div class="video-card">
                        <a href="<?php echo htmlspecialchars($video['video_url']); ?>" target="_blank">
                            <div class="card-image">
                                <img src="https://img.youtube.com/vi/<?php echo htmlspecialchars($video['id']); ?>/hqdefault.jpg" alt="<?php echo htmlspecialchars($video['title']); ?>">
                                <div class="play-overlay">
                                    <div class="play-button">
                                        <svg width="24" height="24" viewBox="0 0 24 24">
                                            <polygon points="5,3 19,12 5,21" fill="#222"></polygon>
                                        </svg>
                                    </div>
                                 </div>
                                <div class="duration"><?php echo htmlspecialchars($video['duration']); ?></div>
                            </div>
                        </a>
                        <div class="card-content">
                            <h3 class="card-title"><?php echo htmlspecialchars($video['title']); ?></h3>
                            <p class="card-subtitle"><?php echo htmlspecialchars($video['channel']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($videos)): ?>
                    <p>Tidak ada video inspirasi yang tersedia saat ini.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
    
    <?php include 'footer-section.php'; ?>

    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
        <p>Loading amazing lip products...</p>
    </div>

    <script>
    async function toggleWishlist(button, productId) {
        <?php if (!isset($_SESSION['user_id'])): ?>
            alert('Anda harus login untuk menggunakan fitur wishlist!');
            window.location.href = 'login.php';
            return;
        <?php endif; ?>
        button.classList.toggle('active');

        try {
            const response = await fetch('/add-to-wishlist.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ product_id: productId })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const result = await response.json();

            if (result.success) {
                if (result.action === 'added') {
                    button.classList.add('active');
                    alert('Produk ditambahkan ke wishlist!');
                } else {
                    button.classList.remove('active');
                    alert('Produk dihapus dari wishlist!');
                }
            } else {
                button.classList.toggle('active');
                alert('Error: ' + result.error);
            }
        } catch (error) {
            console.error('Error details:', error); // Untuk debugging
            button.classList.toggle('active');
            alert('Gagal terhubung ke server: ' + error.message);
        }
    }
</script>

    </body>
</html>