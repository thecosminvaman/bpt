<?php
/**
 * Single Book (Carte) Template
 *
 * Two-column layout with book cover, details, and content.
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
    $nr_bpt           = function_exists( 'get_field' ) ? get_field( 'nr_bpt' ) : get_post_meta( get_the_ID(), 'nr_bpt', true );
    $an_scriere       = function_exists( 'get_field' ) ? get_field( 'an_scriere' ) : get_post_meta( get_the_ID(), 'an_scriere', true );
    $an_publicare_bpt = function_exists( 'get_field' ) ? get_field( 'an_publicare_bpt' ) : get_post_meta( get_the_ID(), 'an_publicare_bpt', true );
    $traducator       = function_exists( 'get_field' ) ? get_field( 'traducator' ) : get_post_meta( get_the_ID(), 'traducator', true );
    $prefata_de       = function_exists( 'get_field' ) ? get_field( 'prefata_de' ) : get_post_meta( get_the_ID(), 'prefata_de', true );
    $citat            = function_exists( 'get_field' ) ? get_field( 'citat_reprezentativ' ) : get_post_meta( get_the_ID(), 'citat_reprezentativ', true );
    $context_istoric  = function_exists( 'get_field' ) ? get_field( 'context_istoric' ) : get_post_meta( get_the_ID(), 'context_istoric', true );
    $link_cumparare   = function_exists( 'get_field' ) ? get_field( 'link_cumparare' ) : get_post_meta( get_the_ID(), 'link_cumparare', true );
    $in_domeniu_public = function_exists( 'get_field' ) ? get_field( 'in_domeniu_public' ) : get_post_meta( get_the_ID(), 'in_domeniu_public', true );
    $fisier_download  = function_exists( 'get_field' ) ? get_field( 'fisier_download' ) : get_post_meta( get_the_ID(), 'fisier_download', true );
    $nr_pagini        = function_exists( 'get_field' ) ? get_field( 'nr_pagini' ) : get_post_meta( get_the_ID(), 'nr_pagini', true );
    
    // Get taxonomies
    $autori        = get_the_terms( get_the_ID(), 'autor' );
    $genuri        = get_the_terms( get_the_ID(), 'gen_literar' );
    $epoci         = get_the_terms( get_the_ID(), 'epoca' );
    $limbi         = get_the_terms( get_the_ID(), 'limba_originala' );
    $serii         = get_the_terms( get_the_ID(), 'serie_bpt' );
    
    // Get epoca colors
    $epoca_colors = array( 'bg' => '#F5F3EE', 'text' => '#1A1A1A' );
    if ( $epoci && ! is_wp_error( $epoci ) ) {
        $epoca_slug = $epoci[0]->slug;
        $all_epoca_colors = bpt_get_epoca_colors();
        if ( isset( $all_epoca_colors[ $epoca_slug ] ) ) {
            $epoca_colors = $all_epoca_colors[ $epoca_slug ];
        }
    }
    
    // Get gen color for border
    $gen_color = '#8B0000';
    if ( $genuri && ! is_wp_error( $genuri ) ) {
        $gen_slug = $genuri[0]->slug;
        $all_gen_colors = bpt_get_gen_colors();
        if ( isset( $all_gen_colors[ $gen_slug ] ) ) {
            $gen_color = $all_gen_colors[ $gen_slug ];
        }
    }
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-carte' ); ?> 
         style="--epoca-bg: <?php echo esc_attr( $epoca_colors['bg'] ); ?>; --epoca-text: <?php echo esc_attr( $epoca_colors['text'] ); ?>; --gen-color: <?php echo esc_attr( $gen_color ); ?>;">
    
    <div class="single-carte__header" style="background-color: <?php echo esc_attr( $epoca_colors['bg'] ); ?>;">
        <div class="container">
            <div class="single-carte__header-inner">
                <?php if ( $nr_bpt ) : ?>
                    <span class="single-carte__nr">#<?php echo esc_html( $nr_bpt ); ?></span>
                <?php endif; ?>
                
                <?php if ( $epoci && ! is_wp_error( $epoci ) ) : ?>
                    <a href="<?php echo esc_url( get_term_link( $epoci[0] ) ); ?>" class="single-carte__epoca-badge">
                        <?php echo esc_html( $epoci[0]->name ); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="single-carte__content">
        <div class="container">
            <div class="single-carte__layout">
                
                <div class="single-carte__sidebar">
                    <div class="single-carte__cover-wrap">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <figure class="single-carte__cover">
                                <?php the_post_thumbnail( 'large', array( 'class' => 'single-carte__cover-image' ) ); ?>
                            </figure>
                        <?php else : ?>
                            <div class="single-carte__cover single-carte__cover--placeholder">
                                <span class="placeholder-icon"><?php echo bpt_icon( 'book' ); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <div class="single-carte__actions">
                            <?php if ( $in_domeniu_public && $fisier_download ) : 
                                $download_url = is_array( $fisier_download ) ? $fisier_download['url'] : $fisier_download;
                            ?>
                                <a href="<?php echo esc_url( $download_url ); ?>" 
                                   class="btn btn--primary btn--full" 
                                   download
                                   aria-label="<?php esc_attr_e( 'Descarcă cartea', 'biblioteca-pentru-toti' ); ?>">
                                    <?php echo bpt_icon( 'download' ); ?>
                                    <?php esc_html_e( 'Descarcă gratuit', 'biblioteca-pentru-toti' ); ?>
                                </a>
                            <?php endif; ?>
                            
                            <?php if ( $link_cumparare ) : ?>
                                <a href="<?php echo esc_url( $link_cumparare ); ?>" 
                                   class="btn btn--secondary btn--full" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   aria-label="<?php esc_attr_e( 'Cumpără cartea', 'biblioteca-pentru-toti' ); ?>">
                                    <?php echo bpt_icon( 'external-link' ); ?>
                                    <?php esc_html_e( 'Cumpără', 'biblioteca-pentru-toti' ); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="single-carte__facts card">
                        <h3 class="card__title"><?php esc_html_e( 'Detalii carte', 'biblioteca-pentru-toti' ); ?></h3>
                        <dl class="facts-list">
                            <?php if ( $nr_bpt ) : ?>
                                <div class="facts-list__item">
                                    <dt><?php esc_html_e( 'Nr. BPT', 'biblioteca-pentru-toti' ); ?></dt>
                                    <dd>#<?php echo esc_html( $nr_bpt ); ?></dd>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( $an_scriere ) : ?>
                                <div class="facts-list__item">
                                    <dt><?php esc_html_e( 'An scriere', 'biblioteca-pentru-toti' ); ?></dt>
                                    <dd><?php echo esc_html( bpt_format_year( $an_scriere ) ); ?></dd>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( $an_publicare_bpt ) : ?>
                                <div class="facts-list__item">
                                    <dt><?php esc_html_e( 'An publicare BPT', 'biblioteca-pentru-toti' ); ?></dt>
                                    <dd><?php echo esc_html( $an_publicare_bpt ); ?></dd>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( $nr_pagini ) : ?>
                                <div class="facts-list__item">
                                    <dt><?php esc_html_e( 'Pagini', 'biblioteca-pentru-toti' ); ?></dt>
                                    <dd><?php echo esc_html( $nr_pagini ); ?></dd>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( $limbi && ! is_wp_error( $limbi ) ) : ?>
                                <div class="facts-list__item">
                                    <dt><?php esc_html_e( 'Limba originală', 'biblioteca-pentru-toti' ); ?></dt>
                                    <dd><?php echo esc_html( $limbi[0]->name ); ?></dd>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( $traducator ) : ?>
                                <div class="facts-list__item">
                                    <dt><?php esc_html_e( 'Traducător', 'biblioteca-pentru-toti' ); ?></dt>
                                    <dd><?php echo esc_html( $traducator ); ?></dd>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( $prefata_de ) : ?>
                                <div class="facts-list__item">
                                    <dt><?php esc_html_e( 'Prefață de', 'biblioteca-pentru-toti' ); ?></dt>
                                    <dd><?php echo esc_html( $prefata_de ); ?></dd>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( $serii && ! is_wp_error( $serii ) ) : ?>
                                <div class="facts-list__item">
                                    <dt><?php esc_html_e( 'Serie', 'biblioteca-pentru-toti' ); ?></dt>
                                    <dd><?php echo esc_html( $serii[0]->name ); ?></dd>
                                </div>
                            <?php endif; ?>
                        </dl>
                    </div>
                </div>
                
                <div class="single-carte__main">
                    <header class="single-carte__title-block">
                        <h1 class="single-carte__title"><?php the_title(); ?></h1>
                        
                        <?php if ( $autori && ! is_wp_error( $autori ) ) : ?>
                            <p class="single-carte__author">
                                <?php esc_html_e( 'de', 'biblioteca-pentru-toti' ); ?>
                                <?php
                                $autor_links = array();
                                foreach ( $autori as $autor ) {
                                    $autor_links[] = sprintf(
                                        '<a href="%s">%s</a>',
                                        esc_url( get_term_link( $autor ) ),
                                        esc_html( $autor->name )
                                    );
                                }
                                echo wp_kses_post( implode( ', ', $autor_links ) );
                                ?>
                            </p>
                        <?php endif; ?>
                        
                        <div class="single-carte__tags">
                            <?php if ( $genuri && ! is_wp_error( $genuri ) ) : 
                                foreach ( $genuri as $gen ) :
                                    $gen_colors = bpt_get_gen_colors();
                                    $this_gen_color = isset( $gen_colors[ $gen->slug ] ) ? $gen_colors[ $gen->slug ] : '#8B0000';
                            ?>
                                <a href="<?php echo esc_url( get_term_link( $gen ) ); ?>" 
                                   class="tag tag--gen" 
                                   style="--tag-color: <?php echo esc_attr( $this_gen_color ); ?>">
                                    <?php echo esc_html( $gen->name ); ?>
                                </a>
                            <?php 
                                endforeach;
                            endif; 
                            ?>
                            
                            <?php if ( $epoci && ! is_wp_error( $epoci ) ) : 
                                foreach ( $epoci as $epoca ) :
                            ?>
                                <a href="<?php echo esc_url( get_term_link( $epoca ) ); ?>" class="tag tag--epoca">
                                    <?php echo esc_html( $epoca->name ); ?>
                                </a>
                            <?php 
                                endforeach;
                            endif; 
                            ?>
                        </div>
                    </header>
                    
                    <?php if ( $citat ) : ?>
                        <blockquote class="single-carte__quote pull-quote">
                            <p><?php echo esc_html( $citat ); ?></p>
                        </blockquote>
                    <?php endif; ?>
                    
                    <div class="single-carte__description prose">
                        <?php the_content(); ?>
                    </div>
                    
                    <?php if ( $context_istoric ) : ?>
                        <section class="single-carte__context">
                            <h2 class="section-title"><?php esc_html_e( 'Context istoric', 'biblioteca-pentru-toti' ); ?></h2>
                            <div class="prose">
                                <?php echo wp_kses_post( wpautop( $context_istoric ) ); ?>
                            </div>
                        </section>
                    <?php endif; ?>
                    
                    <?php
                    // Related events mentioning this book
                    $related_events = new WP_Query( array(
                        'post_type'      => 'eveniment',
                        'posts_per_page' => 5,
                        'meta_query'     => array(
                            array(
                                'key'     => 'carti_asociate',
                                'value'   => '"' . get_the_ID() . '"',
                                'compare' => 'LIKE',
                            ),
                        ),
                    ) );
                    
                    if ( $related_events->have_posts() ) :
                    ?>
                        <section class="single-carte__timeline">
                            <h2 class="section-title"><?php esc_html_e( 'Pe cronologie', 'biblioteca-pentru-toti' ); ?></h2>
                            <div class="mini-timeline">
                                <?php
                                while ( $related_events->have_posts() ) :
                                    $related_events->the_post();
                                    get_template_part( 'template-parts/timeline', 'item-mini' );
                                endwhile;
                                wp_reset_postdata();
                                ?>
                            </div>
                        </section>
                    <?php endif; ?>
                    
                    <?php
                    // Related books
                    $related_books = bpt_get_related_books( get_the_ID(), 4 );
                    
                    if ( $related_books->have_posts() ) :
                    ?>
                        <section class="single-carte__related">
                            <h2 class="section-title"><?php esc_html_e( 'Cărți similare', 'biblioteca-pentru-toti' ); ?></h2>
                            <div class="books-grid books-grid--compact">
                                <?php
                                while ( $related_books->have_posts() ) :
                                    $related_books->the_post();
                                    get_template_part( 'template-parts/card', 'carte-compact' );
                                endwhile;
                                wp_reset_postdata();
                                ?>
                            </div>
                        </section>
                    <?php endif; ?>
                    
                    <nav class="single-carte__navigation post-navigation">
                        <div class="post-navigation__inner">
                            <?php
                            $prev_post = get_previous_post();
                            $next_post = get_next_post();
                            ?>
                            
                            <?php if ( $prev_post ) : ?>
                                <a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" class="post-navigation__link post-navigation__link--prev">
                                    <span class="post-navigation__label"><?php echo bpt_icon( 'arrow-left' ); ?> <?php esc_html_e( 'Cartea anterioară', 'biblioteca-pentru-toti' ); ?></span>
                                    <span class="post-navigation__title"><?php echo esc_html( get_the_title( $prev_post ) ); ?></span>
                                </a>
                            <?php endif; ?>
                            
                            <?php if ( $next_post ) : ?>
                                <a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="post-navigation__link post-navigation__link--next">
                                    <span class="post-navigation__label"><?php esc_html_e( 'Cartea următoare', 'biblioteca-pentru-toti' ); ?> <?php echo bpt_icon( 'arrow-right' ); ?></span>
                                    <span class="post-navigation__title"><?php echo esc_html( get_the_title( $next_post ) ); ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </nav>
                    
                </div>
            </div>
        </div>
    </div>
</article>

<?php
endwhile;

get_footer();
