<?php
/**
 * The template for displaying posts in the Video post format.
 *
 * @package WordPress
 * @subpackage dgc-theme
 * @since dgc-theme 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('blog_post'); ?>>
	<?php $day 			= get_the_date('d'); 
		  $month_abr 	= get_the_date('M');
	?>
	<div class="date_of_post updated">
		<span class="day_post"><?php print $day; ?></span>
		<span class="month_post"><?php print $month_abr; ?></span>
	</div>
	
	<div class="post-content">	
		<header class="post-header">
			<?php if ( is_single() ) : ?>
				<h1 class="post-title entry-title"><?php the_title(); ?></h1>
			<?php else : ?>
				<h2 class="post-title entry-title">
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>
			<?php endif; // is_single() ?>		
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'textdomain' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'textdomain' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
		</div><!-- .entry-content -->

		<footer class="entry-meta">
			<?php dgc_entry_meta(); ?>

			<?php if ( comments_open() && ! is_single() ) : ?>
			<span class="comments-link">
				<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a comment', 'textdomain' ) . '</span>', __( 'One comment so far', 'textdomain' ), __( 'View all % comments', 'textdomain' ) ); ?>
			</span><!-- .comments-link -->
			<?php endif; // comments_open() ?>

			<?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
				<?php get_template_part( 'author-bio' ); ?>
			<?php endif; ?>
			<?php edit_post_link( __( 'Edit', 'textdomain' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->
	</div>
</article><!-- #post -->