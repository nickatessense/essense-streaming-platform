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
		<footer class="footer" role="contentinfo">
			<ul class="menu">
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