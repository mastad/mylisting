<?php 
	global $redux_demo;
	$premiumSECtitle = $redux_demo['premium-sec-title'];
	$premiumSECdesc = $redux_demo['premium-sec-desc'];	
	$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
	$featuredCatOn = $redux_demo['featured-caton'];
	$classieraFeaturedCategories = $redux_demo['featured-ads-cat'];
	$classieraPremiumAdsCount = $redux_demo['premium-ads-counter'];
	$category_icon_code = "";
	$category_icon_color = "";
	$catIcon = "";
	$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
?>
<section class="classiera-premium-ads-v6 border-bottom section-pad">
	<div class="section-heading-v6">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 center-block">
                    <h3 class="text-capitalize"><?php echo $premiumSECtitle; ?></h3>
                    <p><?php echo $premiumSECdesc; ?></p>
                </div>
            </div>
        </div>
    </div>
	<div style="overflow: hidden;">
		<div style="margin-bottom: 40px;">			
			<div id="owl-demo" class="owl-carousel premium-carousel-v6" data-car-length="4" data-items="4" data-loop="true" data-nav="false" data-autoplay="true" data-autoplay-timeout="3000" data-dots="false" data-auto-width="false" data-auto-height="true" data-right="<?php if(is_rtl()){echo "true";}else{ echo "false";}?>" data-responsive-small="1" data-autoplay-hover="true" data-responsive-medium="2" data-responsive-large="4" data-responsive-xlarge="6" data-margin="15">
				<?php 
				$cat_id = get_cat_ID(single_cat_title('', false)); 
				global $paged, $wp_query, $wp;
				$args = wp_parse_args($wp->matched_query);
				$temp = $wp_query;
				$wp_query= null;
				if($featuredCatOn == 1){						
					$arags = array(
						'post_type' => 'post',
						'posts_per_page' => $classieraPremiumAdsCount,
						'cat' => $classieraFeaturedCategories,
					);
				}else{
					$arags = array(
						'post_type' => 'post',
						'posts_per_page' => $classieraPremiumAdsCount,
						'meta_query' => array(
						array(
							'key' => 'featured_post',
							'value' => '1',
							'compare' => '=='
							)
						),
					);
				}
				$wp_query = new WP_Query($arags);
				$current = -1;
				while ($wp_query->have_posts()) : $wp_query->the_post();
					$featuredMeta = get_post_meta($post->ID, 'featured_post', true);
					if($featuredCatOn == 1){
						$featured_post = "1";
					}else{
						$featured_post = "0";
					}
					$post_price_plan_activation_date = get_post_meta($post->ID, 'post_price_plan_activation_date', true);
					$post_price_plan_expiration_date = get_post_meta($post->ID, 'post_price_plan_expiration_date', true);
					$post_price_plan_expiration_date_noarmal = get_post_meta($post->ID, 'post_price_plan_expiration_date_normal', true);
					$todayDate = strtotime(date('m/d/Y h:i:s'));
					$expireDate = $post_price_plan_expiration_date;
					if(!empty($post_price_plan_activation_date) && $featuredMeta == 1) {
						if(($todayDate < $expireDate) or $post_price_plan_expiration_date == 0) {
							$featured_post = "1";
						}
					}elseif($featuredMeta == 1){
						$featured_post = "1";
					}
					//$featured_post = "1";
					if($featured_post == "1") {
						$current++;
				?>
				<?php 
					$category = get_the_category();
					$catID = $category[0]->cat_ID;
					if ($category[0]->category_parent == 0) {
						$tag = $category[0]->cat_ID;
						$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
						if (isset($tag_extra_fields[$tag])) {
							$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
							$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
							$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
						}
					}elseif($category[1]->category_parent == 0){
						$tag = $category[0]->category_parent;
						$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
						if (isset($tag_extra_fields[$tag])) {
							$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
							$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
							$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
						}
					}else{
						$tag = $category[1]->category_parent;
						$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
						if (isset($tag_extra_fields[$tag])) {
							$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
							$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
							$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
						}
					}
					if(!empty($category_icon_code)) {
						$catIcon = stripslashes($category_icon_code);
					}
					$postCatgory = get_the_category( $post->ID );
					$categoryLink = get_category_link($catID);
					$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
					$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
					if(!empty($post_currency_tag)){
						$classieraCurrencyTag = classiera_Display_currency_sign($post_currency_tag);
					}else{
						global $redux_demo;
						$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
					}
					/*PostMultiCurrencycheck*/
				?>
				<div class="classiera-box-div-v7 item match-height">
					<figure>
						<div class="premium-img">
							<div class="featured">
								<p><?php esc_html_e( 'Featured', 'classiera' ); ?></p>
							</div><!--featured-tag-->
							<?php 
								if(has_post_thumbnail()){
									$classieraIMGURL = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
									$thumb_id = get_post_thumbnail_id($post->id);
									$classieraALT = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
									?>
								<img class="img-responsive" src="<?php echo $classieraIMGURL[0]; ?>" alt="<?php echo $classieraALT;  ?>">	
							<?php
								}else{
									$classieraDafult = get_template_directory_uri() . '/images/nothumb.png';
									?>
									<img class="img-responsive" src="<?php echo $classieraDafult; ?>" alt="<?php echo get_the_title(); ?>">
									<?php
								}
							?>							
						</div><!--premium-img-->
						<figcaption>
							<div class="caption-tags">
								<?php $post_price = get_post_meta($post->ID, 'post_price', true);?>
								<?php if(!empty($post_price)){?>
                                <span class="price btn btn-primary round btn-style-six active">
									<?php if(is_numeric($post_price)){?>
										<?php echo $classieraCurrencyTag.$post_price; ?>
									<?php }else{ ?>
										<?php echo $post_price; ?>
									<?php } ?>
								</span>
								<?php } ?>
								<?php $classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true); ?>
								<?php if(!empty($classiera_ads_type)){?>
                                <span class="buy-sale-tag btn btn-primary round btn-style-six active">
									<?php classiera_buy_sell($classiera_ads_type); ?>
								</span>
								<?php } ?>
                            </div>
							<div class="content">
								<h5><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h5>
								<div class="category">
									<span><?php esc_html_e( 'Category', 'classiera' ); ?> : 
										<a href="<?php echo $categoryLink; ?>"><?php echo $postCatgory[0]->name; ?></a>
									</span>
								</div>
								<div class="description">
									<p><?php echo substr(get_the_excerpt(), 0,260); ?></p>
								</div>
								<a href="<?php the_permalink(); ?>"><?php esc_html_e( 'view ad', 'classiera' ); ?> <i class="fa fa-long-arrow-right"></i></a>
							</div>
						</figcaption>
					</figure>
				</div>
				<?php } ?>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
			</div>
		</div>
		<div class="navText">
			<a class="prev btn btn-primary radius outline btn-style-six">
				<i class="icon-left fa fa-long-arrow-left"></i>
				<?php esc_html_e( 'Previous', 'classiera' ); ?>
			</a>
            <a class="next btn btn-primary radius outline btn-style-six">
				<?php esc_html_e( 'Next', 'classiera' ); ?>
				<i class="icon-right fa fa-long-arrow-right"></i>
			</a>
		</div>
	</div>
</section>