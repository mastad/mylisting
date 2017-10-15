<?php 
	global $redux_demo;
	$home_location_disable = $redux_demo['home-location-disable'];
	$locationTitle = $redux_demo['locations-sec-title'];
	$locationDesc = $redux_demo['locations-desc'];
	$locShownBy = $redux_demo['location-shown-by'];
	/*Get Locations Data Start */
	$locationTemplate = $wpdb->get_results("SELECT `post_id` FROM $wpdb->postmeta WHERE `meta_key` ='_wp_page_template' AND `meta_value` = 'template-locations.php' ", ARRAY_A);
	$locationTemplatePermalink ="";
	if(!empty($locationTemplate)){
	$locationTemplatePermalink = get_permalink($locationTemplate[0]['post_id']);
	}
	global $wp_rewrite;
	if ($wp_rewrite->permalink_structure == ''){
	//we are using ?page_id
	$locationURL = $locationTemplatePermalink."&location=";
	}else{
	//we are using permalinks
	$locationURL = $locationTemplatePermalink."?location=";
	}
?>
<section class="locations locations-v6 section-pad">
	<div class="section-heading-v6">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 center-block">
                    <h1 class="text-capitalize"><?php echo $locationTitle; ?></h1>
                    <p><?php echo $locationDesc; ?></p>
                </div>
            </div>
        </div>
    </div><!--section-heading-v6-->
	<div class="location-content-v6">
		<div class="container">
			<div class="row">
				<?php 
					$classieraClass = 'col-lg-6';
					$args = array(
						'posts_per_page'   => -1,
						'post_type'        => 'countries',
						'suppress_filters' => false,
						'post_status'      => 'publish',
					);
					$classieraAllCountries =  get_posts( $args );
					if(!empty($classieraAllCountries)){
						$current = 1;
						foreach ( $classieraAllCountries as $country ) : setup_postdata( $country );
							$countryName = $country->post_title;							
							if($current == 1 || $current == 2){
								$classieraClass = 'col-lg-6';
							}elseif($current == 3 || $current == 4 || $current == 5){
								$classieraClass = 'col-lg-4';
							}
							if($current == 5){
								$current = 0;
							}
							?>
							<div class="<?php echo $classieraClass;?> col-sm-6">
								<figure class="location">
									<?php echo get_the_post_thumbnail($country->ID);?>
									<figcaption>
										<div class="location-caption">
											<span><i class="fa fa-map-marker"></i></span>
										</div>
										<div class="location-caption">
											<h4><a href="#"><?php echo $countryName; ?></a></h4>
											<p>
												<?php 
												$countargs = array(
													'posts_per_page'   => -1,
													'post_type'        => 'post',
													'post_status'      => 'publish',
													'suppress_filters' => true,
													'meta_query' => array(
														array(
															'key' => 'post_location',
															'value' => $countryName,
														)
													)
												);
												//print_r($countargs);
												$classieraAllPCount =  get_posts($countargs);
												//print_r($classieraAllPCount);
												$totalPosts = count($classieraAllPCount);
												?>
												<?php echo $totalPosts; ?>&nbsp;<?php esc_html_e( 'ads posted in this location', 'classiera' ); ?>
											</p>
											<a href="<?php echo $locationURL.$countryName;;?>"><?php esc_html_e( 'View All Ads in', 'classiera' ); ?>&nbsp;<?php echo $countryName; ?> <i class="fa fa-long-arrow-<?php if(is_rtl()){echo "left";}else{echo "right";}?>"></i></a>
										</div>
									</figcaption>
								</figure>
							</div>
							<?php
							$current++;
						endforeach; 
						wp_reset_postdata();
					}
				?>
			</div>
		</div>
	</div>
</section>