<?php
// Redirect back to our version of the login page
function custom_login(){
 global $pagenow;
 
 if( 'wp-login.php' === $pagenow && $_GET['action']!="logout" && $_GET['action']!="lostpassword" && $_GET['action'] !="rp") {
     wp_redirect(home_url());
     // exit();
 }
}
add_action('login_headerurl','custom_login');

//redirect to homepage after login
function login_redirect( $redirect_to, $request, $user ){
    return home_url();
}
add_filter( 'login_redirect', 'login_redirect', 10, 3 );

//throw an error if login incorrect

function my_front_end_login_fail( $username ) {
   $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
   // if there's a valid referrer, and it's not the default log-in screen
   if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
      wp_redirect( $referrer . '?login=failed' );  // let's append some information (login=failed) to the URL for the theme to use
      exit;
   }
}
add_action( 'wp_login_failed', 'my_front_end_login_fail' );  // hook failed login

//Confirm redirect
function wpse_lost_password_redirect() {

    // Check if have submitted 
    $confirm = ( isset($_GET['checkemail'] ) ? $_GET['checkemail'] : '' );

    if( $confirm ) {
        wp_redirect( home_url("?checkemail=confirm") ); 
        exit;
    }
}
add_action('login_headerurl', 'wpse_lost_password_redirect');

// Custom CCS styles
function my_login_style() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/logo.png);
            width:240px;
            height:162px;
            background-size: 240px auto;
            background-position: center bottom;
            background-repeat: no-repeat;
            padding-bottom: 30px;
        }
        body.login {
            /*background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/body-bg.jpg);*/
            background-color: #f1f1f1;
            background-repeat: no-repeat;
        }
        body.login input[type=checkbox]:focus, body.login input[type=color]:focus, body.login input[type=date]:focus, body.login input[type=datetime-local]:focus, body.login input[type=datetime]:focus, body.login input[type=email]:focus, body.login input[type=month]:focus, body.login input[type=number]:focus, body.login input[type=password]:focus, body.login input[type=radio]:focus, body.login input[type=search]:focus, body.login input[type=tel]:focus, body.login input[type=text]:focus, body.login input[type=time]:focus, body.login input[type=url]:focus, body.login input[type=week]:focus, body.login select:focus, body.login textarea:focus {
          border-color: #21547a;
          box-shadow: 0 0 0 1px #21547a;
        }
        .login #login_error, .login .message, .login .success {
          border-left: 4px solid #0a2a3b !important;
        }
        #login form p.submit input {
          background: #0a2a3b;
          border: #0a2a3b;
        }
        p#nav {
          display: none;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_style' );

// set the last login date
add_action('wp_login','iiwp_set_last_login', 0, 2);
function iiwp_set_last_login($login, $user) {  
    $user = get_user_by('login',$login);
    $time = current_time( 'timestamp' );
    $last_login = get_user_meta( $user->ID, '_last_login', 'true' );
 
    if(!$last_login){
    update_usermeta( $user->ID, '_last_login', $time );
    }else{
    update_usermeta( $user->ID, '_last_login_prev', $last_login );
    update_usermeta( $user->ID, '_last_login', $time );
    }
 
}
 
// get last login date
function iiwp_get_last_login($user_id,$prev=null){
 
  $last_login = get_user_meta($user_id);
  $time = current_time( 'timestamp' );
 
  if(isset($last_login['_last_login_prev'][0]) && $prev){
          $last_login = get_user_meta($user_id, '_last_login_prev', 'true' );
  }else if(isset($last_login['_last_login'][0])){
          $last_login = get_user_meta($user_id, '_last_login', 'true' );
  }else{
    update_usermeta( $user_id, '_last_login', $time );
    $last_login = $last_login['_last_login'][0];
  }
 
  return $last_login;
}

//From email
function itsg_mail_from_address( $email ) {
return 'noreply@essensepartners.com';
}
add_filter( 'wp_mail_from', 'itsg_mail_from_address' );

function itsg_mail_from_name( $from_name ) {
return 'Essense Partners';
}
add_filter( 'wp_mail_from_name', 'itsg_mail_from_name' );

//Allow logout without confirmation
function logout_without_confirm($action, $result)
{
    if ($action == "log-out" && !isset($_GET['_wpnonce'])) {
        $redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : '/';
        $location = str_replace('&amp;', '&', wp_logout_url($redirect_to));
        header("Location: $location");
        die;
    }
}
add_action('check_admin_referer', 'logout_without_confirm', 10, 2);