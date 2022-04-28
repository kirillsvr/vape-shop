<?php
/**
 * Wp Enqueue Scripts
 *
 * @package Handicraft Liquids
 * @subpackage Handicraft Liquids
 * @since Handicraft Liquids 1.0.0
 */

function handicraft_liquids_scripts() {

	// FontAwesome
	wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', false, '4.5.0' );
	// Slick
	wp_enqueue_style( 'slick', get_theme_file_uri( '/css/slick.css' ), false, '1.6.0' );
	// Stylesheet
	wp_enqueue_style( 'stylesheet', get_stylesheet_uri(), false, get_theme_version() );
	
	if ( is_front_page() ) {
		if( !is_mobile() ){
		// One Page Scroll
			wp_enqueue_style( 'onepage-scroll', get_theme_file_uri( '/css/onepage-scroll.css' ), false, '1.3.1' );
		}
	}

	if (!is_admin()) {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', get_theme_file_uri( '/js/jquery.min.js' ), false, '2.2.4', true );
		//wp_enqueue_script( 'jquery' );
		wp_deregister_script( 'wp-embed' );
	}

	if ( is_front_page() ) {
		// jQuery Onepage Scroll
		if( !is_mobile() ){
			wp_enqueue_script( 'onepage-scroll', get_theme_file_uri( '/js/jquery.onepage-scroll.js' ), array( 'jquery' ), '1.3.1', true );
		}
	}
	// Slick
	wp_enqueue_script( 'slick', get_theme_file_uri( '/js/slick.min.js' ), array( 'jquery' ), '1.6.0', true );
	// jQuery Cookie
	wp_enqueue_script( 'jquery-cookie', get_theme_file_uri( '/js/jquery.cookie.js' ), array( 'jquery' ), '1.4.1', true );
	
	if ( ! is_front_page() ) {
		// Waypoints
		wp_enqueue_script( 'waypoints', get_theme_file_uri( '/js/jquery.waypoints.js' ), array( 'jquery' ), '4.0.1', true );
	}
	// Cart Scrips
	wp_enqueue_script( 'cart', get_theme_file_uri( '/js/cart.js' ), array( 'jquery' ), get_theme_version(), true );
	// Load Main Scrips
	wp_enqueue_script( 'scripts', get_theme_file_uri( '/js/common.js' ), array( 'jquery' ), get_theme_version(), true );

}
add_action( 'wp_enqueue_scripts', 'handicraft_liquids_scripts' );