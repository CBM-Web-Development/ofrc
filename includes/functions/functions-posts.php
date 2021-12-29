<?php 


// Remove the Category:, Tag:, Author:, Archives:. and Other taxonomy name: from the archive title 
add_filter('get_the_archive_title', 'ofrc_archive_title');
function ofrc_archive_title($title){
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	}
  
	return $title;
}

// Update the elipsis 
add_filter('excerpt_more', 'ofrc_excerpt_more');
function ofrc_excerpt_more($more){
	global $post;
		
	return "...";
	
}


