<?php 
$post_ID = related_Post_ID();
global $redux_demo;
$classieraRelatedCount = $redux_demo['classiera_related_ads_count'];
$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
//echo $post_ID; echo "shabir";
?>
<!-- related blog post section -->
<section class="blog-post-section related-blog-post-section border-bottom">
    <div class="container" style="overflow: hidden;">
        <div class="row">
            <div class="col-sm-6 related-blog-post-head">
                <h4 class="text-uppercase"><?php esc_html_e( 'Related ads', 'classiera' ); ?></h4>
            </div><!--col-sm-6-->
            <div class="col-sm-6">
                <div class="navText text-right flip hidden-xs">
                    <a class="prev btn btn-primary sharp btn-style-one btn-sm"><i class="fa fa-chevron-left"></i></a>
                    <a class="next btn btn-primary sharp btn-style-one btn-sm"><i class="fa fa-chevron-right"></i></a>
                </div>
            </div><!--col-sm-6-->
        </div><!--row-->
        <div class="row">
            <div class="col-lg-12">
                <div class="owl-carousel premium-carousel-v1" data-car-length="4" data-items="4" data-loop="true" data-nav="false" data-autoplay="true" data-autoplay-timeout="3000" data-dots="false" data-auto-width="false" data-auto-height="true" data-right="false" data-responsive-small="1" data-autoplay-hover="true" data-responsive-medium="2" data-responsive-xlarge="4" data-margin="30">
				<?php 
				$orig_post = $post; 
				global $post;
				$tags = wp_get_post_tags($post_ID);
				//print_r($tags); echo "hassan";
				$relatedCat = wp_get_post_categories($post_ID);
				if ($tags || $relatedCat){
					
				$tag_ids = array();
				foreach($tags as $individual_tag)
				$tag_ids[] = $individual_tag->term_id;
				$args=array(  
							'tag__in' => $tag_ids,  
							'post__not_in' => array($post_ID),  
							'posts_per_page'=>$classieraRelatedCount, // Number of related posts to display.  
							'ignore_sticky_posts'=>1,
						);
				$current = -1;
				$my_query = new wp_query( $args );
				$category_icon_code ="";
				$category_icon_color ="";
				$your_image_url ="";
				while( $my_query->have_posts() ) {
					$my_query->the_post();
					global $postID;
					$current++;
					$category = get_the_category();
					if ($category[0]->category_parent == 0){
						$tag = get_cat_ID( $category[0]->name );
						$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
						//print_r($tag_extra_fields); echo "shabir";	
						if (isset($tag_extra_fields[$tag])) {
							$category_icon_code = $tag_extra_fields[$tag]['category_icon_code']; 
							$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
							$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
						}
					}elseif($category[1]->category_parent == 0){
						$tag = $category[0]->category_parent;
						$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);						
						if (isset($tag_extra_fields[$tag])){
							$categoryID = $tag_extra_fields[$tag];
							$category_icon_code = $categoryID['category_icon_code'];
							$category_icon_color = $categoryID['category_icon_color'];
							$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
						}
					}else{
						$tag = $category[1]->category_parent;
						$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);						
						if (isset($tag_extra_fields[$tag])){
							$categoryID = $tag_extra_fields[$tag];
							$category_icon_code = $categoryID['category_icon_code'];
							$category_icon_color = $categoryID['category_icon_color'];
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
					$categoryLink = get_category_link($tag);
					$classieraPostAuthor = $post->post_author;
					$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
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
					<!--SingleItem-->
                    <div class="classiera-box-div-v1 item match-height">
                        <figure>
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
									<a href="<?php the_permalink(); ?>" class="btn btn-primary sharp btn-sm active"><?php esc_html_e( 'View Ad', 'classiera' ); ?></a>
								</span>
                            </div>
							<?php if(!empty($post_price)){?>
                            <span class="classiera-price-tag" style="background-color:<?php echo $category_icon_color; ?>; color:<?php echo $category_icon_color; ?>;">
                                <span class="price-text">
									<?php if(is_numeric($post_price)){?>
										<?php echo $classieraCurrencyTag.$post_price; ?>
									<?php }else{ ?>
										<?php echo $post_price; ?>
									<?php } ?>
								</span>
                            </span>
							<?php } ?>
                            <figcaption>
                                <h5><a href="<?php the_permalink(); ?>"><?php echo $theTitle; ?></a></h5>
                                <p> 
									<?php esc_html_e('Category', 'classiera'); ?> : 
									<a href="<?php echo $categoryLink; ?>"><?php echo $postCatgory[0]->name; ?></a>
								</p>
                                <span class="category-icon-box" style=" background:<?php echo $category_icon_color; ?>; color:<?php echo $category_icon_color; ?>; ">
									<?php 
									if($classieraIconsStyle == 'icon'){
										?>
										<i class="<?php echo $category_icon; ?>"></i>
										<?php
									}elseif($classieraIconsStyle == 'img'){
										?>
										<img src="<?php echo $classieraCatIcoIMG; ?>" alt="<?php echo $postCatgory[0]->name; ?>">
										<?php
									}
									?>
								</span>
                            </figcaption>
                        </figure>
                    </div><!--item-->
					<?php }?><!--End while -->
					<?php }?><!--End Main tags if -->
					<!--SingleItem-->
                </div><!--owl-carousel-->
            </div><!--col-lg-12-->
        </div><!--row-->
    </div>
</section><!-- /.related blog post -->