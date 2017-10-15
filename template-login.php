<?php
/**
 * Template name: Login Page
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera
 */

if ( is_user_logged_in() ) { 

	global $redux_demo; 
	$profile = $redux_demo['profile'];
	wp_redirect( $profile ); exit;

}

global $user_ID, $username, $password, $remember;

//We shall SQL escape all inputs
$username = esc_sql(isset($_REQUEST['username']) ? $_REQUEST['username'] : '');
$password = esc_sql(isset($_REQUEST['password']) ? $_REQUEST['password'] : '');
$remember = esc_sql(isset($_REQUEST['rememberme']) ? $_REQUEST['rememberme'] : '');
	
if($remember) $remember = "true";
else $remember = "false";
$login_data = array();
$login_data['user_login'] = $username;
$login_data['user_password'] = $password;
$login_data['remember'] = $remember;
$user_verify = wp_signon( $login_data, false ); 
//wp_signon is a wordpress function which authenticates a user. It accepts user info parameters as an array.
if(isset($_POST['submit'])){
	if($_POST['submit'] == 'Login'){
		if ( is_wp_error($user_verify)){		
			$UserError =  esc_html__( 'Invalid username or password. Please try again!', 'classiera' );
		}else{
			global $redux_demo; 
			$profile = $redux_demo['profile'];
			wp_redirect( $profile ); exit;
		}
	}
}
global $redux_demo; 
$login = $redux_demo['login'];
$reset = $redux_demo['reset'];
$register = $redux_demo['register'];
$classieraSocialLogin = $redux_demo['classiera_social_login'];
$rand1 = rand(0,9);
$rand2 = rand(0,9);
$rand_answer = $rand1 + $rand2;
get_header(); ?>
<?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
?>
<!-- page content -->
<section class="inner-page-content border-bottom top-pad-50">
	<div class="login-register login-register-v1">
		<div class="container">
            <div class="row">
				<div class="col-lg-10 col-md-11 col-sm-12 center-block">
					<div class="row">
                        <div class="col-lg-12">
                            <div class="classiera-login-register-heading border-bottom text-center">
                                <h3 class="text-uppercase"><?php esc_html_e('Login', 'classiera') ?></h3>
                            </div><!--classiera-login-register-heading-->
							<?php if($classieraSocialLogin == 1){?>
                            <div class="social-login border-bottom">
                                <h5 class="text-uppercase text-center">
								<?php esc_html_e('Login or Signup With Social Media', 'classiera') ?>
								</h5>
                                <!--Social Plugins-->
								<?php
								/* Detect plugin. For use on Front End only.*/
								include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
								// check for plugin using plugin name
								if ( is_plugin_active( "nextend-facebook-connect/nextend-facebook-connect.php" ) ) {
									//plugin is activated
									?>
									<a class="loginSocialbtn fb" href="<?php echo get_site_url(); ?>/wp-login.php?loginFacebook=1" onclick="window.location = '<?php echo get_site_url(); ?>/wp-login.php?loginFacebook=1&redirect='+window.location.href; return false;"><i class="fa fa-facebook"></i><?php esc_html_e('Login via Facebook', 'classiera') ?></a>
								<?php } ?>
								<?php
								/* Detect plugin. For use on Front End only.*/
								include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
								// check for plugin using plugin name
								if ( is_plugin_active( "nextend-twitter-connect/nextend-twitter-connect.php" ) ) {
									//plugin is activated
									?>
									<a class="loginSocialbtn twitter" href="<?php echo get_site_url(); ?>/wp-login.php?loginTwitter=1" onclick="window.location = '<?php echo get_site_url(); ?>/wp-login.php?loginTwitter=1&redirect='+window.location.href; return false;"><i class="fa fa-twitter"></i><?php esc_html_e('Login via Twitter', 'classiera') ?></a>
								<?php }	?>
								<?php
								/* Detect plugin. For use on Front End only.*/
								include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
								// check for plugin using plugin name
								if ( is_plugin_active( "nextend-google-connect/nextend-google-connect.php" ) ) {
									//plugin is activated
									?>
									<a class="loginSocialbtn google" href="<?php echo get_site_url(); ?>/wp-login.php?loginGoogle=1" onclick="window.location = '<?php echo get_site_url(); ?>/wp-login.php?loginGoogle=1&redirect='+window.location.href; return false;"><i class="fa fa-google-plus"></i><?php esc_html_e('Login via Google', 'classiera') ?></a>
									<?php
								}
								?>
								<!--AccessPress Socil Login-->
								<?php
								include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
								if ( is_plugin_active( "accesspress-social-login-lite/accesspress-social-login-lite.php" )){
									echo do_shortcode('[apsl-login-lite]');
								}								
								?>
								<!--AccessPress Socil Login-->
                                <!--Social Plugins-->
								<div class="social-login-or">
                                    <span><?php esc_html_e('OR', 'classiera') ?></span>
                                </div>
                            </div><!--social-login-->
							<?php } ?>
                        </div><!--col-lg-12-->
                    </div><!--row-->
					<div class="row">
						<div class="col-lg-8 center-block">
							<form data-toggle="validator" role="form" method="POST" enctype="multipart/form-data">
								<?php if(!empty($UserError)) { ?>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-12">
												<h3><?php echo $UserError; ?></h3>
											</div>
										</div>
									</div>
								<?php } ?>
								<div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-3 single-label">
                                            <label for="username"><?php esc_html_e( 'UserName', 'classiera' ); ?> : <span class="text-danger">*</span></label>
                                        </div><!--col-lg-3-->
                                        <div class="col-lg-9">
                                            <div class="inner-addon left-addon">
                                                <i class="left-addon form-icon fa fa-lock"></i>
                                                <input type="text" id="username" name="username" class="form-control form-control-md sharp-edge" placeholder="<?php esc_html_e( 'Your Username', 'classiera' ); ?>" data-error="<?php esc_html_e( 'UserName is required', 'classiera' ); ?>" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div><!--col-lg-9-->
                                    </div><!--row-->
                                </div><!--UserName-->
								<div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-3 single-label">
                                            <label for="password"><?php esc_html_e( 'Password', 'classiera' ); ?> : <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9">
                                            <div class="inner-addon left-addon">
                                                <i class="left-addon form-icon fa fa-lock"></i>
                                                <input id="password" type="password" name="password" class="form-control form-control-md sharp-edge" placeholder="<?php esc_html_e( 'Enter Password', 'classiera' ); ?>" data-error="<?php esc_html_e( 'Password required', 'classiera' ); ?>" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--Password-->
								<div class="col-lg-9 pull-right flip">
                                    <div class="form-group clearfix">
                                        <div class="checkbox pull-left flip">
                                            <input type="checkbox" id="remember" name="rememberme" value="forever">
                                            <label for="remember"><?php esc_html_e( 'Remember me', 'classiera' ); ?></label>
                                        </div>
                                        <p class="forget-pass pull-right flip">
											<a href="<?php echo $reset; ?>"><?php esc_html_e('Forget Password?', 'classiera') ?></a>
										</p>
                                    </div>
                                    <div class="form-group">
										<input type="hidden" id="submitbtn" name="submit" value="Login" />				
										<button class="btn btn-primary sharp btn-md btn-style-one" id="edit-submit" name="op" value="Login" type="submit"><?php esc_html_e('LOGIN NOW', 'classiera') ?></button>
                                    </div>
                                    <div class="form-group">
                                        <p><?php esc_html_e('If you don’t have account?', 'classiera') ?> 
											<a href="<?php echo $register; ?>"><?php esc_html_e('Create an account.', 'classiera') ?></a>
                                        </p>
                                    </div>
                                </div><!--Rememberme-->
							</form>
						</div><!--col-lg-8-->
					</div><!--row-->
				</div><!--col-lg-10-->
			</div><!--row-->	
		</div><!--container-->	
	</div><!--login-register login-register-v1-->
</section>
<!-- page content -->
<?php get_footer(); ?>