<?php
/**
 * The Product Filter
 */
 
/**
 * [list_searcheable_acf list all the custom fields we want to include in our search query]
 * @return [array] [list of custom fields]
 */
function list_searcheable_acf(){
  $list_searcheable_acf = array('tastes');
  return $list_searcheable_acf;
}
/**
 * [advanced_custom_search search that encompasses ACF/advanced custom fields and taxonomies and split expression before request]
 * @param  [query-part/string]      $where    [the initial "where" part of the search query]
 * @param  [object]                 $wp_query []
 * @return [query-part/string]      $where    [the "where" part of the search query as we customized]
 * see https://vzurczak.wordpress.com/2013/06/15/extend-the-default-wordpress-search/
 * credits to Vincent Zurczak for the base query structure/spliting tags section
 */
function advanced_custom_search( $where, $wp_query ) {
	global $wpdb;
	
	$prefix = $wpdb->prefix;

	if ( empty( $where ))
		return $where;
 
	// get search expression
	$terms = $wp_query->query_vars[ 's' ];
	
	// explode search expression to get search terms
	$exploded = explode( ' ', $terms );
	if( $exploded === FALSE || count( $exploded ) == 0 )
		$exploded = array( 0 => $terms );
		 
	// reset search in order to rebuilt it as we whish
	$where = '';
	
	// get searcheable_acf, a list of advanced custom fields you want to search content in
	$list_searcheable_acf = list_searcheable_acf();
	foreach( $exploded as $tag ) :
		$where .= " 
		  AND (
			(wp_liquid_posts.post_title LIKE '%$tag%')
			OR (wp_liquid_posts.post_content LIKE '%$tag%')
			OR EXISTS (
			  SELECT * FROM wp_liquid_postmeta
				  WHERE post_id = wp_liquid_posts.ID
					AND (";
		foreach ($list_searcheable_acf as $searcheable_acf) :
		  if ($searcheable_acf == $list_searcheable_acf[0]):
			$where .= " (meta_key LIKE '%" . $searcheable_acf . "%' AND meta_value LIKE '%$tag%') ";
		  else :
			$where .= " OR (meta_key LIKE '%" . $searcheable_acf . "%' AND meta_value LIKE '%$tag%') ";
		  endif;
		endforeach;
			$where .= ")
			)
	
		)";
	endforeach;
	return $where;
	}
 
add_filter( 'posts_search', 'advanced_custom_search', 500, 2 );

function the_products_filter( $term_id = '' ) {

		// Get all $_GET values		
		if (isset($_GET['order'])){
			$order = $_GET['order'];
		} else {
			$order = 'ASC';
		}
		if (isset($_GET['orderby'])){
			$orderby = $_GET['orderby'];
		} else {
			$orderby = 'title';
		}
		if (isset($_GET['search'])){
			$s = $_GET['search'];
		} else {
			$s = '';
		}
		if (isset($_GET['posts_per_page'])){
			$posts_per_page = $_GET['posts_per_page'];
		} else {
			$posts_per_page = 6;
		}
		
	
		// Get Url
		function get_submit_url(){
			$url = getCurrentUrl();			
			return $url;
		}
		
		$order_active = 'class="active"';
	
	?>
	<div class="catalog-sort">
	
			<form id="filter_form" action="">
				<input type="search" placeholder="Поиск по вкусам" value="<?php echo get_search_query(); ?>" name="search">
				<input type="submit" value="">
				<input type="hidden" name="order" value="<?php echo $order;?>">
				<input type="hidden" name="orderby" value="<?php echo $orderby;?>">
				<input type="hidden" name="term" value="<?php echo $term_id;?>">
				<input type="hidden" name="posts_per_page" value="<?php echo $posts_per_page;?>">
			</form>
			<div class="links select-orderby">
				<a href="#" <?php if($orderby == 'title') echo $order_active;?> data-orderby="title" data-order="ASC">По алфавиту</a>
				<a href="#" <?php if(($orderby == 'price') && ($order == 'ASC')) echo $order_active;?> data-orderby="price" data-order="ASC">По возрастанию стоимости</a>
				<a href="#" <?php if(($orderby == 'price') && ($order == 'DESC')) echo $order_active;?> data-orderby="price" data-order="DESC">По убыванию стоимости</a>
				<select class="select-orderby-option">
					<option data-orderby="title" data-order="ASC" <?php if($orderby == 'title') echo 'selected';?>>По алфавиту</option>
					<option data-orderby="price" data-order="ASC" <?php if(($orderby == 'price') && ($order == 'ASC')) echo 'selected';?>>По возрастанию стоимости</option>
					<option data-orderby="price" data-order="DESC" <?php if(($orderby == 'price') && ($order == 'DESC')) echo 'selected';?>>По убыванию стоимости</option>
				</select>
			</div>
			<div class="clear"></div>
		</div>

<?php }