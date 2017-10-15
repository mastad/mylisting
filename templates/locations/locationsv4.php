<?php 
	global $redux_demo;
	$home_location_disable = $redux_demo['home-location-disable'];
	$locationTitle = $redux_demo['locations-sec-title'];
	$locationDesc = $redux_demo['locations-desc'];
	$locShownBy = $redux_demo['location-shown-by'];
?>
<section class="locations locations-v5 section-pad-80 border-bottom">
	<div class="section-heading-v5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 center-block">
                    <h3 class="text-capitalize"><?php echo $locationTitle; ?></h3>
                    <p><?php echo $locationDesc; ?></p>
                </div><!--col-lg-8 col-md-8 center-block-->
            </div><!--row-->
        </div><!--container-->
    </div><!--section-heading-v1-->
	<div class="location-content-v5">
		<div class="container">
			<ul class="list-inline list-unstyled">
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
				foreach ($directors as $director) {				
					if(!empty($director)){
				/*Get Locations Data End */
			?>
				<li>			
					<div class="location-content match-height">
						<!--<div class="location-content-img">
                            <img class="svg" src="images/location.svg" alt="classiera-design">
                        </div>-->
						<i class="fa fa-map-marker fa-4x"></i>
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
						<h5><a href="<?php echo $locationURL; ?><?php echo $director; ?>"><?php echo $director; ?></a></h5>
                    </div>
				</li>
			<?php }}?>
			<?php wp_reset_query(); ?>
			</ul><!--container-->
		</div><!--container-->
	</div><!--location-content-->
	<div class="load-more text-center">
        <a href="#" class="btn btn-primary outline btn-md btn-style-five">
			<?php esc_html_e( 'View All', 'classiera' ); ?>
		</a>
    </div>
</section>