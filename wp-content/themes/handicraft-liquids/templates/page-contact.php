<?php
/**
 * Template name: Contact
 *
 * @package Handicraft Liquids
 * @subpackage Handicraft Liquids
 * @since Handicraft Liquids 1.0.0
 */

get_header(); ?>

	<div class="blue-zag">
		<?php wp_social_menu( 'right-social', '<a href="#" class="search-event"><span class="search"></span></a>' );?>
		<?php the_title( '<h1>', '</h1>' );?>
	</div>
	<?php while ( have_posts() ) : the_post();?>
		<div class="page-content">
			<div class="contacts-page">
				<?php the_html_field();?>
			</div>
		</div>

	<?php endwhile; ?>
	
<?php get_footer(); ?>