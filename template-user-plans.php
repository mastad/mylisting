<?php
/**
 * Template name: Single User All Plans
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
$featured_ads_option = $redux_demo['featured-options-on'];
$profile = $redux_demo['profile'];
$all_adds = $redux_demo['all-ads'];
$allFavourite = $redux_demo['all-favourite'];
$newPostAds = $redux_demo['new_post'];
$current_user = wp_get_current_user();
$user_info = get_userdata($user_ID);
$user_id = $current_user->ID; // You can set $user_id to any users, but this gets the current users ID.
get_header();
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
				<!-- Oder History -->
				<div class="user-ads user-packages">
					<h4 class="user-detail-section-heading text-uppercase">
					<?php esc_html_e("Order History", 'classiera') ?>
					</h4>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th><?php esc_html_e("Packeg Name", 'classiera') ?></th>
									<th><?php esc_html_e("Duration", 'classiera') ?></th>
									<th><?php esc_html_e("Total Ads", 'classiera') ?></th>
									<th><?php esc_html_e("Price", 'classiera') ?></th>
									<th><?php esc_html_e("Status", 'classiera') ?></th>
									<th><?php esc_html_e("Details", 'classiera') ?></th>
									<th><?php esc_html_e("Payment Method", 'classiera') ?></th>
									
								</tr>
							</thead>
							<tbody>
							<?php
							if (!class_exists('WooCommerce')) :
								require ABSPATH . 'wp-content/plugins/woocommerce/woocommerce.php';
								$orders = get_all_orders();
							endif;
							$args = array(
								'numberposts' => -1,
								'meta_key' => '_customer_user',
								'meta_value' => get_current_user_id(),
								'post_type' => 'shop_order',
								'post_status' => array_keys(wc_get_order_statuses()),
							);							
							$customer_orders = get_posts($args);							
							$loop = new WP_Query($customer_orders);
							  foreach ($customer_orders as $orderItem){
								  ?>
								  <tr>
								  <?php
									$order = wc_get_order($orderItem->ID);
									//print_r($order);
									$items = $order->get_items();
									$current = 0;
									foreach ( $items as $item_id => $item_data ) {	
										$plan_name = wc_get_order_item_meta($item_id, 'plan_name', true);
										$plan_time = wc_get_order_item_meta($item_id, 'plan_time', true);
										$plan_ads = wc_get_order_item_meta($item_id, 'plan_ads', true);
										$payment = wc_get_order_item_meta($item_id, 'payment_method_title', true);
										?>
										
											<td><?php echo $plan_name; ?></td>
											<td><?php echo $plan_time; ?>&nbsp;<?php esc_html_e("Days", 'classiera') ?></td>
											<td><?php echo $plan_ads; ?></td>			
											<td><?php echo get_woocommerce_currency_symbol(); ?><?php echo $item_data['total']; ?></td>
										
									<?php
									} 
									?>
									
										<td class="text-success"><?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?></td>
										<td>
											<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
												<?php esc_html_e("View Oder Details", 'classiera') ?>
											</a>
										</td>
										<td><?php echo $order->get_payment_method_title(); ?></td>
									</tr>
									<?php
								}
							?>
							</tbody>
						</table>
					</div><!--table-responsive-->
				</div><!--user-ads user-packages-->
				<!-- Oder History -->
				<!--Package Details-->
				<div class="user-ads user-packages">
					<h4 class="user-detail-section-heading text-uppercase">
					<?php esc_html_e("Ads Plans Details", 'classiera') ?>
					</h4>
					<div class="table-responsive">
						<table class="table table-striped table-center">
							<thead>
								<tr>
									<th><?php esc_html_e("Plan Name", 'classiera') ?></th>
									<th><?php esc_html_e("Price", 'classiera') ?></th>
									<th><?php esc_html_e("Total Ads", 'classiera') ?></th>
									<th><?php esc_html_e("Used Ads", 'classiera') ?></th>
									<th><?php esc_html_e("Available Ads", 'classiera') ?></th>
									<th><?php esc_html_e("Days", 'classiera') ?></th>
									<th><?php esc_html_e("status", 'classiera') ?></th>
								</tr>
							</thead>
							<tbody>
							<?php 
							$current_user = wp_get_current_user();
							$userID = $current_user->ID;
							$result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_plans WHERE user_id = $userID ORDER BY id DESC" );
							$totalAds = '';
							$usedAds = '';
							$availableADS = '';
							if(!empty($result)){
								foreach ( $result as $info ) {
									$totalAds = $info->ads;
									$usedAds = $info->used;
									$availableADS = $totalAds-$usedAds;
									$name = $info->plan_name;
									$price = $info->price;
									$days = $info->days;
									$status = $info->status;
									?>
									<tr>
										<td><?php echo $name; ?></td>
										<td><?php echo $price; ?></td>
										<td><?php echo $totalAds; ?></td>
										<td><?php echo $usedAds; ?></td>
										<td><?php echo $availableADS; ?></td>
										<td><?php echo $days; ?></td>
										<td><?php echo $status; ?></td>
									</tr>
									<?php
								}
							}
							?>
							</tbody>
						</table>
					</div><!--table-responsive-->
				</div>
				<!--Package Details-->
				</div><!--user-detail-section-->
			</div><!--col-lg-9-->
		</div><!--row-->
	</div><!-- container-->
</section>
<!-- user pages -->
<!-- Company Section Start-->
<?php 
	global $redux_demo; 
	$classieraCompany = $redux_demo['partners-on'];
	$classieraPartnersStyle = $redux_demo['classiera_partners_style'];
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