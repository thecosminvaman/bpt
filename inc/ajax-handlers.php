<?php
/**
 * AJAX Handlers
 * 
 * REST and AJAX endpoints for filtering, search, and autocomplete
 * 
 * @package Biblioteca_Pentru_Toti
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register AJAX actions
 */
add_action('wp_ajax_bpt_filter_books', 'bpt_ajax_filter_books');
add_action('wp_ajax_nopriv_bpt_filter_books', 'bpt_ajax_filter_books');

add_action('wp_ajax_bpt_autocomplete_authors', 'bpt_ajax_autocomplete_authors');
add_action('wp_ajax_nopriv_bpt_autocomplete_authors', 'bpt_ajax_autocomplete_authors');

add_action('wp_ajax_bpt_load_more_books', 'bpt_ajax_load_more_books');
add_action('wp_ajax_nopriv_bpt_load_more_books', 'bpt_ajax_load_more_books');

add_action('wp_ajax_bpt_search_books', 'bpt_ajax_search_books');
add_action('wp_ajax_nopriv_bpt_search_books', 'bpt_ajax_search_books');

/**
 * Filter Books via AJAX
 */
function bpt_ajax_filter_books() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'] ?? '', 'bpt_ajax_nonce')) {
        wp_send_json_error(['message' => 'Invalid nonce']);
    }

    // Build query args
    $args = [
        'post_type' => 'carte',
        'posts_per_page' => get_theme_mod('bpt_books_per_page', 24),
        'paged' => isset($_POST['paged']) ? absint($_POST['paged']) : 1,
    ];

    // Tax query
    $tax_query = [];

    // Epoca filter
    if (!empty($_POST['epoca'])) {
        $tax_query[] = [
            'taxonomy' => 'epoca',
            'field' => 'slug',
            'terms' => sanitize_text_field($_POST['epoca']),
        ];
    }

    // Gen filter
    if (!empty($_POST['gen'])) {
        $tax_query[] = [
            'taxonomy' => 'gen-literar',
            'field' => 'slug',
            'terms' => sanitize_text_field($_POST['gen']),
        ];
    }

    // Limba filter
    if (!empty($_POST['limba'])) {
        $tax_query[] = [
            'taxonomy' => 'limba-originala',
            'field' => 'slug',
            'terms' => sanitize_text_field($_POST['limba']),
        ];
    }

    // Autor filter
    if (!empty($_POST['autor'])) {
        $tax_query[] = [
            'taxonomy' => 'autor',
            'field' => 'slug',
            'terms' => sanitize_text_field($_POST['autor']),
        ];
    }

    if (!empty($tax_query)) {
        $tax_query['relation'] = 'AND';
        $args['tax_query'] = $tax_query;
    }

    // Meta query for year range
    $meta_query = [];

    if (!empty($_POST['an_min'])) {
        $meta_query[] = [
            'key' => 'an_publicare_bpt',
            'value' => absint($_POST['an_min']),
            'compare' => '>=',
            'type' => 'NUMERIC',
        ];
    }

    if (!empty($_POST['an_max'])) {
        $meta_query[] = [
            'key' => 'an_publicare_bpt',
            'value' => absint($_POST['an_max']),
            'compare' => '<=',
            'type' => 'NUMERIC',
        ];
    }

    if (!empty($meta_query)) {
        $meta_query['relation'] = 'AND';
        $args['meta_query'] = $meta_query;
    }

    // Search
    if (!empty($_POST['s'])) {
        $args['s'] = sanitize_text_field($_POST['s']);
    }

    // Sorting
    $orderby = sanitize_text_field($_POST['orderby'] ?? 'title');
    
    switch ($orderby) {
        case 'title':
            $args['orderby'] = 'title';
            $args['order'] = 'ASC';
            break;
        case 'title_desc':
            $args['orderby'] = 'title';
            $args['order'] = 'DESC';
            break;
        case 'nr_bpt':
            $args['meta_key'] = 'nr_bpt';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'ASC';
            break;
        case 'an_scriere':
            $args['meta_key'] = 'an_scriere';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'ASC';
            break;
        case 'an_publicare':
            $args['meta_key'] = 'an_publicare_bpt';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'ASC';
            break;
        default:
            $args['orderby'] = 'title';
            $args['order'] = 'ASC';
    }

    // Run query
    $query = new WP_Query($args);

    // Build HTML output
    ob_start();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            echo bpt_get_carte_card(get_the_ID(), 'medium');
        }
    } else {
        ?>
        <div class="no-results">
            <div class="no-results-icon">
                <?php echo bpt_icon('book'); ?>
            </div>
            <h2><?php esc_html_e('Nu am găsit cărți', 'flavor'); ?></h2>
            <p><?php esc_html_e('Încearcă să modifici filtrele sau să cauți altceva.', 'flavor'); ?></p>
        </div>
        <?php
    }

    $html = ob_get_clean();
    wp_reset_postdata();

    // Build count text
    $count_text = sprintf(
        _n('%s carte găsită', '%s cărți găsite', $query->found_posts, 'flavor'),
        number_format_i18n($query->found_posts)
    );

    wp_send_json_success([
        'html' => $html,
        'found' => $query->found_posts,
        'count_text' => $count_text,
        'max_pages' => $query->max_num_pages,
    ]);
}

/**
 * Autocomplete Authors
 */
function bpt_ajax_autocomplete_authors() {
    // Verify nonce
    if (!wp_verify_nonce($_GET['nonce'] ?? '', 'bpt_ajax_nonce')) {
        wp_send_json_error(['message' => 'Invalid nonce']);
    }

    $query = sanitize_text_field($_GET['query'] ?? '');
    
    if (strlen($query) < 2) {
        wp_send_json_success([]);
    }

    $terms = get_terms([
        'taxonomy' => 'autor',
        'hide_empty' => true,
        'name__like' => $query,
        'number' => 10,
        'orderby' => 'count',
        'order' => 'DESC',
    ]);

    if (is_wp_error($terms)) {
        wp_send_json_error(['message' => 'Error fetching terms']);
    }

    $results = array_map(function($term) {
        return [
            'id' => $term->term_id,
            'name' => $term->name,
            'slug' => $term->slug,
            'count' => $term->count,
        ];
    }, $terms);

    wp_send_json_success($results);
}

/**
 * Load More Books (Infinite Scroll)
 */
function bpt_ajax_load_more_books() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'] ?? '', 'bpt_ajax_nonce')) {
        wp_send_json_error(['message' => 'Invalid nonce']);
    }

    $paged = absint($_POST['paged'] ?? 1);
    
    // Rebuild the same query with new page
    $args = json_decode(stripslashes($_POST['query_args'] ?? '{}'), true);
    $args['paged'] = $paged;
    $args['posts_per_page'] = get_theme_mod('bpt_books_per_page', 24);

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            echo bpt_get_carte_card(get_the_ID(), 'medium');
        }
    }

    $html = ob_get_clean();
    wp_reset_postdata();

    wp_send_json_success([
        'html' => $html,
        'has_more' => $paged < $query->max_num_pages,
    ]);
}

/**
 * Live Search Books
 */
function bpt_ajax_search_books() {
    // Verify nonce
    if (!wp_verify_nonce($_GET['nonce'] ?? '', 'bpt_ajax_nonce')) {
        wp_send_json_error(['message' => 'Invalid nonce']);
    }

    $search = sanitize_text_field($_GET['s'] ?? '');
    
    if (strlen($search) < 2) {
        wp_send_json_success([]);
    }

    $args = [
        'post_type' => 'carte',
        's' => $search,
        'posts_per_page' => 8,
    ];

    $query = new WP_Query($args);
    $results = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            
            $autori = wp_get_post_terms(get_the_ID(), 'autor', ['fields' => 'names']);
            
            $results[] = [
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'url' => get_permalink(),
                'author' => !empty($autori) ? $autori[0] : '',
                'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'),
                'nr_bpt' => get_post_meta(get_the_ID(), 'nr_bpt', true),
            ];
        }
    }

    wp_reset_postdata();

    wp_send_json_success($results);
}

/**
 * Register REST API endpoints
 */
add_action('rest_api_init', 'bpt_register_rest_routes');

function bpt_register_rest_routes() {
    register_rest_route('bpt/v1', '/books', [
        'methods' => 'GET',
        'callback' => 'bpt_rest_get_books',
        'permission_callback' => '__return_true',
        'args' => [
            'epoca' => [
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
            ],
            'gen' => [
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
            ],
            'page' => [
                'type' => 'integer',
                'default' => 1,
                'sanitize_callback' => 'absint',
            ],
            'per_page' => [
                'type' => 'integer',
                'default' => 24,
                'sanitize_callback' => 'absint',
            ],
        ],
    ]);

    register_rest_route('bpt/v1', '/stats', [
        'methods' => 'GET',
        'callback' => 'bpt_rest_get_stats',
        'permission_callback' => '__return_true',
    ]);
}

/**
 * REST: Get Books
 */
function bpt_rest_get_books($request) {
    $args = [
        'post_type' => 'carte',
        'posts_per_page' => min($request['per_page'], 100),
        'paged' => $request['page'],
        'orderby' => 'title',
        'order' => 'ASC',
    ];

    $tax_query = [];

    if ($request['epoca']) {
        $tax_query[] = [
            'taxonomy' => 'epoca',
            'field' => 'slug',
            'terms' => $request['epoca'],
        ];
    }

    if ($request['gen']) {
        $tax_query[] = [
            'taxonomy' => 'gen-literar',
            'field' => 'slug',
            'terms' => $request['gen'],
        ];
    }

    if (!empty($tax_query)) {
        $tax_query['relation'] = 'AND';
        $args['tax_query'] = $tax_query;
    }

    $query = new WP_Query($args);
    $books = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            
            $autori = wp_get_post_terms(get_the_ID(), 'autor', ['fields' => 'all']);
            $epoca_terms = wp_get_post_terms(get_the_ID(), 'epoca', ['fields' => 'all']);
            $gen_terms = wp_get_post_terms(get_the_ID(), 'gen-literar', ['fields' => 'all']);

            $books[] = [
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'slug' => get_post_field('post_name', get_the_ID()),
                'url' => get_permalink(),
                'excerpt' => get_the_excerpt(),
                'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'card-medium'),
                'nr_bpt' => get_post_meta(get_the_ID(), 'nr_bpt', true),
                'an_scriere' => get_post_meta(get_the_ID(), 'an_scriere', true),
                'an_publicare_bpt' => get_post_meta(get_the_ID(), 'an_publicare_bpt', true),
                'autori' => array_map(function($a) {
                    return ['id' => $a->term_id, 'name' => $a->name, 'slug' => $a->slug];
                }, $autori),
                'epoca' => !empty($epoca_terms) ? [
                    'id' => $epoca_terms[0]->term_id,
                    'name' => $epoca_terms[0]->name,
                    'slug' => $epoca_terms[0]->slug,
                ] : null,
                'gen' => !empty($gen_terms) ? [
                    'id' => $gen_terms[0]->term_id,
                    'name' => $gen_terms[0]->name,
                    'slug' => $gen_terms[0]->slug,
                ] : null,
            ];
        }
    }

    wp_reset_postdata();

    return [
        'books' => $books,
        'total' => $query->found_posts,
        'pages' => $query->max_num_pages,
        'current_page' => $request['page'],
    ];
}

/**
 * REST: Get Collection Stats
 */
function bpt_rest_get_stats($request) {
    $stats = bpt_get_collection_stats();
    
    $genuri = get_terms(['taxonomy' => 'gen-literar', 'hide_empty' => true]);
    $limbi = get_terms(['taxonomy' => 'limba-originala', 'hide_empty' => true]);
    $epoci = get_terms(['taxonomy' => 'epoca', 'hide_empty' => true]);

    return [
        'books' => $stats['books'],
        'authors' => $stats['authors'],
        'years' => $stats['years'],
        'genres' => is_array($genuri) ? count($genuri) : 0,
        'languages' => is_array($limbi) ? count($limbi) : 0,
        'epochs' => is_array($epoci) ? count($epoci) : 0,
    ];
}
