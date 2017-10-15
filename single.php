<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */
get_header(); ?>
	
	<?php while ( have_posts() ) : the_post(); ?>


<?php 

global $redux_demo; 
global $current_user; wp_get_current_user(); $user_ID == $current_user->ID;

$profileLink = get_the_author_meta( 'user_url', $user_ID );
$contact_email = get_the_author_meta('user_email');
$classieraContactEmailError = $redux_demo['contact-email-error'];
$classieraContactNameError = $redux_demo['contact-name-error'];
$classieraConMsgError = $redux_demo['contact-message-error'];
$classieraContactThankyou = $redux_demo['contact-thankyou-message'];
$classieraRelatedCount = $redux_demo['classiera_related_ads_count'];
$classieraSearchStyle = $redux_demo['classiera_search_style'];
$classieraSingleAdStyle = $redux_demo['classiera_single_ad_style'];
$classieraPartnersStyle = $redux_demo['classiera_partners_style'];
$classieraComments = $redux_demo['classiera_sing_post_comments'];
$googleMapadPost = $redux_demo['google-map-adpost'];
$classieraToAuthor = $redux_demo['author-msg-box-off'];
$locShownBy = $redux_demo['location-shown-by'];
$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
$category_icon_code = "";
$category_icon_color = "";
$your_image_url = "";

global $errorMessage;
global $emailError;
global $commentError;
global $subjectError;
global $humanTestError;
global $hasError;

//If the form is submitted
if(isset($_POST['submit'])) {
	if($_POST['submit'] == 'send_message'){
		//echo "send_message";
		//Check to make sure that the name field is not empty
		if(trim($_POST['contactName']) === '') {
			$errorMessage = $classieraContactNameError;
			$hasError = true;
		} elseif(trim($_POST['contactName']) === 'Name*') {
			$errorMessage = $classieraContactNameError;
			$hasError = true;
		}	else {
			$name = trim($_POST['contactName']);
		}

		//Check to make sure that the subject field is not empty
		if(trim($_POST['subject']) === '') {
			$errorMessage = $classiera_contact_subject_error;
			$hasError = true;
		} elseif(trim($_POST['subject']) === 'Subject*') {
			$errorMessage = $classiera_contact_subject_error;
			$hasError = true;
		}	else {
			$subject = trim($_POST['subject']);
		}
		
		//Check to make sure sure that a valid email address is submitted
		if(trim($_POST['email']) === ''){
			$errorMessage = $classieraContactEmailError;
			$hasError = true;		
		}else{
			$email = trim($_POST['email']);
		}
			
		//Check to make sure comments were entered	
		if(trim($_POST['comments']) === '') {
			$errorMessage = $classieraConMsgError;
			$hasError = true;
		} else {
			if(function_exists('stripslashes')) {
				$comments = stripslashes(trim($_POST['comments']));
			} else {
				$comments = trim($_POST['comments']);
			}
		}

		//Check to make sure that the human test field is not empty
		$classieraCheckAnswer = $_POST['humanAnswer'];
		if(trim($_POST['humanTest']) != $classieraCheckAnswer) {
			$errorMessage = esc_html__('Not Human', 'classiera');			
			$hasError = true;
		}
		$classieraPostTitle = $_POST['classiera_post_title'];	
		$classieraPostURL = $_POST['classiera_post_url'];
		
		//If there is no error, send the email		
		if(!isset($hasError)) {

			$emailTo = $contact_email;
			$subject = $subject;	
			$body = "Name: $name \n\nEmail: $email \n\nMessage: $comments";
			$headers = 'From <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
			
			//wp_mail($emailTo, $subject, $body, $headers);
			contactToAuthor($emailTo, $subject, $name, $email, $comments, $headers, $classieraPostTitle, $classieraPostURL);
			$emailSent = true;			

		}
	}
	if($_POST['submit'] == 'report_to_admin'){		
		$displayMessage = '';
		$report_ad = $_POST['report_ad_val'];
		if($report_ad == "illegal") {
			$message = esc_html__('This is illegal/fraudulent Ads, please take action.', 'classiera');
		}
		if($report_ad == "spam") {
			$message = esc_html__('This Ad is SPAM, please take action', 'classiera');			
		}
		if($report_ad == "duplicate") {
			$message = esc_html__('This ad is a duplicate, please take action', 'classiera');			
		}
		if($report_ad == "wrong_category") {
			$message = esc_html__('This ad is in the wrong category, please take action', 'classiera');			
		}
		if($report_ad == "post_rules") {
			$message = esc_html__('The ad goes against posting rules, please take action', 'classiera');			
		}
		if($report_ad == "post_other") {
			$message = $_POST['other_report'];				
		}		
		$classieraPostTitle = $_POST['classiera_post_title'];	
		$classieraPostURL = $_POST['classiera_post_url'];
		//print_r($message); exit();
		classiera_reportAdtoAdmin($message, $classieraPostTitle, $classieraPostURL);
		if(!empty($message)){
			$displayMessage = esc_html__('Thanks for report, Our Team will take action ASAP.', 'classiera');
		}
	}
	
}
if(isset($_POST['favorite'])){
	$author_id = $_POST['author_id'];
	$post_id = $_POST['post_id'];
	echo classiera_favorite_insert($author_id, $post_id);
}
if(isset($_POST['follower'])){	
	$author_id = $_POST['author_id'];
	$follower_id = $_POST['follower_id'];
	echo classiera_authors_insert($author_id, $follower_id);
}
if(isset($_POST['unfollow'])){
	$author_id = $_POST['author_id'];
	$follower_id = $_POST['follower_id'];
	echo classiera_authors_unfollow($author_id, $follower_id);
}

?>
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
<section class="inner-page-content single-post-page">
	<div class="container">
		<!-- breadcrumb -->
		<?php classiera_breadcrumbs();?>
		<!-- breadcrumb -->
		<!--Google Section-->
		<?php 
		$homeAd1 = '';		
		global $redux_demo;
		$homeAdImg1 = $redux_demo['home_ad2']['url']; 
		$homeAdImglink1 = $redux_demo['home_ad2_url']; 
		$homeHTMLAds = $redux_demo['home_html_ad2'];
		
		if(!empty($homeHTMLAds) || !empty($homeAdImg1)){
			if(!empty($homeHTMLAds)){
				$homeAd1 = $homeHTMLAds;
			}else{
				$homeAd1 = '<a href="'.$homeAdImglink1.'" target="_blank"><img class="img-responsive" alt="image" src="'.$homeAdImg1.'" /></a>';
			}
		}
		if(!empty($homeAd1)){
		?>
		<section id="classieraDv">
			<div class="container">
				<div class="row">							
					<div class="col-lg-12 col-md-12 col-sm-12 center-block text-center">
						<?php echo $homeAd1; ?>
					</div>
				</div>
			</div>	
		</section>
		<?php } ?>
		<?php if ( get_post_status ( $post->ID ) == 'private' ) {?>
		<div class="alert alert-info" role="alert">
		  <p>
		  <strong><?php esc_html_e('Congratulation!', 'classiera') ?></strong> <?php esc_html_e('Your Ad has submitted and pending for review. After review your Ad will be live for all users. You may not preview it more than once.!', 'classiera') ?>
		  </p>
		</div>
		<?php } ?>
		<!--Google Section-->
		<?php if($classieraSingleAdStyle == 2){
			get_template_part( 'templates/singlev2' );
		}?>
		<div class="row">
			<div class="col-md-8">
				<!-- single post -->
				<div class="single-post">
					<?php if($classieraSingleAdStyle == 1){
						get_template_part( 'templates/singlev1');
					}?>
					<?php 
					$post_price = get_post_meta($post->ID, 'post_price', true); 
					$post_old_price = get_post_meta($post->ID, 'post_old_price', true);
					$postVideo = get_post_meta($post->ID, 'post_video', true);
					$dateFormat = get_option( 'date_format' );
					$postDate = get_the_date($dateFormat, $post->ID);
					$itemCondition = get_post_meta($post->ID, 'item-condition', true); 
					$post_location = get_post_meta($post->ID, 'post_location', true);
					$post_state = get_post_meta($post->ID, 'post_state', true);
					$post_city = get_post_meta($post->ID, 'post_city', true);
					$post_phone = get_post_meta($post->ID, 'post_phone', true);
					$post_latitude = get_post_meta($post->ID, 'post_latitude', true);
					$post_longitude = get_post_meta($post->ID, 'post_longitude', true);
					$post_address = get_post_meta($post->ID, 'post_address', true);
					$classieraCustomFields = get_post_meta($post->ID, 'custom_field', true);
					/*PostMultiCurrencycheck*/
					$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
					if(!empty($post_currency_tag)){
						$classieraCurrencyTag = classiera_Display_currency_sign($post_currency_tag);
					}else{
						global $redux_demo;
						$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
					}
					/*PostMultiCurrencycheck*/
					?>
					<!-- ad deails -->
					<div class="border-section border details">
                        <h4 class="border-section-heading text-uppercase"><i class="fa fa-file-text-o"></i><?php esc_html_e('Ad Details', 'classiera') ?></h4>
                        <div class="post-details">
                            <ul class="list-unstyled clearfix">
                                <li>
                                    <p><?php esc_html_e( 'Added', 'classiera' ); ?>: 
									<span class="pull-right flip"><?php echo $postDate; ?></span>
									</p>
                                </li><!--PostDate-->								
								<!--Price Section -->
								<?php 
								$classieraPriceSection = $redux_demo['classiera_sale_price_off'];
								if($classieraPriceSection == 1){
								?>
								<?php if(!empty($post_price)){?>
								<li>
                                    <p><?php esc_html_e( 'Sale Price', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<?php 
										if(is_numeric($post_price)){
											echo $classieraCurrencyTag.$post_price;
										}else{
											echo $post_price;
										}
										?>
									</span>
									</p>
                                </li><!--Sale Price-->
								<?php } ?>
								<?php if(!empty($post_old_price)){?>
								<li>
                                    <p><?php esc_html_e( 'Regular Price', 'classiera' ); ?>: 
									<span class="pull-right flip">										
										<?php 
										if(is_numeric($post_old_price)){
											echo $classieraCurrencyTag.$post_old_price;
										}else{
											echo $post_old_price;
										}
										?>
									</span>
									</p>
                                </li><!--Regular Price-->
								<?php } ?>
								<!--Price Section -->
								<?php } ?>
								<?php if(!empty($itemCondition)){?>
								<li>
                                    <p><?php esc_html_e( 'Condition', 'classiera' ); ?>: 
									<span class="pull-right flip"><?php echo $itemCondition; ?></span>
									</p>
                                </li><!--Condition-->
								<?php } ?>
								<?php if(!empty($post_location)){?>
								<li>
                                    <p><?php esc_html_e( 'Location', 'classiera' ); ?>: 
									<span class="pull-right flip"><?php echo $post_location; ?></span>
									</p>
                                </li><!--Location-->
								<?php } ?>
								<?php if(!empty($post_state)){?>
								<li>
                                    <p><?php esc_html_e( 'State', 'classiera' ); ?>: 
									<span class="pull-right flip"><?php echo $post_state; ?></span>
									</p>
                                </li><!--state-->
								<?php } ?>
								<?php if(!empty($post_city)){?>
								<li>
                                    <p><?php esc_html_e( 'City', 'classiera' ); ?>: 
									<span class="pull-right flip"><?php echo $post_city; ?></span>
									</p>
                                </li><!--City-->
								<?php } ?>
								<?php if(!empty($post_phone)){?>
								<li>
                                    <p><?php esc_html_e( 'Phone', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo $post_phone; ?>"><?php echo $post_phone; ?></a>
									</span>
									</p>
                                </li><!--Phone-->
								<?php } ?>
								<li>
                                    <p><?php esc_html_e( 'Views', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<?php echo classiera_get_post_views(get_the_ID()); ?>
									</span>
									</p>
                                </li><!--Views-->
								<?php 
								if(!empty($classieraCustomFields)) {
									for ($i = 0; $i < count($classieraCustomFields); $i++){
										if($classieraCustomFields[$i][2] != 'dropdown' && $classieraCustomFields[$i][2] != 'checkbox'){
											if(!empty($classieraCustomFields[$i][1]) && !empty($classieraCustomFields[$i][0]) ) {
												?>
											<li>
												<p><?php echo $classieraCustomFields[$i][0]; ?>: 
												<span class="pull-right flip">
													<?php echo $classieraCustomFields[$i][1]; ?>
												</span>
												</p>
											</li><!--test-->	
												<?php
											}
										}
									}
									for ($i = 0; $i < count($classieraCustomFields); $i++){
										if($classieraCustomFields[$i][2] == 'dropdown'){
											if(!empty($classieraCustomFields[$i][1]) && !empty($classieraCustomFields[$i][0]) ){
											?>
											<li>
												<p><?php echo $classieraCustomFields[$i][0]; ?>: 
												<span class="pull-right flip">
													<?php echo $classieraCustomFields[$i][1]; ?>
												</span>
												</p>
											</li><!--dropdown-->
											<?php
											}
										}
									}
									for ($i = 0; $i < count($classieraCustomFields); $i++){
										if($classieraCustomFields[$i][2] == 'checkbox'){
											if(!empty($classieraCustomFields[$i][1]) && !empty($classieraCustomFields[$i][0]) ){
											?>
											<li>
												<p><?php echo $classieraCustomFields[$i][0]; ?>: 
												<span class="pull-right flip">
													<?php esc_html_e( 'Yes', 'classiera' ); ?>
												</span>
												</p>
											</li><!--dropdown-->
											<?php	
											}
										}
									}
								}
								?>
                            </ul>
                        </div><!--post-details-->
                    </div>
					<!-- ad deails -->
					<!--PostVideo-->
					<?php if(!empty($postVideo)) { ?>
					<div class="border-section border postvideo">
						<h4 class="border-section-heading text-uppercase">
						<?php esc_html_e( 'Video', 'classiera' ); ?>
						</h4>
						<?php 
						if(preg_match("/youtu.be\/[a-z1-9.-_]+/", $postVideo)) {
							preg_match("/youtu.be\/([a-z1-9.-_]+)/", $postVideo, $matches);
							if(isset($matches[1])) {
								$url = 'http://www.youtube.com/embed/'.$matches[1];
								$video = '<iframe class="embed-responsive-item" src="'.$url.'" frameborder="0" allowfullscreen></iframe>';
							}
						}elseif(preg_match("/youtube.com(.+)v=([^&]+)/", $postVideo)) {
							preg_match("/v=([^&]+)/", $postVideo, $matches);
							if(isset($matches[1])) {
								$url = 'http://www.youtube.com/embed/'.$matches[1];
								$video = '<iframe class="embed-responsive-item" src="'.$url.'" frameborder="0" allowfullscreen></iframe>';
							}
						}elseif(preg_match("#https?://(?:www\.)?vimeo\.com/(\w*/)*(([a-z]{0,2}-)?\d+)#", $postVideo)) {
							preg_match("/vimeo.com\/([1-9.-_]+)/", $postVideo, $matches);
							//print_r($matches); exit();
							if(isset($matches[1])) {
								$url = 'https://player.vimeo.com/video/'.$matches[1];
								$video = '<iframe class="embed-responsive-item" src="'.$url.'" frameborder="0" allowfullscreen webkitallowfullscreen mozallowfullscreen></iframe>';
							}
						}else{
							$video = $postVideo;
						}
						?>
						<div class="embed-responsive embed-responsive-16by9">
							<?php echo $video; ?>
						</div>
					</div>
					<?php } ?>
					<!--PostVideo-->
					<!-- post description -->
					<div class="border-section border description">
						<h4 class="border-section-heading text-uppercase">
						<?php esc_html_e( 'Description', 'classiera' ); ?>
						</h4>
						<?php echo the_content(); ?>
						<div class="tags">
                            <span>
                                <i class="fa fa-tags"></i>
                                <?php esc_html_e( 'Tags', 'classiera' ); ?> :
                            </span>
							<?php the_tags('','',''); ?>
                        </div>
					</div>
					<!-- post description -->
					<!--comments-->
					<?php if($classieraComments == 1){?>
					<div class="border-section border comments">
						<h4 class="border-section-heading text-uppercase"><?php esc_html_e( 'Comments', 'classiera' ); ?></h4>
						<?php 
						$file ='';
						$separate_comments ='';
						comments_template( $file, $separate_comments );
						?>
					</div>
					<?php } ?>
					<!--comments-->
				</div>
				<!-- single post -->
			</div><!--col-md-8-->
			<div class="col-md-4">
				<aside class="sidebar">
					<div class="row">
						<?php if($classieraSingleAdStyle == 1){?>
						<!--Widget for style 1-->
						<div class="col-lg-12 col-md-12 col-sm-6 match-height">
							<div class="widget-box <?php if($classieraSingleAdStyle == 2){echo "border-none";}?>">
								<?php 
								$classieraPriceSection = $redux_demo['classiera_sale_price_off'];
								if($classieraPriceSection == 1){
									/*PostMultiCurrencycheck*/
									$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
									if(!empty($post_currency_tag)){
										$classieraCurrencyTag = classiera_Display_currency_sign($post_currency_tag);
									}else{
										global $redux_demo;
										$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
									}
									/*PostMultiCurrencycheck*/
								?>
								<div class="widget-title price">
                                    <h3 class="post-price">
										<?php 
										if(is_numeric($post_price)){
											echo $classieraCurrencyTag.$post_price;
										}else{
											echo $post_price;
										}
										?>
									</h3>
                                </div><!--price-->
								<?php } ?>	
								<div class="widget-content widget-content-post">
                                    <div class="author-info border-bottom widget-content-post-area">
									<?php 
									$user_ID = $post->post_author;
									$authorName = get_the_author_meta('display_name', $user_ID );
									if(empty($authorName)){
										$authorName = get_the_author_meta('user_nicename', $user_ID );
									}
									if(empty($authorName)){
										$authorName = get_the_author_meta('user_login', $user_ID );
									}
									$author_avatar_url = get_user_meta($user_ID, "classify_author_avatar_url", true);
									$authorEmail = get_the_author_meta('user_email', $user_ID);
									$authorURL = get_the_author_meta('user_url', $user_ID);
									$authorPhone = get_the_author_meta('phone', $user_ID);
									if(empty($author_avatar_url)){										
										$author_avatar_url = classiera_get_avatar_url ($authorEmail, $size = '150' );
									}
									$UserRegistered = get_the_author_meta( 'user_registered', $user_ID );
									$dateFormat = get_option( 'date_format' );
									$classieraRegDate = date_i18n($dateFormat,  strtotime($UserRegistered));
									?>	
                                        <div class="media">
                                            <div class="media-left">
                                                <img class="media-object" src="<?php echo $author_avatar_url; ?>" alt="<?php echo $authorName; ?>">
                                            </div><!--media-left-->
                                            <div class="media-body">
                                                <h5 class="media-heading text-uppercase">
													<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo $authorName; ?></a>
												</h5>
                                                <p><?php esc_html_e('Member Since', 'classiera') ?>&nbsp;<?php echo $classieraRegDate;?></p>
                                                <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php esc_html_e( 'see all ads', 'classiera' ); ?></a>
												<?php if ( is_user_logged_in()){ 
													$current_user = wp_get_current_user();
													$user_id = $current_user->ID;
													if(isset($user_id)){
														if($user_ID != $user_id){							
															echo classiera_authors_follower_check($user_ID, $user_id);
														}
													}
												}												
												?>
												
                                            </div><!--media-body-->
                                        </div><!--media-->
                                    </div><!--author-info-->
                                </div><!--widget-content-->
								<div class="widget-content widget-content-post">
                                    <div class="contact-details widget-content-post-area">
                                        <h5 class="text-uppercase"><?php esc_html_e('Contact Details', 'classiera') ?> :</h5>
                                        <ul class="list-unstyled fa-ul c-detail">
											<?php if(!empty($authorPhone)){?>
                                            <li><i class="fa fa-li fa-phone-square"></i>&nbsp;
												<span class="phNum" data-replace="<?php echo $authorPhone;?>"><?php echo $authorPhone;?></span>
												<button type="button" id="showNum"><?php esc_html_e('Reveal', 'classiera') ?></button>
											</li>
											<?php } ?>
											<?php if(!empty($authorURL)){?>
                                            <li><i class="fa fa-li fa-globe"></i> 
												<a href="<?php echo $authorURL; ?>"><?php echo $authorURL; ?></a>
											</li>
											<?php } ?>
											<?php if(!empty($authorEmail)){?>
                                            <li><i class="fa fa-li fa-envelope"></i> 
												<a href="mailto:<?php echo $authorEmail; ?>"><?php echo $authorEmail; ?></a>
											</li>
											<?php } ?>
                                        </ul>
                                    </div><!--contact-details-->
                                </div><!--widget-content-->
							</div><!--widget-box-->
						</div><!--col-lg-12 col-md-12 col-sm-6 match-height-->
						<?php } ?>
						<!--Widget for style 1-->
						<div class="col-lg-12 col-md-12 col-sm-6 match-height">
							<div class="widget-box <?php if($classieraSingleAdStyle == 2){echo "border-none";}?>">
								<?php 
								$classieraWidgetClass = "widget-content-post";
								$classieraMakeOffer = "user-make-offer-message widget-content-post-area";
								if($classieraSingleAdStyle == 1){
									$classieraWidgetClass = "widget-content-post";
									$classieraMakeOffer = "user-make-offer-message widget-content-post-area";
								}elseif($classieraSingleAdStyle == 2){
									$classieraWidgetClass = "removePadding";
									$classieraMakeOffer = "user-make-offer-message widget-content-post-area border-none removePadding";
								}
								?>
								<div class="widget-content <?php echo $classieraWidgetClass; ?>">
									<div class="<?php echo $classieraMakeOffer; ?>">
										<ul class="nav nav-tabs" role="tablist">
											<?php if($classieraToAuthor == 1){?>
                                            <li role="presentation" class="active">
                                                <a href="#message" aria-controls="message" role="tab" data-toggle="tab"><i class="fa fa-envelope"></i><?php esc_html_e('Send Message', 'classiera') ?></a>
                                            </li>
											<?php } ?>
											<?php 
											$classieraPriceSection = $redux_demo['classiera_sale_price_off'];
											if($classieraPriceSection == 1){
											?>
                                            <li role="presentation">
                                                <a href="#offer" aria-controls="offer" role="tab" data-toggle="tab"> <?php esc_html_e('Make offer', 'classiera') ?></a>
                                            </li>
											<?php } ?>
                                        </ul><!--nav nav-tabs-->
										<!-- Tab panes -->
										<div class="tab-content">
											<?php if($classieraToAuthor == 1){?>
											<div role="tabpanel" class="tab-pane active" id="message">
											<!--ShownMessage-->
											<?php if(isset($_POST['submit']) && $_POST['submit'] == 'send_message'){?>
												<div class="row">
													<div class="col-lg-12">
														<?php if($hasError == true){ ?>
														<div class="alert alert-warning">
															<?php echo $errorMessage; ?>
														</div>
														<?php } ?>
														<?php if($emailSent == true){ ?>
														<div class="alert alert-success">
															<?php echo $classieraContactThankyou; ?>
														</div>
														<?php } ?>
													</div>
												</div>
												<?php } ?>
												<!--ShownMessage-->
												<form method="post" class="form-horizontal" data-toggle="validator" name="contactForm" action="<?php the_permalink(); ?>">
													<div class="form-group">
                                                        <label class="col-sm-3 control-label" for="name"><?php esc_html_e('Name', 'classiera') ?> :</label>
                                                        <div class="col-sm-9">
                                                            <input id="name" data-minlength="5" type="text" class="form-control form-control-xs" name="contactName" placeholder="<?php esc_html_e('Type your name', 'classiera') ?>" required>
                                                        </div>
                                                    </div><!--name-->
													<div class="form-group">
                                                        <label class="col-sm-3 control-label" for="email"><?php esc_html_e('Email', 'classiera') ?> :</label>
                                                        <div class="col-sm-9">
                                                            <input id="email" type="email" class="form-control form-control-xs" name="email" placeholder="<?php esc_html_e('Type your email', 'classiera') ?>" required>
                                                        </div>
                                                    </div><!--Email-->
													<div class="form-group">
                                                        <label class="col-sm-3 control-label" for="subject"><?php esc_html_e('Subject', 'classiera') ?> :</label>
                                                        <div class="col-sm-9">
                                                            <input id="subject" type="text" class="form-control form-control-xs" name="subject" placeholder="<?php esc_html_e('Type your subject', 'classiera') ?>" required>
                                                        </div>
                                                    </div><!--Subject-->
													<div class="form-group">
                                                        <label class="col-sm-3 control-label" for="msg"><?php esc_html_e('Msg', 'classiera') ?> :</label>
                                                        <div class="col-sm-9">
                                                            <textarea id="msg" name="comments" class="form-control" placeholder="<?php esc_html_e('Type Message', 'classiera') ?>" required></textarea>
                                                        </div>
                                                    </div><!--Message-->
													<?php 
														$classieraFirstNumber = rand(1,9);
														$classieraLastNumber = rand(1,9);
														$classieraNumberAnswer = $classieraFirstNumber + $classieraLastNumber;
													?>
													<div class="form-group">
														<div class="col-sm-9">
															<p>
															<?php esc_html_e("Please input the result of ", "classiera"); ?>
															<?php echo $classieraFirstNumber; ?> + <?php echo $classieraLastNumber;?> = 
															</p>
														</div>
													</div>
													<div class="form-group">
                                                        <label class="col-sm-3 control-label" for="humanTest"><?php esc_html_e('Answer', 'classiera') ?> :</label>
                                                        <div class="col-sm-9">
                                                            <input id="humanTest" type="text" class="form-control form-control-xs" name="humanTest" placeholder="<?php esc_html_e('Your answer', 'classiera') ?>" required>
															<input type="hidden" name="humanAnswer" id="humanAnswer" value="<?php echo $classieraNumberAnswer; ?>" />
															<input type="hidden" name="classiera_post_title" id="classiera_post_title" value="<?php the_title(); ?>" />
															<input type="hidden" name="classiera_post_url" id="classiera_post_url" value="<?php the_permalink(); ?>"  />
                                                        </div>
                                                    </div><!--answer-->
													<input type="hidden" name="submit" value="send_message" />
													<button class="btn btn-primary btn-block btn-sm sharp btn-style-one" name="send_message" value="send_message" type="submit"><?php esc_html_e( 'Send Message', 'classiera' ); ?></button>
												</form>
											</div><!--message-->
											<?php } ?>
											<?php 
											$classieraPriceSection = $redux_demo['classiera_sale_price_off'];
											if($classieraPriceSection == 1){
											?>
											<div role="tabpanel" class="tab-pane <?php if($classieraToAuthor != 1){ echo "active"; }?>" id="offer">
												<form method="post" class="form-horizontal classieraOffer" data-toggle="validator" name="offerForm" id="offerForm" action="<?php the_permalink(); ?>">
													<span class="classiera--loader"><img src="<?php echo get_template_directory_uri().'/images/loader.gif' ?>" alt="classiera loader"></span>
													<div class="classieraAjaxResult"></div>
													<div class="form-group">
                                                        <label class="col-sm-3 control-label"><?php esc_html_e( 'Price', 'classiera' ); ?></label>
                                                        <div class="col-sm-9">
                                                            <p class="form-control-static"><?php echo $classieraCurrencyTag.$post_price; ?></p>
                                                        </div>
                                                    </div><!--Price-->
													<div class="form-group">
                                                        <label class="col-sm-3 control-label" for="offer-text"><?php esc_html_e( 'Offer', 'classiera' ); ?> :</label>
                                                        <div class="col-sm-9">
                                                            <input id="offer-text" type="number" name="offer_price" class="form-control form-control-xs" placeholder="<?php esc_html_e( 'Your Offer', 'classiera' ); ?>" required>
                                                        </div>
                                                    </div><!--NewOffer-->
													<div class="form-group">
                                                        <label class="col-sm-3 control-label" for="email-offer"><?php esc_html_e( 'Email', 'classiera' ); ?> :</label>
                                                        <div class="col-sm-9">
                                                            <input id="email-offer" type="email" class="form-control form-control-xs" name="offer_email" placeholder="<?php esc_html_e( 'Type your email', 'classiera' ); ?>" required>
                                                        </div>
                                                    </div><!--email-->
													<input type="hidden" id="classiera_current_price" name="classiera_current_price" value="<?php echo $classieraCurrencyTag.$post_price; ?>" />
													<input type="hidden" id="classiera_author_email" name="classiera_author_email" value="<?php echo $contact_email; ?>" />
													<input type="hidden" name="classiera_post_title" id="classiera_post_title" value="<?php the_title(); ?>" />
													<input type="hidden" name="classiera_post_url" id="classiera_post_url" value="<?php the_permalink(); ?>"  />
													<input type="hidden" name="submit" value="make_offer" />
													<button class="btn btn-primary btn-block btn-sm sharp btn-style-one" name="make_offer" value="make_offer" type="submit"><?php esc_html_e( 'Send Offer', 'classiera' ); ?></button>
												</form>	
											</div><!--offer-->
											<?php } ?>
										</div><!--tab-content-->
										<!-- Tab panes -->
									</div><!--user-make-offer-message-->
								</div><!--widget-content-->
							</div><!--widget-box-->
						</div><!--col-lg-12 col-md-12 col-sm-6 match-height-->
						<div class="col-lg-12 col-md-12 col-sm-6 match-height">
							<div class="widget-box <?php if($classieraSingleAdStyle == 2){echo "border-none";}?>">
								<!--ReportAd-->
								<div class="widget-content widget-content-post">
									<div class="user-make-offer-message border-bottom widget-content-post-area">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="btnWatch">    
											<?php if ( is_user_logged_in()){ 
													$current_user = wp_get_current_user();
													$user_id = $current_user->ID;
												}
												if(isset($user_id)){
													echo classiera_authors_favorite_check($user_id,$post->ID); 
												}
												?>
                                            </li>
                                            <li role="presentation" class="active">
                                                <a href="#report" aria-controls="report" role="tab" data-toggle="tab"><i class="fa fa-exclamation-triangle"></i> <?php esc_html_e( 'Report', 'classiera' ); ?></a>
                                            </li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="report">
												<form method="post" class="form-horizontal" data-toggle="validator">
													<?php if(!empty($displayMessage)){?>
													<div class="alert alert-success">
														<?php echo $displayMessage; ?>
													</div>
													<?php } ?>
                                                    <div class="radio">
                                                        <input id="illegal" value="illegal" type="radio" name="report_ad_val">
                                                        <label for="illegal"><?php esc_html_e( 'This is illegal/fraudulent', 'classiera' ); ?></label>
                                                        <input id="spam" value="spam" type="radio" name="report_ad_val">
                                                        <label for="spam"><?php esc_html_e( 'This ad is spam', 'classiera' ); ?></label>
                                                        <input id="duplicate" value="duplicate" type="radio" name="report_ad_val">
                                                        <label for="duplicate"><?php esc_html_e( 'This ad is a duplicate', 'classiera' ); ?></label>
                                                        <input id="wrong_category" value="wrong_category" type="radio" name="report_ad_val">
                                                        <label for="wrong_category"><?php esc_html_e( 'This ad is in the wrong category', 'classiera' ); ?></label>
                                                        <input id="post_rules" value="post_rules" type="radio" name="report_ad_val">
                                                        <label for="post_rules"><?php esc_html_e( 'The ad goes against posting rules', 'classiera' ); ?></label>
														<input id="post_other" value="post_other" type="radio" name="report_ad_val">
                                                        <label for="post_other"><?php esc_html_e( 'Other', 'classiera' ); ?></label>														
                                                    </div>
													<div class="otherMSG">
														<textarea id="other_report" name="other_report" class="form-control"placeholder="<?php esc_html_e( 'Type here..!', 'classiera' ); ?>"></textarea>
													</div>
													<input type="hidden" name="classiera_post_title" id="classiera_post_title" value="<?php the_title(); ?>" />
													<input type="hidden" name="classiera_post_url" id="classiera_post_url" value="<?php the_permalink(); ?>"  />
													<input type="hidden" name="submit" value="report_to_admin" />
                                                    <button class="btn btn-primary btn-block btn-sm sharp btn-style-one" name="report_ad" value="report_ad" type="submit"><?php esc_html_e( 'Report', 'classiera' ); ?></button>
                                                </form>
                                            </div><!--tabpanel-->
                                        </div><!--tab-content-->
                                    </div><!--user-make-offer-message-->
								</div><!--widget-content-->
								<!--ReportAd-->
							</div><!--widget-box-->
						</div><!--col-lg-12 col-md-12 col-sm-6 match-height-->
						<div class="col-lg-12 col-md-12 col-sm-6 match-height">
							<div class="widget-box <?php if($classieraSingleAdStyle == 2){echo "border-none";}?>">
								<!--Share-->
								<div class="widget-content widget-content-post">
                                    <div class="share border-bottom widget-content-post-area">
                                        <h5><?php esc_html_e( 'Share ad', 'classiera' ); ?>:</h5>
										<!--AccessPress Socil Login-->
										<?php
										include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
										if ( is_plugin_active( "accesspress-social-share/accesspress-social-share.php" )){
											echo do_shortcode('[apss-share]');
										}								
										?>
										<!--AccessPress Socil Login-->
                                    </div>
                                </div>
								<!--Share-->
							</div><!--widget-box-->
						</div><!--col-lg-12 col-md-12 col-sm-6 match-height-->
						<div class="col-lg-12 col-md-12 col-sm-6 match-height">
							<div class="widget-box <?php if($classieraSingleAdStyle == 2){echo "border-none";}?>">
								<!--GoogleMAP-->
								<?php 
								global $redux_demo;
								$googleMapadPost = $redux_demo['google-map-adpost'];
								$locShownBy = $redux_demo['location-shown-by'];
								$post_location = get_post_meta($post->ID, $locShownBy, true);
								$post_latitude = get_post_meta($post->ID, 'post_latitude', true);
								$post_longitude = get_post_meta($post->ID, 'post_longitude', true);
								$post_address = get_post_meta($post->ID, 'post_address', true);
								if($googleMapadPost == 1){
								?>
								<div class="widget-content widget-content-post">
                                    <div class="share widget-content-post-area">
                                        <h5><?php echo $post_location; ?></h5>
                                        <?php if(!empty($post_latitude)){?>
										<div id="single-page-map">
										<div id="single-page-main-map"></div>

										<script type="text/javascript">
										var mapDiv,
											map,
											infobox;
										jQuery(document).ready(function($) {

											mapDiv = $("#single-page-main-map");
											mapDiv.height(300).gmap3({
												map: {
													options: {
														"center": [<?php echo $post_latitude; ?>,<?php echo $post_longitude; ?>]
														,"zoom": 16
														,"draggable": true
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

														$post_latitude = get_post_meta($post->ID, 'post_latitude', true);
														$post_longitude = get_post_meta($post->ID, 'post_longitude', true);

														$theTitle = get_the_title(); $theTitle = (strlen($theTitle) > 40) ? substr($theTitle,0,37).'...' : $theTitle;

														$post_price = get_post_meta($post->ID, 'post_price', true);

										
										$category = get_the_category();
											if ($category[0]->category_parent == 0) {
												$tag = $category[0]->cat_ID;
												$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
												if (isset($tag_extra_fields[$tag])) {
													$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
													$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
													$your_image_url = $tag_extra_fields[$tag]['your_image_url'];
												}
											}else{
												$tag = $category[0]->category_parent;
												$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
												if (isset($tag_extra_fields[$tag])) {
													$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
													$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
													$your_image_url = $tag_extra_fields[$tag]['your_image_url'];
												}
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
														if(!empty($your_image_url)) {

															$iconPath = $your_image_url;

														} else {

															$iconPath = get_template_directory_uri() .'/images/icon-services.png';

														}
														$postCatgory = get_the_category( $post->ID );

														?>

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
																	data: '<section id="advertisement" class="removePad removeMargin noBorder"><div class="row"><div class="advContent"><div class="tabs-content removeMargin"><div class="large-12 medium-12 columns advItems end removeMargin"><div class="advItem"> <div class="advItem-img" id="AdvMapImg"><img src="<?php echo $imageurl[0]; ?>" alt="<?php if(empty($alt)){echo "Image";}else{ echo $alt; } ; ?>" /></div><span class="price"><?php echo $classieraCurrencyTag.$post_price; ?></span><a class="hover" href="<?php the_permalink(); ?>"></a><div class="info"><a href="<?php the_permalink(); ?>"><i class="<?php echo $category_icon_code; ?>" style="background-color:<?php echo $category_icon_color; ?>"></i><span class="title"><?php echo $theTitle; ?></span><span class="cat">category &nbsp;:&nbsp;<?php echo $postCatgory[0]->name; ?><span></a></div></div></div></div><div class="close"></div></div></div></section>'
																}	
														
													],
													options:{
														draggable: false
													},
													cluster:{
														radius: 20,
														// This style will be used for clusters with more than 0 markers
														0: {
															content: "<div class='cluster cluster-1'>CLUSTER_COUNT</div>",
															width: 62,
															height: 62
														},
														// This style will be used for clusters with more than 20 markers
														20: {
															content: "<div class='cluster cluster-2'>CLUSTER_COUNT</div>",
															width: 82,
															height: 82
														},
														// This style will be used for clusters with more than 50 markers
														50: {
															content: "<div class='cluster cluster-3'>CLUSTER_COUNT</div>",
															width: 102,
															height: 102
														},
														events: {
															click: function(cluster) {
																map.panTo(cluster.main.getPosition());
																map.setZoom(map.getZoom() + 2);
															}
														}
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
															var iWidth = 300;
															var iHeight = 300;
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
															});

											map = mapDiv.gmap3("get");

											infobox = new InfoBox({
												pixelOffset: new google.maps.Size(-50, -65),
												closeBoxURL: '',
												enableEventPropagation: true
											});
											mapDiv.delegate('.infoBox .close','click',function () {
												infobox.close();
											});

											/*if (Modernizr.touch){
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
											}*/

										});
										</script>
									<!--<div id="ad-address"><span><i class="fa fa-map-marker"></i><?php //echo $post_address; ?></span></div>-->
										<div id="ad-address">
											<span>
											<i class="fa fa-map-marker"></i>
											<a href="http://maps.google.com/maps?saddr=&daddr=<?php echo $post_address; ?>" target="_blank">
												<?php esc_html_e( 'Get Directions on Google MAPS to', 'classiera' ); ?>: <?php echo $post_address; ?>
											</a>
											</span>
										</div>
									</div>
										<?php } ?>
                                    </div>
                                </div>
								<?php } ?>
								<!--GoogleMAP-->
							</div><!--widget-box-->
						</div><!--col-lg-12-->
						<!--SidebarWidgets-->
						<?php dynamic_sidebar('single'); ?>
						<!--SidebarWidgets-->
					</div><!--row-->
				</aside><!--sidebar-->
			</div><!--col-md-4-->
		</div><!--row-->
	</div><!--container-->
</section>
<?php endwhile; ?>
<!-- related post section -->
<?php 
global $redux_demo;
$relatedAdsOn = $redux_demo['related-ads-on'];
if($relatedAdsOn == 1){
	function related_Post_ID(){
		global $post;
		$post_Id = $post->ID;
		return $post_Id;
	}
	get_template_part( 'templates/related-ads' );
}
?>
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
<!-- related post section -->
<?php get_footer(); ?>