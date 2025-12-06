/**
 * Admin Mobile Menu Toggle
 * Handles sidebar show/hide on mobile devices
 */

(function() {
    'use strict';
    
    function initAdminMenu() {
        const menuToggle = document.getElementById('admin-menu-toggle');
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('admin-sidebar-overlay');
        const body = document.body;
        
        // Debug
        console.log('Admin menu init:', {
            menuToggle: !!menuToggle,
            sidebar: !!sidebar,
            overlay: !!overlay,
            windowWidth: window.innerWidth
        });
        
        if (!menuToggle || !sidebar) {
            console.warn('Admin menu elements not found');
            return false;
        }
        
        // Toggle menu
        function toggleMenu() {
            console.log('Toggle menu clicked');
            const isActive = sidebar.classList.contains('active');
            console.log('Menu is active:', isActive);
            
            if (isActive) {
                closeMenu();
            } else {
                openMenu();
            }
        }
        
        // Open menu
        function openMenu() {
            console.log('Opening menu...');
            
            // Add active class first
            sidebar.classList.add('active');
            
            // Force all styles with highest priority using setProperty
            sidebar.style.setProperty('display', 'block', 'important');
            sidebar.style.setProperty('visibility', 'visible', 'important');
            sidebar.style.setProperty('opacity', '1', 'important');
            sidebar.style.setProperty('position', 'fixed', 'important');
            sidebar.style.setProperty('z-index', '1000', 'important');
            sidebar.style.setProperty('top', '0', 'important');
            sidebar.style.setProperty('left', '0', 'important');
            
            // Use requestAnimationFrame for smooth animation
            requestAnimationFrame(function() {
                sidebar.style.setProperty('transform', 'translateX(0)', 'important');
                console.log('Menu transform applied');
            });
            
            if (overlay) {
                overlay.style.cssText = 'display: block !important;';
                overlay.classList.add('active');
                requestAnimationFrame(function() {
                    overlay.style.opacity = '1';
                });
            }
            
            body.style.overflow = 'hidden';
            
            // Update toggle button icon
            const icon = menuToggle.querySelector('svg');
            if (icon) {
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
            }
            
            console.log('Menu opened, classes:', sidebar.className);
            console.log('Menu styles:', {
                display: sidebar.style.display,
                transform: sidebar.style.transform,
                visibility: sidebar.style.visibility
            });
        }
        
        // Close menu
        function closeMenu() {
            console.log('Closing menu...');
            sidebar.classList.remove('active');
            sidebar.style.transform = 'translateX(-100%)';
            
            if (overlay) {
                overlay.style.opacity = '0';
                overlay.classList.remove('active');
                setTimeout(function() {
                    overlay.style.display = 'none';
                }, 300);
            }
            
            body.style.overflow = '';
            
            // Update toggle button icon
            const icon = menuToggle.querySelector('svg');
            if (icon) {
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
            }
        }
        
        // Event listeners
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Menu toggle clicked');
            toggleMenu();
        });
        
        // Also handle touch events for mobile
        menuToggle.addEventListener('touchend', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Menu toggle touched');
            toggleMenu();
        });
        
        // Close on overlay click
        if (overlay) {
            overlay.addEventListener('click', function() {
                console.log('Overlay clicked');
                closeMenu();
            });
        }
        
        // Close on sidebar link click (mobile only)
        function setupSidebarLinks() {
            if (window.innerWidth <= 768) {
                const sidebarLinks = sidebar.querySelectorAll('a, button');
                sidebarLinks.forEach(function(link) {
                    link.addEventListener('click', function() {
                        // Small delay to allow navigation
                        setTimeout(closeMenu, 100);
                    });
                });
            }
        }
        
        setupSidebarLinks();
        
        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebar.classList.contains('active')) {
                closeMenu();
            }
        });
        
        // Handle window resize
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (window.innerWidth > 768) {
                    closeMenu();
                } else {
                    setupSidebarLinks();
                }
            }, 250);
        });
        
        console.log('Admin menu initialized successfully');
        return true;
    }
    
    // Try multiple initialization methods
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAdminMenu);
    } else {
        // DOM already loaded
        initAdminMenu();
    }
    
    // Also try after delays as fallback
    setTimeout(initAdminMenu, 100);
    setTimeout(initAdminMenu, 500);
    setTimeout(initAdminMenu, 1000);
    
    // Expose globally for debugging
    window.initAdminMenu = initAdminMenu;
})();
