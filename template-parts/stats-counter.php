<?php
/**
 * Template Part: Stats Counter
 * 
 * Animated statistics display
 * 
 * @package Biblioteca_Pentru_Toti
 */

$stats = bpt_get_collection_stats();

// Get additional stats
$genuri = get_terms(['taxonomy' => 'gen-literar', 'hide_empty' => true]);
$genuri_count = is_array($genuri) ? count($genuri) : 0;

$limbi = get_terms(['taxonomy' => 'limba-originala', 'hide_empty' => true]);
$limbi_count = is_array($limbi) ? count($limbi) : 0;

$epoci = get_terms(['taxonomy' => 'epoca', 'hide_empty' => true]);
$epoci_count = is_array($epoci) ? count($epoci) : 0;
?>

<div class="stats-counter" data-animate="true">
    
    <div class="stat-item">
        <div class="stat-icon">
            <?php echo bpt_icon('book'); ?>
        </div>
        <span class="stat-number" data-count="<?php echo esc_attr($stats['books']); ?>">
            0
        </span>
        <span class="stat-label"><?php esc_html_e('volume', 'flavor'); ?></span>
    </div>
    
    <div class="stat-item">
        <div class="stat-icon">
            <?php echo bpt_icon('user'); ?>
        </div>
        <span class="stat-number" data-count="<?php echo esc_attr($stats['authors']); ?>">
            0
        </span>
        <span class="stat-label"><?php esc_html_e('autori', 'flavor'); ?></span>
    </div>
    
    <div class="stat-item">
        <div class="stat-icon">
            <?php echo bpt_icon('calendar'); ?>
        </div>
        <span class="stat-number" data-count="<?php echo esc_attr($stats['years']); ?>">
            0
        </span>
        <span class="stat-label"><?php esc_html_e('ani de editare', 'flavor'); ?></span>
    </div>
    
    <div class="stat-item">
        <div class="stat-icon">
            <?php echo bpt_icon('layers'); ?>
        </div>
        <span class="stat-number" data-count="<?php echo esc_attr($genuri_count); ?>">
            0
        </span>
        <span class="stat-label"><?php esc_html_e('genuri literare', 'flavor'); ?></span>
    </div>
    
    <div class="stat-item">
        <div class="stat-icon">
            <?php echo bpt_icon('globe'); ?>
        </div>
        <span class="stat-number" data-count="<?php echo esc_attr($limbi_count); ?>">
            0
        </span>
        <span class="stat-label"><?php esc_html_e('limbi traduse', 'flavor'); ?></span>
    </div>
    
    <div class="stat-item">
        <div class="stat-icon">
            <?php echo bpt_icon('clock'); ?>
        </div>
        <span class="stat-number" data-count="<?php echo esc_attr($epoci_count); ?>">
            0
        </span>
        <span class="stat-label"><?php esc_html_e('epoci literare', 'flavor'); ?></span>
    </div>
    
</div>
