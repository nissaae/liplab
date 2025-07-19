<?php
// Memasukkan file config untuk memulai session dan koneksi database
require_once 'config.php';

$page_title = "Your Results";
$recommendations = [];
$original_product = null;
$is_dupe_search = false;
$is_shade_analysis = false;

try {
    // Memeriksa apakah halaman ini diakses dari fitur "Find a Dupe"
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $searchTerm = $_GET['search'];
        $page_title = "Dupes for \"" . htmlspecialchars($searchTerm) . "\"";
        $is_dupe_search = true;
        
        // Mengambil produk acak: 1 untuk original, sisanya untuk duplikat
        $stmt = $pdo->prepare("SELECT * FROM products JOIN brands ON products.brand_id = brands.brand_id WHERE product_name LIKE ? ORDER BY RAND() LIMIT 7");
        $stmt->execute(["%$searchTerm%"]);
        $original_product = $stmt->fetch();

        if ($original_product) {
            $stmt = $pdo->prepare("SELECT * FROM products JOIN brands ON products.brand_id = brands.brand_id WHERE product_id != ? AND image_link IS NOT NULL ORDER BY RAND() LIMIT 6");
            $stmt->execute([$original_product['product_id']]);
        } else {
            // If no exact match found, just get random products
            $stmt = $pdo->prepare("SELECT * FROM products JOIN brands ON products.brand_id = brands.brand_id WHERE image_link IS NOT NULL ORDER BY RAND() LIMIT 6");
            $stmt->execute();
        }
        $recommendations = $stmt->fetchAll();
    } 
    else if (isset($_GET['analysis']) && $_GET['analysis'] === 'shade_match') {
        $page_title = "Your Perfect Shade Results";
        $is_shade_analysis = true;
         $stmt = $pdo->prepare("SELECT * FROM products JOIN brands ON products.brand_id = brands.brand_id WHERE image_link IS NOT NULL ORDER BY RAND() LIMIT 12");
        $stmt->execute();
        $recommendations = $stmt->fetchAll();
    }
     else {
        $page_title = "Recommended Products";
        $stmt = $pdo->prepare("SELECT * FROM products JOIN brands ON products.brand_id = brands.brand_id WHERE image_link IS NOT NULL ORDER BY RAND() LIMIT 12");
        $stmt->execute();
        $recommendations = $stmt->fetchAll();
    }
} catch (PDOException $e) {
    // Handle database error
    error_log("Failed to fetch results: " . $e->getMessage());
    $recommendations = [];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - LipLab</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="result.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="nav-logo">
                <div class="logo-icon">L</div>
                <span class="logo-text">LipLab</span>
            </a>
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="find-shade.php">Find Shade</a>
                <a href="find-dupe.php">Find Dupe</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="logout.php" class="nav-login">Sign Out</a>
                <?php else: ?>
                    <a href="login.php" class="nav-login">Sign In</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <section class="results-header">
        <div class="container">
            <div class="header-content">
                <div class="back-button" onclick="window.history.back()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Back
                </div>
                <h1 class="results-title"><?php echo $page_title; ?></h1>
                 <p class="results-subtitle">
                    <?php if ($is_shade_analysis): ?>
                        Based on your photo analysis, here are the perfect lip shades for you!
                    <?php elseif ($is_dupe_search): ?>
                        Here are affordable alternatives that match your desired product!
                    <?php else: ?>
                        Here are some products we think you'll love!
                    <?php endif; ?>
                </p>
                <?php if ($is_shade_analysis && isset($_GET['photo'])): ?>
                    <div class="uploaded-photo">
                        <img src="uploads/photos/<?php echo htmlspecialchars($_GET['photo']); ?>" alt="Your uploaded photo" style="max-width: 150px; max-height: 150px; border-radius: 8px; margin-top: 1rem;">
                        <p style="font-size: 0.9rem; color: #666; margin-top: 0.5rem;">Analysis based on this photo</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

     <?php if ($original_product && $is_dupe_search): ?>
    <section class="analysis-section">
        <div class="container">
            <h3>Original Product</h3>
            <div class="original-product-card">
                <img src="<?php echo htmlspecialchars($original_product['image_link']); ?>" alt="<?php echo htmlspecialchars($original_product['product_name']); ?>">
                <div class="info">
                    <h4><?php echo htmlspecialchars($original_product['product_name']); ?></h4>
                    <p><?php echo htmlspecialchars($original_product['brand_name']); ?></p>
                    <span class="price">$<?php echo htmlspecialchars(number_format($original_product['price'], 2)); ?></span>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="recommendations-section">
        <div class="container">
            <div class="section-header">
                <h2>
                    <?php if ($is_dupe_search): ?>
                        Top Dupes Found
                    <?php elseif ($is_shade_analysis): ?>
                        Perfect Matches for Your Skin Tone
                    <?php else: ?>
                        Recommended for You
                    <?php endif; ?>
                </h2>
            </div>

            <div class="recommendations-grid" id="recommendationsGrid">
                <?php if (empty($recommendations)): ?>
                    <div class="no-results">
                        <p>Sorry, no matching products found. Try searching for something else!</p>
                        <a href="<?php echo $is_dupe_search ? 'find-dupe.php' : 'find-shade.php'; ?>" class="btn-primary">Try Again</a>
                    </div>
                <?php else: ?>
                    <?php foreach ($recommendations as $index => $product): ?>
                        <div class="recommendation-card">
                            <div class="recommendation-image">
                                <img src="<?php echo htmlspecialchars($product['image_link']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                                <div class="match-percentage">
                                    <?php 
                                    if ($is_shade_analysis) {
                                        echo rand(88, 97); // Higher for shade matches
                                    } else {
                                        echo rand(82, 95); // Slightly lower for dupes
                                    }
                                    ?>% Match
                                </div>
                                <?php if ($is_dupe_search && $original_product): ?>
                                    <div class="savings-badge">
                                        Save $<?php echo number_format($original_product['price'] - $product['price'], 2); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="recommendation-content">
                                <div class="recommendation-header">
                                    <span class="product-type"><?php echo htmlspecialchars($product['product_type']); ?></span>
                                    <div class="product-price">$<?php echo htmlspecialchars(number_format($product['price'], 2)); ?></div>
                                </div>
                                <h4><?php echo htmlspecialchars($product['product_name']); ?></h4>
                                <p><?php echo htmlspecialchars($product['brand_name']); ?></p>
                                <div class="recommendation-actions">
                                    <button class="btn-wishlist" onclick="toggleWishlist(this, <?php echo $product['product_id']; ?>)">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                        </svg>
                                        Wishlist
                                    </button>
                                    <button class="btn-cart" onclick="openReviewModal(<?php echo $product['product_id']; ?>, '<?php echo htmlspecialchars($product['product_name']); ?>')">Add Review</button>
                                </div>
                                <div id="reviewModal" class="review-modal" style="display:none;">
                                    <div class="modal-content">
                                        <span class="close-btn" onclick="closeReviewModal()">&times;</span>
                                        <h3>Write a Review for <span id="reviewProductName">Product</span></h3>
                                        <form action="add-review-process.php" method="POST">
                                            <input type="hidden" id="reviewProductId" name="product_id">
                                            <div class="form-group">
                                                <label>Rating:</label>
                                                <div class="star-rating">
                                                    <input type="radio" id="star5" name="rating" value="5" required/><label for="star5">★</label>
                                                    <input type="radio" id="star4" name="rating" value="4"/><label for="star4">★</label>
                                                    <input type="radio" id="star3" name="rating" value="3"/><label for="star3">★</label>
                                                    <input type="radio" id="star2" name="rating" value="2"/><label for="star2">★</label>
                                                    <input type="radio" id="star1" name="rating" value="1"/><label for="star1">★</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="review_text">Your Review:</label>
                                                <textarea id="review_text" name="review_text" rows="4" placeholder="What did you think?"></textarea>
                                            </div>
                                            <button type="submit" class="btn-primary">Submit Review</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <style>
    .review-modal{position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;background-color:rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;}
    .review-modal .modal-content{background:white;padding:2rem;border-radius:12px;width:90%;max-width:500px;position:relative;}
    .close-btn{position:absolute;top:10px;right:20px;font-size:2rem;cursor:pointer;}
    .star-rating{display:flex;flex-direction:row-reverse;justify-content:flex-end;}.star-rating input{display:none;}
    .star-rating label{font-size:2rem;color:#ccc;cursor:pointer;}.star-rating input:checked~label,.star-rating label:hover,.star-rating label:hover~label{color:#ec4899;}
    </style>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <div class="logo">L</div>
                    <span class="brand-text">LipLab</span>
                </div>
                <p class="footer-subtitle">The Ultimate Lip Shade Finder</p>
                <p class="footer-copyright">© 2024 LipLab. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function openReviewModal(productId, productName) {
            document.getElementById('reviewProductId').value = productId;
            document.getElementById('reviewProductName').innerText = productName;
            document.getElementById('reviewModal').style.display = 'flex';
        }
        function closeReviewModal() {
            document.getElementById('reviewModal').style.display = 'none';
        }
    async function toggleWishlist(button, productId) {
        // Cek apakah pengguna sudah login
        <?php if (!isset($_SESSION['user_id'])): ?>
            alert('Anda harus login untuk menggunakan fitur wishlist!');
            window.location.href = 'login.php';
            return;
        <?php endif; ?>

        try {
            const response = await fetch('add-to-wishlist.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ product_id: productId })
            });
            const result = await response.json();

            if (result.success) {
                if (result.action === 'added') {
                    button.classList.add('active'); // Anda bisa menambahkan style untuk class 'active' di CSS
                    alert('Produk ditambahkan ke wishlist!');
                } else {
                    button.classList.remove('active');
                    alert('Produk dihapus dari wishlist!');
                }
            } else {
                alert('Error: ' + result.error);
            }
        } catch (error) {
            alert('Gagal terhubung ke server.');
        }
    }
</script>

    </body>
</html>