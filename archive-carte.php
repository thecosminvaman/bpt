<?php
/**
 * Archive Template for Books (Carte)
 *
 * Displays the books collection with filters and multiple view options.
 *
 * @package Biblioteca_Pentru_Toti
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// Get view preference
$view = isset( $_GET['view'] ) ? sanitize_text_field( $_GET['view'] ) : get_theme_mod( 'books_default_view', 'grid' );
$sort = isset( $_GET['sort'] ) ? sanitize_text_field( $_GET['sort'] ) : get_theme_mod( 'books_default_sort', 'nr_bpt' );
?>

<div class="archive-carte">
    <header class="archive-carte__header">
        <div class="container">
            <div class="archive-carte__header-content">
                <h1 class="archive-carte__title"><?php esc_html_e( 'Colecția Biblioteca pentru Toți', 'biblioteca-pentru-toti' ); ?></h1>
                <p class="archive-carte__subtitle">
                    <?php
                    $total_books = wp_count_posts( 'carte' )->publish;
                    printf(
                        /* translators: %d: total number of books */
                        esc_html( _n( '%d carte în arhiva digitală', '%d cărți în arhiva digitală', $total_books, 'biblioteca-pentru-toti' ) ),
                        esc_html( $total_books )
                    );
                    ?>
                </p>
            </div>
            
            <div class="archive-carte__controls">
                <div class="archive-carte__view-toggle" role="tablist" aria-label="<?php esc_attr_e( 'Mod vizualizare', 'biblioteca-pentru-toti' ); ?>">
                    <button class="view-toggle__btn <?php echo $view === 'grid' ? 'is-active' : ''; ?>" 
                            data-view="grid"
                            role="tab"
                            aria-selected="<?php echo $view === 'grid' ? 'true' : 'false'; ?>"
                            aria-label="<?php esc_attr_e( 'Vizualizare grilă', 'biblioteca-pentru-toti' ); ?>">
                        <?php echo bpt_icon( 'grid' ); ?>
                    </button>
                    <button class="view-toggle__btn <?php echo $view === 'list' ? 'is-active' : ''; ?>" 
                            data-view="list"
                            role="tab"
                            aria-selected="<?php echo $view === 'list' ? 'true' : 'false'; ?>"
                            aria-label="<?php esc_attr_e( 'Vizualizare listă', 'biblioteca-pentru-toti' ); ?>">
                        <?php echo bpt_icon( 'list' ); ?>
                    </button>
                    <button class="view-toggle__btn <?php echo $view === 'compact' ? 'is-active' : ''; ?>" 
                            data-view="compact"
                            role="tab"
                            aria-selected="<?php echo $view === 'compact' ? 'true' : 'false'; ?>"
                            aria-label="<?php esc_attr_e( 'Vizualizare compactă', 'biblioteca-pentru-toti' ); ?>">
                        <?php echo bpt_icon( 'compact' ); ?>
                    </button>
                </div>
                
                <div class="archive-carte__sort">
                    <label for="sort-select" class="screen-reader-text"><?php esc_html_e( 'Sortare', 'biblioteca-pentru-toti' ); ?></label>
                    <select id="sort-select" class="sort-select" name="sort">
                        <option value="nr_bpt" <?php selected( $sort, 'nr_bpt' ); ?>><?php esc_html_e( 'Nr. BPT', 'biblioteca-pentru-toti' ); ?></option>
                        <option value="an_scriere" <?php selected( $sort, 'an_scriere' ); ?>><?php esc_html_e( 'An scriere', 'biblioteca-pentru-toti' ); ?></option>
                        <option value="an_publicare_bpt" <?php selected( $sort, 'an_publicare_bpt' ); ?>><?php esc_html_e( 'An publicare BPT', 'biblioteca-pentru-toti' ); ?></option>
                        <option value="title" <?php selected( $sort, 'title' ); ?>><?php esc_html_e( 'A-Z', 'biblioteca-pentru-toti' ); ?></option>
                        <option value="date" <?php selected( $sort, 'date' ); ?>><?php esc_html_e( 'Recent adăugate', 'biblioteca-pentru-toti' ); ?></option>
                    </select>
                </div>
                
                <button class="archive-carte__filter-toggle btn btn--secondary" aria-expanded="false" aria-controls="filters-sidebar">
                    <?php echo bpt_icon( 'filter' ); ?>
                    <?php esc_html_e( 'Filtre', 'biblioteca-pentru-toti' ); ?>
                    <span class="filter-count" hidden>0</span>
                </button>
            </div>
        </div>
    </header>
    
    <div class="archive-carte__content">
        <div class="container">
            <div class="archive-carte__layout">
                
                <aside id="filters-sidebar" class="archive-carte__sidebar" aria-label="<?php esc_attr_e( 'Filtre căutare', 'biblioteca-pentru-toti' ); ?>">
                    <div class="filters-sidebar">
                        <div class="filters-sidebar__header">
                            <h2 class="filters-sidebar__title"><?php esc_html_e( 'Filtrează colecția', 'biblioteca-pentru-toti' ); ?></h2>
                            <button class="filters-sidebar__close" aria-label="<?php esc_attr_e( 'Închide filtrele', 'biblioteca-pentru-toti' ); ?>">
                                <?php echo bpt_icon( 'close' ); ?>
                            </button>
                        </div>
                        
                        <form class="filters-form" id="books-filters" action="" method="get">
                            
                            <div class="filter-group">
                                <label for="filter-search" class="filter-group__label"><?php esc_html_e( 'Caută', 'biblioteca-pentru-toti' ); ?></label>
                                <div class="search-input-wrap">
                                    <input type="search" 
                                           id="filter-search" 
                                           name="search" 
                                           class="filter-input filter-input--search"
                                           placeholder="<?php esc_attr_e( 'Titlu, autor...', 'biblioteca-pentru-toti' ); ?>"
                                           value="<?php echo isset( $_GET['search'] ) ? esc_attr( $_GET['search'] ) : ''; ?>"
                                           autocomplete="off">
                                    <div class="search-autocomplete" hidden></div>
                                </div>
                            </div>
                            
                            <div class="filter-group">
                                <span class="filter-group__label"><?php esc_html_e( 'Epocă literară', 'biblioteca-pentru-toti' ); ?></span>
                                <div class="filter-buttons filter-buttons--epoca">
                                    <?php
                                    $epoci = get_terms( array(
                                        'taxonomy'   => 'epoca',
                                        'hide_empty' => true,
                                    ) );
                                    
                                    $selected_epoca = isset( $_GET['epoca'] ) ? (array) $_GET['epoca'] : array();
                                    $epoca_colors = bpt_get_epoca_colors();
                                    
                                    if ( ! is_wp_error( $epoci ) ) :
                                        foreach ( $epoci as $epoca ) :
                                            $colors = isset( $epoca_colors[ $epoca->slug ] ) ? $epoca_colors[ $epoca->slug ] : array( 'bg' => '#F5F3EE', 'text' => '#1A1A1A' );
                                            $is_selected = in_array( $epoca->slug, $selected_epoca );
                                    ?>
                                        <button type="button" 
                                                class="filter-btn filter-btn--epoca <?php echo $is_selected ? 'is-active' : ''; ?>"
                                                data-filter="epoca"
                                                data-value="<?php echo esc_attr( $epoca->slug ); ?>"
                                                style="--epoca-bg: <?php echo esc_attr( $colors['bg'] ); ?>; --epoca-text: <?php echo esc_attr( $colors['text'] ); ?>;">
                                            <?php echo esc_html( $epoca->name ); ?>
                                            <span class="count"><?php echo esc_html( $epoca->count ); ?></span>
                                        </button>
                                    <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </div>
                                <input type="hidden" name="epoca[]" value="" class="filter-hidden" data-filter="epoca">
                            </div>
                            
                            <div class="filter-group">
                                <span class="filter-group__label"><?php esc_html_e( 'Gen literar', 'biblioteca-pentru-toti' ); ?></span>
                                <div class="filter-checkboxes">
                                    <?php
                                    $genuri = get_terms( array(
                                        'taxonomy'   => 'gen_literar',
                                        'hide_empty' => true,
                                    ) );
                                    
                                    $selected_gen = isset( $_GET['gen'] ) ? (array) $_GET['gen'] : array();
                                    $gen_colors = bpt_get_gen_colors();
                                    
                                    if ( ! is_wp_error( $genuri ) ) :
                                        foreach ( $genuri as $gen ) :
                                            $color = isset( $gen_colors[ $gen->slug ] ) ? $gen_colors[ $gen->slug ] : '#8B0000';
                                            $is_selected = in_array( $gen->slug, $selected_gen );
                                    ?>
                                        <label class="filter-checkbox">
                                            <input type="checkbox" 
                                                   name="gen[]" 
                                                   value="<?php echo esc_attr( $gen->slug ); ?>"
                                                   <?php checked( $is_selected ); ?>>
                                            <span class="filter-checkbox__indicator" style="--gen-color: <?php echo esc_attr( $color ); ?>;"></span>
                                            <span class="filter-checkbox__label"><?php echo esc_html( $gen->name ); ?></span>
                                            <span class="filter-checkbox__count"><?php echo esc_html( $gen->count ); ?></span>
                                        </label>
                                    <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </div>
                            </div>
                            
                            <div class="filter-group">
                                <label for="filter-autor" class="filter-group__label"><?php esc_html_e( 'Autor', 'biblioteca-pentru-toti' ); ?></label>
                                <select id="filter-autor" name="autor" class="filter-select" data-searchable="true">
                                    <option value=""><?php esc_html_e( 'Toți autorii', 'biblioteca-pentru-toti' ); ?></option>
                                    <?php
                                    $autori = get_terms( array(
                                        'taxonomy'   => 'autor',
                                        'hide_empty' => true,
                                        'orderby'    => 'name',
                                        'order'      => 'ASC',
                                    ) );
                                    
                                    $selected_autor = isset( $_GET['autor'] ) ? sanitize_text_field( $_GET['autor'] ) : '';
                                    
                                    if ( ! is_wp_error( $autori ) ) :
                                        foreach ( $autori as $autor ) :
                                    ?>
                                        <option value="<?php echo esc_attr( $autor->slug ); ?>" <?php selected( $selected_autor, $autor->slug ); ?>>
                                            <?php echo esc_html( $autor->name ); ?> (<?php echo esc_html( $autor->count ); ?>)
                                        </option>
                                    <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
                            </div>
                            
                            <div class="filter-group">
                                <label for="filter-limba" class="filter-group__label"><?php esc_html_e( 'Limba originală', 'biblioteca-pentru-toti' ); ?></label>
                                <select id="filter-limba" name="limba" class="filter-select">
                                    <option value=""><?php esc_html_e( 'Toate limbile', 'biblioteca-pentru-toti' ); ?></option>
                                    <?php
                                    $limbi = get_terms( array(
                                        'taxonomy'   => 'limba_originala',
                                        'hide_empty' => true,
                                    ) );
                                    
                                    $selected_limba = isset( $_GET['limba'] ) ? sanitize_text_field( $_GET['limba'] ) : '';
                                    
                                    if ( ! is_wp_error( $limbi ) ) :
                                        foreach ( $limbi as $limba ) :
                                    ?>
                                        <option value="<?php echo esc_attr( $limba->slug ); ?>" <?php selected( $selected_limba, $limba->slug ); ?>>
                                            <?php echo esc_html( $limba->name ); ?> (<?php echo esc_html( $limba->count ); ?>)
                                        </option>
                                    <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
                            </div>
                            
                            <div class="filter-group">
                                <span class="filter-group__label"><?php esc_html_e( 'Nr. BPT', 'biblioteca-pentru-toti' ); ?></span>
                                <div class="filter-range">
                                    <input type="number" 
                                           name="nr_bpt_min" 
                                           class="filter-input filter-input--number"
                                           placeholder="<?php esc_attr_e( 'De la', 'biblioteca-pentru-toti' ); ?>"
                                           min="1"
                                           value="<?php echo isset( $_GET['nr_bpt_min'] ) ? esc_attr( $_GET['nr_bpt_min'] ) : ''; ?>">
                                    <span class="filter-range__separator">–</span>
                                    <input type="number" 
                                           name="nr_bpt_max" 
                                           class="filter-input filter-input--number"
                                           placeholder="<?php esc_attr_e( 'Până la', 'biblioteca-pentru-toti' ); ?>"
                                           value="<?php echo isset( $_GET['nr_bpt_max'] ) ? esc_attr( $_GET['nr_bpt_max'] ) : ''; ?>">
                                </div>
                            </div>
                            
                            <div class="filter-group">
                                <span class="filter-group__label"><?php esc_html_e( 'An scriere', 'biblioteca-pentru-toti' ); ?></span>
                                <div class="filter-range">
                                    <input type="number" 
                                           name="an_min" 
                                           class="filter-input filter-input--number"
                                           placeholder="<?php esc_attr_e( 'De la', 'biblioteca-pentru-toti' ); ?>"
                                           value="<?php echo isset( $_GET['an_min'] ) ? esc_attr( $_GET['an_min'] ) : ''; ?>">
                                    <span class="filter-range__separator">–</span>
                                    <input type="number" 
                                           name="an_max" 
                                           class="filter-input filter-input--number"
                                           placeholder="<?php esc_attr_e( 'Până la', 'biblioteca-pentru-toti' ); ?>"
                                           value="<?php echo isset( $_GET['an_max'] ) ? esc_attr( $_GET['an_max'] ) : ''; ?>">
                                </div>
                            </div>
                            
                            <div class="filter-group">
                                <label class="filter-checkbox filter-checkbox--single">
                                    <input type="checkbox" 
                                           name="domeniu_public" 
                                           value="1"
                                           <?php checked( isset( $_GET['domeniu_public'] ) && $_GET['domeniu_public'] == '1' ); ?>>
                                    <span class="filter-checkbox__indicator"></span>
                                    <span class="filter-checkbox__label"><?php esc_html_e( 'Doar în domeniu public', 'biblioteca-pentru-toti' ); ?></span>
                                </label>
                            </div>
                            
                            <div class="filters-form__actions">
                                <button type="submit" class="btn btn--primary btn--full"><?php esc_html_e( 'Aplică filtre', 'biblioteca-pentru-toti' ); ?></button>
                                <button type="reset" class="btn btn--ghost btn--full"><?php esc_html_e( 'Resetează', 'biblioteca-pentru-toti' ); ?></button>
                            </div>
                            
                        </form>
                    </div>
                </aside>
                
                <div class="archive-carte__main">
                    <div class="archive-carte__results" id="books-results">
                        <?php
                        // Build query args
                        $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
                        $per_page = get_theme_mod( 'books_per_page', 12 );
                        
                        $args = array(
                            'post_type'      => 'carte',
                            'posts_per_page' => $per_page,
                            'paged'          => $paged,
                        );
                        
                        // Sort handling
                        switch ( $sort ) {
                            case 'nr_bpt':
                                $args['meta_key'] = 'nr_bpt';
                                $args['orderby']  = 'meta_value_num';
                                $args['order']    = 'ASC';
                                break;
                            case 'an_scriere':
                                $args['meta_key'] = 'an_scriere';
                                $args['orderby']  = 'meta_value_num';
                                $args['order']    = 'ASC';
                                break;
                            case 'an_publicare_bpt':
                                $args['meta_key'] = 'an_publicare_bpt';
                                $args['orderby']  = 'meta_value_num';
                                $args['order']    = 'ASC';
                                break;
                            case 'title':
                                $args['orderby'] = 'title';
                                $args['order']   = 'ASC';
                                break;
                            case 'date':
                            default:
                                $args['orderby'] = 'date';
                                $args['order']   = 'DESC';
                                break;
                        }
                        
                        // Tax query
                        $tax_query = array( 'relation' => 'AND' );
                        
                        if ( ! empty( $_GET['epoca'] ) ) {
                            $tax_query[] = array(
                                'taxonomy' => 'epoca',
                                'field'    => 'slug',
                                'terms'    => array_map( 'sanitize_text_field', (array) $_GET['epoca'] ),
                            );
                        }
                        
                        if ( ! empty( $_GET['gen'] ) ) {
                            $tax_query[] = array(
                                'taxonomy' => 'gen_literar',
                                'field'    => 'slug',
                                'terms'    => array_map( 'sanitize_text_field', (array) $_GET['gen'] ),
                            );
                        }
                        
                        if ( ! empty( $_GET['autor'] ) ) {
                            $tax_query[] = array(
                                'taxonomy' => 'autor',
                                'field'    => 'slug',
                                'terms'    => sanitize_text_field( $_GET['autor'] ),
                            );
                        }
                        
                        if ( ! empty( $_GET['limba'] ) ) {
                            $tax_query[] = array(
                                'taxonomy' => 'limba_originala',
                                'field'    => 'slug',
                                'terms'    => sanitize_text_field( $_GET['limba'] ),
                            );
                        }
                        
                        if ( count( $tax_query ) > 1 ) {
                            $args['tax_query'] = $tax_query;
                        }
                        
                        // Meta query
                        $meta_query = array( 'relation' => 'AND' );
                        
                        if ( ! empty( $_GET['nr_bpt_min'] ) ) {
                            $meta_query[] = array(
                                'key'     => 'nr_bpt',
                                'value'   => intval( $_GET['nr_bpt_min'] ),
                                'compare' => '>=',
                                'type'    => 'NUMERIC',
                            );
                        }
                        
                        if ( ! empty( $_GET['nr_bpt_max'] ) ) {
                            $meta_query[] = array(
                                'key'     => 'nr_bpt',
                                'value'   => intval( $_GET['nr_bpt_max'] ),
                                'compare' => '<=',
                                'type'    => 'NUMERIC',
                            );
                        }
                        
                        if ( ! empty( $_GET['an_min'] ) ) {
                            $meta_query[] = array(
                                'key'     => 'an_scriere',
                                'value'   => intval( $_GET['an_min'] ),
                                'compare' => '>=',
                                'type'    => 'NUMERIC',
                            );
                        }
                        
                        if ( ! empty( $_GET['an_max'] ) ) {
                            $meta_query[] = array(
                                'key'     => 'an_scriere',
                                'value'   => intval( $_GET['an_max'] ),
                                'compare' => '<=',
                                'type'    => 'NUMERIC',
                            );
                        }
                        
                        if ( ! empty( $_GET['domeniu_public'] ) ) {
                            $meta_query[] = array(
                                'key'   => 'in_domeniu_public',
                                'value' => '1',
                            );
                        }
                        
                        if ( count( $meta_query ) > 1 ) {
                            $args['meta_query'] = $meta_query;
                        }
                        
                        // Search
                        if ( ! empty( $_GET['search'] ) ) {
                            $args['s'] = sanitize_text_field( $_GET['search'] );
                        }
                        
                        $books_query = new WP_Query( $args );
                        
                        if ( $books_query->have_posts() ) :
                        ?>
                            <div class="results-info">
                                <?php
                                printf(
                                    /* translators: %d: number of books found */
                                    esc_html( _n( '%d carte găsită', '%d cărți găsite', $books_query->found_posts, 'biblioteca-pentru-toti' ) ),
                                    esc_html( $books_query->found_posts )
                                );
                                ?>
                            </div>
                            
                            <div class="books-grid books-grid--<?php echo esc_attr( $view ); ?>" data-view="<?php echo esc_attr( $view ); ?>">
                                <?php
                                while ( $books_query->have_posts() ) :
                                    $books_query->the_post();
                                    
                                    switch ( $view ) {
                                        case 'list':
                                            get_template_part( 'template-parts/card', 'carte-list' );
                                            break;
                                        case 'compact':
                                            get_template_part( 'template-parts/card', 'carte-compact' );
                                            break;
                                        default:
                                            get_template_part( 'template-parts/card', 'carte' );
                                            break;
                                    }
                                endwhile;
                                ?>
                            </div>
                            
                            <?php
                            $enable_infinite = get_theme_mod( 'books_enable_infinite_scroll', false );
                            
                            if ( $enable_infinite ) :
                            ?>
                                <div class="infinite-scroll-trigger" data-page="<?php echo esc_attr( $paged ); ?>" data-max-pages="<?php echo esc_attr( $books_query->max_num_pages ); ?>">
                                    <div class="loading-spinner" hidden>
                                        <?php echo bpt_icon( 'spinner' ); ?>
                                        <span><?php esc_html_e( 'Se încarcă...', 'biblioteca-pentru-toti' ); ?></span>
                                    </div>
                                </div>
                            <?php else : ?>
                                <?php bpt_pagination( $books_query ); ?>
                            <?php endif; ?>
                            
                        <?php else : ?>
                            <div class="no-results">
                                <div class="no-results__icon"><?php echo bpt_icon( 'book' ); ?></div>
                                <h2 class="no-results__title"><?php esc_html_e( 'Nu am găsit cărți', 'biblioteca-pentru-toti' ); ?></h2>
                                <p class="no-results__message"><?php esc_html_e( 'Încearcă să modifici filtrele sau să cauți altceva.', 'biblioteca-pentru-toti' ); ?></p>
                                <button type="button" class="btn btn--secondary" onclick="document.getElementById('books-filters').reset(); document.getElementById('books-filters').submit();">
                                    <?php esc_html_e( 'Resetează filtrele', 'biblioteca-pentru-toti' ); ?>
                                </button>
                            </div>
                        <?php 
                        endif;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
