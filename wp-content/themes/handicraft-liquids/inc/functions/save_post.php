<?php
/**
 * Save Post
 */

function wp_acf_save_post( $post_id ) {

	if( empty($_POST['acf']) ) {
		return;
	}

	//$price_arr = $_POST['acf'];
	// specific field value
	$price        = $_POST['acf']['field_590bee8c01dbe'];
	$price_100    = $_POST['acf']['field_590d71070dd29'];
	$price_250    = $_POST['acf']['field_590d71170dd2a'];
	$price_gallon = $_POST['acf']['field_590d71350dd2b'];
	
	$status       = $_POST['acf']['field_590beec7a8986'];
	
	$meta_key        = 'price';
	$meta_key_100    = 'price_100';
	$meta_key_250    = 'price_250';
	$meta_key_gallon = 'price_gallon';

	if ( $post_id == 'options' ) {
		if( $status == 1 ) {
			//update_option( 'temp_option', $price_arr );
			
			$args = array(
				'post_type'      => 'product',
				'posts_per_page' => -1,
			);
			
			$posts = get_posts($args);
			
			foreach( $posts as $post ){
				update_field( $meta_key, $price, $post->ID);
			}
			
			$args2 = array(
				'post_type'      => 'product',
				'posts_per_page' => -1,
				'tax_query' => array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'id',
						'terms'    => array( 8 ),
					),
				),
			);
			
			$posts2 = get_posts($args2);
			
			foreach( $posts2 as $post ){
				update_field( $meta_key_100, $price_100, $post->ID);
				update_field( $meta_key_250, $price_250, $post->ID);
				update_field( $meta_key_gallon, $price_gallon, $post->ID);
			}
			
		}
		
	}
	
}

add_action('acf/save_post', 'wp_acf_save_post', 1 );