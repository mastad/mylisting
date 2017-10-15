<?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	$page_slider = get_post_meta($current_page_id, 'page_slider', true); 
	global $redux_demo, $maximRange; 
	$max_range = $redux_demo['max_range'];
	if(!empty($max_range)) {
		$maximRange = $max_range;
	} else {
		$maximRange = 1000;
	}
	$classieraMAPPostCount = $redux_demo['classiera_map_post_count'];
	$classieraMAPPostType = $redux_demo['classiera_map_post_type'];
	$category_icon_code = "";
	$category_icon_color = "";
	$your_image_url = "";
	$caticoncolor ="";
	$category_icon ="";
?>
<section id="big-map">
	<div class="mainSearch">
	<div id="classiera-main-map"></div>

	<script type="text/javascript">
	var mapDiv,
		map,
		infobox;
	jQuery(document).ready(function($) {

		mapDiv = $("#classiera-main-map");
		mapDiv.height(650).gmap3({
			map: {
				options: {
					"draggable": true
					,"mapTypeControl": true
					,"mapTypeId": google.maps.MapTypeId.ROADMAP
					,"scrollwheel": false
					,"panControl": true
					,"rotateControl": false
					,"scaleControl": true
					,"streetViewControl": true
					,"zoomControl": true
					<?php global $redux_demo; $map_style = $redux_demo['map-style']; if(!empty($map_style)) { ?>,"styles": <?php echo $map_style; ?> <?php } ?>
				}
			}
			,marker: {
				values: [

				<?php

					$wp_query= null;
					if($classieraMAPPostType == 'premium'){
						$args = array(
							'post_type' => 'post',
							'posts_per_page' => -1,								
						);
					}elseif($classieraMAPPostType == 'regular'){
						$args = array(
							'post_type' => 'post',
							'posts_per_page' => $classieraMAPPostCount,								
						);
					}
					

					$wp_query = new WP_Query($args);
					//$wp_query->query('post_type=post&posts_per_page=-1');
					$current = 0;
					while ($wp_query->have_posts()) : $wp_query->the_post(); 

					$post_latitude = get_post_meta($post->ID, 'post_latitude', true);
					$post_longitude = get_post_meta($post->ID, 'post_longitude', true);
					$featuredMeta = get_post_meta($post->ID, 'featured_post', true);
					if($featuredCatOn == 1){
						$featured_post = "1";
					}else{
						$featured_post = "0";
					}
					$post_price_plan_activation_date = get_post_meta($post->ID, 'post_price_plan_activation_date', true);
					$post_price_plan_expiration_date = get_post_meta($post->ID, 'post_price_plan_expiration_date', true);
					$post_price_plan_expiration_date_noarmal = get_post_meta($post->ID, 'post_price_plan_expiration_date_normal', true);
					$todayDate = strtotime(date('m/d/Y h:i:s'));
					$expireDate = $post_price_plan_expiration_date;
					if(!empty($post_price_plan_activation_date) && $featuredMeta == 1) {
						if(($todayDate < $expireDate) or $post_price_plan_expiration_date == 0) {
							$featured_post = "1";
						}
					}elseif($featuredMeta == 1){
						$featured_post = "1";
					}

					$theTitle = get_the_title(); 						

					$post_price = get_post_meta($post->ID, 'post_price', true);


					$category = get_the_category();

					$tag = $category[0]->cat_ID;

						$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
						if (isset($tag_extra_fields[$tag])) {
							$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
							$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
							$your_image_url = $tag_extra_fields[$tag]['your_image_url'];
						}

					if (empty($category_icon_code) || empty($category_icon_color) || empty($your_image_url)) {

						$tag = $category[0]->category_parent;

						$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
						if (isset($tag_extra_fields[$tag])) {
							if (empty($category_icon_code)){
								$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
							}
							if (empty($category_icon_color)){
								$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
							}
							if (empty($your_image_url)){
								$your_image_url = $tag_extra_fields[$tag]['your_image_url'];
							}
						}

					}
					if(!empty($category_icon_code)) {

						$category_icon = stripslashes($category_icon_code);

					 }
					if(!empty($your_image_url)) {

						$iconPath = $your_image_url;

					} else {

						$iconPath = get_template_directory_uri() .'/images/icon-services.png';

					}
					$postCatgory = get_the_category( $post->ID );
					if($classieraMAPPostType == 'premium' && $featured_post == '0'){
						$post_latitude = '';
					}
					if($classieraMAPPostType == 'premium' && $current-1 >= $classieraMAPPostCount){
						$post_latitude = '';
					}

					if(!empty($post_latitude)) {?>

							{
								<?php require_once get_template_directory() . '/inc/BFI_Thumb.php'; ?>
								<?php 
								$imageurl = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'classiera-grid');
								$thumb_id = get_post_thumbnail_id($post->id);
								$alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
								?>
								latLng: [<?php echo $post_latitude; ?>,<?php echo $post_longitude; ?>],
								options: {
									icon: "<?php echo $iconPath; ?>",
									shadow: "<?php echo get_template_directory_uri() ?>/images/shadow.png",
								},
								data: '<section id="advertisement" class="removePad removeMargin noBorder <?php echo $current;?>"><div class="row"><div class="advContent"><div class="tabs-content removeMargin"><div class="large-10 medium-12 small-6 columns advItems end removeMargin"><div class="advItem"> <div class="advItem-img" id="AdvMapImg"><img src="<?php echo $imageurl[0]; ?>" alt="<?php if(empty($alt)){echo "Image";}else{ echo $alt; } ; ?>" /></div><span class="price"><?php echo $post_price; ?></span><a class="hover" href="<?php the_permalink(); ?>"></a><div class="info"><a href="<?php the_permalink(); ?>"><i class="<?php echo $category_icon_code; ?>" style="background-color:<?php echo $category_icon_color; ?>"></i><span class="title"><?php echo $theTitle; ?></span><span class="cat">category &nbsp;:&nbsp;<?php echo $postCatgory[0]->name; ?><span></a></div></div></div></div><div class="close"></div></div></div></section>'
							}
						,

				<?php $current++; } endwhile; ?>	

				<?php wp_reset_query(); ?>
					
				],
				options:{
					draggable: false
				},
				
				events: {
					click: function(marker, event, context){
						map.panTo(marker.getPosition());

						var ibOptions = {
							pixelOffset: new google.maps.Size(-125, -88),
							alignBottom: true
						};

						infobox.setOptions(ibOptions)

						infobox.setContent(context.data);
						infobox.open(map,marker);

						// if map is small
						var iWidth = 370;
						var iHeight = 370;
						if((mapDiv.width() / 2) < iWidth ){
							var offsetX = iWidth - (mapDiv.width() / 2);
							map.panBy(offsetX,0);
						}
						if((mapDiv.height() / 2) < iHeight ){
							var offsetY = -(iHeight - (mapDiv.height() / 2));
							map.panBy(0,offsetY);
						}

					}
				}
			}
						},"autofit");

		map = mapDiv.gmap3("get");
		infobox = new InfoBox({
			pixelOffset: new google.maps.Size(-50, -65),
			closeBoxURL: '',
			enableEventPropagation: true
		});
		mapDiv.delegate('.infoBox .close','click',function () {
			infobox.close();
		});

		if (Modernizr.touch){
			map.setOptions({ draggable : false });
			var draggableClass = 'inactive';
			var draggableTitle = "Activate map";
			var draggableButton = $('<div class="draggable-toggle-button '+draggableClass+'">'+draggableTitle+'</div>').appendTo(mapDiv);
			draggableButton.click(function () {
				if($(this).hasClass('active')){
					$(this).removeClass('active').addClass('inactive').text("Activate map");
					map.setOptions({ draggable : false });
				} else {
					$(this).removeClass('inactive').addClass('active').text("Deactivate map");
					map.setOptions({ draggable : true });
				}
			});
		}

	jQuery( "#advance-search-slider" ).slider({
			range: "min",
			value: 500,
			min: 1,
			max: <?php echo $maximRange; ?>,
			slide: function( event, ui ) {
				jQuery( "#geo-radius" ).val( ui.value );
				jQuery( "#geo-radius-search" ).val( ui.value );

				jQuery( ".geo-location-switch" ).removeClass("off");
				jQuery( ".geo-location-switch" ).addClass("on");
				jQuery( "#geo-location" ).val("on");

				mapDiv.gmap3({
					getgeoloc:{
						callback : function(latLng){
							if (latLng){
								jQuery('#geo-search-lat').val(latLng.lat());
								jQuery('#geo-search-lng').val(latLng.lng());
							}
						}
					}
				});

			}
		});
		jQuery( "#geo-radius" ).val( jQuery( "#advance-search-slider" ).slider( "value" ) );
		jQuery( "#geo-radius-search" ).val( jQuery( "#advance-search-slider" ).slider( "value" ) );

		jQuery('.geo-location-button .fa').click(function()
		{
			
			if(jQuery('.geo-location-switch').hasClass('off'))
			{
				jQuery( ".geo-location-switch" ).removeClass("off");
				jQuery( ".geo-location-switch" ).addClass("on");
				jQuery( "#geo-location" ).val("on");

				mapDiv.gmap3({
					getgeoloc:{
						callback : function(latLng){
							if (latLng){
								jQuery('#geo-search-lat').val(latLng.lat());
								jQuery('#geo-search-lng').val(latLng.lng());
							}
						}
					}
				});

			} else {
				jQuery( ".geo-location-switch" ).removeClass("on");
				jQuery( ".geo-location-switch" ).addClass("off");
				jQuery( "#geo-location" ).val("off");
			}
			   
		});

	});
	</script>
	</div>
</section>