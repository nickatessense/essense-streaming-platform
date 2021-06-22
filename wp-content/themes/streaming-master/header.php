<?php
/**
 * The template for displaying the header
 *
 * This is the template that displays all of the <head> section
 *
 */
?>

<!doctype html>

  <html class="no-js"  <?php language_attributes(); ?>>

	<head>
		<meta charset="utf-8">
		
		<!-- Force IE to use the latest rendering engine available -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<!-- Mobile Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta class="foundation-mq">
		<?php 
		date_default_timezone_set('America/New_York');
		session_start();  
		if ($_GET['logged'] === 'login') {

			$_SESSION['loginTime'] = date("H:i:s");
			get_template_part('db_analytics/content', 'sessionID');
		}
		?>
		
		<!-- If Site Icon isn't set in customizer -->
		<?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) { ?>
			<!-- Icons & Favicons -->
			<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
			<link href="<?php echo get_template_directory_uri(); ?>/assets/images/apple-icon-touch.png" rel="apple-touch-icon" />	
	    <?php } ?>

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php wp_head(); ?>

		<?php get_template_part( 'db_analytics/content', 'pageview' ); ?>

	</head>
			
	<body <?php if (!is_user_logged_in()) { ?>id="not-login" <?php } ?><?php body_class(); ?>>
		
		<?php if (is_user_logged_in()) { ?>

			<header class="header" role="banner">
				<div class="header-internal">
					<div class="header-left">
						<div class="logo">

							<a href="<?php echo home_url(); ?>">
								<?php 
								$image = get_field('main_logo', 'option');
								if( !empty( $image ) ): ?>
									<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="inner-logo" />
								<?php endif; ?>
							</a>

						</div><!-- /.logo -->

						<div class="welcome">
							<p>Welcome, <?php $user_id = get_current_user_id();
							$first_name = get_user_meta($user_id, 'first_name', true); echo $first_name ." ". $last_name; ;?>| <?php global $current_user;
								get_currentuserinfo();
								echo 'You last logged in: ' . date("F d, Y h:ma", iiwp_get_last_login($current_user->ID,true)); ?></p>
						</div><!-- /.welcome -->

					</div><!-- /.header-left -->

					<div class="header-right">
						<ul>
							<li class="logout"><a href="<?php echo home_url(); ?>/wp-login.php?action=logout">Log Out</a></li>
							<!-- <li class="profile-edit"><a href="/profile-edit/" rel="noopener noreferrer"><img src="<?php //echo get_template_directory_uri(); ?>/assets/images/icon-profile-edit.svg" alt="profile edit icon" /></a></li> -->
							<li id="mobile-menu">
								<button class="hamburger hamburger--slider" type="button">
							 		<span class="hamburger-box">
							 		<span class="hamburger-inner"></span>
							 		</span>
								</button>
							</li><!-- .mobile-menu -->
						</ul>
						
					</div><!-- /.header-right -->

				</div><!-- /.header-internal -->
				<div class="mobile-list deactive">
					<nav id="main-menu" role="navigation">
					<?php if ( is_active_sidebar( 'main-menu' ) ) : ?>
						<?php dynamic_sidebar( 'main-menu' ); ?>
					<?php endif; ?>

					<?php if( current_user_can('administrator') ) {  ?>
						<?php if ( is_active_sidebar( 'admin-menu' ) ) : ?>

							<?php dynamic_sidebar( 'admin-menu' ); ?>

						<?php endif; ?>
					<?php } ?>
					</nav>

					<nav>
						<ul>
							<li class="logout"><a href="<?php echo home_url(); ?>/wp-login.php?action=logout">Log Out</a></li>
						</ul>
					</nav>
				</div><!-- /.mobile-list -->
			</header> <!-- end .header -->

		<?php } ?>