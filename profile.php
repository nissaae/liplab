<?php
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?status=must_login");
    exit();
}

$userId = $_SESSION['user_id'];

// Handle notification messages
$notification_message = '';
$notification_type = '';

if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'update_success':
            $notification_message = 'Profile updated successfully!';
            $notification_type = 'success';
            break;
        case 'update_failed':
        case 'db_error':
            $notification_message = 'Failed to update profile. Please try again.';
            $notification_type = 'error';
            break;
    }
}

// Get user data
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();
    
    if (!$user) {
        session_destroy();
        header("Location: login.php");
        exit();
    }
} catch (PDOException $e) {
    die("Could not fetch user data: " . $e->getMessage());
}

// Get user's reviews
try {
    $reviewSql = "SELECT r.rating, r.review_text, r.created_at, p.product_name, p.image_link, b.brand_name 
                  FROM reviews r
                  JOIN products p ON r.product_id = p.product_id
                  JOIN brands b ON p.brand_id = b.brand_id
                  WHERE r.user_id = ? ORDER BY r.created_at DESC";
    $stmt = $pdo->prepare($reviewSql);
    $stmt->execute([$userId]);
    $reviewItems = $stmt->fetchAll();
} catch (PDOException $e) {
    $reviewItems = [];
    error_log("Failed to fetch reviews: " . $e->getMessage());
}

// Get user's wishlist
try {
    $stmt_wishlist = $pdo->prepare("
        SELECT 
            p.product_id, 
            p.product_name, 
            p.image_link,
            p.product_type, -- Added product_type
            p.price,        -- Added price
            b.brand_name
        FROM 
            user_favorites w
        JOIN 
            products p ON w.product_id = p.product_id
        JOIN 
            brands b ON p.brand_id = b.brand_id
        WHERE 
            w.user_id = :user_id
    ");
    $stmt_wishlist->execute([':user_id' => $userId]);
    $wishlistItems = $stmt_wishlist->fetchAll();
} catch (PDOException $e) {
    // Handle error
    die("Database Query Failed: " . $e->getMessage());
}

// User info
$firstName = $user['first_name'];
$lastName = $user['last_name'];
$email = $user['email'];
$joinDate = date('Y', strtotime($user['created_at']));
$undertone = $user['undertone'] ?? '';

// Handle active tab
$activeTab = $_GET['tab'] ?? 'wishlist';
$validTabs = ['wishlist', 'favorites', 'history'];
if (!in_array($activeTab, $validTabs)) {
    $activeTab = 'wishlist';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - LipLab</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="profile.css">
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
                <a href="profile.php" class="nav-link active">Profile</a>
                <a href="logout.php" class="btn-primary">Sign Out</a>
            </div>
        </div>
    </nav>

    <main class="profile-main">
        <div class="container">
            <section class="profile-header">
                <div class="profile-card">
                    <div class="profile-avatar-section">
                        <div class="avatar-container">
                            <div class="profile-avatar" id="profileAvatar">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </div>
                            <button class="avatar-upload-btn" onclick="document.getElementById('avatarInput').click();">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                                    <circle cx="12" cy="13" r="4"/>
                                </svg>
                            </button>
                        </div>
                        <input type="file" id="avatarInput" accept="image/*" style="display: none;">
                    </div>

                    <div class="profile-info">
                        <div class="profile-details" id="profileDetails">
                            <h1 class="profile-name"><?php echo htmlspecialchars($firstName . ' ' . $lastName); ?></h1>
                            <p class="profile-email"><?php echo htmlspecialchars($email); ?></p>
                            <div class="profile-badges">
                                <?php if ($undertone): ?>
                                    <span class="badge"><?php echo htmlspecialchars(ucwords(str_replace('-', ' ', $undertone))); ?> Skin</span>
                                <?php endif; ?>
                                <span class="badge">Member since <?php echo $joinDate; ?></span>
                            </div>
                        </div>

                        <div class="profile-edit" id="profileEdit" style="display: none;">
                            <form class="edit-form" action="edit-profile-process.php" method="POST">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="editFirstName">First Name</label>
                                        <input type="text" id="editFirstName" name="editFirstName" value="<?php echo htmlspecialchars($firstName); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="editLastName">Last Name</label>
                                        <input type="text" id="editLastName" name="editLastName" value="<?php echo htmlspecialchars($lastName); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="editEmail">Email</label>
                                    <input type="email" id="editEmail" name="editEmail" value="<?php echo htmlspecialchars($email); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="editSkinTone">Skin Tone</label>
                                    <select id="editSkinTone" name="editSkinTone">
                                        <option value="">Select skin tone</option>
                                        <?php
                                        $tones = [
                                            "fair-cool" => "Fair Cool",
                                            "fair-warm" => "Fair Warm", 
                                            "light-cool" => "Light Cool",
                                            "light-warm" => "Light Warm",
                                            "medium-cool" => "Medium Cool",
                                            "medium-warm" => "Medium Warm",
                                            "deep-cool" => "Deep Cool",
                                            "deep-warm" => "Deep Warm"
                                        ];
                                        foreach ($tones as $value => $label) {
                                            $selected = ($undertone == $value) ? 'selected' : '';
                                            echo "<option value=\"$value\" $selected>$label</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="profile-actions">
                                    <button type="submit" class="btn-save">Save Changes</button>
                                    <button type="button" class="btn-cancel" onclick="toggleEdit()">Cancel</button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="profile-actions" id="initialActions">
                            <button class="btn-edit" id="editBtn" onclick="toggleEdit()">Edit Profile</button>
                        </div>
                    </div>
                </div>
            </section>

            <section class="profile-tabs">
                <div class="tabs-header">
                    <button class="tab-button <?php echo $activeTab == 'wishlist' ? 'active' : ''; ?>" onclick="switchTab('wishlist')">
                        Wishlist <span class="tab-count"><?php echo count($wishlistItems); ?></span>
                    </button>
                    <button class="tab-button <?php echo $activeTab == 'favorites' ? 'active' : ''; ?>" onclick="switchTab('favorites')">
                        My Reviews <span class="tab-count"><?php echo count($reviewItems); ?></span>
                    </button>
                    <button class="tab-button <?php echo $activeTab == 'history' ? 'active' : ''; ?>" onclick="switchTab('history')">
                        Recent Activity
                    </button>
                </div>

                <div class="tabs-content">
                    <div class="tab-content <?php echo $activeTab == 'wishlist' ? 'active' : ''; ?>" id="wishlist">
                        <div class="content-header">
                            <h2>My Wishlist</h2>
                            <p>Products you've saved for later</p>
                        </div>
                        <div class="products-grid" id="wishlistGrid">
                            <?php if (empty($wishlistItems)): ?>
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                        </svg>
                                    </div>
                                    <h3>Your wishlist is empty</h3>
                                    <p>Start adding products you love to see them here</p>
                                    <button class="empty-state-btn" onclick="window.location.href='index.php'">
                                        Browse Products
                                    </button>
                                </div>
                            <?php else: ?>
                                <?php foreach ($wishlistItems as $item): ?>
                                    <div class="product-card" data-product-id="<?php echo $item['product_id']; ?>">
                                        <div class="card-image">
                                            <img src="<?php echo htmlspecialchars($item['image_link']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" loading="lazy">
                                             <button class="heart-btn" onclick="removeFromWishlist(<?php echo $item['product_id']; ?>)">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2">
                                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="wishlist-item-content">
                                            <div class="wishlist-item-header">
                                                <span class="product-type-badge"><?php echo htmlspecialchars($item['product_type']); ?></span>
                                                <div class="product-price">$<?php echo htmlspecialchars(number_format($item['price'], 2)); ?></div>
                                            </div>
                                            <h3><?php echo htmlspecialchars($item['product_name']); ?></h3>
                                            <p class="card-subtitle"><?php echo htmlspecialchars($item['brand_name']); ?></p>
                                            <div class="recommendation-actions">
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="tab-content <?php echo $activeTab == 'favorites' ? 'active' : ''; ?>" id="favorites">
                        <div class="content-header">
                            <h2>My Reviews</h2>
                            <p>Products you've tried and reviewed</p>
                        </div>
                        <div class="reviews-list" id="reviewsList">
                            <?php if (empty($reviewItems)): ?>
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                                        </svg>
                                    </div>
                                    <h3>No reviews yet</h3>
                                    <p>Try some products and share your experience with others</p>
                                    <button class="empty-state-btn" onclick="window.location.href='index.php'">
                                        Explore Products
                                    </button>
                                </div>
                            <?php else: ?>
                                <?php foreach ($reviewItems as $review): ?>
                                    <div class="review-item">
                                        <div class="review-header">
                                            <div class="review-product-image">
                                                <img src="<?php echo htmlspecialchars($review['image_link']); ?>" alt="<?php echo htmlspecialchars($review['product_name']); ?>" loading="lazy">
                                            </div>
                                            <div class="review-info">
                                                <h4 class="review-product-name"><?php echo htmlspecialchars($review['product_name']); ?></h4>
                                                <p class="review-product-brand"><?php echo htmlspecialchars($review['brand_name']); ?></p>
                                                <div class="review-rating">
                                                    <div class="user-rating">
                                                        <?php for ($i = 0; $i < 5; $i++): ?>
                                                            <span class="star <?php echo $i < $review['rating'] ? '' : 'empty'; ?>">★</span>
                                                        <?php endfor; ?>
                                                    </div>
                                                    <span class="review-date"><?php echo date('F j, Y', strtotime($review['created_at'])); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="review-text">"<?php echo htmlspecialchars($review['review_text']); ?>"</div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="tab-content <?php echo $activeTab == 'history' ? 'active' : ''; ?>" id="history">
                        <div class="content-header">
                            <h2>Recent Activity</h2>
                            <p>Your recent searches and interactions</p>
                        </div>
                        <div class="activity-list" id="activityList">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12,6 12,12 16,14"/>
                                    </svg>
                                </div>
                                <h3>No recent activity</h3>
                                <p>Your recent searches and interactions will appear here</p>
                                <button class="empty-state-btn" onclick="window.location.href='index.php'">
                                    Start Exploring
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

   <?php include 'footer-section.php'; ?>

    <script>
        let isEditing = false;

        function toggleEdit() {
            isEditing = !isEditing;
            
            const profileDetails = document.getElementById('profileDetails');
            const profileEdit = document.getElementById('profileEdit');
            const editBtn = document.getElementById('editBtn');
            const initialActions = document.getElementById('initialActions');
            
            if (isEditing) {
                profileDetails.style.display = 'none';
                profileEdit.style.display = 'block';
                initialActions.style.display = 'none';
            } else {
                profileDetails.style.display = 'block';
                profileEdit.style.display = 'none';
                initialActions.style.display = 'block';
            }
        }

        function switchTab(tabName) {
            const url = new URL(window.location);
            url.searchParams.set('tab', tabName);
            window.history.pushState({}, '', url);
            
            document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
            
            document.querySelector(`[onclick="switchTab('${tabName}')"]`).classList.add('active');
            document.getElementById(tabName).classList.add('active');
        }

 async function removeFromWishlist(productId) {
        // Find the parent product card to remove it from the page later
        const productCard = document.querySelector(`[data-product-id="${productId}"]`);

        try {
            const response = await fetch('remove-wishlist.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ product_id: productId })
            });

            const result = await response.json();

            if (result.success) {
                if (productCard) {
                // Animation to fade out the card before removing
                productCard.style.transition = 'opacity 0.5s ease';
                productCard.style.opacity = '0';
                
                // Wait for the animation to finish, then remove the element
                setTimeout(() => {
                    productCard.remove();
                    const grid = document.getElementById('wishlistGrid');
                    if (grid.children.length === 0) {
                        grid.innerHTML = `
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                    </svg>
                                </div>
                                <h3>Your wishlist is empty</h3>
                                <p>Start adding products you love to see them here</p>
                                <button class="empty-state-btn" onclick="window.location.href='index.php'">
                                    Browse Products
                                </button>
                            </div>
                        `;
                    }
                    const tabButton = document.querySelector('.tab-button[onclick="switchTab(\'wishlist\')"]');
                    if (tabButton) {
                        const countSpan = tabButton.querySelector('.tab-count');
                        if (countSpan) {
                            const currentCount = parseInt(countSpan.textContent) - 1;
                            countSpan.textContent = Math.max(0, currentCount);
                        }
                    }
                }, 500);
                showNotification('Product removed from wishlist!', 'success');
                }
            } else {
                showNotification('Error: ' + result.error, 'error');
            }
        } catch (error) {
            showNotification('Failed to connect to the server. Please try again.', 'error');
            console.error('Fetch error:', error);
        }
    }

        function addToCart(productId) {
            showNotification('Added to cart!', 'success');
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.style.cssText = `
                position: fixed; top: 2rem; right: 2rem;
                background: ${type === 'error' ? 'linear-gradient(135deg, #ef4444, #dc2626)' : 
                            type === 'success' ? 'linear-gradient(135deg, #10b981, #059669)' : 
                            'linear-gradient(135deg, #3b82f6, #1d4ed8)'};
                color: white; padding: 1rem 1.5rem; border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); z-index: 10001;
                transform: translateX(120%); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                font-weight: 600;
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

        document.getElementById('avatarInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 5 * 1024 * 1024) {
                    showNotification('Image size must be less than 5MB', 'error');
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    const avatar = document.getElementById('profileAvatar');
                    avatar.innerHTML = `<img src="${e.target.result}" alt="Profile Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">`;
                    showNotification('Profile picture updated!', 'success');
                };
                reader.readAsDataURL(file);
            }
        });

        <?php if ($notification_message): ?>
            showNotification('<?php echo $notification_message; ?>', '<?php echo $notification_type; ?>');
        <?php endif; ?>

        async function loadWishlist() {
            try {
                const response = await fetch('get-wishlist.php');
                const result = await response.json();
                
                if (result.success) {
                    displayWishlist(result.data);
                } else {
                    console.error('Error loading wishlist:', result.error);
                }
            } catch (error) {
                console.error('Failed to load wishlist:', error);
            }
        }

        function displayWishlist(items) {
            const wishlistGrid = document.getElementById('wishlistGrid');
            
            if (items.length === 0) {
                wishlistGrid.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </div>
                        <h3>Your wishlist is empty</h3>
                        <p>Start adding products you love to see them here</p>
                        <button class="empty-state-btn" onclick="window.location.href='index.php'">
                            Browse Products
                        </button>
                    </div>
                `;
                return;
            }
            
            let html = '';
            items.forEach(item => {
                html += `
                    <div class="product-card" data-product-id="${item.product_id}">
                        <div class="card-image">
                            <img src="${item.image_link}" alt="${item.product_name}" loading="lazy">
                            <button class="remove-wishlist" onclick="removeFromWishlist(${item.product_id})">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                </svg>
                            </button>
                        </div>
                        <div class="wishlist-item-content">
                            <div class="wishlist-item-header">
                                <span class="product-type-badge">${item.product_type}</span>
                                <div class="product-price">$${parseFloat(item.price).toFixed(2)}</div>
                            </div>
                            <h3>${item.product_name}</h3>
                            <p>${item.brand_name || ''}</p>
                        </div>
                    </div>
                `;
            });
            
            wishlistGrid.innerHTML = html;
        }

        // Load wishlist saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('wishlistGrid')) {
                loadWishlist();
            }
        });
    </script>
</body>
</html>