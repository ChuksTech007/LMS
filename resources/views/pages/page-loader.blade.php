<div id="page-loader" class="fixed inset-0 z-[9999] flex items-center justify-center bg-white/50 backdrop-blur-md transition-opacity duration-500 ease-in-out">
    <div class="text-center text-gray-800">
        {{-- 
          The main loader container now uses Tailwind for:
          - fixed inset-0: Full screen
          - z-[9999]: High z-index
          - flex items-center justify-center: Center content
          - bg-white/50: Light, semi-transparent overlay (for contrast)
          - backdrop-blur-md: The key blur effect
          - transition-opacity duration-500 ease-in-out: Smooth fade-out
        --}}
        
        <div class="relative w-32 h-32 mx-auto mb-6">
            {{-- The single color-changing spinner circle --}}
            <div class="loader-circle w-full h-full border-4 rounded-full border-solid border-transparent"></div>
        </div>
        
        <div class="mb-4">
            <h2 class="text-3xl font-bold text-gray-800 tracking-wider m-0" style="text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);" id="loader-logo-text">FUTO SKILLUP</h2>
        </div>
        
        <div class="loader-text text-lg font-medium text-gray-700 mb-5">Loading...</div>
        
        <div class="w-64 h-1 bg-gray-200 rounded-full mx-auto overflow-hidden">
            <div class="progress-bar h-full rounded-full bg-gradient-to-r from-yellow-400 to-yellow-600"></div>
        </div>
    </div>
</div>

<style>
/* 1. Custom CSS for Loader State and Animations */

/* The class to hide the loader (replaces .page-loader.hidden) */
.page-loader.hidden {
    opacity: 0;
    visibility: hidden;
}

/* Keyframes for the Rotating Color-Changing Circle */
@keyframes spin-color {
    0% {
        transform: rotate(0deg);
        border-top-color: #10B981; /* Tailwind 'green-500' */
    }
    50% {
        border-top-color: #FBBF24; /* Tailwind 'yellow-400' */
    }
    100% {
        transform: rotate(360deg);
        border-top-color: #10B981; /* Back to 'green-500' */
    }
}

/* Apply the Animation to the Loader Circle */
.loader-circle {
    /* Base color for the non-moving part */
    border-color: rgba(0, 0, 0, 0.1);
    
    /* Apply the animation */
    animation: spin-color 1.5s cubic-bezier(0.68, -0.55, 0.265, 1.55) infinite;
}

/* Logo Pulse Animation (from your original logic) */
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
#loader-logo-text {
    animation: pulse 2s ease-in-out infinite;
}

/* Loading Text FadeInOut Animation (from your original logic) */
@keyframes fadeInOut {
    0%, 100% {
        opacity: 0.5;
    }
    50% {
        opacity: 1;
    }
}
.loader-text {
    animation: fadeInOut 1.5s ease-in-out infinite;
}

/* Progress Bar Animation (from your original logic) */
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
.progress-bar {
    animation: progress 1.8s ease-in-out 1 forwards;
}

</style>

<script>
// Global Loader Script (Maintained from your original logic)
document.addEventListener('DOMContentLoaded', function() {
    const loader = document.getElementById('page-loader');
    
    // 1. Hide loader when page is fully loaded
    window.addEventListener('load', function() {
        setTimeout(function() {
            loader.classList.add('hidden');
        }, 500); // Small delay for smooth transition
    });
    
    // 2. Show loader on page navigation 
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && link.href && !link.target && !link.hasAttribute('download')) {
            // Check if it's an internal link
            if (link.hostname === window.location.hostname) {
                loader.classList.remove('hidden');
            }
        }
    });
    
    // 3. Show loader on form submission
    document.addEventListener('submit', function(e) {
        loader.classList.remove('hidden');
    });
    
    // 4. Hide loader if navigation is cancelled (back button, etc)
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            loader.classList.add('hidden');
        }
    });
});

// For AJAX/Fetch requests (optional, maintained from your original logic)
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