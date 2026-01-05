<?php
/**
 * Single Post Template
 *
 * Template for displaying single blog posts.
 *
 * @package Biblioteca_Pentru_Toti
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post' ); ?>>
    
    <?php while ( have_posts() ) : the_post(); ?>
        
        <header class="single-post__header">
            <div class="container container--narrow">
                <?php
                $categories = get_the_category();
                if ( ! empty( $categories ) ) :
                ?>
                    <div class="single-post__categories">
                        <?php foreach ( $categories as $cat ) : ?>
                            <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="category-link">
                                <?php echo esc_html( $cat->name ); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <h1 class="single-post__title"><?php the_title(); ?></h1>
                
                <?php if ( has_excerpt() ) : ?>
                    <p class="single-post__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
                <?php endif; ?>
                
                <div class="single-post__meta">
                    <div class="single-post__author">
                        <?php echo get_avatar( get_the_author_meta( 'ID' ), 48, '', '', array( 'class' => 'author-avatar' ) ); ?>
                        <div class="author-info">
                            <span class="author-name">
                                <?php
                                printf(
                                    /* translators: %s: post author */
                                    esc_html__( 'de %s', 'biblioteca-pentru-toti' ),
                                    '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
                                );
                                ?>
                            </span>
                            <span class="post-date">
                                <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                    <?php echo esc_html( get_the_date() ); ?>
                                </time>
                            </span>
                        </div>
                    </div>
                    
                    <?php
                    // Estimated reading time
                    $content = get_the_content();
                    $word_count = str_word_count( strip_tags( $content ) );
                    $reading_time = ceil( $word_count / 200 );
                    ?>
                    <span class="single-post__reading-time">
                        <?php
                        printf(
                            /* translators: %d: reading time in minutes */
                            esc_html( _n( '%d min citire', '%d min citire', $reading_time, 'biblioteca-pentru-toti' ) ),
                            esc_html( $reading_time )
                        );
                        ?>
                    </span>
                </div>
            </div>
        </header>
        
        <?php if ( has_post_thumbnail() ) : ?>
            <figure class="single-post__featured-image">
                <div class="container">
                    <?php the_post_thumbnail( 'full', array( 'class' => 'featured-image' ) ); ?>
                    <?php
                    $caption = get_the_post_thumbnail_caption();
                    if ( $caption ) :
                    ?>
                        <figcaption class="featured-image__caption">
                            <?php echo esc_html( $caption ); ?>
                        </figcaption>
                    <?php endif; ?>
                </div>
            </figure>
        <?php endif; ?>
        
        <div class="single-post__content">
            <div class="container container--narrow">
                <div class="prose prose--article">
                    <?php the_content(); ?>
                </div>
                
                <?php
                // Post tags
                $tags = get_the_tags();
                if ( $tags ) :
                ?>
                    <footer class="single-post__footer">
                        <div class="single-post__tags">
                            <span class="tags-label"><?php esc_html_e( 'Etichete:', 'biblioteca-pentru-toti' ); ?></span>
                            <?php foreach ( $tags as $tag ) : ?>
                                <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="tag">
                                    <?php echo esc_html( $tag->name ); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </footer>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="single-post__share">
            <div class="container container--narrow">
                <div class="share-buttons">
                    <span class="share-buttons__label"><?php esc_html_e( 'Distribuie:', 'biblioteca-pentru-toti' ); ?></span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="share-button share-button--facebook"
                       aria-label="<?php esc_attr_e( 'Distribuie pe Facebook', 'biblioteca-pentru-toti' ); ?>">
                        <?php echo bpt_icon( 'facebook' ); ?>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode( get_permalink() ); ?>&text=<?php echo urlencode( get_the_title() ); ?>" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="share-button share-button--twitter"
                       aria-label="<?php esc_attr_e( 'Distribuie pe Twitter', 'biblioteca-pentru-toti' ); ?>">
                        <?php echo bpt_icon( 'twitter' ); ?>
                    </a>
                    <button class="share-button share-button--copy" 
                            data-url="<?php echo esc_url( get_permalink() ); ?>"
                            aria-label="<?php esc_attr_e( 'Copiază linkul', 'biblioteca-pentru-toti' ); ?>">
                        <?php echo bpt_icon( 'link' ); ?>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="single-post__author-box">
            <div class="container container--narrow">
                <div class="author-box">
                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 80, '', '', array( 'class' => 'author-box__avatar' ) ); ?>
                    <div class="author-box__info">
                        <h3 class="author-box__name">
                            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                                <?php the_author(); ?>
                            </a>
                        </h3>
                        <?php
                        $author_bio = get_the_author_meta( 'description' );
                        if ( $author_bio ) :
                        ?>
                            <p class="author-box__bio"><?php echo esc_html( $author_bio ); ?></p>
                        <?php endif; ?>
                        <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="author-box__link">
                            <?php esc_html_e( 'Vezi toate articolele', 'biblioteca-pentru-toti' ); ?> →
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <nav class="single-post__navigation post-navigation">
            <div class="container">
                <div class="post-navigation__inner">
                    <?php
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();
                    ?>
                    
                    <?php if ( $prev_post ) : ?>
                        <a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" class="post-navigation__link post-navigation__link--prev">
                            <span class="post-navigation__label"><?php echo bpt_icon( 'arrow-left' ); ?> <?php esc_html_e( 'Articol anterior', 'biblioteca-pentru-toti' ); ?></span>
                            <span class="post-navigation__title"><?php echo esc_html( get_the_title( $prev_post ) ); ?></span>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ( $next_post ) : ?>
                        <a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="post-navigation__link post-navigation__link--next">
                            <span class="post-navigation__label"><?php esc_html_e( 'Articol următor', 'biblioteca-pentru-toti' ); ?> <?php echo bpt_icon( 'arrow-right' ); ?></span>
                            <span class="post-navigation__title"><?php echo esc_html( get_the_title( $next_post ) ); ?></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
        
        <?php
        // Related posts
        $related_posts = new WP_Query( array(
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'post__not_in'   => array( get_the_ID() ),
            'category__in'   => wp_get_post_categories( get_the_ID() ),
            'orderby'        => 'rand',
        ) );
        
        if ( $related_posts->have_posts() ) :
        ?>
            <section class="single-post__related">
                <div class="container">
                    <h2 class="section-title"><?php esc_html_e( 'Articole similare', 'biblioteca-pentru-toti' ); ?></h2>
                    <div class="posts-grid posts-grid--3">
                        <?php
                        while ( $related_posts->have_posts() ) :
                            $related_posts->the_post();
                            get_template_part( 'template-parts/card', 'articol' );
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        
        <?php
        // Comments
        if ( comments_open() || get_comments_number() ) :
        ?>
            <section class="single-post__comments">
                <div class="container container--narrow">
                    <?php comments_template(); ?>
                </div>
            </section>
        <?php endif; ?>
        
    <?php endwhile; ?>
    
</article>

<?php
get_footer();
