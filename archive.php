<?php
/**
 * Generic Archive Template
 * 
 * @package Biblioteca_Pentru_Toti
 */

get_header();

$archive_title = '';
$archive_description = '';

if (is_category()) {
    $archive_title = single_cat_title('', false);
    $archive_description = category_description();
} elseif (is_tag()) {
    $archive_title = single_tag_title('', false);
    $archive_description = tag_description();
} elseif (is_author()) {
    $archive_title = get_the_author();
    $archive_description = get_the_author_meta('description');
} elseif (is_year()) {
    $archive_title = get_the_date('Y');
} elseif (is_month()) {
    $archive_title = get_the_date('F Y');
} elseif (is_day()) {
    $archive_title = get_the_date('j F Y');
} elseif (is_post_type_archive()) {
    $archive_title = post_type_archive_title('', false);
} else {
    $archive_title = __('Arhivă', 'flavor');
}
?>

<main id="main-content" class="site-main">
    
    <!-- Archive Header -->
    <header class="archive-header">
        <div class="container">
            <?php bpt_breadcrumbs(); ?>
            
            <h1 class="archive-title"><?php echo esc_html($archive_title); ?></h1>
            
            <?php if ($archive_description) : ?>
                <div class="archive-description">
                    <?php echo wp_kses_post($archive_description); ?>
                </div>
            <?php endif; ?>
            
            <?php if (have_posts()) : ?>
                <p class="archive-count">
                    <?php
                    printf(
                        _n('%s articol', '%s articole', $wp_query->found_posts, 'flavor'),
                        number_format_i18n($wp_query->found_posts)
                    );
                    ?>
                </p>
            <?php endif; ?>
        </div>
    </header>
    
    <!-- Archive Content -->
    <section class="archive-content section">
        <div class="container">
            
            <?php if (have_posts()) : ?>
                
                <div class="posts-grid">
                    <?php
                    while (have_posts()) :
                        the_post();
                        get_template_part('template-parts/card', 'articol');
                    endwhile;
                    ?>
                </div>
                
                <?php bpt_pagination(); ?>
                
            <?php else : ?>
                
                <div class="no-results">
                    <div class="no-results-icon">
                        <?php echo bpt_icon('search'); ?>
                    </div>
                    <h2><?php esc_html_e('Nu am găsit rezultate', 'flavor'); ?></h2>
                    <p><?php esc_html_e('Nu există articole în această arhivă.', 'flavor'); ?></p>
                    
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                        <?php esc_html_e('Înapoi la pagina principală', 'flavor'); ?>
                    </a>
                </div>
                
            <?php endif; ?>
            
        </div>
    </section>
    
</main>

<?php get_footer(); ?>
