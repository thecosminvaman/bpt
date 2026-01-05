<?php
/**
 * Template Part: Epoch Grid
 * 
 * Visual grid of literary epochs for browsing
 * 
 * @package Biblioteca_Pentru_Toti
 */

$epoci = get_terms([
    'taxonomy' => 'epoca',
    'hide_empty' => true,
    'orderby' => 'term_order',
    'order' => 'ASC',
]);

if (empty($epoci) || is_wp_error($epoci)) {
    return;
}
?>

<div class="epoch-grid">
    <?php foreach ($epoci as $epoca) : 
        $colors = bpt_get_epoca_colors($epoca->slug);
        $perioada = get_term_meta($epoca->term_id, 'perioada', true);
        
        // Get a sample book from this epoca
        $sample_book = get_posts([
            'post_type' => 'carte',
            'posts_per_page' => 1,
            'tax_query' => [
                [
                    'taxonomy' => 'epoca',
                    'field' => 'term_id',
                    'terms' => $epoca->term_id,
                ]
            ],
            'orderby' => 'rand',
        ]);
    ?>
        <a href="<?php echo esc_url(get_term_link($epoca)); ?>" 
           class="epoch-card"
           style="--epoch-bg: <?php echo esc_attr($colors['background']); ?>; 
                  --epoch-text: <?php echo esc_attr($colors['text']); ?>;">
            
            <div class="epoch-card-background">
                <?php if (!empty($sample_book) && has_post_thumbnail($sample_book[0])) : ?>
                    <?php echo get_the_post_thumbnail($sample_book[0], 'card-small', [
                        'class' => 'epoch-card-image',
                        'loading' => 'lazy',
                    ]); ?>
                <?php endif; ?>
            </div>
            
            <div class="epoch-card-content">
                <?php if ($perioada) : ?>
                    <span class="epoch-card-period"><?php echo esc_html($perioada); ?></span>
                <?php endif; ?>
                
                <h3 class="epoch-card-title"><?php echo esc_html($epoca->name); ?></h3>
                
                <p class="epoch-card-count">
                    <?php printf(_n('%s carte', '%s cărți', $epoca->count, 'flavor'), $epoca->count); ?>
                </p>
                
                <span class="epoch-card-arrow" aria-hidden="true">
                    <?php echo bpt_icon('arrow-right'); ?>
                </span>
            </div>
            
        </a>
    <?php endforeach; ?>
</div>
