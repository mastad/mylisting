<?php
class TWRecentPostWidget extends WP_Widget{
    public function __construct() {		
        $widget_ops = array('classname' => 'TWRecentPostWidget', 'description' => 'Classiera recent posts.');
        //parent::__construct(false, 'Classiera recent posts', $widget_ops);
		parent::__construct( 'TWRecentPostWidget', esc_html__( 'Classiera recent posts', 'classiera' ), $widget_ops );
    }
    function widget($args, $instance) {
        global $post;
        extract(array(
            'title' => '',
            'theme' => 'post_nothumbnailed',
            'post_order' => 'latest',
            'post_type' => 'post',
			'post_status' => 'publish',
        ));
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
		$widget_style = $instance['widget_style'];
        $post_count = 5;
        if (isset($instance['number_posts']))
            $post_count = $instance['number_posts'];
        $q['posts_per_page'] = $post_count;
        $cats = (array) $instance['post_category'];
        $q['paged'] = 1;
        $q['post_type'] = $instance['post_type'];
        if (count($cats) > 0) {
            $typ = 'category';
	    if ($instance['post_type'] != 'post')
		$typ = 'catalog';
            $catq = '';
            $sp = '';
            foreach ($cats as $mycat) {
                $catq = $catq . $sp . $mycat;
                $sp = ',';
            }
            $catq = explode(',', $catq);
            $q['tax_query'] = Array(
				Array(
                    'taxonomy' => $typ,
                    'terms' => $catq,
                    'field' => 'id'
                )
            );
			if ($instance['post_order'] == 'commented'){
				$q['tax_query'] = Array(
				Array(
						'taxonomy' => $typ,
						'terms' => $catq,
						'field' => 'id',
						'posts_per_page' => -1,
						'meta_query' => array(
						array(
							'key' => 'featured_post',
							'value' => '1',
							'compare' => '=='
							)
						),
					)
				);
			}
        }
        /*if ($instance['post_order'] == 'commented'){
			query_posts($q.'&posts_per_page=-1' );
		}else{
			query_posts($q);
		}*/
		query_posts($q);
			
		$current = -1;
		$featuredCurrent = 0;
        if (isset($before_widget))			
            echo $before_widget;
        if ($title != '')
            echo $args['before_title'] . $title . $args['after_title'];
      
        echo '<div class="widget-content">';
		if($widget_style == 'v2' && $instance['post_order'] == 'commented'){
			echo '<ul class="list-inline grid-view-pr">';
		}
        while ( have_posts() ) : the_post();
		
		if ($instance['post_order'] == 'commented'){
			$featured_post = "";
           $featuredMeta = get_post_meta($post->ID, 'featured_post', true);
		   $post_price_plan_activation_date = get_post_meta($post->ID, 'post_price_plan_activation_date', true);
		   $post_price_plan_expiration_date = get_post_meta($post->ID, 'post_price_plan_expiration_date', true);
		   $post_price_plan_expiration_date_noarmal = get_post_meta($post->ID, 'post_price_plan_expiration_date_normal', true);
		   $todayDate = strtotime(date('m/d/Y h:i:s'));
		   $expireDate = $post_price_plan_expiration_date;
		   if(!empty($post_price_plan_activation_date) && $featuredMeta == 1) {
				if(($todayDate < $expireDate) or $post_price_plan_expiration_date == 0){
					$featured_post = "1";
				}
			}
			$featured_post = "1";
		   //echo $featured_post."Shabir<br />Current:".$current;
		   if($featured_post == "1") { 
				$current++; 
			if($current+1 <= $post_count){
				$classieraThumSrc = "";
				$thumb_id = "";
				$classieraALT = "";
		   ?>
		   <?php if($widget_style == 'v1'){?>
			<div class="media footer-pr-widget-v1">
				<div class="media-left">
					<a class="media-img" href="<?php echo esc_url(get_permalink($post->ID)); ?>">
						<?php 
						if ( has_post_thumbnail()){
						$classieraThumSrc = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
						$thumb_id = get_post_thumbnail_id($post->id);
						$classieraALT = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
						?>
						<img class="media-object" src="<?php echo $classieraThumSrc[0]; ?>" alt="<?php echo $classieraALT; ?>">
						<?php }else{
							$classieraDEFThumb = get_template_directory_uri() . '/images/nothumb.png'
						?>
						<img class="media-object" src="<?php echo $classieraDEFThumb; ?>" alt="<?php echo $classieraALT; ?>">	
							<?php
						}?>
					</a>
				</div>
				<div class="media-body">
					<?php 
					/*PostMultiCurrencycheck*/
					global $redux_demo;
					$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
					$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
					if(!empty($post_currency_tag)){
						$classieraCurrencyTag = classiera_Display_currency_sign($post_currency_tag);
					}else{
						global $redux_demo;
						$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
					}
					/*PostMultiCurrencycheck*/
					?>
					<?php $classieraPostPrice = get_post_meta($post->ID, 'post_price', true); ?>
					<span class="price">
						<?php if(is_numeric($classieraPostPrice)){?>
							<?php echo $classieraCurrencyTag.$classieraPostPrice; ?>
						<?php }else{ ?>
							<?php echo $classieraPostPrice; ?>
						<?php } ?>
					</span>
					<h4 class="media-heading">
						<a href="<?php echo esc_url(get_permalink($post->ID)); ?>"><?php echo get_the_title();?></a>
					</h4>
					<?php 
						$categories = get_the_category();
						if (! empty( $categories )){
							$classieraCategory =  esc_html( $categories[0]->name );   
							$classieraCategoryURL = esc_url(get_category_link($categories[0]->term_id ));   
						}
					?>
					<span class="category">
						<?php esc_html_e( 'Category', 'classiera'); ?>: 
						<a href="<?php echo $classieraCategoryURL; ?>"><?php echo $classieraCategory; ?></a>
					</span>
				</div>
			</div>
		   <?php }elseif($widget_style == 'v2'){
			   ?>
			   
				<li>
					<span>
						<?php 
						if ( has_post_thumbnail()){
						$classieraThumSrc = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
						$thumb_id = get_post_thumbnail_id($post->id);
						$classieraALT = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
						?>
						<img class="img-rounded" src="<?php echo $classieraThumSrc[0]; ?>" alt="<?php echo $classieraALT; ?>">
						<?php }else{
							$classieraDEFThumb = get_template_directory_uri() . '/images/nothumb.png'
						?>
						<img class="img-rounded" src="<?php echo $classieraDEFThumb; ?>" alt="<?php echo $classieraALT; ?>">	
							<?php
						}?>
						<?php 
						/*PostMultiCurrencycheck*/
						global $redux_demo;
						$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
						$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
						if(!empty($post_currency_tag)){
							$classieraCurrencyTag = classiera_Display_currency_sign($post_currency_tag);
						}else{
							global $redux_demo;
							$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
						}
						/*PostMultiCurrencycheck*/
						?>
						<a href="<?php echo esc_url(get_permalink($post->ID)); ?>" class="hover-posts">
						<?php $classieraPostPrice = get_post_meta($post->ID, 'post_price', true); ?>
							<span>
								<?php 
								if(is_numeric($classieraPostPrice)){
									echo $classieraCurrencyTag.$classieraPostPrice;
								}else{
									echo $classieraPostPrice;
								}?>
							</span>
						</a>
					</span>
				</li>
			   
			   <?php
						} ?>
			<?php }
		   }
		}else{
			$classieraThumSrc = "";
			$thumb_id = "";
			$classieraALT = "";
			if($current+2 <= $post_count){
            ?>
			<div class="media footer-pr-widget-<?php echo $widget_style; ?>">
				<div class="media-left">
					<a class="media-img" href="<?php echo esc_url(get_permalink($post->ID)); ?>">
						<?php 
						if ( has_post_thumbnail()){
						$classieraThumSrc = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
						$thumb_id = get_post_thumbnail_id($post->id);
						$classieraALT = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
						?>
						<img class="media-object" src="<?php echo $classieraThumSrc[0]; ?>" alt="<?php echo $classieraALT; ?>">
						<?php }else{
							$classieraDEFThumb = get_template_directory_uri() . '/images/nothumb.png'
						?>
						<img class="media-object" src="<?php echo $classieraDEFThumb; ?>" alt="<?php echo $classieraALT; ?>">	
							<?php
						}?>
					</a>
				</div>
				<div class="media-body">
					<?php if($widget_style == 'v1'){?>
					<?php 
					/*PostMultiCurrencycheck*/
					global $redux_demo;
					$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
					$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
					if(!empty($post_currency_tag)){
						$classieraCurrencyTag = classiera_Display_currency_sign($post_currency_tag);
					}else{
						global $redux_demo;
						$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
					}
					/*PostMultiCurrencycheck*/
					?>
					<?php $classieraPostPrice = get_post_meta($post->ID, 'post_price', true); ?>
					<span class="price">
						<?php if(is_numeric($classieraPostPrice)){?>
							<?php echo $classieraCurrencyTag.$classieraPostPrice; ?>
						<?php }else{?>
							<?php echo $classieraPostPrice; ?>
						<?php } ?>
					</span>
					<h4 class="media-heading">
						<a href="<?php echo esc_url(get_permalink($post->ID)); ?>"><?php echo get_the_title();?></a>
					</h4>
					<?php 
						$categories = get_the_category();
						if (! empty( $categories )){
							$classieraCategory =  esc_html( $categories[0]->name );   
							$classieraCategoryURL = esc_url(get_category_link($categories[0]->term_id ));   
						}
					?>
					<span class="category">
						<?php esc_html_e( 'Category', 'classiera'); ?>: 
						<a href="<?php echo $classieraCategoryURL; ?>"><?php echo $classieraCategory; ?></a>
					</span>
					<?php }elseif($widget_style == 'v2'){?>
						<?php $classieradateFormat = get_option( 'date_format' );?>
						<span><i class="fa fa-clock-o"></i><?php echo get_the_date($classieradateFormat, $post->ID); ?></span>
						<h5 class="media-heading">
							<a href="<?php echo esc_url(get_permalink($post->ID)); ?>"><?php echo get_the_title();?></a>
						</h5>
						<?php 
						/*PostMultiCurrencycheck*/
						global $redux_demo;
						$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
						$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
						if(!empty($post_currency_tag)){
							$classieraCurrencyTag = classiera_Display_currency_sign($post_currency_tag);
						}else{
							global $redux_demo;
							$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
						}
						/*PostMultiCurrencycheck*/
						?>
						<?php $classieraPostPrice = get_post_meta($post->ID, 'post_price', true); ?>
						<p class="price"><?php esc_html_e( 'Price', 'classiera'); ?> : <span class="color">
							<?php if(is_numeric($classieraPostPrice)){?>
								<?php echo $classieraCurrencyTag.$classieraPostPrice; ?>
							<?php }else{ 
								 echo $classieraPostPrice;
							} ?>
						</span></p>
					<?php } ?>
				</div>
			</div>
			<?php
			}
			$current++;
			}
        endwhile;
		if($widget_style == 'v2' && $instance['post_order'] == 'commented'){
			echo '</ul>';
		}
        echo '</div>';        
        if (isset($after_widget))
            echo $after_widget;
        wp_reset_query();
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        /* Strip tags (if needed) and update the widget settings. */
        $instance['title'] = strip_tags($new_instance['title']);
        if ($new_instance['post_type'] == 'post') {
	    $instance['post_category'] = $_REQUEST['post_category'];
	} else {
	    $tax = get_object_taxonomies($new_instance['post_type']);
	    $instance['post_category'] = $_REQUEST['tax_input'][$tax[0]];
	}
        $instance['number_posts'] = strip_tags($new_instance['number_posts']);
        $instance['post_type'] = strip_tags($new_instance['post_type']);
        $instance['post_order'] = strip_tags($new_instance['post_order']);
        $instance['widget_style'] = strip_tags($new_instance['widget_style']);
        $instance['theme'] = strip_tags($new_instance['theme']);
        return $instance;
    }

    function form($instance) {
        //Output admin widget options form
        extract(shortcode_atts(array(
                    'title' => '',
                    'theme' => 'post_nothumbnailed',
                    'number_posts' => 5,
                    'post_order' => 'latest',
                    'widget_style' => 'v1',
                    'post_type' => 'post'
                        ), $instance));
        $defaultThemes = Array(
            Array("name" => 'Thumbnailed posts', 'user_func' => 'post_thumbnailed'),
            Array("name" => 'Default posts', 'user_func' => 'post_nonthumbnailed')
        );
        $themes = apply_filters('jw_recent_posts_widget_theme_list', $defaultThemes);
        $defaultPostTypes = Array(Array("name" => 'Post', 'post_type' => 'post')); ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:', 'classiera');?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>"  />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('post_order'); ?>"><?php esc_html_e('Post order', 'classiera');?>:</label>
            <select class="widefat" id="<?php echo $this->get_field_id('post_order'); ?>" name="<?php echo $this->get_field_name('post_order'); ?>">
                <option value="latest" <?php if ($post_order == 'latest') print 'selected="selected"'; ?>><?php esc_html_e('Latest Ads', 'classiera');?></option>
                <option value="commented" <?php if ($post_order == 'commented') print 'selected="selected"'; ?>><?php esc_html_e('Featured Ads', 'classiera');?></option>
            </select>
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('widget_style'); ?>"><?php esc_html_e('Widget Style', 'classiera');?>:</label>
            <select class="widefat" id="<?php echo $this->get_field_id('widget_style'); ?>" name="<?php echo $this->get_field_name('widget_style'); ?>">
                <option value="v1" <?php if ($widget_style == 'v1') print 'selected="selected"'; ?>><?php esc_html_e('Style 1', 'classiera');?></option>
                <option value="v2" <?php if ($widget_style == 'v2') print 'selected="selected"'; ?>><?php esc_html_e('Style 2', 'classiera');?></option>
            </select>
        </p>
       <?php 
        $customTypes = apply_filters('jw_recent_posts_widget_type_list', $defaultPostTypes);
        if (count($customTypes) > 0) { ?>
            <p style="display: none;">
                <label for="<?php echo $this->get_field_id('post_type'); ?>"><?php esc_html_e('Post from', 'classiera');?>:</label>
                <select rel="<?php echo $this->get_field_id('post_cats'); ?>" onChange="jw_get_post_terms(this);" class="widefat" id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>"><?php
                    foreach ($customTypes as $postType) { ?>
                        <option value="<?php print $postType['post_type'] ?>" <?php echo selected($post_type, $postType['post_type']); ?>><?php print $postType['name'] ?></option><?php
                    } ?>
                </select>
            </p><?php
        } ?>
        <p><?php esc_html_e('If you were not selected for cats, it will show all categories.', 'classiera');?></p>
        <div id="<?php echo $this->get_field_id('post_cats'); ?>" style="height:150px; overflow:auto; border:1px solid #dfdfdf;"><?php
            $post_type='post';
            $tax = get_object_taxonomies($post_type);

            $selctedcat = false;
            if (isset($instance['post_category']) && $instance['post_category'] != ''){
                $selctedcat = $instance['post_category'];
            }
            wp_terms_checklist(0, array('taxonomy' => $tax[0], 'checked_ontop' => false, 'selected_cats' => $selctedcat)); ?>
        </div>
        <p>
            <label for="<?php echo $this->get_field_id('number_posts'); ?>"><?php esc_html_e('Number of posts to show', 'classiera');?>:</label>
            <input  id="<?php echo $this->get_field_id('number_posts'); ?>" name="<?php echo $this->get_field_name('number_posts'); ?>" value="<?php echo $number_posts; ?>" size="3"  />
        </p><?php
    }
}
add_action('widgets_init', create_function('', 'return register_widget("TWRecentPostWidget");'));
add_action('wp_ajax_themewave_recent_post_terms', 'get_post_type_terms');
function get_post_type_terms() {
    $cat = 'post';
    if (isset($_REQUEST['post_format']) && $_REQUEST['post_format'] != '')
        $cat = $_REQUEST['post_format'];
    $tax = get_object_taxonomies($cat);
    wp_terms_checklist(0, array('taxonomy' => $tax[0], 'checked_ontop' => false, 'selected_cats' => false));
    die;
} ?>