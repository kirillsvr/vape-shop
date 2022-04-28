<?php
/**
 * Template name: Cart
 *
 * @package Handicraft Liquids
 * @subpackage Handicraft Liquids
 * @since Handicraft Liquids 1.0.0
 */

get_header(); ?>

	<?php wp_social_menu( 'right-social', '<a href="#" class="search-event"><span class="search"></span></a>' );?>
	<div class="page-content">
		<?php 
			$cart_cookie = '';
			if( isset($_COOKIE['cartCookie'] ) ) {
				$cart_cookie = json_decode( stripslashes( $_COOKIE['cartCookie'] ), true );
			}
			if( !empty( $cart_cookie ) ) {
			?>
			<?php the_title( '<h1>', '</h1>' );?>
				<table class="basket-table">
					<thead>
						<tr>
							<td>товар</td>
							<td>количество</td>
							<td>цена за шт.</td>
							<td>объем</td>
							<td>стоимость</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ($cart_cookie as $cart_post) {
								$post_id = $cart_post['id'];
								$post_qty = $cart_post['qty'];
								$post_obj = get_post( (int) $post_id );
								$title = $post_obj->post_title;
								$post_volume = $cart_post['volume'];
							?>
							<tr>
								<td>
									<div class="name">
										<?php if( has_post_thumbnail( $post_id )){?>
											<img src="<?php echo get_the_post_thumbnail_url( $post_id, 'catalog' );?>" alt="">
										<?php } else { ?>
											<img src="<?php echo get_theme_file_uri( '/img/thumb.png' );?>" alt="">
										<?php } ?>
										<div>
											<span><?php echo $title;?></span>
											<?php the_field( 'tastes', $post_id );?>
										</div>
									</div>
								</td>
								<td>
									<label>Количество</label>
									<div class="number">
										<span class="minus btn-cart-minus"><img src="<?php echo get_theme_file_uri( '/img/minus.jpg' );?>"></span>
										<input type="text" value="<?php echo $post_qty;?>" class="input-qty">
										<span class="plus btn-cart-plus"><img src="<?php echo get_theme_file_uri( '/img/plus.jpg' );?>"></span>
									</div>
								</td>
								<td>
									<label>Цена за шт.</label>
									<input type="hidden" class="price-count-default" value="<?php the_field( $post_volume, $post_id );?>">
									<input type="hidden" class="cart-product-id" value="<?php echo $post_id;?>">
									
									<div class="price"><span><?php the_field( $post_volume, $post_id );?></span> p</div>
								</td>
								<td>
									<?php
										$terms =  wp_get_post_terms( $post_id, 'product_cat', array( 'fields' => 'ids' ) );
										if( in_array( '8', $terms )) { ?>
										<label>Объем</label>
										<select class="select-volume-option-cart">
											<?php if( get_field('price', $post_id )){?>
												<option value="price" data-price="<?php the_field('price', $post_id);?>" <?php selected($post_volume, 'price');?>>10 мл.</option>
											<?php } ?>
											<?php if( get_field('price_100', $post_id)){?>
												<option value="price_100" data-price="<?php the_field('price_100',$post_id);?>" <?php selected($post_volume, 'price_100');?>>100 мл.</option>
											<?php } ?>
											<?php if( get_field('price_250',$post_id)){?>
												<option value="price_250" data-price="<?php the_field('price_250',$post_id);?>" <?php selected($post_volume, 'price_250');?>>250 мл.</option>
											<?php } ?>
											<?php if( get_field_object('price_gallon',$post_id)){
												?>
												<option value="price_gallon" data-price="<?php the_field('price_gallon',$post_id);?>" <?php selected($post_volume, 'price_gallon');?>>галлон</option>
											<?php } ?>
										
										</select>
									<?php } ?>
								</td>
								<td>
									<label>Стоимость</label>
									<div class="price"><span class="price-count"><?php echo get_field( $post_volume, $post_id ) * $post_qty;?></span> p</div>
								</td>
								<td>
									<a href="#" class="delete remove-from-cart" data-id="<?php echo $post_id;?>"></a>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			
				<div class="basket-right sidebar-cart-page">
					<?php
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
				</div>
				<div class="basket-left">
					<button class="go-to-order-form">оформить заказ</button>
					<a href="<?php the_permalink( 210 );?>"><img src="<?php echo get_theme_file_uri( '/img/delivery.jpg' );?>"> Доставка и оплата</a>
				</div>
				<div class="clear"></div>
				<div class="contacts-zag" id="order-form">
					<span>Оформление заказа</span>
				</div>
				<div class="site-form site-form-order">
					<div>
						<div class="select active">
							<span class="chb"></span> физическое лицо
						</div>
						<div class="select">
							<span class="chb"></span> Юридическое лицо
						</div>
						<div class="clear"></div>
						<div class="form">
							<?php echo do_shortcode('[contact-form-7 id="233" title="Форма заказа физическое лицо"]');?>
							
						</div>
						<div class="form hidden">
							<?php echo do_shortcode('[contact-form-7 id="234" title="Форма заказа Юридическое лицо"]');?>
						</div>
					</div>
				</div>
				<div class="site-subscribe">
					<div class="index-page-slider-right">
						<?php theme_field( 'subscribe' );?>
					</div>
				</div>
				<div class="clear"></div>
			<?php } else { ?>
				<?php the_title( '<h1>', ' Пуста</h1>' );?>
			<?php } ?>
		</div>
	
<?php get_footer(); ?>