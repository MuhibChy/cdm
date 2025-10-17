/**
 * CDMS Demo Enhancements
 * Browser compatibility and error handling improvements
 */

// Polyfill for older browsers
if (!String.prototype.includes) {
    String.prototype.includes = function(search, start) {
        'use strict';
        if (typeof start !== 'number') {
            start = 0;
        }
        if (start + search.length > this.length) {
            return false;
        } else {
            return this.indexOf(search, start) !== -1;
        }
    };
}

// Console polyfill for older browsers
if (!window.console) {
    window.console = {
        log: function() {},
        warn: function() {},
        error: function() {},
        info: function() {}
    };
}

// Enhanced error handling
window.addEventListener('error', function(e) {
    console.warn('JavaScript Error:', e.error);
    // Don't break the demo for minor errors
    return true;
});

// Resource loading helper
function loadResource(url, type, callback) {
    let element;
    
    if (type === 'css') {
        element = document.createElement('link');
        element.rel = 'stylesheet';
        element.href = url;
    } else if (type === 'js') {
        element = document.createElement('script');
        element.src = url;
    }
    
    if (callback) {
        element.onload = callback;
        element.onerror = function() {
            console.warn('Failed to load resource:', url);
            if (callback) callback(new Error('Resource load failed'));
        };
    }
    
    document.head.appendChild(element);
}

// Fallback CDN resources
const fallbackResources = {
    jquery: 'https://code.jquery.com/jquery-3.6.0.min.js',
    bootstrap: 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js',
    chartjs: 'https://cdn.jsdelivr.net/npm/chart.js',
    datatables: 'https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js',
    fontawesome: 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'
};

// Check and load fallback resources
function checkAndLoadFallbacks() {
    // Check jQuery
    if (typeof jQuery === 'undefined') {
        console.warn('jQuery not found locally, loading from CDN');
        loadResource(fallbackResources.jquery, 'js', function(error) {
            if (!error) {
                console.info('jQuery loaded from CDN');
                initializeDemoFeatures();
            }
        });
    } else {
        initializeDemoFeatures();
    }
}

// Initialize demo features with error handling
function initializeDemoFeatures() {
    $(document).ready(function() {
        // Initialize tooltips if Bootstrap is available
        try {
            if (typeof $().tooltip === 'function') {
                $('[data-toggle="tooltip"]').tooltip();
            }
        } catch(e) {
            console.warn('Tooltip initialization failed:', e);
        }
        
        // Initialize popovers if Bootstrap is available
        try {
            if (typeof $().popover === 'function') {
                $('[data-toggle="popover"]').popover();
            }
        } catch(e) {
            console.warn('Popover initialization failed:', e);
        }
        
        // Enhanced button interactions
        $(document).on('click', '.btn:not(.no-demo)', function(e) {
            e.preventDefault();
            const buttonText = $(this).text().trim();
            
            // Show different messages based on button type
            let message = 'This is a demo version. ';
            if (buttonText.includes('View') || buttonText.includes('Edit')) {
                message += 'In the full version, this would open the detailed view.';
            } else if (buttonText.includes('Delete') || buttonText.includes('Remove')) {
                message += 'In the full version, this would delete the item after confirmation.';
            } else if (buttonText.includes('Add') || buttonText.includes('Create')) {
                message += 'In the full version, this would open the creation form.';
            } else {
                message += 'In the full version, this would perform the actual action.';
            }
            
            // Use modern notification if available, otherwise alert
            if (typeof Toastify !== 'undefined') {
                Toastify({
                    text: message,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "linear-gradient(to right, #667eea, #764ba2)",
                }).showToast();
            } else {
                alert(message);
            }
        });
        
        // Smooth scrolling for anchor links
        $('a[href^="#"]').on('click', function(e) {
            const target = $(this.getAttribute('href'));
            if (target.length) {
                e.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 100
                }, 1000);
            }
        });
    });
}

// Mobile-friendly enhancements
function initializeMobileEnhancements() {
    // Add touch-friendly classes for mobile
    if ('ontouchstart' in window) {
        document.body.classList.add('touch-device');
        
        // Add touch-friendly styles
        const style = document.createElement('style');
        style.textContent = `
            .touch-device .btn {
                min-height: 44px;
                min-width: 44px;
            }
            .touch-device .nav-link {
                padding: 12px 16px;
            }
            .touch-device .dropdown-item {
                padding: 12px 20px;
            }
        `;
        document.head.appendChild(style);
    }
    
    // Handle orientation changes
    window.addEventListener('orientationchange', function() {
        setTimeout(function() {
            // Trigger window resize to recalculate layouts
            window.dispatchEvent(new Event('resize'));
        }, 100);
    });
}

// Accessibility enhancements
function initializeAccessibilityEnhancements() {
    // Add ARIA labels to buttons without text
    $('button:not([aria-label]):empty, a:not([aria-label]):empty').each(function() {
        const $this = $(this);
        const title = $this.attr('title');
        const icon = $this.find('i').attr('class');
        
        if (title) {
            $this.attr('aria-label', title);
        } else if (icon && icon.includes('fa-')) {
            // Extract Font Awesome icon name for aria-label
            const iconName = icon.split('fa-').pop().split(' ')[0];
            $this.attr('aria-label', iconName.replace('-', ' '));
        }
    });
    
    // Add skip navigation link
    if (!$('#skip-nav').length) {
        $('body').prepend(`
            <a href="#main-content" id="skip-nav" class="sr-only sr-only-focusable" 
               style="position: absolute; top: 10px; left: 10px; z-index: 9999; 
                      background: #007bff; color: white; padding: 8px 16px; 
                      text-decoration: none; border-radius: 4px;">
                Skip to main content
            </a>
        `);
    }
}

// Performance monitoring
function initializePerformanceMonitoring() {
    if ('performance' in window) {
        window.addEventListener('load', function() {
            setTimeout(function() {
                const perfData = performance.timing;
                const loadTime = perfData.loadEventEnd - perfData.navigationStart;
                console.info('Page load time:', loadTime + 'ms');
                
                // Log slow loading resources
                if (performance.getEntriesByType) {
                    const resources = performance.getEntriesByType('resource');
                    resources.forEach(function(resource) {
                        if (resource.duration > 1000) {
                            console.warn('Slow resource:', resource.name, resource.duration + 'ms');
                        }
                    });
                }
            }, 0);
        });
    }
}

// Initialize all enhancements
document.addEventListener('DOMContentLoaded', function() {
    checkAndLoadFallbacks();
    initializeMobileEnhancements();
    initializeAccessibilityEnhancements();
    initializePerformanceMonitoring();
});

// Export for use in other scripts
window.CDMSDemo = {
    loadResource: loadResource,
    fallbackResources: fallbackResources,
    initializeDemoFeatures: initializeDemoFeatures
};
