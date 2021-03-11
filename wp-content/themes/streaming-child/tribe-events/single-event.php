<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();

$event_id = get_the_ID();

?>


<div class="tribe-events-back">
	<a href="<?php echo home_url(); ?>/calendar-event"> <?php printf( '&laquo; ' . esc_html_x( 'Back to Calendar', 'the-events-calendar' ), $events_label_plural ); ?></a>
</div>

<div id="event-content">

	<div class="event-title">
		<h1><span><?php echo tribe_get_start_date( null, false, 'F j, Y g:i a' ); ?></span></br>
			<?php the_title(); ?></h1>
	</div>

	<?php while ( have_posts() ) :  the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('event-content'); ?>>
			<!-- Event featured image, but exclude link -->
			<?php //echo tribe_event_featured_image( $event_id, 'full', false ); ?>

			<!-- Event content -->
			<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
			<div class="tribe-events-single-event-description tribe-events-content">
				<?php the_content(); ?>
			</div>
			
		</div> <!-- #post-x -->
	<?php endwhile; ?>
</div><!-- #event-content -->