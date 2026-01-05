<?php
/**
 * Template Name: Pagină principală
 * 
 * Homepage template with hero, featured content, and discovery sections
 * 
 * @package Biblioteca_Pentru_Toti
 */

get_header();

// Get settings from customizer
$show_hero = get_theme_mod('bpt_show_hero', true);
$show_stats = get_theme_mod('bpt_show_stats', true);
$show_epoci = get_theme_mod('bpt_show_epoci', true);
$show_featured = get_theme_mod('bpt_show_featured', true);
$show_timeline_preview = get_theme_mod('bpt_show_timeline_preview', true);
$show_newsletter = get_theme_mod('bpt_show_newsletter', true);

// Get featured books
$featured_books = get_posts([
    'post_type' => 'carte',
    'posts_per_page' => 6,
    'meta_query' => [
        [
            'key' => 'featured',
            'value' => '1',
            'compare' => '=',
        ]
    ]
]);

// Fallback to recent if no featured
if (empty($featured_books)) {
    $featured_books = get_posts([
        'post_type' => 'carte',
        'posts_per_page' => 6,
        'orderby' => 'date',
        'order' => 'DESC',
    ]);
}

// Get recent timeline events
$timeline_events = get_posts([
    'post_type' => 'eveniment',
    'posts_per_page' => 4,
    'meta_key' => 'data_eveniment',
    'orderby' => 'meta_value',
    'order' => 'ASC',
]);
?>

<main id="main-content" class="site-main homepage">
    
    <!-- Hero Section -->
    <?php if ($show_hero) : ?>
        <?php get_template_part('template-parts/hero'); ?>
    <?php endif; ?>
    
    <!-- Stats Section -->
    <?php if ($show_stats) : ?>
        <section class="section section-stats" aria-labelledby="stats-title">
            <div class="container">
                <h2 id="stats-title" class="sr-only"><?php esc_html_e('Colecția în cifre', 'flavor'); ?></h2>
                <?php get_template_part('template-parts/stats', 'counter'); ?>
            </div>
        </section>
    <?php endif; ?>
    
    <!-- Browse by Epoca -->
    <?php if ($show_epoci) : ?>
        <section class="section section-epoci" aria-labelledby="epoci-title">
            <div class="container">
                <header class="section-header">
                    <h2 id="epoci-title" class="section-title">
                        <?php esc_html_e('Explorează pe epoci', 'flavor'); ?>
                    </h2>
                    <p class="section-subtitle">
                        <?php esc_html_e('De la Antichitate la Contemporan, descoperă literatura universală prin prisma colecției BPT.', 'flavor'); ?>
                    </p>
                </header>
                
                <?php get_template_part('template-parts/epoch', 'grid'); ?>
            </div>
        </section>
    <?php endif; ?>
    
    <!-- Featured Books -->
    <?php if ($show_featured && !empty($featured_books)) : ?>
        <section class="section section-featured section-alt" aria-labelledby="featured-title">
            <div class="container">
                <header class="section-header">
                    <h2 id="featured-title" class="section-title">
                        <?php esc_html_e('Cărți de referință', 'flavor'); ?>
                    </h2>
                    <p class="section-subtitle">
                        <?php esc_html_e('Titluri esențiale din colecția Biblioteca pentru Toți', 'flavor'); ?>
                    </p>
                </header>
                
                <div class="books-grid books-grid-featured">
                    <?php foreach ($featured_books as $book) : 
                        setup_postdata($book);
                        echo bpt_get_carte_card($book->ID, 'featured');
                    endforeach; 
                    wp_reset_postdata();
                    ?>
                </div>
                
                <div class="section-footer">
                    <a href="<?php echo esc_url(get_post_type_archive_link('carte')); ?>" class="btn btn-secondary">
                        <?php esc_html_e('Vezi toate cărțile', 'flavor'); ?>
                        <?php echo bpt_icon('arrow-right'); ?>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
    <!-- About Section -->
    <section class="section section-about" id="despre" aria-labelledby="about-title">
        <div class="container container-narrow">
            <header class="section-header section-header-centered">
                <h2 id="about-title" class="section-title">
                    <?php esc_html_e('Despre colecție', 'flavor'); ?>
                </h2>
            </header>
            
            <div class="about-content prose">
                <p class="lead">
                    <?php esc_html_e('Biblioteca pentru Toți a fost cea mai longevivă și mai accesibilă colecție de literatură din România socialistă, publicând între 1953 și 1989 peste 800 de volume.', 'flavor'); ?>
                </p>
                
                <p>
                    <?php esc_html_e('Colecția a adus în casele românilor opere fundamentale ale literaturii universale și naționale, de la clasicii antici la moderniști, de la Dostoievski la Caragiale. Formatele de buzunar și prețurile accesibile au democratizat accesul la cultură într-o perioadă în care alternativele erau limitate.', 'flavor'); ?>
                </p>
                
                <p>
                    <?php esc_html_e('Acest proiect digital își propune să catalogheze și să celebreze această moștenire culturală, oferind informații detaliate despre fiecare volum, autorii incluși și contextul istoric al publicării.', 'flavor'); ?>
                </p>
            </div>
            
            <div class="about-timeline-preview">
                <div class="timeline-decades">
                    <?php
                    $decades = ['1950', '1960', '1970', '1980'];
                    foreach ($decades as $decade) :
                        // Count books in this decade
                        $count = count(get_posts([
                            'post_type' => 'carte',
                            'posts_per_page' => -1,
                            'fields' => 'ids',
                            'meta_query' => [
                                [
                                    'key' => 'an_publicare_bpt',
                                    'value' => [$decade, ($decade + 9)],
                                    'compare' => 'BETWEEN',
                                    'type' => 'NUMERIC',
                                ]
                            ]
                        ]));
                    ?>
                        <div class="decade-item">
                            <span class="decade-label"><?php echo esc_html($decade); ?>s</span>
                            <span class="decade-bar" style="--height: <?php echo esc_attr(min($count / 3, 100)); ?>%;"></span>
                            <span class="decade-count"><?php echo esc_html($count); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Timeline Preview -->
    <?php if ($show_timeline_preview && !empty($timeline_events)) : ?>
        <section class="section section-timeline-preview section-alt" aria-labelledby="timeline-title">
            <div class="container">
                <header class="section-header">
                    <h2 id="timeline-title" class="section-title">
                        <?php esc_html_e('Cronologia BPT', 'flavor'); ?>
                    </h2>
                    <p class="section-subtitle">
                        <?php esc_html_e('Momente importante din istoria colecției', 'flavor'); ?>
                    </p>
                </header>
                
                <div class="timeline timeline-preview">
                    <?php 
                    $i = 0;
                    foreach ($timeline_events as $event) : 
                        setup_postdata($event);
                        global $post;
                        $post = $event;
                        get_template_part('template-parts/timeline', 'item', ['index' => $i]);
                        $i++;
                    endforeach; 
                    wp_reset_postdata();
                    ?>
                </div>
                
                <div class="section-footer">
                    <a href="<?php echo esc_url(get_post_type_archive_link('eveniment')); ?>" class="btn btn-secondary">
                        <?php esc_html_e('Vezi cronologia completă', 'flavor'); ?>
                        <?php echo bpt_icon('arrow-right'); ?>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
    <!-- Newsletter Section -->
    <?php if ($show_newsletter) : ?>
        <section class="section section-newsletter" aria-labelledby="newsletter-title">
            <div class="container container-narrow">
                <div class="newsletter-box">
                    <h2 id="newsletter-title" class="newsletter-title">
                        <?php esc_html_e('Primește noutăți despre colecție', 'flavor'); ?>
                    </h2>
                    <p class="newsletter-description">
                        <?php esc_html_e('Abonează-te pentru a primi actualizări când adăugăm noi volume și descoperiri.', 'flavor'); ?>
                    </p>
                    
                    <form class="newsletter-form" action="#" method="post">
                        <div class="newsletter-input-group">
                            <label for="newsletter-email" class="sr-only">
                                <?php esc_html_e('Adresa de email', 'flavor'); ?>
                            </label>
                            <input type="email" 
                                   id="newsletter-email" 
                                   name="email" 
                                   class="newsletter-input"
                                   placeholder="<?php esc_attr_e('Adresa ta de email', 'flavor'); ?>"
                                   required>
                            <button type="submit" class="btn btn-primary newsletter-submit">
                                <?php esc_html_e('Abonare', 'flavor'); ?>
                            </button>
                        </div>
                        <p class="newsletter-privacy">
                            <?php esc_html_e('Nu trimitem spam. Te poți dezabona oricând.', 'flavor'); ?>
                        </p>
                    </form>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
</main>

<?php get_footer(); ?>
