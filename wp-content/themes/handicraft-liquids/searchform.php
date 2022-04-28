<?php
/**
 * Template for displaying search forms
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" placeholder=" Поиск.." name="s" value="<?php echo get_search_query(); ?>"><input type="submit" value="">
</form>