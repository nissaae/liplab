// Profile Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initializeProfilePage();
});

async function initializeProfilePage() {
    // Check if the user is logged in
    const storedUser = JSON.parse(localStorage.getItem('liplab_user'));
    if (!storedUser || !storedUser.userId) {
        sessionStorage.setItem('login_redirect_message', 'Oops! You need to log in to see your profile.');
        window.location.href = 'login.php';
        return;
    }

    try {
        // Fetch the user's full profile data from the server
        const response = await fetch(`/api/users/profile/${storedUser.userId}`);
        const result = await response.json();

        if (response.ok) {
            // If data is fetched successfully, load it into the page
            loadProfileData(result.data);
        } else {
            // If the user isn't found in the DB, log them out
            showNotification(result.error, 'error');
            logout(); // a function to clear localStorage and redirect
            return;
        }

    } catch (error) {
        console.error('Failed to fetch profile:', error);
        showNotification('Could not connect to the server.', 'error');
        return; // Stop execution if we can't load the profile
    }
    
    // The rest of your page initializations can run now
    setupTabNavigation();
    loadWishlist();
    loadReviews();
    loadActivity();
    updateTabCounts();
}

function setupTabNavigation() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetTab = button.dataset.tab;
            
            // Remove active class from all tabs and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked tab and corresponding content
            button.classList.add('active');
            document.getElementById(targetTab).classList.add('active');
        });
    });
}

function loadProfileData(user) {
    document.querySelector('.profile-name').textContent = `${user.firstName} ${user.lastName}`;
    document.querySelector('.profile-email').textContent = user.email;

    // Update form fields for the edit mode
    document.getElementById('editFirstName').value = user.firstName;
    document.getElementById('editLastName').value = user.lastName;
    document.getElementById('editEmail').value = user.email;
    document.getElementById('editSkinTone').value = user.skinTone;
    // document.getElementById('editPreference').value = user.preference; // Add this if you have it in your DB

    // Update badges
    const skinToneText = user.skinTone.replace('-', ' ').replace(/\b\w/g, l => l.toUpperCase());
    const badges = document.querySelector('.profile-badges');
    badges.innerHTML = `
        <span class="badge">${skinToneText}</span>
        <span class="badge">Member since ${user.joinDate}</span>
    `;
}

function loadWishlist() {
    const wishlistGrid = document.getElementById('wishlistGrid');
    
    if (wishlistData.length === 0) {
        wishlistGrid.innerHTML = createEmptyState(
            'heart',
            'Your wishlist is empty',
            'Start adding products you love to see them here',
            'Browse Products'
        );
        return;
    }
    
    wishlistGrid.innerHTML = wishlistData.map((item, index) => `
        <div class="wishlist-item" style="animation-delay: ${index * 0.1}s">
            <div class="wishlist-item-image">
                <img src="${item.image}" alt="${item.name}" loading="lazy">
                <button class="remove-wishlist" onclick="removeFromWishlist(${item.id})">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                </button>
            </div>
            <div class="wishlist-item-content">
                <div class="wishlist-item-header">
                    <span class="product-type-badge">${item.type}</span>
                    <div class="product-price">
                        ${item.originalPrice > item.price ? `<span style="text-decoration: line-through; color: #9ca3af; font-size: 0.9rem;">$${item.originalPrice}</span>` : ''}
                        $${item.price}
                    </div>
                </div>
                <h3>${item.name}</h3>
                <p>${item.brand} • ${item.shade}</p>
                <div class="product-rating">
                    <span class="rating-stars">★</span>
                    <span>${item.rating} (${item.reviews.toLocaleString()})</span>
                </div>
                <button class="add-to-cart-btn" onclick="addToCart(${item.id})">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"/>
                        <circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    Add to Cart
                </button>
            </div>
        </div>
    `).join('');
}

function loadReviews() {
    const reviewsList = document.getElementById('reviewsList');
    
    if (reviewsData.length === 0) {
        reviewsList.innerHTML = createEmptyState(
            'star',
            'No reviews yet',
            'Try some products and share your experience with others',
            'Explore Products'
        );
        return;
    }
    
    reviewsList.innerHTML = reviewsData.map((review, index) => `
        <div class="review-item" style="animation-delay: ${index * 0.1}s">
            <div class="review-header">
                <div class="review-product-image">
                    <img src="${review.image}" alt="${review.productName}" loading="lazy">
                </div>
                <div class="review-info">
                    <h4 class="review-product-name">${review.productName}</h4>
                    <p class="review-product-brand">${review.brand} • ${review.shade}</p>
                    <div class="review-rating">
                        <div class="user-rating">
                            ${Array.from({length: 5}, (_, i) => 
                                `<span class="star ${i < review.rating ? '' : 'empty'}">★</span>`
                            ).join('')}
                        </div>
                        <span class="review-date">${formatDate(review.date)}</span>
                    </div>
                </div>
            </div>
            <div class="review-text">"${review.review}"</div>
        </div>
    `).join('');
}

function loadActivity() {
    const activityList = document.getElementById('activityList');
    
    if (activityData.length === 0) {
        activityList.innerHTML = createEmptyState(
            'clock',
            'No recent activity',
            'Your recent searches and interactions will appear here',
            'Start Exploring'
        );
        return;
    }
    
    activityList.innerHTML = activityData.map((activity, index) => `
        <div class="activity-item" style="animation-delay: ${index * 0.1}s">
            <div class="activity-icon">
                ${getActivityIcon(activity.icon)}
            </div>
            <div class="activity-content">
                <div class="activity-title">${activity.title}</div>
                <div class="activity-description">${activity.description}</div>
                <div class="activity-time">${activity.time}</div>
            </div>
        </div>
    `).join('');
}

function createEmptyState(icon, title, description, buttonText) {
    return `
        <div class="empty-state">
            <div class="empty-state-icon">
                ${getActivityIcon(icon)}
            </div>
            <h3>${title}</h3>
            <p>${description}</p>
            <button class="empty-state-btn" onclick="window.location.href='index.php'">
                ${buttonText}
            </button>
        </div>
    `;
}

function getActivityIcon(iconType) {
    const icons = {
        search: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>',
        heart: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>',
        star: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>',
        camera: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>',
        clock: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>'
    };
    return icons[iconType] || icons.search;
}

function updateTabCounts() {
    document.getElementById('wishlistCount').textContent = wishlistData.length;
    document.getElementById('favoritesCount').textContent = reviewsData.length;
}

function toggleEdit() {
    isEditing = !isEditing;
    
    const profileDetails = document.getElementById('profileDetails');
    const profileEdit = document.getElementById('profileEdit');
    const editBtn = document.getElementById('editBtn');
    const saveBtn = document.getElementById('saveBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    
    if (isEditing) {
        profileDetails.style.display = 'none';
        profileEdit.style.display = 'block';
        editBtn.style.display = 'none';
        saveBtn.style.display = 'flex';
        cancelBtn.style.display = 'flex';
    } else {
        profileDetails.style.display = 'block';
        profileEdit.style.display = 'none';
        editBtn.style.display = 'flex';
        saveBtn.style.display = 'none';
        cancelBtn.style.display = 'none';
    }
}

function saveProfile() {
    // Get form values
    const firstName = document.getElementById('editFirstName').value.trim();
    const lastName = document.getElementById('editLastName').value.trim();
    const email = document.getElementById('editEmail').value.trim();
    const skinTone = document.getElementById('editSkinTone').value;
    const preference = document.getElementById('editPreference').value;
    
    // Validate
    if (!firstName || !lastName || !email) {
        showNotification('Please fill in all required fields', 'error');
        return;
    }
    
    // Update user data
    currentUser.firstName = firstName;
    currentUser.lastName = lastName;
    currentUser.email = email;
    currentUser.skinTone = skinTone;
    currentUser.preference = preference;
    
    // Save to localStorage (in a real app, this would be an API call)
    localStorage.setItem('liplab_user', JSON.stringify(currentUser));
    
    // Update UI
    loadProfileData();
    toggleEdit();
    
    showNotification('Profile updated successfully!', 'success');
}

function cancelEdit() {
    // Reset form values
    document.getElementById('editFirstName').value = currentUser.firstName;
    document.getElementById('editLastName').value = currentUser.lastName;
    document.getElementById('editEmail').value = currentUser.email;
    document.getElementById('editSkinTone').value = currentUser.skinTone;
    document.getElementById('editPreference').value = currentUser.preference;
    
    toggleEdit();
}

function uploadAvatar() {
    document.getElementById('avatarInput').click();
}

// Handle avatar upload
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
            avatar.innerHTML = `<img src="${e.target.result}" alt="Profile Avatar">`;
            currentUser.avatar = e.target.result;
            
            showNotification('Profile picture updated!', 'success');
        };
        reader.readAsDataURL(file);
    }
});

function removeFromWishlist(productId) {
    const index = wishlistData.findIndex(item => item.id === productId);
    if (index > -1) {
        wishlistData.splice(index, 1);
        loadWishlist();
        updateTabCounts();
        showNotification('Removed from wishlist', 'info');
    }
}

function addToCart(productId) {
    const product = wishlistData.find(item => item.id === productId);
    if (product) {
        showNotification(`Added ${product.name} to cart!`, 'success');
    }
}

function logout() {
    showNotification('Signing out...', 'info');
    setTimeout(() => {
        localStorage.removeItem('liplab_user');
        window.location.href = 'index.php';
    }, 1500);
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    });
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background: ${type === 'error' ? 'linear-gradient(135deg, #ef4444, #dc2626)' : 
                    type === 'success' ? 'linear-gradient(135deg, #10b981, #059669)' : 
                    'linear-gradient(135deg, #ec4899, #f43f5e)'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        z-index: 10001;
        transform: translateX(400px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-weight: 600;
        backdrop-filter: blur(10px);
        max-width: 300px;
    `;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Animate out and remove
    setTimeout(() => {
        notification.style.transform = 'translateX(400px)';
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 4000);
}

// Load user data from localStorage on page load
window.addEventListener('load', function() {
    const savedUser = localStorage.getItem('liplab_user');
    if (savedUser) {
        currentUser = { ...currentUser, ...JSON.parse(savedUser) };
        loadProfileData();
    }
});