<?php
/**
 * Template name: Homepage V2 - Strobe
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */
get_header(); ?>

<?php 

	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	$page_slider = get_post_meta($current_page_id, 'page_slider', true); 

	global $redux_demo; 
	$homeLayout = $redux_demo['opt-homepage-layout-v2']['enabled'];
	if ($homeLayout):
	foreach ($homeLayout as $key=>$value) {
 
			switch($key) {
					
					case 'layerslider': get_template_part('templates/slider/sliderv1');
					break;
					
					case 'searchv2': get_template_part( 'templates/searchbar/searchstyle2' );
					break;
					
					case 'premiumslider': get_template_part( 'templates/premium/premiumv2' );
					break;
					
					case 'categories': get_template_part( 'templates/category/catstyle2' );
					break;	
			 
					case 'advertisement': get_template_part( 'templates/adv/advstyle2' );    
					break;  
					
					case 'customads': get_template_part( 'templates/customads' );
					break;
					
					case 'callout': get_template_part( 'templates/callout/callout2' );    
					break; 
					
					case 'location': get_template_part( 'templates/locations/locationsv2' );    
					break; 
					
					case 'packages': get_template_part( 'templates/plans/plansv2' );    
					break;
					
					case 'partners': get_template_part( 'templates/members/memberv2' );    
					break;
				}			 
			}		 
	endif;

?>

<?php get_footer(); ?>