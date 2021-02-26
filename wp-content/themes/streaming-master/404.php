<?php
/**
 * The template for displaying 404 (page not found) pages.
 *
 * For more info: https://codex.wordpress.org/Creating_an_Error_404_Page
 */

get_header(); ?>
	<?php if (!is_user_logged_in()) { ?>
    <?php get_template_part( 'parts/content', 'login' ); ?>
    <?php } else { ?>
	<main class="content">
		<div class="inner-content">
			<h1><?php _e( '404 - Page is Not Found', 'jointswp' ); ?></h1>
		</div><!-- /.inner-content -->
	</main> <!-- /.content -->
	
	<?php get_sidebar(); ?>
	<?php } ?>
<?php get_footer(); ?>