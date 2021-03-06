<?php 
/**
 * The template for displaying all single posts and attachments
 */

get_header(); ?>
	
    <?php if (!is_user_logged_in()) { ?>
    <?php get_template_part( 'parts/content', 'login' ); ?>
    <?php } else { ?>

	<main class="content">
		
	    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	    	<?php get_template_part( 'parts/loop', 'single' ); ?>
	    	
	    <?php endwhile; else : ?>
	
	   		<?php get_template_part( 'parts/content', 'missing' ); ?>

	    <?php endif; ?>

	</main> <!-- end #main -->
	
	<?php get_sidebar(); ?>
	<?php } ?>

<?php get_footer(); ?>