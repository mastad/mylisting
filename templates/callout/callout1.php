<?php 
global $redux_demo;
$calloutbg = $redux_demo['callout-bg']['url'];
$calloutbgV2 = $redux_demo['callout-bg-version2']['url'];
$calloutTitle = $redux_demo['callout_title'];
$calloutTitlesecond = $redux_demo['callout_title_second'];
$calloutDesc = $redux_demo['callout_desc'];
$calloutBtnTxt = $redux_demo['callout_btn_text'];
$calloutBtnIcon = $redux_demo['callout_btn_icon_code'];
$calloutBtnURL = $redux_demo['callout_btn_url'];
$featuredAdsPage = $redux_demo['featured_plans'];
$calloutBtnTxtTwo = $redux_demo['callout_btn_text_two'];
$calloutBtnIconTwo = $redux_demo['callout_btn_icon_code_two'];
$calloutBtnURLTwo = $redux_demo['callout_btn_url_two'];
?>	
<section class="members" style="background-image:url(<?php echo $calloutbg; ?>)">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="members-text">
                    <h1><?php echo $calloutTitle; ?></h1>
                    <h3><?php echo $calloutTitlesecond; ?></h3>
                    <p><?php echo $calloutDesc; ?></p>
                    <a href="<?php echo $calloutBtnURL; ?>" class="btn sharp btn-primary btn-style-one btn-sm">
						<?php if(is_rtl()){?>
							<?php echo $calloutBtnTxt; ?><i class="icon-left <?php echo $calloutBtnIcon; ?>"></i>
						<?php }else{ ?>
							<i class="icon-left <?php echo $calloutBtnIcon; ?>"></i><?php echo $calloutBtnTxt; ?>
						<?php } ?>
					</a>
                    <a href="<?php echo $calloutBtnURLTwo; ?>" class="btn sharp btn-primary btn-style-one btn-sm">
						<?php if(is_rtl()){?>
							<?php echo $calloutBtnTxtTwo; ?><i class="icon-left <?php echo $calloutBtnIconTwo; ?>"></i>
						<?php }else{ ?>
							<i class="icon-left <?php echo $calloutBtnIconTwo; ?>"></i><?php echo $calloutBtnTxtTwo; ?>
						<?php } ?>
					</a>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 hidden-xs hidden-sm">
                <div class="people-img pull-right flip">
                    <img class="img-responsive" src="<?php echo $calloutbgV2; ?>">
                </div>
            </div>
        </div>
    </div>
</section><!-- /.Memebers -->