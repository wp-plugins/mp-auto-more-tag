<?php
/**
Plugin Name: MP Auto More tag
Plugin URI: http://webshop.mijnpress.nl/
Description: Auto sets the more tag to post title if no custom text has been set.
Version: 0.0.1
Author: Ramon Fincken
Author URI: http://www.mijnpress.nl
*/

add_filter( 'the_content_more_link', 'mp_auto_more_more_link');
function mp_auto_more_more_link($more, $more_link_text) {
	global $page, $pages;
	$post = get_post();

	if ( $page > count( $pages ) ) // if the requested page doesn't exist
		$page = count( $pages ); // give them the highest numbered page that DOES exist

	$content = $pages[$page - 1];

	if ( preg_match( '/<!--more(.*?)?-->/', $content, $matches ) ) {
		$content = explode( $matches[0], $content, 2 );
		if(isset($matches[1]) && strlen($matches[1]) > 1) {
			return $more;
		}
	}

	$more_link_text = __('Continue reading') .' '.get_the_title();
	return '<a href="' . get_permalink() . "#more-{$post->ID}\" class=\"more-link\" title=\"".$more_link_text."\">$more_link_text</a>";
}
?>
