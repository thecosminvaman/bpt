<?php
/**
 * ACF Field Groups
 * 
 * Define field groups programmatically for ACF Pro
 * 
 * @package Biblioteca_Pentru_Toti
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register ACF field groups
 */
add_action('acf/init', 'bpt_register_acf_fields');

function bpt_register_acf_fields() {
    // Check if ACF Pro is active
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    /**
     * Field Group: Carte (Book) Details
     */
    acf_add_local_field_group([
        'key' => 'group_carte_details',
        'title' => 'Detalii Carte',
        'fields' => [
            // BPT Number
            [
                'key' => 'field_nr_bpt',
                'label' => 'Nr. BPT',
                'name' => 'nr_bpt',
                'type' => 'number',
                'instructions' => 'Numărul volumului în colecția Biblioteca pentru Toți',
                'required' => 1,
                'min' => 1,
                'max' => 999,
            ],
            // Year Written
            [
                'key' => 'field_an_scriere',
                'label' => 'An scriere',
                'name' => 'an_scriere',
                'type' => 'text',
                'instructions' => 'Anul în care a fost scrisă opera (ex: 1869, cca. 400 î.Hr.)',
            ],
            // Year Published BPT
            [
                'key' => 'field_an_publicare_bpt',
                'label' => 'An publicare BPT',
                'name' => 'an_publicare_bpt',
                'type' => 'number',
                'instructions' => 'Anul primei publicări în colecția BPT',
                'required' => 1,
                'min' => 1953,
                'max' => 1989,
            ],
            // Translator
            [
                'key' => 'field_traducator',
                'label' => 'Traducător',
                'name' => 'traducator',
                'type' => 'text',
                'instructions' => 'Numele traducătorului (dacă este cazul)',
            ],
            // Preface by
            [
                'key' => 'field_prefata_de',
                'label' => 'Prefață de',
                'name' => 'prefata_de',
                'type' => 'text',
                'instructions' => 'Autorul prefaței',
            ],
            // Representative Quote
            [
                'key' => 'field_citat_reprezentativ',
                'label' => 'Citat reprezentativ',
                'name' => 'citat_reprezentativ',
                'type' => 'textarea',
                'instructions' => 'Un citat memorabil din carte',
                'rows' => 4,
            ],
            // Historical Context
            [
                'key' => 'field_context_istoric',
                'label' => 'Context istoric',
                'name' => 'context_istoric',
                'type' => 'wysiwyg',
                'instructions' => 'Context despre scrierea sau publicarea operei',
                'tabs' => 'all',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ],
            // Purchase Link
            [
                'key' => 'field_link_cumparare',
                'label' => 'Link cumpărare',
                'name' => 'link_cumparare',
                'type' => 'url',
                'instructions' => 'Link pentru achiziție (anticariat, ediție nouă etc.)',
            ],
            // Public Domain
            [
                'key' => 'field_in_domeniu_public',
                'label' => 'În domeniu public',
                'name' => 'in_domeniu_public',
                'type' => 'true_false',
                'instructions' => 'Opera se află în domeniul public?',
                'default_value' => 0,
                'ui' => 1,
            ],
            // Download File
            [
                'key' => 'field_fisier_download',
                'label' => 'Fișier download',
                'name' => 'fisier_download',
                'type' => 'file',
                'instructions' => 'PDF sau EPUB pentru descărcare (doar dacă e în domeniul public)',
                'return_format' => 'array',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_in_domeniu_public',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ],
            // Page Count
            [
                'key' => 'field_nr_pagini',
                'label' => 'Nr. pagini',
                'name' => 'nr_pagini',
                'type' => 'number',
                'instructions' => 'Numărul de pagini al ediției BPT',
                'min' => 1,
            ],
            // Personal Notes (admin only)
            [
                'key' => 'field_note_personale',
                'label' => 'Note personale',
                'name' => 'note_personale',
                'type' => 'textarea',
                'instructions' => 'Note interne (nu se afișează public)',
                'rows' => 3,
            ],
            // Personal Rating
            [
                'key' => 'field_rating_personal',
                'label' => 'Rating personal',
                'name' => 'rating_personal',
                'type' => 'range',
                'min' => 1,
                'max' => 5,
                'step' => 1,
            ],
            // Collection Status
            [
                'key' => 'field_stare_colectie',
                'label' => 'Stare în colecție',
                'name' => 'stare_colectie',
                'type' => 'select',
                'choices' => [
                    'de_achizitionat' => 'De achiziționat',
                    'in_colectie' => 'În colecție',
                    'digitalizat' => 'Digitalizat',
                ],
                'default_value' => 'de_achizitionat',
            ],
            // Featured
            [
                'key' => 'field_featured',
                'label' => 'Carte de referință',
                'name' => 'featured',
                'type' => 'true_false',
                'instructions' => 'Afișează pe pagina principală',
                'ui' => 1,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'carte',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
    ]);

    /**
     * Field Group: Eveniment (Event) Details
     */
    acf_add_local_field_group([
        'key' => 'group_eveniment_details',
        'title' => 'Detalii Eveniment',
        'fields' => [
            // Event Date
            [
                'key' => 'field_data_eveniment',
                'label' => 'Data eveniment',
                'name' => 'data_eveniment',
                'type' => 'date_picker',
                'instructions' => 'Data exactă a evenimentului',
                'required' => 1,
                'display_format' => 'd/m/Y',
                'return_format' => 'Y-m-d',
            ],
            // Display Date
            [
                'key' => 'field_data_afisata',
                'label' => 'Data afișată',
                'name' => 'data_afisata',
                'type' => 'text',
                'instructions' => 'Cum să se afișeze data (ex: "Primăvara 1953", "1960-1965")',
            ],
            // Short Description
            [
                'key' => 'field_descriere_scurta',
                'label' => 'Descriere scurtă',
                'name' => 'descriere_scurta',
                'type' => 'textarea',
                'instructions' => 'Descriere scurtă pentru afișare în timeline',
                'rows' => 2,
                'maxlength' => 200,
            ],
            // Importance
            [
                'key' => 'field_importanta',
                'label' => 'Importanță',
                'name' => 'importanta',
                'type' => 'select',
                'choices' => [
                    'mare' => 'Mare',
                    'medie' => 'Medie',
                    'mica' => 'Mică',
                ],
                'default_value' => 'medie',
            ],
            // Marker Color
            [
                'key' => 'field_culoare_marker',
                'label' => 'Culoare marker',
                'name' => 'culoare_marker',
                'type' => 'color_picker',
                'instructions' => 'Culoarea personalizată pentru marcaj (opțional)',
            ],
            // Image Gallery
            [
                'key' => 'field_galerie_imagini',
                'label' => 'Galerie imagini',
                'name' => 'galerie_imagini',
                'type' => 'gallery',
                'instructions' => 'Imagini relevante pentru eveniment',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ],
            // Associated Books
            [
                'key' => 'field_carti_asociate',
                'label' => 'Cărți asociate',
                'name' => 'carti_asociate',
                'type' => 'relationship',
                'instructions' => 'Cărți legate de acest eveniment',
                'post_type' => ['carte'],
                'filters' => ['search'],
                'return_format' => 'id',
            ],
            // Era Quote
            [
                'key' => 'field_citat_epoca',
                'label' => 'Citat de epocă',
                'name' => 'citat_epoca',
                'type' => 'textarea',
                'instructions' => 'Un citat relevant din acea perioadă',
                'rows' => 3,
            ],
            // Source
            [
                'key' => 'field_sursa_informatie',
                'label' => 'Sursa informației',
                'name' => 'sursa_informatie',
                'type' => 'text',
                'instructions' => 'De unde provine informația',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'eveniment',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
    ]);

    /**
     * Field Group: Autor (Author) Taxonomy Fields
     */
    acf_add_local_field_group([
        'key' => 'group_autor_fields',
        'title' => 'Detalii Autor',
        'fields' => [
            [
                'key' => 'field_autor_an_nastere',
                'label' => 'An naștere',
                'name' => 'an_nastere',
                'type' => 'text',
                'instructions' => 'Ex: 1821, cca. 470 î.Hr.',
            ],
            [
                'key' => 'field_autor_an_deces',
                'label' => 'An deces',
                'name' => 'an_deces',
                'type' => 'text',
                'instructions' => 'Lasă gol dacă autorul trăiește',
            ],
            [
                'key' => 'field_autor_tara_origine',
                'label' => 'Țara de origine',
                'name' => 'tara_origine',
                'type' => 'text',
            ],
            [
                'key' => 'field_autor_biografie_scurta',
                'label' => 'Biografie scurtă',
                'name' => 'biografie_scurta',
                'type' => 'wysiwyg',
                'tabs' => 'all',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ],
            [
                'key' => 'field_autor_fotografie',
                'label' => 'Fotografie',
                'name' => 'fotografie',
                'type' => 'image',
                'return_format' => 'id',
                'preview_size' => 'thumbnail',
            ],
            [
                'key' => 'field_autor_wikipedia_link',
                'label' => 'Link Wikipedia',
                'name' => 'wikipedia_link',
                'type' => 'url',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'autor',
                ],
            ],
        ],
    ]);

    /**
     * Field Group: Epoca (Era) Taxonomy Fields
     */
    acf_add_local_field_group([
        'key' => 'group_epoca_fields',
        'title' => 'Detalii Epoca',
        'fields' => [
            [
                'key' => 'field_epoca_descriere',
                'label' => 'Descriere',
                'name' => 'descriere_epoca',
                'type' => 'wysiwyg',
                'tabs' => 'all',
                'toolbar' => 'basic',
            ],
            [
                'key' => 'field_epoca_perioada',
                'label' => 'Perioada',
                'name' => 'perioada',
                'type' => 'text',
                'instructions' => 'Ex: sec. V î.Hr. - sec. V d.Hr.',
            ],
            [
                'key' => 'field_epoca_caracteristici',
                'label' => 'Caracteristici',
                'name' => 'caracteristici',
                'type' => 'wysiwyg',
                'tabs' => 'all',
                'toolbar' => 'basic',
            ],
            [
                'key' => 'field_epoca_autori_reprezentativi',
                'label' => 'Autori reprezentativi',
                'name' => 'autori_reprezentativi',
                'type' => 'wysiwyg',
                'tabs' => 'all',
                'toolbar' => 'basic',
            ],
            [
                'key' => 'field_epoca_culoare',
                'label' => 'Culoare',
                'name' => 'culoare_epoca',
                'type' => 'color_picker',
                'instructions' => 'Culoare principală pentru această epocă',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'epoca',
                ],
            ],
        ],
    ]);

    /**
     * Field Group: Tip Eveniment Taxonomy Fields
     */
    acf_add_local_field_group([
        'key' => 'group_tip_eveniment_fields',
        'title' => 'Detalii Tip Eveniment',
        'fields' => [
            [
                'key' => 'field_tip_culoare',
                'label' => 'Culoare',
                'name' => 'culoare',
                'type' => 'color_picker',
                'instructions' => 'Culoare pentru acest tip de eveniment pe timeline',
            ],
            [
                'key' => 'field_tip_icon',
                'label' => 'Icon',
                'name' => 'icon',
                'type' => 'text',
                'instructions' => 'Nume icon (ex: book, calendar, star)',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'tip-eveniment',
                ],
            ],
        ],
    ]);
}

/**
 * Set ACF JSON save point
 */
add_filter('acf/settings/save_json', 'bpt_acf_json_save_point');

function bpt_acf_json_save_point($path) {
    return get_stylesheet_directory() . '/acf-json';
}

/**
 * Set ACF JSON load point
 */
add_filter('acf/settings/load_json', 'bpt_acf_json_load_point');

function bpt_acf_json_load_point($paths) {
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
}
