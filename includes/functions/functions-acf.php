<?php 
if(function_exists('acf_add_options_page')){
	
	// Site options
	acf_add_options_page(array(
		'page_title'	=> 'Site Options', 
		'menu_title'	=> 'Site Options', 
		'menu_slug'		=> 'ofrc-site-options', 
		'capability'	=> 'edit_posts', 
		'redirect'		=> false, 
	) );
}