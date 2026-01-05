<?php
/**
 * Enqueue Scripts and Styles
 *
 * @package Biblioteca_Pentru_Toti
 */

defined('ABSPATH') || exit;

/**
 * Enqueue frontend styles and scripts
 */
function bpt_enqueue_scripts() {
    // Google Fonts
    wp_enqueue_style(
        'bpt-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Source+Serif+Pro:ital,wght@0,400;0,600;1,400&display=swap',
        [],
        null
    );

    // Main theme stylesheet
    wp_enqueue_style(
        'bpt-style',
        get_stylesheet_uri(),
        [],
        BPT_VERSION
    );

    // Main JavaScript
    wp_enqueue_script(
        'bpt-main',
        BPT_URI . '/assets/js/main.js',
        [],
        BPT_VERSION,
        true
    );

    // Localize script
    wp_localize_script('bpt-main', 'bptData', [
        'ajaxUrl'   => admin_url('admin-ajax.php'),
        'restUrl'   => rest_url('bpt/v1/'),
        'nonce'     => wp_create_nonce('bpt_nonce'),
        'i18n'      => [
            'loading'       => __('Se încarcă...', 'biblioteca-pentru-toti'),
            'noResults'     => __('Nu s-au găsit rezultate', 'biblioteca-pentru-toti'),
            'error'         => __('A apărut o eroare', 'biblioteca-pentru-toti'),
            'loadMore'      => __('Încarcă mai multe', 'biblioteca-pentru-toti'),
            'searchPlaceholder' => __('Caută cărți...', 'biblioteca-pentru-toti'),
        ],
    ]);

    // Timeline scripts (only on timeline page or homepage)
    if (is_page_template('templates/template-cronologie.php') || is_front_page()) {
        // GSAP
        wp_enqueue_script(
            'gsap',
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js',
            [],
            '3.12.2',
            true
        );

        wp_enqueue_script(
            'gsap-scrolltrigger',
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js',
            ['gsap'],
            '3.12.2',
            true
        );

        wp_enqueue_script(
            'bpt-timeline',
            BPT_URI . '/assets/js/timeline.js',
            ['gsap', 'gsap-scrolltrigger'],
            BPT_VERSION,
            true
        );
    }

    // Filters script (only on books archive)
    if (is_post_type_archive('carte') || is_page_template('templates/template-carti-archive.php')) {
        wp_enqueue_script(
            'bpt-filters',
            BPT_URI . '/assets/js/filters.js',
            ['bpt-main'],
            BPT_VERSION,
            true
        );

        wp_localize_script('bpt-filters', 'bptFilters', [
            'ajaxUrl'    => admin_url('admin-ajax.php'),
            'nonce'      => wp_create_nonce('bpt_filter_nonce'),
            'perPage'    => get_theme_mod('bpt_books_per_page', 12),
            'defaultSort' => get_theme_mod('bpt_default_sort', 'nr_bpt'),
        ]);
    }

    // Animations script
    wp_enqueue_script(
        'bpt-animations',
        BPT_URI . '/assets/js/animations.js',
        ['bpt-main'],
        BPT_VERSION,
        true
    );

    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'bpt_enqueue_scripts');

/**
 * Enqueue admin styles and scripts
 */
function bpt_admin_enqueue_scripts($hook) {
    global $post_type;

    // Admin styles for CPTs
    if (in_array($post_type, ['carte', 'eveniment'])) {
        wp_enqueue_style(
            'bpt-admin',
            BPT_URI . '/assets/css/admin.css',
            [],
            BPT_VERSION
        );
    }

    // Color picker for taxonomy pages
    if ($hook === 'edit-tags.php' || $hook === 'term.php') {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
    }
}
add_action('admin_enqueue_scripts', 'bpt_admin_enqueue_scripts');

/**
 * Add preload for critical fonts
 */
function bpt_preload_fonts() {
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php
}
add_action('wp_head', 'bpt_preload_fonts', 1);

/**
 * Add editor styles
 */
function bpt_add_editor_styles() {
    add_editor_style([
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Source+Serif+Pro:ital,wght@0,400;0,600;1,400&display=swap',
        'assets/css/editor-style.css'
    ]);
}
add_action('admin_init', 'bpt_add_editor_styles');

/**
 * Dequeue unnecessary scripts
 */
function bpt_dequeue_scripts() {
    // Remove jQuery migrate (if not needed)
    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', includes_url('/js/jquery/jquery.min.js'), [], null, true);
    }
}
// add_action('wp_enqueue_scripts', 'bpt_dequeue_scripts');

/**
 * Add async/defer attributes to scripts
 */
function bpt_script_loader_tag($tag, $handle, $src) {
    // Scripts to defer
    $defer_scripts = [
        'gsap',
        'gsap-scrolltrigger',
        'bpt-timeline',
        'bpt-animations',
    ];

    // Scripts to async
    $async_scripts = [];

    if (in_array($handle, $defer_scripts)) {
        return str_replace(' src', ' defer src', $tag);
    }

    if (in_array($handle, $async_scripts)) {
        return str_replace(' src', ' async src', $tag);
    }

    return $tag;
}
add_filter('script_loader_tag', 'bpt_script_loader_tag', 10, 3);

/**
 * Inline critical CSS
 */
function bpt_inline_critical_css() {
    $critical_css = '
        body{margin:0;font-family:"Source Serif Pro",Georgia,serif;background:#FDFBF7}
        .site-header{position:sticky;top:0;z-index:1000;background:#FDFBF7;border-bottom:1px solid #E5E2DA}
        .container{max-width:1280px;margin:0 auto;padding:0 1.5rem}
        h1,h2,h3{font-family:"Playfair Display",serif}
    ';
    
    if (apply_filters('bpt_inline_critical_css', true)) {
        echo '<style id="bpt-critical-css">' . $critical_css . '</style>';
    }
}
add_action('wp_head', 'bpt_inline_critical_css', 5);

/**
 * Remove WP emoji scripts
 */
function bpt_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'bpt_disable_emojis');

/**
 * Remove block library CSS if not using blocks
 */
function bpt_remove_wp_block_library_css() {
    // Keep enabled for Gutenberg support
    // wp_dequeue_style('wp-block-library');
    // wp_dequeue_style('wp-block-library-theme');
    // wp_dequeue_style('wc-blocks-style');
}
add_action('wp_enqueue_scripts', 'bpt_remove_wp_block_library_css', 100);
