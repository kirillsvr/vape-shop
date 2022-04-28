<?php
/**
 * The template for displaying the header
 *
 * @package Handicraft Liquids
 * @subpackage Handicraft Liquids
 * @since Handicraft Liquids 1.0.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<?php wp_head(); ?>
</head>
<body <?php body_class( 'index_page' ); ?>>

	<div class="searchbg"></div>
	<?php if( !is_mobile() ) {?>
		<div class="right-search<?php if(is_front_page()){echo ' index';}?>">
			<?php get_search_form();?>
		</div>
	<?php } ?>
	
	<?php get_sidebar(); ?>
	
	<?php if( is_front_page() ) {?>
		<div class="main">
	<?php } else { ?>
		<div class="main-content dji">
	<?php } ?>