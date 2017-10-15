<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0
 */

get_header(); 
?>
<?php
global $redux_demo;
$classieraSearchStyle = $redux_demo['classiera_search_style'];
$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
$classieraAdsView = $redux_demo['home-ads-view'];
$classieraItemClass = "item-grid";
if($classieraAdsView == 'list'){
	$classieraItemClass = "item-list";
}
//echo $classieraAdsView."shabir";
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
<section class="inner-page-content border-bottom top-pad-50">
	<div class="container">
		<!-- breadcrumb -->
		<?php classiera_breadcrumbs();?>
		<!-- breadcrumb -->
		<div class="row">
			<div class="col-md-8 col-lg-9">
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
                                            <a id="grid" class="grid btn btn-sm sharp outline <?php if($classieraAdsView == 'grid'){ echo "active"; }?>" href="#"><i class="fa fa-th"></i></a>
                                            <a id="list" class="list btn btn-sm sharp outline <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#"><i class="fa fa-bars"></i></a>
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
									if ( !empty ( $args['paged'] ) && 0 == $paged ) {
										$wp_query->set('paged', $args['paged']);
										$paged = $args['paged'];
									}
									if ( is_day() ) :
										$archive_year  = get_the_date('Y'); 
										$archive_month = get_the_date('m'); 
										$archive_day   = get_the_date('d');
										global $args; $args = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'monthnum' => $archive_month, 'day' => $archive_day, 'order' => 'DESC', 'post_type' => 'post');
										global $args_popular; $args_popular = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'monthnum' => $archive_month, 'day' => $archive_day, 'post_type' => 'post', 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC');
										global $args_random; $args_random = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'monthnum' => $archive_month, 'day' => $archive_day, 'order' => 'DESC', 'post_type' => 'post', 'orderby' => 'title');
										
									elseif ( is_month() ) :	
										$archive_year  = get_the_date('Y'); 
										$archive_month = get_the_date('m');
										global $args; $args = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'monthnum' => $archive_month, 'order' => 'DESC', 'post_type' => 'post');
										global $args_popular; $args_popular = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'monthnum' => $archive_month, 'post_type' => 'post', 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC');
										global $args_random; $args_random = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'monthnum' => $archive_month, 'order' => 'DESC', 'post_type' => 'post', 'orderby' => 'title');
									
									elseif ( is_year() ) :
										$archive_year  = get_the_date('Y'); 
										global $args; $args = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'order' => 'DESC');
										global $args_popular; $args_popular = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC');
										global $args_random; $args_random = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'order' => 'DESC', 'orderby' => 'title');
									
									elseif ( is_tag() ) :
										global $wp_query;
										$tag = $wp_query->get_queried_object();
										$current_tag = $tag->term_id;
										global $args; $args = array('paged' => $paged, 'posts_per_page' => 9, 'tag_id' => $current_tag, 'order' => 'DESC');
										global $args_popular; $args_popular = array('paged' => $paged, 'posts_per_page' => 9, 'tag_id' => $current_tag, 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC');
										global $args_random; $args_random = array('paged' => $paged, 'posts_per_page' => 9, 'tag_id' => $current_tag, 'order' => 'DESC', 'orderby' => 'title');
										
									else :
									endif;					
									?>
									<?php
										$wp_query= null;
										$wp_query = new WP_Query();
										$wp_query->query($args);
										$current = -1;
										$current2 = 0;

									?>
									<?php while ($wp_query->have_posts()) : $wp_query->the_post(); $current++; $current2++; ?>
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
													<?php if(!empty($classiera_ads_type)){?>
													<span class="classiera-buy-sel">
														<?php classiera_buy_sell($classiera_ads_type); ?>
													</span>
													<?php } ?>
												</div><!--premium-img-->
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
															<img src="<?php echo $classieraCatIcoIMG; ?>" alt="<?php echo $postCatgory[0]->name; ?>">
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
									<?php									
									  if(function_exists('classiera_pagination')){
										classiera_pagination();
									  }
									?>
									<?php wp_reset_query(); ?>	
									</div>
								</div>
							</div>
						</div><!--tab-content-->
					</div>
				</section>
			</div>
			<div class="col-md-4 col-lg-3">
				<aside class="sidebar">
					<div class="row">
						<?php get_sidebar('pages'); ?>
					</div>
				</aside>
			</div>
		</div><!--row-->
	</div><!--container-->
</section><!--inner-page-content-->
<?php get_footer(); ?>
