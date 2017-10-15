<?php 
global $redux_demo;
$home_callout_disable = $redux_demo['home-callout-disable'];
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
<section class="members-v1" style="background-image:url(<?php echo $calloutbg; ?>)">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-6 hidden-xs hidden-sm">
                <div class="mobile-img text-center">
                    <img src="<?php echo $calloutbgV2; ?>">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="members-text text-left flip">
                    <h2><?php echo $calloutTitle; ?></h2>
                    <h2><?php echo $calloutTitlesecond; ?></h2>
                    <p><?php echo $calloutDesc; ?></p>
                    <a href="<?php echo $calloutBtnURL; ?>" class="btn btn-primary round btn-style-two btn-md active"><span><i class="<?php echo $calloutBtnIcon; ?>"></i></span><?php echo $calloutBtnTxt; ?></a>
                </div>
            </div>
        </div>
    </div>
</section><!-- /.Memebers -->