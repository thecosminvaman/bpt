<?php
/**
 * Template Part: Book Card
 * 
 * Reusable book card component for archive pages
 * 
 * @package Biblioteca_Pentru_Toti
 */

$book_id = get_the_ID();

// Get book meta
$nr_bpt = get_post_meta($book_id, 'nr_bpt', true);
$an_scriere = get_post_meta($book_id, 'an_scriere', true);
$an_publicare = get_post_meta($book_id, 'an_publicare_bpt', true);

// Get taxonomies
$autori = wp_get_post_terms($book_id, 'autor', ['fields' => 'all']);
$epoca_terms = wp_get_post_terms($book_id, 'epoca', ['fields' => 'all']);
$gen_terms = wp_get_post_terms($book_id, 'gen-literar', ['fields' => 'all']);

$epoca = !empty($epoca_terms) ? $epoca_terms[0] : null;
$gen = !empty($gen_terms) ? $gen_terms[0] : null;

// Get colors
$epoca_colors = $epoca ? bpt_get_epoca_colors($epoca->slug) : ['background' => '#F5F3EE', 'text' => '#1a1a1a'];
$gen_colors = $gen ? bpt_get_gen_colors($gen->slug) : ['border' => '#8B4513'];

// Card size (can be passed as variable)
$card_size = isset($args['size']) ? $args['size'] : 'medium';
?>

<article class="book-card book-card-<?php echo esc_attr($card_size); ?>" 
         data-epoca="<?php echo $epoca ? esc_attr($epoca->slug) : ''; ?>"
         data-gen="<?php echo $gen ? esc_attr($gen->slug) : ''; ?>"
         style="--epoca-bg: <?php echo esc_attr($epoca_colors['background']); ?>; 
                --epoca-text: <?php echo esc_attr($epoca_colors['text']); ?>;
                --gen-border: <?php echo esc_attr($gen_colors['border']); ?>;">
    
    <a href="<?php the_permalink(); ?>" class="book-card-link">
        
        <!-- Book Cover -->
        <div class="book-card-cover">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('card-medium', [
                    'class' => 'book-card-image',
                    'loading' => 'lazy',
                ]); ?>
            <?php else : ?>
                <div class="book-card-placeholder">
                    <span class="placeholder-title"><?php the_title(); ?></span>
                    <?php if (!empty($autori)) : ?>
                        <span class="placeholder-author"><?php echo esc_html($autori[0]->name); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <!-- BPT Number Badge -->
            <?php if ($nr_bpt) : ?>
                <span class="book-card-number">
                    <?php echo esc_html($nr_bpt); ?>
                </span>
            <?php endif; ?>
            
            <!-- Hover overlay -->
            <div class="book-card-overlay">
                <span class="overlay-text"><?php esc_html_e('Vezi detalii', 'flavor'); ?></span>
            </div>
        </div>
        
        <!-- Book Info -->
        <div class="book-card-info">
            <!-- Author(s) -->
            <?php if (!empty($autori)) : ?>
                <p class="book-card-author">
                    <?php
                    $author_names = array_map(function($a) { return $a->name; }, $autori);
                    echo esc_html(implode(', ', $author_names));
                    ?>
                </p>
            <?php endif; ?>
            
            <!-- Title -->
            <h3 class="book-card-title"><?php the_title(); ?></h3>
            
            <!-- Meta -->
            <div class="book-card-meta">
                <?php if ($an_scriere) : ?>
                    <span class="meta-year" title="<?php esc_attr_e('Anul scrierii', 'flavor'); ?>">
                        <?php echo esc_html(bpt_format_year($an_scriere)); ?>
                    </span>
                <?php endif; ?>
                
                <?php if ($epoca) : ?>
                    <span class="meta-epoca" style="background-color: <?php echo esc_attr($epoca_colors['background']); ?>; color: <?php echo esc_attr($epoca_colors['text']); ?>;">
                        <?php echo esc_html($epoca->name); ?>
                    </span>
                <?php endif; ?>
            </div>
            
            <!-- Genre indicator -->
            <?php if ($gen) : ?>
                <span class="book-card-genre" style="border-left-color: <?php echo esc_attr($gen_colors['border']); ?>;">
                    <?php echo esc_html($gen->name); ?>
                </span>
            <?php endif; ?>
        </div>
        
    </a>
    
</article>
