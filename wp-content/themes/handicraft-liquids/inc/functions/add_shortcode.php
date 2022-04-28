<?php
/**
 * Add Shortcode
 */

/**
 * Current Year
 */
function current_year( ){
	$current_year = get_current_year();
	return $current_year;
}
add_shortcode( 'current_year', 'current_year' );

/**
 * Echo copyright years
 *
 * @use [copy_year year="2014"]
 */
function copyright_years( $atts ){
	
	extract( shortcode_atts( array(
		'year' => ''
	 ), $atts ) );
	
	$made_year = $year;
	$current_year = get_current_year();
	if($made_year != '' && $made_year != $current_year && $made_year < $current_year ){
		$copyright_years = $made_year.' - '.$current_year;
	} else {
		$copyright_years = $current_year;
	}
	
	return $copyright_years;
}
add_shortcode( 'copy_year', 'copyright_years' );

/**
 * Current Year
 */
function theme_img_path( ){
	$theme_img_path = get_theme_file_uri( '/img/' );
	return $theme_img_path;
}
add_shortcode( 'theme_img_path', 'theme_img_path' );

/**
 * Do ACF Field 
 *
 * @use [do_field field="field_name" theme-field="theme_field"]
 */
function do_acf_field( $atts ){
	
	extract( shortcode_atts( array(
		'field'       => '',
		'theme_field' => '',
	 ), $atts ) );
	
	if( $theme_field ) {
		return do_shortcode( theme_field( $theme_field, false ) );	
	} else {
		return get_field( $field );
	}

}
add_shortcode( 'do_field', 'do_acf_field' );

/**
 * Get Permalink Shortcode by id
 *
 * @use [get_permalink id="page_id"]
 */
function get_permalink_shortcode( $atts ){
	
	extract( shortcode_atts( array(
		'id' => '',
	 ), $atts ) );
	
	return get_permalink( $id );

}
add_shortcode( 'get_permalink', 'get_permalink_shortcode' );

/**
 * Get Term Permalink Shortcode by id
 *
 * @use [get_term_link id="term_id" tax="taxonomy_name"]
 */
function get_term_link_shortcode( $atts ){
	
	extract( shortcode_atts( array(
		'id'  => '',
		'tax' => 'category',
	), $atts ) );
	
	$term_link = get_term_link( (int) $id, $tax );
	if(!is_wp_error( $term_link )){
		return $term_link;
	}

}
add_shortcode( 'get_term_link', 'get_term_link_shortcode' );
