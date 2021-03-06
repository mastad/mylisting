<?php 
	global $redux_demo;
	$locationTitle = $redux_demo['locations-sec-title'];
	$locationDesc = $redux_demo['locations-desc'];
	$locShownBy = $redux_demo['location-shown-by'];
	$homeLocCounter = $redux_demo['home-location-counter'];
?>
<section class="locations section-pad border-bottom">
	<div class="section-heading-v1">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 center-block">
                    <h3 class="text-uppercase"><?php echo $locationTitle; ?></h3>
                    <p><?php echo $locationDesc; ?></p>
                </div><!--col-lg-8 col-md-8 center-block-->
            </div><!--row-->
        </div><!--container-->
    </div><!--section-heading-v1-->
	<div class="location-content">
		<div class="container">
			<div class="row">
				<?php 
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
				$args_location = array( 'posts_per_page' => -1 );
				$lastposts = get_posts( $args_location );
				$all_post_location = array();
				foreach( $lastposts as $post ) {
					$all_post_location[] = get_post_meta( $post->ID, $locShownBy, true );
				}
				//print_r($all_post_location);
				$directors = array_unique($all_post_location);
				$count = 0;
				foreach ($directors as $director) {				
					if(!empty($director) && $count <= $homeLocCounter){
				/*Get Locations Data End */
			?>
				<div class="col-sm-6 col-md-6 col-lg-3">
					<div class="location">
						<span class="location-icon" style="color: #b6d91a;">
							<i class="fa fa-map-marker"></i>
							<span class="tip"></span>
						</span>
						<?php
						$args = array(
							'post_type' => 'post',
							'post_status' => 'publish',
							'posts_per_page' => -1,
							'meta_query' => array(								
								array(
									'key' => $locShownBy,
									'value' => $director,
									'type' => 'LIKE'
								),
							),
						);
						$myQuery = new WP_Query($args);
						$countposts = $myQuery->found_posts;
						?>
                        <a href="<?php echo $locationURL; ?><?php echo $director; ?>">
                            <span class="loc-head"><?php echo $director; ?></span>
                            <span><?php echo $countposts; ?>&nbsp;<?php esc_html_e( 'Ads posted', 'classiera' ); ?></span>
                        </a>
                    </div>
				</div>
			<?php 
				}$count++;
			}
			?>
			<?php wp_reset_query(); ?>
			</div><!--container-->
		</div><!--container-->
	</div><!--location-content-->
</section>