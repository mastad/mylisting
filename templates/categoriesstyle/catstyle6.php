<?php 
	global $redux_demo;
	$category_icon_code = "";
	$category_icon_color = "";
	$catIcon = "";
	$homeCatONOFF = $redux_demo['home-cat-disable'];
	$classieraCatSECTitle = $redux_demo['cat-sec-title'];
	$classieraCatSECDESC = $redux_demo['cat-sec-desc'];
	$allCatURL = $redux_demo['all-cat-page-link'];
	$trnsCatVAll = $redux_demo['trns-cat-viewall-btn'];
	$cat_counter = $redux_demo['classiera_no_of_cats_all_page'];
	$primaryColor = $redux_demo['color-primary'];
	$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
	$classieraPostCount = $redux_demo['classiera_cat_post_counter'];
?>
<section class="section-pad category-v6 border-bottom">
	<div class="section-heading-v6">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 center-block">
                    <h1 class="text-capitalize"><?php echo $classieraCatSECTitle; ?></h1>
                    <p><?php echo $classieraCatSECDESC; ?></p>
                </div><!--col-lg-7-->
            </div><!--row-->
        </div><!--container-->
    </div><!--section-heading-v1-->
	<div class="container">
		<div class="row">
			<?php 
			$categories = get_terms('category', array(
					'hide_empty' => 0,
					'parent' => 0,
					'number' => $cat_counter,
					'order'=> 'ASC'
				)	
			);
			$current = -1;
			foreach ($categories as $category) {
				$tag = $category->term_id;
				$classieraCatFields = get_option(MY_CATEGORY_FIELDS);
				//print_r($classieraCatFields);
				if (isset($classieraCatFields[$tag])){
					$classieraCatIconCode = $classieraCatFields[$tag]['category_icon_code'];
					$classieraCatIcoIMG = $classieraCatFields[$tag]['your_image_url'];
					$classieraCatIconClr = $classieraCatFields[$tag]['category_icon_color'];
					$categoryIMG = $classieraCatFields[$tag]['category_image'];
				}
				$cat = $category->count;
				$catName = $category->term_id;
				$mainID = $catName;
				if(empty($classieraCatIconClr)){
					$iconColor = $primaryColor;
				}else{
					$iconColor = $classieraCatIconClr;
				}
				if(empty($categoryIMG)){
					$classieracatIMG = get_template_directory_uri().'/images/category.png';
				}else{
					$classieracatIMG = $categoryIMG;
				}	
				$current++;
				$allPosts = 0;
				$categoryLink = get_category_link( $category->term_id );
				$categories = get_categories('child_of='.$catName);
				foreach ($categories as $category) {
					$allPosts += $category->category_count;
				}
				$classieraTotalPosts = $allPosts + $cat;
				$category_icon = stripslashes($classieraCatIconCode);
				?>
			<div class="col-lg-4 col-sm-6">
				<div class="category-box">
					<figure>
						<img src="<?php echo $classieracatIMG; ?>" alt="<?php echo get_cat_name( $catName ); ?>">
						<div class="category-box-hover" style="background: #ea4444">
							<span><i style="color:<?php echo $iconColor; ?>;" class="<?php echo $category_icon; ?>"></i></span>
							<h3><a href="<?php echo $categoryLink; ?>"><?php echo get_cat_name( $catName ); ?></a></h3>
							<?php if($classieraPostCount == 1){?>
							<p><?php echo $classieraTotalPosts; ?> <?php esc_html_e( 'ads posted', 'classiera' ); ?></p>
							<?php }?>
							<ul class="list-unstyled fa-ul">
							<?php 
							$args = array(
								'type' => 'post',
								'child_of' => $catName,
								'parent' => get_query_var(''),
								'orderby' => 'name',
								'order' => 'ASC',
								'hide_empty' => 0,
								'hierarchical' => 1,
								'exclude' => '',
								'include' => '',
								'number' => '5',
								'taxonomy' => 'category',
								'pad_counts' => true 
							);
							$subcategories = get_categories($args);
							foreach($subcategories as $subcat) {
								$categoryTitle = $subcat->name;
								$categoryLinkChild = get_category_link( $subcat->term_id );
								?>
								<li>
                                    <a href="<?php echo $categoryLinkChild; ?>">
										<i class="fa-li fa fa-angle-right"></i>
										<?php echo $categoryTitle; ?>
									</a>
                                </li>
								<?php
							}
							?>
							</ul>
							<a href="<?php echo $categoryLink; ?>"><?php esc_html_e( 'View All', 'classiera' ); ?> 
								<i class="fa fa-long-arrow-right"></i>
							</a>
						</div>
						<figcaption>
							<span style="background:<?php echo $iconColor; ?>;"><i class="<?php echo $category_icon; ?>"></i></span>
							<h3><a href="<?php echo $categoryLink; ?>"><?php echo get_cat_name( $catName ); ?></a></h3>
							<p>
							<?php if($classieraPostCount == 1){?>
								<?php echo $classieraTotalPosts;?>&nbsp;<?php esc_html_e( 'Ads posted', 'classiera' ); ?>
							<?php }else{ ?>
								&nbsp;
							<?php } ?>
							</p>
						</figcaption>
					</figure>
				</div>
			</div>			
			<?php } ?>			
		</div>
	</div>
</section>