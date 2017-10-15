<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "off-canvas-wrap" div and all content after.
 *
 * @package WordPress
 * @subpackage ClassiEra
 * @since ClassiEra 1.0
 */

?>
<?php 
	global $redux_demo;
	$classieraCopyRight = $redux_demo['footer_copyright'];
	$classierabackToTop = $redux_demo['backtotop'];
	$classieraFooterWidgets = $redux_demo['footer_widgets_area_on'];
	$classieraFooterStyle = $redux_demo['classiera_footer_style'];
	$classieraFooterBottomStyle = $redux_demo['classiera_footer_bottom_style'];
	$footerStyleClass = 'section-bg-black section-bg-light-img';
	$classieraFacebook = $redux_demo['facebook-link'];
	$classieraTwitter = $redux_demo['twitter-link'];
	$classieraDribbble = $redux_demo['dribbble-link'];
	$classieraFlickr = $redux_demo['flickr-link'];
	$classieraGithub = $redux_demo['github-link'];
	$classieraPinterest = $redux_demo['pinterest-link'];	
	$classieraYouTube = $redux_demo['youtube-link'];
	$classieraGoogle = $redux_demo['google-plus-link'];
	$classieraLinkedin = $redux_demo['linkedin-link'];
	$classieraInstagram = $redux_demo['instagram-link'];
	$classieraVimeo = $redux_demo['vimeo-link'];
	if($classieraFooterStyle == 'three'){
		$footerStyleClass = 'section-bg-black section-bg-light-img';
	}elseif($classieraFooterStyle == 'four'){
		$footerStyleClass = 'section-bg-black four-columns-footer';
	}
?>
<footer class="<?php if($classieraFooterWidgets == 1){ echo "section-pad"; }?> <?php echo $footerStyleClass; ?>">
	<div class="container">
		<div class="row">
			<?php if($classieraFooterWidgets == 1){ ?>
			<?php dynamic_sidebar( 'footer-one' ); ?>
			<?php } ?>
		</div><!--row-->
	</div><!--container-->
</footer>
<section class="footer-bottom">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-sm-6">
				<p><?php echo $classieraCopyRight; ?></p>
			</div>
			<div class="col-lg-6 col-sm-6">
				<?php if($classieraFooterBottomStyle == 'menu'){?>
				<?php classieraFooterNav(); ?>
				<?php }elseif($classieraFooterBottomStyle == 'icon'){
					?>
					<ul class="footer-bottom-social-icon">
						<li><span><?php esc_html_e( 'Follow Us', 'classiera' ); ?> :</span></li>
						
						<?php if(!empty($classieraFacebook)){?>
						<li>
							<a href="<?php echo $classieraFacebook; ?>" class="rounded text-center" target="_blank">
								<i class="fa fa-facebook"></i>
							</a>
						</li>
						<?php } ?>
						<?php if(!empty($classieraTwitter)){?>
						<li>
							<a href="<?php echo $classieraTwitter; ?>" class="rounded text-center" target="_blank">
								<i class="fa fa-twitter"></i>
							</a>
						</li>
						<?php } ?>
						<?php if(!empty($classieraGoogle)){?>
						<li>
							<a href="<?php echo $classieraGoogle; ?>" class="rounded text-center" target="_blank">
								<i class="fa fa-google-plus"></i>
							</a>
						</li>
						<?php } ?>
						<?php if(!empty($classieraPinterest)){?>
						<li>
							<a href="<?php echo $classieraPinterest; ?>" class="rounded text-center" target="_blank">
								<i class="fa fa-pinterest-p"></i>
							</a>
						</li>
						<?php } ?>
						<?php if(!empty($classieraInstagram)){?>
						<li>
							<a href="<?php echo $classieraInstagram; ?>" class="rounded text-center" target="_blank">
								<i class="fa fa-instagram"></i>
							</a>
						</li>
						<?php } ?>
					</ul>
					<?php
				}?>
			</div>
		</div><!--row-->
	</div><!--container-->
</section>
<?php if($classierabackToTop == 1){?>
	<!-- back to top -->
	<a href="#" id="back-to-top" title="<?php esc_html_e( 'Back to top', 'classiera' ); ?>" class="social-icon social-icon-md"><i class="fa fa-angle-double-up removeMargin"></i></a>
<?php } ?>
<?php wp_footer(); ?>
</body>
</html>