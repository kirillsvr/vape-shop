<?php
/**
 * The template for displaying the footer
 *
 * @package Handicraft Liquids
 * @subpackage Handicraft Liquids
 * @since Handicraft Liquids 1.0.0
 */
?>

	<section>
		<?php wp_social_menu( 'right-social', '<a href="#" class="search-event"><span class="search"></span></a>' );?>
		<div class="main-content no_m">
			<div class="index-contacts">
				<div class="content">
					<div class="contacts-content">
						<div class="info">
							<div class="zag">контакты</div>
							<div class="adress">
								<img src="<?php echo get_theme_file_uri( '/img/adress.png' );?>">
								<div>
									<?php theme_field( 'address' );?>
								</div>
							</div>
							<div class="item">
								<span><?php theme_field( 'phone' );?></span>
								<?php theme_field( 'phone_desc' );?>
							</div>
							<div class="item">
								<span><?php theme_field( 'email' );?></span>
								<?php theme_field( 'email_desc' );?>
							</div>
						</div>
					</div>
					<footer class="footer">
						<div class="copy">
							<?php theme_field( 'copyright' );?>
						</div>						
						<nav class="bottom-menu">
							<a href="<?php the_permalink( 40 );?>">Карта сайта</a>
							<a class="politic-popup">Политика конфиденциальности</a>
						</nav>
						<div class="clear"></div>
					</footer>
				</div>
			</div>
		</div>
	</section>
</div>

<?php get_template_part( 'template-parts/content', 'modals' );?>

<?php wp_footer(); ?>
</body>
</html>