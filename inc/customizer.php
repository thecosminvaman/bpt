<?php
/**
 * Theme Customizer
 *
 * @package Biblioteca_Pentru_Toti
 */

defined('ABSPATH') || exit;

/**
 * Register Customizer settings
 */
function bpt_customize_register($wp_customize) {
    
    // =========================================================================
    // Panel: BPT Settings
    // =========================================================================
    $wp_customize->add_panel('bpt_settings', [
        'title'       => __('Setări Biblioteca pentru Toți', 'biblioteca-pentru-toti'),
        'description' => __('Personalizează tema Biblioteca pentru Toți', 'biblioteca-pentru-toti'),
        'priority'    => 30,
    ]);

    // =========================================================================
    // Section: Homepage
    // =========================================================================
    $wp_customize->add_section('bpt_homepage', [
        'title'    => __('Homepage', 'biblioteca-pentru-toti'),
        'panel'    => 'bpt_settings',
        'priority' => 10,
    ]);

    // Hero Book Selection
    $wp_customize->add_setting('bpt_hero_book', [
        'default'           => '',
        'sanitize_callback' => 'absint',
    ]);

    $wp_customize->add_control('bpt_hero_book', [
        'label'       => __('Carte pentru Hero', 'biblioteca-pentru-toti'),
        'description' => __('Selectează cartea afișată în hero (ID post)', 'biblioteca-pentru-toti'),
        'section'     => 'bpt_homepage',
        'type'        => 'number',
    ]);

    // Hero Custom Quote
    $wp_customize->add_setting('bpt_hero_quote', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);

    $wp_customize->add_control('bpt_hero_quote', [
        'label'       => __('Citat personalizat Hero', 'biblioteca-pentru-toti'),
        'description' => __('Dacă e completat, înlocuiește citatul cărții', 'biblioteca-pentru-toti'),
        'section'     => 'bpt_homepage',
        'type'        => 'textarea',
    ]);

    // Hero Background Image
    $wp_customize->add_setting('bpt_hero_bg', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'bpt_hero_bg', [
        'label'   => __('Imagine fundal Hero', 'biblioteca-pentru-toti'),
        'section' => 'bpt_homepage',
    ]));

    // Timeline Teaser Count
    $wp_customize->add_setting('bpt_timeline_teaser_count', [
        'default'           => 7,
        'sanitize_callback' => 'absint',
    ]);

    $wp_customize->add_control('bpt_timeline_teaser_count', [
        'label'       => __('Număr evenimente în teaser', 'biblioteca-pentru-toti'),
        'section'     => 'bpt_homepage',
        'type'        => 'number',
        'input_attrs' => ['min' => 3, 'max' => 10],
    ]);

    // Homepage Sections Toggle
    $homepage_sections = [
        'hero'       => __('Hero Section', 'biblioteca-pentru-toti'),
        'timeline'   => __('Timeline Teaser', 'biblioteca-pentru-toti'),
        'editorial'  => __('Editorial (Articole + Cartea Săptămânii)', 'biblioteca-pentru-toti'),
        'epochs'     => __('Browse by Epoch', 'biblioteca-pentru-toti'),
        'stats'      => __('Stats Counter', 'biblioteca-pentru-toti'),
        'recent'     => __('Recent Books Carousel', 'biblioteca-pentru-toti'),
        'newsletter' => __('Newsletter', 'biblioteca-pentru-toti'),
    ];

    foreach ($homepage_sections as $key => $label) {
        $wp_customize->add_setting("bpt_show_section_{$key}", [
            'default'           => true,
            'sanitize_callback' => 'bpt_sanitize_checkbox',
        ]);

        $wp_customize->add_control("bpt_show_section_{$key}", [
            'label'   => $label,
            'section' => 'bpt_homepage',
            'type'    => 'checkbox',
        ]);
    }

    // =========================================================================
    // Section: Books Archive
    // =========================================================================
    $wp_customize->add_section('bpt_books_archive', [
        'title'    => __('Arhivă Cărți', 'biblioteca-pentru-toti'),
        'panel'    => 'bpt_settings',
        'priority' => 20,
    ]);

    // Books per page
    $wp_customize->add_setting('bpt_books_per_page', [
        'default'           => 12,
        'sanitize_callback' => 'absint',
    ]);

    $wp_customize->add_control('bpt_books_per_page', [
        'label'       => __('Cărți pe pagină', 'biblioteca-pentru-toti'),
        'section'     => 'bpt_books_archive',
        'type'        => 'number',
        'input_attrs' => ['min' => 6, 'max' => 48],
    ]);

    // Default view
    $wp_customize->add_setting('bpt_default_view', [
        'default'           => 'grid',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('bpt_default_view', [
        'label'   => __('Vizualizare implicită', 'biblioteca-pentru-toti'),
        'section' => 'bpt_books_archive',
        'type'    => 'select',
        'choices' => [
            'grid'    => __('Grid', 'biblioteca-pentru-toti'),
            'list'    => __('Listă', 'biblioteca-pentru-toti'),
            'compact' => __('Compact', 'biblioteca-pentru-toti'),
        ],
    ]);

    // Default sort
    $wp_customize->add_setting('bpt_default_sort', [
        'default'           => 'nr_bpt',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('bpt_default_sort', [
        'label'   => __('Sortare implicită', 'biblioteca-pentru-toti'),
        'section' => 'bpt_books_archive',
        'type'    => 'select',
        'choices' => [
            'nr_bpt'     => __('Număr BPT', 'biblioteca-pentru-toti'),
            'an_scriere' => __('An scriere', 'biblioteca-pentru-toti'),
            'an_bpt'     => __('An publicare BPT', 'biblioteca-pentru-toti'),
            'title'      => __('Alfabetic (A-Z)', 'biblioteca-pentru-toti'),
            'date'       => __('Recent adăugate', 'biblioteca-pentru-toti'),
        ],
    ]);

    // Enable infinite scroll
    $wp_customize->add_setting('bpt_infinite_scroll', [
        'default'           => false,
        'sanitize_callback' => 'bpt_sanitize_checkbox',
    ]);

    $wp_customize->add_control('bpt_infinite_scroll', [
        'label'   => __('Activează Infinite Scroll', 'biblioteca-pentru-toti'),
        'section' => 'bpt_books_archive',
        'type'    => 'checkbox',
    ]);

    // Show filters
    $filter_options = [
        'epoca'           => __('Epocă', 'biblioteca-pentru-toti'),
        'gen'             => __('Gen literar', 'biblioteca-pentru-toti'),
        'limba'           => __('Limbă originală', 'biblioteca-pentru-toti'),
        'autor'           => __('Autor', 'biblioteca-pentru-toti'),
        'domeniu_public'  => __('Domeniu public', 'biblioteca-pentru-toti'),
        'range_nr'        => __('Interval Nr. BPT', 'biblioteca-pentru-toti'),
        'range_an'        => __('Interval an scriere', 'biblioteca-pentru-toti'),
    ];

    foreach ($filter_options as $key => $label) {
        $wp_customize->add_setting("bpt_show_filter_{$key}", [
            'default'           => true,
            'sanitize_callback' => 'bpt_sanitize_checkbox',
        ]);

        $wp_customize->add_control("bpt_show_filter_{$key}", [
            'label'   => $label,
            'section' => 'bpt_books_archive',
            'type'    => 'checkbox',
        ]);
    }

    // =========================================================================
    // Section: Timeline
    // =========================================================================
    $wp_customize->add_section('bpt_timeline', [
        'title'    => __('Cronologie', 'biblioteca-pentru-toti'),
        'panel'    => 'bpt_settings',
        'priority' => 30,
    ]);

    // Timeline start year
    $wp_customize->add_setting('bpt_timeline_start', [
        'default'           => 1953,
        'sanitize_callback' => 'absint',
    ]);

    $wp_customize->add_control('bpt_timeline_start', [
        'label'       => __('An început cronologie', 'biblioteca-pentru-toti'),
        'section'     => 'bpt_timeline',
        'type'        => 'number',
        'input_attrs' => ['min' => 1900, 'max' => 2000],
    ]);

    // Timeline end year
    $wp_customize->add_setting('bpt_timeline_end', [
        'default'           => 1989,
        'sanitize_callback' => 'absint',
    ]);

    $wp_customize->add_control('bpt_timeline_end', [
        'label'       => __('An sfârșit cronologie', 'biblioteca-pentru-toti'),
        'section'     => 'bpt_timeline',
        'type'        => 'number',
        'input_attrs' => ['min' => 1950, 'max' => 2000],
    ]);

    // Timeline animation
    $wp_customize->add_setting('bpt_timeline_animation', [
        'default'           => true,
        'sanitize_callback' => 'bpt_sanitize_checkbox',
    ]);

    $wp_customize->add_control('bpt_timeline_animation', [
        'label'   => __('Activează animațiile cronologiei', 'biblioteca-pentru-toti'),
        'section' => 'bpt_timeline',
        'type'    => 'checkbox',
    ]);

    // =========================================================================
    // Section: Epoch Colors
    // =========================================================================
    $wp_customize->add_section('bpt_epoca_colors', [
        'title'    => __('Culori Epoci', 'biblioteca-pentru-toti'),
        'panel'    => 'bpt_settings',
        'priority' => 40,
    ]);

    $default_epoca_colors = bpt_get_epoca_colors();
    foreach ($default_epoca_colors as $slug => $colors) {
        // Background color
        $wp_customize->add_setting("bpt_color_epoca_{$slug}_bg", [
            'default'           => $colors['bg'],
            'sanitize_callback' => 'sanitize_hex_color',
        ]);

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "bpt_color_epoca_{$slug}_bg", [
            'label'   => sprintf(__('%s - Fundal', 'biblioteca-pentru-toti'), ucfirst($slug)),
            'section' => 'bpt_epoca_colors',
        ]));

        // Text color
        $wp_customize->add_setting("bpt_color_epoca_{$slug}_text", [
            'default'           => $colors['text'],
            'sanitize_callback' => 'sanitize_hex_color',
        ]);

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "bpt_color_epoca_{$slug}_text", [
            'label'   => sprintf(__('%s - Text', 'biblioteca-pentru-toti'), ucfirst($slug)),
            'section' => 'bpt_epoca_colors',
        ]));
    }

    // =========================================================================
    // Section: Genre Colors
    // =========================================================================
    $wp_customize->add_section('bpt_gen_colors', [
        'title'    => __('Culori Genuri', 'biblioteca-pentru-toti'),
        'panel'    => 'bpt_settings',
        'priority' => 50,
    ]);

    $default_gen_colors = [
        'roman'     => '#8B0000',
        'poezie'    => '#1B365D',
        'teatru'    => '#6B3E26',
        'filosofie' => '#2D5A27',
        'memorii'   => '#705D84',
        'nuvele'    => '#C5A572',
        'eseu'      => '#4A6670',
    ];

    foreach ($default_gen_colors as $slug => $color) {
        $wp_customize->add_setting("bpt_color_gen_{$slug}", [
            'default'           => $color,
            'sanitize_callback' => 'sanitize_hex_color',
        ]);

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "bpt_color_gen_{$slug}", [
            'label'   => ucfirst($slug),
            'section' => 'bpt_gen_colors',
        ]));
    }

    // =========================================================================
    // Section: Typography
    // =========================================================================
    $wp_customize->add_section('bpt_typography', [
        'title'    => __('Tipografie', 'biblioteca-pentru-toti'),
        'panel'    => 'bpt_settings',
        'priority' => 60,
    ]);

    // Base font size
    $wp_customize->add_setting('bpt_base_font_size', [
        'default'           => 16,
        'sanitize_callback' => 'absint',
    ]);

    $wp_customize->add_control('bpt_base_font_size', [
        'label'       => __('Mărime font de bază (px)', 'biblioteca-pentru-toti'),
        'section'     => 'bpt_typography',
        'type'        => 'range',
        'input_attrs' => ['min' => 14, 'max' => 20, 'step' => 1],
    ]);

    // =========================================================================
    // Section: Footer
    // =========================================================================
    $wp_customize->add_section('bpt_footer', [
        'title'    => __('Footer', 'biblioteca-pentru-toti'),
        'panel'    => 'bpt_settings',
        'priority' => 70,
    ]);

    // Footer copyright
    $wp_customize->add_setting('bpt_footer_copyright', [
        'default'           => sprintf(__('© %s Biblioteca pentru Toți. Toate drepturile rezervate.', 'biblioteca-pentru-toti'), date('Y')),
        'sanitize_callback' => 'wp_kses_post',
    ]);

    $wp_customize->add_control('bpt_footer_copyright', [
        'label'   => __('Text Copyright', 'biblioteca-pentru-toti'),
        'section' => 'bpt_footer',
        'type'    => 'textarea',
    ]);

    // Social links
    $social_networks = [
        'facebook'  => 'Facebook',
        'instagram' => 'Instagram',
        'twitter'   => 'Twitter/X',
    ];

    foreach ($social_networks as $key => $label) {
        $wp_customize->add_setting("bpt_social_{$key}", [
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ]);

        $wp_customize->add_control("bpt_social_{$key}", [
            'label'   => $label,
            'section' => 'bpt_footer',
            'type'    => 'url',
        ]);
    }
}
add_action('customize_register', 'bpt_customize_register');

/**
 * Sanitize checkbox
 */
function bpt_sanitize_checkbox($checked) {
    return ((isset($checked) && true === $checked) ? true : false);
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function bpt_customize_preview_js() {
    wp_enqueue_script(
        'bpt-customizer',
        BPT_URI . '/assets/js/customizer.js',
        ['customize-preview'],
        BPT_VERSION,
        true
    );
}
add_action('customize_preview_init', 'bpt_customize_preview_js');

/**
 * Output dynamic CSS from Customizer settings
 */
function bpt_customizer_css() {
    $base_font_size = get_theme_mod('bpt_base_font_size', 16);
    
    $css = "
        html {
            font-size: {$base_font_size}px;
        }
    ";
    
    // Add epoch colors
    foreach (bpt_get_epoca_colors() as $slug => $colors) {
        $css .= "
            .epoca-{$slug} { 
                --epoca-bg: {$colors['bg']}; 
                --epoca-text: {$colors['text']}; 
            }
        ";
    }
    
    // Add gen colors
    foreach (bpt_get_gen_colors() as $slug => $color) {
        $css .= "
            .gen-{$slug} { 
                --gen-color: {$color}; 
            }
        ";
    }
    
    wp_add_inline_style('bpt-style', $css);
}
add_action('wp_enqueue_scripts', 'bpt_customizer_css', 20);
