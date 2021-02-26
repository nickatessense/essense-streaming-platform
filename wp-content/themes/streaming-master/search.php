<?php 
/**
 * The template for displaying search results pages
 *
 * For more info: https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 */
 	
get_header(); ?>
	
    <?php if (!is_user_logged_in()) { ?>
    <?php get_template_part( 'parts/content', 'login' ); ?>
    <?php } else { ?>

	<main class="content">
		<header>
			<h1 class="archive-title"><?php _e( 'Search Results for:', 'jointswp' ); ?> <?php echo esc_attr(get_search_query()); ?></h1>
		</header>

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	 
			<!-- To see additional archive styles, visit the /parts directory -->
			<?php get_template_part( 'parts/loop', 'archive' ); ?>
		    
		<?php endwhile; ?>	

			<?php joints_page_navi(); ?>
			
		<?php else : ?>
		
			<?php get_template_part( 'parts/content', 'missing' ); ?>
				
	    <?php endif; ?>

	</main> <!-- end #main -->

	<?php get_sidebar(); ?>
	<?php } ?>

<?php get_footer(); ?>