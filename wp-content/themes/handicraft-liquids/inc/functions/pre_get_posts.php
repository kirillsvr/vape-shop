<?php
/**
 * Pre Get Posts
 *
 * @package Handicraft Liquids
 * @subpackage Handicraft Liquids
 * @since Handicraft Liquids 1.0.0
 */

function search_filter($query) {
	$exclude_ids = array ( get_option( 'page_on_front' ), 186 );
	if ( !is_admin() && $query->is_main_query() ) {
		if ( $query->is_search ) {
			$query->set( 'post__not_in', $exclude_ids );
			$query->set( 'posts_per_page', 10 );
		}
	}
}
add_action('pre_get_posts','search_filter');

function search_order_filter($query) {
	if ( !is_admin() && $query->is_main_query() && $query->is_tax('product_cat') ) {
		if (isset($_GET['orderby'])){
			$orderby = $_GET['orderby'];			
		} else {
			$orderby = 'title';
		}
		$meta_key = '';
		if($orderby == 'price') {
			$meta_key = $orderby;
			$orderby = 'meta_value_num';
		}
		
		if (isset($_GET['order'])){
			$order = $_GET['order'];
		} else {
			$order = 'ASC';
		}
		if (isset($_GET['search'])){
			$s = $_GET['search'];
		} else {
			$s = '';
		}
		
		// Rewrite default WP Query
		$query->set( 'orderby' , $orderby );
		$query->set( 'order'   , $order );
		$query->set( 'meta_key', $meta_key );
		$query->set( 's'       , $s );
		
	}
}
add_action('pre_get_posts','search_order_filter');
