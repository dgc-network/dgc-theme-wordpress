<?php
/**
 * The Shop Sidebar containing Widget areas for Shop Page.
 *
 * @package WordPress
 * @subpackage dgc-theme
 * @since dgc-theme 1.0
 */?>

<div id="secondary" class="widget-area" role="complementary">
	<?php do_action( 'before_sidebar' ); ?>
	<?php if ( ! dynamic_sidebar( 'sidebar-5' ) ) : ?>
					
		<aside id="woocommerce_product_search-2" class="widget woocommerce widget_product_search">
			<h3 class="widget-title"><?php _e('Search Products', 'textdomain'); ?></h3>
			<?php get_product_search_form(); ?>
		</aside>
					
	<?php endif; // end sidebar widget area ?>
</div><!-- #secondary .widget-area -->
