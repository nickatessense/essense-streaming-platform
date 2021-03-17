<?php 
/**
 * The sidebar containing the main widget area
 */
 ?>
<div id="sidebar" class="sidebar">
	<div class="inner-sidebar">

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

	<?php if (!is_page(16)) { ?>
		<?php if ( is_active_sidebar( 'footer-menu' ) ) : ?>
			<nav id="footer-menu" role="navigation">
				<?php dynamic_sidebar( 'footer-menu' ); ?>
			</nav>
		<?php endif; ?>
	<?php } else{ ?>
			<?php if (get_field("enable_live", 16) == true){ ?>
				<?php if ( is_active_sidebar( 'footer-menu' ) ) { ?>
					<nav id="footer-menu" role="navigation">
						<?php echo wp_nav_menu( array( 
							'menu' => '4'
						)); ?>
					</nav>
				<?php }
			} else{ ?>
				<?php if ( is_active_sidebar( 'footer-menu' ) ) { ?>
					<nav id="footer-menu" role="navigation">
						<?php echo wp_nav_menu( array( 
							'menu' => '5'
						)); ?>
					</nav>
			<?php } 
		}
	} ?>
	</div><!-- /.inner-sidebar -->
</div><!-- /.sidebar -->