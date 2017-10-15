<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */

get_header();
 ?>

<?php 

	$page = get_page($post->ID);
	$current_page_id = $page->ID;

	$page_slider = get_post_meta($current_page_id, 'page_slider', true); 
	$page_custom_title = get_post_meta($current_page_id, 'page_custom_title', true);

	global $redux_demo;
	$classieraSearchStyle = $redux_demo['classiera_search_style'];
	$classieraPartnersStyle = $redux_demo['classiera_partners_style'];
$caticoncolor="";
$category_icon_code ="";
$category_icon="";
$category_icon_color="";	

?>

<?php if($page_slider == "LayerSlider") : ?>
<?php get_template_part( 'templates/slider/sliderv1' ); ?>

<?php elseif ($page_slider == "Big Map") : ?>

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

						$wp_query = new WP_Query();

						$wp_query->query('post_type=post&posts_per_page=-1');

						


						while ($wp_query->have_posts()) : $wp_query->the_post(); 

						$post_latitude = get_post_meta($post->ID, 'post_latitude', true);
						$post_longitude = get_post_meta($post->ID, 'post_longitude', true);

						$theTitle = get_the_title(); 

						$post_price = get_post_meta($post->ID, 'post_price', true);


						$category = get_the_category();

						$tag = $category[0]->cat_ID;
						$category_icon_code = "";
						$category_icon_color = "";
						$your_image_url = "";
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

						if(!empty($post_latitude)) {?>

							 	{
							 		<?php require_once get_template_directory() . '/inc/BFI_Thumb.php'; ?>
									<?php $params = array( "width" => 470, "height" => 400, "crop" => true ); $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "single-post-thumbnail" ); ?>

									latLng: [<?php echo $post_latitude; ?>,<?php echo $post_longitude; ?>],
									options: {
										icon: "<?php echo $iconPath; ?>",
										shadow: "<?php echo get_template_directory_uri() ?>/images/shadow.png",
									},
									data: '<section id="advertisement" class="removePad removeMargin"><div class="row"><div class="advContent"><div class="tabs-content removeMargin"><div class="large-12 medium-6 columns advItems end removeMargin"><div class="advItem"> <div class="advItem-img" id="AdvMapImg"><img src="<?php echo bfi_thumb( "$image[0]", $params ) ?>" /></div><span class="price"><?php echo $post_price; ?></span><a class="hover" href="<?php the_permalink(); ?>"></a><div class="info"><a href="<?php the_permalink(); ?>"><i class="<?php echo $category_icon_code; ?>" style="background-color:<?php echo $category_icon_color; ?>"></i><span class="title"><?php echo $theTitle; ?></span><span class="cat">category &nbsp;:&nbsp;<?php echo $postCatgory[0]->name; ?><span></a></div></div></div></div><div class="close"></div></div></div></section>'
								}
							,

					<?php } endwhile; ?>	

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

		<?php 

			global $redux_demo; 			

		?>
	

		<!--Search Section Start -->
		<div class="advanceSearch">
			<div class="advSearchBtn"><!--Search bar hide Show Button -->
				<div class="row">
					<a id="searchbtn" href="#">
						<i class="fa fa-search"></i>
						<span><?php esc_html_e( 'Advance Search', 'classiera' ); ?></span>
						<i class="fa fa-caret-down"></i>
					</a>
				</div>
			</div><!--END Search bar hide Show Button -->
			<div class="advSeachBar"><!--AdvSeachBar Start -->
				<div class="row"><!--row Start -->
					<form action="<?php echo home_url(); ?>" method="get" id="views-exposed-form-search-view-other-ads-page" accept-charset="UTF-8">
						<input placeholder="<?php esc_html_e( 'Enter keyword...', 'classiera' ); ?>" type="text" id="edit-search-api-views-fulltext" name="s" value="" size="30" maxlength="128" class="form-text">
						<!--<input type="hidden" id="hidden-keyword" name="s" value="all" size="30" maxlength="128" class="form-text">-->
						<!--Select Category-->
						<select id="edit-field-category" name="category_name" class="form-select">
							<option value="All" selected="selected"><?php esc_html_e( 'Category...', 'classiera' ); ?></option>
							<?php
							$args = array(
								'hierarchical' => '0',
								'hide_empty' => '0'
							);
							$categories = get_categories($args);
							foreach ($categories as $cat) {
								if ($cat->category_parent == 0) { 
									$catID = $cat->cat_ID;
									?>
									<option value="<?php echo $cat->slug; ?>"><?php echo $cat->cat_name; ?></option>
									<?php 
									$args2 = array(
										'hide_empty' => '0',
										'parent' => $catID
									);
									$categories = get_categories($args2);
									foreach ($categories as $cat) { ?>
									<option value="<?php echo $cat->slug; ?>">- <?php echo $cat->cat_name; ?></option>
									<?php } ?>
								<?php } else { ?>
								<?php }
							} ?>

						</select>
						<!--Select Category -->
						<!--Choose Location-->
						<select id="edit-ad-location" name="post_location" class="form-select">
							<option value="All" selected="selected"><?php esc_html_e( 'Location...', 'classiera' ); ?></option>
							<?php
							$args_location = array( 'posts_per_page' => -1 );
							$lastposts = get_posts( $args_location );
							$all_post_location = array();
							foreach( $lastposts as $post ) {
								$all_post_location[] = get_post_meta( $post->ID, 'post_location', true );
							}
							$directors = array_unique($all_post_location);
							foreach ($directors as $director) { ?>
								<option value="<?php echo $director; ?>"><?php echo $director; ?></option>
							<?php }?>
							<?php wp_reset_query(); ?>
						</select>
						<!--End Choose Location -->
						<!--Range Slider --->
						<div class="range" id="advance-search-slider"> 
							<div class="range-slider round" data-slider data-options="display_selector: #sliderOutput3;">
							  <span class="range-slider-handle" role="slider" aria-valuenow="50" aria-valuemin="1" aria-valuemax="1000">
								 <!--<span class="range-slider-out" id="sliderOutput3"></span>-->
								 <input type="text" class="range-slider-out" name="geo-radius" id="geo-radius" value="100" data-default-value="100" />
							  </span>
							  <span class="range-slider-active-segment"></span>
							</div>
						</div>
						
						<input type="text" name="geo-location" id="geo-location" value="off" data-default-value="off">
						<input type="text" name="geo-radius-search" id="geo-radius-search" value="500" data-default-value="500">
						<input type="text" name="geo-search-lat" id="geo-search-lat" value="0" data-default-value="0">
						<input type="text" name="geo-search-lng" id="geo-search-lng" value="0" data-default-value="0">
						<!--End Range Slider -->
						<button class="btn btn-primary form-submit submit" id="edit-submit-search-view" name="search" value="Search" type="submit">
                                <span><?php esc_html_e( 'Search Now', 'classiera' ); ?></span>
                                <i class="fa fa-search"></i>
                        </button>
					</form>
				</div><!--row END -->
			</div><!--AdvSeachBar END -->
		</div>
		<!--END Search Section -->


		</div>
	</section>

<?php endif; ?>
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
<!--PageContent-->
<section class="inner-page-content border-bottom">
	<div class="container">
		<!-- breadcrumb -->
		<?php classiera_breadcrumbs();?>
		<!-- breadcrumb -->
		<div class="row">
			<div class="col-md-8 col-lg-9">
				<article class="article-content">
					<h3><?php the_title(); ?></h3>
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php the_content(); ?>
					<?php endwhile; endif; ?>
				</article>
				<!--comments-->
				<?php
					$defaults = array(
						'before'           => '<p>' . __( 'Pages:' , 'classiera'),
						'after'            => '</p>',
						'link_before'      => '',
						'link_after'       => '',
						'next_or_number'   => 'number',
						'separator'        => ' ',
						'nextpagelink'     => __( 'Next page', 'classiera'),
						'previouspagelink' => __( 'Previous page', 'classiera'),
						'pagelink'         => '%',
						'echo'             => 1
					);
					wp_link_pages( $defaults );
				?>
				<div class="hidden">
					<?php comment_form(); ?>
				</div>
				<!--comments-->
			</div><!--col-md-8 col-lg-9-->
			<div class="col-md-4 col-lg-3">
				<aside class="sidebar">
					<div class="row">
						<?php get_sidebar('pages'); ?>
					</div><!--row-->
				</aside><!--sidebar-->
			</div><!--col-md-4 col-lg-3-->
		</div><!--row-->
	</div>
</section>
<!--PageContent-->
<!-- Company Section Start-->
<?php 
	global $redux_demo; 
	$classieraCompany = $redux_demo['partners-on'];
	if($classieraCompany == 1){
		if($classieraPartnersStyle == 1){
			get_template_part('templates/members/memberv1');
		}elseif($classieraPartnersStyle == 2){
			get_template_part('templates/members/memberv2');
		}elseif($classieraPartnersStyle == 3){
			get_template_part('templates/members/memberv3');
		}elseif($classieraPartnersStyle == 4){
			get_template_part('templates/members/memberv4');
		}elseif($classieraPartnersStyle == 5){
			get_template_part('templates/members/memberv5');
		}elseif($classieraPartnersStyle == 6){
			get_template_part('templates/members/memberv6');
		}
	}
?>
<!-- Company Section End-->	
<?php get_footer(); ?>