/**
 * Biblioteca pentru Toți - Customizer Live Preview
 * 
 * Handles real-time preview updates in the WordPress Customizer
 * 
 * @package Biblioteca_Pentru_Toti
 */

(function($) {
    'use strict';

    // Bail if not in customizer preview
    if (typeof wp === 'undefined' || typeof wp.customize === 'undefined') {
        return;
    }

    /**
     * Helper: Update CSS custom property
     */
    function updateCSSProperty(property, value) {
        document.documentElement.style.setProperty(property, value);
    }

    /**
     * Helper: Update inline style
     */
    function updateInlineStyle(selector, property, value) {
        $(selector).css(property, value);
    }

    /**
     * Helper: Update text content
     */
    function updateText(selector, value) {
        $(selector).text(value);
    }

    /**
     * Helper: Update HTML content
     */
    function updateHTML(selector, value) {
        $(selector).html(value);
    }

    /**
     * Helper: Toggle visibility
     */
    function toggleVisibility(selector, show) {
        $(selector).toggle(show);
    }

    /**
     * Helper: Update image source
     */
    function updateImage(selector, value) {
        if (value) {
            $(selector).attr('src', value).show();
        } else {
            $(selector).hide();
        }
    }

    // =========================================================================
    // Site Identity
    // =========================================================================

    // Site Title
    wp.customize('blogname', function(value) {
        value.bind(function(newval) {
            $('.site-title a').text(newval);
        });
    });

    // Site Description
    wp.customize('blogdescription', function(value) {
        value.bind(function(newval) {
            $('.site-description').text(newval);
        });
    });

    // =========================================================================
    // Colors Section
    // =========================================================================

    // Primary Color
    wp.customize('bpt_primary_color', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--color-primary', newval);
            updateCSSProperty('--color-primary-rgb', hexToRGB(newval));
        });
    });

    // Secondary Color
    wp.customize('bpt_secondary_color', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--color-secondary', newval);
        });
    });

    // Accent Color
    wp.customize('bpt_accent_color', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--color-accent', newval);
        });
    });

    // Background Color
    wp.customize('bpt_background_color', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--color-background', newval);
            $('body').css('background-color', newval);
        });
    });

    // Text Color
    wp.customize('bpt_text_color', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--color-text', newval);
            $('body').css('color', newval);
        });
    });

    // Link Color
    wp.customize('bpt_link_color', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--color-link', newval);
        });
    });

    // Link Hover Color
    wp.customize('bpt_link_hover_color', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--color-link-hover', newval);
        });
    });

    // =========================================================================
    // Typography Section
    // =========================================================================

    // Body Font Family
    wp.customize('bpt_body_font', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--font-body', newval);
            $('body').css('font-family', newval);
        });
    });

    // Heading Font Family
    wp.customize('bpt_heading_font', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--font-heading', newval);
            $('h1, h2, h3, h4, h5, h6, .site-title').css('font-family', newval);
        });
    });

    // Base Font Size
    wp.customize('bpt_base_font_size', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--font-size-base', newval + 'px');
            $('html').css('font-size', newval + 'px');
        });
    });

    // Line Height
    wp.customize('bpt_line_height', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--line-height-base', newval);
            $('body').css('line-height', newval);
        });
    });

    // =========================================================================
    // Hero Section
    // =========================================================================

    // Hero Title
    wp.customize('bpt_hero_title', function(value) {
        value.bind(function(newval) {
            $('.hero__title').text(newval);
        });
    });

    // Hero Subtitle
    wp.customize('bpt_hero_subtitle', function(value) {
        value.bind(function(newval) {
            $('.hero__subtitle').text(newval);
        });
    });

    // Hero Background Image
    wp.customize('bpt_hero_background', function(value) {
        value.bind(function(newval) {
            if (newval) {
                $('.hero').css('background-image', 'url(' + newval + ')');
            } else {
                $('.hero').css('background-image', 'none');
            }
        });
    });

    // Hero Background Overlay Opacity
    wp.customize('bpt_hero_overlay_opacity', function(value) {
        value.bind(function(newval) {
            $('.hero::before').css('opacity', newval / 100);
            // Since we can't target pseudo-elements directly, inject a style
            updateOrCreateStyle('hero-overlay', '.hero::before { opacity: ' + (newval / 100) + ' !important; }');
        });
    });

    // Hero Height
    wp.customize('bpt_hero_height', function(value) {
        value.bind(function(newval) {
            $('.hero').css('min-height', newval + 'vh');
        });
    });

    // Hero CTA Button Text
    wp.customize('bpt_hero_cta_text', function(value) {
        value.bind(function(newval) {
            $('.hero__cta .btn--primary').text(newval);
        });
    });

    // Hero Secondary Button Text
    wp.customize('bpt_hero_secondary_text', function(value) {
        value.bind(function(newval) {
            $('.hero__cta .btn--secondary').text(newval);
        });
    });

    // Show Hero Stats
    wp.customize('bpt_show_hero_stats', function(value) {
        value.bind(function(newval) {
            toggleVisibility('.hero__stats', newval);
        });
    });

    // =========================================================================
    // Layout Section
    // =========================================================================

    // Container Width
    wp.customize('bpt_container_width', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--container-width', newval + 'px');
            $('.container').css('max-width', newval + 'px');
        });
    });

    // Sidebar Position
    wp.customize('bpt_sidebar_position', function(value) {
        value.bind(function(newval) {
            $('body').removeClass('sidebar-left sidebar-right sidebar-none');
            $('body').addClass('sidebar-' + newval);
        });
    });

    // Grid Columns
    wp.customize('bpt_grid_columns', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--grid-columns', newval);
        });
    });

    // Grid Gap
    wp.customize('bpt_grid_gap', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--grid-gap', newval + 'px');
            $('.books-grid, .cards-grid').css('gap', newval + 'px');
        });
    });

    // =========================================================================
    // Header Section
    // =========================================================================

    // Header Background Color
    wp.customize('bpt_header_bg_color', function(value) {
        value.bind(function(newval) {
            $('.site-header').css('background-color', newval);
        });
    });

    // Header Text Color
    wp.customize('bpt_header_text_color', function(value) {
        value.bind(function(newval) {
            $('.site-header, .site-header a, .main-navigation a').css('color', newval);
        });
    });

    // Sticky Header
    wp.customize('bpt_sticky_header', function(value) {
        value.bind(function(newval) {
            $('body').toggleClass('has-sticky-header', newval);
            $('.site-header').toggleClass('is-sticky', newval);
        });
    });

    // Show Search in Header
    wp.customize('bpt_show_header_search', function(value) {
        value.bind(function(newval) {
            toggleVisibility('.header-search', newval);
        });
    });

    // =========================================================================
    // Footer Section
    // =========================================================================

    // Footer Background Color
    wp.customize('bpt_footer_bg_color', function(value) {
        value.bind(function(newval) {
            $('.site-footer').css('background-color', newval);
        });
    });

    // Footer Text Color
    wp.customize('bpt_footer_text_color', function(value) {
        value.bind(function(newval) {
            $('.site-footer, .site-footer a').css('color', newval);
        });
    });

    // Copyright Text
    wp.customize('bpt_copyright_text', function(value) {
        value.bind(function(newval) {
            $('.footer-copyright').text(newval);
        });
    });

    // Show Footer Widgets
    wp.customize('bpt_show_footer_widgets', function(value) {
        value.bind(function(newval) {
            toggleVisibility('.footer-widgets', newval);
        });
    });

    // =========================================================================
    // Book Archive Section
    // =========================================================================

    // Books Per Page (requires refresh)
    // This setting requires a full refresh since it affects the query

    // Default View Mode
    wp.customize('bpt_default_view', function(value) {
        value.bind(function(newval) {
            $('.books-grid').removeClass('view-grid view-list').addClass('view-' + newval);
            $('.view-toggle__btn').removeClass('is-active');
            $('.view-toggle__btn[data-view="' + newval + '"]').addClass('is-active');
        });
    });

    // Show Filter Sidebar
    wp.customize('bpt_show_filters', function(value) {
        value.bind(function(newval) {
            toggleVisibility('.filters-sidebar', newval);
        });
    });

    // Card Style
    wp.customize('bpt_card_style', function(value) {
        value.bind(function(newval) {
            $('.card-carte').removeClass('style-minimal style-detailed style-cover').addClass('style-' + newval);
        });
    });

    // Show BPT Numbers
    wp.customize('bpt_show_bpt_numbers', function(value) {
        value.bind(function(newval) {
            toggleVisibility('.card-carte__number, .bpt-number', newval);
        });
    });

    // =========================================================================
    // Timeline Section
    // =========================================================================

    // Timeline Style
    wp.customize('bpt_timeline_style', function(value) {
        value.bind(function(newval) {
            $('.cronologie-timeline').removeClass('style-vertical style-horizontal style-alternating').addClass('style-' + newval);
        });
    });

    // Timeline Line Color
    wp.customize('bpt_timeline_color', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--timeline-color', newval);
            $('.cronologie-timeline__line').css('background-color', newval);
        });
    });

    // Timeline Dot Color
    wp.customize('bpt_timeline_dot_color', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--timeline-dot-color', newval);
            $('.timeline-item__marker').css('background-color', newval);
        });
    });

    // =========================================================================
    // Performance Section
    // =========================================================================

    // Enable Animations
    wp.customize('bpt_enable_animations', function(value) {
        value.bind(function(newval) {
            $('body').toggleClass('animations-enabled', newval);
            $('body').toggleClass('animations-disabled', !newval);
        });
    });

    // Enable Lazy Loading
    wp.customize('bpt_lazy_loading', function(value) {
        value.bind(function(newval) {
            if (newval) {
                $('img[data-src]').each(function() {
                    // Re-enable lazy loading
                    $(this).attr('loading', 'lazy');
                });
            } else {
                // Load all images immediately
                $('img[data-src]').each(function() {
                    var src = $(this).data('src');
                    if (src) {
                        $(this).attr('src', src);
                    }
                });
            }
        });
    });

    // =========================================================================
    // Epoca Colors (Dynamic)
    // =========================================================================

    // Listen for epoca color changes
    ['veche', 'pasoptista', 'moderna', 'interbelica', 'contemporana'].forEach(function(epoca) {
        wp.customize('bpt_epoca_color_' + epoca, function(value) {
            value.bind(function(newval) {
                updateCSSProperty('--epoca-' + epoca, newval);
                $('.epoca-' + epoca + ', [data-epoca="' + epoca + '"]').css('--epoca-color', newval);
            });
        });
    });

    // =========================================================================
    // Helper Functions
    // =========================================================================

    /**
     * Convert hex color to RGB values
     */
    function hexToRGB(hex) {
        var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? 
            parseInt(result[1], 16) + ', ' + 
            parseInt(result[2], 16) + ', ' + 
            parseInt(result[3], 16) : 
            '0, 0, 0';
    }

    /**
     * Update or create a dynamic style element
     */
    function updateOrCreateStyle(id, css) {
        var styleId = 'bpt-customizer-' + id;
        var $style = $('#' + styleId);
        
        if ($style.length === 0) {
            $style = $('<style id="' + styleId + '"></style>');
            $('head').append($style);
        }
        
        $style.text(css);
    }

    /**
     * Debounce function for performance
     */
    function debounce(func, wait) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                func.apply(context, args);
            }, wait);
        };
    }

    // =========================================================================
    // Selective Refresh Partials
    // =========================================================================

    // These are handled automatically by WordPress when registered with
    // selective_refresh in the customizer.php file

    // Handle custom partial refresh events
    wp.customize.selectiveRefresh.bind('partial-content-rendered', function(placement) {
        // Re-initialize animations after partial refresh
        if (typeof window.BPTAnimations !== 'undefined') {
            window.BPTAnimations.refresh();
        }

        // Re-initialize specific components based on partial
        var partialId = placement.partial.id;
        
        if (partialId.indexOf('hero') !== -1) {
            // Re-init hero animations
            $('.hero').addClass('is-loaded');
        }
        
        if (partialId.indexOf('stats') !== -1) {
            // Re-init counter animations
            if (typeof window.BPTAnimations !== 'undefined') {
                window.BPTAnimations.init();
            }
        }
    });

    // =========================================================================
    // Customizer Panel Events
    // =========================================================================

    // Scroll to section when panel is opened
    wp.customize.panel('bpt_hero_panel', function(panel) {
        panel.expanded.bind(function(isExpanded) {
            if (isExpanded) {
                scrollToElement('.hero');
            }
        });
    });

    wp.customize.panel('bpt_header_panel', function(panel) {
        panel.expanded.bind(function(isExpanded) {
            if (isExpanded) {
                scrollToElement('.site-header');
            }
        });
    });

    wp.customize.panel('bpt_footer_panel', function(panel) {
        panel.expanded.bind(function(isExpanded) {
            if (isExpanded) {
                scrollToElement('.site-footer');
            }
        });
    });

    // Scroll to section when specific sections are opened
    wp.customize.section('bpt_timeline_section', function(section) {
        section.expanded.bind(function(isExpanded) {
            if (isExpanded) {
                scrollToElement('.cronologie-timeline');
            }
        });
    });

    /**
     * Smooth scroll to element in preview
     */
    function scrollToElement(selector) {
        var $element = $(selector);
        if ($element.length) {
            $('html, body').animate({
                scrollTop: $element.offset().top - 100
            }, 500);
        }
    }

    // =========================================================================
    // Device Preview Adjustments
    // =========================================================================

    // Adjust preview based on device
    wp.customize.previewedDevice.bind(function(device) {
        // Add device class to body for testing
        $('body').removeClass('preview-desktop preview-tablet preview-mobile');
        $('body').addClass('preview-' + device);
    });

})(jQuery);
