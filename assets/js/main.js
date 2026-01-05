/**
 * Main JavaScript
 * 
 * Core functionality for Biblioteca pentru Toți theme
 * 
 * @package Biblioteca_Pentru_Toti
 */

(function() {
    'use strict';

    // DOM Ready
    document.addEventListener('DOMContentLoaded', init);

    /**
     * Initialize all modules
     */
    function init() {
        initMobileMenu();
        initSearch();
        initBackToTop();
        initSmoothScroll();
        initImageHover();
        initStatsCounter();
        initViewToggle();
        initAccessibility();
    }

    /**
     * Mobile Menu Toggle
     */
    function initMobileMenu() {
        const menuToggle = document.querySelector('.menu-toggle');
        const mainNav = document.querySelector('.main-navigation');
        
        if (!menuToggle || !mainNav) return;

        menuToggle.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            this.setAttribute('aria-expanded', !isExpanded);
            mainNav.classList.toggle('is-open');
            document.body.classList.toggle('menu-open');
            
            // Trap focus in menu when open
            if (!isExpanded) {
                trapFocus(mainNav);
            }
        });

        // Close menu on Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mainNav.classList.contains('is-open')) {
                menuToggle.click();
                menuToggle.focus();
            }
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (mainNav.classList.contains('is-open') && 
                !mainNav.contains(e.target) && 
                !menuToggle.contains(e.target)) {
                menuToggle.click();
            }
        });
    }

    /**
     * Search Functionality
     */
    function initSearch() {
        const searchToggle = document.querySelector('.search-toggle');
        const searchForm = document.querySelector('.search-form-container');
        const searchInput = document.querySelector('.search-field');
        
        if (!searchToggle || !searchForm) return;

        searchToggle.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            this.setAttribute('aria-expanded', !isExpanded);
            searchForm.classList.toggle('is-open');
            
            if (!isExpanded && searchInput) {
                setTimeout(() => searchInput.focus(), 100);
            }
        });

        // Close on Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && searchForm.classList.contains('is-open')) {
                searchToggle.click();
                searchToggle.focus();
            }
        });
    }

    /**
     * Back to Top Button
     */
    function initBackToTop() {
        const backToTop = document.querySelector('.back-to-top');
        
        if (!backToTop) return;

        // Show/hide based on scroll position
        const toggleButton = () => {
            if (window.scrollY > 500) {
                backToTop.classList.add('is-visible');
            } else {
                backToTop.classList.remove('is-visible');
            }
        };

        window.addEventListener('scroll', throttle(toggleButton, 100));

        // Scroll to top on click
        backToTop.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    /**
     * Smooth Scroll for Anchor Links
     */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                
                if (targetId === '#') return;
                
                const target = document.querySelector(targetId);
                
                if (target) {
                    e.preventDefault();
                    
                    const headerOffset = 80;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });

                    // Update URL without jumping
                    history.pushState(null, null, targetId);
                }
            });
        });
    }

    /**
     * Image Hover Effects (grayscale to color)
     */
    function initImageHover() {
        const cards = document.querySelectorAll('.book-card, .author-card');
        
        cards.forEach(card => {
            const image = card.querySelector('img');
            if (!image) return;

            card.addEventListener('mouseenter', () => {
                image.style.filter = 'grayscale(0)';
            });

            card.addEventListener('mouseleave', () => {
                image.style.filter = '';
            });
        });
    }

    /**
     * Animated Stats Counter
     */
    function initStatsCounter() {
        const statsContainer = document.querySelector('.stats-counter[data-animate="true"]');
        
        if (!statsContainer) return;

        const numbers = statsContainer.querySelectorAll('[data-count]');
        let animated = false;

        const animateNumbers = () => {
            if (animated) return;
            
            const containerTop = statsContainer.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            
            if (containerTop < windowHeight * 0.8) {
                animated = true;
                
                numbers.forEach(num => {
                    const target = parseInt(num.dataset.count, 10);
                    const duration = 2000;
                    const start = 0;
                    const startTime = performance.now();
                    
                    const animate = (currentTime) => {
                        const elapsed = currentTime - startTime;
                        const progress = Math.min(elapsed / duration, 1);
                        
                        // Easing function (ease-out)
                        const eased = 1 - Math.pow(1 - progress, 3);
                        const current = Math.floor(start + (target - start) * eased);
                        
                        num.textContent = current.toLocaleString('ro-RO');
                        
                        if (progress < 1) {
                            requestAnimationFrame(animate);
                        } else {
                            num.textContent = target.toLocaleString('ro-RO');
                        }
                    };
                    
                    requestAnimationFrame(animate);
                });
            }
        };

        window.addEventListener('scroll', throttle(animateNumbers, 100));
        animateNumbers(); // Check on load
    }

    /**
     * View Toggle (Grid/List)
     */
    function initViewToggle() {
        const toggleButtons = document.querySelectorAll('.view-toggle');
        const container = document.getElementById('books-container');
        
        if (!toggleButtons.length || !container) return;

        toggleButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const view = this.dataset.view;
                
                // Update buttons
                toggleButtons.forEach(b => {
                    b.classList.remove('active');
                    b.setAttribute('aria-pressed', 'false');
                });
                this.classList.add('active');
                this.setAttribute('aria-pressed', 'true');
                
                // Update container
                container.classList.remove('view-grid', 'view-list');
                container.classList.add('view-' + view);
                
                // Save preference
                localStorage.setItem('bpt_view_preference', view);
            });
        });

        // Restore preference
        const savedView = localStorage.getItem('bpt_view_preference');
        if (savedView) {
            const btn = document.querySelector(`.view-toggle[data-view="${savedView}"]`);
            if (btn) btn.click();
        }
    }

    /**
     * Accessibility Enhancements
     */
    function initAccessibility() {
        // Skip link focus fix
        const skipLink = document.querySelector('.skip-link');
        if (skipLink) {
            skipLink.addEventListener('click', function(e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.setAttribute('tabindex', '-1');
                    target.focus();
                }
            });
        }

        // Add keyboard navigation for cards
        document.querySelectorAll('.book-card, .article-card').forEach(card => {
            const link = card.querySelector('a');
            if (link) {
                card.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        link.click();
                    }
                });
            }
        });
    }

    /**
     * Utility: Throttle Function
     */
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    /**
     * Utility: Debounce Function
     */
    function debounce(func, wait) {
        let timeout;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }

    /**
     * Utility: Trap Focus in Element
     */
    function trapFocus(element) {
        const focusableElements = element.querySelectorAll(
            'a[href], button, textarea, input[type="text"], input[type="search"], select'
        );
        const firstFocusable = focusableElements[0];
        const lastFocusable = focusableElements[focusableElements.length - 1];

        element.addEventListener('keydown', function(e) {
            if (e.key !== 'Tab') return;

            if (e.shiftKey) {
                if (document.activeElement === firstFocusable) {
                    e.preventDefault();
                    lastFocusable.focus();
                }
            } else {
                if (document.activeElement === lastFocusable) {
                    e.preventDefault();
                    firstFocusable.focus();
                }
            }
        });
    }

    // Expose utility functions globally
    window.BPT = {
        throttle,
        debounce
    };

})();
