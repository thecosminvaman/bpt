<?php
/**
 * Single Event (Eveniment) Template
 *
 * Full-width article layout for timeline events.
 *
 * @package Biblioteca_Pentru_Toti
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

while ( have_posts() ) :
    the_post();
    
    // Get ACF fields or meta
    $data_eveniment   = function_exists( 'get_field' ) ? get_field( 'data_eveniment' ) : get_post_meta( get_the_ID(), 'data_eveniment', true );
    $data_afisata     = function_exists( 'get_field' ) ? get_field( 'data_afisata' ) : get_post_meta( get_the_ID(), 'data_afisata', true );
    $descriere_scurta = function_exists( 'get_field' ) ? get_field( 'descriere_scurta' ) : get_post_meta( get_the_ID(), 'descriere_scurta', true );
    $importanta       = function_exists( 'get_field' ) ? get_field( 'importanta' ) : get_post_meta( get_the_ID(), 'importanta', true );
    $culoare_marker   = function_exists( 'get_field' ) ? get_field( 'culoare_marker' ) : get_post_meta( get_the_ID(), 'culoare_marker', true );
    $galerie_imagini  = function_exists( 'get_field' ) ? get_field( 'galerie_imagini' ) : array();
    $carti_asociate   = function_exists( 'get_field' ) ? get_field( 'carti_asociate' ) : array();
    $citat_epoca      = function_exists( 'get_field' ) ? get_field( 'citat_epoca' ) : get_post_meta( get_the_ID(), 'citat_epoca', true );
    $sursa_informatie = function_exists( 'get_field' ) ? get_field( 'sursa_informatie' ) : get_post_meta( get_the_ID(), 'sursa_informatie', true );
    
    // Get taxonomy
    $tipuri_eveniment = get_the_terms( get_the_ID(), 'tip_eveniment' );
    
    // Format date
    $display_date = $data_afisata ?: ( $data_eveniment ? date_i18n( 'F Y', strtotime( $data_eveniment ) ) : '' );
    $year = $data_eveniment ? date( 'Y', strtotime( $data_eveniment ) ) : '';
    
    // Default marker color
    $marker_color = $culoare_marker ?: '#8B0000';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-eveniment' ); ?>>
    
    <?php if ( has_post_thumbnail() ) : ?>
        <header class="single-eveniment__hero">
            <figure class="single-eveniment__hero-image">
                <?php the_post_thumbnail( 'full', array( 'class' => 'cover-image' ) ); ?>
                <div class="single-eveniment__hero-overlay"></div>
            </figure>
            <div class="single-eveniment__hero-content">
                <div class="container">
                    <?php if ( $display_date ) : ?>
                        <div class="single-eveniment__date" style="--marker-color: <?php echo esc_attr( $marker_color ); ?>">
                            <span class="single-eveniment__date-text"><?php echo esc_html( $display_date ); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <h1 class="single-eveniment__title"><?php the_title(); ?></h1>
                    
                    <?php if ( $tipuri_eveniment && ! is_wp_error( $tipuri_eveniment ) ) : ?>
                        <div class="single-eveniment__types">
                            <?php foreach ( $tipuri_eveniment as $tip ) : ?>
                                <span class="tag tag--type"><?php echo esc_html( $tip->name ); ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </header>
    <?php else : ?>
        <header class="single-eveniment__header">
            <div class="container">
                <?php if ( $display_date ) : ?>
                    <div class="single-eveniment__date" style="--marker-color: <?php echo esc_attr( $marker_color ); ?>">
                        <span class="single-eveniment__date-text"><?php echo esc_html( $display_date ); ?></span>
                    </div>
                <?php endif; ?>
                
                <h1 class="single-eveniment__title"><?php the_title(); ?></h1>
                
                <?php if ( $tipuri_eveniment && ! is_wp_error( $tipuri_eveniment ) ) : ?>
                    <div class="single-eveniment__types">
                        <?php foreach ( $tipuri_eveniment as $tip ) : ?>
                            <span class="tag tag--type"><?php echo esc_html( $tip->name ); ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </header>
    <?php endif; ?>
    
    <div class="single-eveniment__content">
        <div class="container container--narrow">
            
            <?php if ( $descriere_scurta ) : ?>
                <p class="single-eveniment__lead"><?php echo esc_html( $descriere_scurta ); ?></p>
            <?php endif; ?>
            
            <div class="single-eveniment__body prose">
                <?php the_content(); ?>
            </div>
            
            <?php if ( $citat_epoca ) : ?>
                <blockquote class="single-eveniment__quote pull-quote">
                    <p><?php echo esc_html( $citat_epoca ); ?></p>
                </blockquote>
            <?php endif; ?>
            
            <?php if ( ! empty( $galerie_imagini ) ) : ?>
                <section class="single-eveniment__gallery">
                    <h2 class="section-title"><?php esc_html_e( 'Galerie', 'biblioteca-pentru-toti' ); ?></h2>
                    <div class="gallery-grid" data-lightbox="true">
                        <?php foreach ( $galerie_imagini as $image ) : 
                            $img_url = is_array( $image ) ? $image['url'] : wp_get_attachment_url( $image );
                            $img_alt = is_array( $image ) ? $image['alt'] : get_post_meta( $image, '_wp_attachment_image_alt', true );
                            $img_thumb = is_array( $image ) ? $image['sizes']['medium'] : wp_get_attachment_image_url( $image, 'medium' );
                        ?>
                            <a href="<?php echo esc_url( $img_url ); ?>" 
                               class="gallery-item"
                               data-lightbox-group="event-gallery">
                                <img src="<?php echo esc_url( $img_thumb ); ?>" 
                                     alt="<?php echo esc_attr( $img_alt ); ?>"
                                     loading="lazy">
                            </a>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
            
            <?php if ( ! empty( $carti_asociate ) ) : ?>
                <section class="single-eveniment__books">
                    <h2 class="section-title"><?php esc_html_e( 'Cărți menționate', 'biblioteca-pentru-toti' ); ?></h2>
                    <div class="books-grid books-grid--compact">
                        <?php 
                        foreach ( $carti_asociate as $carte ) :
                            // Handle both ACF object and ID
                            $carte_id = is_object( $carte ) ? $carte->ID : $carte;
                            $carte_post = get_post( $carte_id );
                            
                            if ( $carte_post ) :
                                setup_postdata( $GLOBALS['post'] =& $carte_post );
                                get_template_part( 'template-parts/card', 'carte-compact' );
                            endif;
                        endforeach;
                        wp_reset_postdata();
                        ?>
                    </div>
                </section>
            <?php endif; ?>
            
            <?php if ( $sursa_informatie ) : ?>
                <footer class="single-eveniment__source">
                    <p class="source-citation">
                        <strong><?php esc_html_e( 'Sursă:', 'biblioteca-pentru-toti' ); ?></strong>
                        <?php echo esc_html( $sursa_informatie ); ?>
                    </p>
                </footer>
            <?php endif; ?>
            
        </div>
    </div>
    
    <nav class="single-eveniment__navigation post-navigation">
        <div class="container">
            <div class="post-navigation__inner">
                <?php
                // Get adjacent events by date
                $prev_event = get_posts( array(
                    'post_type'      => 'eveniment',
                    'posts_per_page' => 1,
                    'meta_key'       => 'data_eveniment',
                    'orderby'        => 'meta_value',
                    'order'          => 'DESC',
                    'meta_query'     => array(
                        array(
                            'key'     => 'data_eveniment',
                            'value'   => $data_eveniment,
                            'compare' => '<',
                            'type'    => 'DATE',
                        ),
                    ),
                ) );
                
                $next_event = get_posts( array(
                    'post_type'      => 'eveniment',
                    'posts_per_page' => 1,
                    'meta_key'       => 'data_eveniment',
                    'orderby'        => 'meta_value',
                    'order'          => 'ASC',
                    'meta_query'     => array(
                        array(
                            'key'     => 'data_eveniment',
                            'value'   => $data_eveniment,
                            'compare' => '>',
                            'type'    => 'DATE',
                        ),
                    ),
                ) );
                ?>
                
                <?php if ( ! empty( $prev_event ) ) : 
                    $prev = $prev_event[0];
                    $prev_date = function_exists( 'get_field' ) ? get_field( 'data_afisata', $prev->ID ) : get_post_meta( $prev->ID, 'data_afisata', true );
                ?>
                    <a href="<?php echo esc_url( get_permalink( $prev ) ); ?>" class="post-navigation__link post-navigation__link--prev">
                        <span class="post-navigation__label"><?php echo bpt_icon( 'arrow-left' ); ?> <?php esc_html_e( 'Eveniment anterior', 'biblioteca-pentru-toti' ); ?></span>
                        <span class="post-navigation__date"><?php echo esc_html( $prev_date ); ?></span>
                        <span class="post-navigation__title"><?php echo esc_html( get_the_title( $prev ) ); ?></span>
                    </a>
                <?php endif; ?>
                
                <a href="<?php echo esc_url( home_url( '/cronologie/' ) ); ?>" class="post-navigation__link post-navigation__link--center">
                    <?php echo bpt_icon( 'timeline' ); ?>
                    <span><?php esc_html_e( 'Înapoi la cronologie', 'biblioteca-pentru-toti' ); ?></span>
                </a>
                
                <?php if ( ! empty( $next_event ) ) : 
                    $next = $next_event[0];
                    $next_date = function_exists( 'get_field' ) ? get_field( 'data_afisata', $next->ID ) : get_post_meta( $next->ID, 'data_afisata', true );
                ?>
                    <a href="<?php echo esc_url( get_permalink( $next ) ); ?>" class="post-navigation__link post-navigation__link--next">
                        <span class="post-navigation__label"><?php esc_html_e( 'Eveniment următor', 'biblioteca-pentru-toti' ); ?> <?php echo bpt_icon( 'arrow-right' ); ?></span>
                        <span class="post-navigation__date"><?php echo esc_html( $next_date ); ?></span>
                        <span class="post-navigation__title"><?php echo esc_html( get_the_title( $next ) ); ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
</article>

<?php
endwhile;

get_footer();
