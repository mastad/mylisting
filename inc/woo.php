<?php
add_action('wp_ajax_classiera_implement_woo_ajax', 'classiera_implement_woo_ajax');
add_action('wp_ajax_nopriv_classiera_implement_woo_ajax', 'classiera_implement_woo_ajax');//for users that are not logged in.
function classiera_implement_woo_ajax(){	
	if(isset($_POST['user_data'])){				
		$myrecArray = $_POST['user_data'];		
		foreach ($myrecArray as $key => $val) {			
			$allValues .= $val.",";	
		}
		$singleState = explode(",", $allValues);
		$i = 1;
		$savevalue = array();
		foreach( $singleState as $val ){
			//echo $val;
			if($i == 1){
				$savevalue['AMT'] = $val;
			}
			if($i == 2){
				$savevalue['product_id'] = $val;
				$product_id = $val;
				$wooID = $val;
			}
			if($i == 3){
				$savevalue['CURRENCYCODE'] = $val;
			}
			if($i == 4){
				$savevalue['user_ID'] = $val;
			}
			if($i == 5){
				$savevalue['plan_name'] = $val;
			}
			if($i == 6){
				$savevalue['plan_ads'] = $val;
			}
			if($i == 7){
				$savevalue['plan_time'] = $val;
			}
			$i++;
		}
		session_start();
		$_SESSION['classiera_user_data'] = $savevalue;
		die();
	}
}
add_filter('woocommerce_add_cart_item_data','wdm_add_item_data',11,2); 
if(!function_exists('wdm_add_item_data'))
{
    function wdm_add_item_data($cart_item_data,$product_id)
    {
        /*Here, We are adding item in WooCommerce session with, wdm_user_custom_data_value name*/
		//print_r($_SESSION);
        global $woocommerce;
        session_start();    
        if (isset($_SESSION['classiera_user_data'])) {
            $option = $_SESSION['classiera_user_data'];       
            $new_value = array('wdm_user_custom_data_value' => $option);			
        }
        if(empty($option))
            return $cart_item_data;
        else
        {    
            if(empty($cart_item_data))
                return $new_value;
            else
                return array_merge($cart_item_data,$new_value);
        }
        unset($_SESSION['classiera_user_data']); 
        //Unset our custom session variable, as it is no longer needed.
    }
}
add_filter('woocommerce_get_cart_item_from_session', 'wdm_get_cart_items_from_session', 11, 3 );
if(!function_exists('wdm_get_cart_items_from_session'))
{
    function wdm_get_cart_items_from_session($item,$values,$key)
    {
        if (array_key_exists( 'wdm_user_custom_data_value', $values ) )
        {
        $item['wdm_user_custom_data_value'] = $values['wdm_user_custom_data_value'];
        }       
        return $item;
    }
}
add_filter('woocommerce_checkout_cart_item_quantity','wdm_add_user_custom_option_from_session_into_cart',1,3);  
add_filter('woocommerce_cart_item_price','wdm_add_user_custom_option_from_session_into_cart',1,3);
if(!function_exists('wdm_add_user_custom_option_from_session_into_cart'))
{
 function wdm_add_user_custom_option_from_session_into_cart($product_name, $values, $cart_item_key )
    {
		//print_r($values['wdm_user_custom_data_value']);
        /*code to add custom data on Cart & checkout Page*/    
        if(count($values['wdm_user_custom_data_value']) > 0)
        {
			$newval = $values['wdm_user_custom_data_value'];
			//print_r($newval);
            $return_string = $product_name . "</a><ul class='variation'>";
			$return_string .= "<div class='wdm_options_table' id='" . $newval['product_id'] . "'>";
			foreach( $newval as $key => $val ){
				?>
				<?php
				if($key == 'plan_name'){					
					$echokey = esc_html__( 'Plan Name', 'classiera' );
					?>
					<li><?php echo $echokey;?> = <span><?php echo $val;?></span></li>
					<?php
				}elseif($key == 'plan_ads'){
					$echokey = esc_html__( 'Total Featured Ads', 'classiera' );
					?>
					<li><?php echo $echokey;?> = <span><?php echo $val;?></span></li>
					<?php
				}elseif($key == 'plan_time'){					
					$echokey = esc_html__( 'Ads will be live for', 'classiera' );
					?>
					<li><?php echo $echokey;?> = <span><?php echo $val;?></span></li>
					<?php
				}				
			}
            $return_string .= "</div></ul>";
            
            return $return_string;
        }else{
            return $product_name;
        }
    }
}
add_action('woocommerce_add_order_item_meta','wdm_add_values_to_order_item_meta',1,2);
if(!function_exists('wdm_add_values_to_order_item_meta'))
{
  function wdm_add_values_to_order_item_meta($item_id, $values)
  {
        global $woocommerce,$wpdb;
        $user_custom_values = $values['wdm_user_custom_data_value'];
        if(!empty($user_custom_values)){
			foreach($user_custom_values AS $key => $val){
				wc_add_order_item_meta($item_id, $key, $val); 
			}
            //wc_add_order_item_meta($item_id,'wdm_user_custom_data',$user_custom_values);  
        }
  }
}
add_action('woocommerce_before_cart_item_quantity_zero','wdm_remove_user_custom_data_options_from_cart',1,1);
if(!function_exists('wdm_remove_user_custom_data_options_from_cart'))
{
    function wdm_remove_user_custom_data_options_from_cart($cart_item_key)
    {
        global $woocommerce;
        // Get cart
        $cart = $woocommerce->cart->get_cart();
        // For each item in cart, if item is upsell of deleted product, delete it
        foreach( $cart as $key => $values){
			if($values['wdm_user_custom_data_value'] == $cart_item_key ){
				unset( $woocommerce->cart->cart_contents[ $key ] );
			}
        }
    }
}
//Do a task on order status complete//
add_action( 'woocommerce_order_status_completed', 'classiera_complete_payment_order', 10);
function classiera_complete_payment_order($order_id){
	global $wpdb;
	$order = wc_get_order( $order_id );
	$items = $order->get_items();
	foreach( $items as $item_id => $item_data ){
		$plan_time = wc_get_order_item_meta($item_id, 'plan_time', true);
		$plan_ads = wc_get_order_item_meta($item_id, 'plan_ads', true);
		$user_ID = wc_get_order_item_meta($item_id, 'user_ID', true);
		$plan_name = wc_get_order_item_meta($item_id, 'plan_name', true);
		$plan_price = wc_get_order_item_meta($item_id, 'AMT', true);
		$product_id = wc_get_order_item_meta($item_id, 'product_id', true);
	}	
	$price_plan_information = array(
		'id' =>'',
		'product_id' => $product_id,
		'user_id' => $user_ID,
		'plan_name' => $plan_name,
		'price' => $plan_price,
		'ads' => $plan_ads,
		'days' => $plan_time,
		'status' => "complete",
		'used' => "0",
		'created' => time()
	);
	$insert_format = array('%d', '%d', '%d', '%s','%d', '%s', '%s', '%s', '%s', '%s');
	$tablename = $wpdb->prefix . 'classiera_plans';
	$wpdb->insert($tablename, $price_plan_information, $insert_format);
}
/*
function classiera_plans_tbl_create(){
    global $wpdb;
    $sql2 = ("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}classiera_plans(
		id int(11) NOT NULL AUTO_INCREMENT,
		user_id TEXT NOT NULL ,
		plan_name TEXT NOT NULL ,
		price FLOAT UNSIGNED NOT NULL ,
		ads TEXT ,
		days TEXT NOT NULL ,
		date TEXT NOT NULL ,
		status TEXT NOT NULL ,
		used TEXT NOT NULL ,
		created INT( 4 ) UNSIGNED NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB AUTO_INCREMENT=1;");
	$wpdb->query($sql2);
}

add_action( 'init', 'classiera_plans_tbl_create', 1 );*/
function classiera_Select_currency_dropdow($tag){
	?>
	<select name="post_currency_tag" id="post_currency_tag" class="post_currency_tag form-control form-control-md">
		<option value="none" disabled>
			<?php esc_html_e('Select Currency', 'classiera'); ?>
		</option>
		<option value="USD" <?php if($tag == 'USD'){echo "selected";}?>>
			<?php esc_html_e('US Dollar', 'classiera'); ?>
		</option>
		<option value="CAD" <?php if($tag == 'CAD'){echo "selected";}?>>
			<?php esc_html_e('Canadian Dollar', 'classiera'); ?>
		</option>
		<option value="EUR" <?php if($tag == 'EUR'){echo "selected";}?>>
			<?php esc_html_e('Euro', 'classiera'); ?>
		</option>
		<option value="AED" <?php if($tag == 'AED'){echo "selected";}?>>
			<?php esc_html_e('United Arab Emirates Dirham', 'classiera'); ?>
		</option>
		<option value="AFN" <?php if($tag == 'AFN'){echo "selected";}?>>
			<?php esc_html_e('Afghan Afghani', 'classiera'); ?>
		</option>
		<option value="ALL" <?php if($tag == 'ALL'){echo "selected";}?>>
			<?php esc_html_e('Albanian Lek', 'classiera'); ?>
		</option>
		<option value="AMD" <?php if($tag == 'AMD'){echo "selected";}?>>
			<?php esc_html_e('Armenian Dram', 'classiera'); ?>
		</option>
		<option value="ARS" <?php if($tag == 'ARS'){echo "selected";}?>>
			<?php esc_html_e('Argentine Peso', 'classiera'); ?>
		</option>
		<option value="AUD" <?php if($tag == 'AUD'){echo "selected";}?>>
			<?php esc_html_e('Australian Dollar', 'classiera'); ?>
		</option>
		<option value="AZN" <?php if($tag == 'AZN'){echo "selected";}?>>
			<?php esc_html_e('Azerbaijani Manat', 'classiera'); ?>
		</option>	
		<option value="BDT" <?php if($tag == 'BDT'){echo "selected";}?>>
			<?php esc_html_e('Bangladeshi Taka', 'classiera'); ?>
		</option>
		<option value="BGN" <?php if($tag == 'BGN'){echo "selected";}?>>
			<?php esc_html_e('Bulgarian Lev', 'classiera'); ?>
		</option>
		<option value="BHD" <?php if($tag == 'BHD'){echo "selected";}?>>
			<?php esc_html_e('Bahraini Dinar', 'classiera'); ?>
		</option>		
		<option value="BND" <?php if($tag == 'BND'){echo "selected";}?>>
			<?php esc_html_e('Brunei Dollar', 'classiera'); ?>
		</option>
		<option value="BOB" <?php if($tag == 'BOB'){echo "selected";}?>>
			<?php esc_html_e('Bolivian Boliviano', 'classiera'); ?>
		</option>
		<option value="BRL" <?php if($tag == 'BRL'){echo "selected";}?>>
			<?php esc_html_e('Brazilian Real', 'classiera'); ?>
		</option>
		<option value="BWP" <?php if($tag == 'BWP'){echo "selected";}?>>
			<?php esc_html_e('Botswanan Pula', 'classiera'); ?>
		</option>
		<option value="BYN" <?php if($tag == 'BYN'){echo "selected";}?>>
			<?php esc_html_e('Belarusian Ruble', 'classiera'); ?>
		</option>
		<option value="BZD" <?php if($tag == 'BZD'){echo "selected";}?>>
			<?php esc_html_e('Belize Dollar', 'classiera'); ?>
		</option>		
		<option value="CHF" <?php if($tag == 'CHF'){echo "selected";}?>>
			<?php esc_html_e('Swiss Franc', 'classiera'); ?>
		</option>
		<option value="CLP" <?php if($tag == 'CLP'){echo "selected";}?>>
			<?php esc_html_e('Chilean Peso', 'classiera'); ?>
		</option>
		<option value="CNY" <?php if($tag == 'CNY'){echo "selected";}?>>
			<?php esc_html_e('Chinese Yuan', 'classiera'); ?>
		</option>
		<option value="COP" <?php if($tag == 'COP'){echo "selected";}?>>
			<?php esc_html_e('Colombian Peso', 'classiera'); ?>
		</option>
		<option value="CRC" <?php if($tag == 'CRC'){echo "selected";}?>>
			<?php esc_html_e('Costa Rican Colón', 'classiera'); ?>
		</option>
		<option value="CVE" <?php if($tag == 'CVE'){echo "selected";}?>>
			<?php esc_html_e('Cape Verdean Escudo', 'classiera'); ?>
		</option>
		<option value="CZK" <?php if($tag == 'CZK'){echo "selected";}?>>
			<?php esc_html_e('Czech Republic Koruna', 'classiera'); ?>
		</option>
		<option value="DJF" <?php if($tag == 'DJF'){echo "selected";}?>>
			<?php esc_html_e('Djiboutian Franc', 'classiera'); ?>
		</option>
		<option value="DKK" <?php if($tag == 'DKK'){echo "selected";}?>>
			<?php esc_html_e('Danish Krone', 'classiera'); ?>
		</option>
		<option value="DOP" <?php if($tag == 'DOP'){echo "selected";}?>>
			<?php esc_html_e('Dominican Peso', 'classiera'); ?>
		</option>
		<option value="DZD" <?php if($tag == 'DZD'){echo "selected";}?>>
			<?php esc_html_e('Algerian Dinar', 'classiera'); ?>
		</option>		
		<option value="EGP" <?php if($tag == 'EGP'){echo "selected";}?>>
			<?php esc_html_e('Egyptian Pound', 'classiera'); ?>
		</option>
		<option value="ERN" <?php if($tag == 'ERN'){echo "selected";}?>>
			<?php esc_html_e('Eritrean Nakfa', 'classiera'); ?>
		</option>
		<option value="ETB" <?php if($tag == 'ETB'){echo "selected";}?>>
			<?php esc_html_e('Ethiopian Birr', 'classiera'); ?>
		</option>
		<option value="GBP" <?php if($tag == 'GBP'){echo "selected";}?>>
			<?php esc_html_e('British Pound', 'classiera'); ?>
		</option>
		<option value="‎GEL" <?php if($tag == '‎GEL'){echo "selected";}?>>
			<?php esc_html_e('Georgian Lari', 'classiera'); ?>
		</option>
		<option value="GHS" <?php if($tag == 'GHS'){echo "selected";}?>>
			<?php esc_html_e('Ghanaian Cedi', 'classiera'); ?>
		</option>		
		<option value="GTQ" <?php if($tag == 'GTQ'){echo "selected";}?>>
			<?php esc_html_e('Guatemalan Quetzal', 'classiera'); ?>
		</option>
		<option value="HKD" <?php if($tag == 'HKD'){echo "selected";}?>>
			<?php esc_html_e('Hong Kong Dollar', 'classiera'); ?>
		</option>
		<option value="HNL" <?php if($tag == 'HNL'){echo "selected";}?>>
			<?php esc_html_e('Honduran Lempira', 'classiera'); ?>
		</option>
		<option value="HRK" <?php if($tag == 'HRK'){echo "selected";}?>>
			<?php esc_html_e('Croatian Kuna', 'classiera'); ?>
		</option>
		<option value="HUF" <?php if($tag == 'HUF'){echo "selected";}?>>
			<?php esc_html_e('Hungarian Forint', 'classiera'); ?>
		</option>
		<option value="IDR" <?php if($tag == 'IDR'){echo "selected";}?>>
			<?php esc_html_e('Indonesian Rupiah', 'classiera'); ?>
		</option>
		<option value="ILS" <?php if($tag == 'ILS'){echo "selected";}?>>
			<?php esc_html_e('Israeli SheKel', 'classiera'); ?>
		</option>
		<option value="INR" <?php if($tag == 'INR'){echo "selected";}?>>
			<?php esc_html_e('Indian Rupee', 'classiera'); ?>
		</option>
		<option value="IQD" <?php if($tag == 'IQD'){echo "selected";}?>>
			<?php esc_html_e('Iraqi Dinar', 'classiera'); ?>
		</option>
		<option value="IRR" <?php if($tag == 'IRR'){echo "selected";}?>>
			<?php esc_html_e('Iranian Rial', 'classiera'); ?>
		</option>
		<option value="ISK" <?php if($tag == 'ISK'){echo "selected";}?>>
			<?php esc_html_e('Icelandic Króna', 'classiera'); ?>
		</option>
		<option value="JMD" <?php if($tag == 'JMD'){echo "selected";}?>>
			<?php esc_html_e('Jamaican Dollar', 'classiera'); ?>
		</option>
		<option value="JOD" <?php if($tag == 'JOD'){echo "selected";}?>>
			<?php esc_html_e('Jordanian Dinar', 'classiera'); ?>
		</option>
		<option value="JPY" <?php if($tag == 'JPY'){echo "selected";}?>>
			<?php esc_html_e('Japanese Yen', 'classiera'); ?>
		</option>
		<option value="KES" <?php if($tag == 'KES'){echo "selected";}?>>
			<?php esc_html_e('Kenyan Shilling', 'classiera'); ?>
		</option>
		<option value="KHR" <?php if($tag == 'KHR'){echo "selected";}?>>
			<?php esc_html_e('Cambodian Riel', 'classiera'); ?>
		</option>
		<option value="KMF" <?php if($tag == 'KMF'){echo "selected";}?>>
			<?php esc_html_e('Comorian Franc', 'classiera'); ?>
		</option>
		<option value="KRW" <?php if($tag == 'KRW'){echo "selected";}?>>
			<?php esc_html_e('South Korean Won', 'classiera'); ?>
		</option>
		<option value="KWD" <?php if($tag == 'KWD'){echo "selected";}?>>
			<?php esc_html_e('Kuwaiti Dinar', 'classiera'); ?>
		</option>
		<option value="KZT" <?php if($tag == 'KZT'){echo "selected";}?>>
			<?php esc_html_e('Kazakhstani Tenge', 'classiera'); ?>
		</option>
		<option value="LBP" <?php if($tag == 'LBP'){echo "selected";}?>>
			<?php esc_html_e('Lebanese Pound', 'classiera'); ?>
		</option>
		<option value="LKR" <?php if($tag == 'LKR'){echo "selected";}?>>
			<?php esc_html_e('Sri Lankan Rupee', 'classiera'); ?>
		</option>
		<option value="LTL" <?php if($tag == 'LTL'){echo "selected";}?>>
			<?php esc_html_e('Lithuanian Litas', 'classiera'); ?>
		</option>
		<option value="LVL" <?php if($tag == 'LVL'){echo "selected";}?>>
			<?php esc_html_e('Latvian Lats', 'classiera'); ?>
		</option>
		<option value="LYD" <?php if($tag == 'LYD'){echo "selected";}?>>
			<?php esc_html_e('Libyan Dinar', 'classiera'); ?>
		</option>
		<option value="MAD" <?php if($tag == 'MAD'){echo "selected";}?>>
			<?php esc_html_e('Moroccan Dirham', 'classiera'); ?>
		</option>
		<option value="MDL" <?php if($tag == 'MDL'){echo "selected";}?>>
			<?php esc_html_e('Moldovan Leu', 'classiera'); ?>
		</option>
		<option value="MGA" <?php if($tag == 'MGA'){echo "selected";}?>>
			<?php esc_html_e('Malagasy Ariary', 'classiera'); ?>
		</option>
		<option value="MKD" <?php if($tag == 'MKD'){echo "selected";}?>>
			<?php esc_html_e('Macedonian Denar', 'classiera'); ?>
		</option>
		<option value="MMK" <?php if($tag == 'MMK'){echo "selected";}?>>
			<?php esc_html_e('Myanma Kyat', 'classiera'); ?>
		</option>
		<option value="HKD" <?php if($tag == 'HKD'){echo "selected";}?>>
			<?php esc_html_e('Macanese Pataca', 'classiera'); ?>
		</option>
		<option value="MUR" <?php if($tag == 'MUR'){echo "selected";}?>>
			<?php esc_html_e('Mauritian Rupee', 'classiera'); ?>
		</option>
		<option value="MXN" <?php if($tag == 'MXN'){echo "selected";}?>>
			<?php esc_html_e('Mexican Peso', 'classiera'); ?>
		</option>
		<option value="MYR" <?php if($tag == 'MYR'){echo "selected";}?>>
			<?php esc_html_e('Malaysian Ringgit', 'classiera'); ?>
		</option>
		<option value="MZN" <?php if($tag == 'MZN'){echo "selected";}?>>
			<?php esc_html_e('Mozambican Metical', 'classiera'); ?>
		</option>
		<option value="NAD" <?php if($tag == 'NAD'){echo "selected";}?>>
			<?php esc_html_e('Namibian Dollar', 'classiera'); ?>
		</option>
		<option value="NGN" <?php if($tag == 'NGN'){echo "selected";}?>>
			<?php esc_html_e('Nigerian Naira', 'classiera'); ?>
		</option>
		<option value="NIO" <?php if($tag == 'NIO'){echo "selected";}?>>
			<?php esc_html_e('Nicaraguan Córdoba', 'classiera'); ?>
		</option>
		<option value="NOK" <?php if($tag == 'NOK'){echo "selected";}?>>
			<?php esc_html_e('Norwegian Krone', 'classiera'); ?>
		</option>
		<option value="NPR" <?php if($tag == 'NPR'){echo "selected";}?>>
			<?php esc_html_e('Nepalese Rupee', 'classiera'); ?>
		</option>
		<option value="NZD" <?php if($tag == 'NZD'){echo "selected";}?>>
			<?php esc_html_e('New Zealand Dollar', 'classiera'); ?>
		</option>
		<option value="OMR" <?php if($tag == 'OMR'){echo "selected";}?>>
			<?php esc_html_e('Omani Rial', 'classiera'); ?>
		</option>
		<option value="‎PAB" <?php if($tag == '‎PAB'){echo "selected";}?>>
			<?php esc_html_e('Panamanian Balboa', 'classiera'); ?>
		</option>
		<option value="PEN" <?php if($tag == 'PEN'){echo "selected";}?>>
			<?php esc_html_e('Peruvian Nuevo Sol', 'classiera'); ?>
		</option>
		<option value="PHP" <?php if($tag == 'PHP'){echo "selected";}?>>
			<?php esc_html_e('Philippine Peso', 'classiera'); ?>
		</option>
		<option value="PKR" <?php if($tag == 'PKR'){echo "selected";}?>>
			<?php esc_html_e('Pakistani Rupee', 'classiera'); ?>
		</option>
		<option value="PLN" <?php if($tag == 'PLN'){echo "selected";}?>>
			<?php esc_html_e('Polish Zloty', 'classiera'); ?>
		</option>
		<option value="PYG" <?php if($tag == 'PYG'){echo "selected";}?>>
			<?php esc_html_e('Paraguayan Guarani', 'classiera'); ?>
		</option>
		<option value="QAR" <?php if($tag == 'QAR'){echo "selected";}?>>
			<?php esc_html_e('Qatari Rial', 'classiera'); ?>
		</option>
		<option value="RON" <?php if($tag == 'RON'){echo "selected";}?>>
			<?php esc_html_e('Romanian Leu', 'classiera'); ?>
		</option>
		<option value="RSD" <?php if($tag == 'RSD'){echo "selected";}?>>
			<?php esc_html_e('Serbian Dinar', 'classiera'); ?>
		</option>
		<option value="RUB" <?php if($tag == 'RUB'){echo "selected";}?>>
			<?php esc_html_e('Russian Ruble', 'classiera'); ?>
		</option>
		<option value="RWF" <?php if($tag == 'RWF'){echo "selected";}?>>
			<?php esc_html_e('Rwandan Franc', 'classiera'); ?>
		</option>
		<option value="SAR" <?php if($tag == 'SAR'){echo "selected";}?>>
			<?php esc_html_e('Saudi Riyal', 'classiera'); ?>
		</option>
		<option value="SDG" <?php if($tag == 'SDG'){echo "selected";}?>>
			<?php esc_html_e('Sudanese Pound', 'classiera'); ?>
		</option>
		<option value="SEK" <?php if($tag == 'SEK'){echo "selected";}?>>
			<?php esc_html_e('Swedish Krona', 'classiera'); ?>
		</option>
		<option value="SGD" <?php if($tag == 'SGD'){echo "selected";}?>>
			<?php esc_html_e('Singapore Dollar', 'classiera'); ?>
		</option>
		<option value="SOS" <?php if($tag == 'SOS'){echo "selected";}?>>
			<?php esc_html_e('Somali Shilling', 'classiera'); ?>
		</option>
		<option value="SYP" <?php if($tag == 'SYP'){echo "selected";}?>>
			<?php esc_html_e('Syrian Pound', 'classiera'); ?>
		</option>
		<option value="THB" <?php if($tag == 'THB'){echo "selected";}?>>
			<?php esc_html_e('Thai Baht', 'classiera'); ?>
		</option>
		<option value="TND" <?php if($tag == 'TND'){echo "selected";}?>>
			<?php esc_html_e('Tunisian Dinar', 'classiera'); ?>
		</option>
		<option value="TOP" <?php if($tag == 'TOP'){echo "selected";}?>>
			<?php esc_html_e('Tongan Paʻanga', 'classiera'); ?>
		</option>
		<option value="TRY" <?php if($tag == 'TRY'){echo "selected";}?>>
			<?php esc_html_e('Turkish Lira', 'classiera'); ?>
		</option>
		<option value="TTD" <?php if($tag == 'TTD'){echo "selected";}?>>
			<?php esc_html_e('Trinidad and Tobago Dollar', 'classiera'); ?>
		</option>
		<option value="TWD" <?php if($tag == 'TWD'){echo "selected";}?>>
			<?php esc_html_e('New Taiwan Dollar', 'classiera'); ?>
		</option>		
		<option value="UAH" <?php if($tag == 'UAH'){echo "selected";}?>>
			<?php esc_html_e('Ukrainian Hryvnia', 'classiera'); ?>
		</option>
		<option value="UGX" <?php if($tag == 'UGX'){echo "selected";}?>>
			<?php esc_html_e('Ugandan Shilling', 'classiera'); ?>
		</option>
		<option value="UYU" <?php if($tag == 'UZS'){echo "selected";}?>>
			<?php esc_html_e('Uruguayan Peso', 'classiera'); ?>
		</option>
		<option value="UZS" <?php if($tag == ''){echo "selected";}?>>
			<?php esc_html_e('Uzbekistan Som', 'classiera'); ?>
		</option>
		<option value="VEF" <?php if($tag == 'VEF'){echo "selected";}?>>
			<?php esc_html_e('Venezuelan Bolívar', 'classiera'); ?>
		</option>
		<option value="VND" <?php if($tag == 'VND'){echo "selected";}?>>
			<?php esc_html_e('Vietnamese Dong', 'classiera'); ?>
		</option>		
		<option value="YER" <?php if($tag == 'YER'){echo "selected";}?>>
			<?php esc_html_e('Yemeni Rial', 'classiera'); ?>
		</option>
		<option value="ZAR" <?php if($tag == 'ZAR'){echo "selected";}?>>
			<?php esc_html_e('South African Rand', 'classiera'); ?>
		</option>
		<option value="ZMK" <?php if($tag == 'ZMK'){echo "selected";}?>>
			<?php esc_html_e('Zambian Kwacha', 'classiera'); ?>
		</option>		
	</select>
	<?php
}
function classiera_Display_currency_sign($code){	
	if($code == 'USD'){
		$displayCode = '&dollar;';
	}elseif($code == 'CAD'){
		$displayCode = '&dollar;';
	}elseif($code == 'EUR'){
		$displayCode = '&euro;';	
	}elseif($code == 'AED'){
		$displayCode = '&#x62f;&#x2e;&#x625;';
	}elseif($code == 'AFN'){
		$displayCode = '&#1547;';		
	}elseif($code == 'ALL'){
		$displayCode = 'Lek';
	}elseif($code == 'AMD'){
		$displayCode = '&#x58f;';
	}elseif($code == 'ARS'){
		$displayCode = '&#x24;';
	}elseif($code == 'AUD'){
		$displayCode = '&#x41;&#x24;';
	}elseif($code == 'AZN'){
		$displayCode = '&#8380;';
	}elseif($code == 'BDT'){
		$displayCode = '&#2547;';
	}elseif($code == 'BGN'){
		$displayCode = '&#1083;&#1074;';
	}elseif($code == 'BHD'){
		$displayCode = '.&#1583;.&#1576;';
	}elseif($code == 'BND'){
		$displayCode = '&#36;';
	}elseif($code == 'BOB'){
		$displayCode = '&#36;&#98;';
	}elseif($code == 'BRL'){
		$displayCode = '&#x52;&#x24;';
	}elseif($code == 'BWP'){
		$displayCode = '&#80;';
	}elseif($code == 'BYN'){
		$displayCode = '&#8381;';
	}elseif($code == 'BZD'){
		$displayCode = '&#66;&#90;&#36;';
	}elseif($code == 'CHF'){
		$displayCode = '&#x43;&#x48;&#x46;';
	}elseif($code == 'CLP'){
		$displayCode = '&#x24;';
	}elseif($code == 'CNY'){
		$displayCode = '&#xa5;';	
	}elseif($code == 'COP'){
		$displayCode = '&#x24;';
	}elseif($code == 'CRC'){
		$displayCode = '&#8353;';
	}elseif($code == 'CVE'){
		$displayCode = '&#36;';
	}elseif($code == 'CZK'){
		$displayCode = '&#x4b;&#x10d;';
	}elseif($code == 'DJF'){
		$displayCode = '&#70;&#100;&#106;';
	}elseif($code == 'DKK'){
		$displayCode = '&#x6b;&#x72;';
	}elseif($code == 'DOP'){
		$displayCode = '&#82;&#68;&#36;';
	}elseif($code == 'DZD'){
		$displayCode = '&#1583;&#1580;';
	}elseif($code == 'EGP'){
		$displayCode = '&#163;';
	}elseif($code == 'ERN'){
		$displayCode = '&#163;';
	}elseif($code == 'ETB'){
		$displayCode = '&#66;&#114;';
	}elseif($code == 'GBP'){
		$displayCode = '&pound;';
	}elseif($code == '‎GEL'){
		$displayCode = '&#8382;';
	}elseif($code == 'GHS'){
		$displayCode = '&#x47;&#x48;&#x20b5;';
	}elseif($code == 'GTQ'){
		$displayCode = '&#x51;';
	}elseif($code == 'HKD'){
		$displayCode = '&#x24;';
	}elseif($code == 'HNL'){
		$displayCode = '&#x4c;';
	}elseif($code == 'HRK'){
		$displayCode = '&#x6b;&#x6e;';
	}elseif($code == 'HUF'){
		$displayCode = '&#x46;&#x74;';
	}elseif($code == 'IDR'){
		$displayCode = '&#x52;&#x70;';
	}elseif($code == 'ILS'){
		$displayCode = '&#x20aa;';
	}elseif($code == 'INR'){
		$displayCode = '&#x20b9;';	
	}elseif($code == 'IQD'){
		$displayCode = '&#1593;.&#1583;';
	}elseif($code == 'IRR'){
		$displayCode = '&#65020;';
	}elseif($code == 'ISK'){
		$displayCode = '&#x6b;&#x72;';
	}elseif($code == 'JMD'){
		$displayCode = '&#x4a;&#x24;';
	}elseif($code == 'JOD'){
		$displayCode = '&#74;&#68;';
	}elseif($code == 'JPY'){
		$displayCode = '&yen;';
	}elseif($code == 'KES'){
		$displayCode = '&#75;&#83;&#104;';
	}elseif($code == 'KHR'){
		$displayCode = '&#6107;';
	}elseif($code == 'KMF'){
		$displayCode = '&#67;&#70;';
	}elseif($code == 'KRW'){
		$displayCode = '&#8361;';
	}elseif($code == 'KWD'){
		$displayCode = '&#1583;.&#1603;';
	}elseif($code == 'KZT'){
		$displayCode = '&#1083;&#1074;';
	}elseif($code == 'LBP'){
		$displayCode = '&#163;';
	}elseif($code == 'LKR'){
		$displayCode = '&#8360;';
	}elseif($code == 'LTL'){
		$displayCode = '&#76;&#116;';
	}elseif($code == 'LVL'){
		$displayCode = '&#76;&#115;';
	}elseif($code == 'LYD'){
		$displayCode = '&#1604;.&#1583;';
	}elseif($code == 'MAD'){
		$displayCode = '&#x2e;&#x62f;&#x2e;&#x645;';
	}elseif($code == 'MDL'){
		$displayCode = '&#76;';
	}elseif($code == 'MGA'){
		$displayCode = '&#65;&#114;';
	}elseif($code == 'MKD'){
		$displayCode = '&#1076;&#1077;&#1085;';
	}elseif($code == 'MMK'){
		$displayCode = '&#x4b;';
	}elseif($code == 'HKD'){
		$displayCode = '&#36;';
	}elseif($code == 'MUR'){
		$displayCode = '&#8360;';
	}elseif($code == 'MXN'){
		$displayCode = '&#x24;';
	}elseif($code == 'MYR'){
		$displayCode = '&#x52;&#x4d;';
	}elseif($code == 'MZN'){
		$displayCode = '&#77;&#84;';
	}elseif($code == 'NAD'){
		$displayCode = '&#36;';
	}elseif($code == 'NGN'){
		$displayCode = '&#8358;';
	}elseif($code == 'NIO'){
		$displayCode = '&#67;&#36;';
	}elseif($code == 'NOK'){
		$displayCode = '&#x6b;&#x72;';
	}elseif($code == 'NPR'){
		$displayCode = '&#8360;';
	}elseif($code == 'NZD'){
		$displayCode = '&#x24;';
	}elseif($code == 'OMR'){
		$displayCode = '&#65020;';
	}elseif($code == '‎PAB'){
		$displayCode = '&#x42;&#x2f;&#x2e;';
	}elseif($code == 'PEN'){
		$displayCode = '&#x53;&#x2f;&#x2e;';
	}elseif($code == 'PHP'){
		$displayCode = '&#8369;';
	}elseif($code == 'PKR'){
		$displayCode = '&#8360;';		
	}elseif($code == 'PLN'){
		$displayCode = '&#x7a;&#x142;';
	}elseif($code == 'PYG'){
		$displayCode = '&#71;&#115;';
	}elseif($code == 'QAR'){
		$displayCode = '&#65020;';
	}elseif($code == 'RON'){
		$displayCode = '&#x6c;&#x65;&#x69;';
	}elseif($code == 'RSD'){
		$displayCode = '&#x52;&#x53;&#x44;';
	}elseif($code == 'RUB'){
		$displayCode = '&#x440;&#x443;&#x431;';	
	}elseif($code == 'RWF'){
		$displayCode = '&#1585;.&#1587;';
	}elseif($code == 'SAR'){
		$displayCode = '&#65020;';
	}elseif($code == 'SDG'){
		$displayCode = '&#163;';
	}elseif($code == 'SEK'){
		$displayCode = '&#x6b;&#x72;';
	}elseif($code == 'SGD'){
		$displayCode = '&#x53;&#x24;';
	}elseif($code == 'SOS'){
		$displayCode = '&#83;';
	}elseif($code == 'SYP'){
		$displayCode = '&#163;';
	}elseif($code == 'THB'){
		$displayCode = '&#3647;';
	}elseif($code == 'TND'){
		$displayCode = '&#x44;&#x54;';
	}elseif($code == 'TOP'){
		$displayCode = '&#84;&#36;';
	}elseif($code == 'TRY'){
		$displayCode = '&#x54;&#x4c;';
	}elseif($code == 'TTD'){
		$displayCode = '&#x24;';
	}elseif($code == 'TWD'){
		$displayCode = '&#x4e;&#x54;&#x24;';
	}elseif($code == 'UAH'){
		$displayCode = '&#8372;';
	}elseif($code == 'UGX'){
		$displayCode = '&#85;&#83;&#104;';
	}elseif($code == 'UYU'){
		$displayCode = '&#36;&#85;';
	}elseif($code == 'UZS'){
		$displayCode = '&#1083;&#1074;';
	}elseif($code == 'VEF'){
		$displayCode = '&#x42;&#x73;';
	}elseif($code == 'VND'){
		$displayCode = '&#8363;';
	}elseif($code == 'YER'){
		$displayCode = '&#65020;';
	}elseif($code == 'ZAR'){
		$displayCode = '&#x52;';
	}elseif($code == 'ZMK'){
		$displayCode = '&#90;&#75;';
	}
	return $displayCode;
}
add_action( 'wp_ajax_classiera_change_currency_tag', 'classiera_change_currency_tag' );
add_action( 'wp_ajax_nopriv_classiera_change_currency_tag', 'classiera_change_currency_tag' );
function classiera_change_currency_tag(){
	$currencyTag = $_POST['currencyTag'];	
	$displayTag = classiera_Display_currency_sign($currencyTag);
	echo $displayTag;
	die();
}
?>