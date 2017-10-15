<?php
/**
 * Template Name: Contact
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */

global $redux_demo; 
$contactMAP = $redux_demo['contact-map'];
$contact_email = $redux_demo['contact-email'];
$classieraContactEmailError = $redux_demo['contact-email-error'];
$classieraContactNameError = $redux_demo['contact-name-error'];
$classieraConMsgError = $redux_demo['contact-message-error'];
$classieraContactThankyou = $redux_demo['contact-thankyou-message'];

$classieraContactLatitude = $redux_demo['contact-latitude'];
$classieraContactLongitude = $redux_demo['contact-longitude'];
$ClassieraContactZoomLevel = $redux_demo['contact-zoom'];
$contactAddress = $redux_demo['contact-address'];
$contactPhone = $redux_demo['contact-phone'];
$contactPhone2 = $redux_demo['contact-phone2'];
$caticoncolor="";
$category_icon_code ="";
$category_icon="";
$category_icon_color="";

$hasError = false;
$errorMessage = "";
$emailSent = false;


//If the form is submitted
if(isset($_POST['submitted'])) {		
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
			$errorMessage = $classieraConMsgError;
			$hasError = true;
		} elseif(trim($_POST['subject']) === 'Subject*') {
			$errorMessage = $classieraConMsgError;
			$hasError = true;
		}	else {
			$subject = trim($_POST['subject']);
		}		
		//Check to make sure sure that a valid email address is submitted
		if(trim($_POST['email']) === '')  {
			$errorMessage = $classieraContactEmailError;
			$hasError = true;
		} else if (!preg_match("/^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$/i", trim($_POST['email']))) {
			$errorMessage = $classieraContactEmailError;
			$hasError = true;
		} else {
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
		$classierahumanTest = trim($_POST['humanTest']);		
		if($classierahumanTest != $classieraCheckAnswer) {
			$errorMessage = esc_html__('Not Human', 'classiera');
			$hasError = true;
		}			
		//If there is no error, send the email
		if($hasError == false){			
			$emailTo = $contact_email;
			$subject = $subject;	
			$body = "Nume: $name \n\nEmail: $email \n\nComments: $comments";
			$headers = 'From website <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;			
			wp_mail($emailTo, $subject, $body, $headers);

			$emailSent = true;
		}		
}

get_header(); ?>
<?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php if($contactMAP == 1){?>
<div id="map">
    <div id="classiera-main-map"></div>
	<script type="text/javascript">
		var mapDiv,
			map,
			infobox;
		jQuery(document).ready(function($) {
			mapDiv = $("#classiera-main-map");
			mapDiv.height(500).gmap3({
				map: {
					options: {
						"center":[<?php echo $classieraContactLatitude; ?>,<?php echo $classieraContactLongitude; ?>],
						"zoom": <?php echo $ClassieraContactZoomLevel; ?>
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
					latLng: [<?php echo $classieraContactLatitude; ?>,<?php echo $classieraContactLongitude; ?>]
				}
			});

			map = mapDiv.gmap3("get");
		});
	</script>
</div>
<?php } ?>
<!--PageContent-->
<section class="contact-us border-bottom section-pad">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<?php the_content(); ?>
			</div>
		</div><!--row-->
	</div><!--container-->
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<h4 class="text-uppercase"><?php esc_html_e('Contact Form', 'classiera') ?></h4>
				<?php if(isset($_POST['submitted'])){?>				
				<div class="row">
					<div class="col-lg-12">
						<?php if(!empty($errorMessage)){ ?>
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
				<form name="contactForm" action="<?php the_permalink(); ?>" id="contact-form" method="post" data-toggle="validator">
					<div class="form-group">
						<div class="form-inline row">
							<div class="form-group col-sm-6">
                                <label class="text-capitalize" for="name"><?php esc_html_e( 'Full name', 'classiera' ); ?> : <span class="text-danger">*</span> </label>
                                <div class="inner-addon left-addon">
                                    <i class="left-addon form-icon fa fa-font"></i>
                                    <input id="name" type="text" name="contactName" class="form-control form-control-md" placeholder="<?php esc_html_e( 'Enter your full name', 'classiera' ); ?>" data-error="<?php esc_html_e( 'Name Requried', 'classiera' ); ?>" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div><!--Name Div-->
							<div class="form-group col-sm-6">
                                <label class="text-capitalize" for="email"><?php esc_html_e( 'Email', 'classiera' ); ?> : <span class="text-danger">*</span></label>
                                <div class="inner-addon left-addon">
                                    <i class="left-addon form-icon fa fa-envelope"></i>
                                    <input id="email" type="text" name="email" class="form-control form-control-md" placeholder="<?php esc_html_e( 'Enter your email', 'classiera' ); ?>" data-error="<?php esc_html_e( 'Email required', 'classiera' ); ?>" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div><!--Email-->
							<div class="form-group col-sm-6">
                                <label class="text-capitalize" for="phone"><?php esc_html_e( 'Phone', 'classiera' ); ?> : <span class="text-danger">*</span> </label>
                                <div class="inner-addon left-addon">
                                    <i class="left-addon form-icon fa fa-phone"></i>
                                    <input id="phone" type="text" name="phone" class="form-control form-control-md" placeholder="<?php esc_html_e( 'Enter your phone number', 'classiera' ); ?>">
                                </div>
                            </div><!--Phone Div-->
							<div class="form-group col-sm-6">
                                <label class="text-capitalize" for="subject"><?php esc_html_e( 'Subject', 'classiera' ); ?> : <span class="text-danger">*</span></label>
                                <div class="inner-addon left-addon">
                                    <i class="left-addon form-icon fa fa-book"></i>
                                    <input id="subject" name="subject" type="text" class="form-control form-control-md" placeholder="<?php esc_html_e( 'Enter Subject', 'classiera' ); ?>" data-error="<?php esc_html_e( 'Subject Requried', 'classiera' ); ?>" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div><!--Subject Div-->
							<div class="form-group col-sm-12">
                                <label class="text-capitalize" for="text"><?php esc_html_e( 'Message', 'classiera' ); ?> : <span class="text-danger">*</span></label>
                                <div class="inner-addon">
                                    <textarea data-error="<?php esc_html_e( 'Please type message', 'classiera' ); ?>" name="comments" id="text" placeholder="<?php esc_html_e( 'Type your message here...!', 'classiera' ); ?>" required></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div><!--Message Div-->
							<?php 
								$classieraFirstNumber = rand(1,9);
								$classieraLastNumber = rand(1,9);
								$classieraNumberAnswer = $classieraFirstNumber + $classieraLastNumber;
							?>
							<div class="form-group col-sm-12">
								<div class="inner-addon left-addon">
									<h3>
									<?php esc_html_e('Human test. Please input the result of', 'classiera'); ?>
									<?php echo $classieraFirstNumber ?>&nbsp; + <?php echo $classieraLastNumber ?>
									</h3>
								</div>
							</div>
							<div class="form-group col-sm-6">
                                <label class="text-capitalize" for="humanTest"><?php esc_html_e( 'Security Question', 'classiera' ); ?> : <span class="text-danger">*</span></label>
                                <div class="inner-addon left-addon">
                                    <i class="left-addon form-icon fa fa-eye"></i>
                                    <input id="humanTest" type="text" name="humanTest" class="form-control form-control-md" placeholder="<?php esc_html_e('Your Answer', 'classiera'); ?>" data-error="<?php esc_html_e( 'Security Answer Requried', 'classiera' ); ?>" required>
                                    <div class="help-block with-errors"></div>
									<input type="hidden" name="humanAnswer" id="humanAnswer" value="<?php echo $classieraNumberAnswer; ?>" />
                                </div>
                            </div><!--Question Div-->
						</div><!--form-inline row-->
					</div><!--form-group-->
					<div class="form-group">
						<input type="hidden" name="submit" value="contact_form" id="submit" />
						<button class="btn btn-primary sharp btn-md btn-style-one" type="submit" value="submit" name="submitted"><?php esc_html_e('Send Message','classiera'); ?></button>
                    </div>
				</form>
			</div><!--col-lg-8-->
			<div class="col-lg-4">
                <h4 class="text-uppercase"><?php esc_html_e('Contact Info', 'classiera'); ?></h4>
                <ul class="contact-us-info list-unstyled fa-ul">
				<?php if(!empty($contactAddress)){ ?>
                    <li><i class="fa-li fa fa-map-marker"></i>
					<?php echo $contactAddress; ?>
					</li>
				<?php } ?>
				<?php if(!empty($contact_email)){ ?>
                    <li><i class="fa-li fa fa-envelope"></i>
						<?php echo $contact_email; ?>
					</li>
				<?php } ?>
				<?php if(!empty($contactPhone)){ ?>
                    <li><i class="fa-li fa fa-phone"></i>
						<?php echo $contactPhone; ?>
					</li>
				<?php } ?>	
				<?php if(!empty($contactPhone2)){ ?>
                    <li><i class="fa-li fa fa-phone"></i>
						<?php echo $contactPhone2; ?>
					</li>
				<?php } ?>
                </ul>
            </div><!--col-lg-4-->
		</div><!--row-->
	</div><!--container-->
</section>
<!--PageContent-->
<?php endwhile; endif; ?>
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