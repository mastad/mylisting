<?php
/**
 * Template name: Pricing Plans
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */



$successMsg = '';

get_header(); ?>

<?php 
	global $redux_demo;
	$classieraSearchStyle = $redux_demo['classiera_search_style'];
	$classieraPremiumStyle = $redux_demo['classiera_premium_style'];
	$classieraPartnersStyle = $redux_demo['classiera_partners_style'];
	$classiera_cat_style = $redux_demo['classiera_cat_style'];
	$classieraCartURL = $redux_demo['classiera_cart_url'];
	$classieraPremiumSlider = $redux_demo['featured-options-on'];
	$login = $redux_demo['login'];
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	$page_slider = get_post_meta($current_page_id, 'page_slider', true);
	$page_custom_title = get_post_meta($current_page_id, 'page_custom_title', true);
	$plans_Title = $redux_demo['plans-title'];
	$plans_desc = $redux_demo['plans-desc'];
	$current_user = wp_get_current_user();
	$user_ID = $current_user->ID;
?>
<?php 
	//Search Styles//
	if($classieraSearchStyle == 1){
		get_template_part( 'templates/searchbar/searchstyle1' );
	}elseif($classieraSearchStyle == 2){
		get_template_part( 'templates/searchbar/searchstyle2' );
	}elseif($classieraSearchStyle == 3){
		get_template_part( 'templates/searchbar/searchstyle3' );
	}elseif($classieraSearchStyle == 4){
		get_template_part( 'templates/searchbar/searchstyle4' );
	}elseif($classieraSearchStyle == 5){
		get_template_part( 'templates/searchbar/searchstyle5' );
	}elseif($classieraSearchStyle == 6){
		get_template_part( 'templates/searchbar/searchstyle6' );
	}elseif($classieraSearchStyle == 7){
		get_template_part( 'templates/searchbar/searchstyle7' );
	}
?>
<?php 
	//Premium Styles//
if($classieraPremiumSlider == 1){	
	if($classieraPremiumStyle == 1){
		get_template_part( 'templates/premium/premiumv1' );
	}elseif($classieraPremiumStyle == 2){
		get_template_part( 'templates/premium/premiumv2' );
	}elseif($classieraPremiumStyle == 3){
		get_template_part( 'templates/premium/premiumv3' );
	}elseif($classieraPremiumStyle == 4){
		get_template_part( 'templates/premium/premiumv4' );
	}elseif($classieraPremiumStyle == 5){
		get_template_part( 'templates/premium/premiumv5' );
	}elseif($classieraPremiumStyle == 6){
		get_template_part( 'templates/premium/premiumv6' );
	}
}	
?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php $contentEmpty = get_the_content();?>
<?php if(!empty($contentEmpty)){?>
<section class="inner-page-content border-bottom pricingContent">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<article class="article-content pageContent">
					<?php the_content(); ?>
				</article>
			</div>
		</div>
	</div>
</section>
<?php } ?>
<?php endwhile; endif; ?>

<?php if($classiera_cat_style == 1){?>
<section class="pricing-plan section-pad section-light-bg section-bg-light-img">
	<div class="section-heading-v1">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 center-block">
                    <h3 class="text-uppercase"><?php echo $plans_Title; ?></h3>
                    <p><?php echo $plans_desc; ?></p>
                </div>
            </div>
        </div>
    </div><!--heading-->
	<div class="pricing-plan-content">
		<div class="container">
			<div class="row no-gutter">
				<?php 
					global $paged, $wp_query, $wp;
					$args = wp_parse_args($wp->matched_query);
					$temp = $wp_query;
					$wp_query= null;
					$wp_query = new WP_Query();
					$wp_query->query('post_type=price_plan&posts_per_page=-1');
					$current = -1;
					$current2 = 0;
					require get_template_directory() . '/templates/plans/planshelper.php';
				?>
				<?php while ($wp_query->have_posts()) : $wp_query->the_post(); $current++; $current2++; ?>
				<?php 
				$popular_plan = get_post_meta($post->ID, 'popular_plan', true);
				$wooID = get_post_meta($post->ID, 'woo_id', true);
				$free_plans = get_post_meta($post->ID, 'free_plans', true);
				$post_price = get_post_meta($post->ID, 'plan_price', true);
				$plan_text = get_post_meta($post->ID, 'plan_text', true);
				$plan_days = get_post_meta($post->ID, 'plan_time', true);
				$planFeaturedTXT = get_post_meta($post->ID, 'plan_free_text', true);
				$planSecureTXT = get_post_meta($post->ID, 'plan_secure_text', true);
				$plan_ads = get_post_meta($post->ID, 'featured_ads', true);
				if($free_plans == 1){
					$classieraPlansType =  esc_html__( 'Free', 'classiera' );
				}else{
					$classieraPlansType =  esc_html__( 'Featured', 'classiera' );
				}				
				?>
				<div class="col-lg-3 col-md-3 col-sm-6 price-plan match-height">
					<div class="pricing-plan-box border <?php if($popular_plan == 'true'){echo "popular";} ?>">
					<?php if($popular_plan == 'true'){ ?>
						<div class="featured-tag">
							<span class="left-corner"></span>
							<span class="right-corner"></span>
							<div class="featured">
								<p><?php esc_html_e('Popular', 'classiera') ?></p>
							</div>
						</div>
					<?php } ?>
						<div class="pricing-plan-heading">
							<h4><?php the_title(); ?></h4>
							<p>
							<?php esc_html_e('For', 'classiera') ?>
							<?php echo $plan_days; ?>
							<?php esc_html_e('Day Only', 'classiera') ?>
							</p>
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
						</div><!--pricing-plan-price-->
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
					</div>	
				</div>
				<?php endwhile; ?>
				<?php $wp_query = null; $wp_query = $temp;?>
			</div>
		</div><!--container-->
	</div><!--pricing-plan-content-->
</section>
<?php 
	}elseif($classiera_cat_style == 2){
		get_template_part('templates/plans/plansv2');
	}elseif($classiera_cat_style == 3){ 
		get_template_part('templates/plans/plansv3');
	}elseif($classiera_cat_style == 4){
		get_template_part('templates/plans/plansv4');
	}elseif($classiera_cat_style == 5){ 
		get_template_part('templates/plans/plansv5');
	}elseif($classiera_cat_style == 6){ 
		get_template_part('templates/plans/plansv6');
	}elseif($classiera_cat_style == 7){ 
		get_template_part('templates/plans/plansv7');
	}

?>
<!-- Company Section Start-->
<?php 
	global $redux_demo; 
	$classieraCompany = $redux_demo['partners-on'];
	$classieraPartnersStyle = $redux_demo['classiera_partners_style'];
	if($classieraCompany == 1){
		if($classieraPartnersStyle == 1){
			get_template_part('templates/members/memberv1');
		}elseif($classieraPartnersStyle == 2){
			get_template_part('templates/members/memberv2');
		}elseif($classieraPartnersStyle == 3){
			get_template_part('templates/members/memberv3');
		}elseif($classieraPartnersStyle == 4){
			get_template_part('templates/members/memberv4');
		}elseif($classieraPartnersStyle == 5){
			get_template_part('templates/members/memberv5');
		}elseif($classieraPartnersStyle == 6){
			get_template_part('templates/members/memberv6');
		}
	}
?>
<?php get_footer(); ?>