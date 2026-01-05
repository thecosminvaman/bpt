/**
 * Biblioteca pentru Toți - Scroll Animations
 * 
 * Enhanced scroll-based animations using GSAP and ScrollTrigger
 * with graceful fallback to IntersectionObserver
 * 
 * @package Biblioteca_Pentru_Toti
 */

(function() {
    'use strict';

    /**
     * Check if GSAP and ScrollTrigger are available
     */
    const hasGSAP = typeof gsap !== 'undefined';
    const hasScrollTrigger = hasGSAP && typeof ScrollTrigger !== 'undefined';

    /**
     * Respect reduced motion preferences
     */
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /**
     * Animation configuration
     */
    const config = {
        fadeUp: {
            y: 40,
            opacity: 0,
            duration: 0.8,
            ease: 'power2.out'
        },
        fadeIn: {
            opacity: 0,
            duration: 0.6,
            ease: 'power1.out'
        },
        stagger: {
            amount: 0.4,
            from: 'start'
        },
        scrollTrigger: {
            start: 'top 85%',
            end: 'bottom 15%',
            toggleActions: 'play none none reverse'
        }
    };

    /**
     * Initialize all animations
     */
    function init() {
        if (prefersReducedMotion) {
            // Show all elements immediately without animation
            document.querySelectorAll('[data-animate]').forEach(el => {
                el.style.opacity = '1';
                el.style.transform = 'none';
            });
            return;
        }

        if (hasGSAP && hasScrollTrigger) {
            initGSAPAnimations();
        } else {
            initFallbackAnimations();
        }

        // Initialize special effects
        initParallax();
        initRevealText();
        initCounterAnimations();
        initImageEffects();
    }

    /**
     * GSAP-based animations
     */
    function initGSAPAnimations() {
        gsap.registerPlugin(ScrollTrigger);

        // Fade up animations
        gsap.utils.toArray('[data-animate="fade-up"]').forEach(element => {
            gsap.from(element, {
                ...config.fadeUp,
                scrollTrigger: {
                    trigger: element,
                    ...config.scrollTrigger
                }
            });
        });

        // Fade in animations
        gsap.utils.toArray('[data-animate="fade-in"]').forEach(element => {
            gsap.from(element, {
                ...config.fadeIn,
                scrollTrigger: {
                    trigger: element,
                    ...config.scrollTrigger
                }
            });
        });

        // Staggered grid items
        gsap.utils.toArray('[data-animate="stagger-grid"]').forEach(container => {
            const items = container.querySelectorAll('.card, .grid-item, article');
            
            gsap.from(items, {
                ...config.fadeUp,
                stagger: config.stagger,
                scrollTrigger: {
                    trigger: container,
                    ...config.scrollTrigger
                }
            });
        });

        // Slide from left
        gsap.utils.toArray('[data-animate="slide-left"]').forEach(element => {
            gsap.from(element, {
                x: -60,
                opacity: 0,
                duration: 0.8,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: element,
                    ...config.scrollTrigger
                }
            });
        });

        // Slide from right
        gsap.utils.toArray('[data-animate="slide-right"]').forEach(element => {
            gsap.from(element, {
                x: 60,
                opacity: 0,
                duration: 0.8,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: element,
                    ...config.scrollTrigger
                }
            });
        });

        // Scale up
        gsap.utils.toArray('[data-animate="scale-up"]').forEach(element => {
            gsap.from(element, {
                scale: 0.8,
                opacity: 0,
                duration: 0.6,
                ease: 'back.out(1.7)',
                scrollTrigger: {
                    trigger: element,
                    ...config.scrollTrigger
                }
            });
        });

        // Hero section special animation
        const heroSection = document.querySelector('.hero');
        if (heroSection) {
            const heroTimeline = gsap.timeline();
            
            heroTimeline
                .from('.hero__title', {
                    y: 30,
                    opacity: 0,
                    duration: 1,
                    ease: 'power3.out'
                })
                .from('.hero__subtitle', {
                    y: 20,
                    opacity: 0,
                    duration: 0.8,
                    ease: 'power2.out'
                }, '-=0.5')
                .from('.hero__cta', {
                    y: 20,
                    opacity: 0,
                    duration: 0.6
                }, '-=0.4')
                .from('.hero__stats .stat', {
                    y: 15,
                    opacity: 0,
                    stagger: 0.1,
                    duration: 0.5
                }, '-=0.3');
        }

        // Book cards hover animation enhancement
        document.querySelectorAll('.card-carte').forEach(card => {
            const cover = card.querySelector('.card-carte__cover img');
            const overlay = card.querySelector('.card-carte__overlay');
            
            if (cover && overlay) {
                card.addEventListener('mouseenter', () => {
                    gsap.to(cover, {
                        scale: 1.05,
                        duration: 0.4,
                        ease: 'power2.out'
                    });
                });
                
                card.addEventListener('mouseleave', () => {
                    gsap.to(cover, {
                        scale: 1,
                        duration: 0.3,
                        ease: 'power2.inOut'
                    });
                });
            }
        });

        // Epoch timeline animation
        const epochItems = document.querySelectorAll('.epoca-item');
        if (epochItems.length) {
            gsap.from(epochItems, {
                opacity: 0,
                y: 30,
                stagger: 0.15,
                duration: 0.6,
                scrollTrigger: {
                    trigger: epochItems[0].parentElement,
                    start: 'top 80%'
                }
            });
        }
    }

    /**
     * Fallback animations using IntersectionObserver
     */
    function initFallbackAnimations() {
        const observerOptions = {
            root: null,
            rootMargin: '0px 0px -15% 0px',
            threshold: 0.1
        };

        const animationObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    const animationType = element.dataset.animate;
                    
                    // Add appropriate CSS class
                    element.classList.add('is-animated');
                    element.classList.add(`animate-${animationType}`);
                    
                    // Unobserve after animation
                    animationObserver.unobserve(element);
                }
            });
        }, observerOptions);

        // Observe all animated elements
        document.querySelectorAll('[data-animate]').forEach(element => {
            // Set initial state
            element.style.opacity = '0';
            animationObserver.observe(element);
        });

        // Handle stagger grid separately
        document.querySelectorAll('[data-animate="stagger-grid"]').forEach(container => {
            const items = container.querySelectorAll('.card, .grid-item, article');
            
            const gridObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        items.forEach((item, index) => {
                            setTimeout(() => {
                                item.classList.add('is-animated');
                                item.style.opacity = '1';
                                item.style.transform = 'translateY(0)';
                            }, index * 100);
                        });
                        gridObserver.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Set initial state for items
            items.forEach(item => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(40px)';
                item.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            });

            gridObserver.observe(container);
        });
    }

    /**
     * Parallax effects
     */
    function initParallax() {
        if (prefersReducedMotion) return;

        const parallaxElements = document.querySelectorAll('[data-parallax]');
        
        if (!parallaxElements.length) return;

        if (hasGSAP && hasScrollTrigger) {
            parallaxElements.forEach(element => {
                const speed = parseFloat(element.dataset.parallax) || 0.5;
                const direction = element.dataset.parallaxDirection || 'y';
                
                gsap.to(element, {
                    [direction]: () => speed * 100,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: element.parentElement || element,
                        start: 'top bottom',
                        end: 'bottom top',
                        scrub: true
                    }
                });
            });
        } else {
            // Simple CSS-based parallax fallback
            let ticking = false;

            window.addEventListener('scroll', () => {
                if (!ticking) {
                    requestAnimationFrame(() => {
                        const scrolled = window.pageYOffset;
                        
                        parallaxElements.forEach(element => {
                            const speed = parseFloat(element.dataset.parallax) || 0.5;
                            const rect = element.getBoundingClientRect();
                            
                            if (rect.top < window.innerHeight && rect.bottom > 0) {
                                const yPos = -(scrolled * speed);
                                element.style.transform = `translate3d(0, ${yPos}px, 0)`;
                            }
                        });
                        
                        ticking = false;
                    });
                    ticking = true;
                }
            });
        }
    }

    /**
     * Text reveal animations
     */
    function initRevealText() {
        if (prefersReducedMotion) return;

        const revealElements = document.querySelectorAll('[data-reveal-text]');
        
        if (!revealElements.length) return;

        revealElements.forEach(element => {
            const text = element.textContent;
            const words = text.split(' ');
            
            // Wrap each word in a span
            element.innerHTML = words.map(word => 
                `<span class="reveal-word"><span class="reveal-word__inner">${word}</span></span>`
            ).join(' ');

            if (hasGSAP && hasScrollTrigger) {
                const innerWords = element.querySelectorAll('.reveal-word__inner');
                
                gsap.from(innerWords, {
                    y: '100%',
                    opacity: 0,
                    stagger: 0.03,
                    duration: 0.5,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: element,
                        start: 'top 85%'
                    }
                });
            } else {
                // CSS fallback
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            element.classList.add('is-revealed');
                            observer.unobserve(element);
                        }
                    });
                }, { threshold: 0.1 });

                observer.observe(element);
            }
        });
    }

    /**
     * Counter animations (for statistics)
     */
    function initCounterAnimations() {
        const counters = document.querySelectorAll('[data-counter]');
        
        if (!counters.length) return;

        const animateCounter = (element) => {
            const target = parseInt(element.dataset.counter, 10);
            const duration = parseInt(element.dataset.counterDuration, 10) || 2000;
            const startTime = performance.now();
            
            const updateCounter = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                
                // Easing function (ease-out)
                const easeOut = 1 - Math.pow(1 - progress, 3);
                const current = Math.round(easeOut * target);
                
                element.textContent = current.toLocaleString('ro-RO');
                
                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                }
            };
            
            requestAnimationFrame(updateCounter);
        };

        if (prefersReducedMotion) {
            counters.forEach(counter => {
                counter.textContent = parseInt(counter.dataset.counter, 10).toLocaleString('ro-RO');
            });
            return;
        }

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(counter => {
            counter.textContent = '0';
            counterObserver.observe(counter);
        });
    }

    /**
     * Image effects (lazy load with animation)
     */
    function initImageEffects() {
        const images = document.querySelectorAll('[data-lazy-animate]');
        
        if (!images.length) return;

        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    const src = img.dataset.src;
                    
                    if (src) {
                        img.src = src;
                        img.removeAttribute('data-src');
                    }
                    
                    img.addEventListener('load', () => {
                        img.classList.add('is-loaded');
                        
                        if (hasGSAP && !prefersReducedMotion) {
                            gsap.from(img, {
                                opacity: 0,
                                scale: 1.05,
                                duration: 0.6,
                                ease: 'power2.out'
                            });
                        }
                    });
                    
                    imageObserver.unobserve(img);
                }
            });
        }, {
            rootMargin: '50px 0px',
            threshold: 0.01
        });

        images.forEach(img => imageObserver.observe(img));
    }

    /**
     * Magnetic button effect
     */
    function initMagneticButtons() {
        if (prefersReducedMotion) return;

        const buttons = document.querySelectorAll('[data-magnetic]');
        
        buttons.forEach(button => {
            button.addEventListener('mousemove', (e) => {
                const rect = button.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;
                
                const strength = parseFloat(button.dataset.magnetic) || 0.3;
                
                if (hasGSAP) {
                    gsap.to(button, {
                        x: x * strength,
                        y: y * strength,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                } else {
                    button.style.transform = `translate(${x * strength}px, ${y * strength}px)`;
                }
            });
            
            button.addEventListener('mouseleave', () => {
                if (hasGSAP) {
                    gsap.to(button, {
                        x: 0,
                        y: 0,
                        duration: 0.5,
                        ease: 'elastic.out(1, 0.5)'
                    });
                } else {
                    button.style.transform = 'translate(0, 0)';
                }
            });
        });
    }

    /**
     * Scroll progress indicator
     */
    function initScrollProgress() {
        const progressBar = document.querySelector('[data-scroll-progress]');
        
        if (!progressBar) return;

        const updateProgress = () => {
            const scrollTop = window.pageYOffset;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const progress = (scrollTop / docHeight) * 100;
            
            progressBar.style.width = `${progress}%`;
        };

        window.addEventListener('scroll', () => {
            requestAnimationFrame(updateProgress);
        }, { passive: true });
    }

    /**
     * Smooth anchor scrolling
     */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                const targetId = anchor.getAttribute('href');
                
                if (targetId === '#') return;
                
                const target = document.querySelector(targetId);
                
                if (target) {
                    e.preventDefault();
                    
                    const headerOffset = document.querySelector('.site-header')?.offsetHeight || 0;
                    const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerOffset - 20;
                    
                    if (hasGSAP) {
                        gsap.to(window, {
                            scrollTo: targetPosition,
                            duration: 1,
                            ease: 'power2.inOut'
                        });
                    } else {
                        window.scrollTo({
                            top: targetPosition,
                            behavior: prefersReducedMotion ? 'auto' : 'smooth'
                        });
                    }
                    
                    // Update URL without triggering scroll
                    history.pushState(null, null, targetId);
                }
            });
        });
    }

    /**
     * Page transition effects
     */
    function initPageTransitions() {
        if (prefersReducedMotion) return;

        // Fade in on page load
        document.body.classList.add('page-loaded');

        // Handle link clicks for page transitions
        document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not([href^="mailto:"]):not([href^="tel:"])').forEach(link => {
            link.addEventListener('click', (e) => {
                const href = link.getAttribute('href');
                
                // Skip if modifier key pressed
                if (e.metaKey || e.ctrlKey || e.shiftKey) return;
                
                // Skip external links
                if (href.startsWith('http') && !href.includes(window.location.hostname)) return;
                
                e.preventDefault();
                
                document.body.classList.add('page-leaving');
                
                setTimeout(() => {
                    window.location.href = href;
                }, 300);
            });
        });
    }

    /**
     * Refresh ScrollTrigger on dynamic content
     */
    function refreshScrollTrigger() {
        if (hasScrollTrigger) {
            ScrollTrigger.refresh();
        }
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Re-initialize on AJAX content load
    document.addEventListener('bpt:contentLoaded', () => {
        if (hasScrollTrigger) {
            ScrollTrigger.refresh();
        }
        initCounterAnimations();
        initImageEffects();
    });

    // Expose refresh function globally
    window.BPTAnimations = {
        refresh: refreshScrollTrigger,
        init: init
    };

})();
