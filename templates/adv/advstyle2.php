<?php 
	global $redux_demo;	
	$classieraAdsSecDesc = $redux_demo['ad-desc'];
	$ads_counter = $redux_demo['home-ads-counter'];
	$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
	$classieraFeaturedAdsCounter = $redux_demo['classiera_featured_ads_count'];
	$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
	$classieraAdsView = $redux_demo['home-ads-view'];
	$classieraItemClass = "item-grid";
	if($classieraAdsView == 'list'){
		$classieraItemClass = "item-list";
	}
	$category_icon_code = "";
	$category_icon_color = "";
	$catIcon = "";
?>
<section class="classiera-advertisement advertisement-v2 section-pad-top-100">
	<div class="section-heading-v1">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-7 center-block">
                    <h3 class="text-uppercase"><?php esc_html_e( 'ADVERTISEMENTS', 'classiera' ); ?></h3>
                    <p><?php echo $classieraAdsSecDesc; ?></p>
                </div>
            </div>
        </div>
    </div>
	<div class="tab-divs">
		<div class="view-head">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-sm-8">
                        <div class="tab-button">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#all" class="btn btn-labeled btn-primary radius" aria-controls="all" role="tab" data-toggle="tab"><span class="btn-label"><i class="fa fa-bars"></i></span> <span class="btn-label-text"><?php esc_html_e( 'All Ads', 'classiera' ); ?></span></a>
                                </li>
                                <li role="presentation">
                                    <a href="#random" class="btn btn-labeled btn-primary radius" aria-controls="random" role="tab" data-toggle="tab"><span class="btn-label"><i class="fa fa-clock-o"></i></span><span class="btn-label-text"><?php esc_html_e( 'Random Ads', 'classiera' ); ?></span></a>
                                </li>
                                <li role="presentation">
                                    <a href="#popular" class="btn btn-labeled btn-primary radius" aria-controls="popular" role="tab" data-toggle="tab"><span class="btn-label"><i class="fa fa-star"></i></span><span class="btn-label-text"><?php esc_html_e( 'Popular Ads', 'classiera' ); ?></span></a>
                                </li>
                            </ul><!--nav nav-tabs-->
                        </div><!--tab-button-->
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
						$featuredPosts = array();
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
						<?php wp_reset_postdata(); ?>
					</div><!--row-->
				</div><!--container-->
			</div><!--tabpanel-->
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
						<?php wp_reset_postdata(); ?>
					</div><!--row-->
				</div><!--container-->
			</div><!--tabpanel Random-->
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
										<p class="price"><?php esc_html_e( 'Price', 'classiera' ); ?> : <span>
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
						<?php wp_reset_postdata(); ?>
					</div><!--row-->
				</div><!--container-->
			</div><!--tabpanel popular-->
			<?php $viewAllAds = $redux_demo['all-ads-page-link']; ?>
			<div class="view-all text-center">
                <a href="<?php echo $viewAllAds; ?>" class="btn btn-primary round btn-md btn-style-two"><span><i class="fa fa-refresh"></i></span><?php esc_html_e('View All Ads', 'classiera'); ?></a>
            </div>
		</div><!--tab-content-->
		
	</div><!--tab-divs-->
</section>