<?php
/**
 * Taxonomy Autor Archive Template
 * 
 * Shows author biography and all their books in the collection
 * 
 * @package Biblioteca_Pentru_Toti
 */

get_header();

$term = get_queried_object();

// Get author custom fields
$an_nastere = get_term_meta($term->term_id, 'an_nastere', true);
$an_deces = get_term_meta($term->term_id, 'an_deces', true);
$tara_origine = get_term_meta($term->term_id, 'tara_origine', true);
$biografie = get_term_meta($term->term_id, 'biografie_scurta', true);
$fotografie_id = get_term_meta($term->term_id, 'fotografie', true);
$wikipedia_link = get_term_meta($term->term_id, 'wikipedia_link', true);

// Format years
$years_display = '';
if ($an_nastere) {
    $years_display = $an_nastere;
    if ($an_deces) {
        $years_display .= ' – ' . $an_deces;
    } else {
        $years_display .= ' – prezent';
    }
}

// Get author's epoci
$author_books = get_posts([
    'post_type' => 'carte',
    'posts_per_page' => -1,
    'tax_query' => [
        [
            'taxonomy' => 'autor',
            'field' => 'term_id',
            'terms' => $term->term_id,
        ]
    ],
    'fields' => 'ids',
]);

$author_epoci = [];
$author_genres = [];

if (!empty($author_books)) {
    foreach ($author_books as $book_id) {
        $book_epoci = wp_get_post_terms($book_id, 'epoca', ['fields' => 'all']);
        $book_genres = wp_get_post_terms($book_id, 'gen-literar', ['fields' => 'all']);
        
        foreach ($book_epoci as $epoca) {
            $author_epoci[$epoca->term_id] = $epoca;
        }
        foreach ($book_genres as $gen) {
            $author_genres[$gen->term_id] = $gen;
        }
    }
}
?>

<main id="main-content" class="site-main taxonomy-autor">
    
    <!-- Author Header -->
    <header class="author-header">
        <div class="container">
            <?php bpt_breadcrumbs(); ?>
            
            <div class="author-header-content">
                <?php if ($fotografie_id) : ?>
                    <div class="author-portrait">
                        <?php echo wp_get_attachment_image($fotografie_id, 'medium', false, [
                            'class' => 'author-image',
                            'loading' => 'eager',
                        ]); ?>
                    </div>
                <?php else : ?>
                    <div class="author-portrait author-portrait-placeholder">
                        <?php echo bpt_icon('user'); ?>
                    </div>
                <?php endif; ?>
                
                <div class="author-info">
                    <h1 class="author-name"><?php echo esc_html($term->name); ?></h1>
                    
                    <div class="author-meta">
                        <?php if ($years_display) : ?>
                            <span class="author-years">
                                <?php echo bpt_icon('calendar'); ?>
                                <?php echo esc_html($years_display); ?>
                            </span>
                        <?php endif; ?>
                        
                        <?php if ($tara_origine) : ?>
                            <span class="author-country">
                                <?php echo bpt_icon('globe'); ?>
                                <?php echo esc_html($tara_origine); ?>
                            </span>
                        <?php endif; ?>
                        
                        <span class="author-books-count">
                            <?php echo bpt_icon('book'); ?>
                            <?php printf(_n('%s carte în colecție', '%s cărți în colecție', $term->count, 'flavor'), $term->count); ?>
                        </span>
                    </div>
                    
                    <?php if (!empty($author_epoci)) : ?>
                        <div class="author-epoci">
                            <?php foreach ($author_epoci as $epoca) : 
                                $colors = bpt_get_epoca_colors($epoca->slug);
                            ?>
                                <a href="<?php echo esc_url(get_term_link($epoca)); ?>" 
                                   class="epoca-tag"
                                   style="background-color: <?php echo esc_attr($colors['background']); ?>; color: <?php echo esc_attr($colors['text']); ?>;">
                                    <?php echo esc_html($epoca->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($wikipedia_link) : ?>
                        <a href="<?php echo esc_url($wikipedia_link); ?>" 
                           class="author-wikipedia-link" 
                           target="_blank" 
                           rel="noopener noreferrer">
                            <?php echo bpt_icon('external-link'); ?>
                            <?php esc_html_e('Wikipedia', 'flavor'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Author Biography -->
    <?php if ($biografie || $term->description) : ?>
        <section class="author-biography section">
            <div class="container container-narrow">
                <h2 class="section-title"><?php esc_html_e('Biografie', 'flavor'); ?></h2>
                <div class="biography-content prose">
                    <?php echo wp_kses_post($biografie ?: $term->description); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
    <!-- Author's Works -->
    <section class="author-works section">
        <div class="container">
            <header class="section-header">
                <h2 class="section-title">
                    <?php printf(esc_html__('Opere în colecția BPT', 'flavor')); ?>
                </h2>
                
                <?php if (!empty($author_genres)) : ?>
                    <div class="genre-filters">
                        <span class="filter-label"><?php esc_html_e('Genuri:', 'flavor'); ?></span>
                        <?php foreach ($author_genres as $gen) : 
                            $gen_colors = bpt_get_gen_colors($gen->slug);
                        ?>
                            <span class="genre-tag" style="border-color: <?php echo esc_attr($gen_colors['border']); ?>;">
                                <?php echo esc_html($gen->name); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </header>
            
            <?php if (have_posts()) : ?>
                
                <!-- View Toggle -->
                <div class="view-controls">
                    <button class="view-toggle active" data-view="grid" aria-pressed="true">
                        <?php echo bpt_icon('grid'); ?>
                        <span class="sr-only"><?php esc_html_e('Vedere grilă', 'flavor'); ?></span>
                    </button>
                    <button class="view-toggle" data-view="list" aria-pressed="false">
                        <?php echo bpt_icon('list'); ?>
                        <span class="sr-only"><?php esc_html_e('Vedere listă', 'flavor'); ?></span>
                    </button>
                </div>
                
                <div class="books-grid" id="books-container">
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
                    <p><?php esc_html_e('Nu există cărți de acest autor în colecție.', 'flavor'); ?></p>
                </div>
                
            <?php endif; ?>
        </div>
    </section>
    
    <!-- Related Authors (same epoca or country) -->
    <?php
    $related_authors = [];
    
    // Get authors from same country
    if ($tara_origine) {
        $country_authors = get_terms([
            'taxonomy' => 'autor',
            'hide_empty' => true,
            'number' => 6,
            'exclude' => [$term->term_id],
            'meta_query' => [
                [
                    'key' => 'tara_origine',
                    'value' => $tara_origine,
                ]
            ]
        ]);
        
        if (!is_wp_error($country_authors)) {
            $related_authors = array_merge($related_authors, $country_authors);
        }
    }
    
    // Limit to 4 authors
    $related_authors = array_slice($related_authors, 0, 4);
    
    if (!empty($related_authors)) :
    ?>
    <section class="related-authors section section-alt">
        <div class="container">
            <h2 class="section-title"><?php esc_html_e('Autori din aceeași țară', 'flavor'); ?></h2>
            
            <div class="authors-grid">
                <?php foreach ($related_authors as $related_author) : 
                    $rel_foto_id = get_term_meta($related_author->term_id, 'fotografie', true);
                    $rel_tara = get_term_meta($related_author->term_id, 'tara_origine', true);
                ?>
                    <a href="<?php echo esc_url(get_term_link($related_author)); ?>" class="author-card">
                        <div class="author-card-portrait">
                            <?php if ($rel_foto_id) : ?>
                                <?php echo wp_get_attachment_image($rel_foto_id, 'thumbnail', false, ['class' => 'author-card-image']); ?>
                            <?php else : ?>
                                <div class="author-card-placeholder">
                                    <?php echo bpt_icon('user'); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="author-card-info">
                            <h3 class="author-card-name"><?php echo esc_html($related_author->name); ?></h3>
                            <?php if ($rel_tara) : ?>
                                <span class="author-card-country"><?php echo esc_html($rel_tara); ?></span>
                            <?php endif; ?>
                            <span class="author-card-count">
                                <?php printf(_n('%s carte', '%s cărți', $related_author->count, 'flavor'), $related_author->count); ?>
                            </span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
</main>

<?php get_footer(); ?>
