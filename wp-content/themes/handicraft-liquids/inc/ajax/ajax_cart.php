<?php
/**
 * Ajax Cart
 */

if(isset($_COOKIE['cartCookie'])) {
	$cartCookie = json_decode(stripslashes($_COOKIE['cartCookie']));
	$arrId = array();
	$arrQty = array();
	$qty = 1;
	$sum = 0;
	foreach ($cartCookie as $mypost) {
		$arrId[] = $mypost->id;
		$arrQty[] = $mypost->qty;
		$qty = $mypost->qty;
		$sum += $qty; 
	}
}
if($sum == null){
	$sum = 0;
}
$arr = array(  
	'cartQty'       => $sum,
);

$json = json_encode($arr);
echo $json;