<?php
/**
 * The template for displaying Category pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */

get_header(); 
?>
<?php
global $redux_demo; 
$caticoncolor="";
$category_icon_code ="";
$category_icon ="";
$category_icon_color="";
$classieraSearchStyle = $redux_demo['classiera_search_style'];
$classieraPremiumStyle = $redux_demo['classiera_premium_style'];
$classieraPartnersStyle = $redux_demo['classiera_partners_style'];
$classieraCategoriesStyle = $redux_demo['classiera_cat_style'];
$classieraPostCount = $redux_demo['classiera_cat_post_counter'];

	//$cat_id = get_cat_ID(single_cat_title('', false));
	$cat_id = get_queried_object_id();
	$this_category = get_category($cat_id);
	//$cat_id = get_cat_ID(single_cat_title('', false));
	$cat_parent_ID = isset( $cat_id->category_parent ) ? $cat_id->category_parent : '';
	if ($cat_parent_ID == 0) {
		$tag = $cat_id;
	}else{
		$tag = $cat_parent_ID;
	}
	$category = get_category($tag);
	$count = $category->category_count;
	$catName = get_cat_name( $tag );
function classiera_Cat_Ads_Count(){
		//$cat_id = get_cat_ID(single_cat_title('', false));
		$cat_id = get_queried_object_id();
		$cat_parent_ID = isset( $cat_id->category_parent ) ? $cat_id->category_parent : '';
		if ($cat_parent_ID == 0) {
			$tag = $cat_id;
		}else{
			$tag = $cat_parent_ID;
		}
		$q = new WP_Query( array(
			'nopaging' => true,
			'tax_query' => array(
				array(
					'taxonomy' => 'category',
					'field' => 'id',
					'terms' => $tag,
					'include_children' => true,
				),
			),
			'fields' => 'ids',
		) );
	$count = $q->post_count;
	echo $count; 
}
function classiera_Single_Cat_ID(){
	
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
<!-- page content -->
<section class="inner-page-content border-bottom top-pad-50">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-lg-9">
			<!--Google Section-->
			<?php 
			$homeAd1 = '';		
			global $redux_demo;
			$homeAdImg1 = $redux_demo['post_ad']['url']; 
			$homeAdImglink1 = $redux_demo['post_ad_url']; 
			$homeHTMLAds = $redux_demo['post_ad_code_html'];
			
			if(!empty($homeHTMLAds) || !empty($homeAdImg1)){
				if(!empty($homeHTMLAds)){
					$homeAd1 = $homeHTMLAds;
				}else{
					$homeAd1 = '<a href="'.$homeAdImglink1.'" target="_blank"><img class="img-responsive" alt="image" src="'.$homeAdImg1.'" /></a>';
				}
			}
			if(!empty($homeAd1)){
			?>
			<section id="classieraDv">
				<div class="container">
					<div class="row">							
						<div class="col-lg-12 col-md-12 col-sm-12 center-block text-center">
							<?php echo $homeAd1; ?>
						</div>
					</div>
				</div>	
			</section>
			<?php } ?>
			<!--Google Section-->
				<!-- advertisement -->
				<?php 
					if($classieraCategoriesStyle == 1){
						get_template_part( 'templates/catinner/style1' );
					}elseif($classieraCategoriesStyle == 2){
						get_template_part( 'templates/catinner/style2' );
					}elseif($classieraCategoriesStyle == 3){
						get_template_part( 'templates/catinner/style3' );
					}elseif($classieraCategoriesStyle == 4){
						get_template_part( 'templates/catinner/style4' );
					}elseif($classieraCategoriesStyle == 5){
						get_template_part( 'templates/catinner/style5' );
					}elseif($classieraCategoriesStyle == 6){
						get_template_part( 'templates/catinner/style6' );
					}elseif($classieraCategoriesStyle == 7){
						get_template_part( 'templates/catinner/style7' );
					}
				?>
				<!-- advertisement -->
			</div><!--col-md-8-->
			<div class="col-md-4 col-lg-3">
				<aside class="sidebar">
					<div class="row">
						<!--subcategory-->
						<?php 
						$cat_term_ID = $this_category->term_id;
						$cat_child = get_term_children( $cat_term_ID, 'category' );
						if (!empty($cat_child)) {
							$args = array(
								'type' => 'post',
								'child_of' => $cat_id,
								'parent' => get_query_var(''),
								'orderby' => 'name',
								'order' => 'ASC',
								'hide_empty' => 0,
								'hierarchical' => 1,
								'taxonomy' => 'category',
								'pad_counts' => true 
							);
							$category = get_categories($args);
							if($category[0]->category_parent == 0){
									$tag = $category[0]->cat_ID;
									$category_icon_code = "";
									$category_icon_color = "";
									$your_image_url = "";
									$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
									if (isset($tag_extra_fields[$tag])) {
										$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
										$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
									}
								}else{
									$tag = $category[0]->category_parent;
									$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
									if (isset($tag_extra_fields[$tag])) {
										$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
										$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
									}
								}
								$category_icon = stripslashes($category_icon_code);
						?>
						<div class="col-lg-12 col-md-12 col-sm-6 match-height">
							<div class="widget-box">
								<div class="widget-title">
									<h4>
										<i class="<?php echo $category_icon; ?>" style="color:<?php echo $category_icon_color; ?>;"></i>
										<?php echo $catName; ?>
									</h4>
								</div>
								<div class="widget-content">
									<ul class="category">
									<?php
										foreach($category as $category) { 
									?>
										<li>
                                            <a href="<?php echo get_category_link( $category->term_id )?>">
                                                <i class="fa fa-angle-right"></i>
                                                <?php echo $category->name ?>
                                                <span class="pull-right flip">
												<?php if($classieraPostCount == 1){?>
													(<?php echo $category->count ?>)
												<?php }else{ ?>
													&nbsp;
												<?php } ?>
												</span>
                                            </a>
                                        </li>
									<?php } ?>
									</ul>
								</div>
							</div>
						</div>
						<?php } ?>
						<!--subcategory-->
						<?php get_sidebar('pages'); ?>
					</div><!--row-->
				</aside>
			</div><!--row-->
		</div><!--row-->
	</div><!--container-->
</section>	
<!-- page content -->
<?php get_footer(); ?>