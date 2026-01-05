<?php
/**
 * Template Part: Hero Section
 * 
 * Homepage hero with collection introduction
 * 
 * @package Biblioteca_Pentru_Toti
 */

// Get customizer settings
$hero_title = get_theme_mod('bpt_hero_title', 'Biblioteca pentru Toți');
$hero_subtitle = get_theme_mod('bpt_hero_subtitle', 'Colecția care a format generații de cititori români (1953-1989)');
$hero_description = get_theme_mod('bpt_hero_description', 'Descoperă peste 800 de volume care au adus literatura universală în casele românilor. O arhivă digitală a colecției legendare.');
$hero_image = get_theme_mod('bpt_hero_image');
$hero_cta_text = get_theme_mod('bpt_hero_cta_text', 'Explorează colecția');
$hero_cta_link = get_theme_mod('bpt_hero_cta_link', get_post_type_archive_link('carte'));
$hero_secondary_text = get_theme_mod('bpt_hero_secondary_text', 'Despre proiect');
$hero_secondary_link = get_theme_mod('bpt_hero_secondary_link', '#despre');

// Get collection stats
$stats = bpt_get_collection_stats();
?>

<section class="hero" aria-labelledby="hero-title">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1 id="hero-title" class="hero-title">
                    <?php echo esc_html($hero_title); ?>
                </h1>
                
                <?php if ($hero_subtitle) : ?>
                    <p class="hero-subtitle"><?php echo esc_html($hero_subtitle); ?></p>
                <?php endif; ?>
                
                <?php if ($hero_description) : ?>
                    <p class="hero-description"><?php echo esc_html($hero_description); ?></p>
                <?php endif; ?>
                
                <div class="hero-actions">
                    <?php if ($hero_cta_text && $hero_cta_link) : ?>
                        <a href="<?php echo esc_url($hero_cta_link); ?>" class="btn btn-primary btn-large">
                            <?php echo esc_html($hero_cta_text); ?>
                            <?php echo bpt_icon('arrow-right'); ?>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($hero_secondary_text && $hero_secondary_link) : ?>
                        <a href="<?php echo esc_url($hero_secondary_link); ?>" class="btn btn-secondary btn-large">
                            <?php echo esc_html($hero_secondary_text); ?>
                        </a>
                    <?php endif; ?>
                </div>
                
                <!-- Quick Stats -->
                <div class="hero-stats">
                    <div class="hero-stat">
                        <span class="hero-stat-number" data-count="<?php echo esc_attr($stats['books']); ?>">
                            <?php echo esc_html(number_format_i18n($stats['books'])); ?>
                        </span>
                        <span class="hero-stat-label"><?php esc_html_e('volume', 'flavor'); ?></span>
                    </div>
                    <div class="hero-stat">
                        <span class="hero-stat-number" data-count="<?php echo esc_attr($stats['authors']); ?>">
                            <?php echo esc_html(number_format_i18n($stats['authors'])); ?>
                        </span>
                        <span class="hero-stat-label"><?php esc_html_e('autori', 'flavor'); ?></span>
                    </div>
                    <div class="hero-stat">
                        <span class="hero-stat-number">
                            <?php echo esc_html($stats['years']); ?>
                        </span>
                        <span class="hero-stat-label"><?php esc_html_e('ani de editare', 'flavor'); ?></span>
                    </div>
                </div>
            </div>
            
            <?php if ($hero_image) : ?>
                <div class="hero-image">
                    <?php echo wp_get_attachment_image($hero_image, 'large', false, [
                        'class' => 'hero-illustration',
                        'loading' => 'eager',
                    ]); ?>
                </div>
            <?php else : ?>
                <!-- Default decorative element -->
                <div class="hero-decoration">
                    <div class="book-stack">
                        <div class="book book-1"></div>
                        <div class="book book-2"></div>
                        <div class="book book-3"></div>
                        <div class="book book-4"></div>
                        <div class="book book-5"></div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Decorative scroll indicator -->
    <div class="hero-scroll-indicator" aria-hidden="true">
        <span class="scroll-text"><?php esc_html_e('Descoperă', 'flavor'); ?></span>
        <span class="scroll-icon"><?php echo bpt_icon('chevron-down'); ?></span>
    </div>
</section>
