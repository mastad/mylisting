<?php
/**
 * The template for displaying Category pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Classiera
 * @since Classiera 1.0
 */

get_header(); ?>
<?php 
// Retrieve the URL variables (using PHP).
	global $redux_demo;
	$catSearchID = "";
	$minPrice = "";
	$maxPrice = "";
	$search_state = "";
	$search_country = "";
	$search_city = "";
	$main_cat = "";
	$price_range = "";
	$emptyPost = 0;
	$featuredPosts = array();
	$classieraSearchStyle = $redux_demo['classiera_search_style'];
	$classieraMaxPrice = $redux_demo['classiera_max_price_input'];
	$locShownBy = $redux_demo['location-shown-by'];
	$classieraPriceRange = $redux_demo['classiera_pricerange_on_off'];
	$classieraLocationSearch = $redux_demo['classiera_search_location_on_off'];
	$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
	$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
	$classieraCategoriesStyle = $redux_demo['classiera_cat_style'];	
	$classieraAdsView = $redux_demo['home-ads-view'];
	$classieraItemCondation = $redux_demo['adpost-condition'];
	$classiera_pagination = $redux_demo['classiera_pagination'];
	$locationsStateOn = $redux_demo['location_states_on'];
	$locationsCityOn= $redux_demo['location_city_on'];
	
	$classieraTagDefault = $redux_demo['classiera_multi_currency_default'];
	$classieraMultiCurrency = $redux_demo['classiera_multi_currency'];
	$postCurrency = $redux_demo['classierapostcurrency'];
	if($classieraMultiCurrency == 'multi'){
		$classieraPriceTagForSearch = classiera_Display_currency_sign($classieraTagDefault);
	}elseif(!empty($postCurrency) && $classieraMultiCurrency == 'single'){
		$classieraPriceTagForSearch = $postCurrency;
	}
	$classieraItemClass = "item-grid";
	if($classieraAdsView == 'list'){
		$classieraItemClass = "item-list";
	}	
	$keyword = $_GET['s'];
	if(isset($_GET['custom_fields'])){
		$custom_fields = $_GET['custom_fields'];
		$searchQueryCustomFields = classiera_CF_search_Query($custom_fields);
	}
	if(isset($_GET['sub_cat'])){
		$sub_cat = $_GET['sub_cat'];
	}	
	if(isset($_GET['category_name'])){
		$main_cat = $_GET['category_name'];
	}	
	if(isset($_GET['search_min_price'])){
		$minPrice = $_GET['search_min_price'];
	}
	if(isset($_GET['search_max_price'])){
		$maxPrice = $_GET['search_max_price'];
	}
	if(isset($_GET['price_range'])){
		$price_range = $_GET['price_range'];
	}
	if(empty($minPrice) || empty($maxPrice)){
		$string = $price_range;
	}else{
		$string = $minPrice.','.$maxPrice;
	}	
	$priceArray = explode(',', $string);
	if(!empty($priceArray)){		
		$searchQueryPrice = classiera_Price_search_Query($priceArray);
	}
	if(isset($_GET['post_location'])){
		$country = $_GET['post_location'];		
		$SearchQueryCountry = classiera_Country_search_Query($country);		
	}	
	if(isset($_GET['post_state'])){
		$state = $_GET['post_state'];
		$SearchQueryState = classiera_State_search_Query($state);		
	}	
	if(isset($_GET['post_city'])){
		$city = $_GET['post_city'];
		$SearchQueryCity = classiera_City_search_Query($city);
	}
	if(isset($_GET['item-condition'])){
		$search_condition = $_GET['item-condition'];		
		$SearchCondition = classiera_Condition_search_Query($search_condition);
	}	
	if(empty($sub_cat) || $sub_cat == '-1'){		
		$category_name = $main_cat;
	}else{
		$category_name = $sub_cat;
	}	
	if(!empty($category_name)){
		if($category_name != "All" && $category_name != "-1") {
			$catSearchID = $category_name;				
		} else {
			$catSearchID = '-1';
		}
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
<section class="inner-page-content border-bottom top-pad-50">
	<div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4">
				<!--SearchForm-->
				<form method="get">
					<div class="search-form border">
						<div class="search-form-main-heading">
                            <a href="#innerSearch" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="innerSearch">
                                <i class="fa fa-search"></i>
								<?php esc_html_e( 'Advanced Search', 'classiera' ); ?>
                            </a>
                        </div><!--search-form-main-heading-->
						<div id="innerSearch" class="collapse in classiera__inner">
							<!--Price Range-->
							<?php if($classieraPriceRange == 1){?>
							<div class="inner-search-box">
								<h5 class="inner-search-heading">
									<span class="currency__symbol">
									<?php 
									if (!empty($postCurrency) && $classieraMultiCurrency == 'single'){
										echo $postCurrency;
									}elseif($classieraMultiCurrency == 'multi'){
										echo classiera_Display_currency_sign($classieraTagDefault);
									}else{
										echo "&dollar;";
									}
									?>	
									</span>
								<?php esc_html_e( 'Price Range', 'classiera' ); ?>
								</h5>
								<?php 
								$startPrice = $classieraMaxPrice*10/100; 
								$secondPrice = $startPrice+$startPrice; 
								$thirdPrice = $startPrice+$secondPrice; 
								$fourthPrice = $startPrice+$thirdPrice; 
								$fivePrice = $startPrice+$fourthPrice; 
								$sixPrice = $startPrice+$fivePrice; 
								$sevenPrice = $startPrice+$sixPrice; 
								$eightPrice = $startPrice+$sevenPrice; 
								$ninePrice = $startPrice+$eightPrice; 
								$tenPrice = $startPrice+$ninePrice;
								?>
								<div class="radio">
									<!--PriceFirst-->
                                    <input id="price-range-1" type="radio" value="<?php echo "0,".$startPrice; ?>" name="price_range">
                                    <label for="price-range-1">
										0&nbsp;&ndash;&nbsp;
										<?php echo $startPrice; ?>
									</label>
									<!--PriceSecond-->
									<input id="price-range-2" type="radio" value="<?php echo $startPrice.','.$secondPrice; ?>" name="price_range">
                                    <label for="price-range-2">
										<?php echo $startPrice+1; ?>&nbsp;&ndash;&nbsp;
										<?php echo $secondPrice; ?>
									</label>
									<!--PriceThird-->
									<input id="price-range-3" type="radio" value="<?php echo $secondPrice.','.$thirdPrice; ?>" name="price_range">
                                    <label for="price-range-3">
										<?php echo $secondPrice+1; ?>&nbsp;&ndash;&nbsp;
										<?php echo $thirdPrice; ?>
									</label>
									<!--PriceFourth-->
									<input id="price-range-4" type="radio" value="<?php echo $thirdPrice.','.$fourthPrice; ?>" name="price_range">
                                    <label for="price-range-4">
										<?php echo $thirdPrice+1; ?>&nbsp;&ndash;&nbsp;
										<?php echo $fourthPrice; ?>
									</label>
									<!--PriceFive-->
									<input id="price-range-5" type="radio" value="<?php echo $fourthPrice.','.$fivePrice; ?>" name="price_range">
                                    <label for="price-range-5">
										<?php echo $fourthPrice+1; ?>&nbsp;&ndash;&nbsp;
										<?php echo $fivePrice; ?>
									</label>
									<!--PriceSix-->
									<input id="price-range-6" type="radio" value="<?php echo $fivePrice.','.$sixPrice; ?>" name="price_range">
                                    <label for="price-range-6">
										<?php echo $fivePrice+1; ?>&nbsp;&ndash;&nbsp;
										<?php echo $sixPrice; ?>
									</label>
									<!--PriceSeven-->
									<input id="price-range-7" type="radio" value="<?php echo $sixPrice.','.$sevenPrice; ?>" name="price_range">
                                    <label for="price-range-7">
										<?php echo $sixPrice+1; ?>&nbsp;&ndash;&nbsp;
										<?php echo $sevenPrice; ?>
									</label>
									<!--PriceEight-->
									<input id="price-range-8" type="radio" value="<?php echo $sevenPrice.','.$eightPrice; ?>" name="price_range">
									<label for="price-range-8">
										<?php echo $sevenPrice+1; ?>&nbsp;&ndash;&nbsp;
										<?php echo $eightPrice; ?>
									</label>
									<!--PriceNine-->
									<input id="price-range-9" type="radio" value="<?php echo $eightPrice.','.$ninePrice; ?>" name="price_range">
									<label for="price-range-9">
										<?php echo $eightPrice+1; ?>&nbsp;&ndash;&nbsp;
										<?php echo $ninePrice; ?>
									</label>
									<!--Max Price-->
									 <input id="price-range-10" type="radio" value="<?php echo $ninePrice.','.$classieraMaxPrice; ?>" name="price_range">
                                    <label for="price-range-10">
										<?php echo $ninePrice+1; ?>&nbsp;&ndash;&nbsp;
										<?php echo $classieraMaxPrice; ?>
									</label>
                                </div><!--radio-->
								<div class="range-slider">
                                    <p><?php esc_html_e( 'Set Custom Range', 'classiera' ); ?></p>
                                    <input id="price-range" type="text" class="" value="" data-slider-min="0" data-slider-max="<?php echo $classieraMaxPrice; ?>" data-slider-step="5" data-slider-value="[0,<?php echo $classieraMaxPrice; ?>]">
                                    <div class="price-range-text">
                                        <?php echo $classieraPriceTagForSearch; ?>
                                        <span class="first-price">
                                        0
										</span>
                                        -
                                        <?php echo $classieraPriceTagForSearch; ?>
                                        <span class="second-price">
                                        <?php echo $classieraMaxPrice; ?>
										</span>
                                    </div>
                                </div><!--range-slider-->
							</div>
							<?php } ?>
							<!--Price Range-->
							<div class="inner-search-box">
                                <h5 class="inner-search-heading"><i class="fa fa-tag"></i>
								<?php esc_html_e( 'Keywords', 'classiera' ); ?>
								</h5>
                                <div class="inner-addon right-addon">
                                    <i class="right-addon form-icon fa fa-search"></i>
                                    <input type="search" name="s" class="form-control form-control-sm" placeholder="<?php esc_html_e( 'Enter Keyword', 'classiera' ); ?>">
                                </div>
                            </div><!--Keywords-->
							<!--Locations-->
							<?php if($classieraLocationSearch == 1){?>
							<div class="inner-search-box">
                                <h5 class="inner-search-heading"><i class="fa fa-map-marker"></i>
								<?php esc_html_e( 'Location', 'classiera' ); ?>
								</h5>
								<!--SelectCountry-->
								<?php
								$country = get_posts( array( 'post_type' => 'countries', 'posts_per_page' => -1, 'suppress_filters' => 0 ));
								if(!empty($country)){
								?>
                                <div class="inner-addon right-addon">
                                    <i class="right-addon form-icon fa fa-sort"></i>
                                    <select name="post_location" class="form-control form-control-sm" id="post_location">
										<option value="-1" selected disabled>
											<?php esc_html_e('Select Country', 'classiera'); ?>
										</option>
										<?php foreach( $country as $singleCountry ){?>
										<option value="<?php echo $singleCountry->ID; ?>"><?php echo $singleCountry->post_title; ?></option>
										<?php } ?>
                                    </select>
                                </div>
								<?php } ?>
								 <?php wp_reset_postdata(); ?>
								<!--SelectCountry-->
								<!--Select State-->
								<?php if($locationsStateOn == 1){?>
								<div class="inner-addon right-addon post_sub_loc">
                                    <i class="right-addon form-icon fa fa-sort"></i>
                                    <select name="post_state" class="form-control form-control-sm" id="post_state">
                                        <option value=""><?php esc_html_e('Select State', 'classiera'); ?></option>
                                    </select>
                                </div>
								<?php } ?>
								<!--Select State-->
								<!--Select City-->
								<?php if($locationsCityOn == 1){?>
								<div class="inner-addon right-addon post_sub_loc">
                                    <i class="right-addon form-icon fa fa-sort"></i>
                                    <select name="post_city" class="form-control form-control-sm" id="post_city">
                                        <option value=""><?php esc_html_e('Select City', 'classiera'); ?></option>
                                    </select>
                                </div>
								<?php } ?>
								<!--Select City-->
                            </div>
							<?php } ?>
							<!--Locations-->
							<!--Categories-->
							<div class="inner-search-box">
								<h5 class="inner-search-heading"><i class="fa fa-folder-open"></i>
								<?php esc_html_e( 'Categories', 'classiera' ); ?>
								</h5>
								<!--SelectCategory-->
								<div class="inner-addon right-addon">
                                    <i class="right-addon form-icon fa fa-sort"></i>
                                    <?php 
									$args = array(												
										'show_option_none' => esc_html__( 'Select category', 'classiera' ),
										'show_count' => 0,
										'orderby' => 'name',											  
										'selected' => -1,
										'depth' => 1,
										'hierarchical' => 1,						  
										'hide_if_empty'  => false,
										'hide_empty' => 0,
										'name' => 'category_name',
										'parent' => 0,
										'value_field' => 'slug',
										'id' => 'main_cat',
										'class' => 'form-control form-control-sm',
										'disabled' => '',
									);
									wp_dropdown_categories($args);
									?>
                                </div>
								<!--Select Sub Category-->
								<div class="inner-addon right-addon">
                                    <i class="right-addon form-icon fa fa-sort"></i>
                                    <select name="sub_cat" class="form-control form-control-sm" id="sub_cat" disabled="disabled">
									</select>
                                </div>
								<!--CustomFields-->
								<?php
								$args = array(
								  'hide_empty' => false,
								  'orderby' => 'name',
								  'order' => 'ASC'
								);
								$inum = 0;
								$categories = get_categories($args);
								global $wpdb;
								$shabir = $wpdb->get_results( "select * from ".$wpdb->prefix."postmeta where meta_key='custom_field'", OBJECT );
								$field_values = array();
								foreach ( $shabir as $r ) {			
									$values = maybe_unserialize($r->meta_value);
									if(!empty($values)){
										$post_categories = wp_get_post_categories( $r->post_id );
										if(!empty($post_categories)){
											foreach($post_categories as $c){
												$cat = $c;
											}
											$cat = intval($cat);
											foreach($values as $val) {
												$key= $val[0];
												$field_values[$cat][$key][] = $val[1];					
											}
										}	
									}
								}
								foreach($categories as $category) {
									$inum++;
									$cat_id = $category->cat_ID;
									$cat_slug = $category->slug;
									$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);	
									$fields = $tag_extra_fields[$cat_id]['category_custom_fields'];
									$fieldsType = $tag_extra_fields[$cat_id]['category_custom_fields_type'];
									/*Display Text Fields*/
									for ($i = 0; $i < (count($fields)); $i++) {
										if($fieldsType[$i][1] == 'text'){
											?>
											<div class="inner-addon right-addon custom-field-cat custom-field-cat-<?php echo $cat_slug; ?>" style="display: none;">
												<i class="right-addon form-icon fa fa-sort"></i>
												<select name="custom_fields[]" class="form-control form-control-sm autoHide hide-<?php echo $cat_slug; ?>">
													<option value=""><?php echo $fields[$i][0]; ?>...</option>
													<?php $key = $fields[$i][0];
													if(!empty($field_values[$cat_id][$key])) : 
														foreach($field_values[$cat_id][$key] as $val) : ?>
														<option value="<?php echo $val; ?>"><?php echo $val; ?></option>
													<?php endforeach; endif; ?>
												</select>
											</div>
											<?php
										}
									}
									/*Display Dropdown Fields*/
									for ($i = 0; $i < (count($fields)); $i++) {
										if($fieldsType[$i][1] == 'dropdown'){
											?>
											<div class="inner-addon right-addon custom-field-cat custom-field-cat-<?php echo $cat_slug; ?>" style="display: none;">
												<i class="right-addon form-icon fa fa-sort"></i>
												<select name="custom_fields[]" class="form-control form-control-sm autoHide hide-<?php echo $cat_slug; ?>">
													<option value=""><?php echo $fields[$i][0]; ?>...</option>
													<?php 
													$options = $fieldsType[$i][2]; 
													$optionsarray = explode(',',$options);
													?>
													<?php 
														foreach($optionsarray as $option){
																echo '<option value="'.$option.'">'.$option.'</option>';
															}
													?>
												</select>
											</div>
											<?php
										}
									}
									/*Display Checkbox Fields*/
									for ($i = 0; $i < (count($fields)); $i++) {
										if($fieldsType[$i][1] == 'checkbox'){
											?>
											<div class="inner-addon right-addon custom-field-cat custom-field-cat-<?php echo $cat_slug; ?>" style="display: none;">
												<div class="checkbox custom-field-cat-<?php echo $cat_slug; ?>">
													<input type="checkbox" id="<?php echo $cat_id.$i; ?>" name="custom_fields[]" value="<?php echo $fields[$i][0]; ?>">
													<label for="<?php echo $cat_id.$i; ?>"><?php echo $fields[$i][0]; ?></label>
												</div>
											</div>
											<?php
										}
									}
								}
								?>
								<!--CustomFields-->
								<!--Item Condition-->
								<?php if($classieraItemCondation == 1){ ?>
								<div class="inner-search-box-child">
                                    <p><?php esc_html_e( 'Select Condition', 'classiera' ); ?></p>
                                    <div class="radio">
                                        <input id="use-all" type="radio" name="item-condition" value="<?php esc_html_e('All', 'classiera') ?>" checked>
                                        <label for="use-all"><?php esc_html_e( 'All', 'classiera' ); ?></label>
										<input id="new" type="radio" name="item-condition" value="<?php esc_html_e('New', 'classiera') ?>">
                                        <label for="new"><?php esc_html_e( 'New', 'classiera' ); ?></label>
										<input id="used" type="radio" name="item-condition" value="<?php esc_html_e('Used', 'classiera') ?>">
                                        <label for="used"><?php esc_html_e( 'Used', 'classiera' ); ?></label>
                                    </div>
                                </div>
								<?php } ?>
								<!--Item Condition-->
							</div><!--inner-search-box-->
							<button type="submit" name="search" class="btn btn-primary sharp btn-sm btn-style-one btn-block" value="<?php esc_html_e( 'Search', 'classiera') ?>"><?php esc_html_e( 'Search', 'classiera') ?></button>
						</div><!--innerSearch-->
					</div><!--search-form-->
					<input type="hidden" id="range-first-val" name="search_min_price" value="">
					<input type="hidden" id="range-second-val" name="search_max_price" value="">
				</form>
				<!--SearchForm-->
			</div><!--col-lg-3 col-md-4-->
			<!--EndSidebar-->
			<!--ContentArea-->
			<div class="col-lg-9 col-md-8">
				<?php if($classieraCategoriesStyle == 1){?>
				<section class="classiera-advertisement advertisement-v1">
					<div class="tab-divs section-light-bg">
						<!--ViewHead-->
						<div class="view-head">
                            <div class="container">
                                <div class="row">
								<?php 
								global $paged, $wp_query, $wp;								
								$args = wp_parse_args($wp->matched_query);
								$temp = $wp_query;								
								$args = array(
									'post_type' => 'post',
									'post_status' => 'publish',
									's'   => $keyword,
									'posts_per_page' => -1,
									'category_name' => $catSearchID,
									'meta_query' => array(
										'relation' => 'AND',
										$searchQueryPrice,
										$SearchQueryCountry,											
										$SearchQueryState,											
										$SearchQueryCity,
										$searchCondition,
										$searchQueryCustomFields,
									),
								);
								$wp_query= null;
								$wp_query = new WP_Query($args);
								$count = $wp_query->post_count;
								?>
                                    <div class="col-lg-6 col-sm-6 col-xs-6">
                                        <div class="total-post">
                                            <p> <?php echo $count; ?>
											<?php esc_html_e( 'Ads Founded', 'classiera') ?> : 
												<span>
												<?php esc_html_e( 'Related to your search', 'classiera') ?>
												</span>
											</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-xs-6">
                                        <div class="view-as text-right flip">
                                            <span><?php esc_html_e( 'View as', 'classiera') ?>:</span>
                                            <a id="grid" class="grid btn btn-sm sharp outline <?php if($classieraAdsView == 'grid'){ echo "active"; }?>" href="#"><i class="fa fa-th"></i></a>
                                            <a id="list" class="list btn btn-sm sharp outline <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#"><i class="fa fa-bars"></i></a>
                                        </div>
                                    </div>
									<?php wp_reset_query(); ?>
									 <?php wp_reset_postdata(); ?>
                                </div>
                            </div>
                        </div>
						<!--ViewHead-->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane fade in active" id="all">
								<div class="container">
                                    <div class="row">
									<?php
										global $paged, $wp_query, $wp;										
										$args = wp_parse_args($wp->matched_query);
										$temp = $wp_query;										
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											's'   => $keyword,
											'posts_per_page' => -1,											
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$SearchQueryCountry,											
												$SearchQueryState,											
												$SearchQueryCity,
												$searchCondition,
												$searchQueryCustomFields,
												array(
													'key' => 'featured_post',
													'value' => '1',
													'compare' => '=='
												),
												
											),
										);
										$wp_query= null;
										//print_r($args);
										$wp_query = new WP_Query($args);
										while ($wp_query->have_posts()) : $wp_query->the_post();
										$emptyPost++;
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
										$post_location = get_post_meta($post->ID, 'post_location', true);
										$post_state = get_post_meta($post->ID, 'post_state', true);
										$post_city = get_post_meta($post->ID, 'post_city', true);
										$post_price = get_post_meta($post->ID, 'post_price', true);
										$theTitle = get_the_title();
										$postCatgory = get_the_category( $post->ID );
										$categoryLink = get_category_link($catID);
										$featured_post = get_post_meta($post->ID, 'featured_post', true);
										$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
										$classieraPostAuthor = $post->post_author;
										$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
										/*PostMultiCurrencycheck*/
										$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
										if(!empty($post_currency_tag)){
											$classieraCurrencyTag = classiera_Display_currency_sign($post_currency_tag);
										}else{
											global $redux_demo;
											$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
										}
										$featuredPosts[] = $post->ID;
										/*PostMultiCurrencycheck*/
									?>
									<div class="col-lg-4 col-md-4 col-sm-6 match-height item <?php echo $classieraItemClass; ?>">
										<div class="classiera-box-div classiera-box-div-v1">
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
														<a href="<?php the_permalink(); ?>" class="btn btn-primary outline btn-sm active"><?php esc_html_e( 'view ad', 'classiera' ); ?></a>
													</span>
													<span class="classiera-buy-sel">
														<?php classiera_buy_sell($classiera_ads_type); ?>
													</span>
												</div><!--Premium-IMG-->
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
									</div>									
									<?php endwhile; ?>
									<?php wp_reset_query(); ?>
									 <?php wp_reset_postdata(); ?>
									<!--RegularAds-->
									<?php
										
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}
										$args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
										$args = wp_parse_args($wp->matched_query);
										$temp = $wp_query;										
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'paged' => $paged,
											'post__not_in' => $featuredPosts,
											's'   => $keyword,
											'posts_per_page' => 10,
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$SearchQueryCountry,											
												$SearchQueryState,											
												$SearchQueryCity,
												$searchCondition,
												$searchQueryCustomFields,
											),
										);										
										$wp_query = new WP_Query($args);										
										while ($wp_query->have_posts()) : $wp_query->the_post();
										$emptyPost++;
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
										$post_location = get_post_meta($post->ID, 'post_location', true);
										$post_state = get_post_meta($post->ID, 'post_state', true);
										$post_city = get_post_meta($post->ID, 'post_city', true);
										$post_price = get_post_meta($post->ID, 'post_price', true);
										$theTitle = get_the_title();
										$postCatgory = get_the_category( $post->ID );
										$categoryLink = get_category_link($catID);
										$featured_post = get_post_meta($post->ID, 'featured_post', true);
										$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
										$classieraPostAuthor = $post->post_author;
										$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
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
														<a href="<?php the_permalink(); ?>" class="btn btn-primary outline btn-sm active"><?php esc_html_e( 'view ad', 'classiera' ); ?></a>
													</span>
													<span class="classiera-buy-sel">
														<?php classiera_buy_sell($classiera_ads_type); ?>
													</span>
												</div><!--Premium-IMG-->
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
									</div>									
									<?php endwhile; ?>
									<?php wp_reset_postdata(); ?>
									
									<?php //wp_reset_query(); ?>
									<!--RegularAds-->
									<?php if(empty($emptyPost) || $emptyPost == 0){ ?>
									<div class="col-lg-12 col-md-12 col-sm-12 text-center">
										<h5><?php esc_html_e( 'No results found for the selected search criteria.', 'classiera' ); ?></h5>
									</div>
									<?php } ?>
									</div><!--row-->
									<?php
									  if ( function_exists('classiera_pagination') ){
										classiera_pagination();
									  }
									?>
								</div><!--container-->
							</div><!--tabpanel-->
						</div><!--tab-content-->
					</div>
				</section>
				<!-- end advertisement style 1-->
				<?php }elseif($classieraCategoriesStyle == 2){?>
				<section class="classiera-advertisement advertisement-v2 section-pad-top-100">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-8">
                                        <div class="total-post">
										<?php 
										global $paged, $wp_query, $wp;								
										$args = wp_parse_args($wp->matched_query);
										$temp = $wp_query;
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											's'   => $keyword,
											'posts_per_page' => -1,
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$SearchQueryCountry,											
												$SearchQueryState,											
												$SearchQueryCity,
												$searchCondition,
												$searchQueryCustomFields,
											),
										);
										$wp_query= null;
										$wp_query = new WP_Query($args);
										$count = $wp_query->post_count;
										?>
                                            <p> <?php echo $count; ?>
											<?php esc_html_e( 'Ads Founded', 'classiera') ?> : 
												<span>
												<?php esc_html_e( 'Related to your search', 'classiera') ?>
												</span>
											</p>
											<?php wp_reset_query(); ?>
											<?php wp_reset_postdata(); ?>
                                        </div>
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
										$temp = $wp_query;										
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											's'   => $keyword,
											'posts_per_page' => -1,											
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$SearchQueryCountry,											
												$SearchQueryState,											
												$SearchQueryCity,
												$searchCondition,
												$searchQueryCustomFields,
												array(
													'key' => 'featured_post',
													'value' => '1',
													'compare' => '=='
												),
												
											),
										);
										//print_r($args);
										$wp_query= null;
										$wp_query = new WP_Query($args);
										while ($wp_query->have_posts()) : $wp_query->the_post();
										$emptyPost++;
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
										$post_location = get_post_meta($post->ID, 'post_location', true);
										$post_state = get_post_meta($post->ID, 'post_state', true);
										$post_city = get_post_meta($post->ID, 'post_city', true);
										$post_price = get_post_meta($post->ID, 'post_price', true);
										$theTitle = get_the_title();
										$postCatgory = get_the_category( $post->ID );
										$categoryLink = get_category_link($catID);
										$featured_post = get_post_meta($post->ID, 'featured_post', true);
										$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
										$classieraPostAuthor = $post->post_author;
										$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
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
									if($featured_post == 1){	
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
															<img src="<?php echo $classieraCatIcoIMG; ?>" alt="<?php echo $postCatgory[0]->name; ?>">
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
									<?php } ?>
									<?php endwhile; ?>
									<?php wp_reset_query(); ?>
									<?php wp_reset_postdata(); ?>
									<?php
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}										
										$args = wp_parse_args($wp->matched_query);
										$temp = $wp_query;
										//$wp_query= null;
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'paged' => $paged,
											'post__not_in' => $featuredPosts,
											's'   => $keyword,
											'posts_per_page' => 10,
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$SearchQueryCountry,											
												$SearchQueryState,											
												$SearchQueryCity,
												$searchCondition,
												$searchQueryCustomFields,
											),
										);										
										$wp_query= null;
										//$args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
										$wp_query = new WP_Query($args);
										while ($wp_query->have_posts()) : $wp_query->the_post();
										$emptyPost++;
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
										$post_location = get_post_meta($post->ID, 'post_location', true);
										$post_state = get_post_meta($post->ID, 'post_state', true);
										$post_city = get_post_meta($post->ID, 'post_city', true);
										$post_price = get_post_meta($post->ID, 'post_price', true);
										$theTitle = get_the_title();
										$postCatgory = get_the_category( $post->ID );
										$categoryLink = get_category_link($catID);
										$featured_post = get_post_meta($post->ID, 'featured_post', true);
										$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
										$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
										$classieraPostAuthor = $post->post_author;
										$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
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
															<img src="<?php echo $classieraCatIcoIMG; ?>" alt="<?php echo $postCatgory[0]->name; ?>">
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
				<!-- end advertisement style 2-->
				<?php }elseif($classieraCategoriesStyle == 3){?>
				<section class="classiera-advertisement advertisement-v3 section-pad-top-100">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-8">
										<div class="total-post">
										<?php 
										global $paged, $wp_query, $wp;								
										$args = wp_parse_args($wp->matched_query);
										$temp = $wp_query;
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											's'   => $keyword,
											'posts_per_page' => -1,
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$SearchQueryCountry,											
												$SearchQueryState,											
												$SearchQueryCity,
												$searchCondition,
												$searchQueryCustomFields,
											),
										);
										$wp_query= null;
										$wp_query = new WP_Query($args);
										$count = $wp_query->post_count;
										?>
                                            <p> <?php echo $count; ?>
											<?php esc_html_e( 'Ads Founded', 'classiera') ?> : 
												<span>
												<?php esc_html_e( 'Related to your search', 'classiera') ?>
												</span>
											</p>
											<?php wp_reset_query(); ?>
											<?php wp_reset_postdata(); ?>
                                        </div>
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
										$temp = $wp_query;
										//$wp_query= null;
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											's'   => $keyword,
											'posts_per_page' => -1,											
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$SearchQueryCountry,											
												$SearchQueryState,											
												$SearchQueryCity,
												$searchCondition,
												$searchQueryCustomFields,
												array(
													'key' => 'featured_post',
													'value' => '1',
													'compare' => '=='
												),
												
											),
										);
										//print_r($args);
										$wp_query= null;
										$wp_query = new WP_Query($args);
										while ($wp_query->have_posts()) : $wp_query->the_post();
										$emptyPost++;
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
										$post_location = get_post_meta($post->ID, 'post_location', true);
										$post_state = get_post_meta($post->ID, 'post_state', true);
										$post_city = get_post_meta($post->ID, 'post_city', true);
										$post_price = get_post_meta($post->ID, 'post_price', true);
										$theTitle = get_the_title();
										$postCatgory = get_the_category( $post->ID );
										$categoryLink = get_category_link($catID);
										$featured_post = get_post_meta($post->ID, 'featured_post', true);
										$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
										$classieraPostAuthor = $post->post_author;
										$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
										/*PostMultiCurrencycheck*/
										$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
										if(!empty($post_currency_tag)){
											$classieraCurrencyTag = classiera_Display_currency_sign($post_currency_tag);
										}else{
											global $redux_demo;
											$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
										}
										$featuredPosts[] = $post->ID;
										/*PostMultiCurrencycheck*/
									if($featured_post == 1){	
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
									<?php } ?>
									<?php endwhile; ?>
									<?php wp_reset_query(); ?>
									<?php wp_reset_postdata(); ?>
									<?php
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}										
										$args = wp_parse_args($wp->matched_query);
										$temp = $wp_query;
										//$wp_query= null;
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'paged' => $paged,
											'post__not_in' => $featuredPosts,
											's'   => $keyword,
											'posts_per_page' => 10,
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$SearchQueryCountry,											
												$SearchQueryState,											
												$SearchQueryCity,
												$searchCondition,
												$searchQueryCustomFields,
											),
										);
										$wp_query= null;
										//$args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
										$wp_query = new WP_Query($args);
										while ($wp_query->have_posts()) : $wp_query->the_post();
										$emptyPost++;
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
										$post_location = get_post_meta($post->ID, 'post_location', true);
										$post_state = get_post_meta($post->ID, 'post_state', true);
										$post_city = get_post_meta($post->ID, 'post_city', true);
										$post_price = get_post_meta($post->ID, 'post_price', true);
										$theTitle = get_the_title();
										$postCatgory = get_the_category( $post->ID );
										$categoryLink = get_category_link($catID);
										$featured_post = get_post_meta($post->ID, 'featured_post', true);
										$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
										$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
										$classieraPostAuthor = $post->post_author;
										$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
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
				<!-- end advertisement style 3-->
				<?php }elseif($classieraCategoriesStyle == 4){?>
				<section class="classiera-advertisement advertisement-v4 section-pad-top-100">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-8 col-xs-12">
										<div class="total-post">
										<?php 
										global $paged, $wp_query, $wp;								
										$args = wp_parse_args($wp->matched_query);
										$temp = $wp_query;
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											's'   => $keyword,
											'posts_per_page' => -1,
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$SearchQueryCountry,											
												$SearchQueryState,											
												$SearchQueryCity,
												$searchCondition,
												$searchQueryCustomFields,
											),
										);
										$wp_query= null;
										$wp_query = new WP_Query($args);
										$count = $wp_query->post_count;
										?>
                                            <p> <?php echo $count; ?>
											<?php esc_html_e( 'Ads Founded', 'classiera') ?> : 
												<span>
												<?php esc_html_e( 'Related to your search', 'classiera') ?>
												</span>
											</p>
											<?php wp_reset_query(); ?>
											<?php wp_reset_postdata(); ?>
                                        </div>
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
										?>
										<?php
										global $paged, $wp_query, $wp;										
										$args = wp_parse_args($wp->matched_query);
										$temp = $wp_query;
										//$wp_query= null;
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											's'   => $keyword,
											'posts_per_page' => -1,											
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$SearchQueryCountry,											
												$SearchQueryState,											
												$SearchQueryCity,
												$searchCondition,
												$searchQueryCustomFields,
												array(
													'key' => 'featured_post',
													'value' => '1',
													'compare' => '=='
												),
												
											),
										);
										//print_r($args);
										$wp_query= null;
										$wp_query = new WP_Query($args);
										while ($wp_query->have_posts()) : $wp_query->the_post();
										$emptyPost++;
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
										$post_location = get_post_meta($post->ID, 'post_location', true);
										$post_state = get_post_meta($post->ID, 'post_state', true);
										$post_city = get_post_meta($post->ID, 'post_city', true);
										$post_price = get_post_meta($post->ID, 'post_price', true);
										$theTitle = get_the_title();
										$postCatgory = get_the_category( $post->ID );
										$categoryLink = get_category_link($catID);
										$featured_post = get_post_meta($post->ID, 'featured_post', true);
										$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
										$classieraPostAuthor = $post->post_author;
										$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
										/*PostMultiCurrencycheck*/
										$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
										if(!empty($post_currency_tag)){
											$classieraCurrencyTag = classiera_Display_currency_sign($post_currency_tag);
										}else{
											global $redux_demo;
											$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
										}
										$featuredPosts[] = $post->ID;
										/*PostMultiCurrencycheck*/
									if($featured_post == 1){	
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
									<?php } ?>
									<?php endwhile; ?>
									<?php wp_reset_query(); ?>
									<?php wp_reset_postdata(); ?>
									<?php
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}										
										$args = wp_parse_args($wp->matched_query);
										$temp = $wp_query;
										//$wp_query= null;
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'paged' => $paged,
											'post__not_in' => $featuredPosts,
											's'   => $keyword,
											'posts_per_page' => 10,
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$SearchQueryCountry,											
												$SearchQueryState,											
												$SearchQueryCity,
												$searchCondition,
												$searchQueryCustomFields,
											),
										);
										$wp_query= null;
										//$args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
										$wp_query = new WP_Query($args);
										while ($wp_query->have_posts()) : $wp_query->the_post();
										$emptyPost++;
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
										$post_location = get_post_meta($post->ID, 'post_location', true);
										$post_state = get_post_meta($post->ID, 'post_state', true);
										$post_city = get_post_meta($post->ID, 'post_city', true);
										$post_price = get_post_meta($post->ID, 'post_price', true);
										$theTitle = get_the_title();
										$postCatgory = get_the_category( $post->ID );
										$categoryLink = get_category_link($catID);
										$featured_post = get_post_meta($post->ID, 'featured_post', true);
										$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
										$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
										$classieraPostAuthor = $post->post_author;
										$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
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
				<!-- end advertisement style 4-->
				<?php }elseif($classieraCategoriesStyle == 5){?>
				<section class="classiera-advertisement advertisement-v5 section-pad-80 border-bottom">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-7 col-xs-8">
										<div class="total-post">
										<?php 
										global $paged, $wp_query, $wp;								
										$args = wp_parse_args($wp->matched_query);
										$temp = $wp_query;
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											's'   => $keyword,
											'posts_per_page' => -1,
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$SearchQueryCountry,											
												$SearchQueryState,											
												$SearchQueryCity,
												$searchCondition,
												$searchQueryCustomFields,
											),
										);
										$wp_query= null;
										$wp_query = new WP_Query($args);
										$count = $wp_query->post_count;
										?>
                                            <p> <?php echo $count; ?>
											<?php esc_html_e( 'Ads Founded', 'classiera') ?> : 
												<span>
												<?php esc_html_e( 'Related to your search', 'classiera') ?>
												</span>
											</p>
											<?php wp_reset_query(); ?>
											<?php wp_reset_postdata(); ?>
                                        </div>
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
										global $paged, $wp_query, $wp;										
										$args = wp_parse_args($wp->matched_query);
										$temp = $wp_query;
										//$wp_query= null;
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											's'   => $keyword,
											'posts_per_page' => -1,											
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$SearchQueryCountry,											
												$SearchQueryState,											
												$SearchQueryCity,
												$searchCondition,
												$searchQueryCustomFields,
												array(
													'key' => 'featured_post',
													'value' => '1',
													'compare' => '=='
												),
												
											),
										);
										//print_r($args);
										$wp_query= null;
										$wp_query = new WP_Query($args);
										while ($wp_query->have_posts()) : $wp_query->the_post();
										$emptyPost++;
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
										$post_location = get_post_meta($post->ID, 'post_location', true);
										$post_state = get_post_meta($post->ID, 'post_state', true);
										$post_city = get_post_meta($post->ID, 'post_city', true);
										$post_price = get_post_meta($post->ID, 'post_price', true);
										$theTitle = get_the_title();
										$postCatgory = get_the_category( $post->ID );
										$categoryLink = get_category_link($catID);
										$featured_post = get_post_meta($post->ID, 'featured_post', true);
										$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
										$classieraPostAuthor = $post->post_author;
										$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
										/*PostMultiCurrencycheck*/
										$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
										if(!empty($post_currency_tag)){
											$classieraCurrencyTag = classiera_Display_currency_sign($post_currency_tag);
										}else{
											global $redux_demo;
											$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
										}
										$featuredPosts[] = $post->ID;
										/*PostMultiCurrencycheck*/
									if($featured_post == 1){	
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
									<?php } ?>
									<?php endwhile; ?>
									<?php wp_reset_query(); ?>
									<?php wp_reset_postdata(); ?>
									<?php
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}										
										$args = wp_parse_args($wp->matched_query);
										$temp = $wp_query;
										//$wp_query= null;
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'paged' => $paged,
											'post__not_in' => $featuredPosts,
											's'   => $keyword,
											'posts_per_page' => 10,
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$SearchQueryCountry,											
												$SearchQueryState,											
												$SearchQueryCity,
												$searchCondition,
												$searchQueryCustomFields,
											),
										);
										$wp_query= null;
										//$args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
										$wp_query = new WP_Query($args);
										while ($wp_query->have_posts()) : $wp_query->the_post();
										$emptyPost++;
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
										$post_location = get_post_meta($post->ID, 'post_location', true);
										$post_state = get_post_meta($post->ID, 'post_state', true);
										$post_city = get_post_meta($post->ID, 'post_city', true);
										$post_price = get_post_meta($post->ID, 'post_price', true);
										$theTitle = get_the_title();
										$postCatgory = get_the_category( $post->ID );
										$categoryLink = get_category_link($catID);
										$featured_post = get_post_meta($post->ID, 'featured_post', true);
										$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
										$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
										$classieraPostAuthor = $post->post_author;
										$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
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
				<!-- end advertisement style 5-->
				<?php }elseif($classieraCategoriesStyle == 6){?>
				<section class="classiera-advertisement advertisement-v6 section-pad border-bottom">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-8">
										<div class="total-post">
										<?php 
										global $paged, $wp_query, $wp;								
										$args = wp_parse_args($wp->matched_query);
										$temp = $wp_query;
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											's'   => $keyword,
											'posts_per_page' => -1,
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$SearchQueryCountry,											
												$SearchQueryState,											
												$SearchQueryCity,
												$searchCondition,
												$searchQueryCustomFields,
											),
										);
										$wp_query= null;
										$wp_query = new WP_Query($args);
										$count = $wp_query->post_count;
										?>
                                            <p> <?php echo $count; ?>
											<?php esc_html_e( 'Ads Founded', 'classiera') ?> : 
												<span>
												<?php esc_html_e( 'Related to your search', 'classiera') ?>
												</span>
											</p>
											<?php wp_reset_query(); ?>
											<?php wp_reset_postdata(); ?>
                                        </div>
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
										$temp = $wp_query;
										//$wp_query= null;
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											's'   => $keyword,
											'posts_per_page' => -1,											
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$SearchQueryCountry,											
												$SearchQueryState,											
												$SearchQueryCity,
												$searchCondition,
												$searchQueryCustomFields,
												array(
													'key' => 'featured_post',
													'value' => '1',
													'compare' => '=='
												),
												
											),
										);
										//print_r($args);
										$wp_query= null;
										$wp_query = new WP_Query($args);
										while ($wp_query->have_posts()) : $wp_query->the_post();
										$emptyPost++;
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
										$post_location = get_post_meta($post->ID, 'post_location', true);
										$post_state = get_post_meta($post->ID, 'post_state', true);
										$post_city = get_post_meta($post->ID, 'post_city', true);
										$post_price = get_post_meta($post->ID, 'post_price', true);
										$theTitle = get_the_title();
										$postCatgory = get_the_category( $post->ID );
										$categoryLink = get_category_link($catID);
										$featured_post = get_post_meta($post->ID, 'featured_post', true);
										$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
										$classieraPostAuthor = $post->post_author;
										$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
										/*PostMultiCurrencycheck*/
										$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
										if(!empty($post_currency_tag)){
											$classieraCurrencyTag = classiera_Display_currency_sign($post_currency_tag);
										}else{
											global $redux_demo;
											$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
										}
										$featuredPosts[] = $post->ID;
										/*PostMultiCurrencycheck*/
									if($featured_post == 1){	
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
									<?php } ?>
									<?php endwhile; ?>
									<?php wp_reset_query(); ?>
									<?php wp_reset_postdata(); ?>
									<?php
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}										
										$args = wp_parse_args($wp->matched_query);
										$temp = $wp_query;
										//$wp_query= null;
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'paged' => $paged,
											'post__not_in' => $featuredPosts,
											's'   => $keyword,
											'posts_per_page' => 10,
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$SearchQueryCountry,											
												$SearchQueryState,											
												$SearchQueryCity,
												$searchCondition,
												$searchQueryCustomFields,
											),
										);
										$wp_query= null;
										//$args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
										$wp_query = new WP_Query($args);
										while ($wp_query->have_posts()) : $wp_query->the_post();
										$emptyPost++;
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
										$post_location = get_post_meta($post->ID, 'post_location', true);
										$post_state = get_post_meta($post->ID, 'post_state', true);
										$post_city = get_post_meta($post->ID, 'post_city', true);
										$post_price = get_post_meta($post->ID, 'post_price', true);
										$theTitle = get_the_title();
										$postCatgory = get_the_category( $post->ID );
										$categoryLink = get_category_link($catID);
										$featured_post = get_post_meta($post->ID, 'featured_post', true);
										$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
										$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
										$classieraPostAuthor = $post->post_author;
										$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
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
				<!-- end advertisement style 6-->
				<?php }elseif($classieraCategoriesStyle == 7){?>
				<section class="classiera-advertisement advertisement-v6 advertisement-v7 section-pad border-bottom">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-8">
										<div class="total-post">
										<?php 
										global $paged, $wp_query, $wp;								
										$args = wp_parse_args($wp->matched_query);
										$temp = $wp_query;
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											's'   => $keyword,
											'posts_per_page' => -1,
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$SearchQueryCountry,											
												$SearchQueryState,											
												$SearchQueryCity,
												$searchCondition,
												$searchQueryCustomFields,
											),
										);
										$wp_query= null;
										$wp_query = new WP_Query($args);
										$count = $wp_query->post_count;
										?>
                                            <p> <?php echo $count; ?>
											<?php esc_html_e( 'Ads Founded', 'classiera') ?> : 
												<span>
												<?php esc_html_e( 'Related to your search', 'classiera') ?>
												</span>
											</p>
											<?php wp_reset_query(); ?>
											<?php wp_reset_postdata(); ?>
                                        </div>
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
										$temp = $wp_query;
										//$wp_query= null;
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											's'   => $keyword,
											'posts_per_page' => -1,											
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$SearchQueryCountry,											
												$SearchQueryState,											
												$SearchQueryCity,
												$searchCondition,
												$searchQueryCustomFields,
												array(
													'key' => 'featured_post',
													'value' => '1',
													'compare' => '=='
												),
												
											),
										);
										//print_r($args);
										$wp_query= null;
										$wp_query = new WP_Query($args);
										while ($wp_query->have_posts()) : $wp_query->the_post();
										$emptyPost++;
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
										$post_location = get_post_meta($post->ID, 'post_location', true);
										$post_state = get_post_meta($post->ID, 'post_state', true);
										$post_city = get_post_meta($post->ID, 'post_city', true);
										$post_price = get_post_meta($post->ID, 'post_price', true);
										$theTitle = get_the_title();
										$postCatgory = get_the_category( $post->ID );
										$categoryLink = get_category_link($catID);
										$featured_post = get_post_meta($post->ID, 'featured_post', true);
										$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
										$classieraPostAuthor = $post->post_author;
										$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
										/*PostMultiCurrencycheck*/
										$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
										if(!empty($post_currency_tag)){
											$classieraCurrencyTag = classiera_Display_currency_sign($post_currency_tag);
										}else{
											global $redux_demo;
											$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
										}
										$featuredPosts[] = $post->ID;
										/*PostMultiCurrencycheck*/
									if($featured_post == 1){	
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
									<?php } ?>
									<?php endwhile; ?>
									<?php wp_reset_query(); ?>
									<?php wp_reset_postdata(); ?>
									<?php
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}										
										$args = wp_parse_args($wp->matched_query);
										$temp = $wp_query;
										//$wp_query= null;
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'paged' => $paged,
											'post__not_in' => $featuredPosts,
											's'   => $keyword,
											'posts_per_page' => 10,
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$SearchQueryCountry,											
												$SearchQueryState,											
												$SearchQueryCity,
												$searchCondition,
												$searchQueryCustomFields,
											),
										);
										$wp_query= null;
										//$args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
										$wp_query = new WP_Query($args);
										while ($wp_query->have_posts()) : $wp_query->the_post();
										$emptyPost++;
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
										$post_location = get_post_meta($post->ID, 'post_location', true);
										$post_state = get_post_meta($post->ID, 'post_state', true);
										$post_city = get_post_meta($post->ID, 'post_city', true);
										$post_price = get_post_meta($post->ID, 'post_price', true);
										$theTitle = get_the_title();
										$postCatgory = get_the_category( $post->ID );
										$categoryLink = get_category_link($catID);
										$featured_post = get_post_meta($post->ID, 'featured_post', true);
										$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
										$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
										$classieraPostAuthor = $post->post_author;
										$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
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
				<!-- end advertisement style 7-->
				<?php } ?>
			</div>
			<!--ContentArea-->
		</div><!--row-->
	</div><!--container-->	
</section>
<?php get_footer(); ?>