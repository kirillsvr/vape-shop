<?php

/**
 * WP Nav Cut Menu
 */

function wp_nav_cut_menu( $menu = 'primary', $cut = 4 ){
	
	$classes = array( 'site-menu' );
	$locations = get_nav_menu_locations();
	$location = $locations[ $menu ];
	$menu_object = wp_get_nav_menu_object( $location ); 
	$menu_id = $menu_object->term_id;
	$menu_items = wp_get_nav_menu_items( $menu_id );
	$menu_html = '<ul class="'.implode(" ", $classes).'">'."\n";
		$i = 0;
		$count = count($menu_items);
		foreach($menu_items as $menu_item){
			if ( $cut == $i ) {
				$menu_html .= '<li><a class="more-menu-link"><img src="' . get_theme_file_uri( '/img/more-link.png' ) . '"></a></li>';
				$menu_html .= '<li>';
				$menu_html .= '<ul class="more-menu">';
			}
			$menu_html .= '<li><a href="' . $menu_item->url . '">' . $menu_item->title . '</a>'."\n".'</li>'."\n";
			if ( $count == $i ) {
				$menu_html .= '</li>';
				$menu_html .= '</ul>';
			}
			$i++;
		}
	$menu_html .= '</ul>'."\n";
	echo $menu_html;

}