<?php 
	global $redux_demo;
	$classieraDisplayName = '';
	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;
	$classieraAuthorEmail = $current_user->user_email;
	$classieraDisplayName = $current_user->display_name;
	if(empty($classieraDisplayName)){
		$classieraDisplayName = $current_user->user_nicename;
	}
	if(empty($classieraDisplayName)){
		$classieraDisplayName = $current_user->user_login;
	}
	$classieraAuthorIMG = get_user_meta($user_ID, "classify_author_avatar_url", true);
	if(empty($classieraAuthorIMG)){
		$classieraAuthorIMG = classiera_get_avatar_url ($classieraAuthorEmail, $size = '150' );
	}	
	$classieraOnlineCheck = classiera_user_last_online($user_ID);
	$UserRegistered = $current_user->user_registered;
	$dateFormat = get_option( 'date_format' );
	$classieraRegDate = date_i18n($dateFormat,  strtotime($UserRegistered));
	$classieraProfile = $redux_demo['profile'];
	$classieraAllAds = $redux_demo['all-ads'];
	$classieraEditProfile = $redux_demo['edit'];
	$classieraPostAds = $redux_demo['new_post'];
	$classieraFollowerPage = $redux_demo['classiera_user_follow'];
	$classieraUserPlansPage = $redux_demo['classiera_single_user_plans'];
	$classieraUserFavourite = $redux_demo['all-favourite'];
	
?>
<aside id="sideBarAffix" class="section-bg-white affix-top">
	<div class="author-info border-bottom">
		<div class="media">
			<div class="media-left">
				<img class="media-object" src="<?php echo $classieraAuthorIMG; ?>" alt="<?php echo $classieraDisplayName;  ?>">
			</div><!--media-left-->
			<div class="media-body">
				<h5 class="media-heading text-uppercase"><?php echo $classieraDisplayName; ?></h5>
				<p><?php esc_html_e('Member Since', 'classiera') ?>&nbsp;<?php echo $classieraRegDate;?></p>
				<?php if($classieraOnlineCheck == false){?>
				<span class="offline"><i class="fa fa-circle"></i><?php esc_html_e('Offline', 'classiera') ?></span>
				<?php }else{ ?>
				<span><i class="fa fa-circle"></i><?php esc_html_e('Online', 'classiera') ?></span>
				<?php } ?>
			</div><!--media-body-->
		</div><!--media-->
	</div><!--author-info-->
	<ul class="user-page-list list-unstyled">
		<li class="<?php if(is_page_template( 'template-profile.php' )){echo "active";}?>">
			<a href="<?php echo $classieraProfile; ?>">
				<span>
					<i class="fa fa-user"></i>
					<?php esc_html_e("About Me", 'classiera') ?>
				</span>
			</a>
		</li><!--About-->
		<li class="<?php if(is_page_template( 'template-user-all-ads.php' )){echo "active";}?>">
			<a href="<?php echo $classieraAllAds; ?>">
				<span><i class="fa fa-suitcase"></i><?php esc_html_e("My Ads", 'classiera') ?></span>
				<span class="in-count pull-right flip"><?php echo count_user_posts($user_ID);?></span>
			</a>
		</li><!--My Ads-->
		<li class="<?php if(is_page_template( 'template-favorite.php' )){echo "active";}?>">
			<a href="<?php echo $classieraUserFavourite; ?>">
				<span><i class="fa fa-heart"></i><?php esc_html_e("Watch later Ads", 'classiera') ?></span>
				<span class="in-count pull-right flip">
					<?php 
						global $current_user;
						wp_get_current_user();
						$user_id = $current_user->ID;
						$myarray = classiera_authors_all_favorite($user_id);
						if(!empty($myarray)){
							$args = array(
							   'post_type' => 'post',
							   'post__in'      => $myarray
							);
						$wp_query = new WP_Query( $args );
						$current = -1;
						$current2 = 0;
						while ($wp_query->have_posts()) : $wp_query->the_post(); $current++; $current2++; 													
						endwhile;
						echo $current2;
						wp_reset_query();
						}else{
							echo "0";
						}
					?>
				</span>
			</a>
		</li><!--Watch later Ads-->
		<li class="<?php if(is_page_template( 'template-user-plans.php' )){echo "active";}?>">
			<a href="<?php echo $classieraUserPlansPage; ?>">
				<span><i class="fa fa-dollar"></i><?php esc_html_e("Packages", 'classiera') ?></span>
			</a>
		</li><!--Packeges-->
		<li class="<?php if(is_page_template( 'template-follow.php' )){echo "active";}?>">
			<a href="<?php echo $classieraFollowerPage; ?>">
				<span><i class="fa fa-users"></i><?php esc_html_e("Follower", 'classiera') ?></span>
			</a>
		</li><!--follower-->
		<li class="<?php if(is_page_template( 'template-edit-profile.php' )){echo "active";}?>">
			<a href="<?php echo $classieraEditProfile; ?>">
				<span><i class="fa fa-cog"></i><?php esc_html_e("Profile Settings", 'classiera') ?></span>
			</a>
		</li><!--Profile Setting-->
		<li>
			<a href="<?php echo wp_logout_url(get_option('siteurl')); ?>">
				<span><i class="fa fa-sign-out"></i><?php esc_html_e("Logout", 'classiera') ?></span>
			</a>
		</li><!--Logout-->
	</ul><!--user-page-list-->
	<div class="user-submit-ad">
		<a href="<?php echo $classieraPostAds; ?>" class="btn btn-primary sharp btn-block btn-sm btn-user-submit-ad">
			<i class="icon-left fa fa-plus-circle"></i>
			<?php esc_html_e("POST NEW AD", 'classiera') ?>
		</a>
	</div><!--user-submit-ad-->
</aside><!--sideBarAffix-->