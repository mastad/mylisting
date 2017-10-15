<?php
/**
 * Template name: Profile Page
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Classiera
 * @since Classiera
 */

if ( !is_user_logged_in() ) { 

	global $redux_demo; 
	$login = $redux_demo['login'];
	wp_redirect( $login ); exit;

}


global $redux_demo; 
$edit = $redux_demo['edit'];
$pagepermalink = get_permalink($post->ID);
if(isset($_GET['delete_id'])){
	$deleteUrl = $_GET['delete_id'];
	wp_delete_post($deleteUrl);
}
if(isset($_POST['unfavorite'])){
	$author_id = $_POST['author_id'];
	$post_id = $_POST['post_id'];
	echo classiera_authors_unfavorite($author_id, $post_id);	
}
global $current_user, $user_id;
$current_user = wp_get_current_user();

$user_info = get_userdata($user_ID);
$user_id = $current_user->ID; // You can set $user_id to any users, but this gets the current users ID.

get_header(); 


?>
<?php 
global $redux_demo; 
$featured_ads_option = $redux_demo['featured-options-on'];
$profile = $redux_demo['profile'];
$all_adds = $redux_demo['all-ads'];
$allFavourite = $redux_demo['all-favourite'];
$newPostAds = $redux_demo['new_post'];
$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
?>
<?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
?>
<!-- user pages -->
<section class="user-pages section-gray-bg">
	<div class="container">
        <div class="row">
			<div class="col-lg-3 col-md-4">
				<?php get_template_part( 'templates/profile/userabout' );?>
			</div><!--col-lg-3-->
			<div class="col-lg-9 col-md-8 user-content-height">
				<div class="user-detail-section section-bg-white">
					<!-- about me -->
					<div class="about-me">
						<h4 class="user-detail-section-heading text-uppercase"><?php esc_html_e("About Me", 'classiera') ?></h4>
						<p><?php $user_id = $current_user->ID; $author_desc = get_the_author_meta('description', $user_id); echo $author_desc; ?></p>
					</div>
					<!-- about me -->
					<!-- contact details -->
					<div class="user-contact-details">
						<h4 class="user-detail-section-heading text-uppercase">
							<?php esc_html_e("Contact Details", 'classiera') ?>
						</h4>
						<ul class="list-unstyled">
							<?php 
							$userPhone = get_the_author_meta('phone', $user_id);
							$userPhone2 = get_the_author_meta('phone2', $user_id);
							$userEmail = get_the_author_meta('user_email', $user_id);
							$userwebsite = get_the_author_meta('user_url', $user_id);
							?>
							<?php if(!empty($userPhone)){?>
                            <li>
                                <i class="fa fa-phone-square"></i>
                                <?php echo $userPhone; ?>
                            </li>
							<?php } ?>
							<?php if(!empty($userPhone2)){?>
                            <li>
                                <i class="fa fa-mobile-phone"></i>
								<?php echo $userPhone2; ?>
                            </li>
							<?php } ?>
							<?php if(!empty($userwebsite)){?>
                            <li>
                                <i class="fa fa-globe"></i>
                                <a href="<?php echo $userwebsite; ?>"><?php echo $userwebsite; ?></a>
                            </li>
							<?php } ?>
							<?php if(!empty($userEmail)){?>
                            <li>
                                <i class="fa fa-envelope"></i>
                                <a href="mailto:<?php echo $userEmail; ?>"><?php echo $userEmail; ?></a>
                            </li>
							<?php } ?>
                        </ul>
					</div>
					<!-- contact details -->
					<!-- social profile -->
					<div class="user-social-profile-links">
						<h4 class="user-detail-section-heading text-uppercase">
							<?php esc_html_e("Social profile Links", 'classiera') ?>
						</h4>
						<ul class="list-unstyled list-inline">
						<?php 
							$userFB = $user_info->facebook;
							$userTW = $user_info->twitter;
							$userGoogle = $user_info->googleplus;
							$userPin = $user_info->pinterest;
							$userLin = $user_info->linkedin;
							$userInsta = $user_info->instagram;
							$userVimeo = $user_info->vimeo;
							$userYouTube = $user_info->youtube;
						?>
						<?php if(!empty($userFB)){?>
                            <li>
                                <a href="<?php echo $userFB; ?>"><i class="fa fa-facebook"></i></a>
                            </li>
						<?php } ?>
						<?php if(!empty($userTW)){?>
                            <li>
                                <a href="<?php echo $userTW; ?>"><i class="fa fa-twitter"></i></a>
                            </li>
						<?php } ?>	
						<?php if(!empty($userGoogle)){?>	
                            <li>
                                <a href="<?php echo $userGoogle; ?>"><i class="fa fa-google-plus"></i></a>
                            </li>
						<?php } ?>	
						<?php if(!empty($userInsta)){?>	
                            <li>
                                <a href="<?php echo $userInsta; ?>"><i class="fa fa-instagram"></i></a>
                            </li>
						<?php } ?>	
						<?php if(!empty($userPin)){?>	
                            <li>
                                <a href="<?php echo $userPin; ?>"><i class="fa fa-pinterest-p"></i></a>
                            </li>
						<?php } ?>	
						<?php if(!empty($userLin)){?>	
                            <li>
                                <a href="<?php echo $userLin; ?>"><i class="fa fa-linkedin"></i></a>
                            </li>
						<?php } ?>	
						<?php if(!empty($userVimeo)){?>	
                            <li>
                                <a href="<?php echo $userVimeo; ?>"><i class="fa fa-vimeo"></i></a>
                            </li>
						<?php } ?>	
						<?php if(!empty($userYouTube)){?>	
                            <li>
                                <a href="<?php echo $userYouTube; ?>"><i class="fa fa-youtube"></i></a>
                            </li>
						<?php } ?>	
                        </ul>
					</div>
					<!-- social profile -->
					<!-- my ads -->
					<div class="user-ads user-my-ads">
						<h4 class="user-detail-section-heading text-uppercase">
							<?php esc_html_e("My Ads", 'classiera') ?>
						</h4>
						<?php 
							global $wp_query, $wp;
							$wp_query = new WP_Query();
							$kulPost = array(
								'post_type'  => 'post',
								'author' => $user_id,
								'posts_per_page' => 10,	
							);
							$wp_query = new WP_Query($kulPost);
						while ($wp_query->have_posts()) : $wp_query->the_post();
						$title = get_the_title($post->ID); 
						$classieraPstatus = get_post_status( $post->ID );
						$dateFormat = get_option( 'date_format' );
						$postDate = get_the_date($dateFormat, $post->ID);
						?>
						<div class="media border-bottom">
							<div class="media-left">
								<?php 
								if ( has_post_thumbnail()){								
								$imgURL = get_the_post_thumbnail_url();
								?>
                                <img class="media-object" src="<?php echo $imgURL; ?>" alt="<?php echo $title; ?>">
								<?php } ?>
                            </div><!--media-left-->
							<div class="media-body">
								<h5 class="media-heading">
									<a href="<?php echo get_permalink($post->ID);?>"><?php echo $title; ?></a>
								</h5>
								<p>
                                    <span class="published">
                                        <i class="fa fa-check-circle"></i>
                                        <?php classieraPStatusTrns($classieraPstatus); ?>
                                    </span>
                                    <span>
                                        <i class="fa fa-eye"></i>
                                        <?php echo classiera_get_post_views($post->ID); ?>
                                    </span>
                                    <span>
                                        <i class="fa fa-clock-o"></i>
                                        <?php echo $postDate; ?>
                                    </span>									
                                </p>
							</div><!--media-body-->
							<div class="media-right">
								<?php 
									global $redux_demo;
									$edit_post_page_id = $redux_demo['edit_post'];
									$postID = $post->ID;
									global $wp_rewrite;
									if ($wp_rewrite->permalink_structure == ''){
										//we are using ?page_id
										$edit_post = $edit_post_page_id."&post=".$post->ID;
										$del_post = $pagepermalink."&delete_id=".$post->ID;
									}else{
										//we are using permalinks
										$edit_post = $edit_post_page_id."?post=".$post->ID;
										$del_post = $pagepermalink."?delete_id=".$post->ID;
									}
								if(get_post_status( $post->ID ) !== 'private'){ 	
								?>
								<a href="<?php echo $edit_post; ?>" class="btn btn-primary sharp btn-style-one btn-sm"><i class="icon-left fa fa-pencil-square-o"></i><?php esc_html_e("Edit", 'classiera') ?></a>
								<?php } ?>
								<a class="thickbox btn btn-primary sharp btn-style-one btn-sm" href="#TB_inline?height=150&amp;width=400&amp;inlineId=examplePopup<?php echo $post->ID; ?>"><i class="icon-left fa fa-trash-o"></i><?php esc_html_e("Delete", 'classiera') ?></a>
								<div class="delete-popup" id="examplePopup<?php echo $post->ID; ?>" style="display:none">
									<h4><?php esc_html_e("Are you sure you want to delete this?", 'classiera') ?></h4>
									<a class="btn btn-primary sharp btn-style-one btn-sm" href="<?php echo $del_post; ?>">
									<span class="button-inner"><?php esc_html_e("Confirm", 'classiera') ?></span>
									</a>
								</div>
							</div><!--media-right-->
						</div><!--media border-bottom-->
						<?php endwhile;	?>
						<?php wp_reset_query(); ?>
						<div class="user-view-all text-center">
                            <a href="<?php echo $all_adds; ?>" class="btn btn-primary btn-md btn-style-one sharp">
								<?php esc_html_e("View All", 'classiera') ?>
							</a>
                        </div>
					</div>
					<!-- my ads -->
					<!-- favorite ads -->
					<div class="user-ads favorite-ads">
						<h4 class="user-detail-section-heading text-uppercase">
						<?php esc_html_e("Favorite Ads", 'classiera') ?>
						</h4>
						<?php 
							global $paged, $wp_query, $wp;
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ) {
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}
							$cat_id = get_cat_ID(single_cat_title('', false));
							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							global $current_user;
							wp_get_current_user();
							$user_id = $current_user->ID;
							$myarray = classiera_authors_all_favorite($user_id);
							if(!empty($myarray)){
								$args = array(
								   'post_type' => 'post',
								   'posts_per_page' => 10,
								   'post__in' => $myarray,
								);
								// The Query
							$wp_query = new WP_Query( $args );
							while ($wp_query->have_posts()) : $wp_query->the_post();
						?>
						<div class="media border-bottom">
							<div class="media-left">
								<?php 
								if ( has_post_thumbnail()){								
								$imgURL = get_the_post_thumbnail_url();
								?>
                                <img class="media-object" src="<?php echo $imgURL; ?>" alt="<?php echo $title; ?>">
								<?php } ?>
                            </div><!--media-left-->
							<div class="media-body">
								<h5 class="media-heading">
									<a href="<?php echo get_permalink($post->ID);?>"><?php echo $title; ?></a>
								</h5>
								<p>
									<?php $post_user_ID = $post->post_author; ?>
                                    <span>
                                        <i class="fa fa-user"></i>
                                        <?php echo get_the_author_meta('display_name', $post_user_ID ); ?>
                                    </span>                                    
                                    <span>
                                        <i class="fa fa-clock-o"></i>
                                        <?php echo $postDate; ?>
                                    </span>
                                </p>
							</div><!--media-body-->
							<div class="media-right">
								<?php $post_price = get_post_meta($post->ID, 'post_price', true);  ?>
                                <h4><?php echo $classieraCurrencyTag.$post_price; ?></h4>
                                <?php echo classiera_authors_favorite_remove($user_id, $post->ID);?>
							</div><!--media-right-->
						</div><!--media border-bottom-->
						<?php endwhile; ?>
						<?php wp_reset_query(); ?>
						<?php }else{ ?>
							<p><?php esc_html_e("You do not have any favourite ad yet!", 'classiera') ?></p>
						<?php } ?>
					</div>
					<!-- favorite ads -->
				</div>
			</div>
		</div><!--row-->
	</div><!--container-->
</section>
<!-- user pages -->
<?php get_footer(); ?>