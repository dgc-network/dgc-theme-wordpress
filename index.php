<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage dgc-theme
 * @since dgc-theme 1.0
 */

get_header(); ?>
	
	<?php dgc_get_content_with_custom_sidebar('blogright'); ?>

<?php get_footer(); ?>