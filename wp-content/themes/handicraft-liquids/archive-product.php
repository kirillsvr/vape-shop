<?php
/**
 * The template for displaying archive product
 *
 * @package Handicraft Liquids
 * @subpackage Handicraft Liquids
 * @since Handicraft Liquids 1.0.0
 */

get_header(); ?>

	<?php wp_social_menu( 'right-social', '<a href="#" class="search-event"><span class="search"></span></a>' );?>
	<div class="page-content">
		<h1>Каталог</h1>
		<?php if(function_exists('bcn_display')) {?>
			<ol class="breadcrumb">
				<?php bcn_display();?>
			</ol>
		<?php } ?>
	</div>
	<div class="catalog">
		<?php
			$taxonomy = 'product_cat';
			$args = array(
			'taxonomy'      => $taxonomy,
			'hide_empty'    => false,
			'parent'         => 0,
		); 
		$terms = get_terms( $args );
		if ( !empty( $terms ) && !is_wp_error( $terms ) ) { ?>
			<?php foreach ($terms as $term) { ?>
				<?php $term_id = $term->term_id; ?>
				<div class="item">
					<div class="content">
						<div class="zag"><?php echo $term->name;?></div>
						<?php 
							$args_child = array(
							'taxonomy'      => $taxonomy,
							'hide_empty'    => false, 
							'child_of'      => $term_id,
						); 
						$terms_child = get_terms( $args_child );
						$count = count( $terms_child );
						if ( !empty( $terms_child ) && !is_wp_error( $terms_child ) ) {
							$class = '';
							if ( $count > 2 ) {
								$class = ' class="small"';
							}?>
							
							<ul<?php echo $class;?>>
							<?php foreach ($terms_child as $term_child) { ?>
								<li><a href="<?php echo get_term_link( $term_child );?>"><?php echo $term_child->name;?></a></li>
							<?php } ?>
							</ul>
						<?php } else { ?>
							<?php echo term_description( $term_id, $taxonomy ) ?>
						<?php } ?>
						<a href="<?php echo get_term_link( $term );?>" class="button">смотреть каталог</a>
						<div class="price"><?php the_field( 'price', $term ); ?></div>
						<div class="clear"></div>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
		<div class="clear"></div>
	</div>
	<div class="callback-text">
		<div class="right-text">
			<?php theme_field( 'catalog_feedback' );?>
		</div>
		<div class="main-text">
			<?php theme_field( 'catalog_desc' );?>
		</div>
		<div class="clear"></div>
	</div>
	<div class="bottom-icons">
		<?php theme_field( 'catalog_icons' );?>
		<div class="clear"></div>
	</div>

<?php get_footer(); ?>