<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package Handicraft Liquids
 * @subpackage Handicraft Liquids
 * @since Handicraft Liquids 1.0.0
 */

get_header(); ?>

	<div class="blue-zag">
		<?php wp_social_menu( 'right-social', '<a href="#" class="search-event"><span class="search"></span></a>' );?>
		<?php the_title( '<h1>', '</h1>' );?>
		<?php if(function_exists('bcn_display')) {?>
			<ol class="breadcrumb">
				<?php bcn_display();?>
			</ol>
		<?php } ?>
	</div>
	<div class="page-content">
		<div class="news-page">
			<?php while ( have_posts() ) : the_post();?>
				<?php the_content();?>
			<?php endwhile; ?>
			<a href="<?php the_permalink( get_option( 'page_for_posts' ) );?>" class="button">&larr; все новости</a>
		</div>
	</div>

<?php get_footer(); ?>