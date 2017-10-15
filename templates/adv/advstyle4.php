<?php 
	global $redux_demo;	
	$classieraAdsSecDesc = $redux_demo['ad-desc'];
	$ads_counter = $redux_demo['home-ads-counter'];
	$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
	$classieraFeaturedAdsCounter = $redux_demo['classiera_featured_ads_count'];
	$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
	$classieraAdsView = $redux_demo['home-ads-view'];
	$classieraItemClass = "item-masonry";
	if($classieraAdsView == 'list'){
		$classieraItemClass = "item-list";
	}
	$category_icon_code = "";
	$category_icon_color = "";
	$catIcon = "";
?>
<section class="classiera-advertisement advertisement-v4 section-pad-top-100">
	<div class="section-heading-v1 section-heading-with-icon">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-9 center-block">
                    <h3 class="text-capitalize"><?php esc_html_e( 'ADVERTISEMENTS', 'classiera' ); ?><i class="fa fa-briefcase"></i></h3>
                    <p><?php echo $classieraAdsSecDesc; ?></p>
                </div>
            </div>
        </div>
    </div>
	<div class="tab-divs">
		<div class="view-head">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-sm-8 col-xs-12">
                        <div class="tab-button">
                            <ul class="nav nav-tabs" role="tablist">
								<li><span><?php esc_html_e( 'Filter By', 'classiera' ); ?></span></li>
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
					<div class="row masonry-content">
					<!--<div class="row <?php //if($classieraAdsView == 'grid'){ echo "masonry-content"; }?>">-->
					<!--FeaturedAds-->
					<?php 
						global $paged, $wp_query, $wp;
						$args = wp_parse_args($wp->matched_query);
						if ( !empty ( $args['paged'] ) && 0 == $paged ){
							$wp_query->set('paged', $args['paged']);
							$paged = $args['paged'];
						}
						$featuredPosts = array();
						$arags = array(
							'post_type' => 'post',
							'posts_per_page' => $classieraFeaturedAdsCounter,
							'paged' => $paged,
							'meta_query' => array(
							array(
								'key' => 'featured_post',
								'value' => '1',
								'compare' => '=='
								)
							),
						);
						$wsp_query = new WP_Query($arags);
						$current = -1;
						$current2 = 0;
						while ($wsp_query->have_posts()) : $wsp_query->the_post(); $current++; $current2++;
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
							$featuredPosts[] = $post->ID;
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
						<?php wp_reset_postdata(); ?>
						<?php wp_reset_query(); ?>
					<!--FeaturedAds-->
					<?php 
						global $paged, $wp_query, $wp;
						$args = wp_parse_args($wp->matched_query);
						if ( !empty ( $args['paged'] ) && 0 == $paged ){
							$wp_query->set('paged', $args['paged']);
							$paged = $args['paged'];
						}
						$arags = array(
							'post_type' => 'post',
							'posts_per_page' => $ads_counter,
							'paged' => $paged,
							'post__not_in' => $featuredPosts,
						);
						$wsp_query = new WP_Query($arags);
						$current = -1;
						$current2 = 0;
						while ($wsp_query->have_posts()) : $wsp_query->the_post(); $current++; $current2++;
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
						<?php wp_reset_postdata(); ?>
					</div><!--row-->
				</div><!--container-->
			</div><!--tabpanel-->
			<div role="tabpanel" class="tab-pane fade" id="random">
				<div class="container">
					<div class="row masonry-content">
						<?php 
							global $paged, $wp_query, $wp;
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ) {
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}
							$argas = array(
								'orderby' => 'title',
								'post_type' => 'post',
								'posts_per_page' => $ads_counter,
								'paged' => $paged
							);
							$wdp_query = new WP_Query($argas);
							$current = -1;
							$current2 = 0;
						while ($wdp_query->have_posts()) : $wdp_query->the_post(); $current++; $current2++;	
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
											<span style="background:<?php echo $category_icon_color; ?>;"><i class="<?php echo $category_icon; ?>"></i></span>
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
						<?php wp_reset_postdata(); ?>
					</div><!--row-->
				</div><!--container-->
			</div><!--tabpanel Random-->
			<div role="tabpanel" class="tab-pane fade" id="popular">
				<div class="container">
					<div class="row masonry-content">
						<?php 
						global $paged, $wp_query, $wp;
						$args = wp_parse_args($wp->matched_query);
						if ( !empty ( $args['paged'] ) && 0 == $paged ) {
							$wp_query->set('paged', $args['paged']);
							$paged = $args['paged'];
						}
						$current = -1;
						$current2 = 0;
						global $cat_id;
						$popularpost = new WP_Query( array( 'posts_per_page' => $ads_counter, 'cat' => $cat_id, 'posts_type' => 'post', 'paged' => $paged, 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC'  ) );
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
											<span style="background:<?php echo $category_icon_color; ?>;"><i class="<?php echo $category_icon; ?>"></i></span>
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
						<?php wp_reset_postdata(); ?>
					</div><!--row-->
				</div><!--container-->
			</div><!--tabpanel popular-->
			<?php $viewAllAds = $redux_demo['all-ads-page-link']; ?>
			<div class="view-all text-center">               
				<a href="<?php echo $viewAllAds; ?>" class="btn btn-primary radius btn-md btn-style-four">
					<?php esc_html_e('View All Ads', 'classiera'); ?>
				</a>
            </div>
		</div><!--tab-content-->
	</div><!--tab-divs-->
</section>