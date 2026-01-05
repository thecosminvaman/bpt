<?php
/**
 * Template Functions
 *
 * @package Biblioteca_Pentru_Toti
 */

defined('ABSPATH') || exit;

/**
 * Display the book card
 */
function bpt_get_carte_card($post_id = null, $args = []) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $defaults = [
        'show_cover'  => true,
        'show_meta'   => true,
        'show_author' => true,
        'class'       => '',
    ];

    $args = wp_parse_args($args, $defaults);

    // Get book data
    $nr_bpt = get_field('nr_bpt', $post_id);
    $an_scriere = get_field('an_scriere', $post_id);
    
    // Get taxonomies
    $autori = get_the_terms($post_id, 'autor');
    $genuri = get_the_terms($post_id, 'gen_literar');
    $epoci = get_the_terms($post_id, 'epoca');

    // Get first terms
    $autor = ($autori && !is_wp_error($autori)) ? $autori[0] : null;
    $gen = ($genuri && !is_wp_error($genuri)) ? $genuri[0] : null;
    $epoca = ($epoci && !is_wp_error($epoci)) ? $epoci[0] : null;

    // Get colors
    $gen_color = $gen ? bpt_get_gen_color($gen->slug) : '#8B0000';
    $epoca_colors = $epoca ? bpt_get_epoca_color($epoca->slug) : ['bg' => '#F5F3EE', 'text' => '#1A1A1A'];

    ob_start();
    ?>
    <article class="carte-card <?php echo esc_attr($args['class']); ?>" 
             data-epoca="<?php echo $epoca ? esc_attr($epoca->slug) : ''; ?>" 
             data-gen="<?php echo $gen ? esc_attr($gen->slug) : ''; ?>"
             style="border-left-color: <?php echo esc_attr($gen_color); ?>; background-color: <?php echo esc_attr($epoca_colors['bg']); ?>">
        
        <?php if ($args['show_cover']) : ?>
        <div class="carte-card__visual">
            <?php if ($nr_bpt) : ?>
            <span class="carte-card__nr">#<?php echo esc_html($nr_bpt); ?></span>
            <?php endif; ?>
            
            <?php if (has_post_thumbnail($post_id)) : ?>
            <img src="<?php echo esc_url(get_the_post_thumbnail_url($post_id, 'bpt-book-cover')); ?>" 
                 alt="<?php echo esc_attr(get_the_title($post_id)); ?>"
                 class="carte-card__cover"
                 loading="lazy">
            <?php else : ?>
            <div class="carte-card__cover carte-card__cover--placeholder">
                <span><?php echo esc_html(mb_substr(get_the_title($post_id), 0, 1)); ?></span>
            </div>
            <?php endif; ?>
            
            <?php if ($epoca) : ?>
            <span class="carte-card__epoca-tag"><?php echo esc_html($epoca->name); ?></span>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <div class="carte-card__info">
            <h3 class="carte-card__title">
                <a href="<?php echo esc_url(get_permalink($post_id)); ?>">
                    <?php echo esc_html(get_the_title($post_id)); ?>
                </a>
            </h3>
            
            <?php if ($args['show_author'] && $autor) : ?>
            <p class="carte-card__author">
                <?php esc_html_e('de', 'biblioteca-pentru-toti'); ?>
                <a href="<?php echo esc_url(get_term_link($autor)); ?>">
                    <?php echo esc_html($autor->name); ?>
                </a>
            </p>
            <?php endif; ?>
            
            <?php if ($args['show_meta']) : ?>
            <div class="carte-card__meta">
                <?php if ($gen) : ?>
                <span class="gen-tag" style="background-color: <?php echo esc_attr($gen_color); ?>">
                    <?php echo esc_html($gen->name); ?>
                </span>
                <?php endif; ?>
                
                <?php if ($an_scriere) : ?>
                <span class="year"><?php echo esc_html($an_scriere); ?></span>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </article>
    <?php
    return ob_get_clean();
}

/**
 * Display book card
 */
function bpt_carte_card($post_id = null, $args = []) {
    echo bpt_get_carte_card($post_id, $args);
}

/**
 * Get article card HTML
 */
function bpt_get_articol_card($post_id = null, $args = []) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $defaults = [
        'featured'   => false,
        'show_image' => true,
        'show_excerpt' => true,
        'class'      => '',
    ];

    $args = wp_parse_args($args, $defaults);

    $categories = get_the_category($post_id);
    $category = $categories ? $categories[0] : null;

    ob_start();
    ?>
    <article class="articol-card <?php echo $args['featured'] ? 'articol-card--featured' : ''; ?> <?php echo esc_attr($args['class']); ?>">
        
        <?php if ($args['show_image'] && has_post_thumbnail($post_id)) : ?>
        <div class="articol-card__image">
            <a href="<?php echo esc_url(get_permalink($post_id)); ?>">
                <img src="<?php echo esc_url(get_the_post_thumbnail_url($post_id, $args['featured'] ? 'bpt-hero' : 'bpt-card')); ?>" 
                     alt="<?php echo esc_attr(get_the_title($post_id)); ?>"
                     loading="lazy">
            </a>
        </div>
        <?php endif; ?>
        
        <div class="articol-card__content">
            <?php if ($category) : ?>
            <span class="articol-card__category">
                <?php echo esc_html($category->name); ?>
            </span>
            <?php endif; ?>
            
            <h3 class="articol-card__title">
                <a href="<?php echo esc_url(get_permalink($post_id)); ?>">
                    <?php echo esc_html(get_the_title($post_id)); ?>
                </a>
            </h3>
            
            <?php if ($args['show_excerpt']) : ?>
            <p class="articol-card__excerpt">
                <?php echo esc_html(wp_trim_words(get_the_excerpt($post_id), 20)); ?>
            </p>
            <?php endif; ?>
            
            <div class="articol-card__meta">
                <span class="articol-card__author">
                    <?php echo esc_html(get_the_author_meta('display_name', get_post_field('post_author', $post_id))); ?>
                </span>
                <span class="articol-card__date">
                    <?php echo esc_html(get_the_date('', $post_id)); ?>
                </span>
            </div>
        </div>
    </article>
    <?php
    return ob_get_clean();
}

/**
 * Display article card
 */
function bpt_articol_card($post_id = null, $args = []) {
    echo bpt_get_articol_card($post_id, $args);
}

/**
 * Get timeline item HTML
 */
function bpt_get_timeline_item($post_id = null, $args = []) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $defaults = [
        'position'   => 'left',
        'class'      => '',
    ];

    $args = wp_parse_args($args, $defaults);

    // Get event data
    $data_afisata = get_field('data_afisata', $post_id);
    $descriere_scurta = get_field('descriere_scurta', $post_id);
    $importanta = get_field('importanta', $post_id) ?: 'medie';
    $culoare_marker = get_field('culoare_marker', $post_id) ?: '#8B0000';
    $carti_asociate = get_field('carti_asociate', $post_id);

    ob_start();
    ?>
    <div class="timeline-item timeline-item--<?php echo esc_attr($importanta); ?> timeline-item--<?php echo esc_attr($args['position']); ?> <?php echo esc_attr($args['class']); ?>">
        <div class="timeline-item__marker" style="background-color: <?php echo esc_attr($culoare_marker); ?>"></div>
        
        <div class="timeline-item__date">
            <?php echo esc_html($data_afisata); ?>
        </div>
        
        <div class="timeline-item__content">
            <?php if (has_post_thumbnail($post_id)) : ?>
            <figure class="timeline-item__image">
                <img src="<?php echo esc_url(get_the_post_thumbnail_url($post_id, 'bpt-timeline')); ?>" 
                     alt="<?php echo esc_attr(get_the_title($post_id)); ?>"
                     loading="lazy">
            </figure>
            <?php endif; ?>
            
            <h3 class="timeline-item__title">
                <?php echo esc_html(get_the_title($post_id)); ?>
            </h3>
            
            <?php if ($descriere_scurta) : ?>
            <p class="timeline-item__excerpt">
                <?php echo esc_html($descriere_scurta); ?>
            </p>
            <?php endif; ?>
            
            <?php if ($carti_asociate) : ?>
            <div class="timeline-item__books">
                <span class="timeline-item__books-label">📚</span>
                <?php foreach ($carti_asociate as $carte) : ?>
                <a href="<?php echo esc_url(get_permalink($carte->ID)); ?>" class="timeline-item__book-link">
                    <?php echo esc_html($carte->post_title); ?>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            
            <a href="<?php echo esc_url(get_permalink($post_id)); ?>" class="timeline-item__more">
                <?php esc_html_e('Citește mai mult →', 'biblioteca-pentru-toti'); ?>
            </a>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Display timeline item
 */
function bpt_timeline_item($post_id = null, $args = []) {
    echo bpt_get_timeline_item($post_id, $args);
}

/**
 * Get epoch card HTML
 */
function bpt_get_epoch_card($term) {
    $colors = bpt_get_epoca_color($term->slug);
    
    // Get random book covers from this epoch
    $books = get_posts([
        'post_type'      => 'carte',
        'posts_per_page' => 3,
        'orderby'        => 'rand',
        'tax_query'      => [
            [
                'taxonomy' => 'epoca',
                'field'    => 'term_id',
                'terms'    => $term->term_id,
            ],
        ],
    ]);

    ob_start();
    ?>
    <a href="<?php echo esc_url(get_term_link($term)); ?>" 
       class="epoch-card"
       style="background-color: <?php echo esc_attr($colors['bg']); ?>; color: <?php echo esc_attr($colors['text']); ?>">
        
        <h3 class="epoch-card__name"><?php echo esc_html($term->name); ?></h3>
        
        <span class="epoch-card__count">
            <?php printf(
                _n('%d carte', '%d cărți', $term->count, 'biblioteca-pentru-toti'),
                $term->count
            ); ?>
        </span>
        
        <?php if ($books) : ?>
        <div class="epoch-card__covers">
            <?php foreach ($books as $book) : ?>
                <?php if (has_post_thumbnail($book->ID)) : ?>
                <img src="<?php echo esc_url(get_the_post_thumbnail_url($book->ID, 'thumbnail')); ?>" 
                     alt="" 
                     loading="lazy">
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </a>
    <?php
    return ob_get_clean();
}

/**
 * Display epoch card
 */
function bpt_epoch_card($term) {
    echo bpt_get_epoch_card($term);
}

/**
 * Get breadcrumbs
 */
function bpt_breadcrumbs() {
    if (is_front_page()) {
        return;
    }

    $sep = '<span class="breadcrumb-sep">›</span>';
    
    echo '<nav class="breadcrumbs" aria-label="' . esc_attr__('Breadcrumb', 'biblioteca-pentru-toti') . '">';
    echo '<a href="' . esc_url(home_url('/')) . '">' . esc_html__('Acasă', 'biblioteca-pentru-toti') . '</a>';
    
    if (is_singular('carte')) {
        echo $sep;
        echo '<a href="' . esc_url(get_post_type_archive_link('carte')) . '">' . esc_html__('Cărți', 'biblioteca-pentru-toti') . '</a>';
        echo $sep;
        echo '<span>' . esc_html(get_the_title()) . '</span>';
    } elseif (is_singular('eveniment')) {
        echo $sep;
        echo '<a href="' . esc_url(get_permalink(get_page_by_path('cronologie'))) . '">' . esc_html__('Cronologie', 'biblioteca-pentru-toti') . '</a>';
        echo $sep;
        echo '<span>' . esc_html(get_the_title()) . '</span>';
    } elseif (is_post_type_archive('carte')) {
        echo $sep;
        echo '<span>' . esc_html__('Cărți', 'biblioteca-pentru-toti') . '</span>';
    } elseif (is_tax()) {
        echo $sep;
        $term = get_queried_object();
        $taxonomy = get_taxonomy($term->taxonomy);
        if ($term->taxonomy === 'autor' || $term->taxonomy === 'gen_literar' || $term->taxonomy === 'epoca' || $term->taxonomy === 'limba_originala') {
            echo '<a href="' . esc_url(get_post_type_archive_link('carte')) . '">' . esc_html__('Cărți', 'biblioteca-pentru-toti') . '</a>';
            echo $sep;
        }
        echo '<span>' . esc_html($term->name) . '</span>';
    } elseif (is_single()) {
        echo $sep;
        $categories = get_the_category();
        if ($categories) {
            echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a>';
            echo $sep;
        }
        echo '<span>' . esc_html(get_the_title()) . '</span>';
    } elseif (is_category()) {
        echo $sep;
        echo '<span>' . esc_html(single_cat_title('', false)) . '</span>';
    } elseif (is_page()) {
        echo $sep;
        echo '<span>' . esc_html(get_the_title()) . '</span>';
    } elseif (is_search()) {
        echo $sep;
        echo '<span>' . sprintf(esc_html__('Rezultate pentru: %s', 'biblioteca-pentru-toti'), get_search_query()) . '</span>';
    } elseif (is_404()) {
        echo $sep;
        echo '<span>' . esc_html__('Pagină negăsită', 'biblioteca-pentru-toti') . '</span>';
    }
    
    echo '</nav>';
}

/**
 * Custom pagination
 */
function bpt_pagination($query = null) {
    if (!$query) {
        global $wp_query;
        $query = $wp_query;
    }

    $total_pages = $query->max_num_pages;

    if ($total_pages <= 1) {
        return;
    }

    $current_page = max(1, get_query_var('paged'));

    echo '<nav class="pagination" aria-label="' . esc_attr__('Paginare', 'biblioteca-pentru-toti') . '">';
    
    echo paginate_links([
        'base'      => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
        'format'    => '?paged=%#%',
        'current'   => $current_page,
        'total'     => $total_pages,
        'prev_text' => '←',
        'next_text' => '→',
        'type'      => 'list',
        'mid_size'  => 2,
    ]);
    
    echo '</nav>';
}

/**
 * Get related books
 */
function bpt_get_related_books($post_id = null, $count = 4) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    // Get the same author or epoch
    $autori = wp_get_post_terms($post_id, 'autor', ['fields' => 'ids']);
    $epoci = wp_get_post_terms($post_id, 'epoca', ['fields' => 'ids']);

    $args = [
        'post_type'      => 'carte',
        'posts_per_page' => $count,
        'post__not_in'   => [$post_id],
        'orderby'        => 'rand',
    ];

    if ($autori || $epoci) {
        $args['tax_query'] = ['relation' => 'OR'];
        
        if ($autori) {
            $args['tax_query'][] = [
                'taxonomy' => 'autor',
                'field'    => 'term_id',
                'terms'    => $autori,
            ];
        }
        
        if ($epoci) {
            $args['tax_query'][] = [
                'taxonomy' => 'epoca',
                'field'    => 'term_id',
                'terms'    => $epoci,
            ];
        }
    }

    return get_posts($args);
}

/**
 * Get book facts array
 */
function bpt_get_book_facts($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $facts = [];

    $nr_bpt = get_field('nr_bpt', $post_id);
    if ($nr_bpt) {
        $facts['nr_bpt'] = [
            'label' => __('Nr. BPT', 'biblioteca-pentru-toti'),
            'value' => '#' . $nr_bpt,
        ];
    }

    $an_scriere = get_field('an_scriere', $post_id);
    if ($an_scriere) {
        $facts['an_scriere'] = [
            'label' => __('An scriere', 'biblioteca-pentru-toti'),
            'value' => $an_scriere,
        ];
    }

    $an_publicare_bpt = get_field('an_publicare_bpt', $post_id);
    if ($an_publicare_bpt) {
        $facts['an_publicare_bpt'] = [
            'label' => __('An publicare BPT', 'biblioteca-pentru-toti'),
            'value' => $an_publicare_bpt,
        ];
    }

    $nr_pagini = get_field('nr_pagini', $post_id);
    if ($nr_pagini) {
        $facts['nr_pagini'] = [
            'label' => __('Pagini', 'biblioteca-pentru-toti'),
            'value' => $nr_pagini,
        ];
    }

    $limba = get_the_terms($post_id, 'limba_originala');
    if ($limba && !is_wp_error($limba)) {
        $facts['limba'] = [
            'label' => __('Limba originală', 'biblioteca-pentru-toti'),
            'value' => $limba[0]->name,
        ];
    }

    $traducator = get_field('traducator', $post_id);
    if ($traducator) {
        $facts['traducator'] = [
            'label' => __('Traducător', 'biblioteca-pentru-toti'),
            'value' => $traducator,
        ];
    }

    $prefata = get_field('prefata_de', $post_id);
    if ($prefata) {
        $facts['prefata'] = [
            'label' => __('Prefață', 'biblioteca-pentru-toti'),
            'value' => $prefata,
        ];
    }

    return $facts;
}

/**
 * Output SVG icon
 */
function bpt_icon($name, $class = '') {
    $icons = [
        'book'     => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>',
        'calendar' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>',
        'search'   => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        'download' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>',
        'link'     => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>',
        'arrow-up' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>',
        'menu'     => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>',
        'close'    => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>',
    ];

    if (isset($icons[$name])) {
        $icon = $icons[$name];
        if ($class) {
            $icon = str_replace('<svg', '<svg class="' . esc_attr($class) . '"', $icon);
        }
        return $icon;
    }

    return '';
}

/**
 * Format year for display (handles BC years)
 */
function bpt_format_year($year) {
    if ($year < 0) {
        return abs($year) . ' ' . __('î.Hr.', 'biblioteca-pentru-toti');
    }
    return $year;
}
