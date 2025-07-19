// In liplab2/public/script.js

document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

function initializeApp() {
    updateAuthButton(); // Checks login status and updates the nav button
    loadTrendingProducts(); // Fetches and displays products from your database
    loadVideoContent(); // Loads the hardcoded video content
    
    // You can add back other initializations if needed
    // e.g., setupEventListeners();
}

/**
 * Checks if a user is logged in and updates the nav button to show
 * "Sign In" or "Sign Out" as appropriate.
 */
function updateAuthButton() {
    const authButton = document.getElementById('authButton');
    const user = localStorage.getItem('liplab_user');

    if (authButton) {
        if (user) {
            // User is logged in
            authButton.textContent = 'Sign Out';
            authButton.onclick = logout; // Assign the logout function
        } else {
            // User is not logged in
            authButton.textContent = 'Sign In';
            authButton.onclick = () => { window.location.href = 'login.php'; };
        }
    }
}

/**
 * Fetches trending products from your server and displays them.
 */
async function loadTrendingProducts() {
    const productsGrid = document.getElementById('productsGrid');
    if (!productsGrid) return; // Exit if the grid doesn't exist on the page

    try {
        // Fetch data from your backend API
        const response = await fetch('/api/products/trending?limit=6');
        const result = await response.json();

        if (response.ok && result.success) {
            const products = result.data;
            // Clear any old content and display the new products
            productsGrid.innerHTML = products.map(product => createProductCard(product)).join('');
        } else {
            // Display an error if the data couldn't be fetched
            productsGrid.innerHTML = `<p class="error-message">Could not load trending products.</p>`;
        }
    } catch (error) {
        console.error("Failed to fetch trending products:", error);
        productsGrid.innerHTML = `<p class="error-message">Error connecting to the server.</p>`;
    }
}

/**
 * Creates the HTML for a single product card.
 * @param {object} product The product data from your database.
 * @returns {string} HTML string for the product card.
 */
function createProductCard(product) {
    // Default to a placeholder if the image link is broken or missing
    const imageUrl = product.image || 'https://via.placeholder.com/400';

    return `
        <div class="product-card" data-product-id="${product.id}">
            <div class="card-image">
                <img src="${imageUrl}" alt="${product.name}" loading="lazy" onerror="this.src='https://via.placeholder.com/400';">
                <div class="card-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23,6 13.5,15.5 8.5,10.5 1,18"/>
                        <polyline points="17,6 23,6 23,12"/>
                    </svg>
                    Trending
                </div>
                <button class="wishlist-btn" onclick="toggleWishlist(${product.id})">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                </button>
            </div>
            <div class="card-content">
                <div class="card-header">
                    <span class="product-type">${product.type || 'Lipstick'}</span>
                    <div class="price">${product.priceSign}${product.price.toFixed(2)}</div>
                </div>
                <h3 class="card-title">${product.name}</h3>
                <p class="card-subtitle">${product.brand}</p>
                <div class="rating">
                    <span class="stars">★</span>
                    <span class="rating-text">${product.rating} (${product.reviews} reviews)</span>
                </div>
                <button class="btn-secondary" onclick="addToCart(${product.id})">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    Add to Cart
                </button>
            </div>
        </div>
    `;
}

/**
 * Logs the user out, clears storage, and redirects.
 */
function logout() {
    localStorage.removeItem('liplab_user');
    showNotification('You have been signed out.', 'info');
    setTimeout(() => {
        window.location.href = 'index.php';
    }, 1500);
}

// Dummy functions for actions until you implement them
function toggleWishlist(productId) {
    showNotification(`Toggled wishlist for product #${productId}`, 'info');
}
function addToCart(productId) {
    showNotification(`Added product #${productId} to cart!`, 'success');
}

async function loadVideoContent() {
  const videosGrid = document.getElementById("videosGrid");
  if (!videosGrid) return;

  try {
    const response = await fetch("/api/videos");
    const result = await response.json();

    if (result.success && result.data.length > 0) {
      // Memetakan data video ke kartu HTML menggunakan createVideoCard
      videosGrid.innerHTML = result.data.map((video) => createVideoCard(video)).join("");
    } else {
      videosGrid.innerHTML = `<p class="error-message">Tidak dapat memuat video saat ini.</p>`;
    }
  } catch (error) {
    console.error("Gagal mengambil video:", error);
    videosGrid.innerHTML = `<p class="error-message">Gagal terhubung ke server.</p>`;
  }
}

/**
 * **DIPERBARUI**: Fungsi untuk membuat HTML untuk satu kartu video.
 */
function createVideoCard(video) {
  return `
    <div class="video-card">
        <div class="card-image">
            <a href="https://www.youtube.com/watch?v=${video.id}" target="_blank">
                <img src="${video.thumbnail}" alt="${video.title}" loading="lazy">
                <div class="play-overlay">
                    <div class="play-button">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="5,3 19,12 5,21"/>
                        </svg>
                    </div>
                </div>
            </a>
            ${video.duration ? `<div class="duration">${video.duration}</div>` : ''}
        </div>
        <div class="card-content">
            <h3 class="card-title">${video.title}</h3>
            <p class="card-subtitle" style="color: #ec4899;">${video.creator}</p>
        </div>
    </div>
  `;
}

// --- Reusable Notification Function ---
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.style.cssText = `
        position: fixed; top: 2rem; right: 2rem;
        background: ${type === 'error' ? 'linear-gradient(135deg, #ef4444, #dc2626)' : type === 'success' ? 'linear-gradient(135deg, #10b981, #059669)' : 'linear-gradient(135deg, #3b82f6, #6366f1)'};
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
        setTimeout(() => { if (notification.parentNode) { notification.parentNode.removeChild(notification); }}, 300);
    }, 4000);
}