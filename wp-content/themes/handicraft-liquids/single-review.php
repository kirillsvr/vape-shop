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
		<div class="reviews-page">
			<?php while ( have_posts() ) : the_post();?>
				
				<article class="review-item">
					<?php if(has_post_thumbnail()){?>
						<img src="<?php the_post_thumbnail_url( 'review' );?>" class="image">
					<?php } ?>
					<div class="content">
						<span class="name"><?php the_title();?></span>
						
						<?php the_content();?>
						
						<div class="links">
							<?php if( get_field('video_review')){?>
							<img src="<?php echo get_theme_file_uri( '/img/review1.jpg' );?>"> <a href="<?php the_field('video_review'); ?>" class="a1">видеоотзыв</a><br/>
							<?php } ?>
							<?php if( get_field('letter_thanks') ){?>
								<img src="<?php echo get_theme_file_uri( '/img/review2.jpg' );?>"> <a href="<?php echo wp_get_attachment_image_url( get_field('letter_thanks'), 'large' ); ?>" class="a2">благодарственное письмо</a>
							<?php } ?>
						</div>
					</div>
					<div class="clear"></div>
				</article>
					
			<?php endwhile; ?>
			<a href="<?php echo get_post_type_archive_link( 'review' ); ?>" class="button">&larr; все отзывы</a>
		</div>
	</div>

<?php get_footer(); ?>