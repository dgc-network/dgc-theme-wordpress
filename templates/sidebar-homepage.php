<?php
/**
 * The Homepage Sidebar containing Widget areas for Homepage.
 *
 * @package WordPress
 * @subpackage dgc-theme
 * @since dgc-theme 1.0
 */?>

<div id="secondary" class="widget-area" role="complementary">
	<?php do_action( 'before_sidebar' ); ?>
	<?php if ( ! dynamic_sidebar( 'sidebar-4' ) ) : ?>
				
		<aside id="search" class="widget widget_search">
			<?php get_search_form(); ?>
		</aside>

		<aside id="archives" class="widget">
			<h1 class="widget-title"><?php _e( 'Archives', 'textdomain' ); ?></h1>
			<ul>
				<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
			</ul>
		</aside>

		<aside id="meta" class="widget">
			<h1 class="widget-title"><?php _e( 'Meta', 'textdomain' ); ?></h1>
			<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<?php wp_meta(); ?>
			</ul>
		</aside>
				
	<?php endif; // end sidebar widget area ?>
</div><!-- #secondary .widget-area -->
