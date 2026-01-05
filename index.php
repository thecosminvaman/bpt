<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme.
 * It is used to display a page when nothing more specific matches a query.
 *
 * @package Biblioteca_Pentru_Toti
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<div class="archive-page">
    <div class="container">
        <?php if ( is_home() && ! is_front_page() ) : ?>
            <header class="archive-page__header">
                <h1 class="archive-page__title"><?php single_post_title(); ?></h1>
                <?php
                $archive_description = get_the_archive_description();
                if ( $archive_description ) :
                ?>
                    <div class="archive-page__description">
                        <?php echo wp_kses_post( $archive_description ); ?>
                    </div>
                <?php endif; ?>
            </header>
        <?php elseif ( is_archive() ) : ?>
            <header class="archive-page__header">
                <?php the_archive_title( '<h1 class="archive-page__title">', '</h1>' ); ?>
                <?php the_archive_description( '<div class="archive-page__description">', '</div>' ); ?>
            </header>
        <?php elseif ( is_search() ) : ?>
            <header class="archive-page__header">
                <h1 class="archive-page__title">
                    <?php
                    printf(
                        /* translators: %s: search query */
                        esc_html__( 'Rezultate căutare pentru: %s', 'biblioteca-pentru-toti' ),
                        '<span class="search-query">' . esc_html( get_search_query() ) . '</span>'
                    );
                    ?>
                </h1>
            </header>
        <?php endif; ?>
        
        <div class="archive-page__content">
            <?php if ( is_active_sidebar( 'blog-sidebar' ) ) : ?>
                <div class="archive-page__layout archive-page__layout--with-sidebar">
            <?php else : ?>
                <div class="archive-page__layout">
            <?php endif; ?>
                
                <div class="archive-page__main">
                    <?php if ( have_posts() ) : ?>
                        <div class="posts-grid">
                            <?php
                            $counter = 0;
                            while ( have_posts() ) :
                                the_post();
                                $counter++;
                                
                                // First post gets featured treatment on blog home
                                if ( $counter === 1 && is_home() ) :
                                    get_template_part( 'template-parts/card', 'articol-featured' );
                                else :
                                    get_template_part( 'template-parts/card', 'articol' );
                                endif;
                            endwhile;
                            ?>
                        </div>
                        
                        <?php bpt_pagination(); ?>
                        
                    <?php else : ?>
                        <div class="no-results">
                            <h2 class="no-results__title">
                                <?php esc_html_e( 'Nu am găsit conținut', 'biblioteca-pentru-toti' ); ?>
                            </h2>
                            
                            <?php if ( is_search() ) : ?>
                                <p class="no-results__message">
                                    <?php esc_html_e( 'Niciun rezultat pentru căutarea ta. Încearcă alte cuvinte cheie.', 'biblioteca-pentru-toti' ); ?>
                                </p>
                                <?php get_search_form(); ?>
                            <?php else : ?>
                                <p class="no-results__message">
                                    <?php esc_html_e( 'Se pare că nu avem conținut aici. Poate o căutare te-ar ajuta?', 'biblioteca-pentru-toti' ); ?>
                                </p>
                                <?php get_search_form(); ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <?php if ( is_active_sidebar( 'blog-sidebar' ) ) : ?>
                    <aside class="archive-page__sidebar" role="complementary">
                        <?php dynamic_sidebar( 'blog-sidebar' ); ?>
                    </aside>
                <?php endif; ?>
                
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
