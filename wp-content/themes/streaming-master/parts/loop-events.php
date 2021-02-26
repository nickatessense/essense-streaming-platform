<?php
/**
 * Template part for displaying page content in page.php
 */
?>

<?php 
	$args = array(  
	'post_type' => 'tribe_events',
	'post_status' => 'publish',
	'order' => 'ASC',
	'orderby' => 'date',
	'posts_per_page' => -1,
	); 
	$loop = new WP_Query( $args );
	while ( $loop->have_posts() ) : $loop->the_post();
	$thbg = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
	$terms = get_the_terms( $post->ID, 'tribe_events_cat' );
	$ical = get_field('ical');
?>

<div id="event-<?php echo $post->ID; ?>" class="event-post">

	<div class="event-content">
		<h2><?php echo tribe_get_start_date( null, false, 'F j, Y g:i a' ); ?></br>
			<?php the_title(); ?></h2>
		<?php echo the_content(); ?>
		<div class="tribe-events-cal-links">
			<a href="<?php echo tribe_get_gcal_link(); ?>" title="Add to Google Calendar" target="_blank">+ Google Calendar</a>
			<?php if ( $ical ) { ?>
			<a href="<?php echo $ical['url']; ?>">+ iCal</a>
		<?php } ?>
		</div>
		
	</div>
	<?php
		$link = get_field('link');
		$tab = get_field('new_tab');
	?>
	<?php if ( $link ) :?>
	<div class="event-link">
		<a href="<?php echo $link; ?>"<?php if ( $tab ):?> target="_blank"<?php endif; ?>>Join E-Meeting</a>
	</div>
	<?php endif; ?>
</div><!--.event-post -->
<?php endwhile; ?>
<?php wp_reset_postdata(); ?>