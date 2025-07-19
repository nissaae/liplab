document.addEventListener('DOMContentLoaded', function() {
    updateAuthButton(); 
    initializeFindShadePage();
});

function initializeFindShadePage() {
    const fileInput = document.getElementById('fileInput');
    const uploadArea = document.getElementById('uploadArea');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const uploadPreview = document.getElementById('uploadPreview');
    const previewImage = document.getElementById('previewImage');
    const browseBtn = document.getElementById('browseBtn');
    const changePhotoBtn = document.getElementById('changePhotoBtn');
    const analyzeBtn = document.getElementById('analyzeBtn');
    const analysisModal = document.getElementById('analysisModal');
    const progressFill = document.getElementById('progressFill');
    const progressText = document.getElementById('progressText');

    console.log('Browse button:', browseBtn);
    console.log('File input:', fileInput);
    console.log('Upload area:', uploadArea);

    // File input event
      if (!fileInput || !browseBtn) {
        console.error('Critical elements not found!');
        return;
    }

    fileInput.addEventListener('change', handleFileSelect);
    
    // Browse button click
    browseBtn.addEventListener('click', function(e) {
        console.log('Browse button clicked');
        e.preventDefault();
        e.stopPropagation();
        fileInput.click();
    });

    changePhotoBtn.addEventListener('click', function(e) {
        console.log('Change photo button clicked');
        e.preventDefault();
        e.stopPropagation();
        fileInput.click();
    });

    
    // Drag and drop events
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const file = files[0];
            if (isValidImageFile(file)) {
                // Create a new FileList-like object for better browser compatibility
                const dt = new DataTransfer();
                dt.items.add(file);
                fileInput.files = dt.files;
                handleFile(file);
            } else {
                showNotification('Please select a valid image file (JPG, PNG)', 'error');
            }
        }
    });

    uploadArea.addEventListener('click', function(e) {
        console.log('Upload area clicked', e.target);
        if ((e.target === uploadArea || e.target.closest('#uploadPlaceholder')) && 
            !e.target.closest('button')) {
            fileInput.click();
        }
    });
    
    // Analyze button click
    analyzeBtn.addEventListener('click', function(e) {
        e.preventDefault();
        startAnalysis();
    });
    
    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function handleDragOver(e) {
        uploadArea.classList.add('dragover');
    }

    function handleDragLeave(e) {
        uploadArea.classList.remove('dragover');
    }

    function handleDrop(e) {
        uploadArea.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFile(files[0]);
        }
    }

    function handleFileSelect(e) {
        console.log('File input changed');
        const file = e.target.files[0];
        if (file) {
            handleFile(file);
        }
    }

    function handleFile(file) {
        console.log('Handling file:', file.name, file.type, file.size);
        // Validate file type
        if (!file.type.startsWith('image/')) {
            showNotification('Please select an image file', 'error');
            return;
        }

        // Validate file size (10MB limit)
        if (file.size > 10 * 1024 * 1024) {
            showNotification('File size must be less than 10MB', 'error');
            return;
        }

        // Read and display the file
        const reader = new FileReader();
        reader.onload = function(e) {
            console.log('File read successfully');
            previewImage.src = e.target.result;
            showPreview();
            addImageLoadAnimation();
        };
        reader.onerror = function() {
            console.error('Error reading file');
            showNotification('Error reading file', 'error');
        };
        reader.readAsDataURL(file);
    }

    function isValidImageFile(file) {
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        return validTypes.includes(file.type);
    }

    function showPreview() {
        console.log('Showing preview');
        uploadPlaceholder.style.display = 'none';
        uploadPreview.style.display = 'block';
        analyzeBtn.style.display = 'flex';
        
        // Add animation
        uploadPreview.style.opacity = '0';
        uploadPreview.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            uploadPreview.style.transition = 'all 0.5s ease';
            uploadPreview.style.opacity = '1';
            uploadPreview.style.transform = 'translateY(0)';
        }, 100);
    }

    function addImageLoadAnimation() {
        previewImage.addEventListener('load', function() {
            this.style.animation = 'imageZoomIn 0.5s ease-out';
        });
    }

    function startAnalysis() {
        console.log('Starting analysis');

        if (!analysisModal) {
            console.error('Analysis modal not found');
            showNotification('Analysis modal not found', 'error');
            return;
        }

        analysisModal.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        // Simulate analysis progress
        let progress = 0;
        const progressInterval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress > 100) progress = 100;
            
            if (progressFill) progressFill.style.width = progress + '%';
            if (progressText) progressText.textContent = Math.round(progress) + '%';
            
            if (progress >= 100) {
                clearInterval(progressInterval);
                setTimeout(() => {
                    completeAnalysis();
                }, 1000);
            }
        }, 200);
    }

    function completeAnalysis() {
        if (analysisModal) {
            analysisModal.classList.remove('active');
        }
        document.body.style.overflow = '';
        
        // Show success notification
        showNotification('Analysis complete! Redirecting to results...', 'success');
        
        // Simulate redirect to results page
        setTimeout(() => {
            window.location.href = 'result.php';
        }, 2000);
    }

    function showNotification(message, type = 'info') {
        console.log('Notification:', message, type);
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
    window.handleFile = handleFile;

    // Add some interactive animations
    addInteractiveAnimations();
}

function addInteractiveAnimations() {
    // Animate tips on scroll
    const tipItems = document.querySelectorAll('.tip-item');
    if (tipItems.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        }, { threshold: 0.5 });

        tipItems.forEach(tip => {
            observer.observe(tip);
        });
    }

    // Add floating animation to upload icon
    const uploadIcon = document.querySelector('.upload-icon');
    if (uploadIcon) {
        uploadIcon.addEventListener('mouseenter', function() {
            this.style.animation = 'iconPulse 0.6s ease-in-out';
        });
        
        uploadIcon.addEventListener('animationend', function() {
            this.style.animation = 'iconPulse 2s ease-in-out infinite';
        });
    }

    // Add hover effects to cards
    const glassCards = document.querySelectorAll('.glass-card');
    glassCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 20px 60px rgba(31, 38, 135, 0.5)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 8px 32px rgba(31, 38, 135, 0.37)';
        });
    });
}

function logout() {
if (typeof(Storage) !== "undefined") {
        localStorage.removeItem('liplab_user');
    }
    alert('You have been signed out.');
    window.location.href = 'index.php';
}

function updateAuthButton() {
    const authButton = document.getElementById('authButton');
    if (!authButton) return;
    
    let user = null;
    if (typeof(Storage) !== "undefined") {
        user = localStorage.getItem('liplab_user');
    }

    if (user) {
        authButton.textContent = 'Sign Out';
        authButton.onclick = logout;
    } else {
        authButton.textContent = 'Sign In';
        authButton.onclick = () => { window.location.href = 'login.php'; };
    }
}

// Add keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('analysisModal');
        if (modal.classList.contains('active')) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }
    
    if (e.ctrlKey && e.key === 'u') {
        e.preventDefault();
        const fileInput = document.getElementById('fileInput');
        if (fileInput) {
            fileInput.click();
        }
    }
});

// Add paste functionality
document.addEventListener('paste', function(e) {
    const items = e.clipboardData.items;
    for (let item of items) {
        if (item.type.startsWith('image/')) {
            const file = item.getAsFile();
            if (file && window.handleFile) {
                window.handleFile(file);
                e.preventDefault();
            }
        }
    }
});

window.handleFile = handleFile; // Declare handleFile globally