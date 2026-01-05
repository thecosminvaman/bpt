<?php
/**
 * Template Part: Article Card
 * 
 * Reusable article/post card component
 * 
 * @package Biblioteca_Pentru_Toti
 */

$post_id = get_the_ID();

// Get categories
$categories = get_the_category();
$primary_cat = !empty($categories) ? $categories[0] : null;

// Reading time estimate
$content = get_the_content();
$word_count = str_word_count(strip_tags($content));
$reading_time = ceil($word_count / 200); // 200 words per minute
?>

<article class="article-card" id="post-<?php echo esc_attr($post_id); ?>">
    
    <a href="<?php the_permalink(); ?>" class="article-card-link">
        
        <!-- Featured Image -->
        <?php if (has_post_thumbnail()) : ?>
            <div class="article-card-image">
                <?php the_post_thumbnail('card-medium', [
                    'class' => 'article-thumbnail',
                    'loading' => 'lazy',
                ]); ?>
            </div>
        <?php endif; ?>
        
        <!-- Article Content -->
        <div class="article-card-content">
            
            <!-- Category -->
            <?php if ($primary_cat) : ?>
                <span class="article-card-category">
                    <?php echo esc_html($primary_cat->name); ?>
                </span>
            <?php endif; ?>
            
            <!-- Title -->
            <h3 class="article-card-title"><?php the_title(); ?></h3>
            
            <!-- Excerpt -->
            <?php if (has_excerpt() || $content) : ?>
                <p class="article-card-excerpt">
                    <?php echo esc_html(wp_trim_words(get_the_excerpt(), 20, '…')); ?>
                </p>
            <?php endif; ?>
            
            <!-- Meta -->
            <footer class="article-card-meta">
                <time class="article-date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                    <?php echo esc_html(get_the_date('j F Y')); ?>
                </time>
                
                <span class="article-reading-time">
                    <?php printf(_n('%d minut de citit', '%d minute de citit', $reading_time, 'flavor'), $reading_time); ?>
                </span>
            </footer>
            
        </div>
        
    </a>
    
</article>
