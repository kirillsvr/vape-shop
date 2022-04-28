<?php
/**
 * Handicraft Liquids Custom Style Loader Tag
 *
 * Clean tag link
 *
 * @link https://developer.wordpress.org/reference/hooks/style_loader_tag/
 *
 * @package Handicraft Liquids
 * @subpackage Handicraft Liquids
 * @since Handicraft Liquids 1.0.0
 */

//Custom Style Loader Tag
function update_style_loader_tags( $html, $handle, $href ) {
	$html = '<link href="'.$href.'" rel="stylesheet">'."\n";
	return $html;
}
add_filter('style_loader_tag', 'update_style_loader_tags', 10, 3);