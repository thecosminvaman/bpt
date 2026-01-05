<?php
/**
 * Custom Taxonomies Registration
 *
 * @package Biblioteca_Pentru_Toti
 */

defined('ABSPATH') || exit;

/**
 * Register Custom Taxonomies
 */
function bpt_register_taxonomies() {

    /**
     * Taxonomy: Autor (for Carte)
     */
    $autor_labels = [
        'name'                       => _x('Autori', 'Taxonomy general name', 'biblioteca-pentru-toti'),
        'singular_name'              => _x('Autor', 'Taxonomy singular name', 'biblioteca-pentru-toti'),
        'search_items'               => __('Caută Autori', 'biblioteca-pentru-toti'),
        'popular_items'              => __('Autori Populari', 'biblioteca-pentru-toti'),
        'all_items'                  => __('Toți Autorii', 'biblioteca-pentru-toti'),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __('Editează Autor', 'biblioteca-pentru-toti'),
        'update_item'                => __('Actualizează Autor', 'biblioteca-pentru-toti'),
        'add_new_item'               => __('Adaugă Autor Nou', 'biblioteca-pentru-toti'),
        'new_item_name'              => __('Nume Autor Nou', 'biblioteca-pentru-toti'),
        'separate_items_with_commas' => __('Separă autorii cu virgule', 'biblioteca-pentru-toti'),
        'add_or_remove_items'        => __('Adaugă sau elimină autori', 'biblioteca-pentru-toti'),
        'choose_from_most_used'      => __('Alege dintre cei mai folosiți autori', 'biblioteca-pentru-toti'),
        'not_found'                  => __('Nu s-au găsit autori.', 'biblioteca-pentru-toti'),
        'menu_name'                  => __('Autori', 'biblioteca-pentru-toti'),
        'back_to_items'              => __('← Înapoi la Autori', 'biblioteca-pentru-toti'),
    ];

    register_taxonomy('autor', ['carte'], [
        'labels'            => $autor_labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'autor', 'with_front' => false],
        'show_in_rest'      => true,
        'rest_base'         => 'autori',
    ]);

    /**
     * Taxonomy: Gen Literar (for Carte)
     */
    $gen_labels = [
        'name'              => _x('Genuri Literare', 'Taxonomy general name', 'biblioteca-pentru-toti'),
        'singular_name'     => _x('Gen Literar', 'Taxonomy singular name', 'biblioteca-pentru-toti'),
        'search_items'      => __('Caută Genuri', 'biblioteca-pentru-toti'),
        'all_items'         => __('Toate Genurile', 'biblioteca-pentru-toti'),
        'parent_item'       => __('Gen Părinte', 'biblioteca-pentru-toti'),
        'parent_item_colon' => __('Gen Părinte:', 'biblioteca-pentru-toti'),
        'edit_item'         => __('Editează Gen', 'biblioteca-pentru-toti'),
        'update_item'       => __('Actualizează Gen', 'biblioteca-pentru-toti'),
        'add_new_item'      => __('Adaugă Gen Nou', 'biblioteca-pentru-toti'),
        'new_item_name'     => __('Nume Gen Nou', 'biblioteca-pentru-toti'),
        'menu_name'         => __('Genuri Literare', 'biblioteca-pentru-toti'),
        'back_to_items'     => __('← Înapoi la Genuri', 'biblioteca-pentru-toti'),
    ];

    register_taxonomy('gen_literar', ['carte'], [
        'labels'            => $gen_labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'gen', 'with_front' => false],
        'show_in_rest'      => true,
        'rest_base'         => 'genuri',
    ]);

    /**
     * Taxonomy: Epoca Literara (for Carte)
     */
    $epoca_labels = [
        'name'              => _x('Epoci Literare', 'Taxonomy general name', 'biblioteca-pentru-toti'),
        'singular_name'     => _x('Epocă Literară', 'Taxonomy singular name', 'biblioteca-pentru-toti'),
        'search_items'      => __('Caută Epoci', 'biblioteca-pentru-toti'),
        'all_items'         => __('Toate Epocile', 'biblioteca-pentru-toti'),
        'parent_item'       => __('Epocă Părinte', 'biblioteca-pentru-toti'),
        'parent_item_colon' => __('Epocă Părinte:', 'biblioteca-pentru-toti'),
        'edit_item'         => __('Editează Epocă', 'biblioteca-pentru-toti'),
        'update_item'       => __('Actualizează Epocă', 'biblioteca-pentru-toti'),
        'add_new_item'      => __('Adaugă Epocă Nouă', 'biblioteca-pentru-toti'),
        'new_item_name'     => __('Nume Epocă Nouă', 'biblioteca-pentru-toti'),
        'menu_name'         => __('Epoci Literare', 'biblioteca-pentru-toti'),
        'back_to_items'     => __('← Înapoi la Epoci', 'biblioteca-pentru-toti'),
    ];

    register_taxonomy('epoca', ['carte'], [
        'labels'            => $epoca_labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'epoca', 'with_front' => false],
        'show_in_rest'      => true,
        'rest_base'         => 'epoci',
    ]);

    /**
     * Taxonomy: Limba Originala (for Carte)
     */
    $limba_labels = [
        'name'                       => _x('Limbi Originale', 'Taxonomy general name', 'biblioteca-pentru-toti'),
        'singular_name'              => _x('Limbă Originală', 'Taxonomy singular name', 'biblioteca-pentru-toti'),
        'search_items'               => __('Caută Limbi', 'biblioteca-pentru-toti'),
        'popular_items'              => __('Limbi Populare', 'biblioteca-pentru-toti'),
        'all_items'                  => __('Toate Limbile', 'biblioteca-pentru-toti'),
        'edit_item'                  => __('Editează Limbă', 'biblioteca-pentru-toti'),
        'update_item'                => __('Actualizează Limbă', 'biblioteca-pentru-toti'),
        'add_new_item'               => __('Adaugă Limbă Nouă', 'biblioteca-pentru-toti'),
        'new_item_name'              => __('Nume Limbă Nouă', 'biblioteca-pentru-toti'),
        'separate_items_with_commas' => __('Separă limbile cu virgule', 'biblioteca-pentru-toti'),
        'add_or_remove_items'        => __('Adaugă sau elimină limbi', 'biblioteca-pentru-toti'),
        'choose_from_most_used'      => __('Alege dintre cele mai folosite limbi', 'biblioteca-pentru-toti'),
        'not_found'                  => __('Nu s-au găsit limbi.', 'biblioteca-pentru-toti'),
        'menu_name'                  => __('Limbi', 'biblioteca-pentru-toti'),
        'back_to_items'              => __('← Înapoi la Limbi', 'biblioteca-pentru-toti'),
    ];

    register_taxonomy('limba_originala', ['carte'], [
        'labels'            => $limba_labels,
        'hierarchical'      => false,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'limba', 'with_front' => false],
        'show_in_rest'      => true,
        'rest_base'         => 'limbi',
    ]);

    /**
     * Taxonomy: Serie BPT (for Carte)
     */
    $serie_labels = [
        'name'                       => _x('Serii BPT', 'Taxonomy general name', 'biblioteca-pentru-toti'),
        'singular_name'              => _x('Serie BPT', 'Taxonomy singular name', 'biblioteca-pentru-toti'),
        'search_items'               => __('Caută Serii', 'biblioteca-pentru-toti'),
        'popular_items'              => __('Serii Populare', 'biblioteca-pentru-toti'),
        'all_items'                  => __('Toate Seriile', 'biblioteca-pentru-toti'),
        'edit_item'                  => __('Editează Serie', 'biblioteca-pentru-toti'),
        'update_item'                => __('Actualizează Serie', 'biblioteca-pentru-toti'),
        'add_new_item'               => __('Adaugă Serie Nouă', 'biblioteca-pentru-toti'),
        'new_item_name'              => __('Nume Serie Nouă', 'biblioteca-pentru-toti'),
        'menu_name'                  => __('Serii BPT', 'biblioteca-pentru-toti'),
        'back_to_items'              => __('← Înapoi la Serii', 'biblioteca-pentru-toti'),
    ];

    register_taxonomy('serie_bpt', ['carte'], [
        'labels'            => $serie_labels,
        'hierarchical'      => false,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => false,
        'show_in_nav_menus' => false,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'serie', 'with_front' => false],
        'show_in_rest'      => true,
        'rest_base'         => 'serii',
    ]);

    /**
     * Taxonomy: Editura BPT (for Carte)
     */
    $editura_labels = [
        'name'                       => _x('Edituri', 'Taxonomy general name', 'biblioteca-pentru-toti'),
        'singular_name'              => _x('Editura', 'Taxonomy singular name', 'biblioteca-pentru-toti'),
        'search_items'               => __('Caută Edituri', 'biblioteca-pentru-toti'),
        'all_items'                  => __('Toate Editurile', 'biblioteca-pentru-toti'),
        'edit_item'                  => __('Editează Editura', 'biblioteca-pentru-toti'),
        'update_item'                => __('Actualizează Editura', 'biblioteca-pentru-toti'),
        'add_new_item'               => __('Adaugă Editura Nouă', 'biblioteca-pentru-toti'),
        'new_item_name'              => __('Nume Editura Nouă', 'biblioteca-pentru-toti'),
        'menu_name'                  => __('Edituri', 'biblioteca-pentru-toti'),
        'back_to_items'              => __('← Înapoi la Edituri', 'biblioteca-pentru-toti'),
    ];

    register_taxonomy('editura_bpt', ['carte'], [
        'labels'            => $editura_labels,
        'hierarchical'      => false,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => false,
        'show_in_nav_menus' => false,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'editura', 'with_front' => false],
        'show_in_rest'      => true,
        'rest_base'         => 'edituri',
    ]);

    /**
     * Taxonomy: Tip Eveniment (for Eveniment)
     */
    $tip_eveniment_labels = [
        'name'              => _x('Tipuri Evenimente', 'Taxonomy general name', 'biblioteca-pentru-toti'),
        'singular_name'     => _x('Tip Eveniment', 'Taxonomy singular name', 'biblioteca-pentru-toti'),
        'search_items'      => __('Caută Tipuri', 'biblioteca-pentru-toti'),
        'all_items'         => __('Toate Tipurile', 'biblioteca-pentru-toti'),
        'parent_item'       => __('Tip Părinte', 'biblioteca-pentru-toti'),
        'parent_item_colon' => __('Tip Părinte:', 'biblioteca-pentru-toti'),
        'edit_item'         => __('Editează Tip', 'biblioteca-pentru-toti'),
        'update_item'       => __('Actualizează Tip', 'biblioteca-pentru-toti'),
        'add_new_item'      => __('Adaugă Tip Nou', 'biblioteca-pentru-toti'),
        'new_item_name'     => __('Nume Tip Nou', 'biblioteca-pentru-toti'),
        'menu_name'         => __('Tipuri Evenimente', 'biblioteca-pentru-toti'),
        'back_to_items'     => __('← Înapoi la Tipuri', 'biblioteca-pentru-toti'),
    ];

    register_taxonomy('tip_eveniment', ['eveniment'], [
        'labels'            => $tip_eveniment_labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'tip-eveniment', 'with_front' => false],
        'show_in_rest'      => true,
        'rest_base'         => 'tipuri-evenimente',
    ]);
}
add_action('init', 'bpt_register_taxonomies', 0);

/**
 * Insert default terms for taxonomies
 */
function bpt_insert_default_terms() {
    // Default Gen Literar terms
    $default_genuri = [
        'roman'     => 'Roman',
        'poezie'    => 'Poezie',
        'teatru'    => 'Teatru',
        'filosofie' => 'Filosofie',
        'memorii'   => 'Memorii',
        'nuvele'    => 'Nuvele și povestiri',
        'eseu'      => 'Eseu',
        'epistolar' => 'Epistolar',
        'proza'     => 'Proză scurtă',
    ];

    foreach ($default_genuri as $slug => $name) {
        if (!term_exists($slug, 'gen_literar')) {
            wp_insert_term($name, 'gen_literar', ['slug' => $slug]);
        }
    }

    // Default Epoca terms
    $default_epoci = [
        'antichitate' => 'Antichitate',
        'medieval'    => 'Evul Mediu',
        'renastere'   => 'Renaștere',
        'clasicism'   => 'Clasicism',
        'romantism'   => 'Romantism',
        'realism'     => 'Realism',
        'modernism'   => 'Modernism',
        'contemporan' => 'Contemporan',
    ];

    foreach ($default_epoci as $slug => $name) {
        if (!term_exists($slug, 'epoca')) {
            wp_insert_term($name, 'epoca', ['slug' => $slug]);
        }
    }

    // Default Limba terms
    $default_limbi = [
        'romana'     => 'Română',
        'franceza'   => 'Franceză',
        'engleza'    => 'Engleză',
        'germana'    => 'Germană',
        'rusa'       => 'Rusă',
        'italiana'   => 'Italiană',
        'spaniola'   => 'Spaniolă',
        'greaca'     => 'Greacă',
        'latina'     => 'Latină',
        'portugheza' => 'Portugheză',
    ];

    foreach ($default_limbi as $slug => $name) {
        if (!term_exists($slug, 'limba_originala')) {
            wp_insert_term($name, 'limba_originala', ['slug' => $slug]);
        }
    }

    // Default Tip Eveniment terms
    $default_tipuri = [
        'publicare-bpt'        => 'Publicare BPT',
        'eveniment-istoric'    => 'Eveniment istoric',
        'biografie-autor'      => 'Biografie autor',
        'istoria-editurii'     => 'Istoria editurii',
        'context-international' => 'Context internațional',
        'receptie-critica'     => 'Recepție critică',
    ];

    foreach ($default_tipuri as $slug => $name) {
        if (!term_exists($slug, 'tip_eveniment')) {
            wp_insert_term($name, 'tip_eveniment', ['slug' => $slug]);
        }
    }
}
add_action('after_switch_theme', 'bpt_insert_default_terms');

/**
 * Add custom column to Author taxonomy admin
 */
function bpt_autor_taxonomy_columns($columns) {
    $new_columns = [];
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'name') {
            $new_columns['author_dates'] = __('Perioada', 'biblioteca-pentru-toti');
            $new_columns['author_country'] = __('Țară', 'biblioteca-pentru-toti');
        }
    }
    return $new_columns;
}
add_filter('manage_edit-autor_columns', 'bpt_autor_taxonomy_columns');

/**
 * Populate custom columns for Author taxonomy
 */
function bpt_autor_taxonomy_columns_content($content, $column_name, $term_id) {
    switch ($column_name) {
        case 'author_dates':
            $nastere = get_term_meta($term_id, 'an_nastere', true);
            $deces = get_term_meta($term_id, 'an_deces', true);
            if ($nastere || $deces) {
                $content = ($nastere ?: '?') . ' - ' . ($deces ?: '?');
            } else {
                $content = '—';
            }
            break;
        case 'author_country':
            $content = get_term_meta($term_id, 'tara_origine', true) ?: '—';
            break;
    }
    return $content;
}
add_filter('manage_autor_custom_column', 'bpt_autor_taxonomy_columns_content', 10, 3);

/**
 * Add custom fields to Author taxonomy (without ACF)
 */
function bpt_autor_add_custom_fields($term) {
    $term_id = $term->term_id ?? 0;
    $an_nastere = get_term_meta($term_id, 'an_nastere', true);
    $an_deces = get_term_meta($term_id, 'an_deces', true);
    $tara_origine = get_term_meta($term_id, 'tara_origine', true);
    $biografie_scurta = get_term_meta($term_id, 'biografie_scurta', true);
    
    // Don't show if ACF is active (it handles these fields)
    if (class_exists('ACF')) {
        return;
    }
    ?>
    <tr class="form-field">
        <th scope="row"><label for="an_nastere"><?php esc_html_e('An naștere', 'biblioteca-pentru-toti'); ?></label></th>
        <td>
            <input type="number" name="an_nastere" id="an_nastere" value="<?php echo esc_attr($an_nastere); ?>" min="-800" max="2000">
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="an_deces"><?php esc_html_e('An deces', 'biblioteca-pentru-toti'); ?></label></th>
        <td>
            <input type="number" name="an_deces" id="an_deces" value="<?php echo esc_attr($an_deces); ?>" min="-800" max="2100">
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="tara_origine"><?php esc_html_e('Țară origine', 'biblioteca-pentru-toti'); ?></label></th>
        <td>
            <input type="text" name="tara_origine" id="tara_origine" value="<?php echo esc_attr($tara_origine); ?>">
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="biografie_scurta"><?php esc_html_e('Biografie scurtă', 'biblioteca-pentru-toti'); ?></label></th>
        <td>
            <textarea name="biografie_scurta" id="biografie_scurta" rows="5"><?php echo esc_textarea($biografie_scurta); ?></textarea>
        </td>
    </tr>
    <?php
}
add_action('autor_edit_form_fields', 'bpt_autor_add_custom_fields');

/**
 * Add fields to Add New Author form
 */
function bpt_autor_add_new_fields() {
    if (class_exists('ACF')) {
        return;
    }
    ?>
    <div class="form-field">
        <label for="an_nastere"><?php esc_html_e('An naștere', 'biblioteca-pentru-toti'); ?></label>
        <input type="number" name="an_nastere" id="an_nastere" min="-800" max="2000">
    </div>
    <div class="form-field">
        <label for="an_deces"><?php esc_html_e('An deces', 'biblioteca-pentru-toti'); ?></label>
        <input type="number" name="an_deces" id="an_deces" min="-800" max="2100">
    </div>
    <div class="form-field">
        <label for="tara_origine"><?php esc_html_e('Țară origine', 'biblioteca-pentru-toti'); ?></label>
        <input type="text" name="tara_origine" id="tara_origine">
    </div>
    <div class="form-field">
        <label for="biografie_scurta"><?php esc_html_e('Biografie scurtă', 'biblioteca-pentru-toti'); ?></label>
        <textarea name="biografie_scurta" id="biografie_scurta" rows="5"></textarea>
    </div>
    <?php
}
add_action('autor_add_form_fields', 'bpt_autor_add_new_fields');

/**
 * Save custom taxonomy fields
 */
function bpt_save_autor_custom_fields($term_id) {
    if (class_exists('ACF')) {
        return;
    }
    
    if (isset($_POST['an_nastere'])) {
        update_term_meta($term_id, 'an_nastere', sanitize_text_field($_POST['an_nastere']));
    }
    if (isset($_POST['an_deces'])) {
        update_term_meta($term_id, 'an_deces', sanitize_text_field($_POST['an_deces']));
    }
    if (isset($_POST['tara_origine'])) {
        update_term_meta($term_id, 'tara_origine', sanitize_text_field($_POST['tara_origine']));
    }
    if (isset($_POST['biografie_scurta'])) {
        update_term_meta($term_id, 'biografie_scurta', sanitize_textarea_field($_POST['biografie_scurta']));
    }
}
add_action('created_autor', 'bpt_save_autor_custom_fields');
add_action('edited_autor', 'bpt_save_autor_custom_fields');

/**
 * Add color field to Epoca taxonomy
 */
function bpt_epoca_color_field($term) {
    if (class_exists('ACF')) {
        return;
    }
    
    $color = get_term_meta($term->term_id, 'culoare_epoca', true) ?: '#F5F3EE';
    ?>
    <tr class="form-field">
        <th scope="row"><label for="culoare_epoca"><?php esc_html_e('Culoare epocă', 'biblioteca-pentru-toti'); ?></label></th>
        <td>
            <input type="color" name="culoare_epoca" id="culoare_epoca" value="<?php echo esc_attr($color); ?>">
        </td>
    </tr>
    <?php
}
add_action('epoca_edit_form_fields', 'bpt_epoca_color_field');

/**
 * Save Epoca color
 */
function bpt_save_epoca_color($term_id) {
    if (class_exists('ACF')) {
        return;
    }
    
    if (isset($_POST['culoare_epoca'])) {
        update_term_meta($term_id, 'culoare_epoca', sanitize_hex_color($_POST['culoare_epoca']));
    }
}
add_action('edited_epoca', 'bpt_save_epoca_color');
add_action('created_epoca', 'bpt_save_epoca_color');
