<?php
class TWBlogcategoryWidget extends WP_Widget {
    public function __construct() {	
        $widget_ops = array('classname' => 'TWBlogcategoryWidget', 'description' => 'Blogs Categories.');
        //parent::__construct(false, 'Blogs Categories ', $widget_ops);
		parent::__construct( 'TWBlogcategoryWidget', esc_html__( 'Blogs Categories', 'classiera' ), $widget_ops );
		
    }
    function widget($args, $instance) {
        global $post;
		$title = apply_filters('widget_title', $instance['title']);
		?>
		<div class="col-lg-12 col-md-12 col-sm-6 match-height">
			<div class="widget-box">
				<?php if (isset($before_widget))
				echo $before_widget;				
					if ($title != '')
					echo $args['before_title'];
					?>
					<i class="fa fa-folder-open"></i>
					<?php
					echo $title . $args['after_title']; 
				?>
				<div class="widget-content">
					<ul class="category">
					<?php
					$categories = get_terms(
					'blog_category', 
					array('parent' => 0,'order'=> 'DESC','pad_counts'=>true)			
					);
					$current = -1;					      
					foreach ($categories as $category) {						
						$tag = $category->term_id;
						?>						
						<li>
							<a href="<?php echo get_category_link( $category->term_id )?>" title="View posts in <?php echo $category->name?>"><?php echo $category->name ?></a>

						</li>
					<?php
					}
					?>
					</ul>
		    	</div>
		    </div>
		</div>
		<?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        /* Strip tags (if needed) and update the widget settings. */
        $instance['title'] = strip_tags($new_instance['title']);
       
        return $instance;
    }

    function form($instance) {
	extract($instance);
       ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e("Title:", "classiera");?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>"  />
        </p>
        <?php
    }
}
add_action('widgets_init', create_function('', 'return register_widget("TWBlogcategoryWidget");'));

?>