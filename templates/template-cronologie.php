<?php
/**
 * Template Name: Cronologie
 * 
 * Full timeline page with filtering and interactive navigation
 * 
 * @package Biblioteca_Pentru_Toti
 */

get_header();

// Get filter values
$current_tip = isset($_GET['tip']) ? sanitize_text_field($_GET['tip']) : '';
$current_decade = isset($_GET['deceniu']) ? sanitize_text_field($_GET['deceniu']) : '';

// Build query
$args = [
    'post_type' => 'eveniment',
    'posts_per_page' => -1,
    'meta_key' => 'data_eveniment',
    'orderby' => 'meta_value',
    'order' => 'ASC',
];

// Apply filters
$tax_query = [];
if ($current_tip) {
    $tax_query[] = [
        'taxonomy' => 'tip-eveniment',
        'field' => 'slug',
        'terms' => $current_tip,
    ];
}

if (!empty($tax_query)) {
    $args['tax_query'] = $tax_query;
}

// Decade filter via meta query
if ($current_decade) {
    $decade_start = intval($current_decade);
    $decade_end = $decade_start + 9;
    $args['meta_query'] = [
        [
            'key' => 'data_eveniment',
            'value' => [$decade_start . '-01-01', $decade_end . '-12-31'],
            'compare' => 'BETWEEN',
            'type' => 'DATE',
        ]
    ];
}

$events = new WP_Query($args);

// Get event types for filter
$tip_evenimente = get_terms([
    'taxonomy' => 'tip-eveniment',
    'hide_empty' => true,
]);

// Available decades
$decades = ['1950', '1960', '1970', '1980'];
?>

<main id="main-content" class="site-main page-cronologie">
    
    <!-- Page Header -->
    <header class="page-header">
        <div class="container">
            <?php bpt_breadcrumbs(); ?>
            
            <h1 class="page-title"><?php esc_html_e('Cronologia BPT', 'flavor'); ?></h1>
            
            <p class="page-description lead">
                <?php esc_html_e('O călătorie prin istoria colecției Biblioteca pentru Toți, de la înființare în 1953 până la ultimele volume din 1989.', 'flavor'); ?>
            </p>
        </div>
    </header>
    
    <!-- Timeline Controls -->
    <section class="timeline-controls section-slim">
        <div class="container">
            
            <!-- Decade Navigation -->
            <nav class="decade-nav" aria-label="Navigare pe decenii">
                <a href="<?php echo esc_url(remove_query_arg('deceniu')); ?>" 
                   class="decade-link <?php echo !$current_decade ? 'active' : ''; ?>">
                    <?php esc_html_e('Toate', 'flavor'); ?>
                </a>
                <?php foreach ($decades as $decade) : ?>
                    <a href="<?php echo esc_url(add_query_arg('deceniu', $decade)); ?>" 
                       class="decade-link <?php echo $current_decade === $decade ? 'active' : ''; ?>">
                        <?php echo esc_html($decade); ?>s
                    </a>
                <?php endforeach; ?>
            </nav>
            
            <!-- Type Filter -->
            <div class="timeline-filters">
                <label for="tip-filter" class="filter-label">
                    <?php esc_html_e('Filtrează după tip:', 'flavor'); ?>
                </label>
                <select id="tip-filter" class="filter-select" onchange="window.location.href=this.value">
                    <option value="<?php echo esc_url(remove_query_arg('tip')); ?>">
                        <?php esc_html_e('Toate evenimentele', 'flavor'); ?>
                    </option>
                    <?php foreach ($tip_evenimente as $tip) : ?>
                        <option value="<?php echo esc_url(add_query_arg('tip', $tip->slug)); ?>"
                                <?php selected($current_tip, $tip->slug); ?>>
                            <?php echo esc_html($tip->name); ?> (<?php echo esc_html($tip->count); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
        </div>
    </section>
    
    <!-- Timeline Content -->
    <section class="timeline-content section">
        <div class="container">
            
            <?php if ($events->have_posts()) : ?>
                
                <!-- Results Count -->
                <p class="results-count">
                    <?php
                    printf(
                        _n('%s eveniment', '%s evenimente', $events->found_posts, 'flavor'),
                        number_format_i18n($events->found_posts)
                    );
                    
                    if ($current_decade) {
                        printf(' ' . esc_html__('din anii %s', 'flavor'), $current_decade . '-' . ($current_decade + 9));
                    }
                    
                    if ($current_tip) {
                        $tip_term = get_term_by('slug', $current_tip, 'tip-eveniment');
                        if ($tip_term) {
                            printf(' · ' . esc_html__('Tip: %s', 'flavor'), $tip_term->name);
                        }
                    }
                    ?>
                </p>
                
                <!-- Timeline -->
                <div class="timeline timeline-full" id="timeline">
                    
                    <!-- Timeline Line -->
                    <div class="timeline-line" aria-hidden="true"></div>
                    
                    <?php 
                    $i = 0;
                    $current_year = '';
                    
                    while ($events->have_posts()) : 
                        $events->the_post();
                        
                        // Get year for grouping
                        $data_eveniment = get_post_meta(get_the_ID(), 'data_eveniment', true);
                        $event_year = '';
                        if ($data_eveniment) {
                            $date_obj = DateTime::createFromFormat('Y-m-d', $data_eveniment);
                            if ($date_obj) {
                                $event_year = $date_obj->format('Y');
                            }
                        }
                        
                        // Year marker if new year
                        if ($event_year && $event_year !== $current_year) :
                            $current_year = $event_year;
                        ?>
                            <div class="timeline-year-marker" data-year="<?php echo esc_attr($current_year); ?>">
                                <span class="year-marker-text"><?php echo esc_html($current_year); ?></span>
                            </div>
                        <?php 
                        endif;
                        
                        get_template_part('template-parts/timeline', 'item', ['index' => $i]);
                        $i++;
                        
                    endwhile; 
                    ?>
                    
                </div>
                
                <!-- Scroll to Top -->
                <div class="timeline-actions">
                    <button type="button" class="btn btn-secondary scroll-to-top" id="scroll-top">
                        <?php echo bpt_icon('arrow-up'); ?>
                        <?php esc_html_e('Înapoi sus', 'flavor'); ?>
                    </button>
                </div>
                
            <?php else : ?>
                
                <div class="no-results">
                    <div class="no-results-icon">
                        <?php echo bpt_icon('clock'); ?>
                    </div>
                    <h2><?php esc_html_e('Nu am găsit evenimente', 'flavor'); ?></h2>
                    <p><?php esc_html_e('Nu există evenimente care să corespundă filtrelor selectate.', 'flavor'); ?></p>
                    
                    <a href="<?php echo esc_url(get_permalink()); ?>" class="btn btn-primary">
                        <?php esc_html_e('Vezi toate evenimentele', 'flavor'); ?>
                    </a>
                </div>
                
            <?php endif; 
            wp_reset_postdata();
            ?>
            
        </div>
    </section>
    
    <!-- Timeline Legend -->
    <aside class="timeline-legend section-slim section-alt">
        <div class="container">
            <h2 class="legend-title"><?php esc_html_e('Legendă', 'flavor'); ?></h2>
            
            <div class="legend-items">
                <?php foreach ($tip_evenimente as $tip) : 
                    $tip_color = get_term_meta($tip->term_id, 'culoare', true) ?: '#1a3a5c';
                ?>
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: <?php echo esc_attr($tip_color); ?>;"></span>
                        <span class="legend-label"><?php echo esc_html($tip->name); ?></span>
                    </div>
                <?php endforeach; ?>
                
                <div class="legend-item legend-item-importance">
                    <span class="legend-dot legend-dot-mare"></span>
                    <span class="legend-label"><?php esc_html_e('Eveniment major', 'flavor'); ?></span>
                </div>
            </div>
        </div>
    </aside>
    
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Scroll to top button
    const scrollTopBtn = document.getElementById('scroll-top');
    if (scrollTopBtn) {
        scrollTopBtn.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
    
    // Year marker sticky behavior (if GSAP is available)
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);
        
        // Animate timeline items on scroll
        gsap.utils.toArray('.timeline-item').forEach((item, i) => {
            gsap.from(item, {
                opacity: 0,
                y: 50,
                duration: 0.6,
                scrollTrigger: {
                    trigger: item,
                    start: 'top 85%',
                    toggleActions: 'play none none reverse'
                }
            });
        });
    }
});
</script>

<?php get_footer(); ?>
