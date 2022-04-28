<?php
/**
 * WP Social menu
 *
 * @package Handicraft Liquids
 * @subpackage Handicraft Liquids
 * @since Handicraft Liquids 1.0.0
 */ 
function wp_social_menu($class = array(), $end_el = '' ){

	if( !is_array( $class ) ){
		$classes = array();
		$classes[] = $class;
	}
	$classes[] = 'social-menu';
	$locations = get_nav_menu_locations();
	$location = $locations['social'];
	$menu_object = wp_get_nav_menu_object( $location ); 
	$menu_id = $menu_object->term_id;
	
	$menu_items = wp_get_nav_menu_items( $menu_id );

	$menu_html = '<div class="'.implode(" ", $classes).'">'."\n";
	foreach($menu_items as $menu_item){
		$this_classes = $menu_item->classes[0];
		$target = $menu_item->target;
		if($target != '') {
			$target = ' target="' . $menu_item->target . '"';
		}
		if ($menu_item->classes[0]){
			$html_class = '<span class="fa '.$menu_item->classes[0].'"></span>'."\n";
		} else {
			$html_class = $menu_item->title;
		}
		$menu_html .= '<a href="' . $menu_item->url . '"' . $target . '>'."\n";
		$menu_html .= $html_class;
		$menu_html .= '</a>'."\n";
	}
	$menu_html .= $end_el."\n";
	$menu_html .= '</div>'."\n";
	
	echo $menu_html;
	
}