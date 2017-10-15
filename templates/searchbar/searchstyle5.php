<?php 
	global $redux_demo;
	$classieraMaxPrice = $redux_demo['classiera_max_price_input'];
	$classieraLocationSearch = $redux_demo['classiera_search_location_on_off'];
	$classieraPriceRange = $redux_demo['classiera_pricerange_on_off'];
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
<section class="search-section search-section-v5" style="background: #39444c;">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<form data-toggle="validator" role="form" class="search-form search-form-v5 form-inline" action="<?php echo home_url(); ?>" method="get">
					<!--Select Category-->					
					<div class="form-group clearfix">
						<div class="input-group side-by-side-input inner-addon right-addon pull-left flip">
							<i class="form-icon form-icon-size-small fa fa-sort"></i>							
							<select class="form-control form-control-sm" name="category_name" id="ajaxSelectCat">
								<option value="-1" selected disabled><?php esc_html_e('All Categories', 'classiera'); ?></option>
								<?php 
								$args = array(
									'hierarchical' => '0',
									'hide_empty' => '0'
								);
								$categories = get_categories($args);
								foreach ($categories as $cat) {
									if($cat->category_parent == 0){
										$catID = $cat->cat_ID;
										?>
									<option value="<?php echo $cat->slug; ?>"><?php echo $cat->cat_name; ?></option>	
										<?php
										$args2 = array(
											'hide_empty' => '0',
											'parent' => $catID
										);
										$categories = get_categories($args2);
										foreach($categories as $cat){
											?>
										<option value="<?php echo $cat->slug; ?>">- <?php echo $cat->cat_name; ?></option>	
											<?php
										}
									}
								}
								?>
							</select>
						</div>
						<div class="side-by-side-input pull-left flip classieraAjaxInput">
							<input type="text" name="s" id="classieraSearchAJax" class="form-control form-control-sm" placeholder="<?php esc_html_e( 'Enter keyword...', 'classiera' ); ?>" data-error="<?php esc_html_e( 'Please Type some words..!', 'classiera' ); ?>">
							<div class="help-block with-errors"></div>
							<span class="classieraSearchLoader"><img src="<?php echo get_template_directory_uri().'/images/loader.gif' ?>" alt="classiera loader"></span>
							<div class="classieraAjaxResult"></div>
						</div>
					</div>					
					<!--Select Category-->
					<!--Locations-->
					<?php if($classieraLocationSearch == 1){?>
					<div class="form-group">
                       <div class="input-group inner-addon right-addon">
                            <div class="input-group-addon input-group-addon-width-sm"><i class="fa fa-map-marker"></i></div>
                            <input type="text" id="getCity" name="post_location" class="form-control form-control-sm" placeholder="<?php esc_html_e('Address or Location', 'classiera'); ?>">
							<a id="getLocation" href="#" class="form-icon form-icon-size-small" title="<?php esc_html_e('Click here to get your own location', 'classiera'); ?>">
								<i class="fa fa-crosshairs"></i>
							</a>
                        </div>
                    </div>
					<?php } ?>
					<!--Locations-->
					<!--PriceRange-->
					<?php if($classieraPriceRange == 1){?>
					<div class="form-group clearfix">
						<div class="inner-addon right-addon">
							<i class="form-icon form-icon-size-small fa fa-sort"></i>
							<select class="form-control form-control-sm" data-placeholder="<?php esc_html_e('Select price range', 'classiera'); ?>" name="price_range">
								<option value="-1" selected disabled><?php esc_html_e('select price range', 'classiera'); ?></option>
								<option value="<?php echo "0,".$startPrice; ?>">0 - <?php echo $startPrice; ?></option>
								<option value="<?php echo $startPrice.','.$secondPrice; ?>"><?php echo $startPrice+1; ?> - <?php echo $secondPrice; ?></option>
								<option value="<?php echo $secondPrice.','.$thirdPrice; ?>"><?php echo $secondPrice+1; ?> - <?php echo $thirdPrice; ?></option>
								<option value="<?php echo $thirdPrice.','.$fourthPrice; ?>"><?php echo $thirdPrice+1; ?> - <?php echo $fourthPrice; ?></option>
								<option value="<?php echo $fourthPrice.','.$fivePrice; ?>"><?php echo $fourthPrice+1; ?> - <?php echo $fivePrice; ?></option>
								<option value="<?php echo $fivePrice.','.$sixPrice; ?>"><?php echo $fivePrice+1; ?> - <?php echo $sixPrice; ?></option>
								<option value="<?php echo $sixPrice.','.$sevenPrice; ?>"><?php echo $sixPrice+1; ?> - <?php echo $sevenPrice; ?></option>
								<option value="<?php echo $sevenPrice.','.$eightPrice; ?>"><?php echo $sevenPrice+1; ?> - <?php echo $eightPrice; ?></option>
								<option value="<?php echo $eightPrice.','.$ninePrice; ?>"><?php echo $eightPrice+1; ?> - <?php echo $ninePrice; ?></option>
								<option value="<?php echo $ninePrice.','.$classieraMaxPrice; ?>"><?php echo $ninePrice+1; ?> - <?php echo $classieraMaxPrice; ?></option>
							</select>
						</div>
					</div>
					<?php } ?>
					<!--PriceRange-->
					<div class="form-group">
						<button class="radius" type="submit" name="search" value="Search"><?php esc_html_e( 'Search Now', 'classiera' ); ?></button>
					</div>
				</form>
			</div><!--col-md-12-->
		</div><!--row-->
	</div><!--container-->
</section><!--search-section-->