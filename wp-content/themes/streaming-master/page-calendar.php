<?php 
    /*
    Template Name: Calendar
    */
    get_header();
 ?>
			
    <?php if (!is_user_logged_in()) { ?>
    <?php get_template_part( 'parts/content', 'login' ); ?>
    <?php } else { ?>
	<main id="event-calendar" class="content">
        <div class="inner-content">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                
                <div class="event-calendar">
                    <?php the_content(); ?>
                </div>
                <div class="event-posts">
                    <?php get_template_part( 'parts/loop', 'events' ); ?>
                    <div class="placeholder-content">
                        <div class="placeholder-image">
                            <img src ="<?php echo get_template_directory_uri(); ?>/assets/images/calendar-placeholder.svg" alt="" />
                        </div><!-- /.placeholder-image -->
                        <p>Select an event on the calendar to get more information</p>
                    </div><!-- /.placeholder-content -->
                </div> <!--.event-posts-->
                
            <?php endwhile; else : ?>
        
                <?php get_template_part( 'parts/content', 'missing' ); ?>

            <?php endif; ?>
        </div><!-- /.inner-content -->
   
	</main> <!-- end #main -->

	<?php get_sidebar(); ?>
    <?php } ;?>

<?php get_footer(); ?>