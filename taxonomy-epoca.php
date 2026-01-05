<?php
/**
 * Taxonomy Epoca Archive Template
 * 
 * Shows all books from a specific literary era with era-specific styling
 * 
 * @package Biblioteca_Pentru_Toti
 */

get_header();

$term = get_queried_object();
$epoca_colors = bpt_get_epoca_colors($term->slug);

// Get custom fields
$descriere = get_term_meta($term->term_id, 'descriere_epoca', true);
$perioada = get_term_meta($term->term_id, 'perioada', true);
$caracteristici = get_term_meta($term->term_id, 'caracteristici', true);
$autori_reprezentativi = get_term_meta($term->term_id, 'autori_reprezentativi', true);

// Stats for this epoca
$books_count = $term->count;
$authors_in_epoca = get_terms([
    'taxonomy' => 'autor',
    'hide_empty' => true,
    'meta_query' => [
        [
            'key' => 'epoca_principala',
            'value' => $term->term_id,
        ]
    ]
]);
$authors_count = is_array($authors_in_epoca) ? count($authors_in_epoca) : 0;
?>

<style>
    .epoca-header {
        background-color: <?php echo esc_attr($epoca_colors['background']); ?>;
        border-bottom: 4px solid <?php echo esc_attr($epoca_colors['text']); ?>;
    }
    .epoca-header .epoca-title {
        color: <?php echo esc_attr($epoca_colors['text']); ?>;
    }
    .epoca-badge {
        background-color: <?php echo esc_attr($epoca_colors['text']); ?>;
        color: <?php echo esc_attr($epoca_colors['background']); ?>;
    }
    .epoca-nav-link.active,
    .epoca-nav-link:hover {
        border-color: <?php echo esc_attr($epoca_colors['text']); ?>;
        color: <?php echo esc_attr($epoca_colors['text']); ?>;
    }
</style>

<main id="main-content" class="site-main taxonomy-epoca">
    
    <!-- Epoca Header -->
    <header class="epoca-header">
        <div class="container">
            <?php bpt_breadcrumbs(); ?>
            
            <div class="epoca-header-content">
                <span class="epoca-badge"><?php echo esc_html($perioada ?: 'Epocă literară'); ?></span>
                
                <h1 class="epoca-title"><?php echo esc_html($term->name); ?></h1>
                
                <?php if ($term->description || $descriere) : ?>
                    <div class="epoca-description lead">
                        <?php echo wp_kses_post($descriere ?: $term->description); ?>
                    </div>
                <?php endif; ?>
                
                <div class="epoca-stats">
                    <div class="stat-item">
                        <span class="stat-number"><?php echo esc_html($books_count); ?></span>
                        <span class="stat-label"><?php echo _n('carte', 'cărți', $books_count, 'flavor'); ?></span>
                    </div>
                    <?php if ($authors_count > 0) : ?>
                        <div class="stat-item">
                            <span class="stat-number"><?php echo esc_html($authors_count); ?></span>
                            <span class="stat-label"><?php echo _n('autor', 'autori', $authors_count, 'flavor'); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Epoca Navigation -->
    <nav class="epoca-nav" aria-label="Navigare epoci">
        <div class="container">
            <ul class="epoca-nav-list">
                <?php
                $all_epoci = get_terms([
                    'taxonomy' => 'epoca',
                    'hide_empty' => true,
                    'orderby' => 'term_order',
                    'order' => 'ASC',
                ]);
                
                if (!is_wp_error($all_epoci)) :
                    foreach ($all_epoci as $epoca) :
                        $is_active = $epoca->term_id === $term->term_id;
                        $epoca_link_colors = bpt_get_epoca_colors($epoca->slug);
                        ?>
                        <li>
                            <a href="<?php echo esc_url(get_term_link($epoca)); ?>" 
                               class="epoca-nav-link <?php echo $is_active ? 'active' : ''; ?>"
                               style="--epoca-color: <?php echo esc_attr($epoca_link_colors['text']); ?>;"
                               <?php echo $is_active ? 'aria-current="page"' : ''; ?>>
                                <?php echo esc_html($epoca->name); ?>
                                <span class="count">(<?php echo esc_html($epoca->count); ?>)</span>
                            </a>
                        </li>
                    <?php
                    endforeach;
                endif;
                ?>
            </ul>
        </div>
    </nav>
    
    <!-- Epoca Content -->
    <section class="epoca-content section">
        <div class="container">
            
            <?php if ($caracteristici || $autori_reprezentativi) : ?>
                <div class="epoca-info">
                    <?php if ($caracteristici) : ?>
                        <div class="info-block">
                            <h2 class="info-title"><?php esc_html_e('Caracteristici', 'flavor'); ?></h2>
                            <div class="info-content">
                                <?php echo wp_kses_post($caracteristici); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($autori_reprezentativi) : ?>
                        <div class="info-block">
                            <h2 class="info-title"><?php esc_html_e('Autori reprezentativi', 'flavor'); ?></h2>
                            <div class="info-content">
                                <?php echo wp_kses_post($autori_reprezentativi); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <!-- Sorting -->
            <div class="archive-controls">
                <div class="results-count">
                    <?php
                    printf(
                        _n('%s carte din epoca %s', '%s cărți din epoca %s', $wp_query->found_posts, 'flavor'),
                        number_format_i18n($wp_query->found_posts),
                        '<strong>' . esc_html($term->name) . '</strong>'
                    );
                    ?>
                </div>
                
                <div class="sort-controls">
                    <label for="sort-select" class="sr-only"><?php esc_html_e('Sortare', 'flavor'); ?></label>
                    <select id="sort-select" class="sort-select" onchange="window.location.href=this.value">
                        <option value="<?php echo esc_url(add_query_arg('orderby', 'title', get_term_link($term))); ?>"
                                <?php selected(get_query_var('orderby'), 'title'); ?>>
                            <?php esc_html_e('Alfabetic', 'flavor'); ?>
                        </option>
                        <option value="<?php echo esc_url(add_query_arg('orderby', 'an_scriere', get_term_link($term))); ?>"
                                <?php selected(get_query_var('orderby'), 'an_scriere'); ?>>
                            <?php esc_html_e('An scriere', 'flavor'); ?>
                        </option>
                        <option value="<?php echo esc_url(add_query_arg('orderby', 'nr_bpt', get_term_link($term))); ?>"
                                <?php selected(get_query_var('orderby'), 'nr_bpt'); ?>>
                            <?php esc_html_e('Nr. BPT', 'flavor'); ?>
                        </option>
                    </select>
                </div>
            </div>
            
            <?php if (have_posts()) : ?>
                
                <div class="books-grid">
                    <?php
                    while (have_posts()) :
                        the_post();
                        echo bpt_get_carte_card(get_the_ID(), 'medium');
                    endwhile;
                    ?>
                </div>
                
                <?php bpt_pagination(); ?>
                
            <?php else : ?>
                
                <div class="no-results">
                    <div class="no-results-icon">
                        <?php echo bpt_icon('book'); ?>
                    </div>
                    <h2><?php esc_html_e('Nu am găsit cărți', 'flavor'); ?></h2>
                    <p><?php printf(esc_html__('Nu există încă cărți catalogate pentru epoca %s.', 'flavor'), esc_html($term->name)); ?></p>
                    
                    <a href="<?php echo esc_url(get_post_type_archive_link('carte')); ?>" class="btn btn-primary">
                        <?php esc_html_e('Vezi toate cărțile', 'flavor'); ?>
                    </a>
                </div>
                
            <?php endif; ?>
            
        </div>
    </section>
    
    <!-- Related Epoci -->
    <?php
    // Get adjacent epoci for navigation
    $epoca_order = ['antichitate', 'medieval', 'renastere', 'clasicism', 'romantism', 'realism', 'modernism', 'contemporan'];
    $current_index = array_search($term->slug, $epoca_order);
    $prev_epoca = $current_index > 0 ? get_term_by('slug', $epoca_order[$current_index - 1], 'epoca') : false;
    $next_epoca = $current_index < count($epoca_order) - 1 ? get_term_by('slug', $epoca_order[$current_index + 1], 'epoca') : false;
    
    if ($prev_epoca || $next_epoca) :
    ?>
    <nav class="epoca-pagination section" aria-label="Navigare între epoci">
        <div class="container">
            <div class="epoca-pagination-inner">
                <?php if ($prev_epoca) : 
                    $prev_colors = bpt_get_epoca_colors($prev_epoca->slug);
                ?>
                    <a href="<?php echo esc_url(get_term_link($prev_epoca)); ?>" class="epoca-pagination-link prev"
                       style="--link-color: <?php echo esc_attr($prev_colors['text']); ?>;">
                        <span class="direction"><?php echo bpt_icon('arrow-left'); ?> Epoca anterioară</span>
                        <span class="epoca-name"><?php echo esc_html($prev_epoca->name); ?></span>
                    </a>
                <?php else : ?>
                    <span class="epoca-pagination-placeholder"></span>
                <?php endif; ?>
                
                <?php if ($next_epoca) : 
                    $next_colors = bpt_get_epoca_colors($next_epoca->slug);
                ?>
                    <a href="<?php echo esc_url(get_term_link($next_epoca)); ?>" class="epoca-pagination-link next"
                       style="--link-color: <?php echo esc_attr($next_colors['text']); ?>;">
                        <span class="direction">Epoca următoare <?php echo bpt_icon('arrow-right'); ?></span>
                        <span class="epoca-name"><?php echo esc_html($next_epoca->name); ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <?php endif; ?>
    
</main>

<?php get_footer(); ?>
