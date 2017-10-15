<?php 
global $redux_demo;
$calloutbg = $redux_demo['callout-bg']['url'];
$calloutbgV2 = $redux_demo['callout-bg-version2']['url'];
$calloutTitle = $redux_demo['callout_title'];
$calloutTitlesecond = $redux_demo['callout_title_second'];
$calloutDesc = $redux_demo['callout_desc'];
$calloutBtnTxt = $redux_demo['callout_btn_text'];
$calloutBtnURL = $redux_demo['callout_btn_url'];
$featuredAdsPage = $redux_demo['featured_plans'];
$calloutBtnIcon = $redux_demo['callout_btn_icon_code'];
$calloutBtnIconTwo = $redux_demo['callout_btn_icon_code_two'];
$calloutBtnTxtTwo = $redux_demo['callout_btn_text_two'];
$calloutBtnURLTwo = $redux_demo['callout_btn_url_two'];
?>
<section class="members-v3" style="background-image:url(<?php echo $calloutbg; ?>)">
	<div class="container">
        <div class="row">
            <div class="col-lg-5 col-sm-12">
                <div class="members-text text-left flip">
                    <h1><?php echo $calloutTitle; ?></h1>
                    <h2><?php echo $calloutTitlesecond; ?></h2>
                    <p><?php echo $calloutDesc; ?></p>
					
					<?php if(!empty($calloutBtnTxt)){?>
                    <a href="<?php echo $calloutBtnURL; ?>" class="btn btn-primary outline btn-md"><?php echo $calloutBtnTxt; ?></a>
					<?php } ?>
					
					<?php if(!empty($calloutBtnTxtTwo)){?>
                    <a href="<?php echo $calloutBtnURLTwo; ?>" class="btn btn-primary outline btn-md"><?php echo $calloutBtnTxtTwo; ?></a>
					<?php } ?>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12 visible-lg">
                <div class="member-img text-center">
					<?php if(!empty($calloutbgV2 )){?>
                    <img src="<?php echo $calloutbgV2; ?>">
					<?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>