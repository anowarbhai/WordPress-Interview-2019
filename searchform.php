<?php
/**
 * Search form template.
 *
 * @package WordPress
 * @subpackage CIT Theme Starterr
 * @since CIT Theme Starterr 1.0
 */

?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'cit' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'cit' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	</label>
	<button type="submit" class="search-submit"><span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'cit' ); ?></span></button>
</form>
