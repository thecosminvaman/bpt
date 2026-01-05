<?php
/**
 * Template Part: Timeline Item
 * 
 * Single event on the timeline
 * 
 * @package Biblioteca_Pentru_Toti
 */

$event_id = get_the_ID();

// Get event meta
$data_eveniment = get_post_meta($event_id, 'data_eveniment', true);
$data_afisata = get_post_meta($event_id, 'data_afisata', true);
$descriere_scurta = get_post_meta($event_id, 'descriere_scurta', true);
$importanta = get_post_meta($event_id, 'importanta', true) ?: 'medie';
$culoare_marker = get_post_meta($event_id, 'culoare_marker', true);
$citat_epoca = get_post_meta($event_id, 'citat_epoca', true);

// Get tip eveniment
$tip_terms = wp_get_post_terms($event_id, 'tip-eveniment', ['fields' => 'all']);
$tip = !empty($tip_terms) ? $tip_terms[0] : null;

// Get associated books
$carti_asociate = get_post_meta($event_id, 'carti_asociate', true);

// Parse year from date
$year = '';
if ($data_eveniment) {
    $date_obj = DateTime::createFromFormat('Y-m-d', $data_eveniment);
    if ($date_obj) {
        $year = $date_obj->format('Y');
    }
}

// Default color based on importance
$default_colors = [
    'mare' => '#8B0000',
    'medie' => '#1a3a5c',
    'mica' => '#666666',
];
$marker_color = $culoare_marker ?: ($default_colors[$importanta] ?? $default_colors['medie']);

// Position class (alternating left/right handled by CSS)
$index = isset($args['index']) ? $args['index'] : 0;
?>

<article class="timeline-item timeline-item-<?php echo esc_attr($importanta); ?>" 
         data-year="<?php echo esc_attr($year); ?>"
         data-tip="<?php echo $tip ? esc_attr($tip->slug) : ''; ?>"
         style="--marker-color: <?php echo esc_attr($marker_color); ?>;">
    
    <!-- Year Marker -->
    <div class="timeline-marker">
        <span class="timeline-year"><?php echo esc_html($data_afisata ?: $year); ?></span>
        <span class="timeline-dot" aria-hidden="true"></span>
    </div>
    
    <!-- Event Content -->
    <div class="timeline-content">
        
        <!-- Event Type Badge -->
        <?php if ($tip) : ?>
            <span class="timeline-type">
                <?php echo esc_html($tip->name); ?>
            </span>
        <?php endif; ?>
        
        <!-- Title -->
        <h3 class="timeline-title">
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h3>
        
        <!-- Short Description -->
        <?php if ($descriere_scurta) : ?>
            <p class="timeline-description">
                <?php echo esc_html($descriere_scurta); ?>
            </p>
        <?php elseif (has_excerpt()) : ?>
            <p class="timeline-description">
                <?php echo esc_html(get_the_excerpt()); ?>
            </p>
        <?php endif; ?>
        
        <!-- Featured Image -->
        <?php if (has_post_thumbnail()) : ?>
            <div class="timeline-image">
                <?php the_post_thumbnail('card-small', [
                    'class' => 'timeline-thumbnail',
                    'loading' => 'lazy',
                ]); ?>
            </div>
        <?php endif; ?>
        
        <!-- Quote -->
        <?php if ($citat_epoca) : ?>
            <blockquote class="timeline-quote">
                <?php echo esc_html($citat_epoca); ?>
            </blockquote>
        <?php endif; ?>
        
        <!-- Associated Books -->
        <?php if (!empty($carti_asociate) && is_array($carti_asociate)) : ?>
            <div class="timeline-books">
                <span class="timeline-books-label"><?php esc_html_e('Cărți asociate:', 'flavor'); ?></span>
                <ul class="timeline-books-list">
                    <?php foreach (array_slice($carti_asociate, 0, 3) as $carte_id) : 
                        $carte = get_post($carte_id);
                        if (!$carte) continue;
                    ?>
                        <li>
                            <a href="<?php echo esc_url(get_permalink($carte_id)); ?>">
                                <?php echo esc_html($carte->post_title); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                    <?php if (count($carti_asociate) > 3) : ?>
                        <li class="more-books">
                            +<?php echo count($carti_asociate) - 3; ?>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <!-- Read More -->
        <a href="<?php the_permalink(); ?>" class="timeline-link">
            <?php esc_html_e('Citește mai mult', 'flavor'); ?>
            <?php echo bpt_icon('arrow-right'); ?>
        </a>
        
    </div>
    
</article>
