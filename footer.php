<?php
/**
 * The footer for the theme
 *
 * Contains the closing of the main content and footer elements.
 *
 * @package Biblioteca_Pentru_Toti
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
    </main><!-- #main-content -->
</div><!-- #page -->

<footer id="colophon" class="site-footer" role="contentinfo">
    <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) : ?>
    <div class="site-footer__widgets">
        <div class="container">
            <div class="site-footer__widgets-grid">
                <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                    <div class="site-footer__widget-area site-footer__widget-area--1">
                        <?php dynamic_sidebar( 'footer-1' ); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                    <div class="site-footer__widget-area site-footer__widget-area--2">
                        <?php dynamic_sidebar( 'footer-2' ); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                    <div class="site-footer__widget-area site-footer__widget-area--3">
                        <?php dynamic_sidebar( 'footer-3' ); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
                    <div class="site-footer__widget-area site-footer__widget-area--4">
                        <?php dynamic_sidebar( 'footer-4' ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="site-footer__main">
        <div class="container">
            <div class="site-footer__inner">
                <div class="site-footer__branding">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-footer__logo" rel="home">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                    <p class="site-footer__tagline">
                        <?php esc_html_e( 'Arhiva digitală a colecției Biblioteca pentru Toți (1953-1989)', 'biblioteca-pentru-toti' ); ?>
                    </p>
                </div>
                
                <div class="site-footer__links">
                    <?php if ( has_nav_menu( 'footer' ) ) : ?>
                        <nav class="site-footer__nav" aria-label="<?php esc_attr_e( 'Navigare footer', 'biblioteca-pentru-toti' ); ?>">
                            <?php
                            wp_nav_menu( array(
                                'theme_location' => 'footer',
                                'menu_class'     => 'footer-menu',
                                'container'      => false,
                                'depth'          => 1,
                                'fallback_cb'    => false,
                            ) );
                            ?>
                        </nav>
                    <?php endif; ?>
                </div>
                
                <div class="site-footer__social">
                    <?php
                    $social_links = array(
                        'facebook'  => get_theme_mod( 'footer_social_facebook', '' ),
                        'instagram' => get_theme_mod( 'footer_social_instagram', '' ),
                        'twitter'   => get_theme_mod( 'footer_social_twitter', '' ),
                    );
                    
                    $has_social = array_filter( $social_links );
                    
                    if ( ! empty( $has_social ) ) :
                    ?>
                        <ul class="social-links">
                            <?php if ( ! empty( $social_links['facebook'] ) ) : ?>
                                <li>
                                    <a href="<?php echo esc_url( $social_links['facebook'] ); ?>" 
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       aria-label="<?php esc_attr_e( 'Facebook', 'biblioteca-pentru-toti' ); ?>">
                                        <?php echo bpt_icon( 'facebook' ); ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <?php if ( ! empty( $social_links['instagram'] ) ) : ?>
                                <li>
                                    <a href="<?php echo esc_url( $social_links['instagram'] ); ?>" 
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       aria-label="<?php esc_attr_e( 'Instagram', 'biblioteca-pentru-toti' ); ?>">
                                        <?php echo bpt_icon( 'instagram' ); ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <?php if ( ! empty( $social_links['twitter'] ) ) : ?>
                                <li>
                                    <a href="<?php echo esc_url( $social_links['twitter'] ); ?>" 
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       aria-label="<?php esc_attr_e( 'Twitter', 'biblioteca-pentru-toti' ); ?>">
                                        <?php echo bpt_icon( 'twitter' ); ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="site-footer__bottom">
        <div class="container">
            <div class="site-footer__bottom-inner">
                <p class="site-footer__copyright">
                    <?php
                    $copyright_text = get_theme_mod( 'footer_copyright', '' );
                    if ( ! empty( $copyright_text ) ) {
                        echo wp_kses_post( $copyright_text );
                    } else {
                        printf(
                            /* translators: %1$s: current year, %2$s: site name */
                            esc_html__( '© %1$s %2$s. Toate drepturile rezervate.', 'biblioteca-pentru-toti' ),
                            esc_html( date( 'Y' ) ),
                            esc_html( get_bloginfo( 'name' ) )
                        );
                    }
                    ?>
                </p>
                
                <p class="site-footer__credits">
                    <?php
                    printf(
                        /* translators: %s: WordPress link */
                        esc_html__( 'Construit cu %s', 'biblioteca-pentru-toti' ),
                        '<a href="https://wordpress.org/" target="_blank" rel="noopener noreferrer">WordPress</a>'
                    );
                    ?>
                </p>
            </div>
        </div>
    </div>
</footer>

<button class="back-to-top" aria-label="<?php esc_attr_e( 'Înapoi sus', 'biblioteca-pentru-toti' ); ?>" hidden>
    <?php echo bpt_icon( 'arrow-up' ); ?>
</button>

<?php wp_footer(); ?>

</body>
</html>
