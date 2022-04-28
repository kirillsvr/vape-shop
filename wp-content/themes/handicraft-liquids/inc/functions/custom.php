<?php
/**
 * Handicraft Liquids custom functions and definitions
 *
 * @package Handicraft Liquids
 * @subpackage Handicraft Liquids
 * @since Handicraft Liquids 1.0.0
 */

/**
 * Get Theme Version
 *
 * @return string Current Theme Version.
 * @uses echo get_theme_version()
 */
function get_theme_version(){
	$theme = wp_get_theme();
	$version = $theme->get( 'Version' );
	return $version;
}

/**
 * Add tag to n word from string
 *
 * add_tag_to_n_word( $words_string, $order_number, $tag );
 * @example echo add_tag_to_n_word( 'my custom text', 2, 'div' );
 */
function add_tag_to_n_word( $text = '', $n = 1, $tag = 'span' ) {

	$arr_text = explode( ' ', $text );
	$n = $n - 1;
	if ( array_key_exists( $n, $arr_text ) ) {
		$arr_text[ $n ] = '<' . $tag . '>' . $arr_text[ $n ] . '</' . $tag . '>';
		return $text = implode( ' ', $arr_text);
	} else {
		return $text;
	}

}

/**
 * Get the current Url taking into account Https and Port
 * @link http://css-tricks.com/snippets/php/get-current-page-url/
 * @version Refactored by @AlexParraSilva
 */
function getCurrentUrl() {
	$url  = isset( $_SERVER['HTTPS'] ) && 'on' === $_SERVER['HTTPS'] ? 'https' : 'http';
	$url .= '://' . $_SERVER['SERVER_NAME'];
	$url .= in_array( $_SERVER['SERVER_PORT'], array('80', '443') ) ? '' : ':' . $_SERVER['SERVER_PORT'];
	$url .= $_SERVER['REQUEST_URI'];
	return esc_url($url);
}

/**
 * Get Clean Telephone Number
 *
 * @return Clean Intenger from string
 * @uses echo get_clean_numb()
 */
function get_clean_tel( $string = ''){
	$replace_args = array(
		' ',
		',',
		'(',
		')',
		//'+',
		'-'
	);
	$clean_int = str_replace( $replace_args, '', $string);
	return $clean_int;
}

/**
 * Get Percentage From Number
 *
 * @return Percentage From Number
 * @uses echo get_percentage( $number, $percentage )
 */
function get_percentage( $number = '', $percentage = ''){
	$number = $number * ( $percentage / 100 );
	return $number;
}

/**
 * Get Discount Percentage From Number
 *
 * @return Percentage From Number
 * @uses echo get_discount( $number, $percentage )
 */
function get_discount( $number = '', $percentage = ''){
	$percentage = get_percentage( $number, $percentage );
	$discount = $number - $percentage;
	return $discount;
}

/**
 * Get Current Year
 *
 * @return string Current year.
 */
function get_current_year(){
	$current_year = date( 'Y' );
	return $current_year;
}

/**
 * Get HTML Repeater Fields
 */
function the_html_field() {
	
	if ( get_field( 'html' ) ) :
		while( has_sub_field( 'html' ) ) :
			echo do_shortcode( get_sub_field( 'section' ) )."\n\n";
		endwhile;
	endif;
	
}