<?php
/**
 * Template name: All Ads
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */
 get_header(); ?>
 <?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	global $redux_demo;	
	$classieraSearchStyle = $redux_demo['classiera_search_style'];
	$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
	$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
	$classieraAdsView = $redux_demo['home-ads-view'];	
	$classieraAdsSecDesc = $redux_demo['ad-desc'];
	$classieraAllAdsCount = $redux_demo['classiera_no_of_ads_all_page'];
	$classieraCategoriesStyle = $redux_demo['classiera_cat_style'];
	$classiera_pagination = $redux_demo['classiera_pagination'];
	$locShownBy = $redux_demo['location-shown-by'];
	$category_icon_code = "";
	$category_icon_color = "";
	$your_image_url = "";
	$category_icon ="";
	$caticoncolor="";
	$classieraItemClass = "item-grid";
	if($classieraAdsView == 'list'){
		$classieraItemClass = "item-list";
	}
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
<!--Content-->
<section class="inner-page-content border-bottom top-pad-50">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-lg-9">
				<!-- advertisement -->
				<?php if($classieraCategoriesStyle == 1){?>
				<section class="classiera-advertisement advertisement-v1">
					<div class="tab-divs section-light-bg">
						<div class="view-head">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6 col-xs-6">
									<?php 
										$classieraPostCount = wp_count_posts();
										$classieraPublishPCount = $classieraPostCount->publish;
									?>
                                        <div class="total-post">
                                            <p><?php esc_html_e( 'Total ads', 'classiera' ); ?>: 
												<span>
												<?php echo $classieraPublishPCount; ?> 
												<?php esc_html_e( 'ads posted', 'classiera' ); ?>
												</span>
											</p>
                                        </div><!--total-post-->
                                    </div><!--col-lg-6 col-sm-6 col-xs-6-->
                                    <div class="col-lg-6 col-sm-6 col-xs-6">
                                        <div class="view-as text-right flip">
                                            <span><?php esc_html_e( 'View as', 'classiera' ); ?>:</span>
                                            <a id="grid" class="grid btn btn-sm sharp outline <?php if($classieraAdsView == 'grid'){ echo "active"; }?>" href="#">
												<i class="fa fa-th"></i>
											</a>
                                            <a id="list" class="list btn btn-sm sharp outline <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#">
												<i class="fa fa-bars"></i>
											</a>
                                        </div><!--view-as text-right flip-->
                                    </div><!--col-lg-6 col-sm-6 col-xs-6-->
                                </div><!--row-->
                            </div><!--container-->
                        </div><!--view-head-->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane fade in active" id="all">
								<div class="container">
                                    <div class="row">
										<?php
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}
										$cat_id = get_cat_ID(single_cat_title('', false));
										$temp = $wp_query;
										$wp_query= null;
										$wp_query = new WP_Query();
										$arags = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'posts_per_page' => $classieraAllAdsCount,
											'paged' => $paged
										);
										$wp_query = new WP_Query($arags);
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
											$categoryLink = get_category_link($catID);
											$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
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
											<div class="classiera-box-div classiera-box-div-v1">
												<figure class="clearfix">
													<div class="premium-img">
														<?php if($classieraFeaturedPost == 1){?>
														<div class="featured-tag">
															<span class="left-corner"></span>
															<span class="right-corner"></span>
															<div class="featured">
																<p><?php esc_html_e( 'Featured', 'classiera' ); ?></p>
															</div>
														</div>
														<?php } ?>
														<?php if( has_post_thumbnail()){
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
															<a href="<?php the_permalink(); ?>" class="btn btn-primary outline btn-sm active"><?php esc_html_e( 'view ad', 'classiera' ); ?></a>
														</span>
													</div><!--premium-img-->
													<?php if(!empty($post_price)){?>
													<span class="classiera-price-tag" style="background-color:<?php echo $category_icon_color; ?>; color:<?php echo $category_icon_color; ?>;">
														<span class="price-text"><?php echo $classieraCurrencyTag.$post_price; ?></span>
													</span>
													<?php } ?>
													<figcaption>
														<h5><a href="<?php the_permalink(); ?>"><?php echo $theTitle; ?></a></h5>
														<p><?php esc_html_e( 'Category', 'classiera' ); ?> : 
															<a href="<?php echo $categoryLink; ?>"><?php echo $postCatgory[0]->name; ?></a>
														</p>
														<span class="category-icon-box" style=" background:<?php echo $category_icon_color; ?>; color:<?php echo $category_icon_color; ?>; ">
															<?php 
															if($classieraIconsStyle == 'icon'){
																?>
																<i class="<?php echo $category_icon_code;?>"></i>
																<?php
															}elseif($classieraIconsStyle == 'img'){
																?>
																<img src="<?php echo $classieraCatIcoIMG; ?>" alt="<?php echo get_cat_name( $catName ); ?>">
																<?php
															}
															?>
														</span>
														<p class="description">
															<?php echo substr(get_the_excerpt(), 0,260); ?>
														</p>
														<div class="post-tags">
															<span><i class="fa fa-tags"></i>
															<?php esc_html_e('Tags', 'classiera'); ?>&nbsp; :
															</span>
															<?php the_tags('','',''); ?>
														</div>
													</figcaption>
												</figure>
											</div><!--classiera-box-div-->
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
							</div><!--tabpanel-->
						</div><!--tab-content-->
					</div><!--tab-divs-->
				</section>
				<!-- End advertisement Style 1-->
				<?php }elseif($classieraCategoriesStyle == 2){?>
				<section class="classiera-advertisement advertisement-v2 section-pad-top-100">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-8">
									<?php 
										$classieraPostCount = wp_count_posts();
										$classieraPublishPCount = $classieraPostCount->publish;
									?>
                                        <div class="total-post">
                                            <p><?php esc_html_e( 'Total ads', 'classiera' ); ?>: 
												<span>
												<?php echo $classieraPublishPCount; ?> 
												<?php esc_html_e( 'ads posted', 'classiera' ); ?>
												</span>
											</p>
                                        </div><!--total-post-->
									</div><!--col-lg-6 col-sm-8-->
									<div class="col-lg-6 col-sm-4">
										<div class="view-as text-right flip">
											<span><?php esc_html_e( 'View as', 'classiera' ); ?>:</span>
											<div class="btn-group">
												<a id="grid" class="grid btn btn-primary radius btn-md <?php if($classieraAdsView == 'grid'){ echo "active"; }?>" href="#"><i class="fa fa-th"></i></a>
												<a id="list" class="list btn btn-primary btn-md radius <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#"><i class="fa fa-th-list"></i></a>
											</div>
										</div>
									</div><!--col-lg-6 col-sm-4-->
								</div><!--row-->
							</div><!--container-->
						</div><!--view-head-->
						<div class="tab-content section-gray-bg">
							<div role="tabpanel" class="tab-pane fade in active" id="all">
								<div class="container">
									<div class="row">
										<?php
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}
										$cat_id = get_cat_ID(single_cat_title('', false));
										$temp = $wp_query;
										$wp_query= null;										
										$arags = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'posts_per_page' => $classieraAllAdsCount,
											'paged' => $paged
										);
										$wp_query = new WP_Query($arags);
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
											$categoryLink = get_category_link($catID);
											$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
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
											<div class="classiera-box-div classiera-box-div-v2">
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
															<a href="<?php the_permalink(); ?>" class="btn btn-primary btn-round btn-md btn-style-two active">
																<?php esc_html_e( 'view ad', 'classiera' ); ?>
																<span><i class="fa fa-eye"></i></span>
															</a>
														</span>
														<?php if(!empty($classiera_ads_type)){?>
														<span class="classiera-buy-sel">
														<?php classiera_buy_sell($classiera_ads_type); ?>
														</span>
														<?php } ?>
													</div><!--premium-img-->
													<figcaption>
														<a class="category-box" href="<?php echo $categoryLink; ?>" style="background: <?php echo $category_icon_color; ?>;">
															<?php 
															if($classieraIconsStyle == 'icon'){
																?>
																<i class="<?php echo $category_icon_code;?>"></i>
																<?php
															}elseif($classieraIconsStyle == 'img'){
																?>
																<img src="<?php echo $classieraCatIcoIMG; ?>" alt="<?php echo get_cat_name( $catName ); ?>">
																<?php
															}
															?>
															<span><?php echo $postCatgory[0]->name; ?></span>
														</a>
														<h5><a href="<?php the_permalink(); ?>"><?php echo $theTitle; ?></a></h5>
														<?php if(!empty($post_price)){?>
														<p class="price">
														<?php esc_html_e( 'Price', 'classiera' ); ?> : <span>
															<?php if(is_numeric($post_price)){?>
															<?php echo $classieraCurrencyTag.$post_price; ?>
															<?php }else{ ?>
															<?php echo $post_price; ?>
															<?php } ?>
														</span>
														</p>
														<?php } ?>
														<p class="description"><?php echo substr(get_the_excerpt(), 0,260); ?></p>
														<div class="post-tags">
															<span><i class="fa fa-tags"></i><?php esc_html_e('Tags', 'classiera'); ?>&nbsp;:</span>
															<?php the_tags('','',''); ?>
														</div>
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
							</div><!--tabpanel-->
						</div><!--tab-content section-gray-bg-->
					</div>
				</section>
				<!-- advertisement Style 2-->
				<?php }elseif($classieraCategoriesStyle == 3){?>
				<section class="classiera-advertisement advertisement-v3 section-pad-top-100">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-8">
									<?php 
										$classieraPostCount = wp_count_posts();
										$classieraPublishPCount = $classieraPostCount->publish;
									?>
                                        <div class="total-post">
                                            <p><?php esc_html_e( 'Total ads', 'classiera' ); ?>: 
												<span>
												<?php echo $classieraPublishPCount; ?> 
												<?php esc_html_e( 'ads posted', 'classiera' ); ?>
												</span>
											</p>
                                        </div><!--total-post-->
									</div><!--col-lg-6 col-sm-8-->
									<div class="col-lg-6 col-sm-4">
										<div class="view-as text-right flip">
											<span><?php esc_html_e( 'View as', 'classiera' ); ?>:</span>
											<div class="btn-group">
												<a id="grid" class="grid <?php if($classieraAdsView == 'grid'){ echo "active"; }?>" href="#"><i class="fa fa-th"></i></a>
												<a id="list" class="list <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#"><i class="fa fa-th-list"></i></a>
											</div>
										</div>
									</div><!--col-lg-6 col-sm-4-->
								</div><!--row-->
							</div><!--container-->
						</div><!--view-head-->
						<div class="tab-content section-gray-bg">
							<div role="tabpanel" class="tab-pane fade in active" id="all">
								<div class="container">
									<div class="row">
										<?php
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}
										$cat_id = get_cat_ID(single_cat_title('', false));
										$temp = $wp_query;
										$wp_query= null;										
										$arags = array(
											'post_type' => 'post',
											'posts_per_page' => $classieraAllAdsCount,
											'post_status' => 'publish',
											'paged' => $paged
										);
										$wp_query = new WP_Query($arags);
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
											$categoryLink = get_category_link($catID);
											$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
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
											<div class="classiera-box-div classiera-box-div-v3">
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
															<a href="<?php the_permalink(); ?>" class="btn btn-primary radius btn-md btn-style-three active">
																<?php esc_html_e( 'view ad', 'classiera' ); ?>
															</a>
														</span>
														<?php if(!empty($classiera_ads_type)){?>
														<span class="classiera-buy-sel">
														<?php classiera_buy_sell($classiera_ads_type); ?>
														</span>
														<?php } ?>
													</div><!--premium-img-->
													<figcaption>
														<?php if(!empty($post_price)){?>
														<div class="price">
															<span><i class="fa fa-money" aria-hidden="true"></i></span>
															<span class="amount">
																<?php if(is_numeric($post_price)){?>
																	<?php echo $classieraCurrencyTag.$post_price; ?>
																<?php }else{ ?>
																	<?php echo $post_price; ?>
																<?php } ?>
															</span>
														</div>
														<?php } ?>
														<h5><a href="<?php the_permalink(); ?>"><?php echo $theTitle; ?></a></h5>
														<span class="category">                                            
															<?php 
															if($classieraIconsStyle == 'icon'){
																?>
																<i style="color:<?php echo $category_icon_color; ?>" class="<?php echo $category_icon_code;?>"></i> :
																<?php
															}elseif($classieraIconsStyle == 'img'){
																?>
																<img src="<?php echo $classieraCatIcoIMG; ?>" alt="<?php echo get_cat_name( $catName ); ?>"> :
																<?php
															}
															?>
															<a href="<?php echo $categoryLink; ?>"><?php echo $postCatgory[0]->name; ?></a>
														</span>
														<p class="description"><?php echo substr(get_the_excerpt(), 0,260); ?></p>
														
														<div class="post-tags">
															<span><i class="fa fa-tags"></i><?php esc_html_e('Tags', 'classiera'); ?>&nbsp;:</span>
															<?php the_tags('','',''); ?>
														</div>
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
							</div><!--tabpanel-->
						</div><!--tab-content section-gray-bg-->
					</div><!--tab-divs-->
				</section>
				<!-- advertisement Style 3-->
				<?php }elseif($classieraCategoriesStyle == 4){?>
				<section class="classiera-advertisement advertisement-v4 section-pad-top-100">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-8 col-xs-12">
									<?php 
										$classieraPostCount = wp_count_posts();
										$classieraPublishPCount = $classieraPostCount->publish;
									?>
										<div class="total-post">
											<p><?php esc_html_e( 'Total ads', 'classiera' ); ?>: 
												<span>
												<?php echo $classieraPublishPCount; ?> 
												<?php esc_html_e( 'ads posted', 'classiera' ); ?>
												</span>
											</p>
										</div><!--total-post-->
									</div><!--col-lg-6 col-sm-8-->
									<div class="col-lg-6 col-sm-4 col-xs-12">
										<div class="view-as tab-button">
											<ul class="nav nav-tabs pull-right flip" role="tablist">
												<li><span><?php esc_html_e( 'View as', 'classiera' ); ?></span></li>
												<li role="presentation" class="<?php if($classieraAdsView == 'grid'){ echo "active"; }?>">
													<a id="grid" class="masonry" href="#">
														<i class="zmdi zmdi-view-dashboard"></i>
														<span class="arrow-down"></span>
													</a>
												</li>
												<li role="presentation" class="<?php if($classieraAdsView == 'list'){ echo "active"; }?>">
													<a id="list" class="list" href="#">
														<i class="zmdi zmdi-view-list"></i>
														<span class="arrow-down"></span>
													</a>
												</li>
											</ul>
										</div><!--view-as tab-button-->
									</div><!--col-lg-6 col-sm-4 col-xs-12-->
								</div><!--row-->
							</div><!--container-->
						</div><!--view-head-->
						<div class="tab-content section-gray-bg">
							<div role="tabpanel" class="tab-pane fade in active" id="all">
								<div class="container">
									<div class="row <?php if($classieraAdsView == 'grid'){ echo "masonry-content"; }?>">
										<?php
										$classieraItemClass = "item-masonry";
										if($classieraAdsView == 'list'){
											$classieraItemClass = "item-list";
										}
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}
										$cat_id = get_cat_ID(single_cat_title('', false));
										$temp = $wp_query;
										$wp_query= null;										
										$arags = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'posts_per_page' => $classieraAllAdsCount,
											'paged' => $paged
										);
										$wp_query = new WP_Query($arags);
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
											$post_phone = get_post_meta($post->ID, 'post_phone', true);
											$theTitle = get_the_title();
											$postCatgory = get_the_category( $post->ID );
											//print_r($category);
											$categoryLink = get_category_link($catID);
											$classieraPostAuthor = $post->post_author;
											$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
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
										<div class="item item-grid <?php echo $classieraItemClass; ?>">
											<div class="classiera-box-div classiera-box-div-v4">
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
														<div class="premium-img-inner">	
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
															</span>
															<?php if(!empty($classiera_ads_type)){?>
															<span class="classiera-buy-sel">
																<?php classiera_buy_sell($classiera_ads_type); ?>
															</span>
															<?php } ?>
															<div class="category">
																<span style="background:<?php echo $category_icon_color; ?>;">
																<?php 
																if($classieraIconsStyle == 'icon'){
																	?>
																	<i class="<?php echo $category_icon_code;?>"></i>
																	<?php
																}elseif($classieraIconsStyle == 'img'){
																	?>
																	<img src="<?php echo $classieraCatIcoIMG; ?>" alt="<?php echo get_cat_name( $catName ); ?>">
																	<?php
																}
																?>
																</span>
																<a href="<?php echo $categoryLink; ?>"><?php echo $postCatgory[0]->name; ?></a>
															</div><!--category-->
														</div><!--premium-img-inner-->
													</div><!--premium-img-->
													<div class="detail text-center">
														<?php if(!empty($post_price)){?>
														<span class="amount">
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
														<a href="<?php the_permalink(); ?>" class="btn btn-primary btn-md btn-style-four"><?php esc_html_e('View Ad', 'classiera'); ?></a>
													</div><!--detail text-center-->
													<figcaption>
														<h5><a href="<?php the_permalink(); ?>"><?php echo $theTitle; ?></a></h5>
														<div class="category">
															<span style="background:<?php echo $category_icon_color; ?>;">
															<?php 
																if($classieraIconsStyle == 'icon'){
																	?>
																	<i class="<?php echo $category_icon_code;?>"></i>
																	<?php
																}elseif($classieraIconsStyle == 'img'){
																	?>
																	<img src="<?php echo $classieraCatIcoIMG; ?>" alt="<?php echo get_cat_name( $catName ); ?>">
																	<?php
																}
															?>
															</span>
															<a href="<?php echo $categoryLink; ?>"><?php echo $postCatgory[0]->name; ?></a>
														</div>
														<?php if(!empty($post_price)){?>
														<div class="price">
															<span class="amount">
																<?php if(is_numeric($post_price)){?>
																	<?php echo $classieraCurrencyTag.$post_price; ?>
																<?php }else{ ?>
																	<?php echo $post_price; ?>
																<?php } ?>
															</span>
														</div>
														<?php } ?>
														<p class="description"><?php echo substr(get_the_excerpt(), 0,260); ?></p>
													</figcaption>
												</figure>
											</div><!--row-->
										</div><!--item item-grid item-masonry-->
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
							</div><!--tabpanel-->
						</div><!--tab-content-->
					</div><!--tab-divs-->
				</section>
				<!-- advertisement Style 4-->
				<?php }elseif($classieraCategoriesStyle == 5){?>
				<section class="classiera-advertisement advertisement-v5 section-pad-80 border-bottom">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-7 col-xs-8">
										<?php 
										$classieraPostCount = wp_count_posts();
										$classieraPublishPCount = $classieraPostCount->publish;
									?>
                                        <div class="total-post">
                                            <p><?php esc_html_e( 'Total ads', 'classiera' ); ?>: 
												<span>
												<?php echo $classieraPublishPCount; ?> 
												<?php esc_html_e( 'ads posted', 'classiera' ); ?>
												</span>
											</p>
                                        </div><!--total-post-->
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
										<?php
										$classieraItemClass = "item-masonry";
										if($classieraAdsView == 'list'){
											$classieraItemClass = "item-list";
										}
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}
										$cat_id = get_cat_ID(single_cat_title('', false));
										$temp = $wp_query;
										$wp_query= null;										
										$arags = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'posts_per_page' => $classieraAllAdsCount,
											'paged' => $paged
										);
										$wp_query = new WP_Query($arags);
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
											$post_phone = get_post_meta($post->ID, 'post_phone', true);
											$theTitle = get_the_title();
											$postCatgory = get_the_category( $post->ID );
											//print_r($category);
											$categoryLink = get_category_link($catID);
											$classieraPostAuthor = $post->post_author;
											$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
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
							</div><!--tabpanel-->
						</div><!--tab-content-->
					</div><!--tab-divs-->
				</section>
				<!-- advertisement Style 5-->
				<?php }elseif($classieraCategoriesStyle == 6){?>
				<section class="classiera-advertisement advertisement-v6 section-pad border-bottom">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-8">
										<?php 
										$classieraPostCount = wp_count_posts();
										$classieraPublishPCount = $classieraPostCount->publish;
									?>
                                        <div class="total-post">
                                            <p><?php esc_html_e( 'Total ads', 'classiera' ); ?>: 
												<span>
												<?php echo $classieraPublishPCount; ?> 
												<?php esc_html_e( 'ads posted', 'classiera' ); ?>
												</span>
											</p>
                                        </div><!--total-post-->
									</div><!--col-lg-6 col-sm-8-->
									<div class="col-lg-6 col-sm-4">
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
									<?php 
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}
										$arags = array(
											'post_type' => 'post',
											'posts_per_page' => $classieraAllAdsCount,
											'post_status' => 'publish',
											'paged' => $paged
										);
										$wp_query = new WP_Query($arags);
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
											$post_phone = get_post_meta($post->ID, 'post_phone', true);
											$theTitle = get_the_title();
											$postCatgory = get_the_category( $post->ID );
											//print_r($category);
											$categoryLink = get_category_link($catID);
											$classieraPostAuthor = $post->post_author;
											$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
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
											<div class="classiera-box-div classiera-box-div-v6">
												<figure class="nohover clearfix">
													<div class="premium-img">
													<?php 
														$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
														if($classieraFeaturedPost == 1){
															?>
															<div class="featured">
																<p><?php esc_html_e( 'Featured', 'classiera' ); ?></p>
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
														<?php if(!empty($post_price)){?>
															<span class="price btn btn-primary round btn-style-six active">
																<?php if(is_numeric($post_price)){?>
																	<?php echo $classieraCurrencyTag.$post_price; ?>
																<?php }else{ ?>
																	<?php echo $post_price; ?>
																<?php } ?>
															</span>
														<?php } ?>
														<?php if(!empty($classiera_ads_type)){?>
														<span class="classiera-buy-sel btn btn-primary round btn-style-six active">
															<?php classiera_buy_sell($classiera_ads_type); ?>
														</span>
														<?php } ?>
													</div><!--premium-img-->
													<div class="box-div-heading">
														<h4>
															<a href="<?php the_permalink(); ?>"><?php echo $theTitle; ?></a>
														</h4>
														<div class="category">
															<span><?php esc_html_e('Category', 'classiera'); ?> : 
																<a href="<?php echo $categoryLink; ?>"><?php echo $postCatgory[0]->name; ?></a>
															</span>
														</div>
													</div><!--box-div-heading-->
													<div class="detail text-center">
															<?php if(!empty($post_price)){?>
															<span class="price price btn btn-primary round btn-style-six active">
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
														<?php //} ?>
													</div><!--box-div-heading-->									
													<figcaption>
														<div class="content">
															<?php if(!empty($post_price)){?>
															<span class="price btn btn-primary round btn-style-six active visible-xs">
																<?php if(is_numeric($post_price)){?>
																	<?php echo $classieraCurrencyTag.$post_price; ?>
																<?php }else{ ?>
																	<?php echo $post_price; ?>
																<?php } ?>
															</span>
															<?php } ?>
															<h5>
																<a href="<?php the_permalink(); ?>"><?php echo $theTitle; ?></a>
															</h5>
															<div class="category">
																<span><?php esc_html_e('Category', 'classiera'); ?> : <a href="<?php echo $categoryLink; ?>"><?php echo $postCatgory[0]->name; ?></a></span>
															</div>
															<div class="description">
																<p><?php echo substr(get_the_excerpt(), 0,260); ?></p>
															</div>
															<a href="<?php the_permalink(); ?>"><?php esc_html_e('View Ad', 'classiera'); ?> <i class="fa fa-long-arrow-right"></i></a>
														</div><!--content-->
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
							</div><!--tabpanel-->
						</div><!--tab-content-->
					</div><!--tab-divs-->
				</section>
				<!-- advertisement Style 6-->
				<?php }elseif($classieraCategoriesStyle == 7){?>
				<section class="classiera-advertisement advertisement-v6 advertisement-v7 section-pad border-bottom">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-8">
									<?php 
										$classieraPostCount = wp_count_posts();
										$classieraPublishPCount = $classieraPostCount->publish;
									?>
                                        <div class="total-post">
                                            <p><?php esc_html_e( 'Total ads', 'classiera' ); ?>: 
												<span>
												<?php echo $classieraPublishPCount; ?> 
												<?php esc_html_e( 'ads posted', 'classiera' ); ?>
												</span>
											</p>
                                        </div><!--total-post-->
									</div><!--col-lg-6 col-sm-8-->
									<div class="col-lg-6 col-sm-4">
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
										<?php 
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}
										$arags = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'posts_per_page' => $classieraAllAdsCount,
											'paged' => $paged
										);
										$wp_query = new WP_Query($arags);
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
											$post_phone = get_post_meta($post->ID, 'post_phone', true);
											$theTitle = get_the_title();
											$postCatgory = get_the_category( $post->ID );
											//print_r($category);
											$categoryLink = get_category_link($catID);
											$classieraPostAuthor = $post->post_author;
											$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
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
											<div class="classiera-box-div classiera-box-div-v7">
												<figure class="clearfix">
													<div class="premium-img">
													<?php 
														$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
														if($classieraFeaturedPost == 1){
															?>
															<div class="featured">
																<p><?php esc_html_e( 'Featured', 'classiera' ); ?></p>
															</div>
															<?php
														}
														?>
														<?php if(!empty($classiera_ads_type)){?>
														<div class="caption-tags">
															<span class="buy-sale-tag btn btn-primary round btn-style-six active">
															<?php classiera_buy_sell($classiera_ads_type); ?>
															</span>
														</div>
														<?php } ?>
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
													</div><!--premium-img-->
													<div class="detail text-center">
														<?php if(!empty($post_price)){?>
														<span class="price price btn btn-primary round btn-style-six active">
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
													</div><!--box-div-heading-->
													<figcaption>
														<div class="caption-tags">
															<?php if(!empty($post_price)){?>
															<span class="price btn btn-primary round btn-style-six active">
																<?php if(is_numeric($post_price)){?>
																	<?php echo $classieraCurrencyTag.$post_price; ?>
																<?php }else{ ?>
																	<?php echo $post_price; ?>
																<?php } ?>
															</span>
															<?php } ?>
															<?php if(!empty($classiera_ads_type)){?>
															<span class="buy-sale-tag btn btn-primary round btn-style-six active">
																<?php classiera_buy_sell($classiera_ads_type); ?>
															</span>
															<?php } ?>
														</div>
														<div class="content">
															<?php if(!empty($post_price)){?>
															<span class="price btn btn-primary round btn-style-six active visible-xs">
																<?php if(is_numeric($post_price)){?>
																	<?php echo $classieraCurrencyTag.$post_price; ?>
																<?php }else{ ?>
																	<?php echo $post_price; ?>
																<?php } ?>
															</span>
															<?php } ?>
															<h5>
																<a href="<?php the_permalink(); ?>"><?php echo $theTitle; ?></a>
															</h5>
															<div class="category">
																<span><?php esc_html_e('Category', 'classiera'); ?> : <a href="<?php echo $categoryLink; ?>"><?php echo $postCatgory[0]->name; ?></a></span>
															</div>
															<div class="description">
																<p><?php echo substr(get_the_excerpt(), 0,260); ?></p>
															</div>
															<a href="<?php the_permalink(); ?>"><?php esc_html_e('View Ad', 'classiera'); ?> <i class="fa fa-long-arrow-right"></i></a>
														</div><!--content-->
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
							</div><!--tabpanel-->
						</div><!--tab-content-->
					</div><!--tab-divs-->
				</section>
				<!-- advertisement Style 7-->
				<?php } ?>
			</div><!--col-md-8 col-lg-9-->
			<div class="col-md-4 col-lg-3">
				<aside class="sidebar">
					<div class="row">
						<?php get_sidebar('pages'); ?>
					</div>
				</aside>
			</div>
		</div><!--row-->
	</div><!--container-->
</section>
<!--Content-->
<?php get_footer(); ?>