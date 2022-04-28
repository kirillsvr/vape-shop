<?php
/**
 * The template for the sidebar catalog
 *
 * @package Handicraft Liquids
 * @subpackage Handicraft Liquids
 * @since Handicraft Liquids 1.0.0
 */
?>

<div class="cart-info sidebar-cart-catalog">
<?php
$sum = 0;
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

	if( $sum > 0 ) { 
		$price = 0;
		?>
		<a href="#" class="top-link">товаров в заказе <span><?php echo $sum;?></span></a>
		<table class="cart-table">
			<?php
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
					?>
					<tr>
						<td><?php echo $title;?></td>
						<td><?php echo $post_qty;?></td>
						<td><a href="#" class="delete" data-id="<?php echo $post_id;?>"></a></td>
					</tr>
					<?php
				}
			?>
		</table>
		
		<?php
			$promo_procent = get_field('promo_1', 'option');
			$next_procent = get_field('promo_2', 'option');
			if ( $price_promo <= 10000 ) {
				$promo_procent = get_field('promo_1', 'option');
			} else if ( $price_promo >= 10001 && $price_promo <= 20000 ) {
				$promo_procent = get_field('promo_2', 'option');
				$next_procent = get_field('promo_3', 'option');
			} else if ( $price_promo >= 20001 && $price_promo <= 30000 ) {
				$promo_procent = get_field('promo_3', 'option');
				$next_procent = get_field('promo_5', 'option');
			} else if ( $price_promo >= 30001 && $price_promo <= 50000 ) {
				$promo_procent = get_field('promo_4', 'option');
				$next_procent = get_field('promo_5', 'option');
			} else if ( $price_promo > 50001 ) {
				$promo_procent = get_field('promo_5', 'option');
				$next_procent = false;
			}
			
      //echo $promo_procent.'- promo_procent <br>';
			// Get Discount Price
			$price_promo_result = get_discount( $price_promo, $promo_procent);
      //echo $price_promo_result.'- price_promo_result <br>';
			$price_total = $price_promo_result + $price;
      //echo $price_total.'- price_total <br>';
			$discount_flaw = 10000 - $price_promo;
      //echo $discount_flaw.'- discount_flaw <br>';
		?>
		
		<div class="cart-result">
			<div class="result"><?php echo $price_total;?> P</div>
			<?php if($price_gallon == true){?>
          <div class="cart-result-gallon"><span>+</span> галлон</div>
			<?php } ?>
			<div class="discount">ваша скидка</div>
			<div class="result"><?php echo $promo_procent;?>%</div>
			<?php if( $price_promo < 10001){ ?>
				<p>До скидки в <?php the_field('promo_2', 'option');?>% вам нужно положить в корзине еще на <?php echo $discount_flaw;?> руб.</p>
			<?php } else if ( $price_promo >= 10001 && $price_promo <= 20000 ) { ?>
          		<p>До скидки в <?php the_field('promo_3', 'option');?>% вам нужно положить в корзине еще на <?php echo $discount_flaw;?> руб.</p>
          	<?php } else if ( $price_promo >= 20001 && $price_promo <= 30000 ) { ?>
          		<p>До скидки в <?php the_field('promo_4', 'option');?>% вам нужно положить в корзине еще на <?php echo $discount_flaw;?> руб.</p>
          	<?php } else if ( $price_promo >= 30001 && $price_promo <= 50000 ) { ?>
          		<p>До скидки в <?php the_field('promo_5', 'option');?>% вам нужно положить в корзине еще на <?php echo $discount_flaw;?> руб.</p>
          	<?php } ?>
			<a href="<?php the_permalink(186);?>" class="button">оформить заказ</a>
		</div>
	<?php } else {?>
		<span class="top-link">Ваша корзина пуста</span>
	<?php } ?>
</div>
<div class="clear"></div>