<?php
/**
 * Ajax Cart
 */
//global $wpdb;
require_once('../../../../../wp-load.php');

$totals = 0;
if(isset($_COOKIE['cartCookie'])) {
	$cart_cookie = json_decode(stripslashes($_COOKIE['cartCookie']), true);
}
if(isset($cart_cookie)){
	if(!empty($cart_cookie)){
		foreach ($cart_cookie as $cart_post) {
			$post_id = $cart_post['id'];
			$post_qty = $cart_post['qty'];
			if ( get_post_meta( $post_id, '_price', true ) ){ 
				$value_price = get_post_meta( $post_id, '_price', true );
				$totals += ($value_price * $post_qty);
			}
		}
	}
}


$totals = preg_replace("/[^x\d|*\.]/","",$totals);
$totals = number_format($totals, 0, '.', ' ');

$arr = array(  
	'cartSum'       => $totals,
);

$json = json_encode($arr);
echo $json;