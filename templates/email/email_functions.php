<?php
/* Filter Email */
add_filter ("wp_mail_content_type", "classiera_mail_content_type");
function classiera_mail_content_type() {
	return "text/html";
}
/* Filter Name */
add_filter('wp_mail_from_name', 'classiera_blog_name_from_name');
function classiera_blog_name_from_name($name = '') {
     return get_bloginfo('name');
}
/* Filter Email */
add_filter ("wp_mail_from", "classiera_mail_from");
function classiera_mail_from() {
	$sendemail =  get_bloginfo('admin_email');
	return $sendemail;
}	
/* Publish Post Email Function*/
add_action("publish_post", "classieraPostEmail");
function classieraPostEmail($post_id){
	$post = get_post($post_id);
	$author = get_userdata($post->post_author);
	global $redux_demo;
	$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
	$trns_listing_published = $redux_demo['trns_listing_published'];
	$email_subject = $trns_listing_published;
	$author_email = $author->user_email;
	ob_start();
	include(TEMPLATEPATH . '/templates/email/email-header.php');
	?>
	<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo $classieraEmailIMG; ?>') repeat-x; background-size: cover;">
		<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo $trns_listing_published; ?></h4>
		<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
		<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
			<?php esc_html_e( 'Hi', 'classiera' ); ?>, <?php echo $author->display_name ?>. <?php esc_html_e( 'Congratulations your item has been listed', 'classiera' ); ?>!
		</h3>
	</div>
	<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
		<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
			<?php esc_html_e( 'Hi', 'classiera' ); ?>, <?php echo $author->display_name ?>. <?php esc_html_e( 'Congratulations your item has been listed', 'classiera' ); ?>! 
			<strong>(<?php echo $post->post_title ?>)</strong> <?php esc_html_e( 'on', 'classiera' ); ?> <?php echo  $blog_title = get_bloginfo('name'); ?>!
		</p>
		<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
			<?php esc_html_e( 'You have successfully listed your item on', 'classiera' ); ?> <strong><?php echo  $blog_title = get_bloginfo('name'); ?></strong>, <?php esc_html_e( 'now sit back and let us do the hard work.', 'classiera' ); ?>
		</p>
		<p>
			<span style="display: block;font-family: 'Lato', sans-serif; font-size: 16px; font-weight: bold; color: #232323; margin-bottom: 10px;"><?php esc_html_e( 'If youd like to take a look', 'classiera' ); ?> : </span>
			<a href="<?php echo get_permalink($post->ID) ?>" style="color: #0d7cb0; font-family: 'Lato', sans-serif; font-size: 14px; ">
				<?php esc_html_e( 'Click Here', 'classiera' ); ?>
			</a>
		</p>
	</div>
	<?php
	include(TEMPLATEPATH . '/templates/email/email-footer.php');	
	$message = ob_get_contents();
	ob_end_clean();
	wp_mail($author_email, $email_subject, $message);
}
/* Publish Post Email Function End*/
/* New User Registration Function Start*/

function classieraUserNotification($email, $password, $username){
	$blog_title = get_bloginfo('name');
	$blog_url = esc_url( home_url() ) ;
	$adminEmail =  get_bloginfo('admin_email');
	global $redux_demo;
	$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
	$welComeUser = $redux_demo['trns_welcome_user_title'];	
	$email_subject = $welComeUser." ".$username."!";
	
	ob_start();	
	include(get_template_directory() . '/templates/email/email-header.php');
	
	?>
	<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo $classieraEmailIMG; ?>') repeat-x; background-size: cover;">
		<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo $welComeUser; ?></h4>
		<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
		<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
			<?php esc_html_e( 'A very special welcome to you', 'classiera' ); ?>, <?php echo $username ?>
		</h3>
	</div>
	<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
		<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; font-weight: normal; text-transform: capitalize;">
			<?php esc_html_e( 'A very special welcome to you', 'classiera' ); ?>, <?php echo $username ?>. <?php esc_html_e( 'Thank you for joining', 'classiera' ); ?> <?php echo $blog_title; ?>!
		</h3>
		<p>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Your username is', 'classiera' ); ?> : </span>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;"><?php echo $username ?></span>
		</p>
		<p>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Your password is', 'classiera' ); ?> : </span>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;"><?php echo $password ?></span>
		</p>
		<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
			<?php esc_html_e( 'We hope you enjoy your stay at', 'classiera' ); ?> <a href="<?php echo $blog_url; ?>"><?php echo $blog_title; ?></a>. <?php esc_html_e( 'If you have any problems, questions, opinions, praise, comments, suggestions, please feel free to contact us at', 'classiera' ); ?> 
		 <strong><?php echo $adminEmail; ?> </strong><?php esc_html_e( 'any time!', 'classiera' ); ?>
		</p>
	</div>
	<?php
	
	include(get_template_directory() . '/templates/email/email-footer.php');
	
	$message = ob_get_contents();
	ob_end_clean();

	wp_mail($email, $email_subject, $message);
	}

/* New User Registration Function End*/
/* Email to Admin On New User Registration */
function classieraNewUserNotifiy($email, $username){
	$blog_title = get_bloginfo('name');
	$blog_url = esc_url( home_url() ) ;
	$adminEmail =  get_bloginfo('admin_email');
	global $redux_demo;
	$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
	
	$email_subject = "New User Has been Registered On ".$blog_title;
	
	ob_start();	
	include(get_template_directory() . '/templates/email/email-header.php');
	
	?>
	<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo $classieraEmailIMG; ?>') repeat-x; background-size: cover;">
		<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php esc_html_e( 'New User has been Registered !', 'classiera' ); ?></h4>
		<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
		<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
			<?php esc_html_e( 'Hello Admin, New User Registred on', 'classiera' ); ?>, <?php echo $blog_title ?>
		</h3>
	</div>
	<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
		<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
			<?php esc_html_e( 'Hello, New User has been Registred on', 'classiera' ); ?>, <?php echo $blog_title ?>. <?php esc_html_e( 'By using this email', 'classiera' ); ?> <?php echo $email; ?>!
		</p>
		<p>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'His User name is:', 'classiera' ); ?> : </span>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;"><?php echo $username ?></span>
		</p>
	</div>	
	<?php
	
	include(get_template_directory() . '/templates/email/email-footer.php');
	
	$message = ob_get_contents();
	ob_end_clean();

	wp_mail($adminEmail, $email_subject, $message);
	}
/* Email to Admin On New User Registration */
/*Pending Post Status Function*/
function classieraPendingPost( $new_status, $old_status, $post ) {
    if ( $new_status == 'private' ) {
        $author = get_userdata($post->post_author);
		global $redux_demo;
		$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
		$trns_new_post_posted = $redux_demo['trns_new_post_posted'];
		$email_subject = $trns_new_post_posted;
		$adminEmail =  get_bloginfo('admin_email');	
		ob_start();
		include(TEMPLATEPATH . '/templates/email/email-header.php');
		?>
		<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo $classieraEmailIMG; ?>') repeat-x; background-size: cover;">
			<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo $trns_new_post_posted; ?></h4>
			<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
			<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
				<?php esc_html_e( 'Hello Admin, New Ads Posted on', 'classiera' ); ?>, <?php echo $blog_title ?>
			</h3>
		</div>
		<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
			<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
				<?php esc_html_e( 'Hi', 'classiera' ); ?>, <?php echo $author->display_name ?>. <?php esc_html_e( 'Have Post New Ads', 'classiera' ); ?><strong>(<?php echo $post->post_title ?>)</strong> <?php esc_html_e( 'on', 'classiera' ); ?> <?php echo  $blog_title = get_bloginfo('name'); ?>!
			</p>
			 <p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;"><?php esc_html_e( 'Please Approve or Reject this Post from WordPress Dashboard.', 'classiera' ); ?> </p>
		</div>
		<?php
		include(TEMPLATEPATH . '/templates/email/email-footer.php');
		$message = ob_get_contents();
		ob_end_clean();
		wp_mail($adminEmail, $email_subject, $message);
    }
}
add_action(  'transition_post_status',  'classieraPendingPost', 10, 3 );
/*Pending Post Status Function End*/
/*Rejected Post Status Function*/
function classieraRejectedPost( $new_status, $old_status, $post ){
    if ($new_status == 'rejected'){		
        $author = get_userdata($post->post_author);		
		$author_email = $author->user_email;
		$author_display = $author->user_login;
		$blog_title = get_bloginfo('name');
		global $redux_demo;
		$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
		$email_subject = esc_html__( 'Your Ad is Rejected..!', 'classiera' );
		$adminEmail =  get_bloginfo('admin_email');	
		ob_start();
		include(TEMPLATEPATH . '/templates/email/email-header.php');
		?>
		<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo $classieraEmailIMG; ?>') repeat-x; background-size: cover;">
			<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo $email_subject; ?></h4>
			<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
			<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
				<?php esc_html_e( 'Hello', 'classiera' ); ?>, <?php echo $author_display ?>
			</h3>
		</div>
		<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
			<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
				<?php esc_html_e( 'We want to inform you, your ad is rejected, which you have posts on', 'classiera' ); ?> &nbsp;<?php echo  $blog_title = get_bloginfo('name'); ?>!
			</p>
			<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;"><?php esc_html_e( 'Please visit your Dashboard to see post status, For more information contact with website admin at this email.', 'classiera' ); ?> <a href="mailto:<?php echo $adminEmail; ?>"><?php echo $adminEmail; ?></a> </p>
		</div>
		<?php
		include(TEMPLATEPATH . '/templates/email/email-footer.php');
		$message = ob_get_contents();
		ob_end_clean();		
		wp_mail($author_email, $email_subject, $message);
    }
}
add_action(  'transition_post_status',  'classieraRejectedPost', 10, 3 );
/*Rejected Post Status Function End*/
/*Email to Post Author */
function contactToAuthor($emailTo, $subject, $name, $email, $comments, $headers, $classieraPostTitle, $classieraPostURL) {	

	$blog_title = get_bloginfo('name');
	$blog_url = esc_url( home_url() ) ;
	$adminEmail =  get_bloginfo('admin_email');
	global $redux_demo;
	$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
	
	$email_subject = $subject;
	
	ob_start();	
	include(get_template_directory() . '/templates/email/email-header.php');
	
	?>
	<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo $classieraEmailIMG; ?>') repeat-x; background-size: cover;">
		<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo $email_subject; ?></h4>
		<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
		<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
			<?php esc_html_e( 'You have received email from', 'classiera' ); ?>, <?php echo $name; ?>
		</h3>
	</div>
	<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
		<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; font-weight: normal; text-transform: capitalize;">
			<?php esc_html_e( 'Your have received this email from', 'classiera' ); ?>
		</h3>
		<p><?php echo $comments; ?></p>
		<p>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Sender Name', 'classiera' ); ?> : </span>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;"><?php echo  $name;?></span>
		</p>
		<p>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Sender Email', 'classiera' ); ?> : </span>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;"><?php echo  $email;?></span>
		</p>
		<p>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Your Post Title', 'classiera' ); ?> : </span>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;"><?php echo  $classieraPostTitle;?></span>
		</p>
		<p>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Your Post URL', 'classiera' ); ?> : </span>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;"><?php echo  $classieraPostURL;?></span>
		</p>
	</div>	
	<?php
	
	include(get_template_directory() . '/templates/email/email-footer.php');
	
	$message = ob_get_contents();
	ob_end_clean();

	wp_mail($emailTo, $email_subject, $message, $headers);
	}
/*ResetPasswordemail*/
function classiera_reset_password($new_password, $userName, $userEmail ){
	$blog_title = get_bloginfo('name');
	$blog_url = esc_url( home_url() ) ;
	$emailTo = $userEmail;
	$adminEmail =  get_bloginfo('admin_email');
	global $redux_demo;
	$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
	$email_subject = esc_html__( 'Password Reset', 'classiera' );
	
	ob_start();
	include(get_template_directory() . '/templates/email/email-header.php');
	?>
	<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo $classieraEmailIMG; ?>') repeat-x; background-size: cover;">
		<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo $email_subject; ?></h4>
		<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
		<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
			<?php esc_html_e( 'Keep Your Password Always safe..!', 'classiera' ); ?>, <?php echo $name; ?>
		</h3>
	</div>
	<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
		<p>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Your UserName Was', 'classiera' ); ?> : </span>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;"><?php echo $userName; ?></span>
		</p>
		<p>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Your New Password is', 'classiera' ); ?> : </span>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;"><?php echo $new_password; ?></span>
		</p>
	</div>
	<?php
	include(get_template_directory() . '/templates/email/email-footer.php');
	$message = ob_get_contents();
	ob_end_clean();
	wp_mail($emailTo, $email_subject, $message);
}	
/*ResetPasswordemail*/	
//Send Offer//
function classiera_send_offer_to_author($offer_price, $offer_email, $classieraCP, $classieraPU, $classieraAE, $classieraPT){
	$blog_title = get_bloginfo('name');
	$blog_url = esc_url( home_url() ) ;
	$emailTo = $userEmail;
	$adminEmail =  get_bloginfo('admin_email');
	global $redux_demo;
	$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
	$email_subject = esc_html__( 'New Offer Received..!', 'classiera' );
	
	ob_start();
	include(get_template_directory() . '/templates/email/email-header.php');
	?>
	<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo $classieraEmailIMG; ?>') repeat-x; background-size: cover;">
		<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo $email_subject; ?></h4>
		<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
		<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
			<?php esc_html_e( 'Congratulations you have received new offer for your post', 'classiera' ); ?>: <?php echo $classieraPT; ?>
		</h3>
	</div>
	<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
		<p>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Your Price was', 'classiera' ); ?> : </span>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;"><?php echo $classieraCP; ?></span>
		</p>
		<p>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Offered Price', 'classiera' ); ?> : </span>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;"><?php echo $offer_price; ?></span>
		</p>
		<p>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Contact Email', 'classiera' ); ?> : </span>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;"><?php echo $offer_email; ?></span>
		</p>
		<p>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Visit Your Post', 'classiera' ); ?> : </span>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;"><?php echo $classieraPU; ?></span>
		</p>
	</div>
	<?php
	include(get_template_directory() . '/templates/email/email-footer.php');
	$message = ob_get_contents();
	ob_end_clean();
	wp_mail($classieraAE, $email_subject, $message);
}	
/*EndOfferEmail*/
/*Report Ad to Admin*/
function classiera_reportAdtoAdmin($message, $classieraPostTitle, $classieraPostURL){
	$blog_title = get_bloginfo('name');
	$blog_url = esc_url( home_url() ) ;	
	$adminEmail =  get_bloginfo('admin_email');
	global $redux_demo;
	$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
	$email_subject = esc_html__( 'Report Ad Notification!', 'classiera' );
	
	ob_start();
	include(get_template_directory() . '/templates/email/email-header.php');
	?>
	<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo $classieraEmailIMG; ?>') repeat-x; background-size: cover;">
		<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo $email_subject; ?></h4>
		<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
		<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
			<?php esc_html_e( 'Hello Admin, DMCA/Copyright', 'classiera' ); ?>: <?php echo $classieraPT; ?>
		</h3>
	</div>
	<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
		<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
			<?php esc_html_e( 'Hi Someone Report an Ad which is posted on your website.', 'classiera' ); ?>
		</p>
		<p>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;">
				<?php esc_html_e( 'Post Title Is', 'classiera' ); ?> : 
			</span>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
				<?php echo $classieraPostTitle; ?>
			</span>
		</p>
		<p>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;">
				<?php esc_html_e( 'Post Link', 'classiera' ); ?> : 
			</span>
			<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
				<?php echo $classieraPostURL; ?>
			</span>
		</p>
		<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
			<?php echo $message; ?>
		</p>
	</div>
	<?php
	include(get_template_directory() . '/templates/email/email-footer.php');
	$emilbody = ob_get_contents();
	ob_end_clean();
	wp_mail($adminEmail, $email_subject, $emilbody);
}	
/*Report Ad to Admin*/	
/* Email Function End*/
?>