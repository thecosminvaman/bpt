<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Biblioteca_Pentru_Toti
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
    return;
}
?>

<aside id="secondary" class="sidebar widget-area" role="complementary">
    <?php dynamic_sidebar( 'blog-sidebar' ); ?>
</aside>
