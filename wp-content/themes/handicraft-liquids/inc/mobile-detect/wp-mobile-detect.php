<?php
/**
 * Mobile Detect
 */
require_once get_parent_theme_file_path( '/inc/mobile-detect/mobile-detect.php' );

$detect = new Mobile_Detect();

function is_mobile(){
	global $detect;
	if ( $detect->isMobile() ) {
		return true;
	}
}

function front_page_mobile_redirect(){
	if( is_front_page() ){
		if ( is_mobile() ) {
			include( get_parent_theme_file_path( '/front-page-mobile.php' ) );
			exit;
		}
	}
}
add_action( 'template_redirect', 'front_page_mobile_redirect' );