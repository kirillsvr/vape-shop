<?php
/**
 * Plugin Contact Form 7
 */


//Before Send Mail
function send_order_products(){
	
	$result = '';
	$cart_cookie = '';
	if( isset($_COOKIE['cartCookie'] ) ) {
		$cart_cookie = json_decode( stripslashes( $_COOKIE['cartCookie'] ), true );
	}
	if( !empty( $cart_cookie ) ) {
		
		foreach ($cart_cookie as $cart_post) {
			$post_id = $cart_post['id'];
			$post_qty = $cart_post['qty'];
			$post_obj = get_post( (int) $post_id );
			$title = $post_obj->post_title;
			$volume = $cart_post['volume'];
			
			$post_volume = get_field( 'global_' . $volume, 'option');
			$terms =  wp_get_post_terms( $post_id, 'product_cat', array( 'fields' => 'ids' ) );
			if( in_array( '8', $terms )) {
				$post_volume = $post_volume. ' мл.';
			} else {
				$post_volume = '';
			}
			$post_price = get_field( $volume, $post_id ) * $post_qty;
		
			$result .= '<tr>';
				$result .= '<td style="padding:5px 2px 5px 10px;border-bottom:1px solid #333333;">
				<a href="' . get_the_permalink($post_id) . '">' . get_the_title($post_id) . '</a>
			</td>';
				$result .= '<td style="padding:5px 10px 5px 2px;border-bottom:1px solid #333333;">'.$post_qty.' </td>';
				$result .= '<td style="padding:5px 10px 5px 2px;border-bottom:1px solid #333333;">'.$post_volume.'</td>';
				$result .= '<td style="padding:5px 10px 5px 2px;border-bottom:1px solid #333333;">'.$post_price.' </td>';
			$result .= '</tr>';
		}
	}
	return $result;
}


function send_order_products_price(){
	
	$result = '';
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

	// Get Discount Procent
	$promo_procent = get_field('promo_1', 'option');
	if ( $price_promo <= 4000 ) {
		$promo_procent = get_field('promo_1', 'option');
	} else if ( $price_promo > 4001 && $price_promo <= 8000 ) {
		$promo_procent = get_field('promo_2', 'option');
	} else if ( $price_promo > 8001 ) {
		$promo_procent = get_field('promo_3', 'option');
	}
	// Get Discount Price
	$price_promo_result = get_discount( $price_promo, $promo_procent);
	$price_total = $price_promo_result + $price;
	$discount_flaw = 8000 - $price_promo;

	$price_total = $price_total.' руб ';
	if( $price_gallon == true){
		$price_total .=	'плюс галлон';
	}
	
	$result .= '<tr><td style="padding:5px 5px;text-align: center;">Скидка: '.$promo_procent.'%</td></tr>';
	$result .= '<tr><td style="padding:5px 5px;text-align: center;">Итог: '.$price_total.'</td></tr>';
	
	return $result;
}

function send_order_products_html(){
	
	$products = send_order_products();
	$total_price = send_order_products_price();
	$site_title = get_bloginfo('name');			
	$site_url = get_bloginfo('url');

	$send_order_products = '
		<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#DDDDDD" style="width:100%;background:#dddddd;padding-bottom:10px;">
			<tbody>
				<tr>
					<td>
						<div style="max-width:600px;margin:0 auto;">
							<table style="background:#ffffff;width:100%;" cellspacing="0" cellpadding="0">
								<tbody>
									<tr>
										<td style="padding:5px 2px 5px 10px;background:#333333;color:#ffffff">Название</td>
										<td style="padding:5px 2px 5px 10px;background:#333333;color:#ffffff">Каличество</td>
										<td style="padding:5px 2px 5px 10px;background:#333333;color:#ffffff">Объем</td>
										<td style="padding:5px 10px 5px 2px;background: #333333;color: #ffffff;" >Цена</td>
									</tr>'. $products . '
								</tbody>
							</table>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<table border="0" style="background-color:#333;color:#fff;width:100%;" cellpadding="0" cellspacing="0">
			<tbody>
				'.send_order_products_price().'
			</tbody>
		</table>
		<table border="0" style="background-color:#333;color:#fff;width:100%;" cellpadding="0" cellspacing="0">
			<tbody>
				<tr>
					<td style="padding:5px 5px;text-align: center;">Это сообщение отправлено с сайта <a href="'.$site_url.'" style="color:#fff;">'.$site_title.'</a></td></tr></tbody></table>';
	
	return $send_order_products;
}

//Add Products to mail sent Contact Form 7
function wpcf7_update_email_body($contact_form) {
	$id = $contact_form->id();
	if($id == 233 || $id == 234){
		$submission = WPCF7_Submission::get_instance();
		if ( $submission ) {
			$mail = $contact_form->prop('mail');

			$mail['body'] .= send_order_products_html();
			$contact_form->set_properties(array('mail' => $mail));
		}
	}
}
add_action("wpcf7_before_send_mail", "wpcf7_update_email_body");
