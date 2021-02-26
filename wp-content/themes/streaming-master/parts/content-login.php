<section id="login-portal">
    <header class="login-header" role="banner">
        <div class="header-internal">
            <a href="<?php echo home_url(); ?>">
            <?php 
                $image = get_field('main_logo', 'option');
                if( !empty( $image ) ): ?>
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="home-logo" />
                <?php endif; ?>
            </a>
        </div><!-- /.header-home -->

    </header> <!-- end .header -->
    <div class="login-portal">
        <?php if($_GET[checkemail] == 'confirm' && !is_user_logged_in() ):?>
            <div class="passwordNoti">
                <h1>Check your email for the confirmation link</h1>
            </div>
        <?php endif;?>
                
        <div class="message-holder">

            <div class="message-left">
                <div class="text-holder">
                    <h1><?php the_field('homepage_welcome', 'option') ;?></h1>
                </div><!-- /.text-holder -->
            </div><!-- /.message-left -->

            <div class="message-right">
                <div id="login" class="text-holder">
                    <?php if ( !is_user_logged_in() && strpos($_SERVER['REQUEST_URI'], "login=failed" ) !== false){ ?>
                        <div class="login-failed">
                            <p>Sorry, your entered the wrong username or password.</p> 
                        </div><!-- /.login-failed -->
                    <?php }; ?>
                    <?php echo do_shortcode('[groups_login]');?>
                    <a href="<?php echo home_url(); ?>/wp-login.php?action=lostpassword">Forgot password?</a>
                </div>
                <!-- /.message-holder -->

            </div><!-- /.message-right -->
            
        </div><!-- /.message-holder -->
    </div><!-- /.login-portal -->

</section><!-- /#login-portal -->