<?php 
	require get_template_directory() . '/templates/plans/planshelper.php';
	global $redux_demo;
	$plans_Title = $redux_demo['plans-title'];
	$plans_desc = $redux_demo['plans-desc'];
	$classieraCartURL = $redux_demo['classiera_cart_url'];
	$classiera_plans_bg = $redux_demo['classiera_plans_bg'];
	$login = $redux_demo['login'];
	$current_user = wp_get_current_user();
	$user_ID = $current_user->ID;	
?>
<section class="pricing-plan section-pad section-light-bg section-bg-light-img">
	<div class="section-heading-v1">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 center-block">
                    <h3 class="text-uppercase"><?php echo $plans_Title; ?></h3>
                    <p><?php echo $plans_desc; ?></p>
                </div><!--col-lg-8-->
            </div><!--row-->
        </div><!--container-->
    </div><!--section-heading-v1-->
	<div class="pricing-plan-content">
		<div class="container">
			<div class="row no-gutter">
				<?php
					global $redux_demo;
					$classieraPlansType = "";
					global $paged, $wp_query, $wp;
					$args = wp_parse_args($wp->matched_query);
					$temp = $wp_query;
					$wp_query= null;
					$wp_query = new WP_Query();
					$wp_query->query('post_type=price_plan&posts_per_page=-1');
					$current = -1;
					$current2 = 0;
				while ($wp_query->have_posts()) : $wp_query->the_post(); $current++; $current2++;
				$popular_plan = get_post_meta($post->ID, 'popular_plan', true);
				$free_plans = get_post_meta($post->ID, 'free_plans', true);
				$wooID = get_post_meta($post->ID, 'woo_id', true);
				$post_price = get_post_meta($post->ID, 'plan_price', true);
				$plan_text = get_post_meta($post->ID, 'plan_text', true);
				$plan_days = get_post_meta($post->ID, 'plan_time', true);
				$planFeaturedTXT = get_post_meta($post->ID, 'plan_free_text', true);
				$planSecureTXT = get_post_meta($post->ID, 'plan_secure_text', true);
				$plan_ads = get_post_meta($post->ID, 'featured_ads', true);
				if($free_plans == 1){
					$classieraPlansType =  esc_html__( 'Free', 'classiera' );
				}else{
					$classieraPlansType =  get_the_title();
				}
				$redirect = classiera_Plans_URL($free_plans);
				//echo $popular_plan."shabir";
				?>
				<div class="col-lg-3 col-md-3 col-sm-6 match-height price-plan">
					<div class="pricing-plan-box border <?php if($popular_plan == 'true'){echo "popular";} ?>">
						<?php if($popular_plan == 'true'){
							?>
							<div class="featured-tag">
								<span class="left-corner"></span>
								<span class="right-corner"></span>
								<div class="featured">
									<p><?php esc_html_e('Popular', 'classiera') ?></p>
								</div>
							</div>
							<?php
						}?>
						<div class="pricing-plan-heading">
							<h4><?php echo $classieraPlansType; ?></h4>
							<p>
							<?php esc_html_e('For', 'classiera') ?>
							<?php echo $plan_days; ?>
							<?php esc_html_e('Day Only', 'classiera') ?></p>
						</div><!--pricing-plan-heading-->
						<div class="pricing-plan-price">
							<h1>
								<?php 
									if($free_plans == 1){
										echo classiera_currency_sign()."0.00";										
									}else{
										echo classiera_currency_sign().$post_price;
									}
								?>
							</h1>
						</div>
						<div class="pricing-plan-text">
							<ul>
                                <li><?php echo $planFeaturedTXT; ?></li>
                                <li>
									<?php echo $plan_ads ?>&nbsp;
									<?php esc_html_e( 'Featured ads availability', 'classiera' ); ?>
								</li>
                                <li>
									<?php esc_html_e( 'For', 'classiera' ); ?>&nbsp;
									<?php echo $plan_days ?>&nbsp;
									<?php esc_html_e( 'days', 'classiera' ); ?>
								</li>
                                <li><?php echo $planSecureTXT; ?></li>
                            </ul>
						</div><!--pricing-plan-text-->
						<!--FormSection-->
						<form method="post" class="planForm">
							<input type="hidden" name="AMT" value="<?php echo $post_price; ?>" />
							<input type="hidden" name="id" value="<?php echo $wooID; ?>" />
							<input type="hidden" name="CURRENCYCODE" value="<?php echo classiera_currency_sign(); ?>">
							<input type="hidden" name="user_ID" value="<?php echo $user_ID; ?>">
							<input type="hidden" name="plan_name" value="<?php the_title(); ?>">
							<?php $plan_ads = get_post_meta($post->ID, 'featured_ads', true); ?>
							<input type="hidden" name="plan_ads" value="<?php echo $plan_ads; ?>">
							<?php $plan_time = get_post_meta($post->ID, 'plan_time', true); ?>
							<input type="hidden" name="plan_time" value="<?php echo $plan_time; ?>">
							<div class="pricing-plan-button">
							<?php 
							if($free_plans == 1){
								$link = classiera_Plans_URL();
								?>
							<a class="btn btn-primary sharp btn-sm btn-style-one" href="<?php echo $link; ?>">
								<?php esc_html_e( 'Post Ad', 'classiera' ); ?>
							</a>	
								<?php
							}else{
								if (is_user_logged_in()){
								?>
							<a rel="nofollow" href="#" data-quantity="1" data-product_id="<?php echo $wooID; ?>" data-product_sku="" class="btn btn-primary sharp btn-sm btn-style-one button product_type_simple add_to_cart_button ajax_add_to_cart">
							<?php esc_html_e( 'Purchase Now', 'classiera' ); ?>
							</a>
								<?php
								}else{
									?>
									<a rel="nofollow" href="<?php echo $login; ?>" class="btn btn-primary sharp btn-sm btn-style-one button">
									<?php esc_html_e( 'Purchase Now', 'classiera' ); ?>
									</a>
									<?php
								}
							}
							?>
							</div>							
						</form>
						<div class="viewcart">
							<a class="btn btn-primary sharp btn-sm btn-style-one" href="<?php echo $classieraCartURL; ?>">
							<?php esc_html_e( 'View Cart', 'classiera' ); ?>
							</a>
						</div>
						<!--FormSection-->
					</div><!--pricing-plan-box-->
				</div><!--col-lg-3-->
				<?php endwhile; ?>
				<?php $wp_query = null; $wp_query = $temp;?>
			</div><!--row no-gutter-->
		</div><!--container-->
	</div><!--pricing-plan-content-->
</section>