// Result page JavaScript
document.addEventListener("DOMContentLoaded", () => {
  initializeResultPage()
})

// API base URL
const API_BASE_URL = ""

function initializeResultPage() {
  // Load analysis data from URL parameters or localStorage
  loadAnalysisData()

  // Load shade recommendations
  loadShadeRecommendations()

  // Initialize filter tabs
  initializeFilterTabs()

  // Initialize animations
  initializeAnimations()

  // Add event listeners
  addEventListeners()
}

function loadAnalysisData() {
  const analysisData = {
    skinTone: "Personalized For You", // Teks umum karena hasilnya acak
    undertone: "Varies",
    confidence: "90+",
    photoData: "https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=400&h=400&fit=crop", // Gambar placeholder
  };
  updateAnalysisDisplay(analysisData);
}

function updateAnalysisDisplay(data) {
  // Perbarui elemen UI dengan data analisis
  document.getElementById("skinToneName").textContent = data.skinTone;
  document.getElementById("skinToneDescription").textContent = "Berikut adalah beberapa produk hebat yang kami pikir akan Anda sukai!";
  document.getElementById("undertone").textContent = data.undertone;
  document.getElementById("confidenceScore").textContent = `${data.confidence}%`;
  document.getElementById("analyzedPhoto").src = data.photoData;
  // Anda dapat memperbarui elemen lain jika perlu
}

/**
 * Mengambil rekomendasi produk acak dari server dan menampilkannya.
 */
async function loadShadeRecommendations() {
  const recommendationsGrid = document.getElementById("recommendationsGrid");
  if (!recommendationsGrid) return;

  recommendationsGrid.innerHTML = `<p>Loading recommendations...</p>`;

  try {
    // Memanggil endpoint API Anda yang sekarang mengembalikan produk acak
    const result = await apiRequest(`/api/products/shade-recommendations`);

    if (result && result.recommendations && result.recommendations.length > 0) {
      displayRecommendations(result.recommendations);
    } else {
      showNoRecommendations();
    }
  } catch (error) {
    console.error("Gagal memuat rekomendasi:", error);
    showErrorState();
  }
}

/**
 * Menampilkan kartu produk di grid.
 */
function displayRecommendations(recommendations) {
  const recommendationsGrid = document.getElementById("recommendationsGrid");
  recommendationsGrid.innerHTML = recommendations
    .map((product) => createRecommendationCard(product))
    .join("");
}

/**
 * Membuat HTML untuk satu kartu produk.
 */
function createRecommendationCard(product) {
    const imageUrl = product.image || 'https://via.placeholder.com/300';
    return `
        <div class="recommendation-card" data-product-type="${(product.type || '').toLowerCase()}">
            <div class="recommendation-image">
                <img src="${imageUrl}" alt="${product.name}" loading="lazy" onerror="this.src='https://via.placeholder.com/300';">
                <div class="match-percentage">${product.matchPercentage || 95}% Match</div>
            </div>
            <div class="recommendation-content">
                <div class="recommendation-header">
                    <span class="product-type">${product.type || 'Lipstick'}</span>
                    <div class="product-price">${product.priceSign || '$'}${product.price.toFixed(2)}</div>
                </div>
                <h4>${product.name}</h4>
                <p>${product.brand}</p>
                <div class="product-rating">
                    <span class="rating-stars">★</span>
                    <span>${product.rating} (${product.reviews})</span>
                </div>
                <div class="recommendation-actions">
                    <button class="btn-wishlist" onclick="addToWishlist(${product.id})">Wishlist</button>
                    <button class="btn-cart" onclick="addToCart(${product.id})">Add to Cart</button>
                </div>
            </div>
        </div>
    `;
}


function showNoRecommendations() {
    const recommendationsGrid = document.getElementById("recommendationsGrid");
    recommendationsGrid.innerHTML = `<p>Tidak ada rekomendasi yang ditemukan saat ini.</p>`;
}

function showErrorState() {
    const recommendationsGrid = document.getElementById("recommendationsGrid");
    recommendationsGrid.innerHTML = `<p>Gagal memuat rekomendasi. Silakan coba lagi nanti.</p>`;
}

function initializeFilterTabs() {
  // Logika filter Anda dapat tetap di sini jika Anda ingin memfilter hasil acak
}

function addEventListeners() {
  // Tambahkan event listener Anda yang lain di sini
}

// Fungsi pembantu untuk permintaan API
async function apiRequest(endpoint) {
  try {
    const response = await fetch(`${API_BASE_URL}${endpoint}`);
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    const data = await response.json();
    if (!data.success) {
      throw new Error(data.error || "Permintaan API gagal");
    }
    return data.data;
  } catch (error) {
    console.error("Kesalahan permintaan API:", error);
    throw error;
  }
}

// Fungsi placeholder untuk tindakan tombol
function addToWishlist(productId) {
  console.log(`Menambahkan produk ${productId} ke wishlist`);
  alert(`Menambahkan produk #${productId} ke wishlist!`);
}

function addToCart(productId) {
  console.log(`Menambahkan produk ${productId} ke keranjang`);
  alert(`Menambahkan produk #${productId} ke keranjang!`);
}

function goBack() {
  window.history.back();
}

function retryAnalysis() {
  window.location.href = "find-shade.php";
}

function showNoRecommendations() {
  const recommendationsGrid = document.getElementById("recommendationsGrid")
  recommendationsGrid.innerHTML = `
        <div class="no-recommendations">
            <div class="no-results-icon">🎨</div>
            <h3>No recommendations found</h3>
            <p>We couldn't find products matching your skin tone. Try browsing our full collection.</p>
            <button class="btn-primary" onclick="window.location.href='index.php'">Browse All Products</button>
        </div>
    `
}

function showErrorState() {
  const recommendationsGrid = document.getElementById("recommendationsGrid")
  recommendationsGrid.innerHTML = `
        <div class="error-state">
            <div class="error-icon">⚠️</div>
            <h3>Unable to load recommendations</h3>
            <p>Please check your connection and try again</p>
            <button class="retry-btn" onclick="loadShadeRecommendations()">Retry</button>
        </div>
    `
}

function initializeFilterTabs() {
  const filterTabs = document.querySelectorAll(".filter-tab")
  const recommendationCards = document.querySelectorAll(".recommendation-card")

  filterTabs.forEach((tab) => {
    tab.addEventListener("click", function () {
      // Remove active class from all tabs
      filterTabs.forEach((t) => t.classList.remove("active"))

      // Add active class to clicked tab
      this.classList.add("active")

      // Get filter value
      const filter = this.dataset.filter

      // Filter products
      recommendationCards.forEach((card) => {
        if (filter === "all") {
          card.style.display = "block"
        } else {
          const productType = card.dataset.productType
          if (productType && productType.includes(filter)) {
            card.style.display = "block"
          } else {
            card.style.display = "none"
          }
        }
      })
    })
  })
}

function addEventListeners() {
  // Add any additional event listeners here
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      const modal = document.getElementById("loadingModal")
      if (modal && modal.classList.contains("active")) {
        modal.classList.remove("active")
      }
    }
  })
}

function initializeAnimations() {
  const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("animate-in")
      }
    })
  }, observerOptions)

  document.querySelectorAll(".fade-in, .slide-up").forEach((el) => {
    observer.observe(el)
  })
}

// Action functions
function goBack() {
  window.location.href = "find-shade.php"
}

function retryAnalysis() {
  window.location.href = "find-shade.php"
}

async function loadMoreRecommendations() {
  const loadingModal = document.getElementById("loadingModal")
  loadingModal.classList.add("active")

  // Simulate loading more recommendations
  setTimeout(() => {
    loadingModal.classList.remove("active")
    showNotification("More recommendations loaded!", "success")
  }, 2000)
}

function saveResults() {
  // In a real app, this would save to user's account
  const analysisData = {
    skinTone: document.getElementById("skinToneName")?.textContent,
    undertone: document.getElementById("undertone")?.textContent,
    confidence: document.getElementById("confidenceScore")?.textContent,
    timestamp: new Date().toISOString(),
  }

  localStorage.setItem("liplab_saved_results", JSON.stringify(analysisData))
  showNotification("Results saved to your profile!", "success")
}

function shareResults() {
  if (navigator.share) {
    navigator.share({
      title: "My LipLab Shade Analysis Results",
      text: "Check out my perfect lip shade recommendations from LipLab!",
      url: window.location.href,
    })
  } else {
    // Fallback: copy to clipboard
    navigator.clipboard.writeText(window.location.href).then(() => {
      showNotification("Link copied to clipboard!", "success")
    })
  }
}

function addToWishlist(productId) {
  showNotification("Added to wishlist!", "success")
}

function addToCart(productId) {
  showNotification("Added to cart!", "success")
}

// API helper function
async function apiRequest(endpoint, options = {}) {
  try {
    const response = await fetch(`${API_BASE_URL}${endpoint}`, {
      headers: {
        "Content-Type": "application/json",
        ...options.headers,
      },
      ...options,
    })

    const data = await response.json()

    if (!data.success) {
      throw new Error(data.error || "API request failed")
    }

    return data.data
  } catch (error) {
    console.error("API request error:", error)
    throw error
  }
}

// Notification system
function showNotification(message, type = "info") {
  const notification = document.createElement("div")
  notification.className = `notification ${type}`
  notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background: ${
          type === "error"
            ? "linear-gradient(135deg, #ef4444, #dc2626)"
            : type === "success"
              ? "linear-gradient(135deg, #10b981, #059669)"
              : "linear-gradient(135deg, #ec4899, #f43f5e)"
        };
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
    `
  notification.textContent = message

  document.body.appendChild(notification)

  setTimeout(() => {
    notification.style.transform = "translateX(0)"
  }, 100)

  setTimeout(() => {
    notification.style.transform = "translateX(400px)"
    setTimeout(() => {
      if (document.body.contains(notification)) {
        document.body.removeChild(notification)
      }
    }, 300)
  }, 4000)
}
