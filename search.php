<?php
/**
 * Search Results Template
 *
 * Template for displaying search results.
 *
 * @package Biblioteca_Pentru_Toti
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<div class="search-results">
    <div class="container">
        <header class="search-results__header">
            <h1 class="search-results__title">
                <?php
                printf(
                    /* translators: %s: search query */
                    esc_html__( 'Rezultate pentru: „%s"', 'biblioteca-pentru-toti' ),
                    '<span class="search-query">' . esc_html( get_search_query() ) . '</span>'
                );
                ?>
            </h1>
            
            <?php if ( have_posts() ) : ?>
                <p class="search-results__count">
                    <?php
                    global $wp_query;
                    printf(
                        /* translators: %d: number of results */
                        esc_html( _n( '%d rezultat găsit', '%d rezultate găsite', $wp_query->found_posts, 'biblioteca-pentru-toti' ) ),
                        esc_html( $wp_query->found_posts )
                    );
                    ?>
                </p>
            <?php endif; ?>
            
            <form role="search" method="get" class="search-form search-form--large" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <label for="search-input" class="screen-reader-text"><?php esc_html_e( 'Caută', 'biblioteca-pentru-toti' ); ?></label>
                <input type="search" 
                       id="search-input"
                       class="search-form__input" 
                       placeholder="<?php esc_attr_e( 'Caută altceva...', 'biblioteca-pentru-toti' ); ?>" 
                       value="<?php echo get_search_query(); ?>" 
                       name="s">
                <button type="submit" class="search-form__submit btn btn--primary">
                    <?php echo bpt_icon( 'search' ); ?>
                    <?php esc_html_e( 'Caută', 'biblioteca-pentru-toti' ); ?>
                </button>
            </form>
        </header>
        
        <?php if ( have_posts() ) : ?>
            
            <?php
            // Group results by post type
            $results_by_type = array(
                'carte'     => array(),
                'eveniment' => array(),
                'post'      => array(),
                'page'      => array(),
            );
            
            while ( have_posts() ) :
                the_post();
                $post_type = get_post_type();
                if ( isset( $results_by_type[ $post_type ] ) ) {
                    $results_by_type[ $post_type ][] = get_the_ID();
                } else {
                    $results_by_type['post'][] = get_the_ID();
                }
            endwhile;
            rewind_posts();
            ?>
            
            <?php if ( ! empty( $results_by_type['carte'] ) ) : ?>
                <section class="search-results__section">
                    <h2 class="search-results__section-title">
                        <?php echo bpt_icon( 'book' ); ?>
                        <?php esc_html_e( 'Cărți', 'biblioteca-pentru-toti' ); ?>
                        <span class="count">(<?php echo count( $results_by_type['carte'] ); ?>)</span>
                    </h2>
                    <div class="books-grid books-grid--compact">
                        <?php
                        foreach ( $results_by_type['carte'] as $book_id ) :
                            $post = get_post( $book_id );
                            setup_postdata( $post );
                            get_template_part( 'template-parts/card', 'carte-compact' );
                        endforeach;
                        wp_reset_postdata();
                        ?>
                    </div>
                    <?php if ( count( $results_by_type['carte'] ) > 4 ) : ?>
                        <a href="<?php echo esc_url( add_query_arg( array( 's' => get_search_query(), 'post_type' => 'carte' ), home_url( '/' ) ) ); ?>" class="see-all-link">
                            <?php esc_html_e( 'Vezi toate cărțile', 'biblioteca-pentru-toti' ); ?> →
                        </a>
                    <?php endif; ?>
                </section>
            <?php endif; ?>
            
            <?php if ( ! empty( $results_by_type['eveniment'] ) ) : ?>
                <section class="search-results__section">
                    <h2 class="search-results__section-title">
                        <?php echo bpt_icon( 'timeline' ); ?>
                        <?php esc_html_e( 'Evenimente cronologie', 'biblioteca-pentru-toti' ); ?>
                        <span class="count">(<?php echo count( $results_by_type['eveniment'] ); ?>)</span>
                    </h2>
                    <div class="events-list">
                        <?php
                        foreach ( $results_by_type['eveniment'] as $event_id ) :
                            $post = get_post( $event_id );
                            setup_postdata( $post );
                            get_template_part( 'template-parts/card', 'eveniment' );
                        endforeach;
                        wp_reset_postdata();
                        ?>
                    </div>
                </section>
            <?php endif; ?>
            
            <?php if ( ! empty( $results_by_type['post'] ) ) : ?>
                <section class="search-results__section">
                    <h2 class="search-results__section-title">
                        <?php echo bpt_icon( 'article' ); ?>
                        <?php esc_html_e( 'Articole', 'biblioteca-pentru-toti' ); ?>
                        <span class="count">(<?php echo count( $results_by_type['post'] ); ?>)</span>
                    </h2>
                    <div class="posts-grid">
                        <?php
                        foreach ( $results_by_type['post'] as $post_id ) :
                            $post = get_post( $post_id );
                            setup_postdata( $post );
                            get_template_part( 'template-parts/card', 'articol' );
                        endforeach;
                        wp_reset_postdata();
                        ?>
                    </div>
                </section>
            <?php endif; ?>
            
            <?php if ( ! empty( $results_by_type['page'] ) ) : ?>
                <section class="search-results__section">
                    <h2 class="search-results__section-title">
                        <?php echo bpt_icon( 'page' ); ?>
                        <?php esc_html_e( 'Pagini', 'biblioteca-pentru-toti' ); ?>
                        <span class="count">(<?php echo count( $results_by_type['page'] ); ?>)</span>
                    </h2>
                    <ul class="pages-list">
                        <?php
                        foreach ( $results_by_type['page'] as $page_id ) :
                            $page = get_post( $page_id );
                        ?>
                            <li class="pages-list__item">
                                <a href="<?php echo esc_url( get_permalink( $page_id ) ); ?>">
                                    <?php echo esc_html( get_the_title( $page_id ) ); ?>
                                </a>
                                <?php if ( has_excerpt( $page_id ) ) : ?>
                                    <p class="pages-list__excerpt"><?php echo esc_html( get_the_excerpt( $page_id ) ); ?></p>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>
            
            <?php bpt_pagination(); ?>
            
        <?php else : ?>
            
            <div class="no-results">
                <div class="no-results__icon"><?php echo bpt_icon( 'search' ); ?></div>
                <h2 class="no-results__title"><?php esc_html_e( 'Nu am găsit rezultate', 'biblioteca-pentru-toti' ); ?></h2>
                <p class="no-results__message">
                    <?php esc_html_e( 'Încearcă să cauți cu alte cuvinte sau explorează colecția.', 'biblioteca-pentru-toti' ); ?>
                </p>
                
                <div class="no-results__suggestions">
                    <p class="suggestions-title"><?php esc_html_e( 'Sugestii:', 'biblioteca-pentru-toti' ); ?></p>
                    <ul class="suggestions-list">
                        <li><?php esc_html_e( 'Verifică ortografia cuvintelor', 'biblioteca-pentru-toti' ); ?></li>
                        <li><?php esc_html_e( 'Folosește cuvinte mai generale', 'biblioteca-pentru-toti' ); ?></li>
                        <li><?php esc_html_e( 'Încearcă sinonime', 'biblioteca-pentru-toti' ); ?></li>
                    </ul>
                </div>
                
                <div class="no-results__actions">
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'carte' ) ); ?>" class="btn btn--secondary">
                        <?php echo bpt_icon( 'book' ); ?>
                        <?php esc_html_e( 'Explorează colecția', 'biblioteca-pentru-toti' ); ?>
                    </a>
                </div>
            </div>
            
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
