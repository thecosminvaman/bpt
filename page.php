<?php
/**
 * Page Template
 *
 * Template for displaying all pages.
 *
 * @package Biblioteca_Pentru_Toti
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<div class="page-content">
    <?php while ( have_posts() ) : the_post(); ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-page' ); ?>>
            
            <header class="single-page__header">
                <div class="container container--narrow">
                    <h1 class="single-page__title"><?php the_title(); ?></h1>
                </div>
            </header>
            
            <?php if ( has_post_thumbnail() ) : ?>
                <figure class="single-page__featured-image">
                    <div class="container">
                        <?php the_post_thumbnail( 'full', array( 'class' => 'featured-image' ) ); ?>
                    </div>
                </figure>
            <?php endif; ?>
            
            <div class="single-page__content">
                <div class="container container--narrow">
                    <div class="prose">
                        <?php the_content(); ?>
                    </div>
                    
                    <?php
                    wp_link_pages( array(
                        'before'      => '<nav class="page-links"><span class="page-links__title">' . esc_html__( 'Pagini:', 'biblioteca-pentru-toti' ) . '</span>',
                        'after'       => '</nav>',
                        'link_before' => '<span class="page-links__item">',
                        'link_after'  => '</span>',
                    ) );
                    ?>
                </div>
            </div>
            
        </article>
        
        <?php
        // If comments are open or there are comments, load the comment template.
        if ( comments_open() || get_comments_number() ) :
        ?>
            <section class="single-page__comments">
                <div class="container container--narrow">
                    <?php comments_template(); ?>
                </div>
            </section>
        <?php endif; ?>
        
    <?php endwhile; ?>
</div>

<?php
get_footer();
