<?php
/**
 * Biblioteca pentru Toți Theme Functions
 *
 * @package Biblioteca_Pentru_Toti
 * @version 1.0.0
 */

defined('ABSPATH') || exit;

/**
 * Theme Constants
 */
define('BPT_VERSION', '1.0.0');
define('BPT_DIR', get_template_directory());
define('BPT_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function bpt_setup() {
    // Make theme available for translation
    load_theme_textdomain('biblioteca-pentru-toti', BPT_DIR . '/languages');

    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Custom image sizes
    add_image_size('bpt-book-cover', 400, 600, true);
    add_image_size('bpt-book-cover-large', 600, 900, true);
    add_image_size('bpt-card', 400, 300, true);
    add_image_size('bpt-hero', 1200, 800, true);
    add_image_size('bpt-timeline', 600, 400, true);

    // Register nav menus
    register_nav_menus([
        'primary' => __('Meniu Principal', 'biblioteca-pentru-toti'),
        'footer'  => __('Meniu Footer', 'biblioteca-pentru-toti'),
    ]);

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);

    // Add support for custom logo
    add_theme_support('custom-logo', [
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    // Add support for Block Editor styles
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');

    // Add support for responsive embeds
    add_theme_support('responsive-embeds');

    // Add support for wide alignment
    add_theme_support('align-wide');

    // Custom background support
    add_theme_support('custom-background', [
        'default-color' => 'FDFBF7',
    ]);

    // Add support for Block Editor color palette
    add_theme_support('editor-color-palette', [
        ['name' => __('Burgundy', 'biblioteca-pentru-toti'), 'slug' => 'burgundy', 'color' => '#8B0000'],
        ['name' => __('Navy', 'biblioteca-pentru-toti'), 'slug' => 'navy', 'color' => '#1B365D'],
        ['name' => __('Green', 'biblioteca-pentru-toti'), 'slug' => 'green', 'color' => '#2D5A27'],
        ['name' => __('Gold', 'biblioteca-pentru-toti'), 'slug' => 'gold', 'color' => '#C5A572'],
        ['name' => __('Paper', 'biblioteca-pentru-toti'), 'slug' => 'paper', 'color' => '#FDFBF7'],
        ['name' => __('Secondary', 'biblioteca-pentru-toti'), 'slug' => 'secondary', 'color' => '#F5F3EE'],
    ]);
}
add_action('after_setup_theme', 'bpt_setup');

/**
 * Set the content width in pixels
 */
function bpt_content_width() {
    $GLOBALS['content_width'] = apply_filters('bpt_content_width', 800);
}
add_action('after_setup_theme', 'bpt_content_width', 0);

/**
 * Register widget areas
 */
function bpt_widgets_init() {
    register_sidebar([
        'name'          => __('Sidebar', 'biblioteca-pentru-toti'),
        'id'            => 'sidebar-1',
        'description'   => __('Zona de widget-uri pentru sidebar.', 'biblioteca-pentru-toti'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ]);

    register_sidebar([
        'name'          => __('Footer 1', 'biblioteca-pentru-toti'),
        'id'            => 'footer-1',
        'description'   => __('Prima zonă de widget-uri din footer.', 'biblioteca-pentru-toti'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget__title">',
        'after_title'   => '</h3>',
    ]);

    register_sidebar([
        'name'          => __('Footer 2', 'biblioteca-pentru-toti'),
        'id'            => 'footer-2',
        'description'   => __('A doua zonă de widget-uri din footer.', 'biblioteca-pentru-toti'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget__title">',
        'after_title'   => '</h3>',
    ]);

    register_sidebar([
        'name'          => __('Footer 3', 'biblioteca-pentru-toti'),
        'id'            => 'footer-3',
        'description'   => __('A treia zonă de widget-uri din footer.', 'biblioteca-pentru-toti'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget__title">',
        'after_title'   => '</h3>',
    ]);

    register_sidebar([
        'name'          => __('Footer 4', 'biblioteca-pentru-toti'),
        'id'            => 'footer-4',
        'description'   => __('A patra zonă de widget-uri din footer.', 'biblioteca-pentru-toti'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget__title">',
        'after_title'   => '</h3>',
    ]);
}
add_action('widgets_init', 'bpt_widgets_init');

/**
 * Include theme files
 */
require_once BPT_DIR . '/inc/custom-post-types.php';
require_once BPT_DIR . '/inc/taxonomies.php';
require_once BPT_DIR . '/inc/enqueue-scripts.php';
require_once BPT_DIR . '/inc/customizer.php';
require_once BPT_DIR . '/inc/template-functions.php';
require_once BPT_DIR . '/inc/ajax-handlers.php';

// ACF Fields (only if ACF is active)
if (class_exists('ACF')) {
    require_once BPT_DIR . '/inc/acf-fields.php';
}

/**
 * Epoch Colors
 */
function bpt_get_epoca_colors() {
    $default_colors = [
        'antichitate'  => ['bg' => '#F5E6D3', 'text' => '#5C4033'],
        'medieval'     => ['bg' => '#E8DCC8', 'text' => '#4A4035'],
        'renastere'    => ['bg' => '#FDF6E3', 'text' => '#5C4D2E'],
        'clasicism'    => ['bg' => '#E8EDF2', 'text' => '#2C3E50'],
        'romantism'    => ['bg' => '#F2E8E8', 'text' => '#6B3A3A'],
        'realism'      => ['bg' => '#E5E8E4', 'text' => '#3D4A3D'],
        'modernism'    => ['bg' => '#F0F0F0', 'text' => '#333333'],
        'contemporan'  => ['bg' => '#FFFFFF', 'text' => '#1A1A1A'],
    ];

    // Allow override via Customizer
    foreach ($default_colors as $slug => $colors) {
        $bg = get_theme_mod("bpt_color_epoca_{$slug}_bg", $colors['bg']);
        $text = get_theme_mod("bpt_color_epoca_{$slug}_text", $colors['text']);
        $default_colors[$slug] = ['bg' => $bg, 'text' => $text];
    }

    return apply_filters('bpt_epoca_colors', $default_colors);
}

/**
 * Genre Colors
 */
function bpt_get_gen_colors() {
    $default_colors = [
        'roman'     => '#8B0000',
        'poezie'    => '#1B365D',
        'teatru'    => '#6B3E26',
        'filosofie' => '#2D5A27',
        'memorii'   => '#705D84',
        'nuvele'    => '#C5A572',
        'eseu'      => '#4A6670',
    ];

    // Allow override via Customizer
    foreach ($default_colors as $slug => $color) {
        $default_colors[$slug] = get_theme_mod("bpt_color_gen_{$slug}", $color);
    }

    return apply_filters('bpt_gen_colors', $default_colors);
}

/**
 * Get color for a specific epoca term
 */
function bpt_get_epoca_color($term_slug) {
    $colors = bpt_get_epoca_colors();
    return $colors[$term_slug] ?? ['bg' => '#F5F3EE', 'text' => '#1A1A1A'];
}

/**
 * Get color for a specific gen term
 */
function bpt_get_gen_color($term_slug) {
    $colors = bpt_get_gen_colors();
    return $colors[$term_slug] ?? '#8B0000';
}

/**
 * Output dynamic CSS for colors
 */
function bpt_dynamic_colors_css() {
    $css = '<style id="bpt-dynamic-colors">';
    
    // Epoca colors as CSS variables
    foreach (bpt_get_epoca_colors() as $slug => $colors) {
        $css .= ":root { --epoca-{$slug}-bg: {$colors['bg']}; --epoca-{$slug}-text: {$colors['text']}; }";
    }
    
    // Gen colors as CSS variables
    foreach (bpt_get_gen_colors() as $slug => $color) {
        $css .= ":root { --gen-{$slug}: {$color}; }";
    }
    
    $css .= '</style>';
    
    echo $css;
}
add_action('wp_head', 'bpt_dynamic_colors_css');

/**
 * ACF Options Page
 */
function bpt_acf_options_page() {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page([
            'page_title'    => __('Setări Temă BPT', 'biblioteca-pentru-toti'),
            'menu_title'    => __('Setări BPT', 'biblioteca-pentru-toti'),
            'menu_slug'     => 'bpt-settings',
            'capability'    => 'edit_posts',
            'redirect'      => false,
            'icon_url'      => 'dashicons-book',
        ]);

        acf_add_options_sub_page([
            'page_title'    => __('Setări Homepage', 'biblioteca-pentru-toti'),
            'menu_title'    => __('Homepage', 'biblioteca-pentru-toti'),
            'parent_slug'   => 'bpt-settings',
        ]);

        acf_add_options_sub_page([
            'page_title'    => __('Setări Cronologie', 'biblioteca-pentru-toti'),
            'menu_title'    => __('Cronologie', 'biblioteca-pentru-toti'),
            'parent_slug'   => 'bpt-settings',
        ]);
    }
}
add_action('acf/init', 'bpt_acf_options_page');

/**
 * ACF JSON save point
 */
function bpt_acf_json_save_point($path) {
    return BPT_DIR . '/acf-json';
}
add_filter('acf/settings/save_json', 'bpt_acf_json_save_point');

/**
 * ACF JSON load point
 */
function bpt_acf_json_load_point($paths) {
    $paths[] = BPT_DIR . '/acf-json';
    return $paths;
}
add_filter('acf/settings/load_json', 'bpt_acf_json_load_point');

/**
 * Modify main query for carte archive
 */
function bpt_modify_carte_archive_query($query) {
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('carte')) {
        $query->set('posts_per_page', get_theme_mod('bpt_books_per_page', 12));
        
        // Default sort
        $orderby = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'nr_bpt';
        
        switch ($orderby) {
            case 'nr_bpt':
                $query->set('meta_key', 'nr_bpt');
                $query->set('orderby', 'meta_value_num');
                $query->set('order', 'ASC');
                break;
            case 'an_scriere':
                $query->set('meta_key', 'an_scriere');
                $query->set('orderby', 'meta_value_num');
                $query->set('order', 'ASC');
                break;
            case 'title':
                $query->set('orderby', 'title');
                $query->set('order', 'ASC');
                break;
            case 'date':
                $query->set('orderby', 'date');
                $query->set('order', 'DESC');
                break;
        }
    }

    return $query;
}
add_action('pre_get_posts', 'bpt_modify_carte_archive_query');

/**
 * Modify taxonomy archives
 */
function bpt_modify_taxonomy_archive_query($query) {
    if (!is_admin() && $query->is_main_query()) {
        if (is_tax('autor') || is_tax('gen_literar') || is_tax('epoca') || is_tax('limba_originala')) {
            $query->set('posts_per_page', get_theme_mod('bpt_books_per_page', 12));
        }
    }
}
add_action('pre_get_posts', 'bpt_modify_taxonomy_archive_query');

/**
 * Add body classes
 */
function bpt_body_classes($classes) {
    // Add class if sidebar is active
    if (is_active_sidebar('sidebar-1')) {
        $classes[] = 'has-sidebar';
    }

    // Add class for single carte
    if (is_singular('carte')) {
        $classes[] = 'single-carte-page';
    }

    // Add class for single eveniment
    if (is_singular('eveniment')) {
        $classes[] = 'single-eveniment-page';
    }

    return $classes;
}
add_filter('body_class', 'bpt_body_classes');

/**
 * Change excerpt length
 */
function bpt_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'bpt_excerpt_length');

/**
 * Change excerpt more
 */
function bpt_excerpt_more($more) {
    return '&hellip;';
}
add_filter('excerpt_more', 'bpt_excerpt_more');

/**
 * Allow SVG uploads
 */
function bpt_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'bpt_mime_types');

/**
 * Get stats for the collection
 */
function bpt_get_collection_stats() {
    $stats = get_transient('bpt_collection_stats');
    
    if (false === $stats) {
        $books_count = wp_count_posts('carte');
        $authors_count = wp_count_terms(['taxonomy' => 'autor', 'hide_empty' => true]);
        
        // Get years range
        global $wpdb;
        $years = $wpdb->get_row("
            SELECT MIN(pm.meta_value) as min_year, MAX(pm.meta_value) as max_year 
            FROM {$wpdb->postmeta} pm 
            JOIN {$wpdb->posts} p ON pm.post_id = p.ID 
            WHERE pm.meta_key = 'an_publicare_bpt' 
            AND p.post_type = 'carte' 
            AND p.post_status = 'publish'
        ");
        
        $stats = [
            'books'   => $books_count->publish ?? 0,
            'authors' => is_wp_error($authors_count) ? 0 : $authors_count,
            'years'   => $years ? ($years->max_year - $years->min_year + 1) : 37,
        ];
        
        set_transient('bpt_collection_stats', $stats, HOUR_IN_SECONDS);
    }
    
    return $stats;
}

/**
 * Clear stats transient when carte is updated
 */
function bpt_clear_stats_transient($post_id) {
    if (get_post_type($post_id) === 'carte') {
        delete_transient('bpt_collection_stats');
    }
}
add_action('save_post', 'bpt_clear_stats_transient');

/**
 * Fallback for ACF functions if ACF is not installed
 */
if (!function_exists('get_field')) {
    function get_field($field_name, $post_id = false) {
        if (!$post_id) {
            $post_id = get_the_ID();
        }
        return get_post_meta($post_id, $field_name, true);
    }
}

if (!function_exists('the_field')) {
    function the_field($field_name, $post_id = false) {
        echo esc_html(get_field($field_name, $post_id));
    }
}

if (!function_exists('have_rows')) {
    function have_rows($field_name, $post_id = false) {
        return false;
    }
}

if (!function_exists('the_row')) {
    function the_row() {
        return false;
    }
}

if (!function_exists('get_sub_field')) {
    function get_sub_field($field_name) {
        return '';
    }
}

/**
 * Add custom admin columns for Carte CPT
 */
function bpt_carte_admin_columns($columns) {
    $new_columns = [];
    foreach ($columns as $key => $value) {
        if ($key === 'title') {
            $new_columns[$key] = $value;
            $new_columns['nr_bpt'] = __('Nr. BPT', 'biblioteca-pentru-toti');
            $new_columns['autor'] = __('Autor', 'biblioteca-pentru-toti');
            $new_columns['an_scriere'] = __('An Scriere', 'biblioteca-pentru-toti');
        } else {
            $new_columns[$key] = $value;
        }
    }
    return $new_columns;
}
add_filter('manage_carte_posts_columns', 'bpt_carte_admin_columns');

/**
 * Populate custom admin columns for Carte CPT
 */
function bpt_carte_admin_columns_content($column, $post_id) {
    switch ($column) {
        case 'nr_bpt':
            $nr = get_field('nr_bpt', $post_id);
            echo $nr ? '#' . esc_html($nr) : '—';
            break;
        case 'autor':
            $terms = get_the_terms($post_id, 'autor');
            if ($terms && !is_wp_error($terms)) {
                $names = wp_list_pluck($terms, 'name');
                echo esc_html(implode(', ', $names));
            } else {
                echo '—';
            }
            break;
        case 'an_scriere':
            $an = get_field('an_scriere', $post_id);
            echo $an ? esc_html($an) : '—';
            break;
    }
}
add_action('manage_carte_posts_custom_column', 'bpt_carte_admin_columns_content', 10, 2);

/**
 * Make custom columns sortable
 */
function bpt_carte_sortable_columns($columns) {
    $columns['nr_bpt'] = 'nr_bpt';
    $columns['an_scriere'] = 'an_scriere';
    return $columns;
}
add_filter('manage_edit-carte_sortable_columns', 'bpt_carte_sortable_columns');

/**
 * Handle sorting by custom columns
 */
function bpt_carte_column_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    $orderby = $query->get('orderby');

    if ($orderby === 'nr_bpt') {
        $query->set('meta_key', 'nr_bpt');
        $query->set('orderby', 'meta_value_num');
    }

    if ($orderby === 'an_scriere') {
        $query->set('meta_key', 'an_scriere');
        $query->set('orderby', 'meta_value_num');
    }
}
add_action('pre_get_posts', 'bpt_carte_column_orderby');

/**
 * Disable WordPress default image sizes if needed
 */
function bpt_disable_default_image_sizes($sizes) {
    unset($sizes['medium_large']);
    return $sizes;
}
// add_filter('intermediate_image_sizes_advanced', 'bpt_disable_default_image_sizes');

/**
 * Add defer attribute to specific scripts
 */
function bpt_defer_scripts($tag, $handle, $src) {
    $defer_scripts = ['bpt-timeline', 'bpt-filters', 'bpt-animations'];
    
    if (in_array($handle, $defer_scripts)) {
        return '<script src="' . esc_url($src) . '" defer></script>';
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'bpt_defer_scripts', 10, 3);
