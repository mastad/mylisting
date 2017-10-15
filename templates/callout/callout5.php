<?php 
global $redux_demo;
$classieraCTABG = $redux_demo['classiera_call_to_action_background']['url'];
$classieraCTAAboutIcon = $redux_demo['classiera_call_to_action_about_icon']['url'];
$classieraCTAAboutTitle = $redux_demo['classiera_call_to_action_about'];
$classieraCTAAboutDesc = $redux_demo['classiera_call_to_action_about_desc'];
$classieraCTASellIcon = $redux_demo['classiera_call_to_action_sell_icon']['url'];
$classieraCTASellTitle = $redux_demo['classiera_call_to_action_sell'];
$classieraCTASellDesc = $redux_demo['classiera_call_to_action_sell_desc'];
$classieraCTABuyIcon = $redux_demo['classiera_call_to_action_buy_icon']['url'];
$classieraCTABuyTitle = $redux_demo['classiera_call_to_action_buy'];
$classieraCTABuyDesc = $redux_demo['classiera_call_to_action_buy_desc'];
?>
<section class="call-to-action" style="background-image:url(<?php echo $classieraCTABG; ?>)">
	<div class="container">
		<div class="row gutter-15">
			<div class="col-lg-4 col-md-4 col-sm-6">
                <div class="call-to-action-box match-height">
                    <div class="action-box-heading">
                        <div class="heading-content">
                            <img src="<?php echo $classieraCTAAboutIcon; ?>" alt="<?php echo $classieraCTAAboutTitle; ?>">
                        </div>
                        <div class="heading-content">
                            <h3><?php echo $classieraCTAAboutTitle; ?></h3>
                        </div>
                    </div>
                    <div class="action-box-content">
                        <p>
                            <?php echo $classieraCTAAboutDesc; ?>
                        </p>
                    </div>
                </div>
            </div><!--End About Section-->
			<div class="col-lg-4 col-md-4 col-sm-6">
                <div class="call-to-action-box match-height">
                    <div class="action-box-heading">
                        <div class="heading-content">
                            <img src="<?php echo $classieraCTASellIcon; ?>" alt="<?php echo $classieraCTASellTitle; ?>">
                        </div>
                        <div class="heading-content">
                            <h3><?php echo $classieraCTASellTitle; ?></h3>
                        </div>
                    </div>
                    <div class="action-box-content">
                        <p>
                            <?php echo $classieraCTASellDesc; ?>
                        </p>
                    </div>
                </div>
            </div><!--End Sell Safely Section-->
			<div class="col-lg-4 col-md-4 col-sm-6">
                <div class="call-to-action-box match-height">
                    <div class="action-box-heading">
                        <div class="heading-content">
                            <img src="<?php echo $classieraCTABuyIcon; ?>" alt="<?php echo $classieraCTABuyTitle; ?>">
                        </div>
                        <div class="heading-content">
                            <h3><?php echo $classieraCTABuyTitle; ?></h3>
                        </div>
                    </div>
                    <div class="action-box-content">
                        <p>
                            <?php echo $classieraCTABuyDesc; ?>
                        </p>
                    </div>
                </div>
            </div><!--End Buy Safely Section-->
		</div><!--row gutter-15-->
	</div><!--container-->
</section><!--call-to-action-->