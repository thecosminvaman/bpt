<?php
/**
 * Template Part: Book Filters
 * 
 * Filtering interface for book archive
 * 
 * @package Biblioteca_Pentru_Toti
 */

// Get current filter values
$current_epoca = isset($_GET['epoca']) ? sanitize_text_field($_GET['epoca']) : '';
$current_gen = isset($_GET['gen']) ? sanitize_text_field($_GET['gen']) : '';
$current_autor = isset($_GET['autor']) ? sanitize_text_field($_GET['autor']) : '';
$current_limba = isset($_GET['limba']) ? sanitize_text_field($_GET['limba']) : '';
$current_an_min = isset($_GET['an_min']) ? absint($_GET['an_min']) : '';
$current_an_max = isset($_GET['an_max']) ? absint($_GET['an_max']) : '';
$current_search = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
$current_sort = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'title';

// Get taxonomies for filters
$epoci = get_terms(['taxonomy' => 'epoca', 'hide_empty' => true, 'orderby' => 'term_order']);
$genuri = get_terms(['taxonomy' => 'gen-literar', 'hide_empty' => true]);
$limbi = get_terms(['taxonomy' => 'limba-originala', 'hide_empty' => true]);
$autori = get_terms(['taxonomy' => 'autor', 'hide_empty' => true, 'orderby' => 'name', 'number' => 100]);

// Year range
$year_min = 1953;
$year_max = 1989;
?>

<div class="books-filters" id="books-filters">
    
    <form class="filters-form" method="get" action="<?php echo esc_url(get_post_type_archive_link('carte')); ?>">
        
        <!-- Search -->
        <div class="filter-group filter-search">
            <label for="filter-search" class="filter-label">
                <?php echo bpt_icon('search'); ?>
                <?php esc_html_e('Caută', 'flavor'); ?>
            </label>
            <input type="search" 
                   id="filter-search" 
                   name="s" 
                   class="filter-input"
                   value="<?php echo esc_attr($current_search); ?>"
                   placeholder="<?php esc_attr_e('Titlu, autor, citat...', 'flavor'); ?>">
        </div>
        
        <!-- Filters Row -->
        <div class="filters-row">
            
            <!-- Epoca Filter -->
            <div class="filter-group">
                <label for="filter-epoca" class="filter-label">
                    <?php esc_html_e('Epoca', 'flavor'); ?>
                </label>
                <select id="filter-epoca" name="epoca" class="filter-select">
                    <option value=""><?php esc_html_e('Toate epocile', 'flavor'); ?></option>
                    <?php foreach ($epoci as $epoca) : 
                        $colors = bpt_get_epoca_colors($epoca->slug);
                    ?>
                        <option value="<?php echo esc_attr($epoca->slug); ?>" 
                                <?php selected($current_epoca, $epoca->slug); ?>
                                data-color="<?php echo esc_attr($colors['background']); ?>">
                            <?php echo esc_html($epoca->name); ?> 
                            (<?php echo esc_html($epoca->count); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- Gen Filter -->
            <div class="filter-group">
                <label for="filter-gen" class="filter-label">
                    <?php esc_html_e('Gen literar', 'flavor'); ?>
                </label>
                <select id="filter-gen" name="gen" class="filter-select">
                    <option value=""><?php esc_html_e('Toate genurile', 'flavor'); ?></option>
                    <?php foreach ($genuri as $gen) : ?>
                        <option value="<?php echo esc_attr($gen->slug); ?>" 
                                <?php selected($current_gen, $gen->slug); ?>>
                            <?php echo esc_html($gen->name); ?> 
                            (<?php echo esc_html($gen->count); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- Limba Filter -->
            <div class="filter-group">
                <label for="filter-limba" class="filter-label">
                    <?php esc_html_e('Limba originală', 'flavor'); ?>
                </label>
                <select id="filter-limba" name="limba" class="filter-select">
                    <option value=""><?php esc_html_e('Toate limbile', 'flavor'); ?></option>
                    <?php foreach ($limbi as $limba) : ?>
                        <option value="<?php echo esc_attr($limba->slug); ?>" 
                                <?php selected($current_limba, $limba->slug); ?>>
                            <?php echo esc_html($limba->name); ?> 
                            (<?php echo esc_html($limba->count); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- Sort -->
            <div class="filter-group">
                <label for="filter-sort" class="filter-label">
                    <?php esc_html_e('Sortare', 'flavor'); ?>
                </label>
                <select id="filter-sort" name="orderby" class="filter-select">
                    <option value="title" <?php selected($current_sort, 'title'); ?>>
                        <?php esc_html_e('Alfabetic (A-Z)', 'flavor'); ?>
                    </option>
                    <option value="title_desc" <?php selected($current_sort, 'title_desc'); ?>>
                        <?php esc_html_e('Alfabetic (Z-A)', 'flavor'); ?>
                    </option>
                    <option value="nr_bpt" <?php selected($current_sort, 'nr_bpt'); ?>>
                        <?php esc_html_e('Nr. BPT', 'flavor'); ?>
                    </option>
                    <option value="an_scriere" <?php selected($current_sort, 'an_scriere'); ?>>
                        <?php esc_html_e('An scriere', 'flavor'); ?>
                    </option>
                    <option value="an_publicare" <?php selected($current_sort, 'an_publicare'); ?>>
                        <?php esc_html_e('An publicare BPT', 'flavor'); ?>
                    </option>
                </select>
            </div>
            
        </div>
        
        <!-- Advanced Filters (collapsible) -->
        <details class="filters-advanced">
            <summary class="filters-advanced-toggle">
                <?php echo bpt_icon('sliders'); ?>
                <?php esc_html_e('Mai multe filtre', 'flavor'); ?>
            </summary>
            
            <div class="filters-advanced-content">
                
                <!-- Author Filter (autocomplete) -->
                <div class="filter-group filter-autor">
                    <label for="filter-autor" class="filter-label">
                        <?php esc_html_e('Autor', 'flavor'); ?>
                    </label>
                    <input type="text" 
                           id="filter-autor-search"
                           class="filter-input filter-autocomplete"
                           placeholder="<?php esc_attr_e('Caută un autor...', 'flavor'); ?>"
                           data-taxonomy="autor"
                           autocomplete="off">
                    <input type="hidden" id="filter-autor" name="autor" value="<?php echo esc_attr($current_autor); ?>">
                    <div class="autocomplete-results" id="autor-results"></div>
                </div>
                
                <!-- Year Range -->
                <div class="filter-group filter-year-range">
                    <span class="filter-label"><?php esc_html_e('Perioada publicării BPT', 'flavor'); ?></span>
                    <div class="year-range-inputs">
                        <label class="sr-only" for="filter-an-min"><?php esc_html_e('De la anul', 'flavor'); ?></label>
                        <input type="number" 
                               id="filter-an-min" 
                               name="an_min" 
                               class="filter-input filter-year"
                               min="<?php echo esc_attr($year_min); ?>"
                               max="<?php echo esc_attr($year_max); ?>"
                               value="<?php echo esc_attr($current_an_min); ?>"
                               placeholder="<?php echo esc_attr($year_min); ?>">
                        <span class="year-separator">–</span>
                        <label class="sr-only" for="filter-an-max"><?php esc_html_e('Până la anul', 'flavor'); ?></label>
                        <input type="number" 
                               id="filter-an-max" 
                               name="an_max" 
                               class="filter-input filter-year"
                               min="<?php echo esc_attr($year_min); ?>"
                               max="<?php echo esc_attr($year_max); ?>"
                               value="<?php echo esc_attr($current_an_max); ?>"
                               placeholder="<?php echo esc_attr($year_max); ?>">
                    </div>
                </div>
                
            </div>
        </details>
        
        <!-- Filter Actions -->
        <div class="filter-actions">
            <button type="submit" class="btn btn-primary">
                <?php echo bpt_icon('search'); ?>
                <?php esc_html_e('Aplică filtrele', 'flavor'); ?>
            </button>
            
            <a href="<?php echo esc_url(get_post_type_archive_link('carte')); ?>" class="btn btn-secondary filter-reset">
                <?php esc_html_e('Resetează', 'flavor'); ?>
            </a>
        </div>
        
    </form>
    
    <!-- Active Filters -->
    <?php 
    $active_filters = [];
    if ($current_epoca) {
        $term = get_term_by('slug', $current_epoca, 'epoca');
        if ($term) $active_filters['epoca'] = $term->name;
    }
    if ($current_gen) {
        $term = get_term_by('slug', $current_gen, 'gen-literar');
        if ($term) $active_filters['gen'] = $term->name;
    }
    if ($current_limba) {
        $term = get_term_by('slug', $current_limba, 'limba-originala');
        if ($term) $active_filters['limba'] = $term->name;
    }
    if ($current_search) {
        $active_filters['s'] = '"' . $current_search . '"';
    }
    
    if (!empty($active_filters)) :
    ?>
    <div class="active-filters">
        <span class="active-filters-label"><?php esc_html_e('Filtre active:', 'flavor'); ?></span>
        <ul class="active-filters-list">
            <?php foreach ($active_filters as $key => $value) : 
                $remove_url = remove_query_arg($key);
            ?>
                <li class="active-filter-item">
                    <a href="<?php echo esc_url($remove_url); ?>" class="active-filter-remove" title="<?php esc_attr_e('Elimină filtrul', 'flavor'); ?>">
                        <?php echo esc_html($value); ?>
                        <?php echo bpt_icon('x'); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
    
</div>
