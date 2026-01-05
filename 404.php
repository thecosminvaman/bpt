<?php
/**
 * 404 Template
 *
 * The template for displaying 404 pages (not found).
 *
 * @package Biblioteca_Pentru_Toti
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<div class="error-404">
    <div class="container">
        <div class="error-404__content">
            <div class="error-404__illustration">
                <span class="error-404__number">404</span>
                <div class="error-404__book">
                    <?php echo bpt_icon( 'book-open' ); ?>
                </div>
            </div>
            
            <h1 class="error-404__title"><?php esc_html_e( 'Pagina căutată nu există', 'biblioteca-pentru-toti' ); ?></h1>
            
            <p class="error-404__message">
                <?php esc_html_e( 'Se pare că această pagină s-a pierdut printre rafturi. Încearcă o căutare sau explorează colecția noastră.', 'biblioteca-pentru-toti' ); ?>
            </p>
            
            <div class="error-404__search">
                <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <label for="error-search" class="screen-reader-text"><?php esc_html_e( 'Caută', 'biblioteca-pentru-toti' ); ?></label>
                    <input type="search" 
                           id="error-search"
                           class="search-form__input" 
                           placeholder="<?php esc_attr_e( 'Caută în colecție...', 'biblioteca-pentru-toti' ); ?>" 
                           name="s">
                    <button type="submit" class="search-form__submit btn btn--primary">
                        <?php esc_html_e( 'Caută', 'biblioteca-pentru-toti' ); ?>
                    </button>
                </form>
            </div>
            
            <div class="error-404__links">
                <p class="error-404__links-label"><?php esc_html_e( 'Sau explorează:', 'biblioteca-pentru-toti' ); ?></p>
                <nav class="error-404__nav">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn--secondary">
                        <?php echo bpt_icon( 'home' ); ?>
                        <?php esc_html_e( 'Pagina principală', 'biblioteca-pentru-toti' ); ?>
                    </a>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'carte' ) ); ?>" class="btn btn--secondary">
                        <?php echo bpt_icon( 'book' ); ?>
                        <?php esc_html_e( 'Colecția de cărți', 'biblioteca-pentru-toti' ); ?>
                    </a>
                    <a href="<?php echo esc_url( home_url( '/cronologie/' ) ); ?>" class="btn btn--secondary">
                        <?php echo bpt_icon( 'timeline' ); ?>
                        <?php esc_html_e( 'Cronologie', 'biblioteca-pentru-toti' ); ?>
                    </a>
                </nav>
            </div>
        </div>
        
        <?php
        // Show some random books as suggestions
        $random_books = new WP_Query( array(
            'post_type'      => 'carte',
            'posts_per_page' => 4,
            'orderby'        => 'rand',
        ) );
        
        if ( $random_books->have_posts() ) :
        ?>
            <section class="error-404__suggestions">
                <h2 class="section-title"><?php esc_html_e( 'Poate te interesează:', 'biblioteca-pentru-toti' ); ?></h2>
                <div class="books-grid books-grid--4">
                    <?php
                    while ( $random_books->have_posts() ) :
                        $random_books->the_post();
                        get_template_part( 'template-parts/card', 'carte-compact' );
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </section>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
