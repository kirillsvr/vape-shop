<?php

/**
 * WP Simple NavWalker
 */

class WP_Simple_NavWalker extends Walker_Nav_Menu {

	/**
	 * Starts the element output.
	 *
	 * @since 3.0.0
	 * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
	 *
	 * @see Walker::start_el()
	 *
	 * @param string   $output Passed by reference. Used to append additional content.
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		if ( ! property_exists( $this , 'indents' ) ) {
			$args->indents = 0;
		};
		$indents_count = $args->indents + 1;
		$tab = "\t";
		$indents = "\n";
		if($indents_count > 0){
			for($i = 1; $i <= $indents_count; $i++){
				$indents .= "\t";
			}
		}
	
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$class = '';
		if( in_array( 'current-menu-item', $classes )) {
			$class = 'active';
		}

		//$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

		$class_name = $class;
		$class_name = $class_name ? ' class="' . esc_attr( $class_name ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indents . '<li' . $id . $class_name .'>';

		$atts = array();
		//$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		//$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$title = apply_filters( 'the_title', $item->title, $item->ID );
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

		$item_output = $indents . $tab;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . $title . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $indents;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
	
	/**
	 * Ends the element output, if needed.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::end_el()
	 *
	 * @param string   $output Passed by reference. Used to append additional content.
	 * @param WP_Post  $item   Page data object. Not used.
	 * @param int      $depth  Depth of page. Not Used.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= '</li>';
	}
	
}

// Get menu indets
function get_menu_indents( $indents = 0, $plus = 0 ) {
	$indents_count = $indents + $plus;
	$tab = "\t";
	$indents = "\n";
	if($indents_count > 0){
		for($i = 1; $i <= $indents_count; $i++){
			$indents .= "\t";
		}
	}
	return $indents;
}

// Add After Menu
function add_after_wp_nav_menu( $output, $args ) {
	$n = "\n";
	$end = '<!-- .' . $args->menu_class . ' -->';
	return $output . $end . $n;
}
add_filter( 'wp_nav_menu', 'add_after_wp_nav_menu', 10 , 2 );