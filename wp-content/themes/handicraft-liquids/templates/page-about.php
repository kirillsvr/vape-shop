<?php
/**
 * Template name: About
 *
 * @package Handicraft Liquids
 * @subpackage Handicraft Liquids
 * @since Handicraft Liquids 1.0.0
 */

get_header(); ?>

	<?php wp_social_menu( 'right-social', '<a href="#" class="search-event"><span class="search"></span></a>' );?>
	<?php while ( have_posts() ) : the_post();?>
		<div class="page-content">
			<?php the_title( '<h1>', '</h1>' );?>
			<div class="entry-content">
				<?php the_content();?>
			</div>
		</div>

		<?php the_html_field();?>

	<?php endwhile; ?>
	
<?php get_footer(); ?>