<?php
/**
 * Ajax Cart Content
 */
require_once('../../../../../wp-load.php');

$price = 0;
if(isset($_COOKIE['cartCookie'])) {
$cartCookie = json_decode(stripslashes($_COOKIE['cartCookie']));
$arrId = array();
$arrQty = array();
$qty = 1;
$sum = 0;
$volume = 'price';
$price_promo = 0;
$price_gallon = false;
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
if( $sum > 0 ) {
	foreach ($cartCookie as $cart_post) {
		$post_id = $cart_post->id;
		$post_qty = $cart_post->qty;
		$post_obj = get_post( (int) $post_id );
		$title = $post_obj->post_title;
		$post_price = get_field($cart_post->volume, $post_id);
		$post_price = $post_price * $post_qty;
		if($post_price == 'price_gallon'){
			$price_gallon = true;
		}
		$terms =  wp_get_post_terms( $post_id, 'product_cat', array( 'fields' => 'ids' ) );
		if( in_array( '8', $terms )) {
			$price_promo += $post_price;
		} else {
			$price += $post_price;	
		}
	}
}
?>

<?php
	// Get Discount Procent
	$promo_procent = get_field('promo_1', 'option');
	$next_procent = get_field('promo_2', 'option');
	$price_remaind = 100000;
	if ( $price_promo <= 10000 ) {
		$promo_procent = get_field('promo_1', 'option');
		$price_remaind = 10000;
	} else if ( $price_promo >= 10001 && $price_promo <= 20000 ) {
		$promo_procent = get_field('promo_2', 'option');
		$next_procent = get_field('promo_3', 'option');
		$price_remaind = 20000;
	} else if ( $price_promo >= 20001 && $price_promo <= 30000 ) {
		$promo_procent = get_field('promo_3', 'option');
		$next_procent = get_field('promo_5', 'option');
		$price_remaind = 30000;
	} else if ( $price_promo >= 30001 && $price_promo <= 50000 ) {
		$promo_procent = get_field('promo_4', 'option');
		$next_procent = get_field('promo_5', 'option');
		$price_remaind = 50000;
	} else if ( $price_promo > 50001 ) {
		$promo_procent = get_field('promo_5', 'option');
		$next_procent = false;
		$price_remaind = 0;
	}
	
	// Get Discount Price
	$price_promo_result = get_discount( $price_promo, $promo_procent);
	$price_total = $price_promo_result + $price;
	$discount_flaw = $price_remaind - $price_promo;
?>

<div class="item">
	ваша скидка
	<span><?php echo $promo_procent;?>%</span>
</div>
<div class="item right">
	всего
	<span><i><?php echo $price_total;?></i> p</span>
</div>
<?php if($price_gallon == true){?>
	<div class="cart-result-gallon">плюс галлон</div>
<?php } ?>
<div class="clear"></div>