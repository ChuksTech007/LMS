{{-- Add this to your resources/views/layouts/app.blade.php right after the opening <body> tag --}}

<!-- Global Page Loader -->
<div id="page-loader" class="page-loader">
    <div class="loader-content">
        <div class="loader-spinner">
            <div class="spinner-ring"></div>
            <div class="spinner-ring"></div>
            <div class="spinner-ring"></div>
            <div class="spinner-ring"></div>
        </div>
        <div class="loader-logo">
            <h2>FUTO SkillUp</h2>
        </div>
        <div class="loader-text">Loading...</div>
        <div class="loader-progress">
            <div class="progress-bar"></div>
        </div>
    </div>
</div>

<style>
/* Page Loader Styles */
.page-loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #065f46 0%, #047857 50%, #10b981 100%);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    transition: opacity 0.5s ease, visibility 0.5s ease;
}

.page-loader.hidden {
    opacity: 0;
    visibility: hidden;
}

.loader-content {
    text-align: center;
    color: white;
}

/* Animated Spinner */
.loader-spinner {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 0 auto 30px;
}

.spinner-ring {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 4px solid transparent;
    border-top-color: rgba(255, 255, 255, 0.8);
    border-radius: 50%;
    animation: spin 1.5s linear infinite;
}

.spinner-ring:nth-child(2) {
    width: 90%;
    height: 90%;
    top: 5%;
    left: 5%;
    border-top-color: rgba(255, 255, 255, 0.6);
    animation-duration: 2s;
    animation-direction: reverse;
}

.spinner-ring:nth-child(3) {
    width: 80%;
    height: 80%;
    top: 10%;
    left: 10%;
    border-top-color: rgba(255, 255, 255, 0.4);
    animation-duration: 2.5s;
}

.spinner-ring:nth-child(4) {
    width: 70%;
    height: 70%;
    top: 15%;
    left: 15%;
    border-top-color: rgba(255, 255, 255, 0.2);
    animation-duration: 3s;
    animation-direction: reverse;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

/* Logo */
.loader-logo {
    margin-bottom: 20px;
}

.loader-logo h2 {
    font-size: 32px;
    font-weight: bold;
    color: white;
    letter-spacing: 2px;
    margin: 0;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: 0.8;
        transform: scale(1.05);
    }
}

/* Loading Text */
.loader-text {
    font-size: 18px;
    font-weight: 500;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 20px;
    animation: fadeInOut 1.5s ease-in-out infinite;
}

@keyframes fadeInOut {
    0%, 100% {
        opacity: 0.5;
    }
    50% {
        opacity: 1;
    }
}

/* Progress Bar */
.loader-progress {
    width: 250px;
    height: 4px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 2px;
    margin: 0 auto;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #fbbf24, #f59e0b);
    border-radius: 2px;
    animation: progress 2s ease-in-out infinite;
}

@keyframes progress {
    0% {
        width: 0%;
        opacity: 1;
    }
    50% {
        width: 70%;
        opacity: 1;
    }
    100% {
        width: 100%;
        opacity: 0;
    }
}

/* Mobile Responsiveness */
@media (max-width: 640px) {
    .loader-spinner {
        width: 80px;
        height: 80px;
    }
    
    .loader-logo h2 {
        font-size: 24px;
    }
    
    .loader-text {
        font-size: 16px;
    }
    
    .loader-progress {
        width: 200px;
    }
}
</style>

<script>
// Global Loader Script
document.addEventListener('DOMContentLoaded', function() {
    const loader = document.getElementById('page-loader');
    
    // Hide loader when page is fully loaded
    window.addEventListener('load', function() {
        setTimeout(function() {
            loader.classList.add('hidden');
        }, 500); // Small delay for smooth transition
    });
    
    // Show loader on page navigation (for SPAs or Livewire)
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && link.href && !link.target && !link.hasAttribute('download')) {
            // Check if it's an internal link
            if (link.hostname === window.location.hostname) {
                loader.classList.remove('hidden');
            }
        }
    });
    
    // Show loader on form submission
    document.addEventListener('submit', function(e) {
        loader.classList.remove('hidden');
    });
    
    // Hide loader if navigation is cancelled (back button, etc)
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            loader.classList.add('hidden');
        }
    });
});

// For AJAX/Fetch requests (optional)
if (window.fetch) {
    const originalFetch = window.fetch;
    window.fetch = function(...args) {
        document.getElementById('page-loader').classList.remove('hidden');
        return originalFetch.apply(this, args).finally(() => {
            setTimeout(() => {
                document.getElementById('page-loader').classList.add('hidden');
            }, 300);
        });
    };
}
</script>