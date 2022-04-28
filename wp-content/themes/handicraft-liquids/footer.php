<?php
/**
 * The template for displaying the footer
 *
 * @package Handicraft Liquids
 * @subpackage Handicraft Liquids
 * @since Handicraft Liquids 1.0.0
 */
?>

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

<?php get_template_part( 'template-parts/content', 'modals' );?>

<?php wp_footer(); ?>
</body>
</html>