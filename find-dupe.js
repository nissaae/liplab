// Find Dupe Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    updateAuthButton();
    initializeFindDupePage();
});

function initializeFindDupePage() {
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const loadingModal = document.getElementById('loadingModal');
    
    // Search functionality
    searchBtn.addEventListener('click', performSearch);
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            performSearch();
        }
    });
    
    // Auto-complete functionality
    searchInput.addEventListener('input', handleSearchInput);
    
    // Sort functionality
    const sortBy = document.getElementById('sortBy');
    if (sortBy) {
        sortBy.addEventListener('change', sortResults);
    }
}

function logout() {
    localStorage.removeItem('liplab_user');
    // You can add a showNotification call here if you have one on these pages
    alert('You have been signed out.');
    window.location.href = 'index.php';
}

function updateAuthButton() {
    const authButton = document.getElementById('authButton');
    const user = localStorage.getItem('liplab_user');

    if (user) {
        authButton.textContent = 'Sign Out';
        authButton.onclick = logout;
    } else {
        authButton.textContent = 'Sign In';
        authButton.onclick = () => { window.location.href = 'login.php'; };
    }
}

function handleSearchInput(e) {
    const query = e.target.value.toLowerCase();
    
    // Simple auto-complete suggestions
    const suggestions = [
        'Charlotte Tilbury Pillow Talk',
        'Fenty Beauty Stunna Lip Paint',
        'Rare Beauty Soft Pinch Liquid Blush',
        'Dior Addict Lip Glow',
        'MAC Ruby Woo',
        'YSL Rouge Volupte',
        'Glossier Cloud Paint',
        'Kylie Cosmetics Lip Kit',
        'Huda Beauty Liquid Matte',
        'Urban Decay Vice Lipstick'
    ];
    
    // In a real app, this would show a dropdown with suggestions
    if (query.length > 2) {
        const matches = suggestions.filter(item => 
            item.toLowerCase().includes(query)
        );
        // Could implement dropdown here
    }
}

function performSearch() {
    const searchQuery = document.getElementById('searchInput').value.trim();
    
    if (!searchQuery) {
        showNotification('Please enter a product name to search for dupes', 'error');
        return;
    }
    
    // Show loading modal
    const loadingModal = document.getElementById('loadingModal');
    loadingModal.classList.add('active');
    document.body.style.overflow = 'hidden';
    
    // Simulate search delay
    setTimeout(() => {
        loadingModal.classList.remove('active');
        document.body.style.overflow = '';
        
        // Show results
        showSearchResults(searchQuery);
        
        // Scroll to results
        setTimeout(() => {
            document.getElementById('resultsSection').scrollIntoView({ 
                behavior: 'smooth' 
            });
        }, 300);
    }, 2500);
}

function searchProduct(productName) {
    document.getElementById('searchInput').value = productName;
    performSearch();
}

function showSearchResults(query) {
    const resultsSection = document.getElementById('resultsSection');
    const resultsTitle = document.getElementById('resultsTitle');
    const resultsCount = document.getElementById('resultsCount');
    const originalProduct = document.getElementById('originalProduct');
    const dupesGrid = document.getElementById('dupesGrid');
    
    // Sample original product data
    const originalProductData = {
        name: "Pillow Talk Lipstick",
        brand: "Charlotte Tilbury",
        type: "Lipstick",
        price: 38.00,
        rating: 4.8,
        reviews: 2847,
        image: "https://images.unsplash.com/photo-1586495777744-4413f21062fa?w=400&h=400&fit=crop"
    };
    
    // Sample dupe data
    const dupesData = [
        {
            id: 1,
            name: "Velvet Teddy Lipstick",
            brand: "MAC",
            type: "Lipstick",
            currentPrice: 22.00,
            originalPrice: 38.00,
            savings: "42%",
            matchScore: "94%",
            rating: 4.6,
            reviews: 1523,
            features: ["Long-wearing", "Matte finish", "Cruelty-free"],
            image: "https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=400&h=400&fit=crop"
        },
        {
            id: 2,
            name: "Nude Attitude Lipstick",
            brand: "Maybelline",
            type: "Lipstick",
            currentPrice: 8.99,
            originalPrice: 38.00,
            savings: "76%",
            matchScore: "91%",
            rating: 4.4,
            reviews: 892,
            features: ["Affordable", "Creamy texture", "Wide shade range"],
            image: "https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=400&h=400&fit=crop"
        },
        {
            id: 3,
            name: "Rosewood Matte Lipstick",
            brand: "Revlon",
            type: "Lipstick",
            currentPrice: 12.99,
            originalPrice: 38.00,
            savings: "66%",
            matchScore: "89%",
            rating: 4.3,
            reviews: 654,
            features: ["Moisturizing", "Full coverage", "Classic formula"],
            image: "https://images.unsplash.com/photo-1631214540242-6b5e4c2d6b7d?w=400&h=400&fit=crop"
        },
        {
            id: 4,
            name: "Nude Pink Liquid Lipstick",
            brand: "ColourPop",
            type: "Liquid Lipstick",
            currentPrice: 7.00,
            originalPrice: 38.00,
            savings: "82%",
            matchScore: "87%",
            rating: 4.5,
            reviews: 1247,
            features: ["Ultra matte", "Vegan", "Highly pigmented"],
            image: "https://images.unsplash.com/photo-1583241800698-9c2e8b2b3b8a?w=400&h=400&fit=crop"
        },
        {
            id: 5,
            name: "Mauve Crush Lipstick",
            brand: "L'Oréal Paris",
            type: "Lipstick",
            currentPrice: 10.99,
            originalPrice: 38.00,
            savings: "71%",
            matchScore: "85%",
            rating: 4.2,
            reviews: 743,
            features: ["Hydrating", "Smooth application", "Long-lasting"],
            image: "https://images.unsplash.com/photo-1515688594390-b649af70d282?w=400&h=400&fit=crop"
        },
        {
            id: 6,
            name: "Dusty Rose Lip Color",
            brand: "NYX Professional",
            type: "Lipstick",
            currentPrice: 6.99,
            originalPrice: 38.00,
            savings: "82%",
            matchScore: "83%",
            rating: 4.1,
            reviews: 567,
            features: ["Budget-friendly", "Creamy finish", "Easy to apply"],
            image: "https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=400&fit=crop"
        }
    ];
    
    // Update results header
    resultsTitle.textContent = `Dupes for "${query}"`;
    resultsCount.textContent = `${dupesData.length} dupes found`;
    
    // Generate original product HTML
    originalProduct.innerHTML = `
        <div class="product-content">
            <div class="product-image">
                <img src="${originalProductData.image}" alt="${originalProductData.name}" loading="lazy">
            </div>
            <div class="product-info">
                <div class="product-header">
                    <span class="product-type-badge">${originalProductData.type}</span>
                    <div class="product-price">$${originalProductData.price.toFixed(2)}</div>
                </div>
                <h3>${originalProductData.name}</h3>
                <div class="product-brand">${originalProductData.brand}</div>
                <div class="product-rating">
                    <span class="rating-stars">★</span>
                    <span>${originalProductData.rating} (${originalProductData.reviews.toLocaleString()} reviews)</span>
                </div>
            </div>
        </div>
    `;
    
    // Generate dupes HTML
    dupesGrid.innerHTML = dupesData.map((dupe, index) => `
        <div class="dupe-card" style="animation-delay: ${index * 0.1}s">
            <div class="dupe-image">
                <img src="${dupe.image}" alt="${dupe.name}" loading="lazy">
                <div class="match-score">${dupe.matchScore} Match</div>
                <div class="savings-badge">Save ${dupe.savings}</div>
            </div>
            <div class="dupe-content">
                <div class="dupe-header">
                    <span class="product-type-badge">${dupe.type}</span>
                    <div class="dupe-price">
                        <div class="current-price">$${dupe.currentPrice.toFixed(2)}</div>
                        <div class="original-price">$${dupe.originalPrice.toFixed(2)}</div>
                    </div>
                </div>
                <h4>${dupe.name}</h4>
                <div class="dupe-brand">${dupe.brand}</div>
                <div class="dupe-features">
                    ${dupe.features.map(feature => `<span class="feature-tag">${feature}</span>`).join('')}
                </div>
                <div class="dupe-rating">
                    <span class="rating-stars">★</span>
                    <span>${dupe.rating} (${dupe.reviews.toLocaleString()})</span>
                </div>
                <div class="dupe-actions">
                    <button class="btn-compare" onclick="compareDupe(${dupe.id})">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 11H1l4-4M1 7l4 4M23 13h-8l4 4M23 17l-4-4"/>
                        </svg>
                        Compare
                    </button>
                    <button class="btn-add-cart" onclick="addDupeToCart(${dupe.id})">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="9" cy="21" r="1"/>
                            <circle cx="20" cy="21" r="1"/>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        </svg>
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
    `).join('');
    
    // Show results section
    resultsSection.style.display = 'block';
    resultsSection.style.animation = 'fadeInUp 0.8s ease-out';
}

function sortResults() {
    const sortBy = document.getElementById('sortBy').value;
    showNotification(`Sorting by ${sortBy.replace('-', ' ')}...`, 'info');
    
    // In a real app, this would re-sort the results
    setTimeout(() => {
        showNotification('Results sorted!', 'success');
    }, 1000);
}

function compareDupe(dupeId) {
    showNotification('Opening comparison view...', 'info');
    // In a real app, this would open a detailed comparison modal
}

function addDupeToCart(dupeId) {
    showNotification('Added dupe to cart!', 'success');
    // In a real app, this would add the dupe to the shopping cart
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

// Add keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('loadingModal');
        if (modal.classList.contains('active')) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }
    
    if (e.ctrlKey && e.key === 'f') {
        e.preventDefault();
        document.getElementById('searchInput').focus();
    }
});