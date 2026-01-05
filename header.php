<?php
/**
 * The header for the theme
 *
 * Displays the <head> section and everything up to the main content area.
 *
 * @package Biblioteca_Pentru_Toti
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <?php if ( is_singular() && pings_open() ) : ?>
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php endif; ?>
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content">
    <?php esc_html_e( 'Sari la conținut', 'biblioteca-pentru-toti' ); ?>
</a>

<header id="masthead" class="site-header" role="banner">
    <div class="site-header__top-bar">
        <div class="container">
            <div class="site-header__date">
                <?php echo esc_html( date_i18n( 'l, j F Y' ) ); ?>
            </div>
            <?php if ( has_nav_menu( 'secondary' ) ) : ?>
                <nav class="site-header__secondary-nav" aria-label="<?php esc_attr_e( 'Navigare secundară', 'biblioteca-pentru-toti' ); ?>">
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'secondary',
                        'menu_class'     => 'secondary-menu',
                        'container'      => false,
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ) );
                    ?>
                </nav>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="site-header__main">
        <div class="container">
            <div class="site-header__inner">
                <div class="site-branding">
                    <?php if ( has_custom_logo() ) : ?>
                        <div class="site-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="site-branding__text">
                        <?php if ( is_front_page() ) : ?>
                            <h1 class="site-title">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                    <?php bloginfo( 'name' ); ?>
                                </a>
                            </h1>
                        <?php else : ?>
                            <p class="site-title">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                    <?php bloginfo( 'name' ); ?>
                                </a>
                            </p>
                        <?php endif; ?>
                        
                        <?php
                        $description = get_bloginfo( 'description', 'display' );
                        if ( $description || is_customize_preview() ) :
                        ?>
                            <p class="site-description"><?php echo esc_html( $description ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="site-header__actions">
                    <button class="search-toggle" aria-expanded="false" aria-controls="header-search" aria-label="<?php esc_attr_e( 'Deschide căutarea', 'biblioteca-pentru-toti' ); ?>">
                        <?php echo bpt_icon( 'search' ); ?>
                    </button>
                    
                    <button class="mobile-menu-toggle" aria-expanded="false" aria-controls="primary-navigation" aria-label="<?php esc_attr_e( 'Deschide meniul', 'biblioteca-pentru-toti' ); ?>">
                        <span class="hamburger">
                            <span class="hamburger__line"></span>
                            <span class="hamburger__line"></span>
                            <span class="hamburger__line"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div id="header-search" class="site-header__search" hidden>
        <div class="container">
            <form role="search" method="get" class="search-form search-form--header" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <label for="header-search-input" class="screen-reader-text">
                    <?php esc_html_e( 'Caută', 'biblioteca-pentru-toti' ); ?>
                </label>
                <input type="search" 
                       id="header-search-input"
                       class="search-form__input" 
                       placeholder="<?php esc_attr_e( 'Caută cărți, autori, articole...', 'biblioteca-pentru-toti' ); ?>" 
                       value="<?php echo get_search_query(); ?>" 
                       name="s"
                       autocomplete="off">
                <button type="submit" class="search-form__submit">
                    <?php echo bpt_icon( 'search' ); ?>
                    <span class="screen-reader-text"><?php esc_html_e( 'Caută', 'biblioteca-pentru-toti' ); ?></span>
                </button>
                <button type="button" class="search-form__close" aria-label="<?php esc_attr_e( 'Închide căutarea', 'biblioteca-pentru-toti' ); ?>">
                    <?php echo bpt_icon( 'close' ); ?>
                </button>
            </form>
            <div class="search-autocomplete" hidden></div>
        </div>
    </div>
    
    <nav id="primary-navigation" class="site-header__nav" aria-label="<?php esc_attr_e( 'Navigare principală', 'biblioteca-pentru-toti' ); ?>">
        <div class="container">
            <?php
            if ( has_nav_menu( 'primary' ) ) :
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_class'     => 'primary-menu',
                    'container'      => false,
                    'depth'          => 2,
                    'fallback_cb'    => false,
                    'walker'         => class_exists( 'BPT_Nav_Walker' ) ? new BPT_Nav_Walker() : null,
                ) );
            else :
            ?>
                <ul class="primary-menu">
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Acasă', 'biblioteca-pentru-toti' ); ?></a></li>
                    <li><a href="<?php echo esc_url( get_post_type_archive_link( 'carte' ) ); ?>"><?php esc_html_e( 'Colecția', 'biblioteca-pentru-toti' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/cronologie/' ) ); ?>"><?php esc_html_e( 'Cronologie', 'biblioteca-pentru-toti' ); ?></a></li>
                    <?php if ( get_option( 'page_for_posts' ) ) : ?>
                        <li><a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"><?php esc_html_e( 'Articole', 'biblioteca-pentru-toti' ); ?></a></li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
        </div>
    </nav>
    
    <?php if ( function_exists( 'bcn_display' ) && ! is_front_page() ) : ?>
        <div class="site-header__breadcrumbs">
            <div class="container">
                <?php bcn_display(); ?>
            </div>
        </div>
    <?php elseif ( ! is_front_page() ) : ?>
        <div class="site-header__breadcrumbs">
            <div class="container">
                <?php bpt_breadcrumbs(); ?>
            </div>
        </div>
    <?php endif; ?>
</header>

<div id="page" class="site">
    <main id="main-content" class="site-main" role="main">
