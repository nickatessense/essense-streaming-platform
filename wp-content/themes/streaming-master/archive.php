<?php
/**
 * Displays archive pages if a speicifc template is not set. 
 *
 * For more info: https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header(); ?>
	
    <?php if (!is_user_logged_in()) { ?>
    <?php get_template_part( 'parts/content', 'login' ); ?>
    <?php } else { ?>

	<main class="content">
			    
    	<header>
    		<h1 class="page-title"><?php the_archive_title();?></h1>
			<?php the_archive_description('<div class="taxonomy-description">', '</div>');?>
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