<?php
/**
 * Template name: Questions
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
			<?php the_content();?>
			<div class="faq-page">

				<?php if( have_rows('question') ): ?>
					<?php while( have_rows('question') ): the_row(); ?>
						<div class="question-items">
							<div class="zag">
								<span class="y">?</span>
								<?php the_sub_field('question_group'); ?>
							</div>
							<?php if( have_rows('questions') ): ?>
								<?php while( have_rows('questions') ): the_row();?>
									<div class="faq-item">
										<div class="top-text"><?php the_sub_field('question-item'); ?></div>
										<div class="bottom-text">
											<?php the_sub_field('answer'); ?>
										</div>
									</div>
								<?php endwhile; ?>
							<?php endif; ?>
						</div><!-- .question-items -->
					<?php endwhile; ?>
				<?php endif; ?>

			</div>
		</div>

	<?php endwhile; ?>
	
<?php get_footer(); ?>