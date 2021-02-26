<?php
    /*
    Template Name: Live Window
    */
    get_header();
 ?>
    <?php if (!is_user_logged_in()) { ?>
    <?php get_template_part( 'parts/content', 'login' ); ?>
    <?php } else { ?>
        
    <main id="live-window" class="content">
        <?php 
        $live = get_field('enable_live');
        $stream = get_field('stream_box');
        $sidebar = get_field('sidebar_box'); 
        ?>
        <?php if( $live ) {?>
        <div id="video-holder">
            <div class="streambox video-embed<?php if( $sidebar ){ ?> sidebar-inc<?php } ?>">
                <?php echo $stream; ?>
            </div>

            <?php if( $sidebar ) { ?>
            <div class="sidebarbox"><?php echo $sidebar; ?></div>
            <?php } ?>
        </div>

        <?php } else { ?>
        <div class="inner-content">
            <?php the_content(); ?>
        </div>
        <?php } ?>

    </main> <!-- end #main -->
    
    <?php get_sidebar(); ?>
    <?php } ?>

<?php get_footer(); ?>