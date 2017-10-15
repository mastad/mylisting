<?php
global $redux_demo;
function classiera_currency_sign(){
	global  $woocommerce;
	$currCode = "";
	if (function_exists("get_woocommerce_currency_symbol")){
		$currCode = get_woocommerce_currency_symbol();
	}else{
		$currCode = "$";
	}
	
	return $currCode;
}
function classiera_Plans_URL(){
	global $redux_demo;
	$login = $redux_demo['login'];
	$new_post = $redux_demo['new_post'];
	if(is_user_logged_in()){
		$redirect =	$new_post;
	}else{
		$redirect = $login;
	}
	return $redirect;
}
?>