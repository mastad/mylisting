<?php 
global $redux_demo;
$locShownBy = $redux_demo['location-shown-by'];	
$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
$classieraFeaturedAdsCounter = $redux_demo['classiera_featured_ads_count'];
$classiera_pagination = $redux_demo['classiera_pagination'];
$classieraAdsView = $redux_demo['home-ads-view'];
$classieraItemClass = "item-grid";
if($classieraAdsView == 'list'){
	$classieraItemClass = "item-list";
}
?>
<section class="classiera-advertisement advertisement-v5 section-pad-80 border-bottom">
	<div class="tab-divs">
		<div class="view-head">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-sm-7 col-xs-8">
                        <div class="tab-button">
                            <ul class="nav nav-tabs" role="tablist">								
                                <li role="presentation" class="active">
									<a href="#all" aria-controls="all" role="tab" data-toggle="tab">
										<?php esc_html_e( 'All Ads', 'classiera' ); ?>
										<span class="arrow-down"></span>
									</a>
                                </li>
                                <li role="presentation">                                    
									<a href="#random" aria-controls="random" role="tab" data-toggle="tab">
										<?php esc_html_e( 'Random Ads', 'classiera' ); ?>
										<span class="arrow-down"></span>
									</a>
                                </li>
                                <li role="presentation">                                   
									<a href="#popular" aria-controls="popular" role="tab" data-toggle="tab">
										<?php esc_html_e( 'Popular Ads', 'classiera' ); ?>
										<span class="arrow-down"></span>
									</a>
                                </li>
                            </ul><!--nav nav-tabs-->
                        </div><!--tab-button-->
                    </div><!--col-lg-6 col-sm-8-->
					<div class="col-lg-6 col-sm-5 col-xs-4">
						<div class="view-as text-right flip">
							<a id="grid" class="grid <?php if($classieraAdsView == 'grid'){ echo "active"; }?>" href="#"><i class="fa fa-th"></i></a>
							<a id="list" class="list <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#"><i class="fa fa-th-list"></i></a>							
                        </div><!--view-as tab-button-->
					</div><!--col-lg-6 col-sm-4 col-xs-12-->
				</div><!--row-->
			</div><!--container-->
		</div><!--view-head-->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane fade in active" id="all">
				<div class="container">
					<div class="row">
						<!--FeaturedPosts-->
						<?php 
							global $paged, $wp_query, $wp;
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ) {
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}
							//$cat_id = get_cat_ID(single_cat_title('', false));
							$cat_id = get_queried_object_id();
							$temp = $wp_query;
							$featuredPosts = array();
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => $classieraFeaturedAdsCounter,
								'paged' => $paged,								
								'cat' => $cat_id,
								'meta_query' => array(
								array(
									'key' => 'featured_post',
									'value' => '1',
									'compare' => '=='
									)
								),
							);
							$wp_query= null;
							$wp_query = new WP_Query($args);							
							$current = -1;
							$current2 = 0;
							while ($wp_query->have_posts()) : $wp_query->the_post(); $current++; $current2++;
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
								$category_icon = stripslashes($category_icon_code);
							}							
							$post_price = get_post_meta($post->ID, 'post_price', true);
							$theTitle = get_the_title();
							$postCatgory = get_the_category( $post->ID );
							//print_r($category);
							$categoryLink = get_category_link($catID);
							$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
							/*PostMultiCurrencycheck*/
							$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
							if(!empty($post_currency_tag)){
								$classieraCurrencyTag = classiera_Display_currency_sign($post_currency_tag);
							}else{
								global $redux_demo;
								$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
							}
							/*PostMultiCurrencycheck*/
							$featuredPosts[] = $post->ID;
						?>
						<div class="col-lg-4 col-md-4 col-sm-6 match-height item <?php echo $classieraItemClass; ?>">
							<div class="classiera-box-div classiera-box-div-v5">
								<figure class="clearfix">
									<div class="premium-img">
									<?php 
										$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
										if($classieraFeaturedPost == 1){
											?>
											<div class="featured-tag">
												<span class="left-corner"></span>
												<span class="right-corner"></span>
												<div class="featured">
													<p><?php esc_html_e( 'Featured', 'classiera' ); ?></p>
												</div>
											</div>
											<?php
										}
										?>
										<?php
										if( has_post_thumbnail()){
											$imageurl = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
											$thumb_id = get_post_thumbnail_id($post->id);
											?>
											<img class="img-responsive" src="<?php echo $imageurl[0]; ?>" alt="<?php echo $theTitle; ?>">
											<?php
										}else{
											?>
											<img class="img-responsive" src="<?php echo get_template_directory_uri() . '/images/nothumb.png' ?>" alt="No Thumb"/>
											<?php
										}
									?>
										<span class="hover-posts">											
											<a href="<?php the_permalink(); ?>"><?php esc_html_e('View Ad', 'classiera'); ?></a>
										</span>
										<?php if(!empty($post_price)){?>
											<span class="price">
												<?php esc_html_e('Price', 'classiera'); ?> : 
												<?php if(is_numeric($post_price)){?>
													<?php echo $classieraCurrencyTag.$post_price; ?>
												<?php }else{ ?>
													<?php echo $post_price; ?>
												<?php } ?>
											</span>
										<?php } ?>
										<?php if(!empty($classiera_ads_type)){?>
										<span class="classiera-buy-sel">
											<?php classiera_buy_sell($classiera_ads_type); ?>
										</span>
										<?php } ?>
									</div><!--premium-img-->
									<div class="detail text-center">
										<?php if(!empty($post_price)){?>
										<span class="price">
											<?php esc_html_e('Price', 'classiera'); ?> : 
											<?php if(is_numeric($post_price)){?>
												<?php echo $classieraCurrencyTag.$post_price; ?>
											<?php }else{ ?>
												<?php echo $post_price; ?>
											<?php } ?>
										</span>
										<?php } ?>
										<div class="box-icon">
											<a href="mailto:<?php echo $classieraAuthorEmail ?>?subject"><i class="fa fa-envelope"></i></a>
											<?php if(!empty($post_phone)){?>
                                            <a href="tel:<?php echo $post_phone; ?>"><i class="fa fa-phone"></i></a>
											<?php } ?>
										</div>
										<a href="<?php the_permalink(); ?>" class="btn btn-primary outline btn-style-five"><?php esc_html_e('View Ad', 'classiera'); ?></a>
									</div><!--detail text-center-->
									<figcaption>
										<?php if(!empty($post_price)){?>
										<span class="price visible-xs">
										<?php esc_html_e('Price', 'classiera'); ?> : 
											<?php if(is_numeric($post_price)){?>
												<?php echo $classieraCurrencyTag.$post_price; ?>
											<?php }else{ ?>
												<?php echo $post_price; ?>
											<?php } ?>
										</span>
										<?php } ?>
										<h5><a href="<?php the_permalink(); ?>"><?php echo $theTitle; ?></a></h5>
										<div class="category">
											<span><?php esc_html_e('Category', 'classiera'); ?> : <a href="<?php echo $categoryLink; ?>"><?php echo $postCatgory[0]->name; ?></a>
											</span>
											<?php $classieraLOC = get_post_meta( $post->ID, $locShownBy, true );?>
											<span><?php esc_html_e('Location', 'classiera'); ?> : 
												<a href="#"><?php echo $classieraLOC; ?></a>
											</span>
										</div>
										<p class="description"><?php echo substr(get_the_excerpt(), 0,260); ?></p>
									</figcaption>
								</figure>
							</div><!--row-->
						</div><!--col-lg-4-->
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
						<?php wp_reset_query(); ?>
						<!--FeaturedPosts-->
						<?php 
							global $paged, $wp_query, $wp;
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ) {
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}
							//$cat_id = get_cat_ID(single_cat_title('', false));
							$cat_id = get_queried_object_id();
							$temp = $wp_query;
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => 12,
								'paged' => $paged,
								'post__not_in' => $featuredPosts,
								'cat' => $cat_id,
							);
							$wp_query= null;
							$wp_query = new WP_Query($args);							
							$current = -1;
							$current2 = 0;
							while ($wp_query->have_posts()) : $wp_query->the_post(); $current++; $current2++;
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
								$category_icon = stripslashes($category_icon_code);
							}							
							$post_price = get_post_meta($post->ID, 'post_price', true);
							$theTitle = get_the_title();
							$postCatgory = get_the_category( $post->ID );
							//print_r($category);
							$categoryLink = get_category_link($catID);
							$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
							/*PostMultiCurrencycheck*/
							$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
							if(!empty($post_currency_tag)){
								$classieraCurrencyTag = classiera_Display_currency_sign($post_currency_tag);
							}else{
								global $redux_demo;
								$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
							}
							/*PostMultiCurrencycheck*/
						?>
						<div class="col-lg-4 col-md-4 col-sm-6 match-height item <?php echo $classieraItemClass; ?>">
							<div class="classiera-box-div classiera-box-div-v5">
								<figure class="clearfix">
									<div class="premium-img">
									<?php 
										$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
										if($classieraFeaturedPost == 1){
											?>
											<div class="featured-tag">
												<span class="left-corner"></span>
												<span class="right-corner"></span>
												<div class="featured">
													<p><?php esc_html_e( 'Featured', 'classiera' ); ?></p>
												</div>
											</div>
											<?php
										}
										?>
										<?php
										if( has_post_thumbnail()){
											$imageurl = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
											$thumb_id = get_post_thumbnail_id($post->id);
											?>
											<img class="img-responsive" src="<?php echo $imageurl[0]; ?>" alt="<?php echo $theTitle; ?>">
											<?php
										}else{
											?>
											<img class="img-responsive" src="<?php echo get_template_directory_uri() . '/images/nothumb.png' ?>" alt="No Thumb"/>
											<?php
										}
									?>
										<span class="hover-posts">											
											<a href="<?php the_permalink(); ?>"><?php esc_html_e('View Ad', 'classiera'); ?></a>
										</span>
										<?php if(!empty($post_price)){?>
											<span class="price">
												<?php esc_html_e('Price', 'classiera'); ?> : 
												<?php if(is_numeric($post_price)){?>
													<?php echo $classieraCurrencyTag.$post_price; ?>
												<?php }else{ ?>
													<?php echo $post_price; ?>
												<?php } ?>
											</span>
										<?php } ?>
										<?php if(!empty($classiera_ads_type)){?>
										<span class="classiera-buy-sel">
											<?php classiera_buy_sell($classiera_ads_type); ?>
										</span>
										<?php } ?>
									</div><!--premium-img-->
									<div class="detail text-center">
										<?php if(!empty($post_price)){?>
										<span class="price">
											<?php esc_html_e('Price', 'classiera'); ?> : 
											<?php if(is_numeric($post_price)){?>
												<?php echo $classieraCurrencyTag.$post_price; ?>
											<?php }else{ ?>
												<?php echo $post_price; ?>
											<?php } ?>
										</span>
										<?php } ?>
										<div class="box-icon">
											<a href="mailto:<?php echo $classieraAuthorEmail ?>?subject"><i class="fa fa-envelope"></i></a>
											<?php if(!empty($post_phone)){?>
                                            <a href="tel:<?php echo $post_phone; ?>"><i class="fa fa-phone"></i></a>
											<?php } ?>
										</div>
										<a href="<?php the_permalink(); ?>" class="btn btn-primary outline btn-style-five"><?php esc_html_e('View Ad', 'classiera'); ?></a>
									</div><!--detail text-center-->
									<figcaption>
										<?php if(!empty($post_price)){?>
										<span class="price visible-xs">
										<?php esc_html_e('Price', 'classiera'); ?> : 
											<?php if(is_numeric($post_price)){?>
												<?php echo $classieraCurrencyTag.$post_price; ?>
											<?php }else{ ?>
												<?php echo $post_price; ?>
											<?php } ?>
										</span>
										<?php } ?>
										<h5><a href="<?php the_permalink(); ?>"><?php echo $theTitle; ?></a></h5>
										<div class="category">
											<span><?php esc_html_e('Category', 'classiera'); ?> : <a href="<?php echo $categoryLink; ?>"><?php echo $postCatgory[0]->name; ?></a>
											</span>
											<?php $classieraLOC = get_post_meta( $post->ID, $locShownBy, true );?>
											<span><?php esc_html_e('Location', 'classiera'); ?> : 
												<a href="#"><?php echo $classieraLOC; ?></a>
											</span>
										</div>
										<p class="description"><?php echo substr(get_the_excerpt(), 0,260); ?></p>
									</figcaption>
								</figure>
							</div><!--row-->
						</div><!--col-lg-4-->
						<?php endwhile; ?>
					</div><!--row-->
					<?php
						if($classiera_pagination == 'pagination'){
							classiera_pagination();
						}
					?>
				</div><!--container-->
				<?php
					if($classiera_pagination == 'infinite'){
						echo infinite($wp_query);
					}
				?>
				<?php wp_reset_query(); ?>
			</div><!--tabpanel all-->
			<div role="tabpanel" class="tab-pane fade" id="random">
				<div class="container">
					<div class="row">
						<?php 
						global $paged, $wp_query, $wp;
						$args = wp_parse_args($wp->matched_query);
						if ( !empty ( $args['paged'] ) && 0 == $paged ) {
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}
						//$cat_id = get_cat_ID(single_cat_title('', false));
						$cat_id = get_queried_object_id();
						$current = -1;
						$current2 = 0;
						$popularpost = new WP_Query( array( 'posts_per_page' => '12', 'cat' => $cat_id, 'posts_type' => 'post', 'paged' => $paged, 'post_status' => 'publish', 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC'  ) );
						while ( $popularpost->have_posts() ) : $popularpost->the_post(); $current++; $current2++;
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
							if(!empty($category_icon_code)){
								$category_icon = stripslashes($category_icon_code);
							}							
							$post_price = get_post_meta($post->ID, 'post_price', true);
							$theTitle = get_the_title();
							$postCatgory = get_the_category( $post->ID );
							//print_r($category);
							$categoryLink = get_category_link($catID);
							$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
							/*PostMultiCurrencycheck*/
							$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
							if(!empty($post_currency_tag)){
								$classieraCurrencyTag = classiera_Display_currency_sign($post_currency_tag);
							}else{
								global $redux_demo;
								$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
							}
							/*PostMultiCurrencycheck*/
						?>
						<div class="col-lg-4 col-md-4 col-sm-6 match-height item <?php echo $classieraItemClass; ?>">
							<div class="classiera-box-div classiera-box-div-v5">
								<figure class="clearfix">
									<div class="premium-img">
									<?php 
										$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
										if($classieraFeaturedPost == 1){
											?>
											<div class="featured-tag">
												<span class="left-corner"></span>
												<span class="right-corner"></span>
												<div class="featured">
													<p><?php esc_html_e( 'Featured', 'classiera' ); ?></p>
												</div>
											</div>
											<?php
										}
										?>
										<?php
										if( has_post_thumbnail()){
											$imageurl = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
											$thumb_id = get_post_thumbnail_id($post->id);
											?>
											<img class="img-responsive" src="<?php echo $imageurl[0]; ?>" alt="<?php echo $theTitle; ?>">
											<?php
										}else{
											?>
											<img class="img-responsive" src="<?php echo get_template_directory_uri() . '/images/nothumb.png' ?>" alt="No Thumb"/>
											<?php
										}
									?>
										<span class="hover-posts">											
											<a href="<?php the_permalink(); ?>"><?php esc_html_e('View Ad', 'classiera'); ?></a>
										</span>
										<?php if(!empty($post_price)){?>
											<span class="price">
												<?php esc_html_e('Price', 'classiera'); ?> : 
												<?php if(is_numeric($post_price)){?>
													<?php echo $classieraCurrencyTag.$post_price; ?>
												<?php }else{ ?>
													<?php echo $post_price; ?>
												<?php } ?>
											</span>
										<?php } ?>
										<?php if(!empty($classiera_ads_type)){?>
										<span class="classiera-buy-sel">
											<?php classiera_buy_sell($classiera_ads_type); ?>
										</span>
										<?php } ?>
									</div><!--premium-img-->
									<div class="detail text-center">
										<?php if(!empty($post_price)){?>
										<span class="price">
											<?php esc_html_e('Price', 'classiera'); ?> : 
											<?php if(is_numeric($post_price)){?>
												<?php echo $classieraCurrencyTag.$post_price; ?>
											<?php }else{ ?>
												<?php echo $post_price; ?>
											<?php } ?>
										</span>
										<?php } ?>
										<div class="box-icon">
											<a href="mailto:<?php echo $classieraAuthorEmail ?>?subject"><i class="fa fa-envelope"></i></a>
											<?php if(!empty($post_phone)){?>
                                            <a href="tel:<?php echo $post_phone; ?>"><i class="fa fa-phone"></i></a>
											<?php } ?>
										</div>
										<a href="<?php the_permalink(); ?>" class="btn btn-primary outline btn-style-five"><?php esc_html_e('View Ad', 'classiera'); ?></a>
									</div><!--detail text-center-->
									<figcaption>
										<?php if(!empty($post_price)){?>
										<span class="price visible-xs">
										<?php esc_html_e('Price', 'classiera'); ?> : 
											<?php if(is_numeric($post_price)){?>
												<?php echo $classieraCurrencyTag.$post_price; ?>
											<?php }else{ ?>
												<?php echo $post_price; ?>
											<?php } ?>
										</span>
										<?php } ?>
										<h5><a href="<?php the_permalink(); ?>"><?php echo $theTitle; ?></a></h5>
										<div class="category">
											<span><?php esc_html_e('Category', 'classiera'); ?> : <a href="<?php echo $categoryLink; ?>"><?php echo $postCatgory[0]->name; ?></a>
											</span>
											<?php $classieraLOC = get_post_meta( $post->ID, $locShownBy, true );?>
											<span><?php esc_html_e('Location', 'classiera'); ?> : 
												<a href="#"><?php echo $classieraLOC; ?></a>
											</span>
										</div>
										<p class="description"><?php echo substr(get_the_excerpt(), 0,260); ?></p>
									</figcaption>
								</figure>
							</div><!--row-->
						</div><!--col-lg-4-->
						<?php endwhile; ?>
						<?php wp_reset_query(); ?>
					</div><!--row-->
				</div><!--container-->
			</div><!--tabpanel random-->
			<div role="tabpanel" class="tab-pane fade" id="popular">
				<div class="container">
					<div class="row">
					<?php 
							global $paged, $wp_query, $wp;
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ) {
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}
							//$cat_id = get_cat_ID(single_cat_title('', false));
							$cat_id = get_queried_object_id();
							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('orderby=title&post_type=post&posts_per_page=12&paged='.$paged.'&cat='.$cat_id);
							$current = -1;
							$current2 = 0;	
						while ($wp_query->have_posts()) : $wp_query->the_post(); $current++; $current2++;
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
								$category_icon = stripslashes($category_icon_code);
							}							
							$post_price = get_post_meta($post->ID, 'post_price', true);
							$theTitle = get_the_title();
							$postCatgory = get_the_category( $post->ID );
							//print_r($category);
							$categoryLink = get_category_link($catID);
							$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
							/*PostMultiCurrencycheck*/
							$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
							if(!empty($post_currency_tag)){
								$classieraCurrencyTag = classiera_Display_currency_sign($post_currency_tag);
							}else{
								global $redux_demo;
								$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
							}
							/*PostMultiCurrencycheck*/
						?>
						<div class="col-lg-4 col-md-4 col-sm-6 match-height item <?php echo $classieraItemClass; ?>">
							<div class="classiera-box-div classiera-box-div-v5">
								<figure class="clearfix">
									<div class="premium-img">
									<?php 
										$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
										if($classieraFeaturedPost == 1){
											?>
											<div class="featured-tag">
												<span class="left-corner"></span>
												<span class="right-corner"></span>
												<div class="featured">
													<p><?php esc_html_e( 'Featured', 'classiera' ); ?></p>
												</div>
											</div>
											<?php
										}
										?>
										<?php
										if( has_post_thumbnail()){
											$imageurl = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
											$thumb_id = get_post_thumbnail_id($post->id);
											?>
											<img class="img-responsive" src="<?php echo $imageurl[0]; ?>" alt="<?php echo $theTitle; ?>">
											<?php
										}else{
											?>
											<img class="img-responsive" src="<?php echo get_template_directory_uri() . '/images/nothumb.png' ?>" alt="No Thumb"/>
											<?php
										}
									?>
										<span class="hover-posts">											
											<a href="<?php the_permalink(); ?>"><?php esc_html_e('View Ad', 'classiera'); ?></a>
										</span>
										<?php if(!empty($post_price)){?>
											<span class="price">
												<?php esc_html_e('Price', 'classiera'); ?> : 
												<?php if(is_numeric($post_price)){?>
													<?php echo $classieraCurrencyTag.$post_price; ?>
												<?php }else{ ?>
													<?php echo $post_price; ?>
												<?php } ?>
											</span>
										<?php } ?>
										<?php if(!empty($classiera_ads_type)){?>
										<span class="classiera-buy-sel">
											<?php classiera_buy_sell($classiera_ads_type); ?>
										</span>
										<?php } ?>
									</div><!--premium-img-->
									<div class="detail text-center">
										<?php if(!empty($post_price)){?>
										<span class="price">
											<?php esc_html_e('Price', 'classiera'); ?> : 
											<?php if(is_numeric($post_price)){?>
												<?php echo $classieraCurrencyTag.$post_price; ?>
											<?php }else{ ?>
												<?php echo $post_price; ?>
											<?php } ?>
										</span>
										<?php } ?>
										<div class="box-icon">
											<a href="mailto:<?php echo $classieraAuthorEmail ?>?subject"><i class="fa fa-envelope"></i></a>
											<?php if(!empty($post_phone)){?>
                                            <a href="tel:<?php echo $post_phone; ?>"><i class="fa fa-phone"></i></a>
											<?php } ?>
										</div>
										<a href="<?php the_permalink(); ?>" class="btn btn-primary outline btn-style-five"><?php esc_html_e('View Ad', 'classiera'); ?></a>
									</div><!--detail text-center-->
									<figcaption>
										<?php if(!empty($post_price)){?>
										<span class="price visible-xs">
										<?php esc_html_e('Price', 'classiera'); ?> : 
											<?php if(is_numeric($post_price)){?>
												<?php echo $classieraCurrencyTag.$post_price; ?>
											<?php }else{ ?>
												<?php echo $post_price; ?>
											<?php } ?>
										</span>
										<?php } ?>
										<h5><a href="<?php the_permalink(); ?>"><?php echo $theTitle; ?></a></h5>
										<div class="category">
											<span><?php esc_html_e('Category', 'classiera'); ?> : <a href="<?php echo $categoryLink; ?>"><?php echo $postCatgory[0]->name; ?></a>
											</span>
											<?php $classieraLOC = get_post_meta( $post->ID, $locShownBy, true );?>
											<span><?php esc_html_e('Location', 'classiera'); ?> : 
												<a href="#"><?php echo $classieraLOC; ?></a>
											</span>
										</div>
										<p class="description"><?php echo substr(get_the_excerpt(), 0,260); ?></p>
									</figcaption>
								</figure>
							</div><!--row-->
						</div><!--col-lg-4-->
						<?php endwhile; ?>
						<?php wp_reset_query(); ?>
					</div><!--row-->
				</div><!--container-->
			</div><!--tabpanel popular-->
		</div><!--tab-content-->
	</div><!--tab-divs-->
</section>