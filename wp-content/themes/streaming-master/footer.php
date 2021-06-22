<?php
/**
 * The template for displaying the footer. 
 *
 * Comtains closing divs for header.php.
 *
 * For more info: https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */			
 ?>
	<?php if (is_user_logged_in()) { ?>
		<?php if (!is_page(16)) { ?>
			<?php if (get_field("enable_live", 16) == true){ ?>
				<?php if ( is_active_sidebar( 'footer-menu' ) ) { ?>
					<nav id="footer-menu" class="tabletVideo" role="navigation">
						<?php dynamic_sidebar( 'footer-menu' ); ?>
					</nav>
				<?php }
			} else{ ?>
				<?php if ( is_active_sidebar( 'footer-menu' ) ) { ?>
					<nav id="footer-menu" role="navigation">
						<?php dynamic_sidebar( 'footer-menu' ); ?>
					</nav>
				<?php }
			}
		}?>
		<footer class="footer" role="contentinfo">
			<ul class="menu">
                <li>SESSION ID: <?php echo session_id(); ?></li>
                <li>SESSION Login Time: <?php echo $_SESSION['loginTime']; ?></li>
				<li>Contact Us: <a href="mailto:feedback@essensepartners.com">feedback@essensepartners.com</a></li>
				<li>&copy;<?php echo date('Y'); ?> <?php bloginfo('name'); ?>. - All Rights Reserved</li>
				<li class="flexMe">
					<a href="https://essensepartners.com/" target="_blank" rel="noopener noreferrer">
						<p>Powered by: </p>
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/essense-logo.svg">
					</a>
				</li>
			</ul>
		</footer> <!-- end .footer -->
	<?php } ?>
		<?php wp_footer(); ?>
		
	</body>
	
</html> <!-- end page -->