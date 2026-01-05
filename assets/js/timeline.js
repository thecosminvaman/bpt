/**
 * Timeline JavaScript
 * 
 * Timeline animations and interactions using GSAP
 * 
 * @package Biblioteca_Pentru_Toti
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', initTimeline);

    function initTimeline() {
        // Check if GSAP is available
        if (typeof gsap === 'undefined') {
            console.warn('GSAP not loaded. Timeline animations disabled.');
            initBasicTimeline();
            return;
        }

        // Register ScrollTrigger
        if (typeof ScrollTrigger !== 'undefined') {
            gsap.registerPlugin(ScrollTrigger);
        }

        initTimelineAnimations();
        initTimelineLine();
        initYearMarkers();
        initParallaxEffects();
    }

    /**
     * Basic Timeline (no GSAP)
     */
    function initBasicTimeline() {
        const items = document.querySelectorAll('.timeline-item');
        
        // Simple intersection observer for fade-in
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                }
            });
        }, { threshold: 0.1 });

        items.forEach(item => observer.observe(item));
    }

    /**
     * Timeline Animations with GSAP
     */
    function initTimelineAnimations() {
        const items = document.querySelectorAll('.timeline-item');
        
        if (!items.length) return;

        // Set initial state
        gsap.set(items, {
            opacity: 0,
            y: 60
        });

        // Animate each item on scroll
        items.forEach((item, index) => {
            gsap.to(item, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: item,
                    start: 'top 85%',
                    end: 'bottom 15%',
                    toggleActions: 'play none none reverse'
                }
            });

            // Stagger marker dots
            const marker = item.querySelector('.timeline-dot');
            if (marker) {
                gsap.fromTo(marker, 
                    { scale: 0 },
                    {
                        scale: 1,
                        duration: 0.4,
                        ease: 'back.out(2)',
                        scrollTrigger: {
                            trigger: item,
                            start: 'top 80%',
                            toggleActions: 'play none none reverse'
                        }
                    }
                );
            }
        });

        // Animate content blocks
        items.forEach(item => {
            const content = item.querySelector('.timeline-content');
            if (content) {
                gsap.fromTo(content,
                    { opacity: 0, x: item.classList.contains('timeline-item-left') ? -30 : 30 },
                    {
                        opacity: 1,
                        x: 0,
                        duration: 0.6,
                        ease: 'power2.out',
                        scrollTrigger: {
                            trigger: item,
                            start: 'top 80%',
                            toggleActions: 'play none none reverse'
                        }
                    }
                );
            }
        });
    }

    /**
     * Animated Timeline Line
     */
    function initTimelineLine() {
        const line = document.querySelector('.timeline-line');
        
        if (!line) return;

        // Create progress indicator
        const progress = document.createElement('div');
        progress.className = 'timeline-line-progress';
        line.appendChild(progress);

        // Animate line on scroll
        gsap.to(progress, {
            height: '100%',
            ease: 'none',
            scrollTrigger: {
                trigger: '.timeline',
                start: 'top center',
                end: 'bottom center',
                scrub: true
            }
        });
    }

    /**
     * Year Markers
     */
    function initYearMarkers() {
        const markers = document.querySelectorAll('.timeline-year-marker');
        
        if (!markers.length) return;

        markers.forEach(marker => {
            gsap.fromTo(marker,
                { opacity: 0, scale: 0.8 },
                {
                    opacity: 1,
                    scale: 1,
                    duration: 0.5,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: marker,
                        start: 'top 75%',
                        toggleActions: 'play none none reverse'
                    }
                }
            );

            // Sticky behavior
            ScrollTrigger.create({
                trigger: marker,
                start: 'top 100px',
                endTrigger: marker.nextElementSibling?.classList.contains('timeline-year-marker') 
                    ? marker.nextElementSibling 
                    : '.timeline',
                end: 'top 100px',
                pin: true,
                pinSpacing: false,
                onEnter: () => marker.classList.add('is-sticky'),
                onLeaveBack: () => marker.classList.remove('is-sticky')
            });
        });
    }

    /**
     * Parallax Effects for Images
     */
    function initParallaxEffects() {
        const images = document.querySelectorAll('.timeline-image img');
        
        if (!images.length) return;

        images.forEach(img => {
            gsap.to(img, {
                yPercent: -10,
                ease: 'none',
                scrollTrigger: {
                    trigger: img.closest('.timeline-item'),
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: true
                }
            });
        });
    }

    /**
     * Navigate to Year
     */
    window.navigateToYear = function(year) {
        const marker = document.querySelector(`.timeline-year-marker[data-year="${year}"]`);
        
        if (marker) {
            const offset = 120;
            const elementPosition = marker.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - offset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }
    };

    /**
     * Timeline Filter by Decade
     */
    window.filterTimelineByDecade = function(decade) {
        const items = document.querySelectorAll('.timeline-item');
        const decadeStart = parseInt(decade, 10);
        const decadeEnd = decadeStart + 9;

        items.forEach(item => {
            const year = parseInt(item.dataset.year, 10);
            
            if (!decade || (year >= decadeStart && year <= decadeEnd)) {
                gsap.to(item, {
                    opacity: 1,
                    height: 'auto',
                    duration: 0.3,
                    display: 'flex'
                });
            } else {
                gsap.to(item, {
                    opacity: 0,
                    height: 0,
                    duration: 0.3,
                    display: 'none'
                });
            }
        });

        // Refresh ScrollTrigger
        setTimeout(() => {
            ScrollTrigger.refresh();
        }, 400);
    };

})();
