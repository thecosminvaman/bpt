<?php
/**
 * Custom Post Types Registration
 *
 * @package Biblioteca_Pentru_Toti
 */

defined('ABSPATH') || exit;

/**
 * Register Custom Post Types
 */
function bpt_register_post_types() {
    
    /**
     * CPT: Carte (Book)
     */
    $carte_labels = [
        'name'                  => _x('Cărți', 'Post type general name', 'biblioteca-pentru-toti'),
        'singular_name'         => _x('Carte', 'Post type singular name', 'biblioteca-pentru-toti'),
        'menu_name'             => _x('Cărți', 'Admin Menu text', 'biblioteca-pentru-toti'),
        'name_admin_bar'        => _x('Carte', 'Add New on Toolbar', 'biblioteca-pentru-toti'),
        'add_new'               => __('Adaugă Carte', 'biblioteca-pentru-toti'),
        'add_new_item'          => __('Adaugă Carte Nouă', 'biblioteca-pentru-toti'),
        'new_item'              => __('Carte Nouă', 'biblioteca-pentru-toti'),
        'edit_item'             => __('Editează Carte', 'biblioteca-pentru-toti'),
        'view_item'             => __('Vezi Cartea', 'biblioteca-pentru-toti'),
        'all_items'             => __('Toate Cărțile', 'biblioteca-pentru-toti'),
        'search_items'          => __('Caută Cărți', 'biblioteca-pentru-toti'),
        'parent_item_colon'     => __('Carte Părinte:', 'biblioteca-pentru-toti'),
        'not_found'             => __('Nu s-au găsit cărți.', 'biblioteca-pentru-toti'),
        'not_found_in_trash'    => __('Nu s-au găsit cărți în coș.', 'biblioteca-pentru-toti'),
        'featured_image'        => _x('Copertă', 'Overrides the "Featured Image" phrase', 'biblioteca-pentru-toti'),
        'set_featured_image'    => _x('Setează coperta', 'Overrides the "Set featured image" phrase', 'biblioteca-pentru-toti'),
        'remove_featured_image' => _x('Șterge coperta', 'Overrides the "Remove featured image" phrase', 'biblioteca-pentru-toti'),
        'use_featured_image'    => _x('Folosește ca copertă', 'Overrides the "Use as featured image" phrase', 'biblioteca-pentru-toti'),
        'archives'              => _x('Arhivă Cărți', 'The post type archive label used in nav menus', 'biblioteca-pentru-toti'),
        'insert_into_item'      => _x('Inserează în carte', 'Overrides the "Insert into post" phrase', 'biblioteca-pentru-toti'),
        'uploaded_to_this_item' => _x('Încărcat în această carte', 'Overrides the "Uploaded to this post" phrase', 'biblioteca-pentru-toti'),
        'filter_items_list'     => _x('Filtrează lista de cărți', 'Screen reader text', 'biblioteca-pentru-toti'),
        'items_list_navigation' => _x('Navigare listă cărți', 'Screen reader text', 'biblioteca-pentru-toti'),
        'items_list'            => _x('Lista cărților', 'Screen reader text', 'biblioteca-pentru-toti'),
    ];

    $carte_args = [
        'labels'             => $carte_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'carti', 'with_front' => false],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-book',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions'],
        'show_in_rest'       => true,
        'rest_base'          => 'carti',
    ];

    register_post_type('carte', $carte_args);

    /**
     * CPT: Eveniment (Timeline Event)
     */
    $eveniment_labels = [
        'name'                  => _x('Evenimente', 'Post type general name', 'biblioteca-pentru-toti'),
        'singular_name'         => _x('Eveniment', 'Post type singular name', 'biblioteca-pentru-toti'),
        'menu_name'             => _x('Cronologie', 'Admin Menu text', 'biblioteca-pentru-toti'),
        'name_admin_bar'        => _x('Eveniment', 'Add New on Toolbar', 'biblioteca-pentru-toti'),
        'add_new'               => __('Adaugă Eveniment', 'biblioteca-pentru-toti'),
        'add_new_item'          => __('Adaugă Eveniment Nou', 'biblioteca-pentru-toti'),
        'new_item'              => __('Eveniment Nou', 'biblioteca-pentru-toti'),
        'edit_item'             => __('Editează Eveniment', 'biblioteca-pentru-toti'),
        'view_item'             => __('Vezi Evenimentul', 'biblioteca-pentru-toti'),
        'all_items'             => __('Toate Evenimentele', 'biblioteca-pentru-toti'),
        'search_items'          => __('Caută Evenimente', 'biblioteca-pentru-toti'),
        'parent_item_colon'     => __('Eveniment Părinte:', 'biblioteca-pentru-toti'),
        'not_found'             => __('Nu s-au găsit evenimente.', 'biblioteca-pentru-toti'),
        'not_found_in_trash'    => __('Nu s-au găsit evenimente în coș.', 'biblioteca-pentru-toti'),
        'featured_image'        => _x('Imagine Eveniment', 'Overrides the "Featured Image" phrase', 'biblioteca-pentru-toti'),
        'set_featured_image'    => _x('Setează imagine', 'Overrides the "Set featured image" phrase', 'biblioteca-pentru-toti'),
        'remove_featured_image' => _x('Șterge imaginea', 'Overrides the "Remove featured image" phrase', 'biblioteca-pentru-toti'),
        'use_featured_image'    => _x('Folosește ca imagine', 'Overrides the "Use as featured image" phrase', 'biblioteca-pentru-toti'),
        'archives'              => _x('Arhivă Evenimente', 'The post type archive label used in nav menus', 'biblioteca-pentru-toti'),
        'insert_into_item'      => _x('Inserează în eveniment', 'Overrides the "Insert into post" phrase', 'biblioteca-pentru-toti'),
        'uploaded_to_this_item' => _x('Încărcat în acest eveniment', 'Overrides the "Uploaded to this post" phrase', 'biblioteca-pentru-toti'),
        'filter_items_list'     => _x('Filtrează lista de evenimente', 'Screen reader text', 'biblioteca-pentru-toti'),
        'items_list_navigation' => _x('Navigare listă evenimente', 'Screen reader text', 'biblioteca-pentru-toti'),
        'items_list'            => _x('Lista evenimentelor', 'Screen reader text', 'biblioteca-pentru-toti'),
    ];

    $eveniment_args = [
        'labels'             => $eveniment_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'cronologie', 'with_front' => false],
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-calendar-alt',
        'supports'           => ['title', 'editor', 'thumbnail', 'revisions'],
        'show_in_rest'       => true,
        'rest_base'          => 'evenimente',
    ];

    register_post_type('eveniment', $eveniment_args);
}
add_action('init', 'bpt_register_post_types');

/**
 * Flush rewrite rules on theme activation
 */
function bpt_rewrite_flush() {
    bpt_register_post_types();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'bpt_rewrite_flush');

/**
 * Change "Enter title here" placeholder for CPTs
 */
function bpt_change_title_placeholder($title, $post) {
    if ($post->post_type === 'carte') {
        return __('Titlul cărții', 'biblioteca-pentru-toti');
    }
    if ($post->post_type === 'eveniment') {
        return __('Titlul evenimentului', 'biblioteca-pentru-toti');
    }
    return $title;
}
add_filter('enter_title_here', 'bpt_change_title_placeholder', 10, 2);

/**
 * Add help text to admin screens
 */
function bpt_add_admin_help_tabs() {
    $screen = get_current_screen();
    
    if ($screen->post_type === 'carte') {
        $screen->add_help_tab([
            'id'      => 'bpt_carte_help',
            'title'   => __('Despre Cărți BPT', 'biblioteca-pentru-toti'),
            'content' => '<p>' . __('Aici gestionați colecția de cărți din Biblioteca pentru Toți. Fiecare carte are un număr unic BPT și diverse metadate asociate.', 'biblioteca-pentru-toti') . '</p>'
        ]);
    }
    
    if ($screen->post_type === 'eveniment') {
        $screen->add_help_tab([
            'id'      => 'bpt_eveniment_help',
            'title'   => __('Despre Evenimente', 'biblioteca-pentru-toti'),
            'content' => '<p>' . __('Evenimentele sunt folosite pentru cronologia interactivă a colecției BPT. Fiecare eveniment are o dată și poate fi asociat cu cărți din colecție.', 'biblioteca-pentru-toti') . '</p>'
        ]);
    }
}
add_action('admin_head', 'bpt_add_admin_help_tabs');

/**
 * Add custom messages for CPT updates
 */
function bpt_updated_messages($messages) {
    $post = get_post();
    $post_type = get_post_type($post);
    $post_type_object = get_post_type_object($post_type);

    $messages['carte'] = [
        0  => '',
        1  => __('Cartea a fost actualizată.', 'biblioteca-pentru-toti'),
        2  => __('Câmpul personalizat a fost actualizat.', 'biblioteca-pentru-toti'),
        3  => __('Câmpul personalizat a fost șters.', 'biblioteca-pentru-toti'),
        4  => __('Cartea a fost actualizată.', 'biblioteca-pentru-toti'),
        5  => isset($_GET['revision']) ? sprintf(__('Cartea a fost restaurată la revizia din %s', 'biblioteca-pentru-toti'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
        6  => __('Cartea a fost publicată.', 'biblioteca-pentru-toti'),
        7  => __('Cartea a fost salvată.', 'biblioteca-pentru-toti'),
        8  => __('Cartea a fost trimisă.', 'biblioteca-pentru-toti'),
        9  => sprintf(__('Cartea este programată pentru: <strong>%1$s</strong>.', 'biblioteca-pentru-toti'), date_i18n('M j, Y @ G:i', strtotime($post->post_date))),
        10 => __('Ciorna cărții a fost actualizată.', 'biblioteca-pentru-toti'),
    ];

    $messages['eveniment'] = [
        0  => '',
        1  => __('Evenimentul a fost actualizat.', 'biblioteca-pentru-toti'),
        2  => __('Câmpul personalizat a fost actualizat.', 'biblioteca-pentru-toti'),
        3  => __('Câmpul personalizat a fost șters.', 'biblioteca-pentru-toti'),
        4  => __('Evenimentul a fost actualizat.', 'biblioteca-pentru-toti'),
        5  => isset($_GET['revision']) ? sprintf(__('Evenimentul a fost restaurat la revizia din %s', 'biblioteca-pentru-toti'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
        6  => __('Evenimentul a fost publicat.', 'biblioteca-pentru-toti'),
        7  => __('Evenimentul a fost salvat.', 'biblioteca-pentru-toti'),
        8  => __('Evenimentul a fost trimis.', 'biblioteca-pentru-toti'),
        9  => sprintf(__('Evenimentul este programat pentru: <strong>%1$s</strong>.', 'biblioteca-pentru-toti'), date_i18n('M j, Y @ G:i', strtotime($post->post_date))),
        10 => __('Ciorna evenimentului a fost actualizată.', 'biblioteca-pentru-toti'),
    ];

    return $messages;
}
add_filter('post_updated_messages', 'bpt_updated_messages');
